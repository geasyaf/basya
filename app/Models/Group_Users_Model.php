<?php

namespace App\Models;

use CodeIgniter\Model;

class Group_Users_Model extends Model
{
    protected $table = 'sys_group_users';
    protected $primaryKey = 'id';
    protected $useTimestamps = true;
    protected $allowedFields = [
        'level', 'level_name', 'deskripsi', 'created_by', 'updated_by'
    ];

    public function getByData($data)
    {
        $query = $this->getwhere($data);
        return $query->getRow();
    }

    public function listData()
    {
        $this->select('sys_group_users.id, sys_group_users.level, sys_group_users.level_name, sys_group_users.deskripsi, sys_users.full_name as created');
        $this->join('sys_users', 'sys_users.id = sys_group_users.created_by');
        $query = $this->get();
        return $query->getResult();
    }
}
