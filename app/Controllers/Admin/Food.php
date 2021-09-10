<?php

namespace App\Controllers\Admin;

use App\Models\Food_model;
use App\Controllers\BaseController;

class Food extends BaseController
{
    protected $foodModel;

    public function __construct()
    {
        $this->foodModel = new Food_model();
    }

    public function ordinary()
    {
        $data['rows'] = $this->foodModel->where('type', 'ordinary')
            ->findAll();
        $data['active']['food']['ordinary'] = true;
        return view('admin/food/v_food_main', $data);
    }

    public function special()
    {
        $data['rows'] = $this->foodModel->where('type', 'special')
            ->findAll();
        $data['active']['food']['special'] = true;
        return view('admin/food/v_food_main_s', $data);
    }

    public function add()
    {
        $data['title'] = '添加菜肴';
        $data['validation'] = \Config\Services::validation();
        $data['active']['food']['ordinary'] = true;
        return view('admin/food/v_food_add', $data);
    }

    public function add_s()
    {
        $data['title'] = '添加菜肴';
        $data['validation'] = \Config\Services::validation();
        $data['active']['food']['special'] = true;
        return view('admin/food/v_food_add_s', $data);
    }

    public function edit($id)
    {
        $id = base64_decode($id);
        if ($this->foodModel->find($id)) {
            $data['row'] = $this->foodModel->find($id);
            $data['validation'] = \Config\Services::validation();
            $data['active']['food']['ordinary'] = true;
            return view('admin/food/v_food_edit', $data);
        } else {
            return redirect()->to(base_url('/admin/food/ordinary'));
        }
    }
    public function edit_s($id)
    {
        $id = base64_decode($id);
        if ($this->foodModel->find($id)) {
            $data['row'] = $this->foodModel->find($id);
            $data['validation'] = \Config\Services::validation();
            $data['active']['food']['special'] = true;
            return view('admin/food/v_food_edit_s', $data);
        } else {
            return redirect()->to(base_url('/admin/food/special'));
        }
    }

    public function delete($type, $id)
    {
        $id = base64_decode($id);
        try {
            if ($this->foodModel->delete($id)) {
                $this->admlog->insert([
                    'controller' => 'food',
                    'method' => 'delete',
                    'userID' => session()->get('userID'),
                    'ip' => $this->request->getIPAddress(),
                    'status' => 1,
                    'data' => 'foodID = ' . $id
                ]);
                session()->setFlashdata('success', '删除成功 Berhasil menghapus');
                return redirect()->to(base_url('/admin/food/' . $type));
            }
        } catch (\Exception $e) {
            $this->admlog->insert([
                'controller' => 'food',
                'method' => 'delete',
                'userID' => session()->get('userID'),
                'ip' => $this->request->getIPAddress(),
                'status' => 0,
                'data' => 'foodID = ' .  $id,
                'response' => $e->getMessage()
            ]);
            session()->setFlashdata('error', '删除失败 Gagal menghapus! Error -> ' . $e->getMessage());
            return redirect()->to(base_url('/admin/food/' . $type));
        }
    }

    public function save()
    {
        if (!$this->validate([
            'foodID' => [
                'rules' => 'required|is_unique[food.foodID]',
                'errors' => [
                    'required' => '不允许为空 Tidak boleh kosong',
                    'is_unique' => '菜肴代码已使用过 Kode sudah pernah terpakai'
                ]
            ],
            'name' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '不允许为空 Tidak boleh kosong'
                ]
            ],
            'nameIND' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '不允许为空 Tidak boleh kosong'
                ]
            ],
            'price' => [
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => '不允许为空 Tidak boleh kosong',
                    'numeric' => '只允许整数 Hanya boleh angka'
                ]
            ],
            'photoURL' => [
                'rules' => 'is_image[photoURL]|mime_in[photoURL,image/jpg,image/jpeg,image/png]|max_size[photoURL,512]',
                'errors' => [
                    'is_image' => '上传文件不是照片 File unggahan bukanlah foto',
                    'mime_in' => '上传文件扩展名不是正常JPG/JPEG/PNG File unggahan tidak normal',
                    'max_size' => '照片大小不能超过512KB File unggahan tidak boleh melebihi 512KB'
                ]
            ]
        ])) {
            return redirect()->to(base_url('/admin/food/add'))->withInput();
        }

        if ($this->request->getMethod() == 'post') {
            try {
                $file = $this->request->getFile('photoURL');

                if ($file->getError() == 4) {
                    $filename = 'food_default.png';
                } else {
                    $filename = $this->request->getPost('foodID') . '.' . $file->getClientExtension();;
                    $file->move(FCPATH . 'img', $filename);
                }
                $data = [
                    'foodID' => $this->request->getPost('foodID'),
                    'name' => $this->request->getPost('name'),
                    'nameIND' => $this->request->getPost('nameIND'),
                    'price' => $this->request->getPost('price'),
                    'type' => 'ordinary',
                    'photoURL' => $filename
                ];
                if ($this->foodModel->insert($data)) {
                    $this->admlog->insert([
                        'controller' => 'food',
                        'method' => 'save',
                        'userID' => session()->get('userID'),
                        'ip' => $this->request->getIPAddress(),
                        'status' => 1,
                        'data' => json_encode($data)
                    ]);
                    session()->setFlashdata('success', '添加成功 Berhasil menambah');
                    return redirect()->to(base_url('/admin/food/ordinary'));
                }
            } catch (\Exception $e) {
                $this->admlog->insert([
                    'controller' => 'food',
                    'method' => 'save',
                    'userID' => session()->get('userID'),
                    'ip' => $this->request->getIPAddress(),
                    'status' => 0,
                    'data' => json_encode($data),
                    'response' => $e->getMessage()
                ]);
                session()->setFlashdata('error', '添加失败 Gagal menambah! Error -> ' . $e->getMessage());
                return redirect()->to(base_url('/admin/food/ordinary'));
                //die($e->getMessage());
            }
        }
    }
    public function save_s()
    {
        if (!$this->validate([
            'foodID' => [
                'rules' => 'required|is_unique[food.foodID]',
                'errors' => [
                    'required' => '不允许为空 Tidak boleh kosong',
                    'is_unique' => '菜肴代码已使用过 Kode sudah pernah terpakai'
                ]
            ],
            'name' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '不允许为空 Tidak boleh kosong'
                ]
            ],
            'nameIND' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '不允许为空 Tidak boleh kosong'
                ]
            ],
            'price' => [
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => '不允许为空 Tidak boleh kosong',
                    'numeric' => '只允许整数 Hanya boleh angka'
                ]
            ],
            'qty' => [
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => '不允许为空 Tidak boleh kosong',
                    'numeric' => '只允许整数 Hanya boleh angka'
                ]
            ],
            'photoURL' => [
                'rules' => 'is_image[photoURL]|mime_in[photoURL,image/jpg,image/jpeg,image/png]|max_size[photoURL,512]',
                'errors' => [
                    'is_image' => '上传文件不是照片 File unggahan bukanlah foto',
                    'mime_in' => '上传文件扩展名不是正常JPG/JPEG/PNG File unggahan tidak normal',
                    'max_size' => '照片大小不能超过512KB File unggahan tidak boleh melebihi 512KB'
                ]
            ]
        ])) {
            return redirect()->to(base_url('/admin/food/add_s'))->withInput();
        }

        if ($this->request->getMethod() == 'post') {
            try {
                $file = $this->request->getFile('photoURL');

                if ($file->getError() == 4) {
                    $filename = 'food_default.png';
                } else {
                    $filename = $this->request->getPost('foodID') . '.' . $file->getClientExtension();
                    $file->move(FCPATH . 'img', $filename);
                }
                $data = [
                    'foodID' => $this->request->getPost('foodID'),
                    'name' => $this->request->getPost('name'),
                    'nameIND' => $this->request->getPost('nameIND'),
                    'price' => $this->request->getPost('price'),
                    'qty' => $this->request->getPost('qty'),
                    'type' => 'special',
                    'photoURL' => $filename
                ];
                if ($this->foodModel->insert($data)) {
                    $this->admlog->insert([
                        'controller' => 'food',
                        'method' => 'save',
                        'userID' => session()->get('userID'),
                        'ip' => $this->request->getIPAddress(),
                        'status' => 1,
                        'data' => json_encode($data)
                    ]);
                    session()->setFlashdata('success', '添加成功 Berhasil menambah');
                    return redirect()->to(base_url('/admin/food/special'));
                }
            } catch (\Exception $e) {
                $this->admlog->insert([
                    'controller' => 'food',
                    'method' => 'save',
                    'userID' => session()->get('userID'),
                    'ip' => $this->request->getIPAddress(),
                    'status' => 0,
                    'data' => json_encode($data),
                    'response' => $e->getMessage()
                ]);
                session()->setFlashdata('error', '添加失败 Gagal menambah! Error -> ' . $e->getMessage());
                return redirect()->to(base_url('/admin/food/special'));
                //die($e->getMessage());
            }
        }
    }

    public function update()
    {
        $id = $this->request->getPost('foodID');
        if (!$this->validate([
            'foodID' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '不允许为空 Tidak boleh kosong'
                ]
            ],
            'name' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '不允许为空  Tidak boleh kosong'
                ]
            ],
            'nameIND' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '不允许为空  Tidak boleh kosong'
                ]
            ],
            'price' => [
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => '不允许为空  Tidak boleh kosong',
                    'numeric' => '只允许整数 Hanya boleh angka'
                ]
            ],
            'photoURL' => [
                'rules' => 'is_image[photoURL]|mime_in[photoURL,image/jpg,image/jpeg,image/png]|max_size[photoURL,512]',
                'errors' => [
                    'is_image' => '上传文件不是照片 File unggahan bukanlah foto',
                    'mime_in' => '上传文件扩展名不是正常JPG/JPEG/PNG File unggahan tidak normal',
                    'max_size' => '照片大小不能超过512KB File unggahan tidak boleh melebihi 512KB'
                ]
            ]
        ])) {
            $id = base64_encode($id);
            return redirect()->to(base_url('/admin/food/edit/' . $id))->withInput();
        }

        if ($this->request->getMethod() == 'post') {
            try {
                $file = $this->request->getFile('photoURL');

                if ($file->getError() == 4) {
                    $filename = false;
                } else {
                    $filename = $id . '.' . $file->getClientExtension();
                }
                $data = [
                    'name' => $this->request->getPost('name'),
                    'nameIND' => $this->request->getPost('nameIND'),
                    'price' => $this->request->getPost('price'),
                ];
                if ($filename != false) {
                    $data['photoURL'] = $filename;
                    $oldPhoto = $this->request->getPost('oldPhoto');
                    if ($oldPhoto != 'food_default.png') {
                        $photo = './img/' . $oldPhoto;
                        chmod($photo, 0777);
                        unlink($photo);
                        $file->move(FCPATH . 'img', $filename);
                    }
                }
                if ($this->foodModel->update($id, $data)) {
                    $this->admlog->insert([
                        'controller' => 'food',
                        'method' => 'update',
                        'userID' => session()->get('userID'),
                        'ip' => $this->request->getIPAddress(),
                        'status' => 1,
                        'data' => json_encode($data)
                    ]);
                    session()->setFlashdata('success', '编辑成功 Berhasil mengedit');
                    return redirect()->to(base_url('/admin/food/ordinary'));
                }
            } catch (\Exception $e) {
                $this->admlog->insert([
                    'controller' => 'food',
                    'method' => 'update',
                    'userID' => session()->get('userID'),
                    'ip' => $this->request->getIPAddress(),
                    'status' => 0,
                    'data' => json_encode($data),
                    'response' => $e->getMessage()
                ]);
                session()->setFlashdata('error', '编辑失败 Gagal mengedit! Error -> ' . $e->getMessage());
                return redirect()->to(base_url('/admin/food/ordinary'));
                //die($e->getMessage());
            }
        }
    }
    public function update_s()
    {
        $id = $this->request->getPost('foodID');
        if (!$this->validate([
            'foodID' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '不允许为空 Tidak boleh kosong'
                ]
            ],
            'name' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '不允许为空  Tidak boleh kosong'
                ]
            ],
            'nameIND' => [
                'rules' => 'required',
                'errors' => [
                    'required' => '不允许为空  Tidak boleh kosong'
                ]
            ],
            'price' => [
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => '不允许为空  Tidak boleh kosong',
                    'numeric' => '只允许整数 Hanya boleh angka'
                ]
            ],
            'qty' => [
                'rules' => 'required|numeric',
                'errors' => [
                    'required' => '不允许为空  Tidak boleh kosong',
                    'numeric' => '只允许整数 Hanya boleh angka'
                ]
            ],
            'photoURL' => [
                'rules' => 'is_image[photoURL]|mime_in[photoURL,image/jpg,image/jpeg,image/png]|max_size[photoURL,512]',
                'errors' => [
                    'is_image' => '上传文件不是照片 File unggahan bukanlah foto',
                    'mime_in' => '上传文件扩展名不是正常JPG/JPEG/PNG File unggahan tidak normal',
                    'max_size' => '照片大小不能超过512KB File unggahan tidak boleh melebihi 512KB'
                ]
            ]
        ])) {
            $id = base64_encode($id);
            return redirect()->to(base_url('/admin/food/edit_s/' . $id))->withInput();
        }

        if ($this->request->getMethod() == 'post') {
            try {
                $file = $this->request->getFile('photoURL');

                if ($file->getError() == 4) {
                    $filename = false;
                } else {
                    $filename = $id . '.' . $file->getClientExtension();
                }

                $data = [
                    'name' => $this->request->getPost('name'),
                    'nameIND' => $this->request->getPost('nameIND'),
                    'price' => $this->request->getPost('price'),
                    'qty' => $this->request->getPost('qty'),
                ];
                if ($filename != false) {
                    $data['photoURL'] = $filename;
                    $oldPhoto = $this->request->getPost('oldPhoto');
                    if ($oldPhoto != 'food_default.png') {
                        $photo = './img/' . $oldPhoto;
                        chmod($photo, 0777);
                        unlink($photo);
                        $file->move(FCPATH . 'img', $filename);
                    }
                }
                if ($this->foodModel->update($id, $data)) {
                    $this->admlog->insert([
                        'controller' => 'food',
                        'method' => 'update',
                        'userID' => session()->get('userID'),
                        'ip' => $this->request->getIPAddress(),
                        'status' => 1,
                        'data' => json_encode($data)
                    ]);
                    session()->setFlashdata('success', '编辑成功 Berhasil mengedit');
                    return redirect()->to(base_url('/admin/food/special'));
                }
            } catch (\Exception $e) {
                $this->admlog->insert([
                    'controller' => 'food',
                    'method' => 'update',
                    'userID' => session()->get('userID'),
                    'ip' => $this->request->getIPAddress(),
                    'status' => 0,
                    'data' => json_encode($data),
                    'response' => $e->getMessage()
                ]);
                session()->setFlashdata('error', '编辑失败 Gagal mengedit! Error -> ' . $e->getMessage());
                return redirect()->to(base_url('/admin/food/special'));
                //die($e->getMessage());
            }
        }
    }

    public function restore()
    {
        $data['rows'] = $this->foodModel->onlyDeleted()->findAll();
        $data['active']['food']['restore'] = true;
        return view('admin/food/v_food_restore', $data);
    }

    public function updatedeleted()
    {
        if ($this->request->getMethod() == 'post') {
            try {
                $id = $this->request->getPost('foodID');
                if ($this->foodModel->restore($id)) {
                    $this->admlog->insert([
                        'controller' => 'food',
                        'method' => 'restore',
                        'userID' => session()->get('userID'),
                        'ip' => $this->request->getIPAddress(),
                        'status' => 1,
                        'data' => 'foodID = ' . $id
                    ]);
                    session()->setFlashdata('success', '还原成功 Berhasil memulihkan');
                    return redirect()->to(base_url('/admin/food/restore'));
                }
            } catch (\Exception $e) {
                $this->admlog->insert([
                    'controller' => 'food',
                    'method' => 'restore',
                    'userID' => session()->get('userID'),
                    'ip' => $this->request->getIPAddress(),
                    'status' => 0,
                    'data' => 'foodID = ' . $id,
                    'response' => $e->getMessage()
                ]);
                session()->setFlashdata('error', '还原失败 Gagal memulihkan! Error -> ' . $e->getMessage());
                return redirect()->to(base_url('/admin/food/restore'));
                //die($e->getMessage());
            }
        }
    }
    public function switch()
    {
        if ($this->request->getMethod() == 'post') {
            $type = $this->request->getPost('type');
            $to = ($type == 'special') ? 'ordinary' : $to = 'special';
            try {
                $id = $this->request->getPost('foodID');
                if ($this->foodModel->update($id, ['type' => $type])) {
                    $this->admlog->insert([
                        'controller' => 'food',
                        'method' => 'switch',
                        'userID' => session()->get('userID'),
                        'ip' => $this->request->getIPAddress(),
                        'status' => 1,
                        'data' => 'foodID = ' . $id . ', type = ' . $type
                    ]);
                    session()->setFlashdata('success', '转换成功 Berhasil mengubah');
                    return redirect()->to(base_url('/admin/food/' . $to));
                }
            } catch (\Exception $e) {
                $this->admlog->insert([
                    'controller' => 'food',
                    'method' => 'switch',
                    'userID' => session()->get('userID'),
                    'ip' => $this->request->getIPAddress(),
                    'status' => 0,
                    'data' => 'foodID = ' . $id . ', type = ' . $type,
                    'response' => $e->getMessage()
                ]);
                session()->setFlashdata('error', '转换失败 Gagal mengubah! Error -> ' . $e->getMessage());
                return redirect()->to(base_url('/admin/food/' . $to));
                //die($e->getMessage());
            }
        }
    }

    public function export()
    {
        $data['active']['food']['export'] = true;
        return view('admin/food/v_food_export', $data);
    }

    public function query($type = null)
    {
        if ($type != null) {
            $result = $this->foodModel->where('type', $type)
                ->findAll();
        } else {
            $result = $this->foodModel->findAll();
        }
        $json = json_encode($result);
        return $json;
    }
}
