<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12 pad0">
            <div class="ibox ">
                <div class="ibox-content">
                    <form method="post" id="filter_user">
                        <div class="form-row d-flex align-items-end">
                            <div class="col-lg-5 my-1">
                                <p>Tanggal Transaksi</p>
                                <div class="input-daterange input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text width46"><svg style="width:20px;height:20px;margin:auto" viewBox="0 0 24 24">
                                                <path fill="#173b60" d="M9,10H7V12H9V10M13,10H11V12H13V10M17,10H15V12H17V10M19,3H18V1H16V3H8V1H6V3H5C3.89,3 3,3.9 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V5A2,2 0 0,0 19,3M19,19H5V8H19V19Z"></path>
                                            </svg></div>
                                    </div>
                                    <input type="search" class="form-control" name="filter_start" placeholder="Start Date" value="<?= $filter_start ?>" autocomplete="off">
                                    <input type="search" class="form-control" name="filter_end" placeholder="End Date" value="<?= $filter_end ?>" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-lg-5 my-1">
                                <p>Payment</p>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text width46"><svg style="width:20px;height:20px;margin:auto" viewBox="0 0 24 24">
                                                <path fill="#173b60" d="M3,6H21V18H3V6M12,9A3,3 0 0,1 15,12A3,3 0 0,1 12,15A3,3 0 0,1 9,12A3,3 0 0,1 12,9M7,8A2,2 0 0,1 5,10V14A2,2 0 0,1 7,16H17A2,2 0 0,1 19,14V10A2,2 0 0,1 17,8H7Z" />
                                            </svg></div>
                                    </div>
                                    <select name="filter_payment" class="form-control" id="filter_payment">
                                        <option></option>
                                        <?php foreach ($payment as $value) : ?>
                                            <option value="<?= $value; ?>" <?php if ($value == $filter_payment) : ?> selected<?php endif; ?>><?= $value; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-2 my-1">
                                <button type="submit" class="btn btn-warning btn-block btn-lg">Filter</button>
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
                    <h5>Data Order</h5>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table id="datatable" class="table table-striped table-bordered table-sm display" width="100%">
                            <thead>
                                <tr>
                                    <th class="align-middle" rowspan="2">No</th>
                                    <th class="align-middle" rowspan="2">Tgl Trx</th>
                                    <th class="align-middle" rowspan="2">Tgl Kirim</th>
                                    <th class="align-middle" rowspan="2">Invoice</th>
                                    <th class="align-middle" rowspan="2">Status</th>
                                    <th class="align-middle" rowspan="2">Pembeli</th>
                                    <th class="text-center" colspan="3">Payment</th>
                                    <th class="align-middle" rowspan="2">Total</th>
                                </tr>
                                <tr>
                                    <th>Transfer</th>
                                    <th>Nama</th>
                                    <th>Nominal</th>
                                </tr>
                            </thead>
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
<?= select2(); ?>
<script>
    $(document).ready(function() {
        $('.input-daterange').datepicker({
            format: 'dd-mm-yyyy',
            keyboardNavigation: false,
            forceParse: false,
            autoclose: true
        });
        $("#filter_payment").select2({
            placeholder: 'Jenis Pembayaran',
            theme: 'bootstrap4',
            language: 'id'
        });
        $('#datatable').DataTable({
            "pageLength": 50,
            "dom": '<"html5buttons">lTfgitp',
            "processing": true,
            "serverSide": true,
            "order": [
                [3, 'desc']
            ],
            "aLengthMenu": [
                [10, 20, 50, 100, -1],
                [10, 20, 50, 100, 'All']
            ],
            "ajax": {
                "url": "<?= base_url('payment/get_data?start=' . $filter_start . '&end=' . $filter_end . '&payment=' . $filter_payment); ?>",
                "type": "POST"
            },
            "columns": [{
                "data": null,
                "sortable": false,
                render: function(data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            }, {
                "data": "transaction_date",
                render: function(data, type, row, meta) {
                    return data ? data.slice(-10) : null;
                }
            }, {
                "data": "delivery_time",
                render: function(data, type, row, meta) {
                    return data ? data.slice(-10) : null;
                }
            }, {
                "data": "invno",
                render: function(data, type, row, meta) {
                    return `<a href='<?= base_url('payment/view_payment/') ?>` + row['_id'] + `' target=_blank>` + data + `</a>`;
                }
            }, {
                "data": "status",
                render: function(data, type, row, meta) {
                    return data ? data : null;
                }
            }, {
                "data": "customer",
                render: function(data, type, row, meta) {
                    return data ? data : null;
                }
            }, {
                "data": "paid_at",
                render: function(data, type, row, meta) {
                    return data ? data.slice(-10) : null;
                }
            }, {
                "data": "method",
                render: function(data, type, row, meta) {
                    return data ? data : null;
                }
            }, {
                "class": "text-right",
                "data": "payment_amount",
                render: $.fn.dataTable.render.number('.', ',', 0, '')
            }, {
                "class": "text-right",
                "data": "total",
                render: $.fn.dataTable.render.number('.', ',', 0, '')
            }]
        });
    });
</script>