<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-body">
            	<div class="row">
                <?php
                if ($this->session->userdata('level') == 1) {
                    ?>
					<div class="col-sm-12 col-md-6">
						<div class="panel panel-danger panel-stat">
							<div class="panel-heading">
								<!--<div class="stat">-->
									<div class="row">
										<div class="col-md-2 col-sm-4 hidden-xs hidden-xxs hidden-tn">
											<img src="<?= base_url(); ?>assets/images/is-document.png" alt="" />
										</div>
										<div class="col-md-10 col-sm-8" style="color: #fff">
											<small class="stat-label">Penjualan Bulan Ini</small>
											<h1>Rp <?= number_format($jual, 0, ',', '.'); ?></h1>
										</div>
									</div><!-- row -->
								<!--</div>-->
							<!-- stat -->
							</div><!-- panel-heading -->
						</div><!-- panel -->
					</div><!-- col-sm-12 -->

					<div class="col-sm-12 col-md-6">
						<div class="panel panel-success panel-stat">
							<div class="panel-heading">
								<div class="stat">
									<div class="row">
										<div class="col-md-3 col-sm-4 hidden-xs hidden-xxs hidden-tn">
											<img src="<?= base_url(); ?>assets/images/is-user.png" alt="" />
										</div>
										<div class="col-sm-8">
											<small class="stat-label">Transaksi Bulan Ini</small>
											<h1><?= $transaksi; ?></h1>
										</div>
									</div><!-- row -->
								</div><!-- stat -->
							</div><!-- panel-heading -->
						</div><!-- panel -->
					</div><!-- col-sm-12 -->
                    <?php
                } else if ($this->session->userdata('level') == 2) {
                    ?>
					<div class="col-sm-12 col-md-6">
						<div class="panel panel-warning panel-stat">
							<div class="panel-heading">
								<!--<div class="stat">-->
									<div class="row">
										<div class="col-md-2 col-sm-4 hidden-xs hidden-xxs hidden-tn">
											<img src="<?= base_url(); ?>assets/images/is-document.png" alt="" />
										</div>
										<div class="col-md-10 col-sm-8" style="color: #fff">
											<small class="stat-label">Total Penjualan KU Hari ini</small>
											<h1>Rp <?= number_format($jual, 0, ',', '.'); ?></h1>
										</div>
									</div><!-- row -->
								<!--</div>-->
							<!-- stat -->
							</div><!-- panel-heading -->
						</div><!-- panel -->
					</div><!-- col-sm-12 -->
					<div class="col-sm-12 col-md-6">
						<div class="panel panel-primary panel-stat">
							<div class="panel-heading">
								<!--<div class="stat">-->
									<div class="row">
										<div class="col-md-2 col-sm-4 hidden-xs hidden-xxs hidden-tn">
											<img src="<?= base_url(); ?>assets/images/is-document.png" alt="" />
										</div>
										<div class="col-md-10 col-sm-8" style="color: #fff">
											<small class="stat-label">Total Penjualan Outlet Hari ini</small>
											<h1>Rp <?= number_format($outlet, 0, ',', '.'); ?></h1>
										</div>
									</div><!-- row -->
								<!--</div>-->
							<!-- stat -->
							</div><!-- panel-heading -->
						</div><!-- panel -->
					</div><!-- col-sm-12 -->
					<div class="col-sm-12 col-md-6">
						<div class="panel panel-info panel-stat">
							<div class="panel-heading">
								<!--<div class="stat">-->
									<div class="row">
										<div class="col-md-2 col-sm-4 hidden-xs hidden-xxs hidden-tn">
											<img src="<?= base_url(); ?>assets/images/is-document.png" alt="" />
										</div>
										<div class="col-md-10 col-sm-8" style="color: #fff">
											<small class="stat-label">Total Komisi KU Bulan ini</small>
											<h1>Rp <?= number_format($komisi, 0, ',', '.'); ?></h1>
										</div>
									</div><!-- row -->
								<!--</div>-->
							<!-- stat -->
							</div><!-- panel-heading -->
						</div><!-- panel -->
					</div><!-- col-sm-12 -->
                    <?php
                }
				$total_bagihasil = 0;
				if ($this->session->userdata('level') == 1 || $this->session->userdata('level') == 4) {
					$bh = 0;
					$color = 0;
					$color_list = array('primary', 'warning', 'danger', 'success', 'info', 'dark');
					foreach ($bagihasil as $b) {
						if ($color % 5 == 0) {
							$color = 0;
						}
						$bh = $jual * $b['user_procentase'] / 100;
						$total_bagihasil += $bh;
						?>
						<div class="col-sm-12 col-md-6">
							<div class="panel panel-<?= $color_list[$color] ?> panel-stat">
								<div class="panel-heading">
									<!--<div class="stat">-->
										<div class="row">
											<div class="col-md-2 col-sm-4 hidden-xs hidden-xxs hidden-tn">
												<img src="<?= base_url(); ?>assets/images/is-document.png" alt="" />
											</div>
											<div class="col-md-10 col-sm-8" style="color: #fff">
												<small class="stat-label">Pendapatan <?= $b['user_name'] ?> Bulan Ini</small>
												<h1>Rp <?= number_format($bh, 0, ',', '.'); ?></h1>
											</div>
										</div><!-- row -->
									<!--</div>-->
								<!-- stat -->
								</div><!-- panel-heading -->
							</div><!-- panel -->
						</div><!-- col-sm-12 -->
						<?php
						$color++;
					}
				}
				if ($this->session->userdata('level') == 1) {
					?>
					<div class="col-sm-12 col-md-6">
						<div class="panel panel-dark panel-stat">
							<div class="panel-heading">
								<!--<div class="stat">-->
									<div class="row">
										<div class="col-md-2 col-sm-4 hidden-xs hidden-xxs hidden-tn">
											<img src="<?= base_url(); ?>assets/images/is-document.png" alt="" />
										</div>
										<div class="col-md-10 col-sm-8" style="color: #fff">
											<small class="stat-label">Pendapatan Bulan Ini</small>
											<h1>Rp <?= number_format($jual - $total_bagihasil, 0, ',', '.'); ?></h1>
										</div>
									</div><!-- row -->
								<!--</div>-->
							<!-- stat -->
							</div><!-- panel-heading -->
						</div><!-- panel -->
					</div><!-- col-sm-12 -->
					<?php
				}
				?>
			</div> <!-- row -->
		</div><!-- panel -->
    </div><!-- col-sm-12 -->
</div><!-- row -->
