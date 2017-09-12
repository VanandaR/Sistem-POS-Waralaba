<div class="panel panel-default">
    <div class="panel-body">
        <div class="table-responsive">
            <table class="table table-striped" id="table" style="font-size: 11px;">
                <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal Promo</th>
                    <th>Diskon Produk</th>
                    <th>Minimal Pembelian Barang</th>
                    <th>Minimal Total Pembelian</th>
                    <th>Diskon</th>
                    <th>Member/Umum</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $i = 0;
                foreach ($dataTable as $t):
                    ?>
                    <tr class="gradeA">
                        <td><?= ++$i; ?></td>
                        <td><?= ($t['discount_date_type']==1)?"All Time":"Periode : ".$t['discount_date_from']." s/d ".$t['discount_date_to']; ?></td>
                        <td>
                            <?php
                            $i=1;
                            foreach ($discount_product as $dp){
                                if ($dp['discount_id']==$t['discount_id']){
                                    if ($dp['discount_product_type']==2){
                                        echo "Makanan : ".$dp['food_menu_name'];
                                    }else if ($dp['discount_product_type']==1){
                                        echo "Kategori : ".$dp['category_name'];
                                    }else{
                                        echo "Kombinasi ".$i." : ";
                                        echo $dp['food_menu_name']."<br>";
                                        $i++;
                                    }
                                }
                            }
                            //                            if ($t['discount_product_type']==2){
                            //                                echo "Makanan : ".$t['food_menu_name'];
                            //                            }else if ($t['discount_product_type']==1){
                            //                                echo "Kategori : ".$t['category_name'];
                            //                            } else{
                            //
                            //                                echo "Kombinasi";
                            //                            }
                            ?>
                        </td>
                        <td><?= $t['product_quantity_minimum']; ?></td>
                        <td><?= $t['product_total_sales_minimum']; ?></td>
                        <td>
                            <?php
                            $i=1;
                            foreach ($discount_type as $dt) {
                                if ($dt['discount_id'] == $t['discount_id']) {
                                    if ($dt['discount_type'] == 2) {
                                        echo $dt['discount_percent'] . "%";
                                    } else if ($dt['discount_type'] == 3) {
                                        echo "Rp " . $dt['discount_nominal'];
                                    } else {
                                        echo "Gratis Produk ".$i." : ";
                                        echo $dt['food_menu_name']."<br>";
                                        $i++;
                                    }
                                }
                            }
                            ?>
                        </td>
                        <td><?= ($t['discount_for_member_type'])?"Member":"Umum"; ?></td>
                        <td>
                            <?php
                            if ($this->session->userdata('outlet_id') != 'all') {
                                ?>
                                <a href="#myModal" data-toggle="modal" data-target="#myModal" class="edit" id="<?= $t['discount_id']; ?>"><i class="fa fa-pencil"></i> Ubah</a> |
                                <?php
                            }
                            ?>
                            <a href="<?= base_url(); ?>discount/delete/<?= $t['discount_id']; ?>" onclick="return confirm('Apakah anda yakin menghapus data penting ini?');"><i class="fa fa-trash-o"></i> Hapus</a>
                        </td>
                    </tr>
                    <?php
                endforeach;
                ?>
                </tbody>
            </table>
        </div><!-- table-responsive -->
    </div><!-- panel-body -->
</div><!-- panel -->
<?php
if ($this->session->userdata('outlet_id') != 'all') {
    ?>
    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-body">
                    <div id="modal_content">
                        <form id="basicForm" method="POST" action="<?= base_url(); ?>discount/process" class="form-horizontal">
                            <input type="hidden" name="discount_id" value="" />
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Tanggal Promo <span class="asterisk">*</span></label>

                                <div class="col-sm-7">
                                    <a onclick="alltimefunction()">
                                        <div class="col-sm-4">
                                            <input id="radio-1" class="" name="discount_date_type" type="radio" value="1" checked>
                                            <label for="radio-32" class="">All Time</label>
                                        </div>
                                    </a>
                                    <a  onclick="periodefunction()">
                                        <div class="col-sm-4">
                                            <input id="radio-2" class="" name="discount_date_type" type="radio" value="2">
                                            <label for="radio-33" class="">Periode</label>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-sm-7" id="periode" hidden>
                                    <div class="col-sm-6">
                                        <input type="text" name="discount_date_from" class="form-control" style="height: 35px" placeholder="Dari : mm/dd/yyyy" id="datepicker"/>
                                        <!--                                        <input type="text" name="supplier_name" id="supplier_name" class="form-control" placeholder="Dari : mm/dd/yyyy" id="datepicker" required value="" />-->
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" name="discount_date_to" class="form-control" style="height: 35px" placeholder="Sampai : mm/dd/yyyy" id="datepicker1"/>
                                        <!--                                        <input type="text" name="supplier_name" id="supplier_name" class="form-control" placeholder="Sampai : mm/dd/yyyy" id="datepicker" required value="" />-->
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Produk <span class="asterisk">*</span></label>
                                <div class="col-sm-7">
                                    <a onclick="kategorifunction()">
                                        <div class="col-sm-4">
                                            <input id="radio-3" class="" name="discount_product_type" type="radio" value="1" checked>
                                            <label for="radio-32" class="">Kategori</label>
                                        </div>
                                    </a>
                                    <a onclick="produkfunction()">
                                        <div class="col-sm-4">
                                            <input id="radio-4" class="" name="discount_product_type" type="radio" value="2">
                                            <label for="radio-33" class="">Produk</label>
                                        </div>
                                    </a>
                                    <a onclick="kombinasifunction()" >
                                        <div class="col-sm-4">
                                            <input id="radio-5" class="" name="discount_product_type" type="radio" value="3">
                                            <label for="radio-33" class="">Kombinasi</label>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-sm-7" id="kategori">
                                    <div class="col-sm-12 form-control">
                                        <?php
                                        foreach ($kategori as $k) {
                                            echo '<input type="radio" id="kategori-'. $k['category_id'] .'" name="discount_product_category" value=' . $k['category_id'] .'>' .$k['category_name'] . '</input><br>';
                                        }
                                        ?>

                                    </div>

                                </div>
                                <div class="col-sm-7" id="produk" hidden>
                                    <div class="col-sm-12 form-control">
                                        <?php
                                        foreach ($produk as $p) {
                                            echo '<input type="radio" id="produk-'. $p['food_menu_id'] .'" name="discount_product" value=' . $p['food_menu_id'] .'>' .$p['food_menu_name'] . '</input><br>';
                                        }
                                        ?>
                                    </div>

                                </div>
                                <div class="col-sm-7" id="kombinasi" hidden>
                                    <div class="col-sm-12 form-control">
                                        <?php
                                        foreach ($produk as $p) {
                                            echo '<input type="checkbox" name="discount_product_combination[]" value=' . $p['food_menu_id'] .'>' .$p['food_menu_name'] . '</input><br>';
                                        }
                                        ?>
                                    </div>

                                </div>
                                <div class="col-sm-7" id="periode" hidden>
                                    <div class="col-sm-6">
                                        <input type="text" name="supplier_name" id="supplier_name" class="form-control" placeholder="Dari Tanggal" required value="" />
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" name="supplier_name" id="supplier_name" class="form-control" placeholder="Sampai Tanggal" required value="" />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Minimal Jumlah Barang <span class="asterisk">*</span></label>
                                <div class="col-sm-7">
                                    <input type="number" name="product_quantity_minimum" class="form-control" placeholder="Minimal Jumlah Barang" required value="0" min="0" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Minimal Total Pembelian <span class="asterisk">*</span></label>
                                +                                <div class="col-sm-7">
                                    <input type="number" name="product_total_sales_minimum" class="form-control" placeholder="Minimal Total Pembelian" required value="0" min="0" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Diskon <span class="asterisk">*</span></label>
                                <div class="col-sm-7">
                                    <a onclick="produkdiskonfunction()">
                                        <div class="col-sm-4">
                                            <input id="radio-6" class="" name="discount_type" type="radio" value="1" checked>
                                            <label for="radio-32" class="">Produk</label>
                                        </div>
                                    </a>
                                    <a onclick="persentasediskonfunction()">
                                        <div class="col-sm-4">
                                            <input id="radio-7" class="" name="discount_type" type="radio" value="2">
                                            <label for="radio-33" class="">Persentase</label>
                                        </div>
                                    </a>
                                    <a onclick="nominaldiskonfunction()">
                                        <div class="col-sm-4">
                                            <input id="radio-8" class="" name="discount_type" type="radio" value="3">
                                            <label for="radio-33" class="">Nominal</label>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-sm-7" id="produkdiskon">
                                    <div class="col-sm-12 form-control">
                                        <?php
                                        foreach ($produk as $p) {
                                            echo '<input type="checkbox" name="discount_free_product[]" value=' . $p['food_menu_id'] .'>' .$p['food_menu_name'] . '</input><br>';
                                        }
                                        ?>
                                    </div>

                                </div>
                                <div class="col-sm-7" id="persentasediskon" hidden>
                                    <div class="input-group">
                                        <input type="text" name="discount_percent" class="form-control" placeholder="Persentase" required value="" />
                                        <span class="input-group-addon">%</span>
                                    </div>
                                </div>
                                <div class="col-sm-7" id="nominaldiskon" hidden>

                                    <div class="input-group">
                                        <span class="input-group-addon">Rp</span>
                                        <input type="text" name="discount_nominal" class="form-control" placeholder="Nominal" required value="" />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Untuk Member/Umum <span class="asterisk">*</span></label>
                                <div class="col-sm-7">
                                    <a>
                                        <div class="col-sm-4">
                                            <input id="radio-9" class="" name="discount_for_member_type" type="radio" value="1" checked>
                                            <label for="radio-32" class="">Member</label>
                                        </div>
                                    </a>
                                    <a>
                                        <div class="col-sm-4">
                                            <input id="radio-10" class="" name="discount_for_member_type" type="radio" value="2">
                                            <label for="radio-33" class="">Umum</label>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </form>
                        <div class="modal-footer">
                            <button type="button" id="close_modal" class="btn btn-danger pull-left" data-dismiss="modal">Close</button>
                            <button type="submit" id="save" class="btn btn-success">Save</button>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>

    <script>

        function periodefunction() {
            $("#radio-2").attr("checked",true);
            $("#periode").attr("hidden",false);
        }
        function alltimefunction() {
            $("#radio-1").attr("checked",true);
            $("#periode").attr("hidden",true);
        }
        function produkfunction() {
            $("#radio-4").attr("checked",true);
            $("#produk").attr("hidden",false);
            $("#kategori").attr("hidden",true);
            $("#kombinasi").attr("hidden",true);
        }
        function kategorifunction() {
            $("#radio-3").attr("checked",true);
            $("#kategori").attr("hidden",false);
            $("#produk").attr("hidden",true);
            $("#kombinasi").attr("hidden",true);
        }
        function kombinasifunction() {
            $("#radio-5").attr("checked",true);
            $("#produk").attr("hidden",true);
            $("#kategori").attr("hidden",true);
            $("#kombinasi").attr("hidden",false);
        }
        function produkdiskonfunction() {
            $("#radio-6").attr("checked",true);
            $("#nominaldiskon").attr("hidden",true);
            $("#persentasediskon").attr("hidden",true);
            $("#produkdiskon").attr("hidden",false);
        }
        function persentasediskonfunction() {
            $("#radio-7").attr("checked",true);
            $("#nominaldiskon").attr("hidden",true);
            $("#persentasediskon").attr("hidden",false);
            $("#produkdiskon").attr("hidden",true);
        }
        function nominaldiskonfunction() {
            $("#radio-8").attr("checked",true);
            $("#nominaldiskon").attr("hidden",false);
            $("#persentasediskon").attr("hidden",true);
            $("#produkdiskon").attr("hidden",true);
        }
        $('#tambah').click(function() {
            $("input[name='discount_id']").val("");
            $("#supplier_id").val("").trigger("chosen:updated");
            $("input[name='discount_name']").val("");
            $("#units").val("gram").trigger("chosen:updated");
            $("input[name='discount_notes']").val("");
        });

        $('.edit').click(function() {
            jQuery.ajax({
                type: "POST",
                url: "<?= base_url(); ?>discount/form",
                dataType: 'JSON',
                data: {id: $(this).attr("id")},
                success: function(data) {

                    $("input[name='discount_id']").val(data[0]['discount_id']);
                    if(data[0]['discount_date_type']==2){
                        periodefunction();
                        $("input[name='discount_date_from']").val(data[0]['discount_date_from']);
                        $("input[name='discount_date_from']").val(data[0]['discount_date_from']);
                    }else{
                        alltimefunction();
                    }
                    if(data[0]['discount_member_type']==2){
                        $("#radio-9").attr("checked",true);
                    }else{
                        $("#radio-8").attr("checked",true);
                    }
                }
            });
        });

        $('#save').click(function() {
            $('#basicForm').submit();
        });
    </script>
    <?php
}
?>
