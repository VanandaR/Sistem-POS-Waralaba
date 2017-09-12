<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Receipt extends RAST_Control {

    private $data;

    function __construct() {
        parent::__construct();

        if (!$this->session->userdata('level') == 1 && !$this->session->userdata('level') == 3) {
            redirect('dashboard');
        }

        $this->load->model('M_receipt');
    }

    function index() {
        $this->session->set_userdata('receipt_id', NULL);

        $isi = array(
            'descript' => 'Resep Makanan'
        , 'dataTable' => $this->M_receipt->get_list()
        , 'food_menu' => $this->M_receipt->food_menu_list()
        , 'material' => $this->M_receipt->material_list()
        , 'add_button' => (($this->session->userdata('outlet_id') != 'all') ? true : false)
        , 'back_button' => false
        );

        $this->set_page('receipt', 'Bahan Baku', $isi['descript'], '<li class="active">Bahan Baku</li>', 'receipt', $isi);
    }

    function form() {
        $this->output->set_content_type('application/json');

        $id = $_POST['id'];
        echo json_encode($this->M_receipt->get_isi($id));
    }

    function process() {
        $post = $_POST;
        if ($this->M_receipt->process($post)) {
            $this->session->set_userdata('pesan_sistem', 'Selamat! ' . (($post['member_id'] == '') ? 'Penambahan' : 'Perubahan') . ' receipt, SUKSES!');
            $this->session->set_userdata('tipe_pesan', 'Sukses');
            redirect('receipt');
        } else {
            $this->session->set_userdata('pesan_sistem', 'Maaf! ' . (($post['member_id'] == '') ? 'Penambahan' : 'Perubahan') . ' receipt, GAGAL! Silahkan periksa dan coba kembali');
            $this->session->set_userdata('tipe_pesan', 'Gagal');
            redirect('receipt');
        }
    }

    function delete($a) {
        if ($this->M_receipt->delete($a)) {
            $this->session->set_userdata('pesan_sistem', 'Selamat! Bahan Baku telah dihapus!');
            $this->session->set_userdata('tipe_pesan', 'Sukses');
            redirect('receipt');
        } else {
            $this->session->set_userdata('pesan_sistem', 'Maaf! Bahan Baku tidak terhapus! Silahkan periksa dan coba kembali');
            $this->session->set_userdata('tipe_pesan', 'Gagal');
            redirect('receipt');
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
