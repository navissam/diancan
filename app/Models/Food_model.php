<?php

namespace App\Models;

use CodeIgniter\Database\MySQLi\Builder;
use CodeIgniter\Model;

class Food_model extends Model
{
    protected $table      = 'food';
    protected $primaryKey = 'foodID';

    protected $useAutoIncrement = false;

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['foodID', 'name', 'nameIND', 'price', 'type', 'qty', 'photoURL'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function restore($id)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table($this->table);
        $builder->where($this->primaryKey, $id);
        $builder->update(['deleted_at' => null]);
        return $builder;
    }
    public function getFoodRow($type = 'special')
    {
        $db = \Config\Database::connect();
        $sub = $db->table('orderdetail');
        $sub->select(['`orderdetail`.`foodID`', 'SUM(`orderdetail`.`qty`) AS `sum_qty`']);
        $sub->join('orders', '`orders`.`ordID` = `orderdetail`.`ordID`', 'inner');
        $sub->where([
            'DATE_FORMAT(orders.created_at, "%Y-%m-%d")' => date('Y-m-d')
        ]);
        $sub->groupBy('`orderdetail`.`foodID`');
        $subQuery = '(' . $sub->getCompiledSelect() . ') AS SUMM';

        $builder = $db->table($this->table);
        if ($type == 'special') {
            $builder->select(['food.*', 'IFNULL(SUMM.sum_qty,0) as ordered_qty']);
            $builder->join($subQuery, '`SUMM`.`foodID` = `food`.`foodID`', 'left');
            $builder->where([
                'food.type' => 'special'
            ]);
        } else {
            $builder->where(
                [
                    'type' => $type,
                    'deleted_at' => null
                ]
            );
        }
        // dd($builder->getCompiledSelect());
        return $builder->get()->getResultArray();
    }
}
