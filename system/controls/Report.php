<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Report extends RAST_Control {

    private $data;

    function __construct() {
        parent::__construct();

        if (!$this->session->userdata('level') == 1 && !$this->session->userdata('level') == 4) {
            redirect('dashboard');
        }

        $this->load->model('M_report');
    }

    function index() {
        $this->inmaterial();
    }

    function inmaterial() {
        $isi = array(
            'descript' => 'Laporan Barang Masuk'
            , 'from' => NULL
            , 'to' => NULL
            , 'dataTable' => $this->M_report->inmaterial_list()
            , 'add_button' => false
            , 'back_button' => false
        );

        if (isset($_POST['from'])||isset($_POST['to'])) {
            $isi['from'] = $_POST['from'];
            $isi['to'] = $_POST['to'];
            $isi['range']=$_POST['range'];
            $isi['dataTable'] = $this->M_report->inmaterial_list($isi['from'], $isi['to'],$isi['range']);
        }

        $this->set_page('report_inmaterial', 'Laporan Barang Masuk', $isi['descript'], '<li><a href="' . base_url() . 'report">Laporan</a></li><li class="active">Barang Masuk</li>', 'report_inmaterial', $isi);

    }
    function inmaterial_table(){
        $this->output->set_content_type('application/json');

        if (isset($_GET['from'])) {
            $isi['from'] = $_POST['from'];
            $isi['to'] = $_POST['to'];
            echo json_encode($this->M_report->inmaterial_list($isi['from'], $isi['to']));
        }

    }
    function sales_member() {
        $isi = array(
            'descript' => 'Laporan Penjualan Member'
        , 'from' => NULL
        , 'to' => NULL
        , 'dataTable' => $this->M_report->sales_member_list()
        , 'add_button' => false
        , 'back_button' => false
        );


        if (isset($_POST['from'])) {
            $isi['from'] = $_POST['from'];
            $isi['to'] = $_POST['to'];
            $isi['dataTable'] = $this->M_report->sales_member_list($isi['from'], $isi['to']);
        }

        $this->set_page('report_member', 'Laporan Penjualan Member', $isi['descript'], '<li><a href="' . base_url() . 'report">Laporan</a></li><li class="active">Penjualan</li>', 'report_sales_member', $isi);
    }
    function sales_produk_table() {
        $isi = array(
            'descript' => 'Laporan Produk Terlaris'
        , 'from' => NULL
        , 'to' => NULL
        , 'dataTable'=>$this->M_report->sales_produk_list()
        , 'add_button' => false
        , 'back_button' => false
        );


        if (isset($_POST['from'])) {
            $isi['from'] = $_POST['from'];
            $isi['to'] = $_POST['to'];
            $isi['dataTable'] = $this->M_report->sales_produk_list($isi['from'], $isi['to']);
        }

        $this->set_page('report_produk_table', 'Laporan Penjualan Produk', $isi['descript'], '<li><a href="' . base_url() . 'report">Laporan</a></li><li class="active">Penjualan</li>', 'report_product_table', $isi);
    }

    function sales_table() {

        $isi = array(
            'descript' => 'Laporan Penjualan'
            , 'from' => NULL
            , 'to' => NULL
            , 'who' => "0"
            , 'memberterpilih' => "0"
            , 'foodmenuterpilih'=> ""
            , 'dataTable' => $this->M_report->sales_table_list()
            , 'member'=>$this->M_report->member_list()
            , 'foodmenu'=>$this->M_report->food_menu_list()
            , 'employee' => $this->M_report->employee_list()
            , 'add_button' => false
            , 'back_button' => false
        );



        if (isset($_POST['from'])) {
            $isi['from'] = $_POST['from'];
            $isi['to'] = $_POST['to'];
            $isi['memberterpilih'] = $_POST['member'];
            $isi['foodmenuterpilih'] = $_POST['foodmenu'];

            $isi['who'] = $_POST['who'];
            $isi['dataTable'] = $this->M_report->sales_table_list($isi['from'], $isi['to'], $isi['who'],$isi['memberterpilih'],$isi['foodmenuterpilih']);
        }

        $this->set_page('report_sales_table', 'Laporan Penjualan', $isi['descript'], '<li><a href="' . base_url() . 'report">Laporan</a></li><li class="active">Penjualan</li>', 'report_sales_table', $isi);
    }

    function sales_graph() {
        $isi = array(
            'descript' => 'Grafik Penjualan Harian'
            , 'from' => NULL
            , 'to' => NULL
            , 'min' => $this->M_report->trans_min()
            , 'grafik' => $this->M_report->sales_graph()
            , 'add_button' => false
            , 'back_button' => false
        );

        if (isset($_POST['from'])) {
            $isi['from'] = $_POST['from'];
            $isi['to'] = $_POST['to'];
            $isi['min'] = $this->M_report->trans_min($isi['from']);
            $isi['grafik'] = $this->M_report->sales_graph($isi['from'], $isi['to']);
        }

        $this->set_page('report_sales_graph', 'Grafik Penjualan Harian', $isi['descript'], '<li><a href="' . base_url() . 'report">Laporan</a></li><li class="active">Penjualan</li>', 'report_sales_graph', $isi);
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
