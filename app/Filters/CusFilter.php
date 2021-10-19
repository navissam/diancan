<?php

namespace App\Filters;

use App\Models\Cuslog_model;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use App\Models\Customer_model;

class CusFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (!(session()->get('logged_in'))) {
            if (isset($_COOKIE["cusid"]) && isset($_COOKIE["key"])) {
                $cusid = base64_decode($_COOKIE["cusid"]);
                $model = new Customer_model();
                $data = $model->find($cusid);
                if ($data == null) {
                    return redirect()->to('/login');
                }
                if (hash('sha256', $data['empID']) !== $_COOKIE["key"]) {
                    return redirect()->to('/login');
                }
                if ($data['status'] != 0) {
                    session()->setFlashdata('error', '账号已被拉黑');
                    return redirect()->to('/login');
                }

                $ses_data = [
                    'cusID' => $data['cusID'],
                    'empID' => $data['empID'],
                    'logged_in' => TRUE
                ];
                session()->set($ses_data);
                $cuslog = new Cuslog_model();
                $cuslog->insert([
                    'controller' => 'auth',
                    'method' => 'login',
                    'empID' => $data['empID'],
                    'status' => 1,
                ]);
                return;
            }
        }

        if (session()->get('logged_in')) {
            $model = new Customer_model();
            $data = $model->find(session()->get('cusID'));
            if ($data['status'] != 0) {
                session()->destroy();
                if (isset($_COOKIE['cusid'])) {
                    setcookie('cusid', '', time() - 3600, '/');
                    setcookie('key', '', time() - 3600, '/');
                }
                session()->setFlashdata('error', '账号已被拉黑');
                return redirect()->to('/login');
            }
            if ($data['roomNum'] == null || $data['phoneNum'] == null || $data['region'] == null) {
                return redirect()->to('/first');
            }
            return;
        }
        if (session()->get('admin_logged_in')) {
            return redirect()->to('/admin');
        }
        if (session()->get('registered')) {
            return redirect()->to('/first');;
        }
        return redirect()->to('/login');
    }

    //--------------------------------------------------------------------

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}
