<?php

namespace App\Controllers;

use App\Models\Menu_Model;

class Dashboard extends BaseController
{
    protected $menuModel;

    public function __construct()
    {
        $this->menuModel = new Menu_Model();
    }

    public function index()
    {
        date_default_timezone_set("Asia/Jakarta");
        $session = session();
        $id_user = $session->get('id_user');
        if ($id_user) {

            $data['data_menu'] = $this->menuModel->getMenu();
            $data['menu'] = ['cek_main' => '', 'cek_page' => 'dashboard'];
            $data['title'] = 'Dashboard';
            $data['content'] = 'dashboard/dashboard';
            $data['content_foot'] = 'dashboard/dashboard_foot';
            return view('layout/wrapper', $data);
        } else {
            return redirect()->to(base_url('login'));
        }
    }
}
?>