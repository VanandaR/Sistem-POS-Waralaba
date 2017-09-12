<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Inmaterial_storage extends RAST_Control {

    private $data;

    function __construct() {
        parent::__construct();

        if (!$this->session->userdata('level') == 1 && !$this->session->userdata('level') == 5) {
            redirect('dashboard');
        }

        $this->load->model('M_inmaterial_storage');
    }

    function index($id = NULL) {
        $this->session->set_userdata('inmaterial_storage_id', $id);
        
        $isi = array(
            'descript' => 'Tambah Stok Bahan [Pra Pack]'
            , 'isi' => ($id != NULL && $id != '') ? $this->M_inmaterial_storage->get_isi($id) : NULL
            , 'material' => $this->M_inmaterial_storage->material_list()
            , 'dataTable' => $this->M_inmaterial_storage->get_list()
            , 'add_button' => false
            , 'back_button' => false
        );

        $this->set_page('inmaterial_storage', 'Tambah Stock Bahan [Pra Pack]', $isi['descript'], '<li class="active">Stok Masuk</li>', 'inmaterial_storage', $isi);
    }

    function process($id = '') {
        if ($id != '') {
            if ($this->M_inmaterial_storage->delete($id)) {
                $this->session->set_userdata('pesan_sistem', 'Selamat! Stok Bahan Baku telah dihapus!');
                $this->session->set_userdata('tipe_pesan', 'Sukses');
                redirect('inmaterial_storage');
            } else {
                $this->session->set_userdata('pesan_sistem', 'Maaf! Stok Bahan Baku tidak terhapus! Silahkan periksa dan coba kembali');
                $this->session->set_userdata('tipe_pesan', 'Gagal');
                redirect('inmaterial_storage');
            }
        }
        
        $post = $_POST;
        if ($post['inmaterial_storage_id'] == '') {
            if ($this->M_inmaterial_storage->process($post)) {
                $this->session->set_userdata('pesan_sistem', 'Selamat! Penambahan Stok Bahan Baku, SUKSES!');
                $this->session->set_userdata('tipe_pesan', 'Sukses');
                redirect('inmaterial_storage');
            } else {
                $this->session->set_userdata('pesan_sistem', 'Maaf! Penambahan Stok Bahan Baku, GAGAL! Silahkan periksa dan coba kembali');
                $this->session->set_userdata('tipe_pesan', 'Gagal');
                redirect('inmaterial_storage');
            }
        } else {
            if ($this->M_inmaterial_storage->process($post)) {
                $this->session->set_userdata('pesan_sistem', 'Selamat! Perubahan Stok Bahan Baku, SUKSES!');
                $this->session->set_userdata('tipe_pesan', 'Sukses');
                redirect('inmaterial_storage');
            } else {
                $this->session->set_userdata('pesan_sistem', 'Maaf! Perubahan Stok Bahan Baku, GAGAL! Silahkan periksa dan coba kembali');
                $this->session->set_userdata('tipe_pesan', 'Gagal');
                redirect('inmaterial_storage');
            }
        }
    }

    function save() {
        if ($this->M_inmaterial_storage->save()) {
            $this->session->set_userdata('pesan_sistem', 'Selamat! Record Stok Bahan Baku telah disimpan!');
            $this->session->set_userdata('tipe_pesan', 'Sukses');
            redirect('inmaterial_storage');
        } else {
            $this->session->set_userdata('pesan_sistem', 'Maaf! Record Stok Bahan Bagu gagal tersimpan! Silahkan periksa dan coba kembali');
            $this->session->set_userdata('tipe_pesan', 'Gagal');
            redirect('inmaterial_storage');
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
