<!DOCTYPE html>
<html lang="en">
	<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
        <meta name="description" content="Sistem Informasi Penjualan Mr. BIG">
        <meta name="author" content="null.co.id">
        <link rel="shortcut icon" href="<?= base_url(); ?>assets/images/favicon.png" type="image/png">

        <title>Mr. BIG  - JEMBER</title>

		<link href="<?= base_url(); ?>assets/css/style.default.css" rel="stylesheet">

		<script src="<?= base_url(); ?>assets/js/jquery-1.10.2.min.js"></script>
		<script src="<?= base_url(); ?>assets/js/jquery-migrate-1.2.1.min.js"></script>
		<script src="<?= base_url(); ?>assets/js/bootstrap.min.js"></script>
		<script src="<?= base_url(); ?>assets/js/modernizr.min.js"></script>
		<script src="<?= base_url(); ?>assets/js/jquery.sparkline.min.js"></script>
		<script src="<?= base_url(); ?>assets/js/jquery.cookies.js"></script>

		<script src="<?= base_url(); ?>assets/js/toggles.min.js"></script>
		<script src="<?= base_url(); ?>assets/js/retina.min.js"></script>

		<script src="<?= base_url(); ?>assets/js/custom.js"></script>
	</head>
	<body class="notfound">
<!-- 		<section> -->
<!-- 			<div class="notfoundpanel col-md-12"> -->
		<center><h1>Pilih Lokasi Anda</h1></center>
		<div class="row" style="padding: 20px">
			<?php
			if ($this->session->userdata('level') == 1) {
			?>
			<div class="col-sm-12 col-md-6">
				<div class="panel panel-info panel-stat">
					<div class="panel-heading">
						<a href="<?= base_url(); ?>login/choose_outlet/all" style="cursor: pointer; cursor: hand;">
							<div class="row">
								<div class="col-md-2 col-sm-4 hidden-xs hidden-xxs hidden-tn">
									<img src="<?= base_url(); ?>assets/images/is-document.png" alt="" />
								</div>
								<div class="col-md-10 col-sm-8" style="color: #fff">
									<h1>ALL Outlet</h1>
								</div>
							</div><!-- row -->
						</a>
					</div><!-- panel-heading -->
				</div><!-- panel -->
			</div><!-- col-sm-12 -->
			<?php
			}
			foreach ($this->session->userdata('list_outlet') AS $l) {
			?>
			<div class="col-sm-12 col-md-6">
				<div class="panel panel-success panel-stat">
					<div class="panel-heading">
						<a href="<?= base_url(); ?>login/choose_outlet/<?= $l['outlet_id']; ?>" style="cursor: pointer; cursor: hand;">
							<div class="row">
								<div class="col-md-2 col-sm-4 hidden-xs hidden-xxs hidden-tn">
									<img src="<?= base_url(); ?>assets/images/is-document.png" alt="" />
								</div>
								<div class="col-md-10 col-sm-8" style="color: #fff">
									<h1><?= $l['outlet_name']; ?></h1>
								</div>
							</div><!-- row -->
						</a>
					</div><!-- panel-heading -->
				</div><!-- panel -->
			</div><!-- col-sm-12 -->
			<?php
			}
			if ($this->session->userdata('level') == 1 || $this->session->userdata('level') == 3) {
			?>
			<div class="col-sm-12 col-md-6">
				<div class="panel panel-warning panel-stat">
					<div class="panel-heading">
						<a href="<?= base_url(); ?>login/choose_outlet/storage" style="cursor: pointer; cursor: hand;">
							<div class="row">
								<div class="col-md-2 col-sm-4 hidden-xs hidden-xxs hidden-tn">
									<img src="<?= base_url(); ?>assets/images/is-document.png" alt="" />
								</div>
								<div class="col-md-10 col-sm-8" style="color: #fff">
									<h1>Storage</h1>
								</div>
							</div><!-- row -->
						</a>
					</div><!-- panel-heading -->
				</div><!-- panel -->
			</div><!-- col-sm-12 -->
			<?php
			}
			?>
			<div class="col-sm-12 col-md-6">
				<div class="panel panel-danger panel-stat">
					<div class="panel-heading">
						<a href="<?= base_url(); ?>login/logout" style="cursor: pointer; cursor: hand;">
							<div class="row">
								<div class="col-md-2 col-sm-4 hidden-xs hidden-xxs hidden-tn">
									<img src="<?= base_url(); ?>assets/images/is-document.png" alt="" />
								</div>
								<div class="col-md-10 col-sm-8" style="color: #fff">
									<h1>Logout</h1>
								</div>
							</div><!-- row -->
						</a>
					</div><!-- panel-heading -->
				</div><!-- panel -->
			</div><!-- col-sm-12 -->
		</div><!-- row -->
<!-- 			</div><!~~ notfoundpanel ~~> -->
<!-- 		</section> -->

		<script>
			jQuery(document).ready(function(){
				"use strict";

			});
		</script>
	</body>
</html>
