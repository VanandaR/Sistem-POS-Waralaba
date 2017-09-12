<head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <base href="http://localhost/ospos3/public/">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <meta name="description" content="Sistem Informasi Penjualan Mr. BIG">
    <meta name="author" content="null.co.id">
    <link rel="shortcut icon" href="<?= base_url(); ?>assets/images/favicon.png" type="image/png">

    <title>Mr. BIG  - JEMBER</title>
    <link rel="stylesheet" type="text/css" href="dist/bootswatch/flatly/bootstrap.min.css">

    <!--[if lte IE 8]>
    <link rel="stylesheet" media="print" href="dist/print.css" type="text/css" />
    <![endif]-->
    <!-- start mincss template tags -->
    <link rel="stylesheet" type="text/css" href="dist/jquery-ui.css">
    <link rel="stylesheet" type="text/css" href="dist/opensourcepos.min.css?rel=d5b9522f2f">
    <link rel="stylesheet" type="text/css" href="dist/style.css">
    <!-- end mincss template tags -->
    <!-- start minjs template tags -->
    <script type="text/javascript" src="dist/opensourcepos.min.js?rel=bc5842b19a"></script>
    <!-- end minjs template tags -->

<!--    <script type="text/javascript">-->
<!--        // live clock-->
<!--        var clock_tick = function clock_tick() {-->
<!--            setInterval('update_clock();', 1000);-->
<!--        }-->
<!---->
<!--        // start the clock immediatly-->
<!--        clock_tick();-->
<!---->
<!--        var update_clock = function update_clock() {-->
<!--            document.getElementById('liveclock').innerHTML = moment().format("MM/DD/YYYY HH:mm:ss");-->
<!--        }-->
<!---->
<!--        $.notifyDefaults({ placement: {-->
<!--            align: 'center',-->
<!--            from: 'bottom'-->
<!--        }});-->
<!---->
<!--        var post = $.post;-->
<!---->
<!--        var csrf_token = function() {-->
<!--            return Cookies.get('csrf_cookie_ospos_v3');-->
<!--        };-->
<!---->
<!--        var csrf_form_base = function() {-->
<!--            return { csrf_ospos_v3 : function () { return csrf_token();  } };-->
<!--        };-->
<!---->
<!--        $.post = function() {-->
<!--            arguments[1] = $.extend(arguments[1], csrf_form_base());-->
<!--            post.apply(this, arguments);-->
<!--        };-->
<!---->
<!--        var setup_csrf_token = function() {-->
<!--            $('input[name="csrf_ospos_v3"]').val(csrf_token());-->
<!--        };-->
<!---->
<!--        setup_csrf_token();-->
<!---->
<!--        $.ajaxSetup({-->
<!--            dataFilter: function(data) {-->
<!--                setup_csrf_token();-->
<!--                return data;-->
<!--            }-->
<!--        });-->
<!---->
<!--        var submit = $.fn.submit;-->
<!---->
<!--        $.fn.submit = function() {-->
<!--            setup_csrf_token();-->
<!--            submit.apply(this, arguments);-->
<!--        };-->
<!---->
<!--        session_sha1 = '4f5ad57';-->
<!---->
<!--    </script>-->
<!--    <script type="text/javascript">-->
<!--        (function(lang, $) {-->
<!---->
<!--            var lines = {-->
<!--                'common_submit' : "Kirim",-->
<!--                'common_close' : "Close"-->
<!--            };-->
<!---->
<!--            $.extend(lang, {-->
<!--                line: function(key) {-->
<!--                    return lines[key];-->
<!--                }-->
<!--            });-->
<!---->
<!---->
<!--        })(window.lang = window.lang || {}, jQuery);-->
<!--    </script>-->
<!--    <style type="text/css">-->
<!--        html {-->
<!--            overflow: auto;-->
<!--        }-->
<!--    </style>-->
</head>
<script type="text/javascript">
    function printdoc()
    {
        // receipt layout sanity check
        if ( $("#receipt_items, #items, #table_holder").length > 0)
        {
            // install firefox addon in order to use this plugin
            if (window.jsPrintSetup)
            {
                // set top margins in millimeters
                jsPrintSetup.setOption('marginTop', '<?php echo $this->config->item('print_top_margin'); ?>');
                jsPrintSetup.setOption('marginLeft', '<?php echo $this->config->item('print_left_margin'); ?>');
                jsPrintSetup.setOption('marginBottom', '<?php echo $this->config->item('print_bottom_margin'); ?>');
                jsPrintSetup.setOption('marginRight', '<?php echo $this->config->item('print_right_margin'); ?>');

                <?php if (!$this->config->item('print_header'))
                {
                ?>
                // set page header
                jsPrintSetup.setOption('headerStrLeft', '');
                jsPrintSetup.setOption('headerStrCenter', '');
                jsPrintSetup.setOption('headerStrRight', '');
                <?php
                }
                if (!$this->config->item('print_footer'))
                {
                ?>
                // set empty page footer
                jsPrintSetup.setOption('footerStrLeft', '');
                jsPrintSetup.setOption('footerStrCenter', '');
                jsPrintSetup.setOption('footerStrRight', '');
                <?php
                }
                ?>

                var printers = jsPrintSetup.getPrintersList().split(',');
                // get right printer here..
                for(var index in printers) {
                    var default_ticket_printer = window.localStorage && localStorage['<?php echo $selected_printer; ?>'];
                    var selected_printer = printers[index];
                    if (selected_printer == default_ticket_printer) {
                        // select epson label printer
                        jsPrintSetup.setPrinter(selected_printer);
                        // clears user preferences always silent print value
                        // to enable using 'printSilent' option
                        jsPrintSetup.clearSilentPrint();
                        <?php if (!$this->config->item('print_silently'))
                        {
                        ?>
                        // Suppress print dialog (for this context only)
                        jsPrintSetup.setOption('printSilent', 1);
                        <?php
                        }
                        ?>
                        // Do Print
                        // When print is submitted it is executed asynchronous and
                        // script flow continues after print independently of completetion of print process!
                        jsPrintSetup.print();
                    }
                }
            }
            else
            {
                window.print();
            }
        }
    }

    <?php
    if($print_after_sale)
    {
    ?>
    $(window).load(function()
    {
        // executes when complete page is fully loaded, including all frames, objects and images
        printdoc();
    });
    <?php
    }
    ?>
</script>
<div class="container" style="margin-top:25px">
    <div class="row">



        <script type="text/javascript">
            function printdoc()
            {
                // receipt layout sanity check
                if ( $("#receipt_items, #items, #table_holder").length > 0)
                {
                    // install firefox addon in order to use this plugin
                    if (window.jsPrintSetup)
                    {
                        // set top margins in millimeters
                        jsPrintSetup.setOption('marginTop', '0');
                        jsPrintSetup.setOption('marginLeft', '0');
                        jsPrintSetup.setOption('marginBottom', '0');
                        jsPrintSetup.setOption('marginRight', '0');

                        // set page header
                        jsPrintSetup.setOption('headerStrLeft', '');
                        jsPrintSetup.setOption('headerStrCenter', '');
                        jsPrintSetup.setOption('headerStrRight', '');
                        // set empty page footer
                        jsPrintSetup.setOption('footerStrLeft', '');
                        jsPrintSetup.setOption('footerStrCenter', '');
                        jsPrintSetup.setOption('footerStrRight', '');

                        var printers = jsPrintSetup.getPrintersList().split(',');
                        // get right printer here..
                        for(var index in printers) {
                            var default_ticket_printer = window.localStorage && localStorage['receipt_printer'];
                            var selected_printer = printers[index];
                            if (selected_printer == default_ticket_printer) {
                                // select epson label printer
                                jsPrintSetup.setPrinter(selected_printer);
                                // clears user preferences always silent print value
                                // to enable using 'printSilent' option
                                jsPrintSetup.clearSilentPrint();
                                // Do Print
                                // When print is submitted it is executed asynchronous and
                                // script flow continues after print independently of completetion of print process!
                                jsPrintSetup.print();
                            }
                        }
                    }
                    else
                    {
                        window.print();
                    }
                }
            }

        </script>
        <div class="print_hide" id="control_buttons" style="text-align:right">
            <a href="javascript:printdoc();"><div class="btn btn-info btn-sm" id="show_print_button"><span class="glyphicon glyphicon-print">&nbsp;</span>Print</div></a>
            <a href="<?= base_url();?>inmaterial" class="btn btn-info btn-sm" id="show_sales_button"><span class="glyphicon glyphicon-save">&nbsp;</span>Penerimaan Barang Masuk</a></div>

        <div id="receipt_wrapper">
            <div id="receipt_header">
                <div id="company_name">Mr. BIG Jember</div>
                <div id="company_address">Kalimantan X</div>
                <div id="company_phone">555-555-5555</div>
                <div id="sale_receipt">Faktur Penerimaan</div>
                <div id="sale_time"></div>
            </div>

            <div id="receipt_general_info">
                <div id="sale_id">ID Penerimaan: RECV 4</div>
                <div id="employee">Karyawan: <?= $this->session->userdata('user_name'); ?></div>
            </div>

            <table id="receipt_items">
                <tbody><tr>
                    <th style="width:40%;">Item</th>
                    <th style="width:20%;">Jumlah</th>
                    <th style="width:20%;">Harga</th>
                </tr>
                <?php
                $i = 0;
                foreach ($inmaterial as $t):
                ?>
                <tr>
                    <td><?= $t['material_name']; ?></td>
                    <td><?= $t['amount']; ?></td>
                </tr>
                <?php endforeach;?>
                <tr>
                    <td></td>
                </tr>

                <tr>
                    <td colspan="3" style="text-align:right;border-top:2px solid #000000;">Total</td>
                    <td style="border-top:2px solid #000000;"><div class="total-value">$5,000.00</div></td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align:right;">Type Pembayaran</td>
                    <td><div class="total-value">Tunai</div></td>
                </tr>

                </tbody></table>

            <div id="sale_return_policy">
                Test	</div>

            <div id="barcode">
                <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAMgAAAAeAQMAAABT8cPvAAAABlBMVEX///8AAABVwtN+AAAAIklEQVQokWNgAIMMn1gpJfOImzOtxZPXMSCDUZlRmREiAwAgroy/2fthBAAAAABJRU5ErkJggg=="><br>
                RECV 4	</div>
        </div>

    </div>
</div>