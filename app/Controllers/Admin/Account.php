<?php

namespace App\Controllers\Admin;

use App\Models\User_model;
use App\Controllers\BaseController;
use Exception;

class Account extends BaseController
{
    protected $user_model;
    public function __construct()
    {
        $this->user_model = new User_model();
    }

    public function changepass()
    {
        $data['validation'] = \Config\Services::validation();
        $data['active']['pass'] = true;
        return view('/admin/user/v_user_change', $data);
    }

    public function updatepass()
    {
        if (!$this->validate([
            'currPass' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '不允许为空 Tidak boleh kosong'
                ]
            ],
            'newPass' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '不允许为空 Tidak boleh kosong'
                ]
            ],

            'passConfirm' => [
                'rules' => 'required|matches[newPass]',
                'errors' => [
                    'required' => '不允许为空 Tidak boleh kosong',
                    'matches' => '密码不一样 Password tidak cocok'
                ]
            ]
        ])) {
            return redirect()->to(base_url('/admin/account/changepass'))->withInput();
        }

        try {
            if ($this->request->getMethod() == 'post') {
                $userID = session()->get('userID');
                $currPass = $this->request->getPost('currPass');
                $newPass = $this->request->getPost('newPass');
                $customer = $this->user_model->find($userID);
                $pass = $customer['password'];
                if (password_verify($currPass, $pass)) {
                    if ($this->user_model->update($userID, ['password' => password_hash($newPass, PASSWORD_DEFAULT)])) {
                        $this->admlog->insert([
                            'controller' => 'account',
                            'method' => 'changepass',
                            'userID' => session()->get('userID'),
                            'ip' => $this->request->getIPAddress(),
                            'status' => 1
                        ]);
                        session()->setFlashdata('success', '密码更改成功 Berhasil mengubah password');
                        return redirect()->to(base_url('/admin/account/changepass'));
                    }
                } else {
                    session()->setFlashdata('error', '当前密码错误 Gagal');
                    return redirect()->to(base_url('/admin/account/changepass'));
                }
            }
        } catch (\Exception $e) {
            $this->admlog->insert([
                'controller' => 'account',
                'method' => 'changepass',
                'userID' => session()->get('userID'),
                'ip' => $this->request->getIPAddress(),
                'status' => 0,
                'response' => $e->getMessage()
            ]);
            session()->setFlashdata('error', '密码更改失败 Gagal！ 失误信息：' . $e->getMessage());
            return redirect()->to(base_url('/admin/account/changepass'));
            //die($e->getMessage());
        }
    }
}
