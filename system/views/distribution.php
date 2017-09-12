<div class="panel panel-default">
    <div class="row">
        <div class="col-md-6">
            <form id="basicForm" method="POST" action="<?= base_url(); ?>distribution/process" class="form-horizontal">
                <input type="hidden" name="distribution_id" value="<?= $this->session->userdata('distribution_id'); ?>" />
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Bahan [After Pack] <span class="asterisk">*</span></label>
                        <div class="col-sm-9">
                            <select class="form-control chosen-select" name="storage_id" id="storage_id" data-placeholder="Pilih Bahan [After Pack]" required>
                                <option value=""></option>
                                <?php
                                foreach ($storage as $s):
                                    ?>
                                    <option value="<?= $s['storage_id'] . ";" . $s['units']; ?>" <?= (($isi != NULL) ? (($isi[0]['storage_id'] == $s['storage_id']) ? "selected" : "") : "") ?>><?= $s['material_name'] . ' [' . $s['units'] . ']'; ?></option>
                                    <?php
                                endforeach;
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Outlet <span class="asterisk">*</span></label>
                        <div class="col-sm-9">
                            <select class="form-control chosen-select" name="outlet" id="outlet" data-placeholder="Pilih Outlet" required>
                                <option value=""></option>
                                <?php
                                foreach ($outlet as $s):
                                    ?>
                                    <option value="<?= $s['outlet_id']; ?>" <?= (($isi != NULL) ? (($isi[0]['outlet_id'] == $s['outlet_id']) ? "selected" : "") : "") ?>><?= $s['outlet_name']; ?></option>
                                    <?php
                                endforeach;
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Bahan pada Outlet <span class="asterisk">*</span></label>
                        <div class="col-sm-9">
                            <select class="form-control chosen-select" name="material" id="material" data-placeholder="Pilih Bahan pada Outlet" required>
                                <option value=""></option>
                                <?php
                                foreach ($material as $s):
                                    ?>
                                    <option value="<?= $s['material_id']; ?>" <?= (($isi != NULL) ? (($isi[0]['material_id'] == $s['material_id']) ? "selected" : "") : "") ?>><?= $s['material_name'] . ' [' . $s['units'] . ']'; ?></option>
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
                            <a href="<?= base_url(); ?>distribution" type="button" class="btn btn-default">Reset</a>
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
                            <th>Bahan [After Pack]</th>
                            <th>Outlet</th>
                            <th>Bahan pada Outlet</th>
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
                                <td><?= $t['material_name_storage']; ?></td>
                                <td><?= $t['outlet_name']; ?></td>
                                <td><?= $t['material_name']; ?></td>
                                <td><?= $t['amount']; ?></td>
                                <td>
                                    <a href="<?= base_url(); ?>distribution/index/<?= $t['tmp_distribution_storage']; ?>"><i class="fa fa-pencil"></i> Ubah</a> |
                                    <a href="<?= base_url(); ?>distribution/process/<?= $t['tmp_distribution_storage']; ?>" onclick="return confirm('Apakah anda yakin menghapus data penting ini?');"><i class="fa fa-trash-o"></i> Hapus</a>
                                </td>
                            </tr>
                            <?php
                        endforeach;
                        ?>
                    </tbody>
                </table>
                <a href="<?= base_url(); ?>distribution/save" class="btn btn-primary pull-right" style="margin-right: 10px">Save</a>
            </div><!-- table-responsive -->
        </div><!-- col-md-6 -->
    </div><!--row -->
</div><!-- panel -->

<script>
	$("#storage_id").change(function() {
		data = $("#storage_id").val().split(';');
		$("#unit_label").html(data[1]);
	});

	$('#outlet').change(function() {
		jQuery.ajax({
			type: "POST",
			url: "<?= base_url(); ?>distribution/material_list",
			dataType: 'JSON',
// 			data: {id: $(this).attr("id")},
			data: {id: $('#outlet').val()},
			success: function(data) {
				$('#material').html('<option value=""></option>');
				for (var i = 0; i < data.length; i++) {
					$('#material').append('<option value="' + data[i]['material_id'] + '">' + data[i]['material_name'] + '</option>');
				}
				$("#material").val("").trigger("chosen:updated");
			}
		});
	});
</script>