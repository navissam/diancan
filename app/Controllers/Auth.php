<?php

namespace App\Controllers;

use App\Models\Customer_model;
use App\Models\User_model;
use App\Models\EmpMeta_model;

class Auth extends BaseController
{
    protected $customerModel;
    protected $user_model;
    protected $empMetaModel;
    public function __construct()
    {
        $this->customerModel = new Customer_model();
        $this->user_model = new User_model();
        $this->empMetaModel = new EmpMeta_model();
    }
    public function index()
    {

        $data['validation'] = \Config\Services::validation();
        return view('customer/auth/v_login.php', $data);
        // return view('customer/auth/v_maintain.php');
    }

    // public function register()
    // {
    //     $data['validation'] = \Config\Services::validation();
    //     return view('customer/auth/v_register.php', $data);
    // }


    // public function registering()
    // {
    //     if (!$this->validate([
    //         'name' => [
    //             'rules' => 'required',
    //             'errors' => [
    //                 'required' => '不允许为空'
    //             ]
    //         ],
    //         'empID' => [
    //             'rules' => 'required|is_unique[customer.empID]',
    //             'errors' => [
    //                 'required' => '不允许为空',
    //                 'is_unique' => '工号已有人注册'
    //             ]
    //         ]
    //         // ,
    //         // 'roomNum' => [
    //         //     'rules' => 'required',
    //         //     'errors' => [
    //         //         'required' => '不允许为空'
    //         //     ]
    //         // ],

    //         // 'phoneNum' => [
    //         //     'rules' => 'required|is_unique[customer.phoneNum]',
    //         //     'errors' => [
    //         //         'required' => '不允许为空',
    //         //         'is_unique' => '电话号已有人注册'
    //         //     ]
    //         // ],
    //         // 'region' => [
    //         //     'rules' => 'required',
    //         //     'errors' => [
    //         //         'required' => '不允许为空'
    //         //     ]
    //         // ]
    //         ,
    //         'password' => [
    //             'rules' => 'required',
    //             'errors' => [
    //                 'required' => '不允许为空'
    //             ]
    //         ],

    //         'passConfirm' => [
    //             'rules' => 'required|matches[password]',
    //             'errors' => [
    //                 'required' => '不允许为空',
    //                 'matches' => '密码不一样'
    //             ]
    //         ]
    //     ])) {
    //         return redirect()->to(base_url('/register'))->withInput();
    //     }

    //     if ($this->request->getMethod() == 'post') {
    //         try {
    //             $data = [
    //                 'name' => $this->request->getPost('name'),
    //                 'empID' => $this->request->getPost('empID'),
    //                 // 'roomNum' => $this->request->getPost('roomNum'),
    //                 // 'phoneNum' => $this->request->getPost('phoneNum'),
    //                 'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT)
    //                 // 'region' => $this->request->getPost('region'),
    //             ];

    //             if ($this->customerModel->insert($data)) {
    //                 $this->cuslog->insert([
    //                     'controller' => 'auth',
    //                     'method' => 'registering',
    //                     'empID' => $this->request->getPost('empID'),
    //                     'status' => 1,
    //                 ]);
    //                 $ses_data = [
    //                     'empID' => $this->request->getPost('empID'),
    //                     'registered' => TRUE
    //                 ];
    //                 session()->set($ses_data);
    //                 // session()->setFlashdata('success', '注册成功');
    //                 return redirect()->to('/first');
    //             } else {
    //                 $this->cuslog->insert([
    //                     'controller' => 'auth',
    //                     'method' => 'registering',
    //                     'empID' => $this->request->getPost('empID'),
    //                     'status' => 0,
    //                     'response' => 'name and empID aren\'t matched'
    //                 ]);
    //                 session()->setFlashdata('error', '注册失败! 姓名和工号对不上！');
    //                 return redirect()->to(base_url('/register'))->withInput();
    //             }
    //         } catch (\Exception $e) {
    //             $this->cuslog->insert([
    //                 'controller' => 'auth',
    //                 'method' => 'registering',
    //                 'empID' => $this->request->getPost('empID'),
    //                 'status' => 0,
    //                 'response' => $e->getMessage()
    //             ]);
    //             session()->setFlashdata('error', '注册失败！ 失误信息：' . $e->getMessage());
    //             return redirect()->to(base_url('/register'));
    //             //die($e->getMessage());
    //         }
    //     }
    // }

    private function isLogged($empID)
    {
        if ($this->cuslog->getLastLogin($empID) == null || $this->cuslog->getLastLogout($empID) == null) {
            return false;
        }
        $lastLogin = date_create($this->cuslog->getLastLogin($empID));
        $lastLogout = date_create($this->cuslog->getLastLogout($empID));
        $now = date_create();
        if ($lastLogin > $lastLogout) {
            $diff = date_diff($lastLogin, $now);
            $day = intval($diff->format('%R%d'));
            $hour = intval($diff->format('%R%h'));;
            $minute = intval($diff->format('%R%i'));
            if ($minute < 5 && $hour <= 0 && $day <= 0)
                return true;
        }
        return false;
    }
    private function isAdminLogged($userID)
    {
        if ($this->admlog->getLastLogin($userID) == null || $this->admlog->getLastLogout($userID) == null) {
            return false;
        }
        $lastLogin = date_create($this->admlog->getLastLogin($userID));
        $lastLogout = date_create($this->admlog->getLastLogout($userID));
        $now = date_create();
        if ($lastLogin > $lastLogout) {
            $diff = date_diff($lastLogin, $now);
            $day = intval($diff->format('%R%d'));
            $hour = intval($diff->format('%R%h'));;
            $minute = intval($diff->format('%R%i'));
            if ($minute < 20 && $hour <= 0 && $day <= 0)
                return true;
        }
        return false;
    }

    public function login()
    {
        if ($this->request->getMethod() == 'post') {
            $session = session();
            $empID = strtolower($this->request->getPost('empID'));
            $password = $this->request->getPost('pass');
            $data = $this->customerModel->where(['empID' => $empID])->first();
            // dd($data);
            if ($data) {
                $pass = $data['password'];
                if ($pass == null) {
                    $verify_pass = ($password == '123456');
                } else {
                    $verify_pass = password_verify($password, $pass);
                }
                if ($verify_pass) {
                    if ($data['status'] != 0) {
                        $session->setFlashdata('error', '账号已被拉黑');
                        return redirect()->to('/login');
                    }

                    // if ($this->isLogged($empID)) {
                    //     $session->setFlashdata('error', '账号已经在别的设备登入！请稍后再登入');
                    //     return redirect()->to('/login');
                    // }

                    $ses_data = [
                        'cusID' => $data['cusID'],
                        'empID' => $empID,
                        'logged_in' => TRUE
                    ];
                    $session->set($ses_data);
                    $this->cuslog->insert([
                        'controller' => 'auth',
                        'method' => 'login',
                        'empID' => $empID,
                        'status' => 1,
                    ]);
                    $remember = $this->request->getPost('remember');

                    if ($remember) {
                        $cusid = base64_encode($data['cusID']);
                        $empid = hash('sha256', $data['empID']);
                        setcookie('cusid', $cusid, time() + 365 * 24 * 60 * 60, '/');
                        setcookie('key', $empid, time() + 365 * 24 * 60 * 60, '/');
                    }
                    return redirect()->to('/');
                } else {
                    $session->setFlashdata('error', '密码错误');
                    return redirect()->to('/login');
                }
            } else {
                $data = $this->user_model->where(['userID' => $empID, 'status' => 0])->first();

                if ($data) {
                    $pass = $data['password'];
                    $verify_pass = password_verify($password, $pass);
                    if ($verify_pass) {
                        $ses_data = [
                            'userID' => $data['userID'],
                            'name' => $data['name'],
                            'roleID' => $data['roleID'],
                            'admin_logged_in' => TRUE
                        ];
                        // if ($this->isAdminLogged($empID)) {
                        //     $session->setFlashdata('error', '账号已经在别的设备登入！请稍后再登入');
                        //     return redirect()->to('/login');
                        // }
                        $session->set($ses_data);
                        $this->admlog->insert([
                            'controller' => 'auth',
                            'method' => 'login',
                            'userID' => $empID,
                            'ip' => $this->request->getIPAddress(),
                            'status' => 1,
                        ]);
                        return redirect()->to('/admin');
                    } else {
                        $this->admlog->insert([
                            'controller' => 'auth',
                            'method' => 'login',
                            'userID' => $empID,
                            'ip' => $this->request->getIPAddress(),
                            'status' => 0,
                            'response' => 'wrong password'
                        ]);
                        $session->setFlashdata('error', '密码错误');
                        return redirect()->to('/login');
                    }
                } else {
                    $session->setFlashdata('error', '账号无效');
                    return redirect()->to('/login');
                }
            }
        }
    }

    public function logout()
    {
        $session = session();
        if ($session->get('empID') != null) {
            $this->cuslog->insert([
                'controller' => 'auth',
                'method' => 'logout',
                'empID' => $session->get('empID'),
                'status' => 1,
            ]);
        } elseif ($session->get('userID') != null) {
            $this->admlog->insert([
                'controller' => 'auth',
                'method' => 'logout',
                'userID' => $session->get('userID'),
                'ip' => $this->request->getIPAddress(),
                'status' => 1,
            ]);
        }
        $session->destroy();

        if (isset($_COOKIE['cusid'])) {
            setcookie('cusid', '', time() - 3600, '/');
            setcookie('key', '', time() - 3600, '/');
        }
        return redirect()->to('/login');
    }
}
