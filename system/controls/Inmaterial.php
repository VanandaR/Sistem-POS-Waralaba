<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Inmaterial extends RAST_Control {

    private $data;

    function __construct() {
        parent::__construct();

        if ((!$this->session->userdata('level') == 1 && !$this->session->userdata('level') == 3) || $this->session->userdata('outlet_id') == 'all') {
            redirect('dashboard');
        }

        $this->load->model('M_inmaterial');
    }

    function index($id = NULL) {
        $this->session->set_userdata('inmaterial_id', $id);
        
        $isi = array(
            'descript' => 'Tambah Stok Bahan Baku'
            , 'isi' => ($id != NULL && $id != '') ? $this->M_inmaterial->get_isi($id) : NULL
            , 'material' => $this->M_inmaterial->material_list()
            , 'dataTable' => $this->M_inmaterial->get_list()
            , 'add_button' => false
            , 'back_button' => false
        );


        $this->set_page('inmaterial', 'Tambah Stock Bahan Baku', $isi['descript'], '<li class="active">Stok Masuk</li>', 'inmaterial', $isi);
    }

    function nota(){
        $isi = array(
            'descript' => 'Tambah Stok Bahan Baku'
        , 'inmaterial' => $this->M_inmaterial->get_list()
        );
        $this->load->view('nota', $isi);
//        $this->set_page('nota', 'Tambah Stock Bahan Baku', $isi['descript'], '<li class="active">Nota</li>', 'nota', $isi);
    }

    function process($id = '') {
        if ($id != '') {
            if ($this->M_inmaterial->delete($id)) {
                $this->session->set_userdata('pesan_sistem', 'Selamat! Stok Bahan Baku telah dihapus!');
                $this->session->set_userdata('tipe_pesan', 'Sukses');
                redirect('inmaterial');
            } else {
                $this->session->set_userdata('pesan_sistem', 'Maaf! Stok Bahan Baku tidak terhapus! Silahkan periksa dan coba kembali');
                $this->session->set_userdata('tipe_pesan', 'Gagal');
                redirect('inmaterial');
            }
        }
        
        $post = $_POST;
        if ($post['inmaterial_id'] == '') {
            if ($this->M_inmaterial->process($post)) {
                $this->session->set_userdata('pesan_sistem', 'Selamat! Penambahan Stok Bahan Baku, SUKSES!');
                $this->session->set_userdata('tipe_pesan', 'Sukses');
                redirect('inmaterial');
            } else {
                $this->session->set_userdata('pesan_sistem', 'Maaf! Penambahan Stok Bahan Baku, GAGAL! Silahkan periksa dan coba kembali');
                $this->session->set_userdata('tipe_pesan', 'Gagal');
                redirect('inmaterial');
            }
        } else {
            if ($this->M_inmaterial->process($post)) {
                $this->session->set_userdata('pesan_sistem', 'Selamat! Perubahan Stok Bahan Baku, SUKSES!');
                $this->session->set_userdata('tipe_pesan', 'Sukses');
                redirect('inmaterial');
            } else {
                $this->session->set_userdata('pesan_sistem', 'Maaf! Perubahan Stok Bahan Baku, GAGAL! Silahkan periksa dan coba kembali');
                $this->session->set_userdata('tipe_pesan', 'Gagal');
                redirect('inmaterial');
            }
        }
    }

    function save() {
        if ($this->M_inmaterial->save()) {
            $this->session->set_userdata('pesan_sistem', 'Selamat! Record Stok Bahan Baku telah disimpan!');
            $this->session->set_userdata('tipe_pesan', 'Sukses');
            redirect('inmaterial');
        } else {
            $this->session->set_userdata('pesan_sistem', 'Maaf! Record Stok Bahan Bagu gagal tersimpan! Silahkan periksa dan coba kembali');
            $this->session->set_userdata('tipe_pesan', 'Gagal');
            redirect('inmaterial');
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
