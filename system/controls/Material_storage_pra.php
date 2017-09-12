<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Material_storage_pra extends RAST_Control {

    private $data;

    function __construct() {
        parent::__construct();

        if (!$this->session->userdata('level') == 1 && !$this->session->userdata('level') == 5) {
            redirect('dashboard');
        }

        $this->load->model('M_material_storage_pra');
    }

    function index() {
        $this->session->set_userdata('storage_pra_id', NULL);
        
        $isi = array(
            'descript' => 'Bahan [Pra Pack]'
            , 'dataTable' => $this->M_material_storage_pra->get_list()
            , 'add_button' => true
            , 'back_button' => false
        );

        $this->set_page('material_storage_pra', 'Bahan [Pra Pack]', $isi['descript'], '<li class="active">Bahan [Pra Pack]</li>', 'material_storage_pra', $isi);
    }

    function form() {
    	$this->output->set_content_type('application/json');

    	$id = $_POST['id'];
        echo json_encode($this->M_material_storage_pra->get_isi($id));
    }

    function process() {
        $post = $_POST;
        if ($this->M_material_storage_pra->process($post)) {
            $this->session->set_userdata('pesan_sistem', 'Selamat! ' . (($post['storage_pra_id'] == '') ? 'Penambahan' : 'Perubahan') . ' material, SUKSES!');
            $this->session->set_userdata('tipe_pesan', 'Sukses');
            redirect('material_storage_pra');
        } else {
            $this->session->set_userdata('pesan_sistem', 'Maaf! ' . (($post['storage_pra_id'] == '') ? 'Penambahan' : 'Perubahan') . ' material, GAGAL! Silahkan periksa dan coba kembali');
            $this->session->set_userdata('tipe_pesan', 'Gagal');
            redirect('material_storage_pra');
        }
    }

    function delete($a) {
        if ($this->M_material_storage_pra->delete($a)) {
            $this->session->set_userdata('pesan_sistem', 'Selamat! Bahan Baku telah dihapus!');
            $this->session->set_userdata('tipe_pesan', 'Sukses');
            redirect('material_storage_pra');
        } else {
            $this->session->set_userdata('pesan_sistem', 'Maaf! Bahan Baku tidak terhapus! Silahkan periksa dan coba kembali');
            $this->session->set_userdata('tipe_pesan', 'Gagal');
            redirect('material_storage_pra');
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
