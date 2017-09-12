<a class="menutoggle"><i class="fa fa-bars"></i></a>
<div class="header-left">
    <ul class="headermenu">
        <li style="margin-top: 3px;">
			<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
<!-- 				<strong class="visible-lg visible-md visible-sm visible-xs">Page : <?= $descript; ?></strong> -->
				<strong class="hidden-xxs hidden-tn">Page : <?= $descript; ?></strong>
			</button>
    	</li>
    </ul>
</div><!-- header-right -->
<div class="header-right">
    <ul class="headermenu">
    	<?php
    	if ($back_button != false) {
    	?>
    	<li style="margin-top: 3px;">
			<button type="button" class="btn btn-default dropdown-toggle" id="kembali" data-toggle="dropdown">
				<i class="fa fa-arrow-left"></i> Kembali
			</button>
    	</li>
    	<?php
    	}
    	if ($add_button != false) {
    	?>
    	<li style="margin-top: 3px;">
			<button type="button" class="btn btn-default dropdown-toggle" id="tambah" data-toggle="dropdown">
				<a href="#myModal" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i> Tambah</a>
			</button>
    	</li>
    	<?php
    	}
    	?>
        <li>
            <div class="btn-group">
                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                    <img src="<?= base_url(); ?>assets/images/photos/loggeduser.png" alt="" />
                    <span class="hidden-xxs hidden-tn"><?= $this->session->userdata('user_name'); ?></span>
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu dropdown-menu-usermenu pull-right">
                	<?php
					if ($this->session->userdata('level') == 1 && $this->session->userdata('outlet_id') != "all") {
					?>
					<li><a href="<?= base_url(); ?>login/choose_outlet2/all"><i class="glyphicon glyphicon-shopping-cart"></i> Change to ALL Outlet</a></li>
					<?php
					}
					foreach ($this->session->userdata('list_outlet') AS $l) {
						if ($this->session->userdata('outlet_id') != $l['outlet_id']) {
						?>
						<li><a href="<?= base_url(); ?>login/choose_outlet2/<?= $l['outlet_id']; ?>"><i class="glyphicon glyphicon-shopping-cart"></i> Change to <?= $l['outlet_name']; ?></a></li>
						<?php
						}
					}
					?>
                	<?php
					if ($this->session->userdata('level') == 1 && $this->session->userdata('outlet_id') != "storage") {
					?>
					<hr />
                	<li><a href="<?= base_url(); ?>login/choose_outlet2/storage"><i class="glyphicon glyphicon-shopping-cart"></i> Change to Storage</a></li>
                	<?php
					}
					?>
					<hr />
                    <li><a href="<?= base_url(); ?>user/changePassword"><i class="glyphicon glyphicon-lock"></i> Change Password</a></li>
                    <li><a href="<?= base_url(); ?>login/logout"><i class="glyphicon glyphicon-log-out"></i> Log Out</a></li>
                </ul>
            </div>
        </li>
    </ul>
</div><!-- header-right -->
