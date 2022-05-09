<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12 pad0">
            <div class="ibox ">
                <div class="ibox-title d-flex align-items-center justify-content-between">
                    <h5>Data Cluster</h5>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-lg-6">
                            <div id="vmap"></div>
                        </div>
                        <div class="col-lg-6">
                            <div id="table"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= core_script(); ?>
<?= jqvmap(); ?>
<script type="text/javascript">
    $(document).ready(function() {
        $.ajax({
            type: "GET",
            url: '<?= base_url('report/get_cluster/') ?>',
            success: function(response) {
                var result = $.parseJSON(response);
                jQuery('#vmap').vectorMap({
                    map: 'surabaya',
                    backgroundColor: '#fff',
                    regionStyle: {
                        initial: {
                            stroke: "black",
                            "stroke-width": 10,
                            "stroke-opacity": 1
                        }
                    },
                    series: {
                        markers: [{
                            attribute: 'fill',
                            scale: ['#e6f3db', '#8ab661'],
                            normalizeFunction: 'polynomial',
                            values: result.customer1,
                            legend: {
                                vertical: true,
                                title: 'Customer'
                            }
                        }],
                        regions: [{
                            scale: ['#e6f3db', '#8ab661'],
                            attribute: 'fill',
                            values: result.customer2
                        }],
                    },
                    regionLabelStyle: {
                        initial: {
                            fill: 'black'
                        }
                    },
                    labels: {
                        regions: {
                            render: function(code) {
                                return result.code[code];
                            },
                            offsets: function(code) {
                                return {
                                    '01': [0, -500],
                                    '04': [-400, 0],
                                    '11': [5000, 0],
                                } [result.code[code]];
                            }
                        }
                    },
                    onRegionTipShow: function(event, label, code) {
                        label.html(
                            '<b>' + label.html() + '</b></br>' +
                            '<b>Customer: </b>' + separator(result.customer2[code]) + '</br>' +
                            '<b>Transaksi: </b>' + separator(result.transaction[code]) + '</br>' +
                            '<b>Avg: </b>' + result.avg[code]
                        );
                    }
                });
                var table1 = `<div class="table-responsive">
                    <table class="table table-striped table-sm display" width="100%">
                        <thead>
                            <tr>
                                <th style="width: 8px">Code</th>
                                <th>Cluster</th>
                                <th class="text-right">Jml Cust</th>
                                <th class="text-right">Jml Trx</th>
                                <th class="text-right">Avg</th>
                            </tr>
                        </thead>
                        <tbody>`;
                var table2 = '';
                for (let i = 0; i < result.data.length; i++) {
                    table2 = table2 + `<tr>
                        <td>` + result.data[i].code + `</td>
                        <td>` + result.data[i].cluster + `</td>
                        <td class="text-right">` + separator(result.data[i].customer) + `</td>
                        <td class="text-right">` + separator(result.data[i].transaction) + `</td>
                        <td class="text-right">` + result.data[i].avg + `</td>
                        </tr>`;
                }
                var table3 = `</tbody>
                        </table>
                    </div>`;
                $('#table').append(table1 + table2 + table3);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    });

    function separator(data) {
        return data.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }
</script>