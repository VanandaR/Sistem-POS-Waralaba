<div class="panel panel-default">
    <div class="row">
        <div class="col-md-6">
            <form id="basicForm" method="POST" action="<?= base_url(); ?>inmaterial/process" class="form-horizontal">
                <input type="hidden" name="inmaterial_id" value="<?= $this->session->userdata('inmaterial_id'); ?>" />
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Bahan Baku <span class="asterisk">*</span></label>
                        <div class="col-sm-9">
                            <select class="form-control chosen-select" name="material_id" id="material_id" data-placeholder="Pilih Bahan Baku" required>
                                <option value=""></option>
                                <?php
                                foreach ($material as $s):
                                    ?>
                                    <option value="<?= $s['material_id'] . ";" . $s['units']; ?>" <?= (($isi != NULL) ? (($isi[0]['material_id'] == $s['material_id']) ? "selected" : "") : "") ?>><?= $s['material_name'] . ' [' . $s['units'] . ']'; ?></option>
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
								<input type="number" min="0" name="amount" class="form-control" placeholder="Jumlah Bahan Baku yang Masuk" id="amount" required value="<?= (($isi != NULL) ? $isi[0]['amount'] : "") ?>" />
								<span class="input-group-addon" id="unit_label"></span>
							</div>
                        </div>
                    </div>
                </div><!-- panel-body -->
                <div class="panel-footer">
                    <div class="row">
                        <div class="col-sm-9 col-sm-offset-3">
                            <button class="btn btn-primary">Add to List</button>
                            <a href="<?= base_url(); ?>inmaterial" type="button" class="btn btn-default">Reset</a>
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
                            <th>Nama Bahan Baku</th>
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
                                    <a href="<?= base_url(); ?>inmaterial/index/<?= $t['tmp_inmaterial']; ?>"><i class="fa fa-pencil"></i> Ubah</a> |
                                    <a href="<?= base_url(); ?>inmaterial/process/<?= $t['tmp_inmaterial']; ?>" onclick="return confirm('Apakah anda yakin menghapus data penting ini?');"><i class="fa fa-trash-o"></i> Hapus</a>
                                </td>
                            </tr>
                            <?php
                        endforeach;
                        ?>
                    </tbody>
                </table>
                <a href="<?= base_url(); ?>inmaterial/save" class="btn btn-primary pull-right" style="margin-right: 10px">Save</a>
            </div><!-- table-responsive -->
        </div><!-- col-md-6 -->
    </div><!--row -->
</div><!-- panel -->

<script>
    // Select your input element.
    var number = document.getElementById('amount');

    // Listen for input event on numInput.
    number.onkeydown = function(e) {
        if(!((e.keyCode > 95 && e.keyCode < 106)
            || (e.keyCode > 47 && e.keyCode < 58)
            || e.keyCode == 8)) {
            return false;
        }
    }
	$("#material_id").change(function() {
		data = $("#material_id").val().split(';');
		$("#unit_label").html(data[1]);
	});
</script>