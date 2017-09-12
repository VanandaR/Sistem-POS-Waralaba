<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Material_storage_after extends RAST_Control {

    private $data;

    function __construct() {
        parent::__construct();

        if (!$this->session->userdata('level') == 1 && !$this->session->userdata('level') == 5) {
            redirect('dashboard');
        }

        $this->load->model('M_material_storage_after');
    }

    function index() {
        $this->session->set_userdata('storage_after_id', NULL);
        
        $isi = array(
            'descript' => 'Bahan [After Pack]'
            , 'dataTable' => $this->M_material_storage_after->get_list()
            , 'add_button' => true
            , 'back_button' => false
        );

        $this->set_page('material_storage_after', 'Bahan [After Pack]', $isi['descript'], '<li class="active">Bahan [After Pack]</li>', 'material_storage_after', $isi);
    }

    function form() {
    	$this->output->set_content_type('application/json');

    	$id = $_POST['id'];
        echo json_encode($this->M_material_storage_after->get_isi($id));
    }

    function process() {
        $post = $_POST;
        if ($this->M_material_storage_after->process($post)) {
            $this->session->set_userdata('pesan_sistem', 'Selamat! ' . (($post['storage_id'] == '') ? 'Penambahan' : 'Perubahan') . ' material, SUKSES!');
            $this->session->set_userdata('tipe_pesan', 'Sukses');
            redirect('material_storage_after');
        } else {
            $this->session->set_userdata('pesan_sistem', 'Maaf! ' . (($post['storage_id'] == '') ? 'Penambahan' : 'Perubahan') . ' material, GAGAL! Silahkan periksa dan coba kembali');
            $this->session->set_userdata('tipe_pesan', 'Gagal');
            redirect('material_storage_after');
        }
    }

    function delete($a) {
        if ($this->M_material_storage_after->delete($a)) {
            $this->session->set_userdata('pesan_sistem', 'Selamat! Bahan Baku telah dihapus!');
            $this->session->set_userdata('tipe_pesan', 'Sukses');
            redirect('material_storage_after');
        } else {
            $this->session->set_userdata('pesan_sistem', 'Maaf! Bahan Baku tidak terhapus! Silahkan periksa dan coba kembali');
            $this->session->set_userdata('tipe_pesan', 'Gagal');
            redirect('material_storage_after');
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
