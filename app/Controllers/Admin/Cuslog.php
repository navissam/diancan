<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Cuslog_model;

class Cuslog extends BaseController
{
    protected $cuslog_model;
    public function __construct()
    {
        $this->cuslog_model = new Cuslog_model();
    }

    public function index()
    {
        $data['active']['syslog']['cuslog'] = true;
        $data['ctrl'] = $this->cuslog_model->getController();
        return view('admin/syslog/v_cuslog_index', $data);
    }


    public function getAll()
    {
        return json_encode($this->cuslog_model->getAll());
    }

    public function getByFilter($start, $finish, $controller, $method, $status)
    {
        return json_encode($this->cuslog_model->getByFilter($start, $finish, $controller, $method, $status));
    }

    public function getMethod($ctrl)
    {
        return json_encode($this->cuslog_model->getMethod($ctrl));
    }
}
