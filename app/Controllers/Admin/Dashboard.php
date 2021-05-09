<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Orders_model;

class Dashboard extends BaseController
{
    public function index()
    {
        if (!session()->get('admin_logged_in'))
            return redirect()->to('/login');
        $orders_model = new Orders_model();
        $data['chart_orders'] = $orders_model->getOrdersCountGroupByRegion();
        // dd($data);
        return view('templates/dashboard', $data);
    }
}
