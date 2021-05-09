<?php

namespace App\Controllers;

use CodeIgniter\HTTP\Request;
use App\Models\Customer_model;

class Account extends BaseController
{
    protected $customerModel;
    public function __construct()
    {
        $this->customerModel = new Customer_model();
    }

    public function changepass()
    {
        $data['validation'] = \Config\Services::validation();
        return view('customer/v_change_password', $data);
    }

    public function updatepass()
    {
        if (!$this->validate([
            'currPass' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '不允许为空'
                ]
            ],
            'newPass' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '不允许为空'
                ]
            ],

            'passConfirm' => [
                'rules' => 'required|matches[newPass]',
                'errors' => [
                    'required' => '不允许为空',
                    'matches' => '密码不一样'
                ]
            ]
        ])) {
            return redirect()->to(base_url('/account/changepass'))->withInput();
        }

        try {
            if ($this->request->getMethod() == 'post') {
                $cusID = session()->get('cusID');
                $currPass = $this->request->getPost('currPass');
                $newPass = $this->request->getPost('newPass');
                $customer = $this->customerModel->find($cusID);
                $pass = $customer['password'];
                if ($pass == null) {
                    $verify_pass = ($currPass == '123456');
                } else {
                    $verify_pass = password_verify($currPass, $pass);
                }
                if ($verify_pass) {
                    if ($this->customerModel->update($cusID, ['password' => password_hash($newPass, PASSWORD_DEFAULT)])) {
                        session()->setFlashdata('success', '密码更改成功');
                        return redirect()->to(base_url('/'));
                    } else {
                        session()->setFlashdata('error', '密码更改失败');
                        return redirect()->to(base_url('/account/changepass'));
                    }
                } else {
                    session()->setFlashdata('error', '当前密码错误');
                    return redirect()->to(base_url('/account/changepass'));
                }
            }
        } catch (\Exception $e) {
            session()->setFlashdata('error', '密码更改失败！ 失误信息：' . $e->getMessage());
            return redirect()->to(base_url('/account/changepass'));
            //die($e->getMessage());
        }
    }

    public function edit()
    {
        $cusID = session()->get('cusID');
        if ($this->customerModel->find($cusID)) {
            $data['title'] = '编辑资料';
            $data['row'] = $this->customerModel->find($cusID);
            $data['validation'] = \Config\Services::validation();
            return view('customer/v_edit_customer', $data);
        } else {
            return redirect()->to(base_url('/'));
        }
    }

    public function update()
    {
        try {

            $cusID = session()->get('cusID');
            $unique = ($this->request->getPost('phoneNum') == $this->customerModel->find($cusID)['phoneNum']) ? '' : '|is_unique[customer.phoneNum]';

            if (!$this->validate([
                'roomNum' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => '不允许为空'
                    ]
                ],
                'phoneNum' => [
                    'rules' => 'required|numeric' . $unique,
                    'errors' => [
                        'required' => '不允许为空',
                        'numeric' => '只允许数字',
                        'is_unique' => '电话号已有人注册'
                    ]
                ],
                'region' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => '不允许为空'
                    ]
                ]
            ])) {
                return redirect()->to(base_url('/account/edit'))->withInput();
            }

            if ($this->request->getMethod() == 'post') {
                $data = [
                    'roomNum' => $this->request->getPost('roomNum'),
                    'phoneNum' => $this->request->getPost('phoneNum'),
                    'region' => $this->request->getPost('region'),
                ];

                $cusID = session()->get('cusID');
                $query = $this->customerModel->update($cusID, $data);
                if ($query) {
                    session()->setFlashdata('success', '资料编辑成功');
                    return redirect()->to(base_url('/account/edit'));
                } else {
                    session()->setFlashdata('error', '资料编辑失败');
                    return redirect()->to(base_url('/account/edit'));
                }
            }
        } catch (\Exception $e) {
            session()->setFlashdata('error', '资料编辑失败！ 失误信息：' . $e->getMessage());
            return redirect()->to(base_url('/account/edit'));
            //die($e->getMessage());
        }
    }
}
