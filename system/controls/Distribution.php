<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Distribution extends RAST_Control {

    private $data;

    function __construct() {
        parent::__construct();

        if (!$this->session->userdata('level') == 1 && !$this->session->userdata('level') == 5) {
            redirect('dashboard');
        }

        $this->load->model('M_distribution');
    }

    function index($id = NULL) {
        $this->session->set_userdata('distribution_id', $id);
        
        $isi = array(
            'descript' => 'Distribusi Bahan'
            , 'isi' => ($id != NULL && $id != '') ? $this->m_distribution->get_isi($id) : NULL
            , 'storage' => $this->m_distribution->storage_list()
            , 'outlet' => $this->m_distribution->outlet_list()
            , 'dataTable' => $this->m_distribution->get_list()
            , 'add_button' => false
            , 'back_button' => false
        );
        $isi['material'] = ($id != NULL && $id != '') ?  $this->m_distribution->material_list($isi['isi'][0]['outlet_id']) : NULL;

        $this->set_page('distribution', 'Distribusi Bahan [After Pack]', $isi['descript'], '<li class="active">Distribusi Bahan</li>', 'distribution', $isi);
    }

    function material_list() {
    	$this->output->set_content_type('application/json');

    	$id = $_POST['id'];
        echo json_encode($this->m_distribution->material_list($id));
    }

    function process($id = '') {
        if ($id != '') {
            if ($this->m_distribution->delete($id)) {
                $this->session->set_userdata('pesan_sistem', 'Selamat! Distribusi Bahan Baku telah dihapus!');
                $this->session->set_userdata('tipe_pesan', 'Sukses');
                redirect('distribution');
            } else {
                $this->session->set_userdata('pesan_sistem', 'Maaf! Distribusi Bahan Baku tidak terhapus! Silahkan periksa dan coba kembali');
                $this->session->set_userdata('tipe_pesan', 'Gagal');
                redirect('distribution');
            }
        }
        
        $post = $_POST;
        if ($post['distribution_id'] == '') {
            if ($this->m_distribution->process($post)) {
                $this->session->set_userdata('pesan_sistem', 'Selamat! Penambahan Distribusi Bahan Baku, SUKSES!');
                $this->session->set_userdata('tipe_pesan', 'Sukses');
                redirect('distribution');
            } else {
                $this->session->set_userdata('pesan_sistem', 'Maaf! Penambahan Distribusi Bahan Baku, GAGAL! Silahkan periksa dan coba kembali');
                $this->session->set_userdata('tipe_pesan', 'Gagal');
                redirect('distribution');
            }
        } else {
            if ($this->m_distribution->process($post)) {
                $this->session->set_userdata('pesan_sistem', 'Selamat! Perubahan Distribusi Bahan Baku, SUKSES!');
                $this->session->set_userdata('tipe_pesan', 'Sukses');
                redirect('distribution');
            } else {
                $this->session->set_userdata('pesan_sistem', 'Maaf! Perubahan Distribusi Bahan Baku, GAGAL! Silahkan periksa dan coba kembali');
                $this->session->set_userdata('tipe_pesan', 'Gagal');
                redirect('distribution');
            }
        }
    }

    function save() {
        if ($this->m_distribution->save()) {
            $this->session->set_userdata('pesan_sistem', 'Selamat! Record Distribusi Bahan Baku telah disimpan!');
            $this->session->set_userdata('tipe_pesan', 'Sukses');
            redirect('distribution');
        } else {
            $this->session->set_userdata('pesan_sistem', 'Maaf! Record Distribusi Bahan Bagu gagal tersimpan! Silahkan periksa dan coba kembali');
            $this->session->set_userdata('tipe_pesan', 'Gagal');
            redirect('distribution');
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
