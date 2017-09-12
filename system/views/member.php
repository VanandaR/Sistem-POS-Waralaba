<div class="panel panel-default">
    <div class="panel-body">
        <div class="table-responsive">
            <table class="table table-striped" id="table">
                <thead>
                    <tr>
                        <th>Nomer Kartu</th>
                        <th>Nama Member</th>
                        <th>Nomer Telpon</th>
                        <th>E-mail</th>
                        <th>Nomer WA</th>
                        <th>BBM</th>
                        <th>Instagram</th>
                        <th>Facebook</th>
                        <th>Twitter</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 0;
                    foreach ($dataTable as $t):
                        ?>
                        <tr class="gradeA">
                            <td><?= $t['member_card']; ?></td>
                            <td><?= $t['member_name']; ?></td>
                            <td><?= $t['member_phone']; ?></td>
                            <td><?= $t['member_mail']; ?></td>
                            <td><?= $t['member_wa']; ?></td>
                            <td><?= $t['member_bbm']; ?></td>
                            <td><?= $t['member_instagram']; ?></td>
                            <td><?= $t['member_facebook']; ?></td>
                            <td><?= $t['member_twitter']; ?></td>
                            <td>
                                <a href="#myModal" data-toggle="modal" data-target="#myModal" class="edit" id="<?= $t['member_id']; ?>"><i class="fa fa-pencil"></i> Ubah</a> |
                                <a href="<?= base_url(); ?>member/delete/<?= $t['member_id']; ?>" onclick="return confirm('Apakah anda yakin menghapus data penting ini?');"><i class="fa fa-trash-o"></i> Hapus</a>
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
					<form id="basicForm" method="POST" action="<?= base_url(); ?>member/process" class="form-horizontal">
						<input type="hidden" name="member_id" value="" />
						<div class="form-group">
							<label class="col-sm-3 control-label">Nomor Kartu <span class="asterisk">*</span></label>
							<div class="col-sm-6">
								<input type="text" name="member_card" class="form-control" placeholder="Nomer kartu" required value="" /> Wajib diisi
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Nama Member <span class="asterisk">*</span></label>
							<div class="col-sm-6">
								<input type="text" name="member_name" class="form-control" placeholder="Nama member" required value="" /> Wajib diisi
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Alamat Member <span class="asterisk">*</span></label>
							<div class="col-sm-6">
								<input type="text" name="member_address" class="form-control" placeholder="Alamat member" value="" />
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Nomor KTP Member <span class="asterisk">*</span></label>
							<div class="col-sm-6">
								<input type="text" name="member_id_card" class="form-control" placeholder="Nomor KTP member" value="" />
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Telpon <span class="asterisk">*</span></label>
							<div class="col-sm-6">
								<input type="text" name="member_phone" class="form-control" placeholder="Nomor telpon member" required value="" /> Wajib diisi
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">E-mail <span class="asterisk">*</span></label>
							<div class="col-sm-6">
								<input type="email" name="member_mail" class="form-control" placeholder="E-mail member" required value="" /> Wajib diisi
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">WA <span class="asterisk">*</span></label>
							<div class="col-sm-6">
								<input type="text" name="member_wa" class="form-control" placeholder="Nomor WA member" value="" />
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">BBM <span class="asterisk">*</span></label>
							<div class="col-sm-6">
								<input type="text" name="member_bbm" class="form-control" placeholder="PIN BBM member" required value="" /> Wajib diisi
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Instagram <span class="asterisk">*</span></label>
							<div class="col-sm-6">
								<input type="text" name="member_instagram" class="form-control" placeholder="Instagram member" required value="" /> Wajib diisi
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Facebook <span class="asterisk">*</span></label>
							<div class="col-sm-6">
								<input type="text" name="member_facebook" class="form-control" placeholder="Facebook member" required value="" /> Wajib diisi
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Twitter <span class="asterisk">*</span></label>
							<div class="col-sm-6">
								<input type="text" name="member_twitter" class="form-control" placeholder="Twitter member" value="" />
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
		$("input[name='member_id']").val("");
		$("input[name='member_card']").val("");
		$("input[name='member_name']").val("");
		$("input[name='member_address']").val("");
		$("input[name='member_id_card']").val("");
		$("input[name='member_phone']").val("");
		$("input[name='member_mail']").val("");
		$("input[name='member_wa']").val("");
		$("input[name='member_bbm']").val("");
		$("input[name='member_instagram']").val("");
		$("input[name='member_facebook']").val("");
		$("input[name='member_twitter']").val("");
	});

	$('.edit').click(function() {
		jQuery.ajax({
			type: "POST",
			url: "<?= base_url(); ?>member/form",
			dataType: 'JSON',
			data: {id: $(this).attr("id")},
			success: function(data) {
				$("input[name='member_id']").val(data[0]['member_id']);
				$("input[name='member_card']").val(data[0]['member_card']);
				$("input[name='member_name']").val(data[0]['member_name']);
				$("input[name='member_address']").val(data[0]['member_address']);
				$("input[name='member_id_card']").val(data[0]['member_id_card']);
				$("input[name='member_phone']").val(data[0]['member_phone']);
				$("input[name='member_mail']").val(data[0]['member_mail']);
				$("input[name='member_wa']").val(data[0]['member_wa']);
				$("input[name='member_bbm']").val(data[0]['member_bbm']);
				$("input[name='member_instagram']").val(data[0]['member_instagram']);
				$("input[name='member_facebook']").val(data[0]['member_facebook']);
				$("input[name='member_twitter']").val(data[0]['member_twitter']);
			}
		});
	});

	$('#save').click(function() {
		$('#basicForm').submit();
	});
</script>
