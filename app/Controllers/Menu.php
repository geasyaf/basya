<?php

namespace App\Controllers;

use App\Models\Group_Users_Model;
use App\Models\Menu_Model;
use App\Models\Menu_Role_Model;
use App\Models\Users_Model;

class Menu extends BaseController
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
            $menu_detail = $this->menuModel->getByData(['nav_act' => 'menu']);
            $menu_role = $this->menuRoleModel->getByData(['id_menu' => $menu_detail->id, 'group_level' => $this->session->get('group_level')]);
            $data['data_menu'] = $this->menuModel->getMenu();
            $data['menu'] = ['cek_main' => 'system_setting', 'cek_page' => 'menu'];
            $data['title'] = 'Menu';
            if ($menu_role->read_act == 'Y') {
                $data['content'] = 'menu/menu';
                $data['content_foot'] = 'menu/menu_foot';
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
        $list = $this->menuModel->listData();
        $data = [];
        $no = 0;
        foreach ($list as $value) {
            $no++;
            $row = [];
            $row[] = $no;
            $row[] = $value->page_name;
            $row[] = '<i class="' . $value->icon . '"></i>';
            $row[] = $value->parent_name;
            $row[] = $value->type_menu;
            if ($value->tampil == 'Y') {
                $row[] = '<button type="button" class="btn btn-success btn-xs" title="status" onclick="changeStatus(' . "'" . $value->id . "'" . ')">yes</button>';
            } else {
                $row[] = '<button type="button" class="btn btn-warning btn-xs" title="status" onclick="changeStatus(' . "'" . $value->id . "'" . ')">no</button>';
            }
            $row[] = $value->created;
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
            $data['data_parent'] = $this->menuModel->listDataByType('main');
            $data['group_level'] = $this->groupModel->findAll();

            $menu_detail = $this->menuModel->getByData(['nav_act' => 'menu']);
            $menu_role = $this->menuRoleModel->getByData(['id_menu' => $menu_detail->id, 'group_level' => $this->session->get('group_level')]);
            $data['data_menu'] = $this->menuModel->getMenu();
            $data['menu'] = ['cek_main' => 'system_setting', 'cek_page' => 'menu'];
            $data['title'] = 'Menu Add';
            
            if ($menu_role->insert_act == 'Y') {
                $data['content'] = 'menu/menu_add';
                $data['content_foot'] = 'menu/menu_foot';
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
            $data['data_parent'] = $this->menuModel->listDataByType('main');
            $data['data_edit'] = $this->menuModel->getByData(['id' => $id]);
            $data['group_level'] = $this->groupModel->findAll();

            $menu_detail = $this->menuModel->getByData(['nav_act' => 'menu']);
            $menu_role = $this->menuRoleModel->getByData(['id_menu' => $menu_detail->id, 'group_level' => $this->session->get('group_level')]);
            $data['data_menu'] = $this->menuModel->getMenu();
            $data['menu'] = ['cek_main' => 'system_setting', 'cek_page' => 'menu'];
            $data['title'] = 'Menu Edit';

            if ($menu_role->update_act == 'Y') {
                $data['content'] = 'menu/menu_edit';
                $data['content_foot'] = 'menu/menu_foot';
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
                if ($this->request->getPost('show') == 'on') {
                    $show = 'Y';
                } else {
                    $show = 'N';
                }

                $get_urutan = $this->menuModel->getUrutanByType($this->request->getPost('type_menu'), $this->request->getPost('parent'));
                $this->menuModel->save([
                    'nav_act' => str_replace(" ", "_", strtolower($this->request->getPost('page_name'))),
                    'page_name' => $this->request->getPost('page_name'),
                    'url' => str_replace(" ", "-", strtolower($this->request->getPost('page_name'))),
                    'icon' => $this->request->getPost('icon'),
                    'urutan_menu' => ($get_urutan) ? $get_urutan->urutan_menu + 1 : 1,
                    'parent' => $this->request->getPost('parent'),
                    'tampil' =>  $show,
                    'type_menu' => $this->request->getPost('type_menu'),
                    'created_by' =>  $this->session->get('id_user')
                ]);
                $id_menu = $this->menuModel->getInsertID();

                $this->menuRoleModel->save([
                    'id_menu' => $id_menu,
                    'group_level' => $this->session->get('group_level'),
                    'read_act' => 'Y',
                    'insert_act' => 'Y',
                    'update_act' => 'Y',
                    'delete_act' => 'Y'
                ]);
                echo json_encode(["status" => true]);
                break;
            case 'edit':

                $this->menuModel->update(['id' => $this->request->getPost('id')], [
                    'nav_act' => str_replace(" ", "_", strtolower($this->request->getPost('page_name'))),
                    'page_name' => $this->request->getPost('page_name'),
                    'url' => str_replace(" ", "-", strtolower($this->request->getPost('page_name'))),
                    'icon' => $this->request->getPost('icon'),
                    'parent' => $this->request->getPost('parent'),
                    'type_menu' => $this->request->getPost('type_menu'),
                    'updated_by' =>  $this->session->get('id_user')
                ]);
                echo json_encode(["status" => true]);
                break;
        }
    }

    public function deleteData($id)
    {
        $menu_detail = $this->menuModel->getByData(['nav_act' => 'menu']); 
        $menu_role = $this->menuRoleModel->getByData(['id_menu' => $menu_detail->id, 'group_level' => $this->session->get('group_level')]);

        if ($menu_role->delete_act == 'Y') {
            $this->menuModel->delete(['id' => $id]);
            echo json_encode(["status" => true]);
        } else {
            echo json_encode(['status' => false, 'message' => 'tidak dapat menghapus karena akses anda terbatas']);
        }
    }

    public function changeStatus($id)
    {
        $data = $this->menuModel->getByData(['id' => $id]);
        if ($data->tampil == 'Y') {
            $new = 'N';
        } else {
            $new = 'Y';
        }
        $this->menuModel->update(['id' => $id], ['tampil' => $new]);
        echo json_encode(["status" => true]);
    }

    private function _validate($method)
    {
        $data = [];
        $data['error_string'] = [];
        $data['inputerror'] = [];
        $data['status'] = TRUE;

        if ($this->request->getPost('type_menu') == '') {
            $data['inputerror'][] = 'type_menu';
            $data['error_string'][] = 'Tipe menu wajib dipilih';
            $data['status'] = FALSE;
        }

        if ($method == 'add') {
            $cek = $this->menuModel->getByData(['nav_act' => str_replace(" ", "_", strtolower($this->request->getPost('page_name')))]);
            if ($cek) {
                $data['inputerror'][] = 'page_name';
                $data['error_string'][] = 'Menu ' . $this->request->getPost('page_name') . ' sudah ada';
                $data['status'] = FALSE;
            }
        } else {
            $cek = $this->menuModel->getByData(['id' => $this->request->getPost('id')]);
            if ($cek->nav_act == str_replace(" ", "_", strtolower($this->request->getPost('page_name')))) {
                $status = true;
            } else {
                $cek2 = $this->menuModel->getByData(['nav_act' => str_replace(" ", "_", strtolower($this->request->getPost('page_name')))]);
                if ($cek2) {
                    $status = false;
                } else {
                    $status = true;
                }
            }

            if ($status == false) {
                $data['inputerror'][] = 'page_name';
                $data['error_string'][] = 'Menu ' . $this->request->getPost('page_name') . ' sudah ada';
                $data['status'] = FALSE;
            }
        }

        if ($this->request->getPost('page_name') == '') {
            $data['inputerror'][] = 'page_name';
            $data['error_string'][] = 'Nama menu wajib diisi';
            $data['status'] = FALSE;
        }

        if ($data['status'] === FALSE) {
            echo json_encode($data);
            exit();
        }
    }
}
