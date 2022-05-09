<link href="<?= base_url('assets/'); ?>vendor/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css" rel="stylesheet" type="text/css">
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12 pad0">
            <div class="ibox ">
                <div class="ibox-title d-flex align-items-center justify-content-between">
                    <h5>Data Order <?= $status_order['title'] ?></h5>
                    <div class="btn-group">
                        <button data-toggle="dropdown" class="btn btn-primary btn-sm dropdown-toggle">
                            <svg width="16px" height="16px" viewBox="0 0 16 16" fill="currentColor">
                                <path d="M3 14.5A1.5 1.5 0 0 1 1.5 13V3A1.5 1.5 0 0 1 3 1.5h8a.5.5 0 0 1 0 1H3a.5.5 0 0 0-.5.5v10a.5.5 0 0 0 .5.5h10a.5.5 0 0 0 .5-.5V8a.5.5 0 0 1 1 0v5a1.5 1.5 0 0 1-1.5 1.5H3z" />
                                <path d="m8.354 10.354 7-7a.5.5 0 0 0-.708-.708L8 9.293 5.354 6.646a.5.5 0 1 0-.708.708l3 3a.5.5 0 0 0 .708 0z" />
                            </svg> Ubah Status</button>
                        <ul class="dropdown-menu animated fadeInRight m-t-xs">
                            <?php foreach ($data_status as $key => $val) {
                                if ($status != $key) { ?>
                                    <li><a class='dropdown-item' id="<?= $key ?>"><?= $val ?></a></li>
                            <?php }
                            } ?>
                        </ul>
                    </div>
                </div>
                <form method="post" action="" id="bulk">
                    <div class="ibox-content">
                        <div class="table-responsive">
                            <table id="datatable" class="table table-striped table-sm display" width="100%">
                                <thead>
                                    <tr>
                                        <th>
                                            <div class="form-check abc-checkbox abc-checkbox-success">
                                                <input class="form-check-input" type="checkbox" id="check-all">
                                                <label class="form-check-label" for="check-all"></label>
                                            </div>
                                        </th>
                                        <th>No</th>
                                        <th>Tgl Transaksi</th>
                                        <th>Tgl Kirim</th>
                                        <th>Kirim</th>
                                        <th>Invoice</th>
                                        <th>Pembeli</th>
                                        <th>Penerima</th>
                                        <th>Berat</th>
                                        <th>Voucher</th>
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
<script>
    $(document).ready(function() {
        $("#check-all").click(function() {
            if ($(this).is(":checked"))
                $(".check-item").prop("checked", true);
            else
                $(".check-item").prop("checked", false);
        });
        $(".dropdown-item").click(function() {
            checked = $("input[type=checkbox]:checked").length;
            if (!checked) {
                Swal({
                    title: 'Silahkan checkbox terlebih dahulu',
                    type: 'warning',
                    showConfirmButton: false,
                    timer: 2000
                })
                return false;
            }
            Swal({
                title: 'Apakah mau update status pesanan?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#8ab661',
                cancelButtonColor: '#fd8664',
                confirmButtonText: 'Update'
            }).then((result) => {
                if (result.value) {
                    $.each($(".check-item[type=checkbox]:checked"), function() {
                        var data = $(this).parents('tr:eq(0)');
                        $(data).find('td:eq(0) div input').attr('name', 'id[]')
                    });
                    $('#bulk').attr('action', "<?= base_url("order/bulk_status/$status/") ?>" + this.id).submit();
                }
            })
        });
        $('#datatable').DataTable({
            "pageLength": 20,
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
                "url": "<?= base_url('order/get_data/' . $status . '?start=' . $start . '&end=' . $end); ?>",
                "type": "POST"
            },
            "columns": [{
                "data": null,
                "sortable": false,
                render: function(data, type, row, meta) {
                    return `<div class="form-check abc-checkbox abc-checkbox-success">
                        <input class="form-check-input check-item" type="checkbox" id="` + row['_id'] + `" value="` + row['_id'] + `">
                        <label class="form-check-label" for="` + row['_id'] + `"></label>
                    </div>`;
                }
            }, {
                "data": null,
                "sortable": false,
                render: function(data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            }, {
                "data": "transaction_date",
                render: function(data, type, row, meta) {
                    return data.slice(-16);
                }
            }, {
                "data": "delivery_time",
                render: function(data, type, row, meta) {
                    return data.slice(-10);
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
                "data": "customer",
                render: function(data, type, row, meta) {
                    return data.name;
                }
            }, {
                "data": "recipient",
                render: function(data, type, row, meta) {
                    return data.name;
                }
            }, {
                "class": "text-right",
                "data": "shipping_weight",
                render: function(data, type, row, meta) {
                    shipping_weight = data ? data : null;
                    return shipping_weight;
                }
            }, {
                "data": "voucher",
                render: function(data, type, row, meta) {
                    voucher = data ? data : null;
                    return voucher;
                }
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