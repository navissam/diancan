<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Orders_model;
use App\Models\Variables_model;



class Payment extends BaseController
{
    protected $varModel, $orderModel;

    public function __construct()
    {
        $this->orderModel = new Orders_model();
        $this->varModel = new Variables_model();
    }

    public function index()
    {
        $data['title'] = '付款 Pembayaran';
        $data['active']['payment'] = true;
        return view('admin/orders/v_payment_search', $data);
    }

    public function search()
    {
        if ($this->request->getMethod() == 'post') {
            $key = $this->request->getPost('key');
            $orders = $this->orderModel->getBySerial($key);
            if ($orders == null) {
                $key .= '-' . date('ymd');
                $orders = $this->orderModel->find($key);
                if ($orders == null) {
                    $data['order'] = $orders;
                    $data['detail'] = null;
                    $data['title'] = '付款 Pembayaran';
                    // dd($data);
                    return view('admin/orders/v_payment_result', $data);
                }
            }
            // dd($orders);
            $ordID = $orders['ordID'];
            $ordID = base64_encode($ordID);
            return redirect()->to('/admin/payment/result/' . $ordID);
        }
    }

    public function result($ordID)
    {
        $ordID = base64_decode($ordID);
        // dd($ordID);
        $orders = $this->orderModel->find($ordID);
        $data['active']['payment'] = true;
        if ($orders == null) {
            $data['order'] = $orders;
            $data['detail'] = null;
            $data['title'] = '付款 Pembayaran';
            // dd($data);
            return view('admin/orders/v_payment_result', $data);
        }
        $data['order'] = $orders;
        $data['detail'] = $this->orderModel->getDetail($orders['ordID']);
        $data['title'] = '付款 Pembayaran';
        // dd($data);
        return view('admin/orders/v_payment_result', $data);
    }

    public function process()
    {
        if ($this->request->getMethod() == 'post') {
            try {
                $ordID = $this->request->getPost('ordID');
                if ($this->orderModel->update($ordID, ['paymentSta' => 1])) {
                    $this->admlog->insert([
                        'controller' => 'payment',
                        'method' => 'process',
                        'userID' => session()->get('userID'),
                        'ip' => $this->request->getIPAddress(),
                        'status' => 1,
                        'data' => 'ordID = ' . $ordID
                    ]);
                    session()->setFlashdata('success', '支付成功 Pembayaran berhasil');
                    $ordID = base64_encode($ordID);
                    // return redirect()->to(base_url('/admin/payment/print/' . $ordID));
                    return redirect()->to(base_url('/admin/payment/result/' . $ordID));
                }
            } catch (\Exception $e) {
                $this->admlog->insert([
                    'controller' => 'payment',
                    'method' => 'process',
                    'userID' => session()->get('userID'),
                    'ip' => $this->request->getIPAddress(),
                    'status' => 0,
                    'data' => 'ordID = ' . $ordID,
                    'response' => $e->getMessage()
                ]);
                session()->setFlashdata('error', '支付失败 Pembayaran Gagal! Error -> ' . $e->getMessage());
                return redirect()->to(base_url('/admin/payment'));
            }
        }
    }

    public function print($ordID = false)
    {
        if (!$ordID)  return redirect()->to('/admin/payment');
        $ordID = base64_decode($ordID);
        $data['order'] = $this->orderModel->find($ordID);
        if ($data['order'] == null) {
            return redirect()->to('/admin/payment');
        }
        $data['details'] = $this->orderModel->getDetail($ordID);
        $data['active']['payment'] = true;
        // dd($data);
        return view('admin/orders/r_order_print', $data);
    }
}
