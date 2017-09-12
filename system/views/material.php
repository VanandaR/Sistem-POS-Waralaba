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
					<th>Nama Bahan Baku</th>
					<th>Supplier</th>
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
						<?php
						if ($this->session->userdata('outlet_id') == 'all') {
							?>
							<td><?= $t['outlet_name']; ?></td>
							<?php
						}
						?>
						<td><?= $t['material_name']; ?></td>
						<td><?= $t['supplier_name']; ?></td>
						<td><?= $t['stock'] . ' ' . $t['units']; ?></td>
						<td><?= $t['material_notes']; ?></td>
						<td>
							<?php
							if ($this->session->userdata('outlet_id') != 'all') {
								?>
								<a href="#myModal" data-toggle="modal" data-target="#myModal" class="edit" id="<?= $t['material_id']; ?>"><i class="fa fa-pencil"></i> Ubah</a> |
								<a href="#RevisiModal" data-toggle="modal" data-target="#RevisiModal" class="revisi" id="<?= $t['material_id']; ?>"><i class="fa fa-refresh"></i> Revisi Stock</a> |
								<?php
							}
							?>
							<a href="<?= base_url(); ?>material/delete/<?= $t['material_id']; ?>" onclick="return confirm('Apakah anda yakin menghapus data penting ini?');"><i class="fa fa-trash-o"></i> Hapus</a>
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
						<form id="basicForm" method="POST" action="<?= base_url(); ?>material/process" class="form-horizontal">
							<input type="hidden" name="material_id" value="" />
							<div class="form-group">
								<label class="col-sm-4 control-label">Supplier Bahan Baku <span class="asterisk">*</span></label>
								<div class="col-sm-8">
									<select class="form-control chosen-select" name="supplier_id" id="supplier_id" data-placeholder="Pilih Supplier" required>
										<option value=""></option>
										<?php
										foreach ($supplier as $s):
											?>
											<option value="<?= $s['supplier_id']; ?>"><?= $s['supplier_name']; ?></option>
											<?php
										endforeach;
										?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4 control-label">Nama Bahan Baku <span class="asterisk">*</span></label>
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
									<input type="text" name="material_notes" class="form-control" placeholder="Keterangan Bahan Baku" required value="" />
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
	<div id="RevisiModal" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-body">
					<div id="modal_content">
						<form id="revisiForm" method="POST" action="<?= base_url(); ?>material/revision" class="form-horizontal">
							<input type="hidden" name="material_id" value="" />
							<input type="hidden" name="stok_lama" value="" />
							<input type="hidden" name="material_name" value="" />
							<div class="form-group">
								<label class="col-sm-4 control-label">Stok <span class="asterisk">*</span></label>
								<div class="col-sm-8">
									<div class="input-group">
									<input type="number" name="stok" class="form-control" placeholder="Jumlah Stok" required value="" />
									<span class="input-group-addon" id="unit_label"></span>
										</div>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4 control-label">Alasan Revisi <span class="asterisk">*</span></label>

								<div class="col-sm-8">
									<textarea name="alasan_revisi" class="form-control" required></textarea>
								</div>
							</div>

						</form>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" id="close_modal" class="btn btn-danger pull-left" data-dismiss="modal">Close</button>
					<button type="submit" id="saverevisi" class="btn btn-success">Save</button>
				</div>
			</div>
		</div>
	</div>

	<script>
		$('#tambah').click(function() {
			$("input[name='material_id']").val("");
			$("#supplier_id").val("").trigger("chosen:updated");
			$("input[name='material_name']").val("");
			$("#units").val("gram").trigger("chosen:updated");
			$("input[name='material_notes']").val("");
		});

		$('.edit').click(function() {
			jQuery.ajax({
				type: "POST",
				url: "<?= base_url(); ?>material/form",
				dataType: 'JSON',
				data: {id: $(this).attr("id")},
				success: function(data) {
					$("input[name='material_id']").val(data[0]['material_id']);
					$("#supplier_id").val(data[0]['supplier_id']).trigger("chosen:updated");
					$("input[name='material_name']").val(data[0]['material_name']);
					$("#units").val(data[0]['units']).trigger("chosen:updated");
					$("input[name='material_notes']").val(data[0]['material_notes']);
				}
			});
		});

		$('.revisi').click(function() {
			jQuery.ajax({
				type: "POST",
				url: "<?= base_url(); ?>material/form",
				dataType: 'JSON',
				data: {id: $(this).attr("id")},
				success: function(data) {
					$("input[name='material_id']").val(data[0]['material_id']);
					$("input[name='material_name']").val(data[0]['material_name']);
					$("input[name='stok']").val(data[0]['stock']);
					$("input[name='stok_lama']").val(data[0]['stock']);
					$("#unit_label").html(data[0]['units']);
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
