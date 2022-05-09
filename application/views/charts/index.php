<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12 pad0">
            <div class="ibox ">
                <div class="ibox-content">
                    <div id="container1"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 pad0">
            <div class="ibox ">
                <div class="ibox-content">
                    <div id="container2"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= core_script(); ?>
<?= highchart(); ?>
<script>
    $(document).ready(function() {
        Highcharts.setOptions({
            lang: {
                decimalPoint: ',',
                thousandsSep: '.'
            }
        });
        Highcharts.chart('container1', {
            title: {
                text: 'Omset - Order'
            },
            xAxis: {
                tickInterval: 7 * 24 * 3600 * 1000,
                tickWidth: 0,
                gridLineWidth: 1
            },
            series: [{
                    yAxis: 0,
                    color: '#3d3d3d'
                },
                {
                    yAxis: 1,
                    color: '#8ab6617a'
                }
            ],
            data: {
                csv: "<?= $data_chart['data1'] ?>"
            },
            yAxis: [{
                    title: {
                        text: null
                    },
                    index: 0,
                    showFirstLabel: false
                },
                {
                    title: {
                        text: null
                    },
                    min: 0,
                    max: 300,
                    index: 1,
                    opposite: true,
                    showFirstLabel: false
                }
            ],
            chart: {
                scrollablePlotArea: {
                    minWidth: 700
                }
            },
            tooltip: {
                shared: true,
                crosshairs: true
            },
            credits: {
                enabled: false
            },
            exporting: {
                enabled: false
            }
        });
        Highcharts.chart('container2', {
            title: {
                text: 'AvgBasketSize - NewCustomer'
            },
            xAxis: {
                tickInterval: 7 * 24 * 3600 * 1000,
                tickWidth: 0,
                gridLineWidth: 1
            },
            series: [{
                    yAxis: 0,
                    color: '#3d3d3d'
                },
                {
                    yAxis: 1,
                    color: '#8ab6617a'
                }
            ],
            data: {
                csv: "<?= $data_chart['data2'] ?>"
            },
            yAxis: [{
                    title: {
                        text: null
                    },
                    index: 0,
                    showFirstLabel: false
                },
                {
                    title: {
                        text: null
                    },
                    index: 1,
                    opposite: true,
                    showFirstLabel: false
                }
            ],
            chart: {
                scrollablePlotArea: {
                    minWidth: 700
                }
            },
            tooltip: {
                shared: true,
                crosshairs: true
            },
            credits: {
                enabled: false
            },
            exporting: {
                enabled: false
            }
        });
    });
</script>