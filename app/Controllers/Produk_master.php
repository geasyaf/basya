<?php

namespace App\Controllers;

use App\Models\Data_Anggota_Model; 
use App\Models\Menu_Model;
use App\Models\Menu_Role_Model;
use App\Models\Produk_Master_Model;

use PhpParser\Node\Expr\List_;

class Produk_master extends BaseController
{
    protected $menuModel;
    protected $dataAnggotaModel;
    protected $menuRoleModel;
    protected $produkMasterModel;

    public function __construct()
    {   
        $this->menuModel = new Menu_Model();
        $this->dataAnggotaModel = new Data_Anggota_Model();
        $this->menuRoleModel = new Menu_Role_Model();
        $this->produkMasterModel = new Produk_Master_Model();
        $this->session = session();
        helper('functions'); 
    }
    public function index()
    {
        $id_user = $this->session->get('id_user');
        if ($id_user) {
            $menu_detail = $this->menuModel->getByData(['nav_act' => 'produk_master']);
            $menu_role = $this->menuRoleModel->getByData(['id_menu' => $menu_detail->id, 'group_level' => $this->session->get('group_level')]);
            $data['data_menu'] = $this->menuModel->getMenu();
            // var_dump($id_user);
            // die();
            $data['menu'] = ['cek_main' => 'menu_master', 'cek_page' => 'produk_master'];
            $data['title'] = 'Produk Master';
            if ($menu_role->read_act == 'Y') {
                $data['content'] = 'produk_master/produk_master';
                $data['content_foot'] = 'produk_master/produk_master_foot';
            } else {
                $data['content'] = 'layout/error_page';
                $data['content_foot'] = '';
            }
            $list = $this->produkMasterModel->listData();

            return view('layout/wrapper', $data);
        } else {
            return redirect()->to(base_url('login'));
        }
    }
    public function listData()
    {
        $list = $this->produkMasterModel->listData();
        $data = [];
        $no = 0;
        foreach ($list as $value) {
            $no++;
            $row = [];
            $row[] = $no;
            $row[] = $value->prod_id;
            $row[] = $value->prod_name;
            if ($value->is_active == 'Y') {
                $row[] = '<button type="button" class="btn btn-success btn-xs" title="status" onclick="changeStatus(' . "'" . $value->id . "'" . ')">yes</button>';
            } else {
                $row[] = '<button type="button" class="btn btn-warning btn-xs" title="status" onclick="changeStatus(' . "'" . $value->id . "'" . ')">no</button>';
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

    public function changeStatus($id)
    {   
        $data = $this->produkMasterModel->getByData(['id' => $id]);
        if ($data->is_active == 'Y') {
            $new = 'N';
        } else {
            $new = 'Y';
        }
        // var_dump($new);
        // die();
        $this->produkMasterModel->update(['id' => $id], ['is_active' => $new]);
        echo json_encode(["status" => true]);
    }

    public function addData()
    {   
        $id_user = $this->session->get('id_user');
        if ($id_user) {
            $data['data_parent'] = $this->menuModel->listDataByType('main');

            $menu_detail = $this->menuModel->getByData(['nav_act' => 'produk_master']);
            $menu_role = $this->menuRoleModel->getByData(['id_menu' => $menu_detail->id, 'group_level' => $this->session->get('group_level')]);
            $data['data_menu'] = $this->menuModel->getMenu();
            $data['menu'] = ['cek_main' => 'menu_master', 'cek_page' => 'produk_master'];
            $data['title'] = 'Produk Master Add';
            
            if ($menu_role->insert_act == 'Y') {
                $data['content'] = 'produk_master/produk_master_add';
                $data['content_foot'] = 'produk_master/produk_master_foot';
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
            $data['data_edit'] = $this->produkMasterModel->getByData(['id' => $id]);

            $menu_detail = $this->menuModel->getByData(['nav_act' => 'produk_master']);
            $menu_role = $this->menuRoleModel->getByData(['id_menu' => $menu_detail->id, 'group_level' => $this->session->get('group_level')]);
            $data['data_menu'] = $this->menuModel->getMenu();
            $data['menu'] = ['cek_main' => 'menu_master', 'cek_page' => 'produk_master'];
            $data['title'] = 'Edit Master Data Product';
            // var_dump($data['data_edit']); 
            // die(); 

            if ($menu_role->update_act == 'Y') {
                $data['content'] = 'produk_master/produk_master_edit';
                $data['content_foot'] = 'produk_master/produk_master_foot';
            } else {
                $data['content'] = 'layout/error_page';
                $data['content_foot'] = '';
            }
            return view('layout/wrapper', $data);
        } else {
            return redirect()->to(base_url('login'));
        }
    }

    public function deleteData($id)
    {   
        $menu_detail = $this->menuModel->getByData(['nav_act' => 'produk_master']);
        $menu_role = $this->menuRoleModel->getByData(['id_menu' => $menu_detail->id, 'group_level' => $this->session->get('group_level')]);
    
        if ($menu_role->delete_act == 'Y') {
            $this->produkMasterModel->delete(['id' => $id]);
            echo json_encode(["status" => true]);
        } else {
            echo json_encode(['status' => false, 'message' => 'tidak dapat menghapus karena akses anda terbatas']);
        }
    }

    public function saveData($method)
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->_validate($method);

        // conditioning for output values ​​"on" and "off" values
        if ($this->request->getPost('is_active') == 'on') {
            $is_active = 'Y';
        } else {
            $is_active = 'N';
        }
        switch ($method) {
            case 'add':
                $prod_type = $this->request->getPost('prod_type');
                if($prod_type == 'L'){
                    $firstLetterId = 'L';
                } else if($prod_type == 'F'){
                    $firstLetterId = 'F';
                }
                $data['reg'] = genReg($firstLetterId); 
                $this->produkMasterModel->save([
                    'prod_id' => $data['reg'],
                    'prod_name' => $this->request->getPost('prod_name'),
                    'prod_desc' => $this->request->getPost('prod_desc'),
                    'prod_type' => $prod_type,
                    'is_active' => $is_active,
                    'created_by' => $this->session->get('id_user')
                ]);
                echo json_encode(["status" => true]);
                break;
            case 'edit':
                var_dump($this->request->getPost('prod_name'));
                die();
                $this->produkMasterModel->update(['id' => $this->request->getPost('id')], [
                    'prod_name' => $this->request->getPost('prod_name'),
                    'prod_desc' => $this->request->getPost('prod_desc'),
                    'is_active' => $is_active, 
                    'created_by' => $this->session->get('id_user')
                ]);
                echo json_encode(["status" => true]);
                break;
        }
    }

    private function _validate($method)
    {
        $data = [];
        $data['error_string'] = [];
        $data['inputerror'] = [];
        $data['status'] = TRUE;

        if ($method == 'add') {

            // =========================================================
            // User's identity 

            if ($this->request->getPost('prod_name') == '') {
                $data['inputerror'][] = 'prod_name';
                $data['error_string'][] = 'Nama produk wajib diisi';
                $data['status'] = FALSE;
            }

            if ($this->request->getPost('prod_type') == '') {
                $data['inputerror'][] = 'prod_type';
                $data['error_string'][] = 'Tipe produk wajib diisi';
                $data['status'] = FALSE;
            }
        }
        if ($method == 'edit') {
            if ($this->request->getPost('prod_name') == '') {
                $data['inputerror'][] = 'prod_name';
                $data['error_string'][] = 'Nama produk wajib diisi';
                $data['status'] = FALSE;
            }
        }
        if ($data['status'] === FALSE) {
            echo json_encode($data);
            exit();
        }
    }
    
}