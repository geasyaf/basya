<?php

namespace App\Controllers;

use App\Models\Group_Users_Model;
use App\Models\Menu_Model;
use App\Models\Menu_Role_Model;
use App\Models\Users_Model;

class User_managements extends BaseController
{
    protected $menuModel;
    protected $userModel;
    protected $groupModel;
    protected $menuRoleModel;
    
    public function __construct()
    {
        $this->menuModel = new Menu_Model();
        $this->userModel = new Users_Model();
        $this->groupModel = new Group_Users_Model();
        $this->menuRoleModel = new Menu_Role_Model();
        $this->session = session();
    }

    public function index()
    {
        $id_user = $this->session->get('id_user');
        if ($id_user) {
            $menu_detail = $this->menuModel->getByData(['nav_act' => 'user_managements']);
            $menu_role = $this->menuRoleModel->getByData(['id_menu' => $menu_detail->id, 'group_level' => $this->session->get('group_level')]);
            $data['data_menu'] = $this->menuModel->getMenu();
            $data['menu'] = ['cek_main' => 'system_setting', 'cek_page' => 'user_managements'];
            $data['title'] = 'User Managements';
            if ($menu_role->read_act == 'Y') {
                $data['content'] = 'user_managements/user_managements';
                $data['content_foot'] = 'user_managements/user_managements_foot';
            } else {
                $data['content'] = 'layout/error_page';
                $data['content_foot'] = '';
            }
            return view('layout/wrapper', $data);
        } else {
            return redirect()->to(base_url('login'));
        }
    }

    public function listData()
    {
        $list = $this->userModel->listData();
        $data = [];
        $no = 0;
        foreach ($list as $value) {
            $no++;
            $row = [];
            $row[] = $no;
            $row[] = '<a href="/upload/foto_user/' . $value->foto_user . '" target="_blank"><img src="/upload/foto_user/' . $value->foto_user . '" width="50"></a>';
            $row[] = $value->full_name;
            $row[] = $value->username;
            $row[] = $value->email;
            $row[] = $value->group_level;
            $row[] = $value->last_login;
            $row[] = $value->created;
            if ($value->aktif == 'Y') {
                $row[] = '<button type="button" class="btn btn-success btn-xs" title="status" onclick="changeStatus(' . "'" . $value->id . "'" . ')"><i class="fas fa-check"></i> aktif</button>';
            } else {
                $row[] = '<button type="button" class="btn btn-warning btn-xs" title="status" onclick="changeStatus(' . "'" . $value->id . "'" . ')"><i class="fas fa-times"></i> tidak aktif</button>';
            }
            $row[] = $value->id;
            $data[] = $row;
        }

        $output = array(
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function addData()
    {
        $id_user = $this->session->get('id_user');
        if ($id_user) {
            $data['group_level'] = $this->groupModel->findAll();

            $menu_detail = $this->menuModel->getByData(['nav_act' => 'user_managements']);
            $menu_role = $this->menuRoleModel->getByData(['id_menu' => $menu_detail->id, 'group_level' => $this->session->get('group_level')]);
            $data['data_menu'] = $this->menuModel->getMenu();
            $data['menu'] = ['cek_main' => 'system_setting', 'cek_page' => 'user_managements'];
            $data['title'] = 'User Managements Add';
            if ($menu_role->insert_act == 'Y') {
                $data['content'] = 'user_managements/user_managements_add';
                $data['content_foot'] = 'user_managements/user_managements_foot';
            } else {
                $data['content'] = 'layout/error_page';
                $data['content_foot'] = '';
            }
            return view('layout/wrapper', $data);
        } else {
            return redirect()->to(base_url('login'));
        }
    }

    public function editData($id)
    {
        $id_user = $this->session->get('id_user');
        if ($id_user) {
            $data['data_edit'] = $this->userModel->getByData(['id' => $id]);
            $data['group_level'] = $this->groupModel->findAll();

            $menu_detail = $this->menuModel->getByData(['nav_act' => 'user_managements']);
            $menu_role = $this->menuRoleModel->getByData(['id_menu' => $menu_detail->id, 'group_level' => $this->session->get('group_level')]);
            $data['data_menu'] = $this->menuModel->getMenu();
            $data['menu'] = ['cek_main' => 'system_setting', 'cek_page' => 'user_managements'];
            $data['title'] = 'User Managements Edit';
            if ($menu_role->update_act == 'Y') {
                $data['content'] = 'user_managements/user_managements_edit';
                $data['content_foot'] = 'user_managements/user_managements_foot';
            } else {
                $data['content'] = 'layout/error_page';
                $data['content_foot'] = '';
            }
            return view('layout/wrapper', $data);
        } else {
            return redirect()->to(base_url('login'));
        }
    }

    public function saveData($method)
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->_validate($method);
        switch ($method) {
            case 'add':
                $foto_user = $this->request->getFile('foto_user');
                if ($foto_user == '') {
                    $file_name = 'default.png';
                } else {
                    $file_name = $foto_user->getRandomName();
                    $foto_user->move('upload/foto_user', $file_name);
                }

                if ($this->request->getPost('aktif') == 'on') {
                    $aktif = 'Y';
                } else {
                    $aktif = 'N';
                }

                $this->userModel->save([
                    'full_name' => $this->request->getPost('full_name'),
                    'username' => $this->request->getPost('username'),
                    'password' => password_hash($this->request->getPost('password'), PASSWORD_BCRYPT),
                    'email' => $this->request->getPost('email'),
                    'foto_user' => $file_name,
                    'group_level' => $this->request->getPost('group_level'),
                    'aktif' =>  $aktif,
                    'created_by' =>  $this->session->get('id_user'),
                ]);
                echo json_encode(["status" => true]);
                break;
            case 'edit':
                $foto_user = $this->request->getFile('foto_user');
                if ($foto_user == '') {
                    $file_name = $this->request->getPost('old_foto');
                } else {
                    $file_name = $foto_user->getRandomName();
                    $foto_user->move('upload/foto_user', $file_name);
                }

                $this->userModel->update(['id' => $this->request->getPost('id')], [
                    'full_name' => $this->request->getPost('full_name'),
                    'email' => $this->request->getPost('email'),
                    'foto_user' => $file_name,
                    'group_level' => $this->request->getPost('group_level'),
                    'updated_by' =>  $this->session->get('id_user')
                ]);
                echo json_encode(["status" => true]);
                break;
        }
    }

    public function deleteData($id)
    {
        $menu_detail = $this->menuModel->getByData(['nav_act' => 'user_managements']);
        $menu_role = $this->menuRoleModel->getByData(['id_menu' => $menu_detail->id, 'group_level' => $this->session->get('group_level')]);

        if ($menu_role->delete_act == 'Y') {
            $this->userModel->update(['id' => $id], ['aktif' => 'D']);
            echo json_encode(["status" => true]);
        } else {
            echo json_encode(['status' => false, 'message' => 'tidak dapat menghapus karena akses anda terbatas']);
        }
    }

    public function changeStatus($id)
    {
        $data = $this->userModel->getByData(['id' => $id]);
        if ($data->aktif == 'Y') {
            $new = 'N';
        } else {
            $new = 'Y';
        }
        $this->userModel->update(['id' => $id], ['aktif' => $new]);
        echo json_encode(["status" => true]);
    }

    private function _validate($method)
    {
        $data = [];
        $data['error_string'] = [];
        $data['inputerror'] = [];
        $data['status'] = TRUE;

        $foto = $this->request->getFile('foto_user');
        if (!empty($foto)) {
            $file_foto = $foto->getClientMimeType();
            $size = $foto->getSize();
            if ($file_foto != '' && $file_foto != 'image/jpeg' && $file_foto != 'image/jpg' && $file_foto != 'image/png') {
                $data['inputerror'][] = 'foto_user';
                $data['error_string'][] = 'foto hanya png/jpg';
                $data['status'] = FALSE;
            }

            if ($size > 1048576) {
                $data['inputerror'][] = 'foto_user';
                $data['error_string'][] = 'Ukuran foto terlalu besar. Max 1MB';
                $data['status'] = FALSE;
            }
        }

        if ($method == 'add') {
            if ($this->request->getPost('confirm_password') == '') {
                $data['inputerror'][] = 'confirm_password';
                $data['error_string'][] = 'Confirm password wajib diisi';
                $data['status'] = FALSE;
            }

            if ($this->request->getPost('password') == '') {
                $data['inputerror'][] = 'password';
                $data['error_string'][] = 'Password wajib diisi';
                $data['status'] = FALSE;
            }

            if ($this->request->getPost('password') != $this->request->getPost('confirm_password')) {
                $data['inputerror'][] = 'confirm_password';
                $data['error_string'][] = 'Confirm password tidak sesuai';
                $data['status'] = FALSE;
            }

            if ($this->request->getPost('username') == '') {
                $data['inputerror'][] = 'username';
                $data['error_string'][] = 'username wajib diisi';
                $data['status'] = FALSE;
            }

            $cek = $this->userModel->getByData(['username' => $this->request->getPost('username')]);
            if ($cek) {
                $data['inputerror'][] = 'username';
                $data['error_string'][] = 'username ' . $this->request->getPost('username') . ' sudah terpakai';
                $data['status'] = FALSE;
            }
        }

        if ($this->request->getPost('full_name') == '') {
            $data['inputerror'][] = 'full_name';
            $data['error_string'][] = 'Nama lengkap wajib diisi';
            $data['status'] = FALSE;
        }

        if ($data['status'] === FALSE) {
            echo json_encode($data);
            exit();
        }
    }
}
