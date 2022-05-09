<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12 pad0">
            <div class="ibox ">
                <div class="ibox-title d-flex align-items-center justify-content-between">
                    <h5>Tanggal Kirim</h5>
                </div>
                <div class="ibox-content">
                    <form method="post" id="filter_user">
                        <div class="form-row d-flex align-items-end">
                            <div class="col-lg-10 my-1">
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
                    <h5>Data Order Gift</h5>
                </div>
                <form method="post" action="" id="bulk">
                    <div class="ibox-content">
                        <div class="table-responsive">
                            <table id="datatable" class="table table-striped table-sm display" width="100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tgl Transaksi</th>
                                        <th>Tgl Kirim</th>
                                        <th>Shift</th>
                                        <th>Invoice</th>
                                        <th>Pembeli</th>
                                        <th>Penerima</th>
                                        <th>Total</th>
                                        <th>Payment</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= core_script(); ?>
<?= datatables(); ?>
<?= datepicker(); ?>
<script>
    $(document).ready(function() {
        $('.input-daterange').datepicker({
            keyboardNavigation: false,
            forceParse: false,
            autoclose: true
        });
        $('#datatable').DataTable({
            "pageLength": 50,
            "dom": '<"html5buttons">lTfgitp',
            "processing": true,
            "serverSide": true,
            "order": [
                [2, 'desc']
            ],
            "aLengthMenu": [
                [10, 20, 50, 100, -1],
                [10, 20, 50, 100, 'All']
            ],
            "ajax": {
                "url": "<?= base_url('order/get_gift?start=' . $filter_start . '&end=' . $filter_end); ?>",
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
                    var created_date = new Date(parseInt(data.$date.$numberLong));
                    var days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                    var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                    return days[created_date.getDay()] + ', ' + created_date.getDate() + ' ' + months[created_date.getMonth()] + ' ' + parseInt(created_date.getFullYear() - 2000).toString() + ' ' + created_date.getHours() + ':' + created_date.getMinutes();
                }
            }, {
                "data": "delivery_time",
                render: function(data, type, row, meta) {
                    var created_date = new Date(parseInt(data.$date.$numberLong));
                    var days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                    var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                    return days[created_date.getDay()] + ', ' + created_date.getDate() + ' ' + months[created_date.getMonth()] + ' ' + parseInt(created_date.getFullYear() - 2000).toString();
                }
            }, {
                "data": "delivery_shift",
                render: function(data, type, row, meta) {
                    delivery_shift = data ? data : null;
                    return delivery_shift;
                }
            }, {
                "data": "invno",
                render: function(data, type, row, meta) {
                    return `<a href='<?= base_url('order/view/') ?>` + row['_id'] + `'>` + data + `</a>`;
                }
            }, {
                "data": "customer"
            }, {
                "data": "recipient"
            }, {
                "class": "text-right",
                "data": "price",
                render: function(data, type, row, meta) {
                    return $.fn.dataTable.render.number('.', ',', 0, '').display(data.total);
                }
            }, {
                "data": "payment",
                render: function(data, type, row, meta) {
                    var payment = [];
                    if (data) {
                        for (let i = 0; i < data.length; i++) {
                            payment.push(data[i].method.split(" ")[0]);
                        }
                        return payment.join(', ');
                    } else {
                        return '';
                    }
                }
            }]
        });
    });
</script>