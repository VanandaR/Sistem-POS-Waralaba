<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Login extends RAST_Control {

    private $data;

    public function __construct() {
        parent::__construct();

        $this->load->model('M_login');
    }

//=====================================================
// View
//=====================================================

    function index() {
        if ($this->M_login->getUser() > 0) {
        	$this->load->view('choose_outlet');
//             redirect('dashboard');
        } else {
            $this->load->view('login');
        }
    }

    function choose_outlet($outlet_id) {
    	if ($outlet_id == 'all' && $this->session->userdata('level') != 1) {
    		$this->session->set_userdata('outlet_id', NULL);
			redirect('login/logout');
		}
    	if ($outlet_id == 'storage' && ($this->session->userdata('level') != 1 && $this->session->userdata('level') != 5)) {
    		$this->session->set_userdata('outlet_id', NULL);
			redirect('login/logout');
		}
    	if ($this->session->userdata('level') == 5 && $outlet_id != 'storage') {
    		$this->session->set_userdata('outlet_id', NULL);
			redirect('login/logout');
		}

		$this->session->set_userdata('outlet_id', $outlet_id);
		redirect('dashboard');
    }

    function choose_outlet2($outlet_id) {
    	if ($outlet_id == 'all' && $this->session->userdata('level') != 1) {
    		$this->session->set_userdata('outlet_id', NULL);
			redirect('login/logout');
		}
    	if ($outlet_id == 'storage' && ($this->session->userdata('level') != 1 && $this->session->userdata('level') != 5)) {
    		$this->session->set_userdata('outlet_id', NULL);
			redirect('login/logout');
		}
    	if ($this->session->userdata('level') == 5 && $outlet_id != 'storage') {
    		$this->session->set_userdata('outlet_id', NULL);
			redirect('login/logout');
		}

    	if ((($outlet_id == 'storage' && $this->session->userdata('outlet_id') != 'storage') || ($outlet_id != 'storage' && $this->session->userdata('outlet_id') == 'storage')) && ($this->session->userdata('level') == 1 || $this->session->userdata('level') == 5)) {
			$this->session->set_userdata('outlet_id', $outlet_id);
			redirect('dashboard');
		}

		$this->session->set_userdata('outlet_id', $outlet_id);
		header("Location: {$_SERVER['HTTP_REFERER']}");
		exit;
    }

//=====================================================
// End of View
//=====================================================
//
//
//
//
//
//=====================================================
// Process
//=====================================================

    function site() {
        if ($_POST) {
            $u = $_POST['username'];
            $p = $_POST['password'];

            if (empty($u) || empty($p)) {
                redirect('login');
            } else {
                if ($this->M_login->login($u, $p)) {
                    $this->session->set_userdata('pesan_sistem', 'Selamat! Anda berhasil login!');
                    $this->session->set_userdata('tipe_pesan', 'Sukses');
                    redirect('login');
                } else {
                    $this->session->set_userdata('pesan_sistem', 'Username atau Password SALAH!<br />Silahkan periksa dan coba kembali');
                    $this->session->set_userdata('tipe_pesan', 'Gagal');
                    redirect('login');
                }
            }
        }
    }

    function logout() {
        $this->session->sess_destroy();
        $deskripsi="Logout";
        $log = $this->db->query
        ('
                    INSERT INTO log VALUES
                    (
                        ' . "'" . "'" . '
                        , '.$this->session->userdata('user_id').'
                        , "'. $deskripsi.'"
                        , now()
                    )
                ');
        redirect('login');
    }

//=====================================================
// End of Process
//=====================================================
}
