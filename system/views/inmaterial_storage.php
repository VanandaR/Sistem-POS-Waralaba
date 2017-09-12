<div class="panel panel-default">
    <div class="row">
        <div class="col-md-6">
            <form id="basicForm" method="POST" action="<?= base_url(); ?>inmaterial_storage/process" class="form-horizontal">
                <input type="hidden" name="inmaterial_storage_id" value="<?= $this->session->userdata('inmaterial_storage_id'); ?>" />
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Bahan [Pra Pack] <span class="asterisk">*</span></label>
                        <div class="col-sm-9">
                            <select class="form-control chosen-select" name="storage_pra_id" id="storage_pra_id" data-placeholder="Pilih Bahan [Pra Pack]" required>
                                <option value=""></option>
                                <?php
                                foreach ($material as $s):
                                    ?>
                                    <option value="<?= $s['storage_pra_id'] . ";" . $s['units']; ?>" <?= (($isi != NULL) ? (($isi[0]['storage_pra_id'] == $s['storage_pra_id']) ? "selected" : "") : "") ?>><?= $s['material_name'] . ' [' . $s['units'] . ']'; ?></option>
                                    <?php
                                endforeach;
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Jumlah masuk <span class="asterisk">*</span></label>
                        <div class="col-sm-9">
							<div class="input-group">
								<input type="text" name="amount" class="form-control" placeholder="Jumlah Bahan Baku yang Masuk" required value="<?= (($isi != NULL) ? $isi[0]['amount'] : "") ?>" />
                                <span class="input-group-addon" id="unit_label"></span>
							</div>
                        </div>
                    </div>
                </div><!-- panel-body -->
                <div class="panel-footer">
                    <div class="row">
                        <div class="col-sm-9 col-sm-offset-3">
                            <button class="btn btn-primary">Add to List</button>
                            <a href="<?= base_url(); ?>inmaterial_storage" type="button" class="btn btn-default">Reset</a>
                        </div>
                    </div>
                </div>
            </form>
        </div><!-- col-md-6 -->
        <div class="col-md-6">
            <div class="table-responsive">
                <table class="table table-striped" style="font-size: 11px;">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Bahan [Pra Pack]</th>
                            <th>Jumlah</th>
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
                                <td><?= $t['material_name']; ?></td>
                                <td><?= $t['amount']; ?></td>
                                <td>
                                    <a href="<?= base_url(); ?>inmaterial_storage/index/<?= $t['tmp_inmaterial_storage']; ?>"><i class="fa fa-pencil"></i> Ubah</a> |
                                    <a href="<?= base_url(); ?>inmaterial_storage/process/<?= $t['tmp_inmaterial_storage']; ?>" onclick="return confirm('Apakah anda yakin menghapus data penting ini?');"><i class="fa fa-trash-o"></i> Hapus</a>
                                </td>
                            </tr>
                            <?php
                        endforeach;
                        ?>
                    </tbody>
                </table>
                <a href="<?= base_url(); ?>inmaterial_storage/save" class="btn btn-primary pull-right" style="margin-right: 10px">Save</a>
            </div><!-- table-responsive -->
        </div><!-- col-md-6 -->
    </div><!--row -->
</div><!-- panel -->

<script>
	$("#storage_pra_id").change(function() {
		data = $("#storage_pra_id").val().split(';');
		$("#unit_label").html(data[1]);
	});
</script>