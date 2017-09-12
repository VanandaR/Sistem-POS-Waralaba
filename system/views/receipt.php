<div class="panel panel-default">
    <div class="panel-body">
        <div class="table-responsive">
            <table class="table table-striped" id="table" style="font-size: 11px;">
                <thead>
                <tr>
                    <th>No</th>
                    <?php
                    if ($this->session->userdata('outlet_id') == 'all') {
                        ?>
                        <th>Outlet</th>
                        <?php
                    }
                    ?>
                    <th>Menu Makanan</th>
                    <th>Resep</th>
                    <th>Jumlah</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $i = 0;
                foreach ($dataTable as $t):
                    ?>
                    <tr class="gradeA">
                        <td><?= ++$i; ?></td>
                        <?php
                        if ($this->session->userdata('outlet_id') == 'all') {
                            ?>
                            <td><?= $t['outlet_name']; ?></td>
                            <?php
                        }
                        ?>
                        <td><?= $t['food_menu_name']; ?></td>
                        <td><?= $t['material_name']; ?></td>
                        <td><?= $t['amount']; ?></td>
                        <td>
                            <?php
                            if ($this->session->userdata('outlet_id') != 'all') {
                                ?>
                                <a href="#myModal" data-toggle="modal" data-target="#myModal" class="edit" id="<?= $t['food_menu_material_id']; ?>"><i class="fa fa-pencil"></i> Ubah</a> |
                                <?php
                            }
                            ?>
                            <a href="<?= base_url(); ?>receipt/delete/<?= $t['food_menu_material_id']; ?>" onclick="return confirm('Apakah anda yakin menghapus data penting ini?');"><i class="fa fa-trash-o"></i> Hapus</a>
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
                        <form id="basicForm" method="POST" action="<?= base_url(); ?>receipt/process" class="form-horizontal">
                            <input type="hidden" name="receipt_id" value="" />
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Nama Menu Makanan <span class="asterisk">*</span></label>
                                <div class="col-sm-8">
                                    <select class="form-control chosen-select" name="food_menu" id="food_menu" data-placeholder="Pilih Menu Makanan" required>
                                        <option value=""></option>
                                        <?php
                                        foreach ($food_menu as $s):
                                            ?>
                                            <option value="<?= $s['food_menu_id']?>"><?= $s['food_menu_name']; ?></option>
                                            <?php
                                        endforeach;
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <?php for($i=0;$i<10;$i++):?>
                            <div class="form-group" id="bahan_id<?php echo $i;?>" hidden>
                                <label class="col-sm-4 control-label">Bahan<span class="asterisk">*</span></label>
                                <div class="col-sm-5">
                                    <select class="form-control chosen-select" name="material_id<?php echo $i;?>" id="material_id<?php echo $i;?>" data-placeholder="Pilih Bahan Baku" required>
                                        <option value=""></option>
                                        <?php
                                        foreach ($material as $s):
                                            ?>
                                            <option value="<?= $s['material_id'] . ";" . $s['units']; ?>"><?= $s['material_name'] . ' [' . $s['units'] . ']'; ?></option>
                                            <?php
                                        endforeach;
                                        ?>
                                    </select>
                                </div>
                                <div class="col-sm-3">
                                    <div class="input-group">
                                        <input type="text" name="amount<?php echo $i;?>" class="form-control" placeholder="Jumlah" value="" />
                                        <span class="input-group-addon" id="unit_label<?php echo $i;?>"></span>
                                    </div>
                                </div>
                            </div>
                            <?php endfor;?>


                            <div id="bahan"></div>
                            <a onclick="tambahFunction()" class="btn col-sm-offset-4 col-sm-4">Tambah</a>

                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="close_modal" class="btn btn-danger pull-left" data-dismiss="modal">Close</button>
                    <button type="submit" id="save" class="btn btn-success">Save</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        var i=0;

        function tambahFunction() {
            $("#bahan_id"+i).attr("hidden",false);

//            document.getElementById("bahan").innerHTML+='<div class="form-group">' +
//                '<label class="col-sm-4 control-label">Bahan '+i+'<span class="asterisk">*</span></label> ' +
//                '<div class="col-sm-5"> ' +
//                '<select class="form-control chosen-select" name="material_id" id="material_id" data-placeholder="Pilih Bahan Baku" required> ' +
//                '<option value=""></option> ' +
//                <?php //foreach ($material as $s): ?>
//                '<option value="<?//= $s['material_id'] . ";" . $s['units']; ?>//"><?//= $s['material_name'] . ' [' . $s['units'] . ']'; ?>//</option>'+
//                <?php //endforeach; ?>
//                '</select> ' +
//                '</div> ' +
//                '<div class="col-sm-3"> ' +
//                '<div class="input-group"> ' +
//                '<input type="text" name="amount" class="form-control" placeholder="Jumlah" value="" /> ' +
//                '<span class="input-group-addon" id="unit_label"></span> ' +
//                '</div> ' +
//                '</div> ' +
//                '</div>';
            i=i+1;
        }
        var j;
//        for(j=0;j<10;j++){
//            $("#material_id"+j).change(function() {
//                data = $("#material_id"+j).val().split(';');
//                alert(data[1]);
//                $("#unit_label"+j).html(data[1]);
//            });
//        }
        $("#material_id0").change(function() {
            data = $("#material_id0").val().split(';');

            $("#unit_label0").html(data[1]);
        });
        $("#material_id1").change(function() {
            data = $("#material_id1").val().split(';');

                $("#unit_label1").html(data[1]);
        });
        $("#material_id2").change(function() {
            data = $("#material_id2").val().split(';');

            $("#unit_label2").html(data[1]);
        });
    </script>
    <script>

        $('#tambah').click(function() {
            $("input[name='receipt_id']").val("");
            $("#supplier_id").val("").trigger("chosen:updated");
            $("input[name='receipt_name']").val("");
            $("#units").val("gram").trigger("chosen:updated");
            $("input[name='receipt_notes']").val("");
        });


        $('.edit').click(function() {
            jQuery.ajax({
                type: "POST",
                url: "<?= base_url(); ?>receipt/form",
                dataType: 'JSON',
                data: {id: $(this).attr("id")},
                success: function(data) {
                    $("input[name='receipt_id']").val(data[0]['receipt_id']);
                    $("#supplier_id").val(data[0]['supplier_id']).trigger("chosen:updated");
                    $("input[name='receipt_name']").val(data[0]['receipt_name']);
                    $("#units").val(data[0]['units']).trigger("chosen:updated");
                    $("input[name='receipt_notes']").val(data[0]['receipt_notes']);
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
