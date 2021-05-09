<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class RoleFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (!session()->get('admin_logged_in')) {
            session()->set('redirect_url', current_url());
            return redirect()->to('/login');
        }
        if (empty($arguments)) {
            return;
        }
        if (session()->get('admin_logged_in')) {
            $roleID = session()->get('roleID');
            if (in_array($roleID, $arguments)) {
                return;
            } else {
                return redirect()->to('/admin');
            }
        }
    }

    //--------------------------------------------------------------------

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}
