<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Log extends RAST_Control {

    private $data;

    function __construct() {
        parent::__construct();


        $this->load->model('M_Log');
    }

    function index($id = NULL) {
        $this->session->set_userdata('Log_id', $id);

        $isi = array(
            'descript' => 'Log Activity'
        , 'dataTable' => $this->M_Log->get_list()
        , 'add_button' => false
        , 'back_button' => false
        );


        $this->set_page('log', 'Log Activity', $isi['descript'], '<li class="active">Log</li>', 'Log', $isi);
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
