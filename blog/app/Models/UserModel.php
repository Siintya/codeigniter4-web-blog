<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * @method User|null first()
 */
class UserModel extends Model
{
    protected $table                = 'users';
    protected $primaryKey           = 'id';
    protected $returnType           = 'array';
    protected $useSoftDeletes       = false;
    protected $allowedFields        = [
        'id', 
        'email', 
        'username', 
        'password', 
        'users_roles_id', 
        'fullname', 
        'status',
        'religion', 
        'gender', 
        'no_telp', 
        'address', 
        'token', 
        'created_at', 
        'updated_at'
    ];
    protected $useTimestamps        = false;
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $afterInsert          = [];

    protected $articleModel;
    protected $pageModel;

    public function __construct()
    {
        $this->articleModel = new ArticleModel();
        $this->pageModel    = new PageModel();
    }

    public function getAll()
    {
        $query   = $this->join('users_roles', 'users_roles.id = users.users_roles_id')
                        ->select([
                            'users.id AS id', 
                            'users.username AS username', 
                            'users.status  AS status', 
                            'users_roles.name AS role', 
                            'users.created_at AS created_at', 
                            'users.updated_at AS updated_at'
                        ])
                        ->get();
        return $query->getResultArray();
    }
    
    public function getData($data)
    {
        $query = $this->where('username', $data)
                      ->get();

        return $query->getRowArray();
    }

    public function getOnlineUsers()
    {
        $query = $this->where('status', 'online')
                      ->limit(5)
                      ->get();

        return $query->getResultArray();
    }

    public function getTotalUsers()
    {
        return $this->countAllResults();
    }

    public function getLatestUsers()
    {
        $query = $this->join('users_roles', 'users_roles.id = users.users_roles_id')
                    ->select([
                        'users.id as id',
                        'users.username as username',
                        'users.email as email',
                        'users.status as status',
                        'users.created_at as created_at',
                        'users.updated_at as updated_at',
                        'users_roles.name as roles'
                    ])
                    ->orderBy('created_at', 'DESC')
                    ->limit(10)
                    ->get();

        return $query->getResultArray();
    }

    public function getById($data)
    {
        $query = $this->join('users_roles', 'users_roles.id = users.users_roles_id')
                      ->select([
                            'users.id as id',
                            'users.users_roles_id as users_roles_id',
                            'users.status as status',
                            'users.username as username',
                            'users.email as email',
                            'users.fullname as fullname',
                            'users.no_telp as no_telp',
                            'users.religion as religion',
                            'users.gender as gender',
                            'users.address as address',
                            'users.image as image',
                            'users.created_at as created_at',
                            'users.updated_at as updated_at',
                            'users_roles.name as role'
                      ])
                      ->where('users.id', $data)
                      ->get();

        return $query->getRowArray();
    }
    public function getRelated($data)
    {
        $articles = new ArticleModel();
        $articles->where('users_id', $data);
        $articlesData = $articles->findAll();

        $pages    = new PageModel();
        $pages->where('users_id', $data);
        $pagesData = $pages->findAll();
    
        return [
            'articles'  => $articlesData,
            'pages'     => $pagesData,
        ];
    }
    
    public function getRoles()
    {
        $userRoles = $this->roles;
        $roleNames = [];
        if (is_array($userRoles)) {
            foreach ($userRoles as $userRole) {
                $roleModel = new UserRoleModel();
                $role = $roleModel->find($userRole['users_roles_id']);
                if ($role) {
                    $roleNames[] = $role['name'];
                }
            }
        }
        return $roleNames;
    }
    

    public function create($data): bool
    {
        return parent::insert($data);
    }

    public function updated($id, $data)
    {
        return $this->db->table($this->table)
                        ->where(["id" => $id])
                        ->set($data)
                        ->update();
    }

    public function updatedStatus($userId, $status)
    {
        return $this->update($userId, ['status' => $status]);
    }

    public function deleted($id)
    {
        // articles
        $articles = $this->articleModel->getByUser($id);
        if ($articles > 0) {
            $this->articleModel->where('users_id', $id)->delete();
        }

        // pages
        $pages = $this->pageModel->getByUser($id);
        if  ($pages > 0) {
            $this->pageModel->where('users_id', $id)->delete();
        }

        return $this->where('id', $id)->delete();
    }
    
}