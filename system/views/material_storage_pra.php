<div class="panel panel-default">
    <div class="panel-body">
        <div class="table-responsive">
            <table class="table table-striped" id="table" style="font-size: 11px;">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Bahan</th>
                        <th>Stok</th>
                        <th>Keterangan</th>
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
                            <td><?= $t['amount'] . ' ' . $t['units']; ?></td>
                            <td><?= $t['notes']; ?></td>
                            <td>
								<a href="#myModal" data-toggle="modal" data-target="#myModal" class="edit" id="<?= $t['storage_pra_id']; ?>"><i class="fa fa-pencil"></i> Ubah</a> |
                                <a href="<?= base_url(); ?>material/delete/<?= $t['storage_pra_id']; ?>" onclick="return confirm('Apakah anda yakin menghapus data penting ini?');"><i class="fa fa-trash-o"></i> Hapus</a>
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

<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-body">
            	<div id="modal_content">
					<form id="basicForm" method="POST" action="<?= base_url(); ?>material_storage_pra/process" class="form-horizontal">
						<input type="hidden" name="storage_pra_id" value="" />
						<div class="form-group">
							<label class="col-sm-4 control-label">Nama Bahan <span class="asterisk">*</span></label>
							<div class="col-sm-8">
								<input type="text" name="material_name" class="form-control" placeholder="Nama Bahan" required value="" />
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-4 control-label">Satuan <span class="asterisk">*</span></label>
							<div class="col-sm-8">
								<select class="form-control chosen-select" name="units" id="units" data-placeholder="Pilih Units" required>
									<option value="gram">gram</option>
									<option value="kg">kg</option>
									<option value="ml">ml</option>
									<option value="liter">liter</option>
									<option value="units">units</option>
									<option value="pcs">pcs</option>
									<option value="packs">packs</option>
									<option value="box">box</option>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-4 control-label">Keterangan bahan Baku <span class="asterisk">*</span></label>
							<div class="col-sm-8">
								<input type="text" name="notes" class="form-control" placeholder="Keterangan Bahan" required value="" />
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
		$("input[name='storage_pra_id']").val("");
		$("input[name='material_name']").val("");
		$("#units").val("gram").trigger("chosen:updated");
		$("input[name='notes']").val("");
	});

	$('.edit').click(function() {
		jQuery.ajax({
			type: "POST",
			url: "<?= base_url(); ?>material_storage_pra/form",
			dataType: 'JSON',
			data: {id: $(this).attr("id")},
			success: function(data) {
				$("input[name='storage_pra_id']").val(data[0]['storage_pra_id']);
				$("input[name='material_name']").val(data[0]['material_name']);
				$("#units").val(data[0]['units']).trigger("chosen:updated");
				$("input[name='notes']").val(data[0]['notes']);
			}
		});
	});

	$('#save').click(function() {
		$('#basicForm').submit();
	});
</script>
