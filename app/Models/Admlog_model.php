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

    public function getAll()
    {
        $db      = \Config\Database::connect();
        $builder = $db->table($this->table);
        $builder->select(['adm_log.*', 'user.name as user_name']);
        $builder->join('user', 'adm_log.userID = user.userID', 'left');
        $builder->where('adm_log.timestamp >', date('Y-m-d'));
        return $builder->get()->getResultArray();
    }

    public function getController()
    {
        $db      = \Config\Database::connect();
        $builder = $db->table($this->table);
        $builder->select(['controller']);
        $builder->groupBy('controller');
        return $builder->get()->getResultArray();
    }

    public function getMethod($ctrl)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table($this->table);
        $builder->select(['method']);
        $builder->where(['controller' => $ctrl]);
        $builder->groupBy('method');
        return $builder->get()->getResultArray();
    }

    public function getByFilter($start, $finish, $controller, $method, $status)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table($this->table);
        $builder->select(['adm_log.*', 'user.name as user_name']);
        $builder->join('user', 'adm_log.userID = user.userID', 'left');
        $builder->where('adm_log.timestamp >=', $start);
        $builder->where('adm_log.timestamp <=', $finish);
        if ($controller != 'all') {
            $builder->where('adm_log.controller', $controller);
        }
        if ($method != 'all') {
            $builder->where('adm_log.method', $method);
        }
        if ($status != 'all') {
            $builder->where('adm_log.status', $status);
        }
        return $builder->get()->getResultArray();
    }
}
