<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class revision extends RAST_Control {

    private $data;

    function __construct() {
        parent::__construct();

        $this->load->model('M_revision');
    }

    function index($id = NULL) {
        $this->session->set_userdata('revision_id', $id);

        $isi = array(
            'descript' => 'Laporan Revisi'
        , 'dataTable' => $this->M_revision->get_list()
        , 'add_button' => false
        , 'back_button' => false
        );


        $this->set_page('revisi_stock', 'Laporan Revisi', $isi['descript'], '<li class="active">revision</li>', 'revision', $isi);
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
