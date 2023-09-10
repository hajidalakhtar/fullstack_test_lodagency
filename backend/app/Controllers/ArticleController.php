<?php

namespace App\Controllers;

use App\Models\Article;
use CodeIgniter\HTTP\ResponseInterface;

class ArticleController extends BaseController
{

    public function __construct()
    {

        helper('jwt');

    }

    public function index(): ResponseInterface
    {
        $model = new Article();
        $articles = $model->findAll();
        foreach ($articles as $key => $article) {
            $articles[$key]["author"] = $model->getUser($article["id"]);
        }

        return $this->response->setJSON([
            'status' => 200,
            'message' => 'Berhasil mendapatkan daftar artikel',
            'data' => $articles
        ]);
    }

    public function show(string $id): ResponseInterface
    {
        $model = new Article();
        $article = $model->find($id);

        if ($article == null) {
            return $this->response->setStatusCode(404)->setJSON([
                'status' => 404,
                'message' => 'Artikel tidak ditemukan',
                'data' => []
            ]);
        }

        $article["author"] = $model->getUser($id);

        return $this->response->setJSON([
            'status' => 200,
            'message' => 'Berhasil mendapatkan detail artikel',
            'data' => $article
        ]);
    }

    public function create(): ResponseInterface
    {
        $validationRules = [
            'title' => 'required',
            'slug' => 'required',
            'content' => 'required',
            'publication_date' => 'required',
            'category' => 'required'
        ];

        if (!$this->validate($validationRules)) {
            return $this->response->setStatusCode(400)->setJSON([
                'status' => 400,
                'message' => 'Terjadi kesalahan validasi',
                'errors' => $this->validator->getErrors()
            ]);
        }


        $authHeader = $this->request->getServer('HTTP_AUTHORIZATION');
        $token = get_bearer_token($authHeader);
        $user = decode_jwt($token);

        $model = new Article();
        $content = $this->request->getVar('content');
        $estimatedReadingTime = $this->estimatedReadingTime($content);


        $articleData = [
            'title' => $this->request->getVar('title'),
            'slug' => $this->request->getVar('slug'),
            "estimated_reading_time" => $estimatedReadingTime,
            'user_id' => $user->user_id,
            'content' => $content,
            'publication_date' => $this->request->getVar('publication_date'),
            'category' => $this->request->getVar('category')
        ];

        $articleData["id"] = $model->insert($articleData);

        return $this->response->setJSON([
            'status' => 200,
            'message' => 'Artikel berhasil dibuat',
            'data' => $articleData
        ]);

    }

    public function update(string $id): ResponseInterface
    {
        $validationRules = [
            'title' => 'required',
            'slug' => 'required',
            'content' => 'required',
            'publication_date' => 'required',
            'category' => 'required'
        ];

        if (!$this->validate($validationRules)) {
            return $this->response->setStatusCode(400)->setJSON([
                'status' => 400,
                'message' => 'Terjadi kesalahan validasi',
                'errors' => $this->validator->getErrors()
            ]);
        }

        $model = new Article();
        $content = $this->request->getVar('content');
        $estimatedReadingTime = $this->estimatedReadingTime($content);


        $authHeader = $this->request->getServer('HTTP_AUTHORIZATION');
        $token = get_bearer_token($authHeader);
        $user = decode_jwt($token);



        $articleData = [
            'title' => $this->request->getVar('title'),
            'slug' => $this->request->getVar('slug'),
            "estimated_reading_time" => $estimatedReadingTime,
            'user_id' => $user->user_id,
            'content' => $content,
            'publication_date' => $this->request->getVar('publication_date'),
            'category' => $this->request->getVar('category')
        ];

        $model->update($id, $articleData);
        return $this->response->setJSON([
            'status' => 200,
            'message' => 'Artikel berhasil diperbarui',
            'data' => []
        ]);
    }

    public function delete(string $id): ResponseInterface
    {
        $model = new Article();
        $article = $model->find($id);
        if ($article == null) {
            return $this->response->setStatusCode(404)->setJSON([
                'status' => 404,
                'message' => 'Artikel tidak ditemukan',
                'data' => []
            ]);
        }
        $model->delete($id);
        return $this->response->setJSON([
            'status' => 200,
            'message' => 'Artikel berhasil dihapus',
            'data' => []
        ]);
    }

    public function search(): ResponseInterface
    {
        $title = $this->request->getGet('title');
        $user_id = $this->request->getGet('user_id');
        $category = $this->request->getGet('category');

        $model = new Article();
        $articles = $model->searchArticles($title, $user_id, $category);
        return $this->response->setJSON($articles);
    }

    private function estimatedReadingTime($content): int
    {
        $wordCount = str_word_count($content);
        $averageReadingSpeed = 3.3; //detik
        $estimatedReadingTime = ceil($wordCount / $averageReadingSpeed);
        return $estimatedReadingTime;
    }

}
