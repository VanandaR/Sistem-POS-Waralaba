<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Sales extends RAST_Control {

    private $data;

    function __construct() {
        parent::__construct();

        if (($this->session->userdata('level') != 1 && $this->session->userdata('level') != 3) || $this->session->userdata('outlet_id') == 'all') {
            redirect('dashboard');
        }

        $this->load->model('M_sales');
        $this->load->model('M_category');
    }

    function index($id = NULL) {
        if ($this->session->userdata('user_id') == '' || $this->session->userdata('user_id') == NULL) {
            redirect('login/logout');
        }
        
        $this->session->set_userdata('sale_id', $id);
        
        $isi = array(
            'descript' => 'Input Penjualan'
            , 'food_menu' => $this->M_sales->food_menu_list()
            , 'member' => $this->M_sales->member_list()
            , 'category' => $this->M_category->get_list()
            , 'add_button' => false
            , 'back_button' => false
        );

        $this->set_page('sales', 'Input Penjualan', $isi['descript'], '<li class="active">Penjualan</li>', 'sales', $isi);
    }

    function save() {

        $post = $_POST;
        if ($this->M_sales->save($post)) {
            $this->session->set_userdata('pesan_sistem', 'Selamat! Record Data Penjualan telah disimpan!');
            $this->session->set_userdata('tipe_pesan', 'Sukses');
            redirect('sales');
        } else {
            $this->session->set_userdata('pesan_sistem', 'Maaf! Record Stok Penjualan gagal tersimpan! Silahkan periksa dan coba kembali');
            $this->session->set_userdata('tipe_pesan', 'Gagal');
            redirect('sales');
        }
    }
    function discount() {
        $this->output->set_content_type('application/json');

        $jumlah_makanan = $_POST['inp'];
        $id_makanan = 2;
        //$totalharga=$_POST['totalharga'];

        echo json_encode($this->M_sales->get_discount($id_makanan));
    }
    function nota(){
        $isi = array(
            '' => 'Tambah Stok Bahan Baku'
        , 'inmaterial' => $this->m_inmaterial->get_list()
        );
        $this->load->view('nota', $isi);
//        $this->set_page('nota', 'Tambah Stock Bahan Baku', $isi['descript'], '<li class="active">Nota</li>', 'nota', $isi);
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
