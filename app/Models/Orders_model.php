<?php

namespace App\Models;

use CodeIgniter\Model;

class Orders_model extends Model
{
    protected $table      = 'orders';
    protected $primaryKey = 'ordID';

    protected $useAutoIncrement = false;

    protected $returnType     = 'array';
    protected $useSoftDeletes = true;

    protected $allowedFields = ['ordID', 'cusID', 'name', 'empID', 'roomNum', 'phoneNum', 'deliverySta', 'deliveryCost', 'paymentSta', 'region'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    public function insertDetail($data)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('orderdetail');
        $builder->insertBatch($data);
        return $builder;
    }
    public function getDetail($ordID)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('orderdetail');
        $builder->select(['orderdetail.*', 'food.type', '(orderdetail.qty * orderdetail.price) as product']);
        // $builder->join('food', 'food.foodID = orderdetail.foodID', 'left');
        $builder->join('food', 'food.foodID = orderdetail.foodID', 'left');
        $builder->where(['ordID' => $ordID]);
        // return ($builder->getCompiledSelect());
        return $builder->get()->getResultArray();
    }

    public function getPrevOrders($cusID = null, $json)
    {
        // ---------find same order detail, only identic
        $db      = \Config\Database::connect();
        $sub = $db->table('orders');
        $sub->select('orders.ordID, orders.created_at');
        $sub->join('orderdetail', 'orderdetail.ordID = orders.ordID', 'inner');
        $sub->where([
            'orders.cusID' => $cusID,
            'orders.created_at >=' => date('Y-m-d'),
        ]);
        $sub->where('orders.deleted_at is null');
        $sub->groupBy('orders.ordID');
        $sub->having('count(distinct orderdetail.foodID)', count($json));
        $sub_qry = $sub->getCompiledSelect();

        $builder = $db->table('(' . $sub_qry . ') as tt');
        $builder->select('tt.ordID, tt.created_at, CONCAT(orderdetail.foodID,\'-\',orderdetail.qty) AS concat');
        $builder->join('orderdetail', 'tt.ordID = orderdetail.ordID', 'inner');
        $builder->orderBy('tt.ordID', 'asc');
        $builder->orderBy('concat', 'asc');
        $sub_qry = $builder->getCompiledSelect();

        $builder = $db->table('(' . $sub_qry . ') as ttt');
        $builder->select('ttt.ordID, ttt.created_at as max_date');
        $arr = [];
        foreach ($json as $row) {
            array_push($arr, $row['foodID'] . '-' . $row['qty']);
        }
        asort($arr);
        // dd($arr);
        $concat =   implode(",", $arr);
        $builder->having('group_concat(DISTINCT `ttt`.`concat` ORDER BY `ttt`.`concat` ASC separator \',\')', $concat);
        $builder->groupBy('ttt.ordID');
        $builder->orderBy('max_date', 'desc');

        // ---------find same order detail, but not identic
        // $builder = $db->table('orders');
        // $builder->select('orders.ordID, MAX(orders.created_at) AS max_date');
        // $builder->join('orderdetail', 'orders.ordID = orderdetail.ordID', 'inner');
        // $builder->where([
        //     'orders.cusID' => $cusID,
        //     'orders.created_at >=' => date('Y-m-d'),
        // ]);
        // $builder->where('orders.deleted_at is null');
        // $builder->whereIn('orderdetail.foodID', $foodIDs);
        // $builder->whereIn('orderdetail.qty', $qtys);
        // $builder->groupBy('orders.ordID');
        // $builder->having('count(distinct orderdetail.foodID)', count($foodIDs));
        // $builder->orderBy('max_date', 'desc');

        // dd($builder->getCompiledSelect());
        return $builder->get()->getFirstRow('array');
    }


    public function getBySerial($serial)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table($this->table);
        $builder->where('serialNum', $serial);
        $builder->where('created_at >', date('Y-m-d'));
        $builder->where('orders.deleted_at IS NULL');
        return $builder->get()->getFirstRow('array');
    }
    public function getUnpayOrders($empID)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table($this->table);
        $builder->where('empID', $empID);
        $builder->where('paymentSta', 0);
        $builder->where('created_at >', date('Y-m-d'));
        $builder->where('orders.deleted_at IS NULL');
        return $builder->get()->getResultArray();
    }

    public function getPayedOrdersByFood()
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('orderdetail');
        $builder->select(['foodID', 'foodName', 'sum(qty) As qtySum']);
        $builder->join('orders', 'orders.ordID = orderdetail.ordID');
        $builder->where('paymentSta', 1);
        $builder->where('created_at >', date('Y-m-d'));
        $builder->groupBy('foodID');
        return $builder->get()->getResultArray();
    }

    public function getPayedOrdersBy($foodID)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('orders');
        $builder->select(['orders.ordID', 'name', 'empID', 'if(deliverySta=0,"不外送 Tidak Antar","外送 Antar") As dSta', 'orderdetail.qty']);
        $builder->join('orderdetail', 'orders.ordID = orderdetail.ordID');
        $builder->where('paymentSta', 1);
        $builder->where('created_at >', date('Y-m-d'));
        $builder->where('foodID', $foodID);
        return $builder->get()->getResultArray();
    }
    public function getTodayOrders($region)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('orders');
        // $builder->where('created_at >', '2021-03-20');
        $builder->where('created_at >', date('Y-m-d'));
        $builder->where('region', $region);
        $builder->where('deleted_at IS NULL');
        $builder->orderBy('serialNum', 'ASC');
        return $builder->get()->getResultArray();
    }
    public function getTodayDetails($region)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('orderdetail');
        $builder->select('orderdetail.*');
        $builder->join('orders', 'orders.ordID = orderdetail.ordID');
        $builder->where('orders.region', $region);
        // $builder->where('orders.created_at >', '2021-03-20');
        $builder->where('orders.created_at >', date('Y-m-d'));
        return $builder->get()->getResultArray();
    }

    public function getDetailsByCus($cusID)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('orderdetail');
        $builder->select('orderdetail.*');
        $builder->join('orders', 'orders.ordID = orderdetail.ordID');
        $builder->where('orders.created_at >', date('Y-m-d'));
        $builder->where('orders.cusID', $cusID);
        return $builder->get()->getResultArray();
    }

    public function getOrdersByCus($cusID)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('orders');
        $builder->where('orders.created_at >', date('Y-m-d'));
        $builder->where('orders.cusID', $cusID);
        $builder->where('orders.deleted_at IS NULL');
        $builder->orderBy('created_at', 'DESC');
        return $builder->get()->getResultArray();
    }

    public function getHistoryDates($cusID)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('orders');
        $builder->select('distinct DATE_FORMAT(created_at,\'%Y-%m-%d\') as date');
        $builder->where('orders.cusID', $cusID);
        $builder->where('orders.paymentSta', 1);
        $builder->where('orders.deleted_at IS NULL');
        $builder->orderBy('created_at', 'DESC');
        return $builder->get()->getResultArray();
    }
    public function getHistoryOrders($cusID)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('orders');
        $builder->where('orders.cusID', $cusID);
        $builder->where('orders.paymentSta', 1);
        $builder->where('orders.deleted_at IS NULL');
        $builder->orderBy('created_at', 'DESC');
        return $builder->get()->getResultArray();
    }

    public function getHistoryDetails($cusID)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('orderdetail');
        $builder->select('orderdetail.*');
        $builder->join('orders', 'orders.ordID = orderdetail.ordID');
        $builder->where('orders.cusID', $cusID);
        $builder->where('orders.paymentSta', 1);
        $builder->orderBy('created_at', 'DESC');
        return $builder->get()->getResultArray();
    }

    public function getOrderQty($cusID)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('orders');
        $builder->where('orders.created_at >', date('Y-m-d'));
        $builder->where('orders.cusID', $cusID);
        $builder->where('orders.deleted_at IS NULL');
        return $builder->countAllResults();
    }

    public function deleteDetails($ordID)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('orderdetail');
        $builder->where('ordID', $ordID);
        return $builder->delete();
    }

    public function getOrdersHistoryByOrder($date, $region)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('orders');
        $builder->select('orders.*, sum(orderdetail.price * orderdetail.qty) as total');
        $builder->join('orderdetail', 'orders.ordID = orderdetail.ordID', 'left');
        $builder->where('DATE_FORMAT(orders.created_at, "%Y-%m-%d")', $date);
        if ($region != 'all') {
            $builder->where('orders.region', $region);
        }
        $builder->where('orders.paymentSta', 1);
        $builder->where('orders.deleted_at IS NULL');
        $builder->groupBy('orders.ordID');
        $builder->orderBy('created_at', 'ASC');
        // dd($builder->getCompiledSelect());
        return $builder->get()->getResultArray();
    }
    public function getOrdersHistoryByFood($date, $region)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('orderdetail');
        $builder->select('foodID, foodName, price, sum(qty) as sum_qty, (price * sum(qty)) as product, region');
        $builder->join('orders', 'orders.ordID = orderdetail.ordID', 'left');
        $builder->where('DATE_FORMAT(orders.created_at, "%Y-%m-%d")', $date);
        if ($region != 'all') {
            $builder->where('orders.region', $region);
        }
        $builder->where('orders.paymentSta', 1);
        $builder->where('orders.deleted_at IS NULL');
        $builder->groupBy(['foodID']);
        $builder->orderBy('foodID', 'ASC');
        return $builder->get()->getResultArray();
    }

    //new---------------------------------------------------------------
    // FOR Report Controller
    public function getIncome($begin, $end, $type, $region)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('orderdetail');
        $builder->select('orderdetail.foodID, concat(food.name, \' \', food.nameIND) as foodName, orderdetail.price, sum(orderdetail.qty) as sum_qty, (orderdetail.price * sum(orderdetail.qty)) as product');
        $builder->join('orders', 'orders.ordID = orderdetail.ordID', 'inner');
        $builder->join('food', 'food.foodID = orderdetail.foodID', 'left');
        $builder->where('DATE_FORMAT(orders.created_at, "%Y-%m-%d") >=', $begin);
        $builder->where('DATE_FORMAT(orders.created_at, "%Y-%m-%d") <=', $end);
        if ($region != 'all') {
            $builder->where('orders.region', $region);
        }
        if ($type != 'all') {
            $builder->where('food.type', $type);
        }
        $builder->where('orders.paymentSta', 1);
        $builder->where('orders.deleted_at IS NULL');
        $builder->groupBy(['orderdetail.foodID', 'orderdetail.price']);
        $builder->orderBy('sum_qty', 'DESC');
        return $builder->get()->getResultArray();
    }


    public function expIncome($begin, $end, $type, $region)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('orderdetail');
        $builder->select('orderdetail.foodID, foodName, orderdetail.price, sum(orderdetail.qty) as sum_qty, (orderdetail.price * sum(orderdetail.qty)) as product');
        $builder->join('orders', 'orders.ordID = orderdetail.ordID', 'inner');
        $builder->join('food', 'food.foodID = orderdetail.foodID', 'left');
        $builder->where('DATE_FORMAT(orders.created_at, "%Y-%m-%d") >=', $begin);
        $builder->where('DATE_FORMAT(orders.created_at, "%Y-%m-%d") <=', $end);
        if ($region != 'all') {
            $builder->where('orders.region', $region);
        }
        if ($type != 'all') {
            $builder->where('food.type', $type);
        }
        $builder->where('orders.paymentSta', 1);
        $builder->where('orders.deleted_at IS NULL');
        $builder->groupBy(['orderdetail.foodID', 'orderdetail.price']);
        $builder->orderBy('sum_qty', 'DESC');
        return $builder->get()->getResultArray();
    }
    public function getDelivery($begin, $end, $region)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('orders');
        $builder->select('count(orders.ordID) as dCount, sum(orders.deliveryCost) as dSum');
        $builder->where('DATE_FORMAT(orders.created_at, "%Y-%m-%d") >=', $begin);
        $builder->where('DATE_FORMAT(orders.created_at, "%Y-%m-%d") <=', $end);
        if ($region != 'all') {
            $builder->where('orders.region', $region);
        }
        $builder->where('orders.paymentSta', 1);
        $builder->where('orders.deliverySta', 1);
        $builder->where('orders.deleted_at IS NULL');
        return $builder->get()->getResultArray();
    }

    // FOR Orders Controller
    public function getHistoryByOrder($begin, $end, $deliverySta, $paymentSta, $region)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('orders');
        $builder->select('orders.*, (sum(orderdetail.price * orderdetail.qty) + orders.deliveryCost) as amount');
        $builder->join('orderdetail', 'orderdetail.ordID = orders.ordID', 'inner');
        $builder->where('DATE_FORMAT(orders.created_at, "%Y-%m-%d") >=', $begin);
        $builder->where('DATE_FORMAT(orders.created_at, "%Y-%m-%d") <=', $end);

        if ($paymentSta != 'all') {
            $builder->where('orders.paymentSta', $paymentSta);
        }
        if ($deliverySta != 'all') {
            $builder->where('orders.deliverySta', $deliverySta);
        }
        if ($region != 'all') {
            $builder->where('orders.region', $region);
        }
        $builder->where('orders.deleted_at IS NULL');
        $builder->groupBy('orders.ordID');
        $builder->orderBy('orders.created_at', 'DESC');
        // dd($builder->getCompiledSelect());
        return $builder->get()->getResultArray();
    }
    public function getHistoryByCus($begin, $end, $deliverySta, $paymentSta, $region)
    {
        $db      = \Config\Database::connect();

        $sub = $db->table('orders');
        $sub->select('orders.*, (sum(orderdetail.price * orderdetail.qty) + orders.deliveryCost) as amount');
        $sub->join('orderdetail', 'orderdetail.ordID = orders.ordID', 'inner');
        $sub->where('DATE_FORMAT(orders.created_at, "%Y-%m-%d") >=', $begin);
        $sub->where('DATE_FORMAT(orders.created_at, "%Y-%m-%d") <=', $end);
        $sub->where('orders.deleted_at IS NULL');

        if ($paymentSta != 'all') {
            $sub->where('orders.paymentSta', $paymentSta);
        }
        if ($deliverySta != 'all') {
            $sub->where('orders.deliverySta', $deliverySta);
        }
        if ($region != 'all') {
            $sub->where('orders.region', $region);
        }
        $sub->where('orders.deleted_at IS NULL');
        $sub->groupBy('orders.ordID');
        $sub->orderBy('orders.created_at', 'DESC');
        $sub_qry = $sub->getCompiledSelect();

        $builder = $db->table('(' . $sub_qry . ') as summ');
        $builder->select('cusID, name, empID, sum(amount) as amount');
        $builder->groupBy('summ.cusID');

        // dd($builder->getCompiledSelect());
        return $builder->get()->getResultArray();
    }
    public function getHistoryByFood($begin, $end, $type, $deliverySta, $paymentSta, $region)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('orderdetail');
        $builder->select('orderdetail.foodID, concat(food.name, \' \', food.nameIND) as foodName, orderdetail.price, food.type, sum(orderdetail.qty) as sum_qty, (orderdetail.price * sum(orderdetail.qty)) as product');
        $builder->join('orders', 'orders.ordID = orderdetail.ordID', 'inner');
        $builder->join('food', 'food.foodID = orderdetail.foodID', 'left');
        $builder->where('DATE_FORMAT(orders.created_at, "%Y-%m-%d") >=', $begin);
        $builder->where('DATE_FORMAT(orders.created_at, "%Y-%m-%d") <=', $end);
        $builder->where('orders.deleted_at IS NULL');

        if ($region != 'all') {
            $builder->where('orders.region', $region);
        }
        if ($type != 'all') {
            $builder->where('food.type', $type);
        }
        if ($paymentSta != 'all') {
            $builder->where('orders.paymentSta', $paymentSta);
        }
        if ($deliverySta != 'all') {
            $builder->where('orders.deliverySta', $deliverySta);
        }
        $builder->where('orders.deleted_at IS NULL');
        $builder->groupBy(['orderdetail.foodID', 'orderdetail.price']);
        $builder->orderBy('sum_qty', 'DESC');
        return $builder->get()->getResultArray();
    }
    public function getOrderPivot($begin, $end, $type, $deliverySta, $paymentSta, $region)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('orderdetail');
        $builder->select('orderdetail.foodID');
        $builder->join('orders', 'orders.ordID = orderdetail.ordID', 'inner');
        $builder->join('food', 'food.foodID = orderdetail.foodID', 'left');
        $builder->where('DATE_FORMAT(orders.created_at, "%Y-%m-%d") >=', $begin);
        $builder->where('DATE_FORMAT(orders.created_at, "%Y-%m-%d") <=', $end);
        if ($region != 'all') {
            $builder->where('orders.region', $region);
        }
        if ($type != 'all') {
            $builder->where('food.type', $type);
        }
        if ($paymentSta != 'all') {
            $builder->where('orders.paymentSta', $paymentSta);
        }
        if ($deliverySta != 'all') {
            $builder->where('orders.deliverySta', $deliverySta);
        }
        $builder->groupBy('orderdetail.foodID');
        $builder->orderBy('orderdetail.foodID');
        $cols = $builder->get()->getResultArray();
        $select = '';
        foreach ($cols as $col) {
            $select .= ', IF(SUM(IF(`orderdetail`.`foodID` = \'' . $col['foodID'] . '\', `orderdetail`.`qty`, 0))=0,\'\',SUM(IF(`orderdetail`.`foodID` = \'' . $col['foodID'] . '\', `orderdetail`.`qty`, 0))) AS `' . $col['foodID'] . '`';
        }
        // dd($select);
        $builder = $db->table('orderdetail');
        $builder->select('orderdetail.ordID, orders.serialNum ' . $select . ', IF(orders.deliverySta=0,\'N\',\'Y\') as deliverySta, orders.roomNum, orders.phoneNum');
        $builder->join('orders', 'orders.ordID = orderdetail.ordID', 'inner');
        $builder->join('food', 'food.foodID = orderdetail.foodID', 'left');
        $builder->where('DATE_FORMAT(orders.created_at, "%Y-%m-%d") >=', $begin);
        $builder->where('DATE_FORMAT(orders.created_at, "%Y-%m-%d") <=', $end);
        $builder->where('orders.deleted_at IS NULL');

        if ($region != 'all') {
            $builder->where('orders.region', $region);
        }
        if ($type != 'all') {
            $builder->where('food.type', $type);
        }
        if ($paymentSta != 'all') {
            $builder->where('orders.paymentSta', $paymentSta);
        }
        if ($deliverySta != 'all') {
            $builder->where('orders.deliverySta', $deliverySta);
        }
        $builder->groupBy('orderdetail.ordID');
        $builder->orderBy('orders.serialNum');
        // dd($builder->getCompiledSelect());
        return $builder->get()->getResultArray();
    }
    public function getPivotColumns($begin, $end, $type, $deliverySta, $paymentSta, $region)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('orderdetail');
        $builder->select('orderdetail.foodID');
        $builder->join('orders', 'orders.ordID = orderdetail.ordID', 'inner');
        $builder->join('food', 'food.foodID = orderdetail.foodID', 'left');
        $builder->where('DATE_FORMAT(orders.created_at, "%Y-%m-%d") >=', $begin);
        $builder->where('DATE_FORMAT(orders.created_at, "%Y-%m-%d") <=', $end);
        if ($region != 'all') {
            $builder->where('orders.region', $region);
        }
        if ($type != 'all') {
            $builder->where('food.type', $type);
        }
        if ($paymentSta != 'all') {
            $builder->where('orders.paymentSta', $paymentSta);
        }
        if ($deliverySta != 'all') {
            $builder->where('orders.deliverySta', $deliverySta);
        }
        $builder->groupBy('orderdetail.foodID');
        $builder->orderBy('cast(orderdetail.foodID as unsigned)');
        return $builder->get()->getResultArray();
    }
    //-------------------------------------------------------------------new

    public function getOrdersCountGroupByRegion()
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('orders');
        $builder->select('orders.region, count(orders.ordID) as count');
        $builder->where('DATE_FORMAT(orders.created_at, "%Y-%m-%d")', date('Y-m-d'));
        $builder->where('orders.deleted_at IS NULL');
        $builder->groupBy('orders.region');
        // dd($builder->getCompiledSelect());
        return $builder->get()->getResultArray();
    }
}
