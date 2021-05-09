<?php

namespace App\Controllers\Admin;

use App\Models\Food_model;
use App\Models\Orders_model;
use App\Controllers\BaseController;

class Report extends BaseController
{
    protected $food_model, $orders_model;
    public function __construct()
    {
        $this->food_model = new Food_model();
        $this->orders_model = new Orders_model();
    }

    // public function food($list = false, $date = false)
    // {
    //     if (!$list || !$date) {
    //         return view('admin/report/v_food_main');
    //     } else if ($list == 'original') {
    //         $data['rows'] = $this->food_model->findAll();
    //         return view('/admin/report/r_food_original', $data);
    //     } else if ($list == 'publish') {
    //         $data['rows'] = $this->food_model->PublishRow($date);
    //         $data['date'] = $date;      
    //         return view('/admin/report/r_food_publish', $data);
    //     }
    // }
    public function income()
    {
        $data['active']['report']['income'] = true;
        return view('admin/report/v_income', $data);
    }

    public function income_query($begin, $end, $type, $region)
    {
        if ($begin != null && $end != null && $type != null && $region != null) {
            $result = $this->orders_model->getIncome($begin, $end, $type, $region);
            $json = json_encode($result);
            return $json;
        } else {
            return null;
        }
    }
    public function income_export($begin, $end, $type, $region)
    {
        if ($begin != null && $end != null && $type != null && $region != null) {
            $result = $this->orders_model->expIncome($begin, $end, $type, $region);
            $json = json_encode($result);
            return $json;
        } else {
            return null;
        }
    }
    public function delivery_query($begin, $end, $region)
    {
        if ($begin != null && $end != null && $region != null) {
            $result = $this->orders_model->getDelivery($begin, $end, $region);
            $json = json_encode($result);
            return $json;
        } else {
            return null;
        }
    }

    public function orders($by = false, $region = false, $date = false)
    {
        if (!$by || !$region || !$date) {
            return view('admin/report/v_orders_main');
        } else if ($by == 'orders') {
            $data['rows'] = $this->orders_model->getOrdersHistoryByOrder($date, $region);
            $data['date'] = $date;
            $data['region'] = $region;
            return view('/admin/report/r_history_by_orders', $data);
        } else if ($by == 'food') {
            $data['rows'] = $this->orders_model->getOrdersHistoryByFood($date, $region);
            $data['date'] = $date;
            $data['region'] = $region;
            return view('/admin/report/r_history_by_food', $data);
        }
    }
    // public function summary($by = false, $region = false, $date = false)
    // {
    //     if (!$by || !$region || !$date) {
    //         return view('admin/report/v_summary_main');
    //     }
    //     if ($by == 'daily-orders') {
    //         $data['rows'] = $this->orders_model->getOrdersHistoryByOrder($date, $region);
    //         $data['date'] = $date;
    //         $data['region'] = $region;
    //         return view('/admin/report/r_summary_by_dialy_orders', $data);
    //     }
    //     if ($by == 'daily-food') {
    //         $data['rows'] = $this->orders_model->getOrdersHistoryByFood($date, $region);
    //         $data['date'] = $date;
    //         $data['region'] = $region;
    //         return view('/admin/report/r_summary_by_dialy_food', $data);
    //     }
    //     if ($by == 'monthly-food') {
    //         $data['rows'] = $this->orders_model->getOrdersMonthlyByFood($date, $region);
    //         $data['date'] = $date;
    //         $data['region'] = $region;
    //         return view('/admin/report/r_summary_by_monthly_food', $data);
    //     }
    //     if ($by == 'monthly-orders') {
    //         $data['rows'] = $this->orders_model->getOrdersMonthlyByOrder($date, $region);
    //         $data['date'] = $date;
    //         $data['region'] = $region;
    //         return view('/admin/report/r_summary_by_monthly_orders', $data);
    //     }
    //     if ($by == 'yearly-orders') {
    //         $data['rows'] = $this->orders_model->getOrdersYearlyByOrder($date, $region);
    //         $data['date'] = $date;
    //         $data['region'] = $region;
    //         return view('/admin/report/r_summary_by_yearly_orders', $data);
    //     }
    //     if ($by == 'yearly-food') {
    //         $data['rows'] = $this->orders_model->getOrdersYearlyByFood($date, $region);
    //         $data['date'] = $date;
    //         $data['region'] = $region;
    //         return view('/admin/report/r_summary_by_yearly_food', $data);
    //     }
    // }

    // public function route()
    // {
    //     if ($this->request->getMethod() == 'post') {
    //         if ($this->request->getPost('report') == 'food') {
    //             $list = $this->request->getPost('list');
    //             $date = $this->request->getPost('date');
    //             return redirect()->to('/admin/report/food/' . $list . '/' . $date);
    //         }
    //         if ($this->request->getPost('report') == 'order') {
    //             $by = $this->request->getPost('by');
    //             $region = $this->request->getPost('region');
    //             $date = $this->request->getPost('date');
    //             return redirect()->to('/admin/report/orders/' . $by . '/' . $region . '/' . $date);
    //         }
    //         if ($this->request->getPost('report') == 'summary') {
    //             $by = $this->request->getPost('by');
    //             $region = $this->request->getPost('region');
    //             $date = $this->request->getPost('date');
    //             return redirect()->to('/admin/report/summary/' . $by . '/' . $region . '/' . $date);
    //         }
    //     }
    // }
}
