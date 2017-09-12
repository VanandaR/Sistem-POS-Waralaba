<div class="panel panel-default">
    <div class="panel-body">
        <hr />
        <div class="table-responsive">
            <table class="table table-striped" style="font-size: 11px;">
                <thead>
                <tr>
                    <th>No</th>
                    <th>Waktu</th>
                    <th>User</th>
                    <th>Deskripsi</th>
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
                        <td><?= $t['timestamp']; ?></td>
                        <td><?= $t['user_name']; ?></td>
                        <td><?= $t['activity']; ?></td>

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