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
                        <th>Nama Kategori</th>
                        <th>Jumlah Menu</th>
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
							<td><?= $t['category_name']; ?></td>
                            <td><b><?= $t['menu_count']; ?></b> Jenis</td>
                            <td>
                                <?php
								if ($this->session->userdata('outlet_id') != 'all') {
								?>
								<a href="#myModal" data-toggle="modal" data-target="#myModal" class="edit" id="<?= $t['category_id']; ?>"><i class="fa fa-pencil"></i> Ubah</a> |
                                <?php
								}
								?>
                                <a href="<?= base_url(); ?>category/delete/<?= $t['category_id']; ?>" onclick="return confirm('Apakah anda yakin menghapus data penting ini?');"><i class="fa fa-trash-o"></i> Hapus</a>
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
					<form id="basicForm" method="POST" action="<?= base_url(); ?>category/process" class="form-horizontal">
						<input type="hidden" name="category_id" value="" />
						<div class="form-group">
							<label class="col-sm-4 control-label">Nama Kategori <span class="asterisk">*</span></label>
							<div class="col-sm-8">
								<input type="text" name="category_name" class="form-control" placeholder="Nama Kategori" required value="" />
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
		$("input[name='category_id']").val("");
		$("input[name='category_name']").val("");
	});

	$('.edit').click(function() {
		jQuery.ajax({
			type: "POST",
			url: "<?= base_url(); ?>category/form",
			dataType: 'JSON',
			data: {id: $(this).attr("id")},
			success: function(data) {
				$("input[name='category_id']").val(data[0]['category_id']);
				$("input[name='category_name']").val(data[0]['category_name']);
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
