<?php

namespace App\Models;

use CodeIgniter\Model;

class Article extends Model
{
    protected $DBGroup = 'default';
    protected $table = 'articles';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'title',
        'slug',
        'user_id',
        'content',
        "estimated_reading_time",
        'publication_date',
        'category',
        "thumbnail"
    ];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    // Validation
    protected $validationRules = [];
    protected $validationMessages = [];
    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert = [];
    protected $afterInsert = [];
    protected $beforeUpdate = [];
    protected $afterUpdate = [];
    protected $beforeFind = [];
    protected $afterFind = [];
    protected $beforeDelete = [];
    protected $afterDelete = [];


    public function getUser($id = false)
    {

        $this->select('u.id ,u.username, u.email');
        $this->join('users as u', 'u.id = articles.user_id');
        return $this->getWhere(['articles.id' => $id])->getRowArray();

    }

    public function searchArticles($title = '', $user_id = '', $category = '')
    {
        $builder = $this->table($this->table);

        if (!empty($title)) {
            $builder->like('title', $title);
        }

        if (!empty($user_id)) {
            $builder->where('user_id', $user_id);
        }

        if (!empty($category)) {
            $builder->like('category', $category);
        }

        return $builder->get()->getResult();
    }

}
