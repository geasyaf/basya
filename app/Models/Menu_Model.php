<?php

namespace App\Models;

use CodeIgniter\Model;

class Menu_Model extends Model
{
    protected $table = 'sys_menu';
    protected $primaryKey = 'id';
    protected $useTimestamps = true;
    protected $allowedFields = [
        'nav_act', 'page_name', 'url', 'main_table', 'icon', 'urutan_menu', 'parent', 'dt_table', 'tampil', 'type_menu', 'created_by', 'updated_by'
    ];

    public function getByData($data)
    {
        $query = $this->getwhere($data);
        return $query->getRow();
    }

    public function listData()
    {
        $this->select('sys_menu.id, sys_menu.nav_act, sys_menu.page_name, sys_menu.url, sys_menu.main_table, sys_menu.icon, sys_menu.urutan_menu, sys_menu.tampil, sys_menu.type_menu, a.page_name as parent_name, sys_users.full_name as created');
        $this->join('sys_menu a', 'a.id = sys_menu.parent', 'left');
        $this->join('sys_users', 'sys_users.id = sys_menu.created_by');
        $query = $this->get();
        return $query->getResult();
    }

    public function listDataByType($type)
    {
        $query = $this->getWhere(['type_menu' => $type]);
        return $query->getResult();
    }

    public function getUrutanByType($type, $parent)
    {
        if ($parent == '') {
            $where = ['parent' => 0];
        } else {
            $where = ['type_menu' => $type, 'parent' => $parent];
        }
        $this->select('urutan_menu');
        $this->orderBy('urutan_menu', 'desc');
        $query = $this->getWhere($where);
        return $query->getRow();
    }

    public function getMenu()
    {
        $session = session();
        $data_main = $this->getByType(['tampil' => 'Y', 'parent' => '0']);
        $result = [];
        $result['main_menu'] = [];
        $result['page_menu'] = [];
        foreach ($data_main as $main) {
            $role_main = $this->getRole(['id_menu' => $main->id, 'group_level' => $session->get('group_level')]);
            if ($role_main) {
                if ($role_main->read_act == 'Y') {
                    $result['main_menu'][] = [
                        'id' => $main->id,
                        'nav_act' => $main->nav_act,
                        'page_name' => $main->page_name,
                        'url' => $main->url,
                        'icon' => $main->icon,
                        'type_menu' => $main->type_menu
                    ];
                }
            }
            $data_page = $this->getByType(['tampil' => 'Y', 'type_menu' => 'page', 'parent' => $main->id]);
            foreach ($data_page as $page) {
                $role_page = $this->getRole(['id_menu' => $page->id, 'group_level' => $session->get('group_level')]);
                if ($role_page) {
                    if ($role_page->read_act == 'Y') {
                        $result['page_menu'][] = [
                            'parent_id' => $main->id,
                            'id' => $page->id,
                            'nav_act' => $page->nav_act,
                            'page_name' => $page->page_name,
                            'url' => $page->url,
                            'icon' => $page->icon,
                            'type_menu' => $page->type_menu
                        ];
                    }
                }
            }
        }
        return $result;
    }

    public function getByType($type)
    {
        $this->orderBy('urutan_menu', 'asc');
        $query = $this->getwhere($type);
        return $query->getResult();
    }

    private function getRole($data)
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('sys_menu_role');
        $query   = $builder->getwhere($data);
        return $query->getRow();
    }
}
