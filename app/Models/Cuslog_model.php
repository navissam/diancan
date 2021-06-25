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

    public function getAll()
    {
        $db      = \Config\Database::connect();
        $builder = $db->table($this->table);
        $builder->select(['cus_log.*', 'customer.name as cus_name']);
        $builder->join('customer', 'cus_log.empID = customer.empID', 'left');
        $builder->where('cus_log.timestamp >', date('Y-m-d'));
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
        $builder->select(['cus_log.*', 'customer.name as cus_name']);
        $builder->join('customer', 'cus_log.empID = customer.empID', 'left');
        $builder->where('cus_log.timestamp >=', $start);
        $builder->where('cus_log.timestamp <=', $finish);
        if ($controller != 'all') {
            $builder->where('cus_log.controller', $controller);
        }
        if ($method != 'all') {
            $builder->where('cus_log.method', $method);
        }
        if ($status != 'all') {
            $builder->where('cus_log.status', $status);
        }
        return $builder->get()->getResultArray();
    }
}
