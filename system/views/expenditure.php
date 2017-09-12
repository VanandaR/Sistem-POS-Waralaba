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
                    <th>Nama Pengeluaran</th>
                    <th>Jumlah Pengeluaran</th>
                    <th>User</th>
                    <th>Waktu</th>
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
                        <?php
                        if ($this->session->userdata('outlet_id') == 'all') {
                            ?>
                            <td><?= $t['outlet_name']; ?></td>
                            <?php
                        }
                        ?>
                        <td><?= $t['expenditure_name']; ?></td>
                        <td><?= $t['price']; ?></td>
                        <td><?= $t['user_name']; ?></td>
                        <td><?= $t['timestamp']; ?></td>
                        <td>
                            <?php
                            if ($this->session->userdata('outlet_id') != 'all') {
                                ?>
                                <a href="#myModal" data-toggle="modal" data-target="#myModal" class="edit" id="<?= $t['expenditure_id']; ?>"><i class="fa fa-pencil"></i> Ubah</a> |
                                <?php
                            }
                            ?>
                            <a href="<?= base_url(); ?>expenditure/delete/<?= $t['expenditure_id']; ?>" onclick="return confirm('Apakah anda yakin menghapus data penting ini?');"><i class="fa fa-trash-o"></i> Hapus</a>
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
                        <form id="basicForm" method="POST" action="<?= base_url(); ?>expenditure/process" class="form-horizontal">
                            <input type="hidden" name="expenditure_id" value="" />
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Nama Pengeluaran <span class="asterisk">*</span></label>
                                <div class="col-sm-8">
                                    <input type="text" name="expenditure_name" class="form-control" placeholder="Nama Pengeluaran" required value="" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4 control-label">Jumlah Pengeluaran <span class="asterisk">*</span></label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <span class="input-group-addon">Rp</span>
                                        <input type="number" name="expenditure_price" class="form-control" placeholder="Jumlah Pengeluaran" required value="" />
                                    </div>
                                </div>
                            </div>
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
        $('#tambah').click(function() {
            $("input[name='expenditure_id']").val("");
            $("#supplier_id").val("").trigger("chosen:updated");
            $("input[name='expenditure_name']").val("");
            $("#units").val("gram").trigger("chosen:updated");
            $("input[name='expenditure_notes']").val("");
        });

        $('.edit').click(function() {
            jQuery.ajax({
                type: "POST",
                url: "<?= base_url(); ?>expenditure/form",
                dataType: 'JSON',
                data: {id: $(this).attr("id")},
                success: function(data) {
                    $("input[name='expenditure_id']").val(data[0]['expenditure_id']);
                    $("input[name='expenditure_name']").val(data[0]['expenditure_name']);
                    $("input[name='expenditure_price']").val(data[0]['price']);
                }
            });
        });

        $('#save').click(function() {
            $('#basicForm').submit();
        });
        $('#saverevisi').click(function() {
            $('#revisiForm').submit();
        });
    </script>
    <?php
}
?>
