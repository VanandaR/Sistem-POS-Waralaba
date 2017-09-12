<div class="panel panel-default">
    <div class="panel-body">
        <div class="row">
            <form method="POST" action="<?= base_url(); ?>report/sales_produk" id="date">

                <!--                <div class="col-md-4 col-sm-12">-->
                <!--                    <div class="input-group" style="width: 100%">-->
                <!--                        <select class="form-control chosen-select" style="height: 35px" name="who" data-placeholder="Pilih Petugas" onchange="$('#date').submit()">-->
                <!--                            <option value="0">Semua Petugas</option>-->
                <!--                            --><?php
                //                            foreach ($employee as $e) {
                //                                echo '<option value="' . $e['user_id'] . '" ' . (($who == $e['user_id']) ? "selected" : "") . '>' . $e['user_name'] . '</option>';
                //                            }
                //                            ?>
                <!--                        </select>-->
                <!--                    </div>-->
                <!--                </div>-->
                <!--                <div class="col-md-4 col-sm-12">-->
                <!--                    <div class="input-group" style="width: 100%">-->
                <!--                        <select class="form-control chosen-select" style="height: 35px" name="member" data-placeholder="Pilih Petugas" onchange="$('#date').submit()">-->
                <!--                            <option value="0">Semua Member</option>-->
                <!--                            --><?php
                //                            foreach ($member as $m) {
                //                                echo '<option value="' . $m['member_id'] . '" ' . (($memberterpilih == $m['member_id']) ? "selected" : "") . '>' .$m['member_card'].' - '. $m['member_name'] . '</option>';
                //                            }
                //                            ?>
                <!--                        </select>-->
                <!--                    </div>-->
                <!--                </div>-->
                <!---->
                <!--                <div class="col-md-4 col-sm-12">-->
                <!--                    <div class="input-group" style="width: 100%">-->
                <!--                        <select class="form-control chosen-select" style="height: 35px" name="foodmenu" data-placeholder="Pilih Petugas" onchange="$('#date').submit()">-->
                <!--                            <option value="0">Semua Menu</option>-->
                <!--                            --><?php
                //                            foreach ($foodmenu as $f) {
                //                                echo '<option value="' . $f['food_menu_id'] . '" ' . (($foodmenuterpilih == $f['food_menu_id']) ? "selected" : "") . '>' . $f['food_menu_name'] . '</option>';
                //                            }
                //                            ?>
                <!--                        </select>-->
                <!--                    </div>-->
                <!--                </div>-->
                <div>
                    <div class="col-md-4 col-sm-12">
                        <div class="input-group">
                            <input type="text" name="from" class="form-control" style="height: 35px" placeholder="From : mm/dd/yyyy" id="datepicker" value="<?= (($from != NULL) ? $from : date("m/d/Y")); ?>" />
                            <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <div class="input-group">
                            <input type="text" name="to" class="form-control" style="height: 35px" placeholder="To : mm/dd/yyyy" id="datepicker1" value="<?= (($to != NULL) ? $to : date("m/d/Y")); ?>" max="<?= date("m/d/Y"); ?>" />
                            <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <hr />
        <div class="table-responsive">
            <table class="table" style="font-size: 11px;">
                <thead>
                <tr>
                    <th>No</th>

                    <th>Member</th>
                    <th>Total Belanja</th>
                </tr>
                </thead>
                <tbody style="color: black;">
                <?php
                $kind = 'gray';
                $total_amount=0;
                for ($i = 0; $i < count($dataTable); $i++) {
                    $t = $dataTable[$i];

//                        $price = $t['food_menu_price'];

                    $total_amount += $t['totalbelanja'];

                    ?>
                    <tr class="gradeA"style="background-color: <?= $kind ?>">
                    <td><?= $i + 1; ?></td>
                    <td><?= $t['food_menu_name']; ?></td>
                    <td><?= $t['totalbelanja']; ?></td>
                    </tr>
                    <?php
                    $kind = (($kind == 'gray') ? 'darkgray' : 'gray');
                }

                ?>
                <tr class="gradeA" style="background-color: whitesmoke; font-size: 15px">
                    <td></td>
                    <td><strong>Total</strong></td>
                    <td><strong><?= $total_amount; ?></strong></td>
                </tr>
                </tbody>
            </table>
        </div><!-- table-responsive -->
    </div><!-- panel-body -->
</div><!-- panel -->

<script>
    $('#date input').on('change', function () {
        $("#date").submit();
    });
</script>