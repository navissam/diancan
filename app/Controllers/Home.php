<?php

namespace App\Controllers;

use App\Models\Food_model;
use App\Models\Orders_model;
use App\Models\Variables_model;
use App\Models\Customer_model;

class Home extends BaseController
{
	protected $orderModel, $varModel, $customerModel, $foodModel;

	public function __construct()
	{
		$this->orderModel = new Orders_model();
		$this->varModel = new Variables_model();
		$this->customerModel = new Customer_model();
		$this->foodModel = new Food_model();
	}
	public function index()
	{
		$cusID = session()->get('cusID');
		$customer = $this->customerModel->where(['cusID' => $cusID, 'status' => 0])->first();
		$data['customer'] = $customer;
		$data['announcement'] = $this->varModel->getAnnouncement();
		$data['beginTime'] = $this->varModel->getValue('beginTime');
		$data['endTime'] = $this->varModel->getValue('endTime');
		return view('customer/v_home.php', $data);
	}
	public function first()
	{
		$empID = session()->get('empID');
		$customer = $this->customerModel->where(['empID' => $empID])->first();
		$data['row'] = $customer;
		$data['validation'] = \Config\Services::validation();
		return view('customer/v_first.php', $data);
	}

	public function update()
	{
		try {
			$unique = '|is_unique[customer.phoneNum]';
			if (!$this->validate([
				'roomNum' => [
					'rules' => 'required',
					'errors' => [
						'required' => '不允许为空'
					]
				],
				'phoneNum' => [
					'rules' => 'required|numeric' . $unique,
					'errors' => [
						'required' => '不允许为空',
						'numeric' => '只允许数字',
						'is_unique' => '电话号已有人注册'
					]
				],
				'region' => [
					'rules' => 'required',
					'errors' => [
						'required' => '不允许为空'
					]
				]
			])) {
				return redirect()->to(base_url('/first'))->withInput();
			}

			if ($this->request->getMethod() == 'post') {
				$data = [
					'roomNum' => $this->request->getPost('roomNum'),
					'phoneNum' => $this->request->getPost('phoneNum'),
					'region' => $this->request->getPost('region'),
				];
				$empID = session()->get('empID');
				$query = $this->customerModel->where('empID', $empID)
					->set($data)
					->update();
				if ($query) {
					if (!session()->has('logged_in')) {
						$customer = $this->customerModel->where(['empID' => $empID])->first();
						session()->remove(['registered', 'empID']);
						session()->set([
							'logged_in' => true,
							'cusID' => $customer['cusID'],
							'empID' => $empID
						]);
						$this->cuslog->insert([
							'controller' => 'auth',
							'method' => 'first',
							'empID' => $empID,
							'status' => 1,
						]);
					}
					return redirect()->to(base_url('/'));
				} else {
					session()->setFlashdata('error', '资料编辑失败');
					return redirect()->to(base_url('/first'));
				}
			}
		} catch (\Exception $e) {
			session()->setFlashdata('error', '资料编辑失败！ 失误信息：' . $e->getMessage());
			return redirect()->to(base_url('/first'));
			//die($e->getMessage());
		}
	}

	public function any()
	{
		return redirect()->to('/');
	}
}
