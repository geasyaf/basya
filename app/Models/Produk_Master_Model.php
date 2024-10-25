<?php

namespace App\Models;

use CodeIgniter\Model;

class Produk_Master_Model extends Model
{
    protected $table = 'tb_product';
    protected $primaryKey = 'id';
    protected $useTimestamps = true;

    protected $createdField  = 'created_on';
    protected $updatedField  = '';
    protected $allowedFields = [
        'id', 'prod_name', 'prod_id', 'prod_desc', 'prod_type', 'is_active', 'created_on', 'created_by',
    ];

    public function getByData($data)
    {
        $query = $this->getwhere($data);
        return $query->getRow();
    }
    public function listData()
    {
        $this->select('id, prod_id, prod_name, is_active');
        $query = $this->get();
        return $query->getResult();
    }
}