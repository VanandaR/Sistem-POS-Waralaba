<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Discount extends RAST_Control {

    private $data;

    function __construct() {
        parent::__construct();

        if (!$this->session->userdata('level') == 1 && !$this->session->userdata('level') == 5) {
            redirect('dashboard');
        }

        $this->load->model('M_discount');
    }

    function index($id = NULL) {
        $this->session->set_userdata('discount_id', $id);

        $isi = array(
            'descript' => 'Daftar Diskon'
        , 'dataTable' => $this->M_discount->get_list()
        , 'produk' => $this->M_discount->get_product()
        , 'kategori' => $this->M_discount->get_category()
        , 'discount_product' => $this->M_discount->discount_product_list()
        , 'discount_type' => $this->M_discount->discount_type_list()
        , 'add_button' => true
        , 'back_button' => false
        );

        $this->set_page('discount', 'Daftar Diskon', $isi['descript'], '<li class="active">Diskon</li>', 'discount', $isi);
    }

    function material_list() {
        $this->output->set_content_type('application/json');

        $id = $_POST['id'];
        echo json_encode($this->M_discount->material_list($id));
    }

    function process($id = '') {
        $post = $_POST;
        if ($post['discount_id'] == '') {

            if ($this->M_discount->process($post)) {
                $this->session->set_userdata('pesan_sistem', 'Selamat! Penambahan Distribusi Bahan Baku, SUKSES!');
                $this->session->set_userdata('tipe_pesan', 'Sukses');
                redirect('discount');
            } else {
                $this->session->set_userdata('pesan_sistem', 'Maaf! Penambahan Distribusi Bahan Baku, GAGAL! Silahkan periksa dan coba kembali');
                $this->session->set_userdata('tipe_pesan', 'Gagal');
                redirect('discount');
            }
        } else {
            if ($this->M_discount->process($post)) {
                $this->session->set_userdata('pesan_sistem', 'Selamat! Perubahan Distribusi Bahan Baku, SUKSES!');
                $this->session->set_userdata('tipe_pesan', 'Sukses');
                redirect('discount');
            } else {
                $this->session->set_userdata('pesan_sistem', 'Maaf! Perubahan Distribusi Bahan Baku, GAGAL! Silahkan periksa dan coba kembali');
                $this->session->set_userdata('tipe_pesan', 'Gagal');
                redirect('discount');
            }
        }
    }
    function form() {
        $this->output->set_content_type('application/json');

        $id = $_POST['id'];
        echo json_encode($this->M_discount->get_isi($id));
    }
    function delete($id) {

        if ($this->M_discount->delete($id)) {
            $this->session->set_userdata('pesan_sistem', 'Selamat! Distribusi Bahan Baku telah dihapus!');
            $this->session->set_userdata('tipe_pesan', 'Sukses');
            redirect('discount');
        } else {
            $this->session->set_userdata('pesan_sistem', 'Maaf! Distribusi Bahan Baku tidak terhapus! Silahkan periksa dan coba kembali');
            $this->session->set_userdata('tipe_pesan', 'Gagal');
            redirect('discount');
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
