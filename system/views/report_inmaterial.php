<div class="panel panel-default">
    <div class="panel-body">
        <div class="row">
            <form method="POST" action="<?= base_url(); ?>report/inmaterial" id="date">
                <div class="form-group">
                    <label for="template-jobform-fname" class="col-sm-12">Pilih Range Waktu</label>
                    <div class="col-sm-4">
                        <select id="range" class="form-control" name="range" required>
                            <option value="">Pilih</option>
                            <option value="1">Hari Ini</option>
                            <option value="2">Kemarin</option>
                            <option value="3">7 Hari Terakhir</option>
                            <option value="4">Bulan Ini</option>
                            <option value="5">Bulan Lalu</option>
                        </select>
                        <!--                            <input id="radio-7" class="radio-style" name="jeniskursus" type="radio" value="1">-->
                        <!--                            <label for="radio-7" class="radio-style-3-label radio-small">Hari ini</label>-->
                        <!--                            <input id="radio-8" class="radio-style" name="jeniskursus" type="radio" value="2">-->
                        <!--                            <label for="radio-8" class="radio-style-3-label radio-small">Kemarin</label>-->
                        <!--                            <input id="radio-9" class="radio-style" name="jeniskursus" type="radio" value="3">-->
                        <!--                            <label for="radio-9" class="radio-style-3-label radio-small">7 Hari Terakhir</label>-->
                        <!--                            <input id="radio-9" class="radio-style" name="jeniskursus" type="radio" value="3">-->
                        <!--                            <label for="radio-9" class="radio-style-3-label radio-small">Bulan ini</label>-->
                        <!--                            <input id="radio-9" class="radio-style" name="jeniskursus" type="radio" value="3">-->
                        <!--                            <label for="radio-9" class="radio-style-3-label radio-small">Bulan Lalu</label>-->
                    </div>
                    <div class="col-md-3 ">
                        <div class="input-group ">
                            <input type="text" name="from" class="form-control" style="height: 35px" placeholder="From : mm/dd/yyyy" id="datepicker" value="<?= (($from != NULL) ? $from : date("m/d/Y"));?>" />
                            <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="input-group">
                            <input type="text" name="to" class="form-control" style="height: 35px" placeholder="To : mm/dd/yyyy" id="datepicker1" value="<?= (($to != NULL) ? $to : date("m/d/Y"));?>" max="<?= date("Y-m-d");?>" />
                            <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                        </div>
                    </div>

                </div>

            </form>
        </div>
        <hr />
        <div class="table-responsive">
            <table class="table table-striped" id="table" style="font-size: 11px;">
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
                    <th>Nama Bahan</th>
                    <th>Jumlah</th>
                    <th>Petugas</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $i = 0;
                foreach ($dataTable as $t):
                    ?>
                    <tr class="gradeA">
                        <td><?= ++$i; ?></td>
                        <?php
                        if ($this->session->userdata('outlet_id') == 'all') {
                            ?>
                            <td><?= $t['outlet_name']; ?></td>
                            <?php
                        }
                        ?>
                        <td><?= $t['inmaterial_date']; ?></td>
                        <td><?= $t['material_name']; ?></td>
                        <td><?= $t['amount']; ?></td>
                        <td><?= $t['user_name']; ?></td>
                    </tr>
                    <?php
                endforeach;
                ?>
                </tbody>
            </table>
        </div><!-- table-responsive -->
    </div><!-- panel-body -->
</div><!-- panel -->

<script>
    $('#datepicker').on('change', function() {
        $('#table').DataTable({
            "processing": true,
            "serverSide": true,
            retrieve: true,
            paging: false,
            "ajax": {
                url: '<?= base_url(); ?>report/inmaterial_table',
                type: 'POST'
            },
            "columns": [
                {"data": "inmaterial_date"},
                {"data": "material_name"},
                {"data": "amount"},
                {"data": "user_name"}
            ],
        });
        //        $( document ).ready(function() {
        //            $('#table').dataTable({
        //                retrieve: true,
        //                paging: false,
        //                searching: false,
        //                "bProcessing": true,
        //                "sAjaxSource": "<?//= base_url(); ?>//report/inmaterial_table",
        //                "aoColumns": [
        //                    { mData: 'inmaterial_date' } ,
        //                    { mData: 'material_name' },
        //                    { mData: 'amount' },
        //                    { mData: 'user_name' }
        //                ]
        //            });
        //        });
        //        jQuery.ajax({
        //            type: "POST",
        //            url: "<?//= base_url(); ?>//report/inmaterial_table",
        //            dataType: 'JSON',
        //            data: {id: $(this).attr("id")},
        //            success: function(data) {
        //                $(document).ready(function() {
        //                    $('#example').DataTable( {
        //                        "columns": [
        //                            { "data": "name" },
        //                            { "data": "position" },
        //                            { "data": "office" },
        //                            { "data": "extn" },
        //                            { "data": "start_date" },
        //                            { "data": "salary" }
        //                        ]
        //                    } );
        //                } );
        //            }
        //        });
        $("#date").submit();
    });
    $('#datepicker1').on('change', function() {
        $("#date").submit();
    });
    $('#range').on('change', function() {
        $("#date").submit();
    });
</script>