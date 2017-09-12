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
                        <th>Nama Menu Makanan</th>
                        <th>Kategori</th>
                        <th>Harga Pokok</th>
                        <th>Price</th>
                        <th>Komisi</th>
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
                            <td><?= $t['food_menu_name']; ?></td>
                            <td><?= $t['category_name']; ?></td>
                            <td><?= $t['food_menu_hpp_price']; ?></td>
                            <td><?= $t['food_menu_price']; ?></td>
                            <td><?= $t['food_menu_commision']; ?></td>
                            <td>
								<?php
								if ($this->session->userdata('outlet_id') != 'all') {
								?>
                                <a href="#myModal" data-toggle="modal" data-target="#myModal" class="edit" id="<?= $t['food_menu_id']; ?>"><i class="fa fa-pencil"></i> Ubah</a> |
                                <a href="#foodMaterialModal" data-toggle="modal" data-target="#foodMaterialModal" class="material" id="<?= $t['food_menu_id'] . ";" . $t['food_menu_name']; ?>"><i class="fa fa-building-o"></i> Bahan</a> |
								<?php
								}
								?>
                                <a href="<?= base_url(); ?>food_menu/delete/<?= $t['food_menu_id']; ?>" onclick="return confirm('Apakah anda yakin menghapus data penting ini?');"><i class="fa fa-trash-o"></i> Hapus</a>
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
					<form id="basicForm" method="POST" action="<?= base_url(); ?>food_menu/process" class="form-horizontal">
						<input type="hidden" name="food_menu_id" value="" />
						<div class="form-group">
							<label class="col-sm-4 control-label">Kategori <span class="asterisk">*</span></label>
							<div class="col-sm-8">
								<select class="form-control chosen-select" name="category_id" id="category_id" data-placeholder="Pilih Kategori Menu" required>
									<option value=""></option>
									<?php
									foreach ($category as $s):
										?>
										<option value="<?= $s['category_id']; ?>"><?= $s['category_name']; ?></option>
										<?php
									endforeach;
									?>
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-4 control-label">Nama Menu Makanan <span class="asterisk">*</span></label>
							<div class="col-sm-8">
								<input type="text" name="food_menu_name" class="form-control" placeholder="Nama Menu Makanan" required value="" />
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-4 control-label">Harga Pokok Menu Makanan <span class="asterisk">*</span></label>
							<div class="col-sm-8">
								<input type="text" name="food_menu_hpp_price" class="form-control" placeholder="Harga Menu makanan" required value="" />
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-4 control-label">Harga Jual Menu Makanan <span class="asterisk">*</span></label>
							<div class="col-sm-8">
								<input type="text" name="food_menu_price" class="form-control" placeholder="Harga Menu makanan" required value="" />
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-4 control-label">Komisi per Pack <span class="asterisk">*</span></label>
							<div class="col-sm-8">
								<input type="text" name="food_menu_commision" class="form-control" placeholder="Komisi per pack" required value="" />
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
		$("input[name='food_menu_id']").val("");
		$("#category_id").val("").trigger("chosen:updated");
		$("input[name='food_menu_name']").val("");
		$("input[name='food_menu_hpp_price']").val("");
		$("input[name='food_menu_price']").val("");
		$("input[name='food_menu_commision']").val("");
	});

	$('.edit').click(function() {
		jQuery.ajax({
			type: "POST",
			url: "<?= base_url(); ?>food_menu/form",
			dataType: 'JSON',
			data: {id: $(this).attr("id")},
			success: function(data) {
				$("input[name='food_menu_id']").val(data[0]['food_menu_id']);
				$("#category_id").val(data[0]['category_id']).trigger("chosen:updated");
				$("input[name='food_menu_name']").val(data[0]['food_menu_name']);
				$("input[name='food_menu_hpp_price']").val(data[0]['food_menu_hpp_price']);
				$("input[name='food_menu_price']").val(data[0]['food_menu_price']);
				$("input[name='food_menu_commision']").val(data[0]['food_menu_commision']);
			}
		});
	});

	$('#save').click(function() {
		$('#basicForm').submit();
	});
</script>

<div id="foodMaterialModal" class="modal fade" role="dialog">
    <div class="modal-dialog" style="width:90%">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-body">
            	<div id="modal_content">
            		<h3>Bahan untuk <span id="label_food_menu_name"></span></h3>
            		<div class="row">
            			<div class="col-md-6">
							<input type="hidden" name="food_menu_id" value="" />
							<div class="form-group">
								<label class="col-sm-4 control-label">Nama Bahan <span class="asterisk">*</span></label>
								<div class="col-sm-8">
									<select class="form-control chosen-select" name="material_id" id="material_id" data-placeholder="Pilih Bahan Baku" required>
										<option value=""></option>
										<?php
										foreach ($material as $s):
											?>
											<option value="<?= $s['material_id']; ?>"><?= $s['material_name'] . ' - ' . $s['material_notes'] . ' [' . $s['units'] . ']'; ?></option>
											<?php
										endforeach;
										?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4 control-label">Jumlah Dibutuhkan <span class="asterisk">*</span></label>
								<div class="col-sm-8">
									<input type="text" name="amount" class="form-control" placeholder="Jumlah Bahan Baku yang Dibutuhkan" required value="" />
								</div>
							</div>
							<button type="submit" id="save_material" class="btn btn-success pull-right">Save</button>
						</div>
						<div class="col-md-6">
							<div class="table-responsive">
								<table class="table" id="table1" style="font-size: 11px;">
									<thead>
										<tr>
											<th>No</th>
											<th>Nama Bahan Baku</th>
											<th>Jumlah</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody id="material_list">
									</tbody>
								</table>
							</div><!-- table-responsive -->
						</div>
					</div>
				</div>
            </div>
            <div class="modal-footer">
                <button type="button" id="close_modal" class="btn btn-danger pull-left" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
	$('.material').click(function() {
		var id_data = $(this).attr("id").split(";");
		$("input[name='food_menu_id']").val(id_data[0]);
		$("#label_food_menu_name").html(id_data[1]);

		jQuery.ajax({
			type: "POST",
			url: "<?= base_url(); ?>food_menu/material_list",
			dataType: 'JSON',
			data: {id: id_data[0]},
			success: function(data) {
				$("#material_list").html("");
				for (var i = 0; i < data.length; i++) {
					$("#material_list").append(
						'<tr class="gradeA ' + ((i % 2 === 0) ? 'even' : 'odd') + '">' +
						'	<td>' + (i + 1) + '</td>' +
						'	<td>' + data[i]['material_name'] + '</td>' +
						'	<td>' + data[i]['amount'] + '</td>' +
						'	<td><span style="cursor: pointer; cursor: hand" id="' + data[i]['food_menu_material_id'] + '" onclick="if (confirm(\'Apakah anda yakin menghapus data penting ini?\')) { delete_material(this); }"><i class="fa fa-trash-o"></i> Hapus</span></td>' +
						'</tr>'
					);
				}
			}
		});
	});

	$('#save_material').click(function() {
		jQuery.ajax({
			type: "POST",
			url: "<?= base_url(); ?>food_menu/material_save",
			dataType: 'JSON',
			data: {food_menu_id: $("input[name='food_menu_id']").val(), material_id: $("#material_id").val(), amount: $("input[name='amount']").val()},
			success: function(data) {
				$("#material_list").html("");
				for (var i = 0; i < data.length; i++) {
					$("#material_list").append(
						'<tr class="gradeA ' + ((i % 2 === 0) ? 'even' : 'odd') + '">' +
						'	<td>' + (i + 1) + '</td>' +
						'	<td>' + data[i]['material_name'] + '</td>' +
						'	<td>' + data[i]['amount'] + '</td>' +
						'	<td><span style="cursor: pointer; cursor: hand" id="' + data[i]['food_menu_material_id'] + '" onclick="if (confirm(\'Apakah anda yakin menghapus data penting ini?\')) { delete_material(this); }"><i class="fa fa-trash-o"></i> Hapus</span></td>' +
						'</tr>'
					);
				}
			}
		});
	});

	function delete_material(t) {
		jQuery.ajax({
			type: "POST",
			url: "<?= base_url(); ?>food_menu/material_delete",
			dataType: 'JSON',
			data: {food_menu_id: $("input[name='food_menu_id']").val(), id: $(t).attr("id")},
			success: function(data) {
				$("#material_list").html("");
				for (var i = 0; i < data.length; i++) {
					$("#material_list").append(
						'<tr class="gradeA ' + ((i % 2 === 0) ? 'even' : 'odd') + '">' +
						'	<td>' + (i + 1) + '</td>' +
						'	<td>' + data[i]['material_name'] + '</td>' +
						'	<td>' + data[i]['amount'] + '</td>' +
						'	<td><span style="cursor: pointer; cursor: hand" class="delete_material" id="' + data[i]['food_menu_material_id'] + '" onclick="return confirm(\'Apakah anda yakin menghapus data penting ini?\');"><i class="fa fa-trash-o"></i> Hapus</span></td>' +
						'</tr>'
					);
				}
			}
		});
	}
</script>
<?php
}
?>
