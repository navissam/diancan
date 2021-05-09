<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Variables_model;



class Variable extends BaseController
{
    protected $varModel;

    public function __construct()
    {
        $this->varModel = new Variables_model();
    }

    public function changeTimeLimit()
    {
        $data['beginTime'] = $this->varModel->getValue('beginTime');
        $data['endTime'] = $this->varModel->getValue('endTime');
        $data['active']['var']['time'] = true;
        return view('admin/variables/v_change_timelimit', $data);
    }
    public function updateTimeLimit()
    {
        if ($this->request->getMethod() == 'post') {
            try {
                $beginTime = $this->request->getPost('beginTime');
                $endTime = $this->request->getPost('endTime');
                $update = $this->varModel->update('beginTime', ['varValue' => $beginTime]) && $this->varModel->update('endTime', ['varValue' => $endTime]);
                if ($update) {
                    $this->admlog->insert([
                        'controller' => 'variable',
                        'method' => 'update',
                        'userID' => session()->get('userID'),
                        'ip' => $this->request->getIPAddress(),
                        'status' => 1,
                        'data' => 'orderTimeLimit = ' . $beginTime . '-' . $endTime
                    ]);
                    session()->setFlashdata('success', '更新成功');
                    return redirect()->to(base_url('/admin/variable/changetimelimit'));
                }
            } catch (\Exception $e) {
                $this->admlog->insert([
                    'controller' => 'variable',
                    'method' => 'update',
                    'userID' => session()->get('userID'),
                    'ip' => $this->request->getIPAddress(),
                    'status' => 0,
                    'data' => 'orderTimeLimit = ' . $beginTime . '-' . $endTime,
                    'response' => $e->getMessage()
                ]);
                session()->setFlashdata('error', '更新失败！ 失误信息：' . $e->getMessage());
                return redirect()->to(base_url('/admin/variable/changetimelimit'));
            }
        }
    }
    public function changeDeliveryCost()
    {
        $data['deliveryCost'] = $this->varModel->getValue('deliveryCost');
        $data['active']['var']['dCost'] = true;
        return view('admin/variables/v_change_deliverycost', $data);
    }
    public function updateDeliveryCost()
    {
        try {
            if ($this->request->getMethod() == 'post') {
                $deliveryCost = $this->request->getPost('deliveryCost');
                if ($this->varModel->update('deliveryCost', ['varValue' => $deliveryCost])) {
                    $this->admlog->insert([
                        'controller' => 'variable',
                        'method' => 'update',
                        'userID' => session()->get('userID'),
                        'ip' => $this->request->getIPAddress(),
                        'status' => 1,
                        'data' => 'deliveryCost = ' . $deliveryCost
                    ]);
                    session()->setFlashdata('success', '更新成功 Berhasil diperbaharui!');
                    return redirect()->to(base_url('/admin/variable/changedeliverycost'));
                }
            }
        } catch (\Exception $e) {
            $this->admlog->insert([
                'controller' => 'variable',
                'method' => 'update',
                'userID' => session()->get('userID'),
                'ip' => $this->request->getIPAddress(),
                'status' => 0,
                'data' => 'deliveryCost = ' . $deliveryCost,
                'response' => $e->getMessage()
            ]);
            session()->setFlashdata('error', '更新失败 Gagal diperbaharui！ Error -> ' . $e->getMessage());
            return redirect()->to(base_url('/admin/variable/changedeliverycost'));
        }
    }
    public function announcement()
    {
        $data['announcement'] = $this->varModel->getAnnouncement();
        $data['active']['var']['announcement'] = true;
        return view('admin/variables/v_edit_announcement', $data);
    }
    public function updateannounce()
    {
        try {
            if ($this->request->getMethod() == 'post') {
                $content = $this->request->getPost('content');
                if ($this->varModel->updateAnnouncement($content)) {
                    $this->admlog->insert([
                        'controller' => 'variable',
                        'method' => 'update',
                        'userID' => session()->get('userID'),
                        'ip' => $this->request->getIPAddress(),
                        'data' => 'save announcement',
                        'status' => 1,
                    ]);
                    session()->setFlashdata('success', '更新成功 Berhasil diperbaharui!');
                    return redirect()->to(base_url('/admin/variable/announcement'));
                }
            }
        } catch (\Exception $e) {
            $this->admlog->insert([
                'controller' => 'variable',
                'method' => 'update',
                'userID' => session()->get('userID'),
                'ip' => $this->request->getIPAddress(),
                'status' => 0,
                'data' => 'save announcement',
                'response' => $e->getMessage()
            ]);
            session()->setFlashdata('error', '更新失败 Gagal diperbaharui！ Error -> ' . $e->getMessage());
            return redirect()->to(base_url('/admin/variable/announcement'));
        }
    }
    public function cancelannounce()
    {
        try {
            if ($this->request->getMethod() == 'post') {
                if ($this->varModel->cancelAnnouncement()) {
                    $this->admlog->insert([
                        'controller' => 'variable',
                        'method' => 'update',
                        'userID' => session()->get('userID'),
                        'ip' => $this->request->getIPAddress(),
                        'data' => 'cancel announcement',
                        'status' => 1,
                    ]);
                    session()->setFlashdata('success', '撤销成功 Berhasil dibatalkan!');
                    return redirect()->to(base_url('/admin/variable/announcement'));
                }
            }
        } catch (\Exception $e) {
            $this->admlog->insert([
                'controller' => 'variable',
                'method' => 'update',
                'userID' => session()->get('userID'),
                'ip' => $this->request->getIPAddress(),
                'status' => 0,
                'data' => 'cancel announcement',
                'response' => $e->getMessage()
            ]);
            session()->setFlashdata('error', '撤销失败 Gagal dibatalkan！ Error -> ' . $e->getMessage());
            return redirect()->to(base_url('/admin/variable/announcement'));
        }
    }

    public function publishannounce()
    {
        try {
            if ($this->request->getMethod() == 'post') {
                if ($this->varModel->publishAnnouncement()) {
                    $this->admlog->insert([
                        'controller' => 'variable',
                        'method' => 'update',
                        'userID' => session()->get('userID'),
                        'ip' => $this->request->getIPAddress(),
                        'data' => 'publish announcement',
                        'status' => 1,
                    ]);
                    session()->setFlashdata('success', '发布成功 Berhasil dipublikasi!');
                    return redirect()->to(base_url('/admin/variable/announcement'));
                }
            }
        } catch (\Exception $e) {
            $this->admlog->insert([
                'controller' => 'variable',
                'method' => 'update',
                'userID' => session()->get('userID'),
                'ip' => $this->request->getIPAddress(),
                'status' => 0,
                'data' => 'publish announcement',
                'response' => $e->getMessage()
            ]);
            session()->setFlashdata('error', '发布失败 Gagal dipublikasi！ Error -> ' . $e->getMessage());
            return redirect()->to(base_url('/admin/variable/announcement'));
        }
    }
}
