<?php
$a = 'active';
$b = 'active nav-active';

$dashboard = '';

$report_inmaterial = '';
$report_sales = '';
$report_sales_table = '';
$report_sales_graph = '';

$supplier = '';
$material = '';
$receipt = '';
$category = '';
$food_menu = '';
$inmaterial = '';
$log='';
$expenditure='';

$sales = '';
$discount='';

$member = '';
$revisi_stock = '';

$report_inmaterial_storage = '';
$report_member = '';
$report_produk = '';
$report_produk_table = '';
$report_produk_graph = '';
$report_packing = '';
$report_distribution_storage = '';
$material_storage_pra = '';
$material_storage_after = '';
$inmaterial_storage = '';
$packing = '';
$distribution = '';

$user = '';

switch ($menu) {

    case 'dashboard' :
        $dashboard = $a;
        break;

    case 'report_inmaterial' :
        $report_inmaterial = $a;
        break;
    case 'report_sales_table' :
        $report_sales = $b;
        $report_sales_table = $a;
        break;
    case 'report_sales_graph' :
        $report_sales = $b;
        $report_sales_graph = $a;
        break;
    case 'report_produk_table' :
        $report_produk = $b;
        $report_produk_table = $a;
        break;
    case 'report_produk_graph' :
        $report_produk = $b;
        $report_produk_graph = $a;
        break;
    case 'revisi_stock' :
        $revisi_stock = $a;
        break;
    case 'supplier' :
        $supplier = $a;
        break;
    case 'report_member' :
        $report_member = $a;
        break;
    case 'receipt' :
        $receipt = $a;
        break;
    case 'log' :
        $log = $a;
        break;
    case 'expenditure':
        $expenditure=$a;
        break;

    case 'material' :
        $material = $a;
        break;
    case 'discount' :
        $discount = $a;
        break;

    case 'category' :
        $category = $a;
        break;

    case 'food_menu' :
        $food_menu = $a;
        break;

    case 'inmaterial' :
        $inmaterial = $a;
        break;

    case 'sales' :
        $sales = $a;
        break;

    case 'member' :
        $member = $a;
        break;

    case 'report_inmaterial_storage' :
        $report_inmaterial_storage = $a;
        break;

    case 'report_packing' :
        $report_packing = $a;
        break;

    case 'report_distribution_storage' :
        $report_distribution_storage = $a;
        break;

    case 'material_storage_pra' :
        $material_storage_pra = $a;
        break;

    case 'material_storage_after' :
        $material_storage_after = $a;
        break;

    case 'inmaterial_storage' :
        $inmaterial_storage = $a;
        break;

    case 'packing' :
        $packing = $a;
        break;

    case 'distribution' :
        $distribution = $a;
        break;

    case 'user' :
        $user = $a;
        break;

    default :
        $dashboard = $a;
        break;
}
?>

<ul class="nav nav-pills nav-stacked nav-bracket">
    <li class="<?= $dashboard; ?>"><a href="<?= base_url(); ?>dashboard"><i class="fa fa-home"></i> <span>Dashboard</span></a></li>
    <?php
    if ($this->session->userdata('outlet_id') != "storage") {
        if ($this->session->userdata('level') == 1 || $this->session->userdata('level') == 4) {
            ?>
            <h5 class="sidebartitle">Laporan - Laporan</h5>
            <li class="<?= $report_inmaterial; ?>"><a href="<?= base_url(); ?>report/inmaterial"><i class="fa fa-calendar"></i> <span>Lap. Stok Masuk</span></a></li>
            <li class="nav-parent <?= $report_sales; ?>"><a href="#"><i class="fa fa-edit"></i> <span>Lap. Penjualan</span></a>
                <ul class="children" style="display: <?= (($report_sales == $b) ? "block" : "none"); ?>">
                    <li class="<?= $report_sales_table; ?>"><a href="<?= base_url(); ?>report/sales_table"><i class="fa fa-calendar"></i> Tabel</a></li>
                    <li class="<?= $report_sales_graph; ?>"><a href="<?= base_url(); ?>report/sales_graph"><i class="fa fa-bar-chart-o"></i> Grafik</a></li>
                </ul>
            </li>
            <li class="<?= $report_member; ?>"><a href="<?= base_url(); ?>report/sales_member"><i class="fa fa-calendar"></i> <span>Lap. Member</span></a></li>
<!--            <li class="--><?//= $report_produk; ?><!--"><a href="--><?//= base_url(); ?><!--report/sales_produk"><i class="fa fa-calendar"></i> <span>Produk Terlaris</span></a></li>-->
            <li class="nav-parent<?= $report_produk; ?>"><a href="#"><i class="fa fa-edit"></i> <span>Produk Terlaris</span></a>
                <ul class="children" style="display: <?= (($report_sales == $b) ? "block" : "none"); ?>">
                    <li class="<?= $report_produk_table; ?>"><a href="<?= base_url(); ?>report/sales_produk_table"><i class="fa fa-calendar"></i> Tabel</a></li>
                    <li class="<?= $report_produk_graph; ?>"><a href="<?= base_url(); ?>report/sales_graph"><i class="fa fa-bar-chart-o"></i> Grafik</a></li>
                </ul>
            </li>
            <li class="<?= $revisi_stock; ?>"><a href="<?= base_url(); ?>revision"><i class="fa fa-refresh"></i> <span>Lap. Revisi Stok</span></a></li>
            <?php
        }
        if ($this->session->userdata('level') == 1 || $this->session->userdata('level') == 3) {
            ?>
            <h5 class="sidebartitle">Gudang</h5>
            <li class="<?= $supplier; ?>"><a href="<?= base_url(); ?>supplier"><i class="fa fa-users"></i> <span>Supplier</span></a></li>
            <li class="<?= $material; ?>"><a href="<?= base_url(); ?>material"><i class="fa fa-inbox"></i> <span>Bahan Baku</span></a></li>
            <li class="<?= $category; ?>"><a href="<?= base_url(); ?>category"><i class="fa fa-tags"></i> <span>Kategori</span></a></li>

            <li class="<?= $food_menu; ?>"><a href="<?= base_url(); ?>food_menu"><i class="fa fa-inbox"></i> <span>Menu Makanan</span></a></li>
            <!--            <li class="--><?//= $receipt; ?><!--"><a href="--><?//= base_url(); ?><!--receipt"><i class="fa fa-inbox"></i> <span>Resep</span></a></li>-->
            <?php
            if ($this->session->userdata('outlet_id') != 'all') {
                ?>
                <li class="<?= $inmaterial; ?>"><a href="<?= base_url(); ?>inmaterial"><i class="fa fa-shopping-cart"></i> <span>Stok Masuk</span></a></li>
                <?php
            }
        }
        if (($this->session->userdata('level') == 1 || $this->session->userdata('level') == 2) && $this->session->userdata('outlet_id') != 'all') {
            ?>
            <h5 class="sidebartitle">Transaksi</h5>
            <li class="<?= $sales; ?>"><a href="<?= base_url(); ?>sales"><i class="fa fa-truck"></i> <span>Penjualan</span></a></li>
            <li class="<?= $expenditure; ?>"><a href="<?= base_url(); ?>expenditure"><i class="fa fa-money"></i> <span>Pengeluaran</span></a></li>
            <h5 class="sidebartitle">Diskon</h5>
            <li class="<?= $discount; ?>"><a href="<?= base_url(); ?>discount"><i class="fa fa-eur" aria-hidden="true"></i><span>Diskon</span></a></li>
            <?php
        }
        if ($this->session->userdata('level') == 1 || $this->session->userdata('level') == 2) {
            ?>
            <h5 class="sidebartitle">Setting</h5>
            <li class="<?= $member; ?>"><a href="<?= base_url(); ?>member"><i class="fa fa-users"></i> <span>Member</span></a></li>
            <li class="<?= $log; ?>"><a href="<?= base_url();?>log"><i class="fa fa-refresh"></i> <span>Log Activity</span></a></li>
            <?php
        }
    } else {
        if ($this->session->userdata('level') == 1 || $this->session->userdata('level') == 5) {
            ?>
            <h5 class="sidebartitle">Laporan - Laporan</h5>
            <li class="<?= $report_inmaterial_storage; ?>"><a href="<?= base_url(); ?>report/inmaterial_storage"><i class="fa fa-calendar"></i> <span>Lap. Bahan Masuk</span></a></li>
            <li class="<?= $report_distribution_storage; ?>"><a href="<?= base_url(); ?>report/distribution_storage"><i class="fa fa-calendar"></i> <span>Lap. Distribusi</span></a></li>

            <h5 class="sidebartitle">Gudang</h5>
            <li class="<?= $material_storage_pra; ?>"><a href="<?= base_url(); ?>material_storage_pra"><i class="fa fa-inbox"></i> <span>Bahan [Pra Pack]</span></a></li>
            <li class="<?= $material_storage_after; ?>"><a href="<?= base_url(); ?>material_storage_after"><i class="fa fa-inbox"></i> <span>Bahan [After Pack]</span></a></li>
            <li class="<?= $inmaterial_storage; ?>"><a href="<?= base_url(); ?>inmaterial_storage"><i class="fa fa-shopping-cart"></i> <span>Bahan Masuk</span></a></li>

            <h5 class="sidebartitle">Aktifitas</h5>
            <li class="<?= $packing; ?>"><a href="<?= base_url(); ?>packing"><i class="fa fa-gears"></i> <span>Pengemasan</span></a></li>
            <li class="<?= $distribution; ?>"><a href="<?= base_url(); ?>distribution"><i class="fa fa-truck"></i> <span>Distribusi</span></a></li>
            <?php
        }
        if ($this->session->userdata('level') == 1) {
            ?>
            <h5 class="sidebartitle">Setting</h5>

            <?php
        }
    }
    if ($this->session->userdata('level') == 1) {
        ?>
        <li class="<?= $user; ?>"><a href="<?= base_url(); ?>user"><i class="fa fa-user"></i> <span>User</span></a></li>

        <?php
    }
    ?>
</ul>