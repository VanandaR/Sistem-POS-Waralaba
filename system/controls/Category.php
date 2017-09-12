<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Category extends RAST_Control {

    private $data;

    function __construct() {
        parent::__construct();

        if (!$this->session->userdata('level') == 1 && !$this->session->userdata('level') == 3) {
            redirect('dashboard');
        }

        $this->load->model('M_category');
    }

    function index() {
        $this->session->set_userdata('category_id', NULL);
        
        $isi = array(
            'descript' => 'Kategori Pada Menu Makanan'
            , 'dataTable' => $this->M_category->get_list()
            , 'add_button' => (($this->session->userdata('outlet_id') != 'all') ? true : false)
            , 'back_button' => false
        );

        $this->set_page('category', 'Kategori', $isi['descript'], '<li class="active">Kategori</li>', 'category', $isi);
    }

    function form() {
    	$this->output->set_content_type('application/json');

    	$id = $_POST['id'];
        echo json_encode($this->M_category->get_isi($id));
    }

    function process() {
        $post = $_POST;
        if ($this->M_category->process($post)) {
            $this->session->set_userdata('pesan_sistem', 'Selamat! ' . (($post['category_id'] == '') ? 'Penambahan' : 'Perubahan') . ' kategori, SUKSES!');
            $this->session->set_userdata('tipe_pesan', 'Sukses');
            redirect('category');
        } else {
            $this->session->set_userdata('pesan_sistem', 'Maaf! ' . (($post['category_id'] == '') ? 'Penambahan' : 'Perubahan') . ' kategori, GAGAL! Silahkan periksa dan coba kembali');
            $this->session->set_userdata('tipe_pesan', 'Gagal');
            redirect('category');
        }
    }

    function delete($a) {
        if ($this->M_category->delete($a)) {
            $this->session->set_userdata('pesan_sistem', 'Selamat! Kategori telah dihapus!');
            $this->session->set_userdata('tipe_pesan', 'Sukses');
            redirect('category');
        } else {
            $this->session->set_userdata('pesan_sistem', 'Maaf! Kategori tidak terhapus! Silahkan periksa dan coba kembali');
            $this->session->set_userdata('tipe_pesan', 'Gagal');
            redirect('category');
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
