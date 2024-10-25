<?php

namespace App\Controllers;

use App\Models\Group_Users_Model;
use App\Models\Menu_Model;
use App\Models\Menu_Role_Model;

class User_group extends BaseController
{   
    protected $menuModel;
    protected $groupModel;
    protected $menuRoleModel;
    
    public function __construct()
    {
        $this->menuModel = new Menu_Model();
        $this->groupModel = new Group_Users_Model();
        $this->menuRoleModel = new Menu_Role_Model();
        $this->session = session();
    }

    public function index()
    {
        $id_user = $this->session->get('id_user');
        if ($id_user) {
            $menu_detail = $this->menuModel->getByData(['nav_act' => 'user_group']);
            $menu_role = $this->menuRoleModel->getByData(['id_menu' => $menu_detail->id, 'group_level' => $this->session->get('group_level')]);
            $data['data_menu'] = $this->menuModel->getMenu();
            $data['menu'] = ['cek_main' => 'system_setting', 'cek_page' => 'user_group'];
            $data['title'] = 'User Group';
            if ($menu_role->read_act == 'Y') {
                $data['content'] = 'user_group/user_group';
                $data['content_foot'] = 'user_group/user_group_foot';
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
        $list = $this->groupModel->listData();
        $data = [];
        $no = 0;
        foreach ($list as $value) {
            $no++;
            $row = [];
            $row[] = $no;
            $row[] = $value->level;
            $row[] = $value->deskripsi;
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

    public function getData($id)
    {
        $data = $this->groupModel->getByData(['id' => $id]);
        echo json_encode($data);
    }

    public function addData()
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->_validate('add');
        $this->groupModel->save([
            'level' => $this->request->getPost('level'),
            'level_name' => $this->request->getPost('level'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'created_by' =>  $this->session->get('id_user')
        ]);
        echo json_encode(["status" => true]);
    }

    public function editData()
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->_validate('edit');
        $this->groupModel->update(['id' => $this->request->getPost('id')], [
            'level' => $this->request->getPost('level'),
            'level_name' => $this->request->getPost('level'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'updated_by' =>  $this->session->get('id_user')
        ]);
        echo json_encode(["status" => true]);
    }

    public function deleteData($id)
    {
        $menu_detail = $this->menuModel->getByData(['nav_act' => 'user_group']);
        $menu_role = $this->menuRoleModel->getByData(['id_menu' => $menu_detail->id, 'group_level' => $this->session->get('group_level')]);

        if ($menu_role->delete_act == 'Y') {
            $this->groupModel->delete(['id' => $id]);
            echo json_encode(["status" => true]);
        } else {
            echo json_encode(['status' => false, 'message' => 'tidak dapat menghapus karena akses anda terbatas']);
        }
    }

    private function _validate($method)
    {
        $data = [];
        $data['error_string'] = [];
        $data['inputerror'] = [];
        $data['status'] = TRUE;

        $menu_detail = $this->menuModel->getByData(['nav_act' => 'user_group']);
        $menu_role = $this->menuRoleModel->getByData(['id_menu' => $menu_detail->id, 'group_level' => $this->session->get('group_level')]);
        if ($menu_role->insert_act == 'N' || $menu_role->insert_act == null) {
            $data['inputerror'][] = 'deskripsi';
            $data['error_string'][] = 'tidak dapat menyimpan karena akses anda terbatas';
            $data['status'] = FALSE;
            $data['inputerror'][] = 'level';
            $data['error_string'][] = 'tidak dapat menyimpan karena akses anda terbatas';
            $data['status'] = FALSE;
        }

        if ($menu_role->update_act == 'N' || $menu_role->update_act == null) {
            $data['inputerror'][] = 'deskripsi';
            $data['error_string'][] = 'tidak dapat menyimpan karena akses anda terbatas';
            $data['status'] = FALSE;
            $data['inputerror'][] = 'level';
            $data['error_string'][] = 'tidak dapat menyimpan karena akses anda terbatas';
            $data['status'] = FALSE;
        }

        if ($this->request->getPost('deskripsi') == '') {
            $data['inputerror'][] = 'deskripsi';
            $data['error_string'][] = 'Deskripsi wajib diisi';
            $data['status'] = FALSE;
        }

        if ($this->request->getPost('level') == '') {
            $data['inputerror'][] = 'level';
            $data['error_string'][] = 'Level wajib diisi';
            $data['status'] = FALSE;
        }

        if ($method == 'add') {
            $cek = $this->groupModel->getByData(['level' => $this->request->getPost('level')]);
            if ($cek) {
                $data['inputerror'][] = 'level';
                $data['error_string'][] = 'level ' . $this->request->getPost('level') . ' sudah ada';
                $data['status'] = FALSE;
            }
        }

        if ($data['status'] === FALSE) {
            echo json_encode($data);
            exit();
        }
    }
}
