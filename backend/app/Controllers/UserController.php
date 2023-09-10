<?php

namespace App\Controllers;

use App\Models\User;
use CodeIgniter\Controller;
use CodeIgniter\HTTP\ResponseInterface;

class UserController extends Controller
{

    public function __construct()
    {

        helper('jwt');

    }

    public function login(): ResponseInterface
    {
        $user = new User();
        $username = $this->request->getVar('username');
        $password = $this->request->getVar('password');
        $user = $user->where('username', $username)->first();

        if ($user) {
            if (password_verify($password, $user['password'])) {
                $jwt = encode_jwt($user['id']);
                $user["token"] = $jwt;

                unset($user['password']);

                return $this->response->setJSON([
                    "status" => 200,
                    "message" => "Login berhasil. Selamat datang, Hajid Al Akhtar!",
                    "data" => $user
                ]);
            }
        }

        return $this->response->setStatusCode(401)->setJSON([
            "status" => 401,
            "message" => "Login Gagal",
            "data" => []
        ]);

    }

    public function register(): ResponseInterface
    {
        $model = new User();
        $data = [
            'username' => $this->request->getVar('username'),
            'fullname' => $this->request->getVar('fullname'),
            'password' => password_hash($this->request->getVar('password'), PASSWORD_DEFAULT),
            'email' => $this->request->getVar('email')
        ];
        $model->insert($data);
        $data["id"] = $model->insert($data);
        $jwt = encode_jwt($data['id']);
        $data["token"] = $jwt;

        return $this->response->setJSON([
            'status' => 200,
            'message' => 'Registrasi berhasil',
            "data" => $data
        ]);
    }

    public function userInfo(): ResponseInterface
    {
        $authHeader = $this->request->getServer('HTTP_AUTHORIZATION');

        if (!empty($authHeader)) {
            $token = get_bearer_token($authHeader);
        }

        if (empty($authHeader)) {
            return $this->response->setStatusCode(401)->setJSON([
                "status" => 401,
                "message" => "Akses ditolak",
                "data" => []
            ]);
        }

        try {
            $decoded = decode_jwt($token);
            $userId = $decoded->user_id;
            $user = new User();
            $user = $user->find($userId);
            unset($user['password']);
            return $this->response->setJSON([
                "status" => 200,
                "message" => "Berhasil mendapatkan informasi pengguna",
                "data" => $user
            ]);
        } catch (\Exception $e) {
            return $this->response->setStatusCode(401)->setJSON([
                "status" => 401,
                "message" => "Token tidak valid",
                "data" => []
            ]);
        }
    }
}
