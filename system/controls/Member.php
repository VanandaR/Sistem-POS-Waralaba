<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Member extends RAST_Control {

    private $data;

    function __construct() {
        parent::__construct();

        if ($this->session->userdata('level') != 1 && $this->session->userdata('level') != 2) {
            redirect('dashboard');
        }

        $this->load->model('M_member');
    }

    function index() {
        $this->session->set_userdata('member_id', NULL);
        
        $isi = array(
            'descript' => 'Member Mr. BIG Store'
            , 'dataTable' => $this->M_member->get_list()
            , 'add_button' => (($this->session->userdata('outlet_id') != 'all') ? true : false)
            , 'back_button' => false
        );

        $this->set_page('member', 'Member', $isi['descript'], '<li class="active">Member</li>', 'member', $isi);
    }

    function form() {
    	$this->output->set_content_type('application/json');

    	$id = $_POST['id'];
        echo json_encode($this->M_member->get_isi($id));
    }

    function process() {
        $post = $_POST;
        if ($this->M_member->process($post)) {
            $this->session->set_userdata('pesan_sistem', 'Selamat! ' . (($post['member_id'] == '') ? 'Penambahan' : 'Perubahan') . ' member, SUKSES!');
            $this->session->set_userdata('tipe_pesan', 'Sukses');
            redirect('member');
        } else {
            $this->session->set_userdata('pesan_sistem', 'Maaf! ' . (($post['member_id'] == '') ? 'Penambahan' : 'Perubahan') . ' member, GAGAL! Silahkan periksa dan coba kembali');
            $this->session->set_userdata('tipe_pesan', 'Gagal');
            redirect('member');
        }
    }

    function delete($a) {
        if ($this->M_member->delete($a)) {
            $this->session->set_userdata('pesan_sistem', 'Selamat! Member telah dihapus!');
            $this->session->set_userdata('tipe_pesan', 'Sukses');
            redirect('member');
        } else {
            $this->session->set_userdata('pesan_sistem', 'Maaf! Member tidak terhapus! Silahkan periksa dan coba kembali');
            $this->session->set_userdata('tipe_pesan', 'Gagal');
            redirect('member');
        }
    }

    function set_page($menu, $page, $descript, $breadcrumb, $file, $isi) {
        $data['menu'] = $menu;
//         $data['page'] = $page;
        $data['descript'] = $descript;
//         $data['breadcrumb'] = $breadcrumb;

        $data['content'] = $this->load->view($file, $isi, TRUE);
        $this->load->view('template/template', $data);
    }
}
