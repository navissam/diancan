<?php

namespace App\Controllers\admin;

use App\Controllers\BaseController;
use App\Models\Customer_model;

class Customer extends BaseController
{
    protected $customerModel;
    public function __construct()
    {
        $this->customerModel = new Customer_model();
    }

    public function index()
    {
        $data['active']['customer'] = true;
        return view('admin/customer/v_customer_search', $data);
    }

    public function result()
    {
        if ($this->request->getMethod() == 'post') {
            $key = $this->request->getPost('key');
            $data['rows'] = $this->customerModel->search($key);
            $data['key'] = $key;
            $data['active']['customer'] = true;
            return view('admin/customer/v_customer_result', $data);
        }
    }

    public function block()
    {
        if ($this->request->getMethod() == 'post') {
            try {
                $cusID = $this->request->getPost('cusID');
                if ($this->customerModel->update($cusID, ['status' => 1])) {
                    $this->admlog->insert([
                        'controller' => 'customer',
                        'method' => 'block',
                        'userID' => session()->get('userID'),
                        'ip' => $this->request->getIPAddress(),
                        'status' => 1,
                        'data' => 'cusID = ' . $cusID
                    ]);
                    session()->setFlashdata('success', '拉黑成功 Berhasil Diblockir');
                    return redirect()->to(base_url('/admin/customer'));
                }
            } catch (\Exception $e) {
                $this->admlog->insert([
                    'controller' => 'customer',
                    'method' => 'block',
                    'userID' => session()->get('userID'),
                    'ip' => $this->request->getIPAddress(),
                    'status' => 0,
                    'data' => 'cusID = ' . $cusID,
                    'response' => $e->getMessage()
                ]);
                session()->setFlashdata('error', '拉黑失败 Gagal blockir！ Error -> ' . $e->getMessage());
                return redirect()->to(base_url('/admin/customer'));
            }
        }
    }

    public function restore()
    {
        try {
            if ($this->request->getMethod() == 'post') {
                $cusID = $this->request->getPost('cusID');
                if ($this->customerModel->update($cusID, ['status' => 0])) {
                    $this->admlog->insert([
                        'controller' => 'customer',
                        'method' => 'restore',
                        'userID' => session()->get('userID'),
                        'ip' => $this->request->getIPAddress(),
                        'status' => 1,
                        'data' => 'cusID = ' . $cusID
                    ]);
                    session()->setFlashdata('success', '复原成功 Berhasil dipulihkan');
                    return redirect()->to(base_url('/admin/customer'));
                }
            }
        } catch (\Exception $e) {
            $this->admlog->insert([
                'controller' => 'customer',
                'method' => 'restore',
                'userID' => session()->get('userID'),
                'ip' => $this->request->getIPAddress(),
                'status' => 0,
                'data' => 'cusID = ' . $cusID,
                'response' => $e->getMessage()
            ]);
            session()->setFlashdata('error', '复原失败 Gagal pulihkan！ Error -> ' . $e->getMessage());
            return redirect()->to(base_url('/admin/customer'));
        }
    }
    public function resetpass()
    {
        try {
            if ($this->request->getMethod() == 'post') {
                $cusID = $this->request->getPost('cusID');
                if ($this->customerModel->update($cusID, ['password' => null])) {
                    $this->admlog->insert([
                        'controller' => 'customer',
                        'method' => 'resetpass',
                        'userID' => session()->get('userID'),
                        'ip' => $this->request->getIPAddress(),
                        'status' => 1,
                        'data' => 'cusID = ' . $cusID
                    ]);
                    session()->setFlashdata('success', '重置密码成功 Password berhasil direset');
                    return redirect()->to(base_url('/admin/customer'));
                }
            }
        } catch (\Exception $e) {
            $this->admlog->insert([
                'controller' => 'customer',
                'method' => 'resetpass',
                'userID' => session()->get('userID'),
                'ip' => $this->request->getIPAddress(),
                'status' => 0,
                'data' => 'cusID = ' . $cusID,
                'response' => $e->getMessage()
            ]);
            session()->setFlashdata('error', '复原失败 Gagal pulihkan！ Error -> ' . $e->getMessage());
            return redirect()->to(base_url('/admin/customer'));
        }
    }
}
