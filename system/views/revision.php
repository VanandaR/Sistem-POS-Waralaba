<div class="panel panel-default">
    <div class="panel-body">
        <hr />
        <div class="table-responsive">
            <table class="table table-striped" style="font-size: 11px;">
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
                    <th>Waktu</th>
                    <th>Material</th>
                    <th>Stok Lama</th>
                    <th>Stok Baru</th>
                    <th>Alasan Revisi</th>

                </tr>
                </thead>
                <tbody style="color: black;">
                <?php
                $total_amount=0;
                for ($i = 0; $i < count($dataTable); $i++) {
                    $t = $dataTable[$i];

                    ?>
                    <tr class="gradeA">

                        <td><?= $i + 1; ?></td>
                        <?php
                        if ($this->session->userdata('outlet_id') == 'all') {
                            ?>
                            <td><?= $t['outlet_name']; ?></td>
                            <?php
                        }
                        ?>
                        <td><?= $t['timestamp']; ?></td>
                        <td><?= $t['material_name']; ?></td>
                        <td><?= $t['older_stock']; ?></td>
                        <td><?= $t['new_stock']; ?></td>
                        <td><?= $t['reason']; ?></td>


                    </tr>
                    <?php
                }
                ?>
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