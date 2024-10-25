<?php

namespace App\Models;

use CodeIgniter\Model;

class Meta_Data_Model extends Model
{
    protected $table = 'tb_meta_data';
    protected $primaryKey = 'id';
    protected $useTimestamps = true;
    protected $allowedFields = [
        'id', 'meta_key', 'meta_name', 'position'
    ];

    public function getByData($data)
    {
        $query = $this->getwhere($data);
        return $query->getRow();
    }

    public function getByMetaKey($metaKey)
    {
        return $this->where('meta_key', $metaKey)->get()->getResult();
    }
}