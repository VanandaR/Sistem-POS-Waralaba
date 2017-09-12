<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Packing extends RAST_Control {

    private $data;

    function __construct() {
        parent::__construct();

        if (!$this->session->userdata('level') == 1 && !$this->session->userdata('level') == 5) {
            redirect('dashboard');
        }

        $this->load->model('M_packing');
    }

    function index($id = NULL) {
        $this->session->set_userdata('packing_id', $id);
        
        $isi = array(
            'descript' => 'Pengemasan'
            , 'isi' => ($id != NULL && $id != '') ? $this->M_packing->get_isi($id) : NULL
            , 'material' => $this->M_packing->material_list()
            , 'material2' => $this->M_packing->material2_list()
            , 'dataTable' => $this->M_packing->get_list()
            , 'add_button' => false
            , 'back_button' => false
        );

        $this->set_page('packing', 'Pengemasan', $isi['descript'], '<li class="active">Pengemasan</li>', 'packing', $isi);
    }

    function process($id = '') {
        if ($id != '') {
            if ($this->M_packing->delete($id)) {
                $this->session->set_userdata('pesan_sistem', 'Selamat! Stok Bahan Baku telah dihapus!');
                $this->session->set_userdata('tipe_pesan', 'Sukses');
                redirect('packing');
            } else {
                $this->session->set_userdata('pesan_sistem', 'Maaf! Stok Bahan Baku tidak terhapus! Silahkan periksa dan coba kembali');
                $this->session->set_userdata('tipe_pesan', 'Gagal');
                redirect('packing');
            }
        }
        
        $post = $_POST;
        if ($post['production_storage_id'] == '') {
            if ($this->M_packing->process($post)) {
                $this->session->set_userdata('pesan_sistem', 'Selamat! Penambahan Stok Bahan Baku, SUKSES!');
                $this->session->set_userdata('tipe_pesan', 'Sukses');
                redirect('packing');
            } else {
                $this->session->set_userdata('pesan_sistem', 'Maaf! Penambahan Stok Bahan Baku, GAGAL! Silahkan periksa dan coba kembali');
                $this->session->set_userdata('tipe_pesan', 'Gagal');
                redirect('packing');
            }
        } else {
            if ($this->M_packing->process($post)) {
                $this->session->set_userdata('pesan_sistem', 'Selamat! Perubahan Stok Bahan Baku, SUKSES!');
                $this->session->set_userdata('tipe_pesan', 'Sukses');
                redirect('packing');
            } else {
                $this->session->set_userdata('pesan_sistem', 'Maaf! Perubahan Stok Bahan Baku, GAGAL! Silahkan periksa dan coba kembali');
                $this->session->set_userdata('tipe_pesan', 'Gagal');
                redirect('packing');
            }
        }
    }

    function save() {
        if ($this->M_packing->save()) {
            $this->session->set_userdata('pesan_sistem', 'Selamat! Record Stok Bahan Baku telah disimpan!');
            $this->session->set_userdata('tipe_pesan', 'Sukses');
            redirect('packing');
        } else {
            $this->session->set_userdata('pesan_sistem', 'Maaf! Record Stok Bahan Bagu gagal tersimpan! Silahkan periksa dan coba kembali');
            $this->session->set_userdata('tipe_pesan', 'Gagal');
            redirect('packing');
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
