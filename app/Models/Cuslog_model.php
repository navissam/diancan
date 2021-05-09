<?php

namespace App\Models;

use CodeIgniter\Model;

class Cuslog_model extends Model
{
    protected $table      = 'cus_log';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['controller', 'method', 'data', 'empID', 'status', 'response'];

    protected $useTimestamps = false;
    protected $createdField  = '';
    protected $updatedField  = '';
    protected $deletedField  = '';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function getLastLogin($empID)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table($this->table);
        $builder->select(['timestamp']);
        $builder->where(['empID' => $empID, 'method' => 'login', 'status' => 1]);
        $builder->orderBy('timestamp', 'DESC');
        $result = $builder->get()->getFirstRow('array');
        return $result == null ? $result : $result['timestamp'];
    }
    public function getLastLogout($empID)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table($this->table);
        $builder->select(['timestamp']);
        $builder->where(['empID' => $empID, 'method' => 'logout', 'status' => 1]);
        $builder->orderBy('timestamp', 'DESC');
        $result = $builder->get()->getFirstRow('array');
        return $result == null ? $result : $result['timestamp'];
    }
}
