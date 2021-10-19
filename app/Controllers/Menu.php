<?php

namespace App\Controllers;

use App\Models\Food_model;
use App\Models\Orders_model;
use App\Models\Variables_model;
use App\Models\Customer_model;

use function PHPUnit\Framework\isNull;
use function PHPUnit\Framework\returnSelf;

class Menu extends BaseController
{
    protected $foodModel, $orderModel, $varModel, $customerModel;

    public function __construct()
    {
        $this->foodModel = new Food_model();
        $this->orderModel = new Orders_model();
        $this->varModel = new Variables_model();
        $this->customerModel = new Customer_model();
    }

    protected function generateOrdID()
    {
        // $rand = rand(0, 9999);
        // $rand = substr('0000' . strval($rand), -4);

        // $dt = date('ymd');
        // return $empID . '-' . $dt;

        $dt = date('ymd');
        $str = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
        $str_a = 'ABCDEFGHJKLMNPQRSTUVWXYZ';
        do {
            $rand_code = '';
            $rand_num = rand(0, 23);
            $rand_code .= $str_a[$rand_num];
            $len = 2;
            for ($i = 0; $i < $len; $i++) {
                $rand_num = rand(0, 31);
                $rand_code .= $str[$rand_num];
            }
            $result = $rand_code . '-' . $dt;
            // dd($this->orderModel->find($result));
        } while ($this->orderModel->find($result) != null);
        return $result;
    }

    public function index()
    {
        // dd($this->generateOrdID());
        $data['special'] = $this->foodModel->getFoodRow('special');
        $data['ordinary'] = $this->foodModel->getFoodRow('ordinary');
        // $data['ordered'] = $this->orderModel->getSpecialOrdered();
        $data['deliveryCost'] = $this->varModel->getValue('deliveryCost');
        $data['beginTime'] = $this->varModel->getValue('beginTime');
        $data['endTime'] = $this->varModel->getValue('endTime');
        $data['title'] = '发布菜肴';
        // dd($data);
        return view('customer/v_menu.php', $data);
    }

    protected function isOrderOver($json)
    {
        $special = $this->foodModel->getFoodRow('special');
        foreach ($special as $row) {
            foreach ($json as $row2) {
                if ($row['foodID'] == $row2['foodID']) {
                    if ($row['ordered_qty'] + $row2['qty'] > $row['qty'])
                        return true;
                }
            }
        }
    }

    protected function isDouble($cusID, $json, $seconds)
    {
        $foodIDs = [];
        $qtys = [];
        // foreach ($json as $row) {
        //     array_push($foodIDs, $row['foodID']);
        //     array_push($qtys, $row['qty']);
        // }
        // $prev = $this->orderModel->getPrevOrders($cusID, $foodIDs, $qtys);

        $prev = $this->orderModel->getPrevOrders($cusID, $json);
        // dd($prev);
        if ($prev == null) return null;
        $last = date_create($prev['max_date']);
        $now = date_create();
        $diff = $now->getTimestamp() - $last->getTimestamp();
        // dd($diff);
        // dd($prev['ordID']);
        if ($seconds > $diff) {
            return $prev['ordID'];
        }
        return null;
    }

    public function ordering()
    {
        // dd($this->request->getPost());
        $time = $this->varModel->getValue('endTime');
        $myTime = date('H:i');
        if ($this->request->getMethod() == 'post') {
            try {
                // dd($this->request->getPost());
                $json_ = $this->request->getPost('json');
                $json = json_decode($this->request->getPost('json'), true);
                if (!(is_array($json) || is_object($json))) {
                    session()->setFlashdata('error', '订购失败! 信息有错误。Gagal memesan!  Kesalahan informasi (JSON).');
                    $this->cuslog->insert([
                        'controller' => 'menu',
                        'method' => 'ordering',
                        'empID' => session()->get('empID'),
                        'status' => 0,
                        'data' => $json_,
                        'response' => 'JSON is not valid'
                    ]);
                    return redirect()->to('/menu');
                } elseif ($time < $myTime) {
                    $this->cuslog->insert([
                        'controller' => 'menu',
                        'method' => 'ordering',
                        'empID' => session()->get('empID'),
                        'status' => 0,
                        'response' => 'ordering overtime'
                    ]);
                    session()->setFlashdata('error', '订单时间已过');
                    return redirect()->to('/menu');
                }
                $cusID = session()->get('cusID');
                $double = $this->isDouble($cusID, $json, 120);
                // dd($double);
                if ($double != null) {
                    $this->cuslog->insert([
                        'controller' => 'menu',
                        'method' => 'ordering',
                        'empID' => session()->get('empID'),
                        'status' => 0,
                        'data' => $json_,
                        'response' => 'Double submit'
                    ]);

                    // return redirect()->to('/menu/orderresult/' . base64_encode($double));
                    return redirect()->to('/orders');
                }
                $customer = $this->customerModel->where(['cusID' => $cusID, 'status' => 0])->first();
                $ordID = $this->generateOrdID();
                $data['ordID'] = $ordID;
                $data = array_merge($data, $customer);
                $data['deliverySta'] = $this->request->getPost('deliverySta');
                // $deliveryCost = $this->request->getPost('deliverySta') ? $this->varModel->getValue('deliveryCost') : 0;
                // $data['deliveryCost'] = $deliveryCost;
                if ($this->isOrderOver($json)) {
                    session()->setFlashdata('error', '订购失败! 其中特别菜肴已卖完。Gagal memesan!  Salah satu menu spesial telah terjual habis.');
                    return redirect()->to('/menu');
                }
                if ($data['deliverySta'] == 0) {
                    $data['deliveryCost'] = 0;
                } else {
                    $data['deliveryCost'] = $this->varModel->getValue('deliveryCost');
                    if ($this->request->getPost('deliveryTo') == 'spec') {
                        $data['roomNum'] = $this->request->getPost('to');
                        $data['region'] = $this->request->getPost('region');
                    }
                }
                if ($this->orderModel->insert($data)) {
                    $details = [];
                    $detail = [];
                    $total = 0;
                    foreach ($json as $row) {
                        $detail['ordID'] = $ordID;
                        $detail['foodID'] = $row['foodID'];
                        $detail['qty'] = $row['qty'];
                        array_push($details, $detail);
                        $total += $row['price'] * $row['qty'];
                    }

                    if ($this->orderModel->insertDetail($details)) {
                        return redirect()->to('/menu/orderResult/' . base64_encode($ordID));
                    } else {
                        $this->orderModel->delete($ordID);
                        session()->setFlashdata('error', '订购失败');
                        $this->cuslog->insert([
                            'controller' => 'menu',
                            'method' => 'ordering',
                            'empID' => $customer['empID'],
                            'status' => 0,
                            'data' => $json_,
                            'response' => 'detail failed'
                        ]);
                        return redirect()->to('/menu');
                    }
                } else {
                    session()->setFlashdata('error', '订购失败');
                    $this->cuslog->insert([
                        'controller' => 'menu',
                        'method' => 'ordering',
                        'empID' => $customer['empID'],
                        'status' => 0,
                        'data' => $json_,
                        'response' => 'header failed'
                    ]);
                    return redirect()->to('/menu');
                }
            } catch (\Exception $e) {
                session()->setFlashdata('error', '订购失败！Gagal! Error -> ' . $e->getMessage());
                $this->cuslog->insert([
                    'controller' => 'menu',
                    'method' => 'ordering',
                    'empID' => session()->get('empID'),
                    'status' => 0,
                    'data' => $json_,
                    'response' => $e->getMessage()
                ]);
                return redirect()->to('/menu');
            }
        }
    }

    public function orderResult($ordID)
    {
        $ordID = base64_decode($ordID);
        $details = $this->orderModel->getDetail($ordID);
        $header = $this->orderModel->find($ordID);
        // dd($header);
        if ($header == null) {
            return redirect()->to('/');
        }
        $data = [
            'details' => $details,
            'header' => $header,
            'ordID' => $ordID
        ];
        return view('customer/v_orderResult', $data);
    }
}
