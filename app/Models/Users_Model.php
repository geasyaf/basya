<?php

namespace App\Models;

use CodeIgniter\Model;

class Users_Model extends Model
{
    protected $table = 'sys_users';
    protected $primaryKey = 'id';
    protected $useTimestamps = true;
    protected $allowedFields = [
        'full_name', 'username', 'password', 'email', 'foto_user', 'group_level', 'aktif', 'token', 'token_expiration', 'last_login', 'created_by', 'updated_by'
    ];

    public function getByData($data)
    {
        $query = $this->getwhere($data);
        return $query->getRow();
    }

    public function listData()
    {
        $this->select('sys_users.id, sys_users.full_name, sys_users.username, sys_users.email, sys_users.foto_user, sys_users.group_level, sys_users.aktif, sys_users.last_login, sys_users.created_by, a.full_name as created');
        $this->join('sys_users a', 'a.id = sys_users.created_by');
        $query = $this->getwhere(['sys_users.aktif !=' => 'D']);
        return $query->getResult();
    }
}
