<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Supplier extends RAST_Control {

    private $data;

    function __construct() {
        parent::__construct();

        if ($this->session->userdata('level') != 1 && $this->session->userdata('level') != 3) {
            redirect('dashboard');
        }

        $this->load->model('M_supplier');
    }

    function index() {
        $this->session->set_userdata('supplier_id', NULL);
        
        $isi = array(
            'descript' => 'Supplier Bahan Baku'
            , 'dataTable' => $this->M_supplier->get_list()
            , 'add_button' => (($this->session->userdata('outlet_id') != 'all') ? true : false)
            , 'back_button' => false
        );

        $this->set_page('supplier', 'Supplier', $isi['descript'], '<li class="active">Supplier</li>', 'supplier', $isi);
    }

    function form() {
    	$this->output->set_content_type('application/json');

    	$id = $_POST['id'];
        echo json_encode($this->M_supplier->get_isi($id));
    }

    function process() {
        $post = $_POST;
        if ($this->M_supplier->process($post)) {
            $this->session->set_userdata('pesan_sistem', 'Selamat! ' . (($post['supplier_id'] == '') ? 'Penambahan' : 'Perubahan') . ' supplier, SUKSES!');
            $this->session->set_userdata('tipe_pesan', 'Sukses');
            redirect('supplier');
        } else {
            $this->session->set_userdata('pesan_sistem', 'Maaf! ' . (($post['supplier_id'] == '') ? 'Penambahan' : 'Perubahan') . ' supplier, GAGAL! Silahkan periksa dan coba kembali');
            $this->session->set_userdata('tipe_pesan', 'Gagal');
            redirect('supplier');
        }
    }

    function delete($a) {
        if ($this->M_supplier->delete($a)) {
            $this->session->set_userdata('pesan_sistem', 'Selamat! Supplier telah dihapus!');
            $this->session->set_userdata('tipe_pesan', 'Sukses');
            redirect('supplier');
        } else {
            $this->session->set_userdata('pesan_sistem', 'Maaf! Supplier tidak terhapus! Silahkan periksa dan coba kembali');
            $this->session->set_userdata('tipe_pesan', 'Gagal');
            redirect('supplier');
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
