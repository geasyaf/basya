<?php

namespace App\Controllers;

use App\Models\Users_Model;

class Login extends BaseController
{   
    protected $userModel; 

    public function __construct()
    {
        $this->userModel = new Users_Model();
    }

    public function index()
    {
        $session = session();

        $userid = $session->get('id_user');

        if ($userid) {
            return redirect()->to(base_url());
        } else {
            return view('layout/login');
        }
    }
    public function action()
    {
        date_default_timezone_set('Asia/Jakarta');
        $session = session();
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $where = [
            'username' => $username
        ];

        $get_data = $this->userModel->getByData($where);

        if ($get_data) {
            $pass = $get_data->password;

            if (password_verify($password, $pass)) {
                if ($get_data->aktif == 'Y') {
                    $set_session = [
                        'id_user' => $get_data->id,
                        'nama' => $get_data->full_name,
                        'email' => $get_data->email,
                        'foto' => $get_data->foto_user,
                        'group_level' => $get_data->group_level,
                        'last_login' => $get_data->last_login
                    ];

                    $session->set($set_session);
                    // Update Last Login
                    $this->userModel->save([
                        'id' => $get_data->id,
                        'last_login' => date("Y-m-d H:i:s")
                    ]);
                    echo json_encode(['status' => true, 'message' => 'login sukses']);
                } else {
                    echo json_encode(['status' => false, 'message' => 'Username ' . $username . ' telah di nonaktifkan atau dihapus']);
                }
            } else {
                echo json_encode(['status' => false, 'message' => 'Username atau password salah']);
            }
        } else {
            echo json_encode(['status' => false, 'message' => 'Username atau password tidak ditemukan']);
        }
    }
    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to(base_url());
    }
}
?>
