<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="shortcut icon" href="<?= base_url(); ?>assets/images/favicon.png" type="image/png">

        <title>Mr. BIG - JEMBER</title>

        <link href="<?= base_url(); ?>assets/css/style.default.css" rel="stylesheet" />
    </head>

    <body class="signin">
        <!-- Preloader -->
        <div id="preloader">
            <div id="status"><i class="fa fa-spinner fa-spin"></i></div>
        </div>
        <section>
            <div class="signinpanel">
                <div class="row">
                    <div class="col-md-6">
                        <div class="signin-info">
                            <div class="logopanel">
                                <h1><strong>Mr. BIG SYSTEM</strong></h1>
                            </div><!-- logopanel -->

                            <div class="mb20"></div>

                            <h5><strong>Welcome to Mr. BIG Accounting System</strong></h5>
                            <ul>
                                <li><i class="fa fa-arrow-circle-o-right mr5"></i> Access for Owner</li>
                                <li><i class="fa fa-arrow-circle-o-right mr5"></i> Access for Caseer</li>
                                <li><i class="fa fa-arrow-circle-o-right mr5"></i> Access for Warehouse</li>
                            </ul>
                        </div><!-- signin0-info -->
                    </div><!-- col-sm-7 -->

                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-1"></div>
                            <div class="col-md-11">
                                <form method="post" action="<?= site_url(); ?>login/site">
                                    <h4 class="nomargin">Sign In</h4>
                                    <p class="mt5 mb20">Login to access your account.</p>

                                    <?php
                                    if ($this->session->userdata('pesan_sistem') != "" && $this->session->userdata('pesan_sistem') != NULL) {
                                        $jenis_pesan = "";
                                        if ($this->session->userdata('tipe_pesan') == "Sukses") {
                                            $jenis_pesan = "success";
                                        } else {
                                            $jenis_pesan = "danger";
                                        }
                                        ?>
                                        <div class="alert alert-<?= $jenis_pesan; ?>">
                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                            <strong><?= $this->session->userdata('pesan_sistem'); ?></strong>
                                        </div>
                                        <?php
                                        $this->session->set_userdata('pesan_sistem', NULL);
                                        $this->session->set_userdata('tipe_pesan', NULL);
                                    }
                                    ?>

                                    <input type="text" name="username" autofocus class="form-control uname" placeholder="Username" />
                                    <input type="password" name="password" class="form-control pword" placeholder="Password" />
                                    <button class="btn btn-success btn-block">Sign In</button>
                                </form>
                            </div><!-- col-md-10 -->
                        </div><!-- row -->
                    </div><!-- col-md-6 -->
                </div><!-- row -->

                <div class="signup-footer">
                    <div class="pull-left">2014 &copy; NULL COMPUTINDO</div>
                </div>
            </div><!-- signin -->
        </section>

        <script src="<?= base_url(); ?>assets/js/jquery-1.10.2.min.js"></script>
        <script src="<?= base_url(); ?>assets/js/jquery-migrate-1.2.1.min.js"></script>
        <script src="<?= base_url(); ?>assets/js/bootstrap.min.js"></script>
        <script src="<?= base_url(); ?>assets/js/modernizr.min.js"></script>
        <script src="<?= base_url(); ?>assets/js/retina.min.js"></script>
        <script src="<?= base_url(); ?>assets/js/custom.js"></script>
    </body>
</html>
