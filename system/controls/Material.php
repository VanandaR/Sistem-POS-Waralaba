<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Material extends RAST_Control {

    private $data;

    function __construct() {
        parent::__construct();

        if (!$this->session->userdata('level') == 1 && !$this->session->userdata('level') == 3) {
            redirect('dashboard');
        }

        $this->load->model('M_material');
    }

    function index() {
        $this->session->set_userdata('material_id', NULL);
        
        $isi = array(
            'descript' => 'Bahan Baku'
            , 'dataTable' => $this->M_material->get_list()
            , 'supplier' => (($this->session->userdata('outlet_id') != 'all') ? $this->M_material->supplier_list() : NULL)
            , 'add_button' => (($this->session->userdata('outlet_id') != 'all') ? true : false)
            , 'back_button' => false
        );

        $this->set_page('material', 'Bahan Baku', $isi['descript'], '<li class="active">Bahan Baku</li>', 'material', $isi);
    }

    function form() {
    	$this->output->set_content_type('application/json');

    	$id = $_POST['id'];
        echo json_encode($this->M_material->get_isi($id));
    }

    function process() {
        $post = $_POST;
        if ($this->M_material->process($post)) {
            $this->session->set_userdata('pesan_sistem', 'Selamat! ' . (($post['member_id'] == '') ? 'Penambahan' : 'Perubahan') . ' material, SUKSES!');
            $this->session->set_userdata('tipe_pesan', 'Sukses');
            redirect('material');
        } else {
            $this->session->set_userdata('pesan_sistem', 'Maaf! ' . (($post['member_id'] == '') ? 'Penambahan' : 'Perubahan') . ' material, GAGAL! Silahkan periksa dan coba kembali');
            $this->session->set_userdata('tipe_pesan', 'Gagal');
            redirect('material');
        }
    }
    function revision() {
        $post = $_POST;
        if ($this->M_material->revision($post)) {
            $this->session->set_userdata('pesan_sistem', 'Selamat! ' . (($post['member_id'] == '') ? 'Penambahan' : 'Perubahan') . ' material, SUKSES!');
            $this->session->set_userdata('tipe_pesan', 'Sukses');
            redirect('material');
        }
    }

    function delete($a) {
        if ($this->M_material->delete($a)) {
            $this->session->set_userdata('pesan_sistem', 'Selamat! Bahan Baku telah dihapus!');
            $this->session->set_userdata('tipe_pesan', 'Sukses');
            redirect('material');
        } else {
            $this->session->set_userdata('pesan_sistem', 'Maaf! Bahan Baku tidak terhapus! Silahkan periksa dan coba kembali');
            $this->session->set_userdata('tipe_pesan', 'Gagal');
            redirect('material');
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
