<div class="panel panel-default">
    <div class="panel-body">
        <div class="table-responsive">
            <table class="table table-striped" id="table">
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
                        <th>Nama Supplier</th>
                        <th>Alamat Suplier</th>
                        <th>Telpon Supplier</th>
                        <th>Jumlah Barang</th>
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
							<td><?= $t['supplier_name']; ?></td>
                            <td><?= $t['supplier_address']; ?></td>
                            <td><?= $t['supplier_phone']; ?></td>
                            <td><b><?= $t['material_count']; ?></b> Jenis</td>
                            <td>
								<?php
								if ($this->session->userdata('outlet_id') != 'all') {
								?>
								<a href="#myModal" data-toggle="modal" data-target="#myModal" class="edit" id="<?= $t['supplier_id']; ?>"><i class="fa fa-pencil"></i> Ubah</a> |
								<?php
								}
								?>
                                <a href="<?= base_url(); ?>supplier/delete/<?= $t['supplier_id']; ?>" onclick="return confirm('Apakah anda yakin menghapus data penting ini?');"><i class="fa fa-trash-o"></i> Hapus</a>
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
					<form id="basicForm" method="POST" action="<?= base_url(); ?>supplier/process" class="form-horizontal">
						<input type="hidden" name="supplier_id" value="" />
						<div class="form-group">
							<label class="col-sm-4 control-label">Nama Supplier <span class="asterisk">*</span></label>
							<div class="col-sm-8">
								<input type="text" name="supplier_name" id="supplier_name" class="form-control" placeholder="Nama supplier" required value="" />
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-4 control-label">Alamat Supplier <span class="asterisk">*</span></label>
							<div class="col-sm-8">
								<input type="text" name="supplier_address" class="form-control" placeholder="Alamat supplier" required value="" />
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-4 control-label">Telpon Supplier <span class="asterisk">*</span></label>
							<div class="col-sm-8">
								<input type="text" name="supplier_phone" class="form-control" placeholder="Telpon supplier" required value="" />
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
		$("input[name='supplier_id']").val("");
		$("input[name='supplier_name']").val("");
		$("input[name='supplier_address']").val("");
		$("input[name='supplier_phone']").val("");
	});

	$('.edit').click(function() {
		jQuery.ajax({
			type: "POST",
			url: "<?= base_url(); ?>supplier/form",
			dataType: 'JSON',
			data: {id: $(this).attr("id")},
			success: function(data) {
				$("input[name='supplier_id']").val(data[0]['supplier_id']);
				$("input[name='supplier_name']").val(data[0]['supplier_name']);
				$("input[name='supplier_address']").val(data[0]['supplier_address']);
				$("input[name='supplier_phone']").val(data[0]['supplier_phone']);
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
