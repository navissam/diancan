<?php

namespace App\Models;

use CodeIgniter\Model;

class Admlog_model extends Model
{
    protected $table      = 'adm_log';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['controller', 'method', 'data', 'userID', 'ip', 'status', 'response'];

    protected $useTimestamps = false;
    protected $createdField  = '';
    protected $updatedField  = '';
    protected $deletedField  = '';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function getLastLogin($userID)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table($this->table);
        $builder->select(['timestamp']);
        $builder->where(['userID' => $userID, 'method' => 'login', 'status' => 1]);
        $builder->orderBy('timestamp', 'DESC');
        $result = $builder->get()->getFirstRow('array');
        return $result == null ? $result : $result['timestamp'];
    }
    public function getLastLogout($userID)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table($this->table);
        $builder->select(['timestamp']);
        $builder->where(['userID' => $userID, 'method' => 'logout', 'status' => 1]);
        $builder->orderBy('timestamp', 'DESC');
        $result = $builder->get()->getFirstRow('array');
        return $result == null ? $result : $result['timestamp'];
    }
}
