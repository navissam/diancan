<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use App\Models\Customer_model;

class RegisterFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (session()->get('logged_in')) {
            $model = new Customer_model();
            $data = $model->find(session()->get('cusID'));
            if ($data['roomNum'] == null || $data['phoneNum'] = null || $data['region'] == null) {
                session()->remove('logged_in');
                session()->set(['registered' => true]);
                return;
            }
            return redirect()->to('/');;
        }
        if (session()->get('registered')) {
            return;
        }
        if (session()->get('admin_logged_in')) {
            return redirect()->to('/admin');
        }
        return redirect()->to('/login');
    }

    //--------------------------------------------------------------------

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}
