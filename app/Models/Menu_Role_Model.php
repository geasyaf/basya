<?php

namespace App\Models;

use CodeIgniter\Model;

class Menu_Role_Model extends Model
{
    protected $table = 'sys_menu_role';
    protected $primaryKey = 'id';
    protected $useTimestamps = false;
    protected $allowedFields = [
        'id_menu', 'group_level', 'read_act', 'insert_act', 'update_act', 'delete_act', 'import_act'
    ];

    public function getByData($data)
    {
        $query = $this->getwhere($data);
        return $query->getRow();
    }
}
