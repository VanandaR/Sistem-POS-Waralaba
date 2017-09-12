 <?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class expenditure extends RAST_Control {

    private $data;

    function __construct() {
        parent::__construct();

        $this->load->model('M_expenditure');
    }

    function index($id = NULL) {
        $this->session->set_userdata('expenditure_id', $id);

        $isi = array(
            'descript' => 'Pengeluaran'
        , 'dataTable' => $this->M_expenditure->get_list()
        , 'add_button' => true
        , 'back_button' => false
        );


        $this->set_page('expenditure', 'Pengeluaran', $isi['descript'], '<li class="active">expenditure</li>', 'expenditure', $isi);
    }

    function process() {
        $post = $_POST;
        if ($this->M_expenditure->process($post)) {
            $this->session->set_userdata('pesan_sistem', 'Selamat! ' . (($post['member_id'] == '') ? 'Penambahan' : 'Perubahan') . ' receipt, SUKSES!');
            $this->session->set_userdata('tipe_pesan', 'Sukses');
            redirect('receipt');
        } else {
            $this->session->set_userdata('pesan_sistem', 'Maaf! ' . (($post['member_id'] == '') ? 'Penambahan' : 'Perubahan') . ' receipt, GAGAL! Silahkan periksa dan coba kembali');
            $this->session->set_userdata('tipe_pesan', 'Gagal');
            redirect('receipt');
        }
    }
    function form() {
        $this->output->set_content_type('application/json');

        $id = $_POST['id'];
        echo json_encode($this->M_expenditure->get_isi($id));
    }

    function delete($a) {
        if ($this->M_expenditure->delete($a)) {
            $this->session->set_userdata('pesan_sistem', 'Selamat! Pengeluaran telah dihapus!');
            $this->session->set_userdata('tipe_pesan', 'Sukses');
            redirect('expenditure');
        } else {
            $this->session->set_userdata('pesan_sistem', 'Maaf! Pengeluaran tidak terhapus! Silahkan periksa dan coba kembali');
            $this->session->set_userdata('tipe_pesan', 'Gagal');
            redirect('expenditure');
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
