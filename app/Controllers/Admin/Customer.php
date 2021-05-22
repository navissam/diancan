<?php

namespace App\Controllers\admin;

use App\Controllers\BaseController;
use App\Models\Customer_model;

class Customer extends BaseController
{
    protected $customerModel;
    public function __construct()
    {
        $this->customerModel = new Customer_model();
    }

    public function index()
    {
        $data['validation'] = \Config\Services::validation();
        $data['active']['customer'] = true;
        return view('admin/customer/v_customer_search', $data);
    }

    public function result()
    {
        if ($this->request->getMethod() == 'post') {
            $key = $this->request->getPost('key');
            $data['rows'] = $this->customerModel->search($key);
            $data['key'] = $key;
            $data['active']['customer'] = true;
            return view('admin/customer/v_customer_result', $data);
        }
    }

    public function block()
    {
        if ($this->request->getMethod() == 'post') {
            try {
                $cusID = $this->request->getPost('cusID');
                if ($this->customerModel->update($cusID, ['status' => 1])) {
                    $this->admlog->insert([
                        'controller' => 'customer',
                        'method' => 'block',
                        'userID' => session()->get('userID'),
                        'ip' => $this->request->getIPAddress(),
                        'status' => 1,
                        'data' => 'cusID = ' . $cusID
                    ]);
                    session()->setFlashdata('success', '拉黑成功 Berhasil Diblockir');
                    return redirect()->to(base_url('/admin/customer'));
                }
            } catch (\Exception $e) {
                $this->admlog->insert([
                    'controller' => 'customer',
                    'method' => 'block',
                    'userID' => session()->get('userID'),
                    'ip' => $this->request->getIPAddress(),
                    'status' => 0,
                    'data' => 'cusID = ' . $cusID,
                    'response' => $e->getMessage()
                ]);
                session()->setFlashdata('error', '拉黑失败 Gagal blockir！ Error -> ' . $e->getMessage());
                return redirect()->to(base_url('/admin/customer'));
            }
        }
    }

    public function restore()
    {
        try {
            if ($this->request->getMethod() == 'post') {
                $cusID = $this->request->getPost('cusID');
                if ($this->customerModel->update($cusID, ['status' => 0])) {
                    $this->admlog->insert([
                        'controller' => 'customer',
                        'method' => 'restore',
                        'userID' => session()->get('userID'),
                        'ip' => $this->request->getIPAddress(),
                        'status' => 1,
                        'data' => 'cusID = ' . $cusID
                    ]);
                    session()->setFlashdata('success', '复原成功 Berhasil dipulihkan');
                    return redirect()->to(base_url('/admin/customer'));
                }
            }
        } catch (\Exception $e) {
            $this->admlog->insert([
                'controller' => 'customer',
                'method' => 'restore',
                'userID' => session()->get('userID'),
                'ip' => $this->request->getIPAddress(),
                'status' => 0,
                'data' => 'cusID = ' . $cusID,
                'response' => $e->getMessage()
            ]);
            session()->setFlashdata('error', '复原失败 Gagal pulihkan！ Error -> ' . $e->getMessage());
            return redirect()->to(base_url('/admin/customer'));
        }
    }
    public function resetpass()
    {
        try {
            if ($this->request->getMethod() == 'post') {
                $cusID = $this->request->getPost('cusID');
                if ($this->customerModel->update($cusID, ['password' => null])) {
                    $this->admlog->insert([
                        'controller' => 'customer',
                        'method' => 'resetpass',
                        'userID' => session()->get('userID'),
                        'ip' => $this->request->getIPAddress(),
                        'status' => 1,
                        'data' => 'cusID = ' . $cusID
                    ]);
                    session()->setFlashdata('success', '重置密码成功 Password berhasil direset');
                    return redirect()->to(base_url('/admin/customer'));
                }
            }
        } catch (\Exception $e) {
            $this->admlog->insert([
                'controller' => 'customer',
                'method' => 'resetpass',
                'userID' => session()->get('userID'),
                'ip' => $this->request->getIPAddress(),
                'status' => 0,
                'data' => 'cusID = ' . $cusID,
                'response' => $e->getMessage()
            ]);
            session()->setFlashdata('error', '复原失败 Gagal pulihkan！ Error -> ' . $e->getMessage());
            return redirect()->to(base_url('/admin/customer'));
        }
    }
    public function upload()
    {
        $validation = \Config\Services::validation();

        $valid = $this->validate(
            [
                'fileImport' => [
                    'label' => 'Customer',
                    'rules' => 'uploaded[fileImport]|ext_in[fileImport,xls,xlsx]',
                    'errors' => [
                        'uploaded' => '选择文件 Pilih File terlebih dahulu',
                        'ext_in' => '文件必需 .xls OR .xlsx'
                    ]
                ]
            ]
        );
        if (!$valid) {
            $error = [
                'error2' => $validation->getError('fileImport'),
            ];

            session()->setFlashdata($error, '上载失败 Gagal mengupload');
            // return redirect()->to('/import');
            return redirect()->to(base_url('/admin/customer'));
        } else {
            $file_excel = $this->request->getFile('fileImport');
            $ext = $file_excel->getClientExtension();
            if ($ext == 'xls') {
                $render = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
            } else {
                $render = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            }
            $spreadsheet = $render->load($file_excel);
            $data = $spreadsheet->getActiveSheet()->toArray();
            // dd($data);

            $gagal = 0;
            $sukses = 0;
            $datagagal = [];
            $datasukses = [];
            $baru = [];
            $lama = [];
            foreach ($data as $d => $row) {
                // dd($row);
                if ($d == 0) {
                    if ($row[0] == "工号 NIK" && $row[1] == "姓名 Nama") {
                        continue;
                    } else {
                        session()->setFlashdata('error2', '范本不合适 Template tidak cocok');
                        return redirect()->to(base_url('/admin/customer'));
                    }
                }
                $name = $row[0];
                $empID = $row[1];

                $db = \Config\Database::connect();

                $cekempID = $db->table('customer')->getWhere(['empID' => $empID])->getResult();

                if (is_null($name) || is_null($empID)) {
                    continue;
                } elseif (count($cekempID) > 0) {
                    $gagal++;
                    $lama['name'] = $name;
                    $lama['empID'] = $empID;
                    array_push($datagagal, $lama);

                    // session()->setFlashdata('error', '工号 ID ' . $empID . ' 已经注册 telah terdaftar');

                } else {
                    $sukses++;
                    $baru['name'] = $name;
                    $baru['empID'] = $empID;
                    array_push($datasukses, $baru);
                    // $simpan = [
                    //     'name' => $name, 'empID' => $empID
                    // ];

                    // $db->table('customer')->insert($simpan);
                }
            }
            // dd($datasukses, $datagagal);
            if ($sukses > 0) {
                try {
                    $db->table('customer')->insertBatch($datasukses);
                } catch (\Exception $e) {
                    $this->admlog->insert([
                        'controller' => 'customer',
                        'method' => 'upload',
                        'userID' => session()->get('userID'),
                        'ip' => $this->request->getIPAddress(),
                        'status' => 0,
                        'data' => 'empID = ' . $empID,
                        'response' => $e->getMessage()
                    ]);
                    session()->setFlashdata('error2', '上载失败 Gagal ！ Error -> ' . $e->getMessage());
                    return redirect()->to(base_url('/admin/customer'));
                }
            } else {
                session()->setFlashdata('error2', '员工名单已导入过， Daftar pelanggan sudah pernah diupload');
                return redirect()->to(base_url('/admin/customer'));
            }
            if ($gagal == 0) {
                // session()->setFlashdata('success', $sukses . ' Data Berhasil di Import, ' . $gagal . ' Data Gagal di Import');
                session()->setFlashdata('success2', '上载成功 Berhasil mengupload');
                return redirect()->to(base_url('/admin/customer'));
            } else {
                $data = [
                    'datagagal' => $datagagal
                ];
                // dd($data);
                $data['active']['customer'] = true;
                return view('/admin/customer/v_customer_double', $data);
            }
        }
    }
    public function download()
    {
        return $this->response->download('download/Customer.xlsx', NULL);
        return redirect()->to(base_url('/admin/customer'));
    }

    public function save()
    {
        // $validation = \Config\Services::validation();

        if (!$this->validate(
            [
                'name' => [
                    'rules' => 'required',
                    'errors' => [
                        'required' => '不允许为空 Tidak boleh kosong'
                    ]
                ],
                'empID' => [
                    'rules' => 'required|is_unique[customer.empID]',
                    'errors' => [
                        'required' => '不允许为空 Tidak boleh kosong',
                        'is_unique' => '工号已注册过 NIK sudah pernah didaftar'
                    ]
                ]
            ]
        )) {
            // dd($error);

            // session()->setFlashdata('$error', '添加失败 Gagal menambah');
            return redirect()->to(base_url('/admin/customer/'))->withInput();
        }


        if ($this->request->getMethod() == 'post') {
            $this->customerModel->save([
                'name' => $this->request->getPost('name'),
                'empID' => $this->request->getPost('empID')
            ]);

            session()->setFlashdata('success', '添加成功 Berhasil ditambah');
            return redirect()->to(base_url('/admin/customer'));
        } else {
            // if (is_null($name) || is_null($empID)) {
            session()->setFlashdata('error', '添加失败 Gagal ditambah');
            return redirect()->to(base_url('/admin/customer'));
            // }
        }
    }
}
