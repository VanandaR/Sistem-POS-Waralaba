<div class="panel panel-default">
	<div class="panel-body">
		<div class="table-responsive">
			<table class="table" id="table">
				<thead>
				<tr>
					<th>No</th>
					<th>Nama User</th>
					<th>Username</th>
					<!--                        <th>Password</th>
                                            <th>Alamat</th>-->
					<th>Nomer KTP</th>
					<th>Nomer Telpon</th>
					<th>Jabatan</th>
					<th>Persentase</th>
					<th>Action</th>
				</tr>
				</thead>
				<tbody>
				<?php
				$i = 0;
				foreach ($dataTable as $t):
					if ($i % 2 != 0) {
						$kind = "odd";
					} else {
						$kind = "even";
					}

					if ($t['level'] == 1) {
						$position = "Owner";
					} else if ($t['level'] == 2) {
						$position = "Kasir";
					} else if ($t['level'] == 3) {
						$position = "Gudang";
					} else if ($t['level'] == 4) {
						$position = "Investor";
					}
					?>
					<tr class="gradeA <?= $kind; ?>">
						<td><?= ++$i; ?></td>
						<td><?= $t['user_name']; ?></td>
						<td><?= $t['username']; ?></td>
						<!--                            <td>********</td>
                            <td><?= $t['user_address']; ?></td>-->
						<td><?= $t['user_id_card']; ?></td>
						<td><?= $t['user_phone']; ?></td>
						<td><?= $position; ?></td>
						<td><?= $t['user_procentase']; ?>%</td>
						<td>
							<!--                                 <a href="<?= base_url(); ?>user/form/<?= $t['user_id']; ?>"><i class="fa fa-pencil"></i> Ubah</a> | -->
							<a href="#myModal" data-toggle="modal" data-target="#myModal" class="edit" id="<?= $t['user_id']; ?>"><i class="fa fa-pencil"></i> Ubah</a> |
							<!--                                 <a href="<?= base_url(); ?>user/setOutlet/<?= $t['user_id']; ?>"><i class="fa fa-building-o"></i> Outlet</a> | -->
							<a href="#outletModal" data-toggle="modal" data-target="#outletModal" class="outlet" id="<?= $t['user_id'] . ";" . $t['user_name']; ?>"><i class="fa fa-building-o"></i> Outlet</a> |
							<a href="<?= base_url(); ?>user/delete/<?= $t['user_id']; ?>" onclick="return confirm('Apakah anda yakin menghapus data penting ini?');"><i class="fa fa-trash-o"></i> Hapus</a>
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
					<form id="basicForm" method="POST" action="<?= base_url(); ?>user/process" class="form-horizontal">
						<input type="hidden" name="user_id" value="" />
						<div class="form-group">
							<label class="col-sm-3 control-label">Username <span class="asterisk">*</span></label>
							<div class="col-sm-6">
								<input type="text" name="username" class="form-control" placeholder="Username" required value="" />
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Password <span class="asterisk">*</span></label>
							<div class="col-sm-6">
								<input type="password" name="password" class="form-control" placeholder="Password" required />
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Nama User <span class="asterisk">*</span></label>
							<div class="col-sm-6">
								<input type="text" name="user_name" class="form-control" placeholder="Nama user" required value="" />
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Alamat User <span class="asterisk">*</span></label>
							<div class="col-sm-6">
								<input type="text" name="user_address" class="form-control" placeholder="Alamat user" required value="" />
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Nomor KTP user <span class="asterisk">*</span></label>
							<div class="col-sm-6">
								<input type="text" name="user_id_card" class="form-control" placeholder="Nomor KTP user" required value="" />
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Telpon <span class="asterisk">*</span></label>
							<div class="col-sm-6">
								<input type="text" name="user_phone" class="form-control" placeholder="Nomor telpon user" required value="" />
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Jabatan <span class="asterisk">*</span></label>
							<div class="col-sm-6">
								<select id="level" class="form-control chosen-select" name="level" required>
									<option value="">Choose One</option>
									<option value="1">Owner</option>
									<option value="2">Kasir</option>
									<option value="3">Gudang</option>
									<option value="4">Investor</option>
								</select>
							</div>
						</div><!-- form-group -->
						<div class="form-group" id="komisi">
							<label class="col-sm-3 control-label">Komisi <span class="asterisk">*</span></label>
							<div class="col-sm-6">
								<input type="text" name="user_procentase" class="form-control" placeholder="Komisi investor" required value="" />
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
		$("input[name='user_id']").val("");
		$("input[name='username']").val("");
		$("input[name='password']").attr('required', true).attr('placeholder','Password');
		$("input[name='user_name']").val("");
		$("input[name='user_address']").val("");
		$("input[name='user_id_card']").val("");
		$("input[name='user_phone']").val("");
		$("input[name='user_procentase']").val("");
		$("#level").val("").trigger("chosen:updated");
	});

	$('.edit').click(function() {
		jQuery.ajax({
			type: "POST",
			url: "<?= base_url(); ?>user/form",
			dataType: 'JSON',
			data: {id: $(this).attr("id")},
			success: function(data) {
				$("input[name='user_id']").val(data[0]['user_id']);
				$("input[name='username']").val(data[0]['username']);
				$("input[name='password']").attr('required', false).attr('placeholder','Kosongi jika tidak ingin mengganti password');
				$("input[name='user_name']").val(data[0]['user_name']);
				$("input[name='user_address']").val(data[0]['user_address']);
				$("input[name='user_id_card']").val(data[0]['user_id_card']);
				$("input[name='user_phone']").val(data[0]['user_phone']);
				$("input[name='user_procentase']").val(data[0]['user_procentase']);
				$("#level").val(data[0]['level']).trigger("chosen:updated");
			}
		});
	});

	$('#save').click(function() {
		$('#basicForm').submit();
	});
</script>

<div id="outletModal" class="modal fade" role="dialog">
	<div class="modal-dialog" style="width:90%">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-body">
				<div id="modal_content">
					<h3>Hak Akses untuk <span id="label_user_name"></span></h3>
					<div class="row">
						<div class="col-md-6">
							<input type="hidden" name="user_id" value="" />
							<div class="form-group">
								<label class="col-sm-4 control-label">Nama Outlet <span class="asterisk">*</span></label>
								<div class="col-sm-8">
									<select class="form-control chosen-select" name="outlet_id" id="outlet_id" data-placeholder="Pilih Outlet" required>
										<option value=""></option>
										<?php
										foreach ($outlet as $o):
											?>
											<option value="<?= $o['outlet_id']; ?>"><?= $o['outlet_name']; ?></option>
											<?php
										endforeach;
										?>
									</select>
								</div>
							</div>
							<button type="submit" id="save_outlet" class="btn btn-success pull-right">Save</button>
						</div>
						<div class="col-md-6">
							<div class="table-responsive">
								<table class="table" id="table1" style="font-size: 11px;">
									<thead>
									<tr>
										<th>No</th>
										<th>Nama Outlet</th>
										<th>Action</th>
									</tr>
									</thead>
									<tbody id="outlet_list">
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
	$('.outlet').click(function() {
		var id_data = $(this).attr("id").split(";");
		$("input[name='user_id']").val(id_data[0]);
		$("#label_user_name").html(id_data[1]);

		jQuery.ajax({
			type: "POST",
			url: "<?= base_url(); ?>user/outlet_list",
			dataType: 'JSON',
			data: {id: id_data[0]},
			success: function(data) {
				$("#outlet_list").html("");
				for (var i = 0; i < data.length; i++) {
					$("#outlet_list").append(
						'<tr class="gradeA ' + ((i % 2 === 0) ? 'even' : 'odd') + '">' +
						'	<td>' + (i + 1) + '</td>' +
						'	<td>' + data[i]['outlet_name'] + '</td>' +
						'	<td><span style="cursor: pointer; cursor: hand" id="' + data[i]['outlet_user_id'] + '" onclick="if (confirm(\'Apakah anda yakin menghapus data penting ini?\')) { delete_outlet(this); }"><i class="fa fa-trash-o"></i> Hapus</span></td>' +
						'</tr>'
					);
				}
			}
		});
	});

	$('#save_outlet').click(function() {
		jQuery.ajax({
			type: "POST",
			url: "<?= base_url(); ?>user/outlet_save",
			dataType: 'JSON',
			data: {user_id: $("input[name='user_id']").val(), outlet_id: $("#outlet_id").val()},
			success: function(data) {
				$("#outlet_list").html("");
				for (var i = 0; i < data.length; i++) {
					$("#outlet_list").append(
						'<tr class="gradeA ' + ((i % 2 === 0) ? 'even' : 'odd') + '">' +
						'	<td>' + (i + 1) + '</td>' +
						'	<td>' + data[i]['outlet_name'] + '</td>' +
						'	<td><span style="cursor: pointer; cursor: hand" id="' + data[i]['outlet_user_id'] + '" onclick="if (confirm(\'Apakah anda yakin menghapus data penting ini?\')) { delete_outlet(this); }"><i class="fa fa-trash-o"></i> Hapus</span></td>' +
						'</tr>'
					);
				}
			}
		});
	});

	function delete_outlet(t) {
		jQuery.ajax({
			type: "POST",
			url: "<?= base_url(); ?>user/outlet_delete",
			dataType: 'JSON',
			data: {user_id: $("input[name='user_id']").val(), id: $(t).attr("id")},
			success: function(data) {
				$("#outlet_list").html("");
				for (var i = 0; i < data.length; i++) {
					$("#outlet_list").append(
						'<tr class="gradeA ' + ((i % 2 === 0) ? 'even' : 'odd') + '">' +
						'	<td>' + (i + 1) + '</td>' +
						'	<td>' + data[i]['outlet_name'] + '</td>' +
						'	<td><span style="cursor: pointer; cursor: hand" id="' + data[i]['outlet_user_id'] + '" onclick="if (confirm(\'Apakah anda yakin menghapus data penting ini?\')) { delete_outlet(this); }"><i class="fa fa-trash-o"></i> Hapus</span></td>' +
						'</tr>'
					);
				}
			}
		});
	}
</script>
