<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Admlog_model;

class Admlog extends BaseController
{
    protected $admlog_model;
    public function __construct()
    {
        $this->admlog_model = new Admlog_model();
    }

    public function index()
    {
        $data['active']['syslog']['admlog'] = true;
        $data['ctrl'] = $this->admlog_model->getController();
        return view('admin/syslog/v_admlog_index', $data);
    }

    public function getAll()
    {
        return json_encode($this->admlog_model->getAll());
    }

    public function getByFilter($start, $f, $controller, $method, $status)
    {
        $date = date_create($f);
        date_modify($date, "+1 days");
        $finish = date_format($date, "Y-m-d");
        return json_encode($this->admlog_model->getByFilter($start, $finish, $controller, $method, $status));
    }

    public function getMethod($ctrl)
    {
        return json_encode($this->admlog_model->getMethod($ctrl));
    }
}
