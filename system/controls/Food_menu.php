<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Food_menu extends RAST_Control {

    private $data;

    function __construct() {
        parent::__construct();

        if (!$this->session->userdata('level') == 1 && !$this->session->userdata('level') == 3) {
            redirect('dashboard');
        }

        $this->load->model('M_food_menu');
    }

    function index() {
        $this->session->set_userdata('food_menu_id', NULL);

        $isi = array(
            'descript' => 'Menu Makanan'
            , 'dataTable' => $this->M_food_menu->get_list()
            , 'category' => (($this->session->userdata('outlet_id') != 'all') ? $this->M_food_menu->category_list() : NULL)
            , 'material' => (($this->session->userdata('outlet_id') != 'all') ? $this->M_food_menu->material_list() : NULL)
            , 'add_button' => (($this->session->userdata('outlet_id') != 'all') ? true : false)
            , 'back_button' => false
        );

        $this->set_page('food_menu', 'Menu Makanan', $isi['descript'], '<li class="active">Menu Makanan</li>', 'food_menu', $isi);
    }

    function form() {
    	$this->output->set_content_type('application/json');

    	$id = $_POST['id'];
        echo json_encode($this->M_food_menu->get_isi($id));
    }

    function process() {
        $post = $_POST;
        if ($this->M_food_menu->process($post)) {
            $this->session->set_userdata('pesan_sistem', 'Selamat! ' . (($post['food_menu_id'] == '') ? 'Penambahan' : 'Perubahan') . ' Menu Makanan, SUKSES!');
            $this->session->set_userdata('tipe_pesan', 'Sukses');
            redirect('food_menu');
        } else {
            $this->session->set_userdata('pesan_sistem', 'Maaf! ' . (($post['food_menu_id'] == '') ? 'Penambahan' : 'Perubahan') . ' Menu Makanan, GAGAL! Silahkan periksa dan coba kembali');
            $this->session->set_userdata('tipe_pesan', 'Gagal');
            redirect('food_menu');
        }
    }

	function material_list() {
    	$this->output->set_content_type('application/json');

    	$id = $_POST['id'];
        echo json_encode($this->M_food_menu->get_food_menu_material_list($id));
	}

	function material_save() {
    	$this->output->set_content_type('application/json');
		
		$post = $_POST;
		if ($this->M_food_menu->process_material($post, "process")) {
			echo json_encode($this->M_food_menu->get_food_menu_material_list($post['food_menu_id']));
		} else {
			echo "{}";
		}
	}

	function material_delete() {
    	$this->output->set_content_type('application/json');
		
		$post = $_POST;
		if ($this->M_food_menu->process_material($post['id'], "delete")) {
			echo json_encode($this->M_food_menu->get_food_menu_material_list($post['food_menu_id']));
		} else {
			echo "{}";
		}
	}

    function delete($a) {
        if ($this->M_food_menu->delete($a)) {
            $this->session->set_userdata('pesan_sistem', 'Selamat! Menu Makanan telah dihapus!');
            $this->session->set_userdata('tipe_pesan', 'Sukses');
            redirect('food_menu');
        } else {
            $this->session->set_userdata('pesan_sistem', 'Maaf! Menu Makanan tidak terhapus! Silahkan periksa dan coba kembali');
            $this->session->set_userdata('tipe_pesan', 'Gagal');
            redirect('food_menu');
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
