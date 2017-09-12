<div class="panel panel-default">
    <div class="panel-body">
        <div class="row">
            <form method="POST" action="<?= base_url(); ?>report/sales_graph" id="date">
                <div class="col-md-4 col-sm-12">
                    From : 
                    <div class="input-group">
                        <input type="date" name="from" class="form-control hasDatepicker" style="height: 35px" placeholder="mm/dd/yyyy" id="datepicker1" value="<?= (($from != NULL) ? $from : date("Y-m-d")); ?>" />
                        <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                    </div>
                </div>
                <div class="col-md-4 col-sm-12">
                    To : 
                    <div class="input-group">
                        <input type="date" name="to" class="form-control hasDatepicker" style="height: 35px" placeholder="mm/dd/yyyy" id="datepicker2" value="<?= (($to != NULL) ? $to : date("Y-m-d")); ?>" max="<?= date("Y-m-d"); ?>" />
                        <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                    </div>
                </div>
                <div class="col-md-1 col-sm-3" style="margin-top: 20px">
                    <button class="btn" type="submit">Submit</button>
                </div>
            </form>
        </div>
        <div class="col-md-12 mb30">
            <div id="penjualan_chart" style="height: 325px;"></div>
        </div>
    </div><!-- panel-body -->
</div><!-- panel -->

<!--<pre>-->
<!--    --><?php
//    print_r($grafik);
//    ?>
<!--</pre>-->

<script>
$('#penjualan_chart').highcharts({
    chart: {
        zoomType: 'x'
    },
    title: {
        text: 'Total Penjualan Mr. BIG'
    },
    xAxis: {
        type: 'datetime',
        minRange: 14 * 24 * 3600000 // fourteen days
    },
    yAxis: {
        title: {
            text: 'Total Penjualan'
        }
    },
    legend: {
        enabled: false
    },
    plotOptions: {
        area: {
            fillColor: {
                linearGradient: { x1: 0, y1: 0, x2: 0, y2: 1},
                stops: [
                    [0, Highcharts.getOptions().colors[0]],
                    [1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
                ]
            },
            marker: {
                radius: 2
            },
            lineWidth: 1,
            states: {
                hover: {
                    lineWidth: 1
                }
            },
            threshold: null
        }
    },

    series: [{
        type: 'area',
        name: 'Total Penjualan',
        pointInterval: 24 * 3600 * 1000,
//                pointStart: Date.UTC(2006, 0, 01),
        <?php
//            $a = explode("-", $min);
            $a = explode("-", $grafik[0]['tanggal']);
            echo "pointStart: Date.UTC(" . $a[0] . ", " . ($a[1] - 1) . ", " . $a[2] . "),\n";
//            echo "pointStart: Date.UTC(" . str_replace("-", ", ", $grafik[0]['tanggal']) . "),\n";
        ?>
        data: [
            <?php
            $i = 0;
            foreach ($grafik as $g):
                if ($i == 0) {
                    echo $g["total"];
                    $i++;
                } else {
                    echo ', ' . $g["total"];
                }
            endforeach;
            ?>
        ]
    }]
});
</script>
