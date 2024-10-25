<?php

namespace App\Models;

use CodeIgniter\Model;

class Data_Anggota_Model extends Model
{
    protected $table = 'tb_nasabah';
    protected $primaryKey = 'id';
    protected $useTimestamps = true;

    protected $createdField  = 'created_on';
    protected $updatedField  = '';
    protected $allowedFields = [
    'id', 'id_nasabah', 'type_nasabah', 'no_ktp', 'full_name', 'address', 'contact', 'pob', 'dob', 'mothers_name', 'email', 'marital_status', 'profession', 'company_address', 'company_name', 'company_tlp', 'job_position', 'take_home_pay', 'long_working', 'employee_status', 'img_ktp', 'family_name', 'family_contact', 'family_address', 'family_relationship_status', 'is_join_come', 'partner_name', 'partner_ktp', 'partner_address', 'partner_pob', 'partner_dob', 'partner_contact', 'partner_mothers_name', 'partner_email', 'partner_profession', 'partner_comp_name', 'partner_comp_address', 'partner_comp_contact', 'partner_position', 'partner_long_working', 'partner_income', 'partner_emp_status', 'partner_img_ktp', 'created_by', 'created_on'
    ];

    public function getByData($data)
    {
        $query = $this->getwhere($data);
        return $query->getRow();
    }

    public function listData()
    {
        $this->select('tb_nasabah.id, tb_nasabah.id_nasabah, tb_nasabah.no_ktp, tb_nasabah.full_name, tb_nasabah.contact, tb_meta_data.meta_name');
        $this->join('tb_meta_data', 'tb_nasabah.profession = tb_meta_data.id', 'left');
        $query = $this->get();
        return $query->getResult();
    }
    
    
}
