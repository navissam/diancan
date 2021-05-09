<?php

namespace App\Controllers\Admin;

use App\Models\User_model;
use App\Controllers\BaseController;
use Exception;

class User extends BaseController
{
    protected $user_model;
    public function __construct()
    {
        $this->user_model = new User_model();
    }
    public function index()
    {
        $data['rows'] = $this->user_model->where('roleID <>', 'super')->findAll();
        $data['active']['user'] = true;
        return view('admin/user/v_user_main', $data);
    }

    public function add()
    {
        $data['validation'] = \Config\Services::validation();
        $data['roles'] = $this->user_model->getRoles();
        $data['active']['user'] = true;
        return view('admin/user/v_user_add', $data);
    }

    public function edit($userID)
    {
        $userID = base64_decode($userID);
        $data['validation'] = \Config\Services::validation();
        $data['user'] = $this->user_model->find($userID);
        $data['roles'] = $this->user_model->getRoles();
        $data['active']['user'] = true;
        return view('admin/user/v_user_edit', $data);
    }

    public function save()
    {
        if (!$this->validate([
            'userID' => [
                'rules' => 'required|is_unique[user.userID]',
                'errors' => [
                    'required' => '不允许为空 Tidak boleh kosong',
                    'is_unique' => '账号编码已使用过 Kode sudah terpakai'
                ]
            ],
            'name' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '不允许为空 Tidak boleh kosong'
                ]
            ],
            'roleID' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '不允许为空 Tidak boleh kosong'
                ]
            ],
            'password' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '不允许为空 Tidak boleh kosong'
                ]
            ],
            'passConfirm' => [
                'rules' => 'required|matches[password]',
                'errors' => [
                    'required' => '不允许为空 Tidak boleh kosong',
                    'matches' => '密码不一样 Password tidak cocok'
                ]
            ],

        ])) {
            return redirect()->to(base_url('/admin/user/add'))->withInput();
        }

        if ($this->request->getMethod() == 'post') {
            try {
                $data = [
                    'userID' => $this->request->getPost('userID'),
                    'name' => $this->request->getPost('name'),
                    'roleID' => $this->request->getPost('roleID'),
                    'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
                ];
                // dd($data);
                if ($this->user_model->insert($data)) {
                    $this->admlog->insert([
                        'controller' => 'user',
                        'method' => 'save',
                        'userID' => session()->get('userID'),
                        'ip' => $this->request->getIPAddress(),
                        'status' => 1,
                        'data' => json_encode($data)
                    ]);
                    session()->setFlashdata('success', '添加成功 Berhasil menambah');
                    return redirect()->to(base_url('/admin/user'));
                }
            } catch (\Exception $e) {
                $this->admlog->insert([
                    'controller' => 'user',
                    'method' => 'save',
                    'userID' => session()->get('userID'),
                    'ip' => $this->request->getIPAddress(),
                    'status' => 0,
                    'data' => json_encode($data),
                    'response' => $e->getMessage()
                ]);
                session()->setFlashdata('error', '添加失败 Gagal menambah！ Error -> ' . $e->getMessage() . $e->getCode());
                return redirect()->to(base_url('/admin/user'));
            }
        }
    }

    public function update()
    {
        $userID = $this->request->getPost('userID');
        $ori_userID = $this->request->getPost('ori_userID');
        $unique = ($userID == $ori_userID) ? '' : '|is_unique[user.userID]';
        if (!$this->validate([
            'userID' => [
                'rules' => 'required' . $unique,
                'errors' => [
                    'required' => '不允许为空 Tidak boleh kosong',
                    'is_unique' => '账号编码已使用过 Kode sudah terpakai'
                ]
            ],
            'name' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '不允许为空 Tidak boleh kosong'
                ]
            ],
            'roleID' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '不允许为空 Tidak boleh kosong'
                ]
            ],
        ])) {
            return redirect()->to(base_url('/admin/user/edit/' . base64_encode($userID)))->withInput();
        }

        if ($this->request->getMethod() == 'post') {
            try {
                $data = [
                    'userID' => $this->request->getPost('userID'),
                    'name' => $this->request->getPost('name'),
                    'roleID' => $this->request->getPost('roleID'),
                    'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
                ];
                // dd($data);
                if ($this->user_model->update($ori_userID, $data)) {
                    $this->admlog->insert([
                        'controller' => 'user',
                        'method' => 'update',
                        'userID' => session()->get('userID'),
                        'ip' => $this->request->getIPAddress(),
                        'status' => 1,
                        'data' => json_encode($data)
                    ]);
                    session()->setFlashdata('success', '编辑成功 Berhasil edit');
                    return redirect()->to(base_url('/admin/user'));
                }
            } catch (\Exception $e) {
                $this->admlog->insert([
                    'controller' => 'user',
                    'method' => 'update',
                    'userID' => session()->get('userID'),
                    'ip' => $this->request->getIPAddress(),
                    'status' => 0,
                    'data' => json_encode($data),
                    'response' => $e->getMessage()
                ]);
                session()->setFlashdata('error', '编辑失败 Gagal edit！ Error -> ' . $e->getMessage());
                return redirect()->to(base_url('/admin/user'));
            }
        }
    }

    public function block()
    {
        if ($this->request->getMethod() == 'post') {
            try {
                $userID = $this->request->getPost('userID');
                if ($this->user_model->update($userID, ['status' => 1])) {
                    $this->admlog->insert([
                        'controller' => 'user',
                        'method' => 'block',
                        'userID' => session()->get('userID'),
                        'ip' => $this->request->getIPAddress(),
                        'status' => 1,
                        'data' => 'userID = ' . $userID
                    ]);
                    session()->setFlashdata('success', '拉黑成功 Berhasil blockir');
                    return redirect()->to(base_url('/admin/user'));
                }
            } catch (\Exception $e) {
                $this->admlog->insert([
                    'controller' => 'user',
                    'method' => 'block',
                    'userID' => session()->get('userID'),
                    'ip' => $this->request->getIPAddress(),
                    'status' => 0,
                    'data' => 'userID = ' . $userID,
                    'response' => $e->getMessage()
                ]);
                session()->setFlashdata('error', '拉黑失败 Gagal blockir！ Error -> ' . $e->getMessage());
                return redirect()->to(base_url('/admin/user'));
            }
        }
    }
    public function resetpass()
    {
        if ($this->request->getMethod() == 'post') {
            try {
                $userID = $this->request->getPost('userID');
                if ($this->user_model->update($userID, ['password' => password_hash('123', PASSWORD_DEFAULT)])) {
                    $this->admlog->insert([
                        'controller' => 'user',
                        'method' => 'resetpass',
                        'userID' => session()->get('userID'),
                        'ip' => $this->request->getIPAddress(),
                        'status' => 1,
                        'data' => 'userID = ' . $userID
                    ]);
                    session()->setFlashdata('success', '重置密码成功 Berhasil reset password！默认密码 Password -> 123');
                    return redirect()->to(base_url('/admin/user'));
                }
            } catch (\Exception $e) {
                $this->admlog->insert([
                    'controller' => 'user',
                    'method' => 'resetpass',
                    'userID' => session()->get('userID'),
                    'ip' => $this->request->getIPAddress(),
                    'status' => 0,
                    'data' => 'userID = ' . $userID,
                    'response' => $e->getMessage()
                ]);
                session()->setFlashdata('error', '重置密码失败 Gagal reset password！ Error -> ' . $e->getMessage());
                return redirect()->to(base_url('/admin/user'));
            }
        }
    }

    public function restore()
    {
        if ($this->request->getMethod() == 'post') {
            try {
                $userID = $this->request->getPost('userID');
                if ($this->user_model->update($userID, ['status' => 0])) {
                    $this->admlog->insert([
                        'controller' => 'user',
                        'method' => 'restore',
                        'userID' => session()->get('userID'),
                        'ip' => $this->request->getIPAddress(),
                        'status' => 1,
                        'data' => 'userID = ' . $userID
                    ]);
                    session()->setFlashdata('success', '复原成功 Berhasil dipulihkan');
                    return redirect()->to(base_url('/admin/user'));
                }
            } catch (\Exception $e) {
                $this->admlog->insert([
                    'controller' => 'user',
                    'method' => 'restore',
                    'userID' => session()->get('userID'),
                    'ip' => $this->request->getIPAddress(),
                    'status' => 0,
                    'data' => 'userID = ' . $userID,
                    'response' => $e->getMessage()
                ]);
                session()->setFlashdata('error', '复原失败 Gagal dipulihkan！ Error -> ' . $e->getMessage());
                return redirect()->to(base_url('/admin/user'));
            }
        }
    }
}
