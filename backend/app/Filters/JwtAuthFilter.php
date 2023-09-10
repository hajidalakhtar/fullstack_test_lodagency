<?php

namespace App\Filters;

use CodeIgniter\Config\Services;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Firebase\JWT\ExpiredException;

class JwtAuthFilter implements FilterInterface
{

    public function __construct()
    {
        helper('jwt');
    }
    /**
     * Do whatever processing this filter needs to do.
     * By default it should not return anything during
     * normal execution. However, when an abnormal state
     * is found, it should return an instance of
     * CodeIgniter\HTTP\Response. If it does, script
     * execution will end and that Response will be
     * sent back to the client, allowing for error pages,
     * redirects, etc.
     *
     * @param RequestInterface $request
     * @param array|null $arguments
     *
     * @return mixed
     */
    public function before(RequestInterface $request, $arguments = null): mixed
    {
        $authHeader = $request->getServer('HTTP_AUTHORIZATION');

        if ($authHeader) {
            $token = get_bearer_token($authHeader);
            try {
                $decoded = decode_jwt($token);
                $request->userID = $decoded;
                return $request;
            } catch (ExpiredException $e) {
                return Services::response()
                    ->setJSON(['message' => 'Provided token is expired.'])
                    ->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED);
            } catch (\Exception $e) {
                return Services::response()
                    ->setJSON(['message' => 'An error while decoding token.'])
                    ->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED);
            }
        }

        return Services::response()
            ->setJSON(['message' => 'Token not provided.'])
            ->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED);
    }




    /**
     * Allows After filters to inspect and modify the response
     * object as needed. This method does not allow any way
     * to stop execution of other after filters, short of
     * throwing an Exception or Error.
     *
     * @param RequestInterface $request
     * @param ResponseInterface $response
     * @param array|null $arguments
     *
     * @return mixed
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null): mixed
    {
        if (!empty($authHeader)) {
            if (preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
                return $matches[1];
            }
        }

        return null;
    }
}
