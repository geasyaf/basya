<?php

namespace App\Controllers;

use App\Models\Data_Anggota_Model;
use App\Models\Meta_Data_Model; 
use App\Models\Menu_Model;
use App\Models\Menu_Role_Model;

class Data_anggota extends BaseController
{   
    protected $menuModel;
    protected $dataAnggotaModel;
    protected $metaDataModel; 
    protected $menuRoleModel;
    
    
    public function __construct()
    {   
        $this->menuModel = new Menu_Model();
        $this->dataAnggotaModel = new Data_Anggota_Model();
        $this->metaDataModel = new Meta_Data_Model(); 
        $this->menuRoleModel = new Menu_Role_Model();
        $this->session = session();
        // helper('functions'); 
    }

    public function index()
    {
        $id_user = $this->session->get('id_user');
        if ($id_user) {
            $menu_detail = $this->menuModel->getByData(['nav_act' => 'data_anggota']);
            $menu_role = $this->menuRoleModel->getByData(['id_menu' => $menu_detail->id, 'group_level' => $this->session->get('group_level')]);
            $data['data_menu'] = $this->menuModel->getMenu();
            $data['menu'] = ['cek_main' => 'menu_master', 'cek_page' => 'data_anggota'];
            $data['title'] = 'Data Anggota Koperasi';
            if ($menu_role->read_act == 'Y') {
                $data['content'] = 'data_anggota/data_anggota';
                $data['content_foot'] = 'data_anggota/data_anggota_foot';
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
        $list = $this->dataAnggotaModel->listData();
        $data = [];
        $no = 0;
        foreach ($list as $value) {
            $no++;
            $row = [];
            $row[] = $no;
            $row[] = $value->id_nasabah;
            $row[] = $value->no_ktp;
            $row[] = $value->full_name;
            $row[] = $value->contact;
            $row[] = $value->meta_name;
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
            $menu_detail = $this->menuModel->getByData(['nav_act' => 'data_anggota']);
            $menu_role = $this->menuRoleModel->getByData(['id_menu' => $menu_detail->id, 'group_level' => $this->session->get('group_level')]);

            $data['marital_status'] = $this->metaDataModel->getByMetaKey('marital_status');
            $data['profession'] = $this->metaDataModel->getByMetaKey('profession');
            $data['employee_status'] = $this->metaDataModel->getByMetaKey('employee_status');
            $data['data_menu'] = $this->menuModel->getMenu();
            $data['menu'] = ['cek_main' => 'menu_master', 'cek_page' => 'data_anggota'];
            $data['title'] = 'Data anggota Add';
            
            if ($menu_role->insert_act == 'Y') {
                $data['content'] = 'data_anggota/data_anggota_add';
                $data['content_foot'] = 'data_anggota/data_anggota_foot';
            } else {
                $data['content'] = 'layout/error_page';
                $data['content_foot'] = '';
            }
            return view('layout/wrapper', $data);
        } else {
            return redirect()->to(base_url('login'));
        }
    }
    
    public function detailData($id)
    {
        $id_user = $this->session->get('id_user');
        if ($id_user) {
            $data['data_detail'] = $this->dataAnggotaModel->getByData(['id' => $id]);

            $menu_detail = $this->menuModel->getByData(['nav_act' => 'data_anggota']);
            $menu_role = $this->menuRoleModel->getByData(['id_menu' => $menu_detail->id, 'group_level' => $this->session->get('group_level')]);
            
            $data['marital_status'] = $this->metaDataModel->getByMetaKey('marital_status');
            $data['profession'] = $this->metaDataModel->getByMetaKey('profession');
            $data['employee_status'] = $this->metaDataModel->getByMetaKey('employee_status');
            $data['data_menu'] = $this->menuModel->getMenu();
            $data['menu'] = ['cek_main' => 'menu_master', 'cek_page' => 'data_anggota'];
            $data['title'] = 'Data Anggota Detail';
            if ($menu_role->update_act == 'Y') {
                $data['content'] = 'data_anggota/data_anggota_detail';
                $data['content_foot'] = 'data_anggota/data_anggota_foot';
            } else {
                $data['content'] = 'layout/error_page';
                $data['content_foot'] = '';
            }
            return view('layout/wrapper', $data);
        } else {
            return redirect()->to(base_url('login'));
        }
    }

    // public function editData($id)
    // {
    //     $id_user = $this->session->get('id_user');
    //     if ($id_user) {
    //         $data['data_edit'] = $this->dataAnggotaModel->getByData(['id' => $id]);

    //         $menu_detail = $this->menuModel->getByData(['nav_act' => 'data_anggota']);
    //         $menu_role = $this->menuRoleModel->getByData(['id_menu' => $menu_detail->id, 'group_level' => $this->session->get('group_level')]);
            
    //         $data['marital_status'] = $this->metaDataModel->getByMetaKey('marital_status');
    //         $data['profession'] = $this->metaDataModel->getByMetaKey('profession');
    //         $data['employee_status'] = $this->metaDataModel->getByMetaKey('employee_status');
    //         $data['data_menu'] = $this->menuModel->getMenu();
    //         $data['menu'] = ['cek_main' => 'menu_master', 'cek_page' => 'data_anggota'];
    //         $data['title'] = 'Data Anggota Edit';
    //         if ($menu_role->update_act == 'Y') {
    //             $data['content'] = 'data_anggota/data_anggota_edit';
    //             $data['content_foot'] = 'data_anggota/data_anggota_foot';
    //         } else {
    //             $data['content'] = 'layout/error_page';
    //             $data['content_foot'] = '';
    //         }
    //         return view('layout/wrapper', $data);
    //     } else {
    //         return redirect()->to(base_url('login'));
    //     }
    // }

    public function saveData($method)
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->_validate($method);
        switch ($method) {
            case 'add':
                // $ktp_user = $this->request->getFile('img_ktp'); 
                //     $file_name_ktp_user = $ktp_user->getRandomName();
                //     $ktp_user->move('upload/foto_ktp', $file_name_ktp_user); 

                if ($this->request->getPost('is_join_come') == 'Y') {
                    $ktp_partner = $this->request->getFile('partner_img_ktp');
                    $file_name_ktp_partner = $ktp_partner->getRandomName();
                    $ktp_partner->move('upload/foto_ktp', $file_name_ktp_partner);
                }
                $no_ktp = $this->request->getPost('no_ktp');
                // if (empty($no_ktp)) {
                //     echo json_encode(['status' => false, 'message' => 'no_ktp is empty']);
                //     return;
                // } else {
                //     echo json_encode(['status' => true, 'no_ktp' => $no_ktp]);
                // }
                $no_ktp = 'anjing';
                // $data['reg'] = genReg('N');   
                $this->dataAnggotaModel->save([
                    // user_identity
                    // 'id_nasabah' => $data['reg'], 
                    // 'no_ktp' => $this->request->getPost('no_ktp'),
                    'full_name' => $this->request->getPost('full_name'),
                    'address' => $this->request->getPost('address'),
                    // 'contact' => $this->request->getPost('contact'),
                    // 'pob' => $this->request->getPost('pob'), 
                    // 'dob' => $this->request->getPost('dob'),
                    // 'mothers_name' => $this->request->getPost('mothers_name'),
                    // 'email' => $this->request->getPost('email'),
                    // 'marital_status' => $this->request->getPost('marital_status'),
                    // 'profession' => $this->request->getPost('profession'), 
                    // 'company_name' => $this->request->getPost('company_name'),
                    // 'company_address' => $this->request->getPost('company_address'),
                    // 'company_tlp' => $this->request->getPost('company_tlp'),
                    // 'job_position' => $this->request->getPost('job_position'),
                    // 'take_home_pay' => $this->request->getPost('take_home_pay'),
                    // 'long_working' => $this->request->getPost('long_working'),
                    // 'employee_status' => $this->request->getPost('employee_status'),
                    // 'img_ktp' => $file_name_ktp_user, 

                    // users family's identity
                    // 'family_name' => $this->request->getPost('family_name'),
                    // 'family_contact' => $this->request->getPost('family_contact'),
                    // 'family_address' => $this->request->getPost('family_address'),
                    // 'family_relationship_status' => $this->request->getPost('family_relationship_status'),
                    // 'is_join_come' => $this->request->getPost('is_join_come'),

                    // partner's identity
                    // 'partner_ktp' => $this->request->getPost('partner_ktp'),
                    // 'partner_name' => $this->request->getPost('partner_name'),
                    // 'partner_address' => $this->request->getPost('partner_address'),
                    // 'partner_contact' => $this->request->getPost('partner_contact'),
                    // 'partner_pob' => $this->request->getPost('partner_pob'),
                    // 'partner_dob' => $this->request->getPost('partner_dob'),
                    // 'partner_mothers_name' => $this->request->getPost('partner_mothers_name'),
                    // 'partner_email' => $this->request->getPost('partner_email'),
                    // 'partner_profession' => $this->request->getPost('partner_profession'),
                    // 'partner_comp_name' => $this->request->getPost('partner_comp_name'),
                    // 'partner_comp_address' => $this->request->getPost('partner_comp_address'),
                    // 'partner_comp_contact' => $this->request->getPost('partner_comp_contact'),
                    // 'partner_position' => $this->request->getPost('partner_position'),
                    // 'partner_income' => $this->request->getPost('partner_income'),
                    // 'partner_long_working' => $this->request->getPost('partner_long_working'),
                    // 'partner_emp_status' => $this->request->getPost('partner_emp_status'),
                    // 'partner_img_ktp' => $file_name_ktp_partner, 
                    // 'created_by' =>  $this->session->get('id_user'), 
                ]);
                echo json_encode(["status" => true]);
                break;
            // case 'edit':
                // $foto_user = $this->request->getFile('foto_user');
                // if ($foto_user == '') {
                //     $file_name = $this->request->getPost('old_foto');
                // } else {
                //     $file_name = $foto_user->getRandomName();
                //     $foto_user->move('upload/foto_user', $file_name);
                // }

                // $this->userModel->update(['id' => $this->request->getPost('id')], [
                //     'full_name' => $this->request->getPost('full_name'),
                //     'email' => $this->request->getPost('email'),
                //     'foto_user' => $file_name,
                //     'group_level' => $this->request->getPost('group_level'),
                //     'updated_by' =>  $this->session->get('id_user')
                // ]);
                // echo json_encode(["status" => true]);
                // break;
        }
    }

    public function deleteData($id)
    {   
        $menu_detail = $this->menuModel->getByData(['nav_act' => 'data_anggota']);
        $menu_role = $this->menuRoleModel->getByData(['id_menu' => $menu_detail->id, 'group_level' => $this->session->get('group_level')]);

        if ($menu_role->delete_act == 'Y') {
            $anggota = $this->dataAnggotaModel->getByData(['id' => $id]);  // Pastikan data ditemukan
            if ($anggota) {
                $this->dataAnggotaModel->delete(['id' => $id]);
                echo json_encode(["status" => true]);
            } else {
                echo json_encode(["status" => false, "message" => "Data tidak ditemukan"]);
            }
        } else {
            echo json_encode(['status' => false, 'message' => 'Tidak dapat menghapus karena akses anda terbatas']);
        }
    }


    private function _validate($method)
    {
        $data = [];
        $data['error_string'] = [];
        $data['inputerror'] = [];
        $data['status'] = TRUE;

        $foto = $this->request->getFile('img_ktp');
        if (!empty($foto)) {
            $file_foto = $foto->getClientMimeType();
            $size = $foto->getSize();
            if ($file_foto != '' && $file_foto != 'image/jpeg' && $file_foto != 'image/jpg' && $file_foto != 'image/png') {
                $data['inputerror'][] = 'img_ktp';
                $data['error_string'][] = 'foto hanya png/jpg';
                $data['status'] = FALSE;
            }

            if ($size > 1048576) {
                $data['inputerror'][] = 'img_ktp';
                $data['error_string'][] = 'Ukuran foto terlalu besar. Max 1MB';
                $data['status'] = FALSE;
            }
        }

        $foto1 = $this->request->getFile('partner_img_ktp');
        if (!empty($foto1)) {
            $file_foto1 = $foto1->getClientMimeType();
            $size = $foto1->getSize();
            if ($file_foto1 != '' && $file_foto1 != 'image/jpeg' && $file_foto1 != 'image/jpg' && $file_foto1 != 'image/png') {
                $data['inputerror'][] = 'img_ktp';
                $data['error_string'][] = 'foto hanya png/jpg';
                $data['status'] = FALSE;
            }

            if ($size > 1048576) {
                $data['inputerror'][] = 'img_ktp';
                $data['error_string'][] = 'Ukuran foto terlalu besar. Max 1MB';
                $data['status'] = FALSE;
            }
        }

        // if ($method == 'add') {

        //     // =========================================================
        //     // User's identity 

        //     if ($this->request->getPost('img_ktp') == '') {
        //         $data['inputerror'][] = 'img_ktp';
        //         $data['error_string'][] = 'Gambar KTP perlu di isi';
        //         $data['status'] = FALSE;
        //     }

        //     if ($this->request->getPost('no_ktp') == '') {
        //         $data['inputerror'][] = 'no_ktp';
        //         $data['error_string'][] = 'Nomor Induk Kependudukan Wajib diisi';
        //         $data['status'] = FALSE;
        //     }

        //     if ($this->request->getPost('full_name') == '') {
        //         $data['inputerror'][] = 'full_name';
        //         $data['error_string'][] = 'Nama Lengkap wajib diisi';
        //         $data['status'] = FALSE;
        //     }

        //     if ($this->request->getPost('address') == '') {
        //         $data['inputerror'][] = 'address';
        //         $data['error_string'][] = 'Alamat wajib diisi';
        //         $data['status'] = FALSE;
        //     }

        //     if ($this->request->getPost('contact') == '') {
        //         $data['inputerror'][] = 'contact';
        //         $data['error_string'][] = 'Nomor telepon wajib diisi';
        //         $data['status'] = FALSE;
        //     }

        //     if ($this->request->getPost('pob') == '') {
        //         $data['inputerror'][] = 'pob';
        //         $data['error_string'][] = 'Tempat Lahir wajib diisi';
        //         $data['status'] = FALSE;
        //     }

        //     if ($this->request->getPost('dob') == '') {
        //         $data['inputerror'][] = 'dob';
        //         $data['error_string'][] = 'Tanggal Lahir wajib diisi';
        //         $data['status'] = FALSE;
        //     }
            
        //     if ($this->request->getPost('mothers_name') == '') {
        //         $data['inputerror'][] = 'mothers_name';
        //         $data['error_string'][] = 'Nama Ibu wajib diisi';
        //         $data['status'] = FALSE;
        //     }

        //     if ($this->request->getPost('marital_status') == '') {
        //         $data['inputerror'][] = 'marital_status';
        //         $data['error_string'][] = 'Status Perkawinan wajib diisi';
        //         $data['status'] = FALSE;
        //     }
            
        //     if ($this->request->getPost('profession') == '') {
        //         $data['inputerror'][] = 'profession';
        //         $data['error_string'][] = 'Profesi wajib diisi';
        //         $data['status'] = FALSE;
        //     }
            
        //     if ($this->request->getPost('company_name') == '') {
        //         $data['inputerror'][] = 'company_name';
        //         $data['error_string'][] = 'Nama perushaan wajib diisi';
        //         $data['status'] = FALSE;
        //     }
            
        //     if ($this->request->getPost('company_tlp') == '') {
        //         $data['inputerror'][] = 'company_tlp';
        //         $data['error_string'][] = 'Nomor telpon perusahaan wajib diisi';
        //         $data['status'] = FALSE;
        //     }

        //     if ($this->request->getPost('company_address') == '') {
        //         $data['inputerror'][] = 'company_address';
        //         $data['error_string'][] = 'ALamat perusahaan wajib diisi';
        //         $data['status'] = FALSE;
        //     }
            
        //     if ($this->request->getPost('job_position') == '') {
        //         $data['inputerror'][] = 'job_position';
        //         $data['error_string'][] = 'Jabatan wajib diisi';
        //         $data['status'] = FALSE;
        //     }
            
        //     if ($this->request->getPost('take_home_pay') == '') {
        //         $data['inputerror'][] = 'take_home_pay';
        //         $data['error_string'][] = 'Penghasilan wajib diisi';
        //         $data['status'] = FALSE;
        //     }
            
        //     if ($this->request->getPost('long_working') == '') {
        //         $data['inputerror'][] = 'long_working';
        //         $data['error_string'][] = 'Lama bekerja wajib diisi';
        //         $data['status'] = FALSE;
        //     }
            
        //     if ($this->request->getPost('employee_status') == '') {
        //         $data['inputerror'][] = 'employee_status';
        //         $data['error_string'][] = 'Status Karyawan wajib diisi';
        //         $data['status'] = FALSE;
        //     }

        //     // // =========================================================
        //     // // kerabat yang dapat dihubungi 

        //     if ($this->request->getPost('family_name') == '') {
        //         $data['inputerror'][] = 'family_name';
        //         $data['error_string'][] = 'Nama keluarga wajib diisi';
        //         $data['status'] = FALSE;
        //     }
            
        //     if ($this->request->getPost('family_contact') == '') {
        //         $data['inputerror'][] = 'family_contact';
        //         $data['error_string'][] = 'Nomor telpon kerabat perlu diisi';
        //         $data['status'] = FALSE;
        //     }
            
        //     if ($this->request->getPost('family_address') == '') {
        //         $data['inputerror'][] = 'family_address';
        //         $data['error_string'][] = 'Alamat keluarga perlu diisi';
        //         $data['status'] = FALSE;
        //     }
            
        //     if ($this->request->getPost('family_relationship_status') == '') {
        //         $data['inputerror'][] = 'family_relationship_status';
        //         $data['error_string'][] = 'Hubungan dengan kerabat perlu diisi';
        //         $data['status'] = FALSE;
        //     }
        //     if ($this->request->getPost('is_join_come') == '') {
        //         $data['inputerror'][] = 'is_join_come';
        //         $data['error_string'][] = 'Informasi ini wajib diisi';
        //         $data['status'] = FALSE;
        //     }
        //     elseif ($this->request->getPost('is_join_come') == 'Y') {
        //     // } elseif ($this->request->getPost('is_join_come') == 'Y') {
        //         // =========================================================
        //         // Partner's Identity
                
        //         if ($this->request->getPost('partner_img_ktp') == '') {
        //             $data['inputerror'][] = 'partner_img_ktp';
        //             $data['error_string'][] = 'Gambar KTP perlu di isi';
        //             $data['status'] = FALSE;
        //         }

        //         if ($this->request->getPost('partner_ktp') == '') {
        //             $data['inputerror'][] = 'partner_ktp';
        //             $data['error_string'][] = 'Nomor Induk Kependudukan perlu diisi';
        //             $data['status'] = FALSE;
        //         }
                
        //         if ($this->request->getPost('partner_name') == '') {
        //             $data['inputerror'][] = 'partner_name';
        //             $data['error_string'][] = 'Nama partner wajib diisi';
        //             $data['status'] = FALSE;
        //         }

        //         if ($this->request->getPost('partner_address') == '') {
        //             $data['inputerror'][] = 'partner_address';
        //             $data['error_string'][] = 'Alamat wajib diisi';
        //             $data['status'] = FALSE;
        //         }

        //         if ($this->request->getPost('partner_contact') == '') {
        //             $data['inputerror'][] = 'partner_contact';
        //             $data['error_string'][] = 'Nomor Telpon wajib diisi';
        //             $data['status'] = FALSE;
        //         }

        //         if ($this->request->getPost('partner_pob') == '') {
        //             $data['inputerror'][] = 'partner_pob';
        //             $data['error_string'][] = 'Tempat lahir wajib diisi';
        //             $data['status'] = FALSE;
        //         }

        //         if ($this->request->getPost('partner_dob') == '') {
        //             $data['inputerror'][] = 'partner_dob';
        //             $data['error_string'][] = 'Tanggal lahir wajib diisi';
        //             $data['status'] = FALSE;
        //         }

        //         if ($this->request->getPost('partner_mothers_name') == '') {
        //             $data['inputerror'][] = 'partner_mothers_name';
        //             $data['error_string'][] = 'Nama Ibu wajib diisi';
        //             $data['status'] = FALSE;
        //         }

        //         if ($this->request->getPost('partner_profession') == '') {
        //             $data['inputerror'][] = 'partner_profession';
        //             $data['error_string'][] = 'Profesi wajib diisi';
        //             $data['status'] = FALSE;
        //         }

        //         if ($this->request->getPost('partner_comp_name') == '') {
        //             $data['inputerror'][] = 'partner_comp_name';
        //             $data['error_string'][] = 'Nama Perushaan wajib diisi';
        //             $data['status'] = FALSE;
        //         }

        //         if ($this->request->getPost('partner_comp_address') == '') {
        //             $data['inputerror'][] = 'partner_comp_address';
        //             $data['error_string'][] = 'Alamat perusahaan wajib diisi';
        //             $data['status'] = FALSE;
        //         }

        //         if ($this->request->getPost('partner_comp_contact') == '') {
        //             $data['inputerror'][] = 'partner_comp_contact';
        //             $data['error_string'][] = 'Nomor telpon perushaan wajib diisi';
        //             $data['status'] = FALSE;
        //         }

        //         if ($this->request->getPost('partner_position') == '') {
        //             $data['inputerror'][] = 'partner_position';
        //             $data['error_string'][] = 'Jabatan wajib diisi';
        //             $data['status'] = FALSE;
        //         }

        //         if ($this->request->getPost('partner_income') == '') {
        //             $data['inputerror'][] = 'partner_income';
        //             $data['error_string'][] = 'Pernghasilan wajib diisi';
        //             $data['status'] = FALSE;
        //         }

        //         if ($this->request->getPost('partner_long_working') == '') {
        //             $data['inputerror'][] = 'partner_long_working';
        //             $data['error_string'][] = 'Lama bekerja wajib diisi';
        //             $data['status'] = FALSE;
        //         }

        //         if ($this->request->getPost('partner_emp_status') == '') {
        //             $data['inputerror'][] = 'partner_emp_status';
        //             $data['error_string'][] = 'Status Karyawan wajib diisi';
        //             $data['status'] = FALSE;
        //         }
        //     }
        // }

        if ($data['status'] === FALSE) {
            echo json_encode($data);
            exit();
        }
    }
}
