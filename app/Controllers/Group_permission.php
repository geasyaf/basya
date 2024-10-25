<?php

namespace App\Controllers;

use App\Models\Group_Users_Model;
use App\Models\Menu_Model;
use App\Models\Menu_Role_Model;
use App\Models\Users_Model;

class Group_permission extends BaseController
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
            $data['group_level'] = $this->groupModel->findAll();
            $data['level'] = $this->request->getGet('level');

            $data['data_menu'] = $this->menuModel->getMenu();
            $data['menu'] = ['cek_main' => 'system_setting', 'cek_page' => 'group_permission', 'detail_menu' => $this->menuModel->getByData(['nav_act' => 'group_permission'])];
            $data['title'] = 'Group Permission';
            $data['content'] = 'group_permission/group_permission';
            $data['content_foot'] = 'group_permission/group_permission_foot';
            return view('layout/wrapper', $data);
        } else {
            return redirect()->to(base_url('login'));
        }
    }

    public function listData()
    {
        $level = $this->request->getPost('level');
        $list = $this->menuModel->getByType(['parent' => 0]);
        $data = [];
        foreach ($list as $value) {
            $row = [];
            $row[] = '<b>' . $value->urutan_menu . '. ' . $value->page_name . '</b>';
            $checked_view = $checked_add = $checked_edit = $checked_delete = '';
            $cek = $this->menuRoleModel->getByData(['id_menu' => $value->id, 'group_level' => $level]);
            if ($cek) {
                if ($cek->read_act == 'Y') {
                    $checked_view = 'checked';
                }

                if ($cek->insert_act == 'Y') {
                    $checked_add = 'checked';
                }

                if ($cek->update_act == 'Y') {
                    $checked_edit = 'checked';
                }

                if ($cek->delete_act == 'Y') {
                    $checked_delete = 'checked';
                }
            }
            if ($value->type_menu == 'page') {
                $row[] = '<div class="icheck-primary d-inline">
                        <input type="checkbox" id="view_' . $value->id . '" onclick="addPermission(this, ' . "'view'" . ', ' . "'" . $value->id . "'" . ', ' . "'" . $level . "'" . ')" ' . $checked_view . '>
                        <label for="view_' . $value->id . '">
                        </label>
                    </div>';
                $row[] = '<div class="icheck-primary d-inline">
                        <input type="checkbox" id="add_' . $value->id . '" onclick="addPermission(this, ' . "'add'" . ', ' . "'" . $value->id . "'" . ', ' . "'" . $level . "'" . ')" ' . $checked_add . '>
                        <label for="add_' . $value->id . '">
                        </label>
                    </div>';
                $row[] = '<div class="icheck-primary d-inline">
                        <input type="checkbox" id="edit_' . $value->id . '" onclick="addPermission(this, ' . "'edit'" . ', ' . "'" . $value->id . "'" . ', ' . "'" . $level . "'" . ')" ' . $checked_edit . '>
                        <label for="edit_' . $value->id . '">
                        </label>
                    </div>';
                $row[] = '<div class="icheck-primary d-inline">
                        <input type="checkbox" id="delete_' . $value->id . '" onclick="addPermission(this, ' . "'delete'" . ', ' . "'" . $value->id . "'" . ', ' . "'" . $level . "'" . ')" ' . $checked_delete . '>
                        <label for="delete_' . $value->id . '">
                        </label>
                    </div>';
            } else {
                $row[] = '<div class="icheck-primary d-inline">
                            <input type="checkbox" id="view_' . $value->id . '" onclick="addPermission(this, ' . "'view'" . ', ' . "'" . $value->id . "'" . ', ' . "'" . $level . "'" . ')" ' . $checked_view . '>
                            <label for="view_' . $value->id . '">
                            </label>
                        </div>';
                $row[] = '';
                $row[] = '';
                $row[] = '';
            }
            $data[] = $row;

            $child = $this->menuModel->getByType(['type_menu' => 'page', 'parent' => $value->id]);
            foreach ($child as $ch) {
                $checked_child_view = $checked_child_add = $checked_child_edit = $checked_child_delete = '';
                $cek_child = $this->menuRoleModel->getByData(['id_menu' => $ch->id, 'group_level' => $level]);
                if ($cek_child) {
                    if ($cek_child->read_act == 'Y') {
                        $checked_child_view = 'checked';
                    }

                    if ($cek_child->insert_act == 'Y') {
                        $checked_child_add = 'checked';
                    }

                    if ($cek_child->update_act == 'Y') {
                        $checked_child_edit = 'checked';
                    }

                    if ($cek_child->delete_act == 'Y') {
                        $checked_child_delete = 'checked';
                    }
                }
                $row = [];
                $row[] = '&emsp;&emsp; ' . $ch->urutan_menu . '. ' . $ch->page_name;
                $row[] = '<div class="icheck-primary d-inline">
                    <input type="checkbox" id="view_' . $ch->id . '" onclick="addPermission(this, ' . "'view'" . ', ' . "'" . $ch->id . "'" . ', ' . "'" . $level . "'" . ')" ' . $checked_child_view . '>
                    <label for="view_' . $ch->id . '">
                    </label>
                </div>';
                $row[] = '<div class="icheck-primary d-inline">
                    <input type="checkbox" id="add_' . $ch->id . '" onclick="addPermission(this, ' . "'add'" . ', ' . "'" . $ch->id . "'" . ', ' . "'" . $level . "'" . ')" ' . $checked_child_add . '>
                    <label for="add_' . $ch->id . '">
                    </label>
                </div>';
                $row[] = '<div class="icheck-primary d-inline">
                    <input type="checkbox" id="edit_' . $ch->id . '" onclick="addPermission(this, ' . "'edit'" . ', ' . "'" . $ch->id . "'" . ', ' . "'" . $level . "'" . ')" ' . $checked_child_edit . '>
                    <label for="edit_' . $ch->id . '">
                    </label>
                </div>';
                $row[] = '<div class="icheck-primary d-inline">
                    <input type="checkbox" id="delete_' . $ch->id . '" onclick="addPermission(this, ' . "'delete'" . ', ' . "'" . $ch->id . "'" . ', ' . "'" . $level . "'" . ')" ' . $checked_child_delete . '>
                    <label for="delete_' . $ch->id . '">
                    </label>
                </div>';
                $data[] = $row;
            }
        }

        $output = array(
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function addPermission()
    {
        $method = $this->request->getPost('method');
        $id = $this->request->getPost('id');
        $level = $this->request->getPost('level');
        $checked = $this->request->getPost('checked');
        if ($checked == 'true') {
            $flag = 'Y';
        } else {
            $flag = 'N';
        }

        switch ($method) {
            case 'view':
                $data = [
                    'id_menu' => $id,
                    'group_level' => $level,
                    'read_act' => $flag
                ];
                $this->menuModel->update(['id' => $id], ['tampil' => $flag]);
                break;
            case 'add':
                $data = [
                    'id_menu' => $id,
                    'group_level' => $level,
                    'insert_act' => $flag
                ];
                break;
            case 'edit':
                $data = [
                    'id_menu' => $id,
                    'group_level' => $level,
                    'update_act' => $flag
                ];
                break;
            case 'delete':
                $data = [
                    'id_menu' => $id,
                    'group_level' => $level,
                    'delete_act' => $flag
                ];
                break;
        }

        $cek = $this->menuRoleModel->getByData(['id_menu' => $id, 'group_level' => $level]);
        if ($cek) {
            $this->menuRoleModel->update(['id' => $cek->id], $data);
        } else {
            $this->menuRoleModel->save($data);
        }

        echo json_encode(['status' => true]);
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
        $this->groupModel->delete(['id' => $id]);
        echo json_encode(["status" => true]);
    }

    private function _validate($method)
    {
        $data = [];
        $data['error_string'] = [];
        $data['inputerror'] = [];
        $data['status'] = TRUE;

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
