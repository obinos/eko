<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12 pad0">
            <div class="ibox ">
                <div class="ibox-title d-flex align-items-center justify-content-between">
                    <h5>Tanggal Pengiriman</h5>
                </div>
                <div class="ibox-content">
                    <form method="post" id="filter_user">
                        <div class="form-row align-items-center">
                            <div class="col-lg-5 my-1">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text width46"><svg style="width:20px;height:20px;margin:auto" viewBox="0 0 24 24">
                                                <path fill="#173b60" d="M3,22L4.5,20.5L6,22L7.5,20.5L9,22L10.5,20.5L12,22L13.5,20.5L15,22L16.5,20.5L18,22L19.5,20.5L21,22V2L19.5,3.5L18,2L16.5,3.5L15,2L13.5,3.5L12,2L10.5,3.5L9,2L7.5,3.5L6,2L4.5,3.5L3,2M18,9H6V7H18M18,13H6V11H18M18,17H6V15H18V17Z" />
                                            </svg></div>
                                    </div>
                                    <input type="text" class="form-control" id="noinvoice" placeholder="No Invoice" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-lg-5 my-1">
                                <div class="input-group date">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text width46"><svg style="width:20px;height:20px;margin:auto" viewBox="0 0 24 24">
                                                <path fill="#173b60" d="M9,10H7V12H9V10M13,10H11V12H13V10M17,10H15V12H17V10M19,3H18V1H16V3H8V1H6V3H5C3.89,3 3,3.9 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V5A2,2 0 0,0 19,3M19,19H5V8H19V19Z"></path>
                                            </svg></div>
                                    </div>
                                    <input type="text" class="form-control" name="filter_date" placeholder="Input Tanggal" value="<?= $filter_date ?>" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-lg-2 my-1">
                                <button type="submit" class="btn btn-warning btn-block">Filter</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 pad0">
            <div class="ibox ">
                <div class="ibox-title d-flex align-items-center justify-content-between">
                    <h5>Data Rekap Payment</h5>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table id="datatable" class="table table-striped table-sm display" width="100%">
                            <thead>
                                <tr>
                                    <th>Jenis Pembayaran</th>
                                    <th>Tgl Transaksi</th>
                                    <th>Invoice</th>
                                    <th>Pembeli</th>
                                    <th>Penerima</th>
                                    <th>Total Transaksi</th>
                                    <th>Ongkir</th>
                                    <th>Total</th>
                                    <th>View</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($recap as $data) :
                                ?>
                                    <tr class="<?= internal_notes($data['internal_notes']) ?>">
                                        <td><?= $data['payment'][0]->method ?></td>
                                        <td><?= datephp('d M y', $data['transaction_date']) ?></td>
                                        <td><?= $data['invno'] ?></td>
                                        <td><?= $data['customer']->name ?></td>
                                        <td><?= $data['recipient']->name ?></td>
                                        <td class="text-right"><?= thousand($data['price']->subtotal) ?></td>
                                        <td class="text-right"><?= thousand($data['price']->shipping) ?></td>
                                        <td class="text-right"><?= thousand($data['price']->total) ?></td>
                                        <td>
                                            <div class='btn-group btn-group-sm'>
                                                <a class='btn btn-primary' data-tooltip="tooltip" data-placement="top" title="Lihat Transaksi" href='<?= base_url('payment/view_payment/' . $data['_id']) ?>'>
                                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.134 13.134 0 0 0 1.66 2.043C4.12 11.332 5.88 12.5 8 12.5c2.12 0 3.879-1.168 5.168-2.457A13.134 13.134 0 0 0 14.828 8a13.133 13.133 0 0 0-1.66-2.043C11.879 4.668 10.119 3.5 8 3.5c-2.12 0-3.879 1.168-5.168 2.457A13.133 13.133 0 0 0 1.172 8z" />
                                                        <path fill-rule="evenodd" d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z" />
                                                    </svg>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= core_script(); ?>
<?= datepicker(); ?>
<?= datatables(); ?>
<script src="<?= base_url('assets/'); ?>vendor/typehead/bootstrap3-typeahead.min.js"></script>
<script>
    $(document).ready(function() {
        $('.date').datepicker({
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            autoclose: true
        });
        $('#noinvoice').typeahead({
            items: 20,
            source: <?= json_encode($this->aratadb->where(['merchant' => '606eba1c099777608a38aeda', 'status' => 'closed'])->get('orders'), true); ?>,
            displayText: function(item) {
                return item.invno;
            },
            afterSelect: function(event) {
                if (event._id.$oid)
                    var id = event._id.$oid;
                else
                    var id = event._id;
                window.location = "<?= base_url('report/view_payment/'); ?>" + id;
            }
        });
        var table = $('#datatable').DataTable({
            "columnDefs": [{
                "visible": false,
                "targets": 0
            }],
            "order": [
                [0, 'asc']
            ],
            "displayLength": 25,
            "drawCallback": function(settings) {
                var api = this.api();
                var rows = api.rows({
                    page: 'all'
                }).nodes();
                var last = null;
                var aData = new Array();
                api.column(0, {
                    page: 'all'
                }).data().each(function(group, i) {
                    group_assoc = group.replace(/[^a-zA-Z]/g, "");
                    var vals = api.row(api.row($(rows).eq(i)).index()).data();
                    var totalTrx = vals[5] ? parseFloat(vals[5].replace(/[^0-9]/g, '')) : 0;
                    var ongkir = vals[6] ? parseFloat(vals[6].replace(/[^0-9]/g, '')) : 0;
                    var totalAll = vals[7] ? parseFloat(vals[7].replace(/[^0-9]/g, '')) : 0;
                    if (typeof aData[group] == 'undefined') {
                        aData[group] = new Array();
                        aData[group].rows = [];
                        aData[group].totalTrx = [];
                        aData[group].ongkir = [];
                        aData[group].totalAll = [];
                    }
                    aData[group].rows.push(i);
                    aData[group].totalTrx.push(totalTrx);
                    aData[group].ongkir.push(ongkir);
                    aData[group].totalAll.push(totalAll);
                    if (last !== group) {
                        $(rows).eq(i).before(
                            '<tr class="group font-weight-bold"><td colspan="4">' + group + '</td>' +
                            '<td class="text-right font-weight-bold sumtotalTrx' + group_assoc + '"></td>' +
                            '<td class="text-right font-weight-bold sumongkir' + group_assoc + '"></td>' +
                            '<td class="text-right font-weight-bold sumtotalAll' + group_assoc + '"></td>' +
                            '<td></td></tr>'
                        );
                        last = group;
                    }
                });
                var idx = 0;
                for (var payment in aData) {
                    group_assoc = payment.replace(/[^a-zA-Z]/g, "");
                    idx = Math.max.apply(Math, aData[payment].rows);
                    var sumtotalTrx = 0;
                    var sumongkir = 0;
                    var sumtotalAll = 0;
                    $.each(aData[payment].totalTrx, function(k, v) {
                        sumtotalTrx = sumtotalTrx + v;
                    });
                    $.each(aData[payment].ongkir, function(k, v) {
                        sumongkir = sumongkir + v;
                    });
                    $.each(aData[payment].totalAll, function(k, v) {
                        sumtotalAll = sumtotalAll + v;
                    });
                    $(".sumtotalTrx" + group_assoc).html(rupiah(sumtotalTrx));
                    $(".sumongkir" + group_assoc).html(rupiah(sumongkir));
                    $(".sumtotalAll" + group_assoc).html(rupiah(sumtotalAll));
                };
            }
        });
    });

    function rupiah(angka) {
        var reverse = angka.toString().split('').reverse().join(''),
            ribuan = reverse.match(/\d{1,3}/g);
        ribuan = ribuan.join('.').split('').reverse().join('');
        return '' + ribuan;
    }
</script>