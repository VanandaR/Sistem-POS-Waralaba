<div class="panel panel-default">
    <div class="row">
        <form id="basicForm" method="POST" action="<?= base_url(); ?>sales/save" class="form-horizontal">
            <input type="hidden" name="total_items" id="total_items" value="0" />
            <input type="hidden" name="member" id="member" value="">
            <div class="panel-body" style="margin-top: -15px">

                <!-- 				<ul class="nav nav-tabs nav-justified"> -->
                <ul class="nav nav-tabs">
                    <?php
                    $l = 0;
                    foreach ($category as $c):
                        ?>
                        <li class="<?= ($l == 0) ? 'active' : ''; ?>"><a href="#c<?= $l; ?>" data-toggle="tab"><strong><?= $c['category_name']; ?></strong></a></li>
                        <?php
                        $l++;
                    endforeach;
                    ?>
                    <li class="pull-right"><a href="#myModal" data-toggle="modal" data-target="#myModal" id="bayar"><strong style="color: blue">Bayar</strong></a></li>
                    <!-- 					<li><button type="button" class="btn btn-info pull-right" data-toggle="modal" data-target="#myModal" id="bayar">Bayar</button></li> -->
                </ul>

                <div class="tab-content">
                    <?php
                    $l = 0;
                    $i = -1;
                    foreach ($category as $c):
                        ?>
                        <div class="tab-pane <?= ($l == 0) ? 'active' : ''; ?>" id="c<?= $l; ?>">
                            <?php
                            foreach ($food_menu as $s):
                                if ($c['category_id'] == $s['category_id']) {
                                    ++$i;
                                    ?>
                                    <div class="col-md-4 col-sm-6 col-xs-6 col-xxs-12 col-tn-12">
                                        <h4><?= $s['food_menu_name']; ?></h4>
                                        <div class="input-group">
										<span class="input-group-btn">
											<button type="button" class="btn btn-lg btn-danger btn-number"  data-type="minus" data-field="food[<?= $i; ?>][3]">
												<span class="glyphicon glyphicon-minus"></span>
											</button>
										</span>
                                            <input type="hidden" name="food[<?= $i; ?>][0]" class="form-control" value="<?= $s['food_menu_id']; ?>">
                                            <input type="hidden" name="food[<?= $i; ?>][1]" class="form-control" value="<?= $s['food_menu_price']; ?>">
                                            <input type="hidden" name="food[<?= $i; ?>][2]" class="form-control" value="<?= $s['food_menu_commision']; ?>">
                                            <input type="number" name="food[<?= $i; ?>][3]" class="form-control input-lg input-number" value="0" min="0" max="1000" data-price="<?= $s['food_menu_price']; ?>" style="text-align: center">
                                            <input type="hidden" name="food[<?= $i; ?>][4]" class="form-control" value="<?= $s['food_menu_name']; ?>">
                                            <span class="input-group-btn">
											<button type="button" class="btn btn-lg btn-success btn-number" data-type="plus" data-field="food[<?= $i; ?>][3]">
												<span class="glyphicon glyphicon-plus"></span>
											</button>
										</span>
                                        </div>
                                    </div>
                                    <?php
                                }
                            endforeach;
                            ?>
                        </div>
                        <?php
                        $l++;
                    endforeach;
                    ?>
                </div>
            </div>
        </form>
    </div><!--row -->
</div><!-- panel -->

<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <!--            <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Modal Header</h4>
                        </div>-->
            <div class="modal-body">
                <center>
                    <h4>Total Belanja</h4>
                    <h3 id="total_belanja" style="color: red; margin-top: -10px; margin-bottom: -10px"></h3>
                    <h4>Uang yang dibayar : </h4>
                    <input type="text" id="dibayar" disabled class="input-lg" style="color: blue; margin-top: -5px; margin-bottom: 0px" />
                    <h4>Uang kembali : </h4>
                    <h3 id="uang_kembali" style="color: red; margin-top: -10px;">Uang pembayaran kurang!</h3>
                </center>
                <div class="row">
                    <div class="col-md-3 col-sm-2 col-xs-1"></div>
                    <div class="col-md-6 col-sm-8 col-xs-10">
                        <button type="button" class="btn btn-lg btn-number btn-default col-md-4 col-sm-4 col-xs-4" onclick="tombol(1)">1</button>
                        <button type="button" class="btn btn-lg btn-number btn-default col-md-4 col-sm-4 col-xs-4" onclick="tombol(2)">2</button>
                        <button type="button" class="btn btn-lg btn-number btn-default col-md-4 col-sm-4 col-xs-4" onclick="tombol(3)">3</button>

                        <button type="button" class="btn btn-lg btn-number btn-default col-md-4 col-sm-4 col-xs-4" onclick="tombol(4)">4</button>
                        <button type="button" class="btn btn-lg btn-number btn-default col-md-4 col-sm-4 col-xs-4" onclick="tombol(5)">5</button>
                        <button type="button" class="btn btn-lg btn-number btn-default col-md-4 col-sm-4 col-xs-4" onclick="tombol(6)">6</button>

                        <button type="button" class="btn btn-lg btn-number btn-default col-md-4 col-sm-4 col-xs-4" onclick="tombol(7)">7</button>
                        <button type="button" class="btn btn-lg btn-number btn-default col-md-4 col-sm-4 col-xs-4" onclick="tombol(8)">8</button>
                        <button type="button" class="btn btn-lg btn-number btn-default col-md-4 col-sm-4 col-xs-4" onclick="tombol(9)">9</button>

                        <button type="button" class="btn btn-lg btn-number btn-default col-md-4 col-sm-4 col-xs-4" onclick="tombol(0)">0</button>
                        <button type="button" class="btn btn-lg btn-number btn-danger col-md-4 col-sm-4 col-xs-4" id="tombolbackspace"><i class="fa fa-arrow-left" aria-hidden="true"></i></button>
                        <button type="button" class="btn btn-lg btn-number btn-danger col-md-4 col-sm-4 col-xs-4" id="tombolreset">C</button>
                    </div>
                    <div class="col-md-3 col-sm-2 col-xs-1"></div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-sm-8 col-xs-10 col-md-offset-3 col-sm-offset-2 col-xs-offset-1">
                        <center><h4>Nomor member : </h4></center>
                        <select class="form-control chosen-select" name="memberbayar" id="memberbayar" data-placeholder="Masukkan Nomor Member" required>
                            <option value=""></option>
                            <?php
                            foreach ($member as $s):
                                ?>
                                <option value="<?= $s['member_id']?>"><?= $s['member_card']; ?></option>
                                <?php
                            endforeach;
                            ?>
                        </select>
                    </div>
                </div>
                <center><h4>Diskon : </h4></center>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Close</button>
                <button type="button" id="save" class="btn btn-success" data-dismiss="modal">Bayar</button>
            </div>
        </div>
    </div>
</div>

<script>
    $('.btn-number').click(function (e) {
        e.preventDefault();

        fieldName = $(this).attr('data-field');
        type = $(this).attr('data-type');
        var input = $("input[name='" + fieldName + "']");
        var currentVal = parseInt(input.val());
        if (!isNaN(currentVal)) {
            if (type === 'minus') {
                if (currentVal > input.attr('min')) {
                    input.val(currentVal - 1).change();
                }
                if (parseInt(input.val()) === input.attr('min')) {
                    $(this).attr('disabled', true);
                }
                $("#total_items").val((parseInt($("#total_items").val()) > 0 ? (parseInt($("#total_items").val()) - 1) : 0));
            } else if (type === 'plus') {
                if (currentVal < input.attr('max')) {
                    input.val(currentVal + 1).change();
                }
                if (parseInt(input.val()) === input.attr('max')) {
                    $(this).attr('disabled', true);
                }
                $("#total_items").val((parseInt($("#total_items").val()) >= 0 ? (parseInt($("#total_items").val()) + 1) : 0));
            }
        } else {
            input.val(0);
        }
    });
    $('.input-number').focusin(function () {
        $(this).data('oldValue', $(this).val());
    });

    $('.input-number').change(function () {
        minValue = parseInt($(this).attr('min'));
        maxValue = parseInt($(this).attr('max'));
        valueCurrent = parseInt($(this).val());

        name = $(this).attr('name');
        if (valueCurrent >= minValue) {
            $(".btn-number[data-type='minus'][data-field='" + name + "']").removeAttr('disabled')
        } else {
            alert('Sorry, the minimum value was reached');
            $(this).val($(this).data('oldValue'));
        }
        if (valueCurrent <= maxValue) {
            $(".btn-number[data-type='plus'][data-field='" + name + "']").removeAttr('disabled')
        } else {
            alert('Sorry, the maximum value was reached');
            $(this).val($(this).data('oldValue'));
        }
    });
    $(".input-number").keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
            // Allow: Ctrl+A
            (e.keyCode == 65 && e.ctrlKey === true) ||
            // Allow: home, end, left, right
            (e.keyCode >= 35 && e.keyCode <= 39)) {
            // let it happen, don't do anything
            return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });
    $('#memberbayar').change(function () {
        memberid=$('#memberbayar').val();
        $('#member').val(memberid);
    });
    $('#bayar').click(function (e) {
        total = 0;
        var inp = [];
        var id = [];
        var yo=[];
        for (var i = 0, max = <?= $i+1; ?>; i < max; i++) {
            if ($("input[name='food[" + i + "][3]']").val() != '0') {
                inp[i] = $("input[name='food[" + i + "][3]']").val();
                yo[i] = $("input[name='food[" + i + "][3]']");
                id[i] = $("input[name='food[" + i + "][0]']").val();
                jml = parseInt(inp[i]);
                if (jml > 0) {
                    total += (jml * parseInt(yo[i].attr('data-price')));
                }
            }
        }



//        discount=0.1;
//        jQuery.ajax({
//            type: "POST",
//            url: "<?//= base_url(); ?>//sales/discount",
//            dataType: 'JSON',
//            data: {inp: inp, id: id},
//            success: function(data) {
//                if(data[0]['discount_type']==1){
//                    $("#total_belanja").html("Rp. " + total);
//
//                }else if(data[0]['discount_type']==2){
//                    discount=data[0]['discount_percent']/100;
//                    total=total-(total*discount);
//                    $("#total_belanja").html("Rp. " + total);
//
//                }else{
//                    discount=data[0]['discount_nominal'];
//                    total=total-(discount);
//                    $("#total_belanja").html("Rp. " + total);
//                }
//            }
//        });
        $("#total_belanja").html("Rp. " + total);





    });

    function tombol(i) {
        dibayar = $("#dibayar").val();
        dibayar += i;
        $("#dibayar").val(dibayar);
        uang_kembali();
    }


    $("#tombolbackspace").click(function() {
        dibayar = "";
        dibayar_new = $("#dibayar").val().split("");
        for (var i = 0, max = dibayar_new.length - 1; i < max; i++) {
            dibayar += dibayar_new[i];
        }
        $("#dibayar").val(dibayar);
        uang_kembali();
    });
    $("#tombolreset").click(function() {
        dibayar = "";
        $("#dibayar").val(dibayar);
        uang_kembali();
    });

    function uang_kembali() {
        dibayar = ($("#dibayar").val() !== '') ? parseInt($("#dibayar").val()) : 0;
        tb = $("#total_belanja").html().split(" ");
        total_belanja = parseInt(tb[1]);

        if (dibayar - total_belanja >= 0) {
            $("#uang_kembali").html(dibayar - total_belanja);
        } else {
            $("#uang_kembali").html("Uang pembayaran kurang!");
        }
    }

    $("#save").click(function() {
        $("#basicForm").submit();
    });
</script>
