<div class="row">
    <div class="col-md-12">
        <form id="basicForm" method="POST" action="<?= base_url(); ?>user/changePassword_process" class="form-horizontal">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-btns">
                        <a href="<?= base_url(); ?>user" title="kembali">&times;</a>
                        <a href="#" class="minimize">&minus;</a>
                    </div>
                    <h4 class="panel-title"><?= $descript ?></h4>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Password Lama <span class="asterisk">*</span></label>
                        <div class="col-sm-6">
                            <input type="password" name="old_password" class="form-control" placeholder="Password Lama" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Password Baru <span class="asterisk">*</span></label>
                        <div class="col-sm-6">
                            <input type="password" name="new_password" class="form-control" placeholder="Password Baru" required />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label">Konfirmasi Password <span class="asterisk">*</span></label>
                        <div class="col-sm-6">
                            <input type="password" name="confirm_password" class="form-control" placeholder="Konfirmasi Password" required />
                        </div>
                    </div>
                </div><!-- panel-body -->
                <div class="panel-footer">
                    <div class="row">
                        <div class="col-sm-9 col-sm-offset-3">
                            <button class="btn btn-primary">Submit</button>
                            <button type="reset" class="btn btn-default">Reset</button>
                        </div>
                    </div>
                </div>
            </div><!-- panel -->
        </form>
    </div><!-- col-md-6 -->
</div><!--row -->

<script>
$("#komisi").hide();
$("#level").change(function() {
    if ($("#level").val() === '4') {
        $("#komisi").show();
    } else {
        $("#komisi").hide();
    }
});
</script>
