<?php

namespace App\Models;

use CodeIgniter\Model;

class User_model extends Model
{
    protected $table      = 'user';
    protected $primaryKey = 'userID';

    protected $useAutoIncrement = false;

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['userID', 'name', 'password', 'roleID', 'status'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function getRoles()
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('role');
        $builder->where('roleID <>', 'super');
        return $builder->get()->getResult('array');
    }
}
