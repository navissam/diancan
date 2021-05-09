<?php

namespace App\Models;

use CodeIgniter\Model;

class Customer_model extends Model
{
    protected $table      = 'customer';
    protected $primaryKey = 'cusID';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['name', 'empID', 'roomNum', 'phoneNum', 'password', 'region', 'status'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function search($key)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table($this->table);
        $builder->like('name', $key);
        $builder->orLike('empID', $key);
        return $builder->get()->getResult('array');
    }
}
