<?php

namespace App\Models;

use CodeIgniter\Model;

class EmpMeta_model extends Model
{
    protected $table      = 'empMeta';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = [];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function check($empID, $name)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table($this->table);
        $builder->where('name', $name);
        $builder->where('empID', $empID);
        return count($builder->get()->getResult('array')) > 0;
    }
}
