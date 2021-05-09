<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Food_model;
use App\Models\Orders_model;
use App\Models\Variables_model;
use App\Models\Customer_model;


class Orders extends BaseController
{
    protected $foodModel, $orderModel, $varModel, $customerModel;

    public function __construct()
    {
        $this->foodModel = new Food_model();
        $this->orderModel = new Orders_model();
        $this->varModel = new Variables_model();
        $this->customerModel = new Customer_model();
    }
    public function index()
    {
        // $data['orders'] = $this->orderModel->getTodayOrders($region);
        // $data['details'] = $this->orderModel->getTodayDetails($region);
        // $data['date'] = date('Y-m-d');
        // $data['region'] = $region;
        // $data['active']['orders'][$region] = true;
        // return view('admin/orders/r_orders_list', $data);

        $data['active']['orders']['orders'] = true;
        return view('admin/orders/v_orders_history', $data);
    }
    public function cus()
    {
        $data['active']['orders']['customer'] = true;
        return view('admin/orders/v_orders_history_by_cus', $data);
    }
    public function food()
    {
        $data['active']['orders']['food'] = true;
        return view('admin/orders/v_orders_history_by_food', $data);
    }
    public function detail()
    {
        $data['active']['orderdetail'] = true;
        return view('admin/orders/v_orders_history_detail', $data);
    }

    // public function getOrd($foodID)
    // {
    //     $data = $this->orderModel->getPayedOrdersBy($foodID);
    //     $data = json_encode($data);
    //     return $data;
    // }
    public function getDetail($ordID)
    {
        $data = $this->orderModel->getDetail($ordID);
        // dd($data);
        $data = json_encode($data);
        return $data;
    }
    public function pivot($begin, $end, $type, $deliverySta, $paymentSta, $region)
    {
        $data = $this->orderModel->getOrderPivot($begin, $end, $type, $deliverySta, $paymentSta, $region);
        // dd($data);
        $data = json_encode($data);
        return $data;
    }
    public function pivot_col($begin, $end, $type, $deliverySta, $paymentSta, $region)
    {
        $cols = $this->orderModel->getPivotColumns($begin, $end, $type, $deliverySta, $paymentSta, $region);
        $header = [
            [
                'title' => '序号<br>Serial',
                'data' => 'serialNum'
            ],
            [
                'title' => '编号<br>Kode',
                'data' => 'ordID'
            ],
        ];
        foreach ($cols as $col) {
            $h = [
                'title' => $col['foodID'],
                'data' => $col['foodID'],
                // 'render' => 'function(data) {if(data==0) return "";}',
            ];
            array_push($header, $h);
        }
        $h1 = [
            'title' => '外送<br>Antar',
            'data' => 'deliverySta'
        ];
        $h2 = [
            'title' => '房间号<br>Kamar',
            'data' => 'roomNum'
        ];
        $h3 = [
            'title' => '电话号<br>No.Telp',
            'data' => 'phoneNum'
        ];
        array_push($header, $h1, $h2, $h3);
        // dd($header);
        $data = json_encode($header);
        return $data;
    }

    public function history_by_order_query($begin, $end, $deliverySta, $paymentSta, $region)
    {
        if ($begin != null && $end != null && $deliverySta != null &&  $paymentSta != null && $region != null) {
            // $result = $this->orders_model->getHistoryByOrder($begin, $end, $deliverySta, $paymentSta, $region);
            $result = $this->orderModel->getHistoryByOrder($begin, $end, $deliverySta, $paymentSta, $region);
            $json = json_encode($result);
            return $json;
        } else {
            return null;
        }
    }
    public function history_by_cus_query($begin, $end, $deliverySta, $paymentSta, $region)
    {
        if ($begin != null && $end != null && $deliverySta != null &&  $paymentSta != null && $region != null) {
            // $result = $this->orders_model->getHistoryByOrder($begin, $end, $deliverySta, $paymentSta, $region);
            $result = $this->orderModel->getHistoryByCus($begin, $end, $deliverySta, $paymentSta, $region);
            $json = json_encode($result);
            return $json;
        } else {
            return null;
        }
    }
    public function history_by_food_query($begin, $end, $type, $deliverySta, $paymentSta, $region)
    {
        if ($begin != null && $end != null && $deliverySta != null &&  $paymentSta != null && $region != null) {
            // $result = $this->orders_model->getHistoryByOrder($begin, $end, $deliverySta, $paymentSta, $region);
            $result = $this->orderModel->getHistoryByFood($begin, $end, $type, $deliverySta, $paymentSta, $region);
            $json = json_encode($result);
            return $json;
        } else {
            return null;
        }
    }
}
