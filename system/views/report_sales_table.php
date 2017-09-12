<div class="panel panel-default">
    <div class="panel-body">
        <div class="row">
            <form method="POST" action="<?= base_url(); ?>report/sales_table" id="date">

                <div class="col-md-4 col-sm-12">
                    <div class="input-group" style="width: 100%">
                        <select class="form-control chosen-select" style="height: 35px" name="who" data-placeholder="Pilih Petugas" onchange="$('#date').submit()">
                            <option value="0">Semua Petugas</option>
                            <?php
                            foreach ($employee as $e) {
                                echo '<option value="' . $e['user_id'] . '" ' . (($who == $e['user_id']) ? "selected" : "") . '>' . $e['user_name'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-4 col-sm-12">
                    <div class="input-group" style="width: 100%">
                        <select class="form-control chosen-select" style="height: 35px" name="member" data-placeholder="Pilih Petugas" onchange="$('#date').submit()">
                            <option value="0">Semua Member</option>
                            <?php
                            foreach ($member as $m) {
                                echo '<option value="' . $m['member_id'] . '" ' . (($memberterpilih == $m['member_id']) ? "selected" : "") . '>' .$m['member_card'].' - '. $m['member_name'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>

                <div class="col-md-4 col-sm-12">
                    <div class="input-group" style="width: 100%">
                        <select class="form-control chosen-select" style="height: 35px" name="foodmenu" data-placeholder="Pilih Petugas" onchange="$('#date').submit()">
                            <option value="0">Semua Menu</option>
                            <?php
                            foreach ($foodmenu as $f) {
                                echo '<option value="' . $f['food_menu_id'] . '" ' . (($foodmenuterpilih == $f['food_menu_id']) ? "selected" : "") . '>' . $f['food_menu_name'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div>
                    <div class="col-md-4 col-sm-12">
                        <div class="input-group">
                            <input type="text" name="from" class="form-control" style="height: 35px" placeholder="From : mm/dd/yyyy" id="datepicker" value="<?= (($from != NULL) ? $from : date("m/d/Y")); ?>" />
                            <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-12">
                        <div class="input-group">
                            <input type="text" name="to" class="form-control" style="height: 35px" placeholder="To : mm/dd/yyyy" id="datepicker1" value="<?= (($to != NULL) ? $to : date("m/d/Y")); ?>" max="<?= date("Y-m-d"); ?>" />
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
                    <?php
                    if ($this->session->userdata('outlet_id') == 'all') {
                        ?>
                        <th>Outlet</th>
                        <?php
                    }
                    ?>
                    <th>Tanggal</th>
                    <th>Nama Menu</th>
                    <th>Member</th>
                    <th>Jumlah</th>
                    <th>Harga</th>
                    <th>Diskon</th>
                    <th>Sub Total</th>
                    <th>Petugas</th>
                    <th>Komisi</th>
                </tr>
                </thead>
                <tbody style="color: black;">
                <?php
                $total = 0;
                $total_amount = 0;
                $total_commision = 0;
                $sales_id = (count($dataTable) != 0) ? $dataTable[0]['sales_id'] : '';
                $kind = 'gray';
                for ($i = 0; $i < count($dataTable); $i++) {
                    $sales_id = $dataTable[$i]['sales_id'];
                    $t = $dataTable[$i];

//                        $price = $t['food_menu_price'];
                    $price = $t['price'];
                    $discount = (($t['kind'] == 2) ? $t['discount'] . '%' : '-');
                    $subtotal = (($t['kind'] == 2) ? $price * $t['amount'] - ($price * $t['amount'] * $discount / 100) : $price * $t['amount']);
                    $total += $subtotal;

                    $total_amount += $t['amount'];
                    $total_commision += $t['commision'];
                    ?>
                    <tr class="gradeA" style="background-color: <?= $kind ?>">
                        <td><?= $i + 1; ?></td>
                        <?php
                        if ($this->session->userdata('outlet_id') == 'all') {
                            ?>
                            <td><?= $t['outlet_name']; ?></td>
                            <?php
                        }
                        ?>
                        <td><?= $t['sales_date']; ?></td>
                        <td><?= $t['food_menu_name']; ?></td>
                        <td><?= $t['member_name']; ?></td>
                        <td><?= $t['amount']; ?></td>
                        <td><?= $price; ?></td>
                        <td><?= $discount; ?></td>
                        <td><?= $subtotal; ?></td>
                        <td><?= $t['user_name']; ?></td>
                        <td><?= $t['commision']; ?></td>
                    </tr>
                    <?php
                    if ($dataTable[$i]['kind'] == 1 && ((count($dataTable) - $i > 1 && $dataTable[$i + 1]['sales_id'] != $sales_id) OR $i == count($dataTable) - 1) && $t['discount'] > 0) {
                        $total -= $t['discount'];
                        ?>
                        <tr class="gradeA" style="background-color: <?= $kind ?>">
                            <td></td>
                            <?php
                            if ($this->session->userdata('outlet_id') == 'all') {
                                ?>
                                <td></td>
                                <?php
                            }
                            ?>
                            <td>Diskon</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>- <?= $dataTable[$i]['discount']; ?></td>
                            <td><?= $t['user_name']; ?></td>
                            <td></td>
                        </tr>
                        <?php
                    }

                    if (count($dataTable) - $i > 1) {
                        if ($dataTable[$i + 1]['sales_id'] != $sales_id) {
                            $kind = (($kind == 'gray') ? 'darkgray' : 'gray');
                        }
                    }
                }
                ?>
                <tr class="gradeA" style="background-color: whitesmoke; font-size: 15px">
                    <td></td>
                    <?php
                    if ($this->session->userdata('outlet_id') == 'all') {
                        ?>
                        <td></td>
                        <?php
                    }
                    ?>
                    <td><strong>Total</strong></td>
                    <td></td>
                    <td><strong><?= $total_amount; ?></strong></td>
                    <td></td>
                    <td></td>
                    <td><strong><?= $total; ?></strong></td>
                    <td></td>
                    <td><strong><?= $total_commision; ?></strong></td>
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