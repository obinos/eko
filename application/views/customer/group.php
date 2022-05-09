<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12 pad0">
            <div class="ibox ">
                <div class="ibox-title d-flex align-items-center justify-content-between">
                    <h5>Total Customer: <?= $total ?></h5>
                </div>
                <div class="ibox-content">
                    <div id="container"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 pad0">
            <div class="ibox ">
                <div class="ibox-title d-flex align-items-center justify-content-between">
                    <h5>Group Customer</h5>
                </div>
                <div class="ibox-content">
                    <div class="row d-flex align-items-center">
                        <?php foreach ($customer as $data) { ?>
                            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-6 pad0">
                                <div class="card <?= $data['bg'] ?> mb-3">
                                    <div class="widget style1">
                                        <div class="row align-items-center">
                                            <div class="col-4">
                                                <span class="<?= $data['icon'] ?>"></span>
                                            </div>
                                            <div class="col-8 text-right">
                                                <span><?= $data['title'] ?></span>
                                                <h2 class="font-bold order-open"><?= $data['count'] ?></h2>
                                            </div>
                                        </div>
                                    </div>
                                    <a class="card-footer d-flex align-items-center justify-content-between text-dark" href="<?= base_url('customer/grouplist/') . $data['icon'] ?>">
                                        <p>View List</p>
                                        <div class="text-white"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#212121" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                                <path d="M9 18l6-6-6-6" />
                                            </svg>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= core_script(); ?>
<?= highchart(); ?>
<script>
    $(document).ready(function() {
        total = 500;
        Highcharts.chart('container', {
            chart: {
                type: 'column'
            },
            title: {
                text: ''
            },
            accessibility: {
                announceNewData: {
                    enabled: true
                }
            },
            xAxis: {
                type: 'category'
            },
            yAxis: {
                title: {
                    text: 'Customer'
                }

            },
            legend: {
                enabled: false
            },
            plotOptions: {
                series: {
                    borderWidth: 0,
                    dataLabels: {
                        enabled: true
                    }
                }
            },

            tooltip: {
                headerFormat: '<span style="font-size:11px">Total {series.name}: <b><?= $total ?></b></span><br>',
                pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.q:.2f}%</b><br/>'
            },

            series: [{
                name: "Customer",
                colorByPoint: true,
                data: [
                    <?php foreach ($customer as $data) { ?> {
                            name: "<?= $data['title'] ?>",
                            y: <?= $data['count'] ?>,
                            q: <?= round($data['count'] / $total * 100, 2) ?>,
                            color: '<?= $data['color'] ?>'
                        },
                    <?php } ?>
                ]
            }],
            exporting: {
                enabled: false
            },
            credits: {
                enabled: false
            }
        });
    });
</script>