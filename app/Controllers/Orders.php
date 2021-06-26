<?php

namespace App\Controllers;

use App\Models\Food_model;
use App\Models\Orders_model;
use App\Models\Variables_model;
use App\Models\Customer_model;
use CodeIgniter\I18n\Time;

class Orders extends BaseController
{
    protected $orderModel, $varModel, $customerModel;

    public function __construct()
    {
        $this->orderModel = new Orders_model();
        $this->varModel = new Variables_model();
        $this->customerModel = new Customer_model();
    }
    public function index()
    {
        $cusID = session()->get('cusID');
        $customer = $this->customerModel->where(['cusID' => $cusID, 'status' => 0])->first();
        $orders  = $this->orderModel->getOrdersByCus($cusID);
        $details = $this->orderModel->getDetailsByCus($cusID);

        $data['customer'] = $customer;
        $data['orders'] = $orders;
        $data['details'] = $details;
        $data['endTime'] = $this->varModel->getValue('endTime');
        return view('customer/v_orders_list.php', $data);
    }

    public function cancel()
    {
        // if ($this->request->getMethod() == 'post') {
        //     $ordID = $this->request->getPost('ordID');
        //     try {
        //         $result = $this->orderModel->find($ordID);
        //         if ($result['paymentSta'] == 1) {
        //             $this->cuslog->insert([
        //                 'controller' => 'orders',
        //                 'method' => 'cancel',
        //                 'empID' => session()->get('empID'),
        //                 'status' => 0,
        //                 'data' => 'ordID = ' . $ordID,
        //                 'response' => 'Trying canceling order after payment'
        //             ]);
        //             return redirect()->to(base_url('/orders'));
        //         }
        //         if ($this->orderModel->delete($ordID)) {
        //             session()->setFlashdata('success', '撤销成功');
        //             return redirect()->to(base_url('/orders'));
        //         } else {
        //             session()->setFlashdata('error', '撤销失败');
        //             return redirect()->to(base_url('/orders'));
        //         }
        //     } catch (\Exception $e) {
        //         session()->setFlashdata('error', '撤销失败！失误信息：' . $e->getMessage());
        //         $this->cuslog->insert([
        //             'controller' => 'orders',
        //             'method' => 'cancel',
        //             'empID' => session()->get('empID'),
        //             'status' => 0,
        //             'data' => 'ordID = ' . $ordID,
        //             'response' => $e->getMessage()
        //         ]);
        //         return redirect()->to(base_url('/orders'));
        //     }
        // }
        $time = $this->varModel->getValue('endTime');
        // $myTime = new Time('now');
        $myTime = date('H:i');
        if ($this->request->getMethod() == 'post') {
            $ordID = $this->request->getPost('ordID');
            try {
                $result = $this->orderModel->find($ordID);
                if ($result['paymentSta'] == 1) {
                    $this->cuslog->insert([
                        'controller' => 'orders',
                        'method' => 'cancel',
                        'empID' => session()->get('empID'),
                        'status' => 0,
                        'data' => 'ordID = ' . $ordID,
                        'response' => 'Trying canceling order after payment'
                    ]);
                    return redirect()->to(base_url('/orders'));
                    // if ($time < $myTime->toTimeString()) {
                } elseif ($time < $myTime) {
                    $this->cuslog->insert([
                        'controller' => 'orders',
                        'method' => 'cancel',
                        'empID' => session()->get('empID'),
                        'status' => 0,
                        'data' => 'ordID = ' . $ordID,
                        'response' => 'canceling overtime'
                    ]);
                    session()->setFlashdata('error', '撤销时间已过');
                    return redirect()->to(base_url('/orders'));
                } elseif ($this->orderModel->delete($ordID) && $this->orderModel->deleteDetails($ordID)) {
                    session()->setFlashdata('success', '撤销成功');
                    return redirect()->to(base_url('/orders'));
                } else {
                    session()->setFlashdata('error', '撤销失败');
                    return redirect()->to(base_url('/orders'));
                }
            } catch (\Exception $e) {
                session()->setFlashdata('error', '撤销失败！失误信息：' . $e->getMessage());
                $this->cuslog->insert([
                    'controller' => 'orders',
                    'method' => 'cancel',
                    'empID' => session()->get('empID'),
                    'status' => 0,
                    'data' => 'ordID = ' . $ordID,
                    'response' => $e->getMessage()
                ]);
                return redirect()->to(base_url('/orders'));
            }
        }
    }

    public function history()
    {
        $cusID = session()->get('cusID');
        $customer = $this->customerModel->where(['cusID' => $cusID, 'status' => 0])->first();
        $dates  = $this->orderModel->getHistoryDates($cusID);
        $orders  = $this->orderModel->getHistoryOrders($cusID);
        $details = $this->orderModel->getHistoryDetails($cusID);

        $data['customer'] = $customer;
        $data['dates'] = $dates;
        $data['orders'] = $orders;
        $data['details'] = $details;
        // dd($data);
        return view('customer/v_orders_history.php', $data);
    }
}
