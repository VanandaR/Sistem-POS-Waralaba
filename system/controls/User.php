<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User extends RAST_Control {

    private $data;

    function __construct() {
        parent::__construct();

        if ($this->session->userdata('level') != 1 && $this->session->userdata('level') != 2 && $this->session->userdata('level') != 3 && $this->session->userdata('level') != 4) {
            redirect('dashboard');
        }

        $this->load->model('M_user');
    }

    function index() {
        if ($this->session->userdata('level') != 1) {
            redirect('dashboard');
        }
//         $this->session->set_userdata('user_id', NULL);
        
        $isi = array(
            'descript' => 'Pengguna Pada Sistem'
            , 'dataTable' => $this->M_user->get_list()
            , 'outlet' => $this->M_user->outlet_list()
            , 'add_button' => true
            , 'back_button' => false
        );

        $this->set_page('user', 'User', $isi['descript'], '<li class="active">User</li>', 'user', $isi);
    }

    function form() {
    	$this->output->set_content_type('application/json');

    	$id = $_POST['id'];
        echo json_encode($this->M_user->get_isi($id));
    }

//     function form($id = '') {
//         if ($this->session->userdata('level') != 1) {
//             redirect('dashboard');
//         }
//         if ($id != '') {
//             $this->session->set_userdata('user_id', $id);
//             redirect('user/form');
//         }
// 
//         $idnew = (($this->session->userdata('user_id') == NULL) ? '' : $this->session->userdata('user_id'));
// 
//         $isi = array(
//             'descript' => (($idnew == '') ? 'Tambah ' : 'Ubah ') . 'Data User'
//             , 'isi' => NULL
//         );
// 
//         if ($idnew != NULL) {
//             $isi['isi'] = $this->M_user->get_isi($idnew);
//             if ($isi['isi'] == NULL) {
//                 redirect('user/form');
//             }
//         }
// 
//         $this->set_page('user', 'User', $isi['descript'], '<li><a href="' . base_url() . 'user">User</a></li><li class="active">' . (($idnew == NULL) ? 'Tambah' : 'Ubah') . ' Data User</li>', 'user_form', $isi);
//     }

    function changePassword() {
        $isi = array(
            'descript' => 'Ubah Password User'
            , 'isi' => NULL
        );
        $this->set_page('user', 'User', $isi['descript'], '<li class="active">Ubah Password User</li>', 'changePassword', $isi);
    }

    function changePassword_process() {
        $post = $_POST;
        if ($post['new_password'] == $post['confirm_password']) {
            if ($this->M_user->changePassword_process($post)) {
                $this->session->set_userdata('pesan_sistem', 'Selamat! Perubahan password, SUKSES!');
                $this->session->set_userdata('tipe_pesan', 'Sukses');
                redirect('login/logout');
            } else {
                $this->session->set_userdata('pesan_sistem', 'Maaf! Perubahan password, GAGAL! Silahkan periksa dan coba kembali');
                $this->session->set_userdata('tipe_pesan', 'Gagal');
                redirect('user/changePassword');
            }
        } else {
            $this->session->set_userdata('pesan_sistem', 'Konfirmasi password tidak sesuai dengan password baru! Silahkan periksa dan coba kembali');
            $this->session->set_userdata('tipe_pesan', 'Gagal');
            redirect('user/changePassword');
        }
    }

	function outlet_list() {
    	$this->output->set_content_type('application/json');

    	$id = $_POST['id'];
        echo json_encode($this->M_user->get_user_outlet_list($id));
	}

	function outlet_save() {
    	$this->output->set_content_type('application/json');
		
		$post = $_POST;
		if ($this->M_user->process_outlet($post, "process")) {
			echo json_encode($this->M_user->get_user_outlet_list($post['user_id']));
		} else {
			echo "{}";
		}
	}

	function outlet_delete() {
    	$this->output->set_content_type('application/json');
		
		$post = $_POST;
		if ($this->M_user->process_outlet($post['id'], "delete")) {
			echo json_encode($this->M_user->get_user_outlet_list($post['user_id']));
		} else {
			echo "{}";
		}
	}

//     function setOutlet($id = '', $kind = '') {
//         if ($id != '') {
//             if ($kind != 'delete') {
//                 $this->session->set_userdata('user_outlet_id', $id);
//             }
// 
//             if ($kind == 'process') {
//                 $post = $_POST;
//                 if ($this->M_user->process_material($post, $kind)) {
//                     $this->session->set_userdata('pesan_sistem', 'Selamat! Penambahan Hak Akses, SUKSES!');
//                     $this->session->set_userdata('tipe_pesan', 'Sukses');
//                     redirect('user/setOutlet/' . $id);
//                 } else {
//                     $this->session->set_userdata('pesan_sistem', 'Maaf! Penambahan Hak Akses, GAGAL! Silahkan periksa dan coba kembali');
//                     $this->session->set_userdata('tipe_pesan', 'Gagal');
//                     redirect('user/setOutlet/' . $id);
//                 }
//             } else if ($kind == 'delete') {
//                 if ($this->M_user->process_material($id, $kind)) {
//                     $this->session->set_userdata('pesan_sistem', 'Selamat! Data berhasil dihapus!');
//                     $this->session->set_userdata('tipe_pesan', 'Sukses');
//                     redirect('user/setOutlet/' . $this->session->userdata('user_outlet_id'));
//                 } else {
//                     $this->session->set_userdata('pesan_sistem', 'Maaf! Data gagal dihapus! Silahkan periksa dan coba kembali');
//                     $this->session->set_userdata('tipe_pesan', 'Gagal');
//                     redirect('user/setOutlet/' . $this->session->userdata('user_outlet_id'));
//                 }
//             }
//             redirect('user/setOutlet');
//         }
// 
//         $user_idnew = (($this->session->userdata('user_outlet_id') == NULL) ? '' : $this->session->userdata('user_outlet_id'));
//         $isi = array(
//             'descript' => 'List Hak Akses Outlet'
//             , 'outlet' => $this->M_user->outlet_list()
//             , 'user' => $this->M_user->user_name($user_idnew)
//             , 'dataTable' => NULL
//         );
// 
//         if ($user_idnew != NULL) {
//             $isi['dataTable'] = $this->M_user->get_user_outlet_list($user_idnew);
//         }
// 
//         $this->set_page('user', 'User pada Outlet', $isi['descript'], '<li><a href="' . base_url() . 'user">User</a></li><li class="active">List Hak Akses User</li>', 'user_outlet', $isi);
//     }

    function process() {
        $post = $_POST;
        if ($this->M_user->process($post)) {
            $this->session->set_userdata('pesan_sistem', 'Selamat! ' . (($post['user_id'] == '') ? 'Penambahan' : 'Perubahan') . ' user, SUKSES!');
            $this->session->set_userdata('tipe_pesan', 'Sukses');
            redirect('user');
        } else {
            $this->session->set_userdata('pesan_sistem', 'Maaf! ' . (($post['user_id'] == '') ? 'Penambahan' : 'Perubahan') . ' user, GAGAL! Silahkan periksa dan coba kembali');
            $this->session->set_userdata('tipe_pesan', 'Gagal');
            redirect('user');
        }
    }

    function delete($a) {
        if ($this->M_user->delete($a)) {
            $this->session->set_userdata('pesan_sistem', 'Selamat! User telah dihapus!');
            $this->session->set_userdata('tipe_pesan', 'Sukses');
            redirect('user');
        } else {
            $this->session->set_userdata('pesan_sistem', 'Maaf! User tidak terhapus! Silahkan periksa dan coba kembali');
            $this->session->set_userdata('tipe_pesan', 'Gagal');
            redirect('user');
        }
    }

    function set_page($menu, $page, $descript, $breadcrumb, $file, $isi) {
        $data['menu'] = $menu;
        $data['page'] = $page;
        $data['descript'] = $descript;
        $data['breadcrumb'] = $breadcrumb;

        $data['content'] = $this->load->view($file, $isi, TRUE);
        $this->load->view('template/template', $data);
    }
}
