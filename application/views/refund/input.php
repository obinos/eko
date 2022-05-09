<link href="<?= base_url('assets/'); ?>vendor/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css" rel="stylesheet" type="text/css">
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12 pad0">
            <div class="ibox ">
                <div class="ibox-content">
                    <form method="post" id="filter_user">
                        <div class="form-row align-items-end">
                            <div class="col-lg-6 my-1">
                                <p>Tanggal Kirim</p>
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
                            <div class="col-lg-4 my-1">
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
                    <h5>Data Order Terkirim</h5>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table id="datatable" class="table table-striped table-sm display" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tgl Transaksi</th>
                                    <th>Tgl Kirim</th>
                                    <th>Kirim</th>
                                    <th>Invoice</th>
                                    <th>Refund</th>
                                    <th>Pembeli</th>
                                    <th>Penerima</th>
                                    <th>Voucher</th>
                                    <th>Total</th>
                                    <th>Payment</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="modal-form" class="modal fade bd-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Form Refund</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-4 pad0">
                        <div class="ibox ">
                            <div class="ibox-content">
                                <form role="form" id="form_edit">
                                    <input type="hidden" class="empty" id="_id" name="_id">
                                    <ul class="todo-list ui-sortable">
                                        <li>
                                            <div class="form-check abc-radio abc-radio-success">
                                                <input class="form-check-input checked" type="radio" id="GaransiKualitas" value="Garansi Kualitas" name="refund_category" aria-label="Single radio One">
                                                <label class="form-check-label" for="GaransiKualitas">Garansi Kualitas</label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="form-check abc-radio abc-radio-success">
                                                <input class="form-check-input" type="radio" id="SalahKirim" value="Salah Kirim" name="refund_category" aria-label="Single radio Two">
                                                <label class="form-check-label" for="SalahKirim">Salah Kirim</label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="form-check abc-radio abc-radio-success">
                                                <input class="form-check-input" type="radio" id="BarangKosong" value="Barang Kosong" name="refund_category" aria-label="Single radio Two">
                                                <label class="form-check-label" for="BarangKosong">Barang Kosong</label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="form-check abc-radio abc-radio-success">
                                                <input class="form-check-input" type="radio" id="KelebihanTransfer" value="Kelebihan Transfer" name="refund_category" aria-label="Single radio Two">
                                                <label class="form-check-label" for="KelebihanTransfer">Kelebihan Transfer</label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="form-check abc-radio abc-radio-success">
                                                <input class="form-check-input" type="radio" id="Lainnya" value="Lainnya" name="refund_category" aria-label="Single radio Two">
                                                <label class="form-check-label" for="Lainnya">Lainnya</label>
                                            </div>
                                        </li>
                                        <div class="form-group new-error">
                                            <div class="input-group my-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-addon bg-light2">Rp</span>
                                                </div>
                                                <input type="number" class="form-control" id="refund_price" name="refund_price">
                                            </div>
                                        </div>
                                    </ul>

                                    <div class="form-group d-flex align-items-center mt-3">
                                        <div class="form-check abc-radio abc-radio-primary form-check-inline">
                                            <input class="form-check-input unchecked" type="radio" id="transfer" value="transfer" name="refund_method">
                                            <label class="form-check-label" for="transfer"> Transfer </label>
                                        </div>
                                        <div class="form-check abc-radio abc-radio-primary form-check-inline">
                                            <input class="form-check-input unchecked" type="radio" id="voucher" value="voucher" name="refund_method">
                                            <label class="form-check-label" for="voucher"> Voucher <span class="empty" id="refund_voucher"></span></label>
                                        </div>
                                    </div>
                                    <div class="is-floating-label">
                                        <label class="form-label">Note Refund</label>
                                        <textarea class="form-control" rows="3" name="refund_notes" id="refund_notes"></textarea>
                                    </div>
                                    <div class="form-group d-flex align-items-center mt-3">
                                        <div class="form-check abc-radio abc-radio-danger form-check-inline">
                                            <input class="form-check-input checked" type="radio" id="refund_paidfalse" value="false" name="refund_paid">
                                            <label class="form-check-label" for="refund_paidfalse"> Pending </label>
                                        </div>
                                        <div class="form-check abc-radio abc-radio-primary form-check-inline">
                                            <input class="form-check-input" type="radio" id="refund_paidtrue" value="true" name="refund_paid">
                                            <label class="form-check-label" for="refund_paidtrue"> Done </label>
                                        </div>
                                    </div>
                                </form>
                                <form id="fileupload" action="<?= base_url('refund/upload/'); ?>" method="POST" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <noscript><input type="hidden" name="redirect" value="https://blueimp.github.io/jQuery-File-Upload/" /></noscript>
                                        <div class="row fileupload-buttonbar">
                                            <div class="col-lg-2">
                                                <span class="btn btn-success fileinput-button">
                                                    <span><svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                                            <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z" />
                                                            <path d="M7.646 1.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 2.707V11.5a.5.5 0 0 1-1 0V2.707L5.354 4.854a.5.5 0 1 1-.708-.708l3-3z" />
                                                        </svg></span>
                                                    <input type="file" name="files[]" multiple />
                                                </span>
                                                <span class="fileupload-process"></span>
                                            </div>
                                            <div class="col-lg-10 fileupload-progress fade">
                                                <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                                                    <div class="progress-bar progress-bar-striped bg-success" style="width: 0%;"></div>
                                                </div>
                                                <div class="progress-extended">&nbsp;</div>
                                            </div>
                                        </div>
                                    </div>
                                    <table role="presentation" class="table table-striped">
                                        <tbody class="files"></tbody>
                                    </table>
                                </form>
                                <button id="submit" type="submit" class="mt-3 btn btn-warning btn-block">Submit</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8 pad0">
                        <div class="ibox ">
                            <div class="ibox-content">
                                <div class="row justify-content-between d-flex align-items-center mb-2">
                                    <div class="col-8">
                                        <h3 class="text-success my-1" id="invno"></h3>
                                    </div>
                                    <div class="col-4">
                                        <p class="text-success text-right" id="transaction_date"></p>
                                    </div>
                                </div>
                                <div class="row justify-content-center d-flex align-items-center">
                                    <div class="col-md-6">
                                        <table class="table mb-0">
                                            <tbody>
                                                <tr>
                                                    <td style="width: 8px">
                                                        <svg style="width:20px;height:20px" viewBox="0 0 24 24">
                                                            <path fill="#909090" d="M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2M7.07,18.28C7.5,17.38 10.12,16.5 12,16.5C13.88,16.5 16.5,17.38 16.93,18.28C15.57,19.36 13.86,20 12,20C10.14,20 8.43,19.36 7.07,18.28M18.36,16.83C16.93,15.09 13.46,14.5 12,14.5C10.54,14.5 7.07,15.09 5.64,16.83C4.62,15.5 4,13.82 4,12C4,7.59 7.59,4 12,4C16.41,4 20,7.59 20,12C20,13.82 19.38,15.5 18.36,16.83M12,6C10.06,6 8.5,7.56 8.5,9.5C8.5,11.44 10.06,13 12,13C13.94,13 15.5,11.44 15.5,9.5C15.5,7.56 13.94,6 12,6M12,11A1.5,1.5 0 0,1 10.5,9.5A1.5,1.5 0 0,1 12,8A1.5,1.5 0 0,1 13.5,9.5A1.5,1.5 0 0,1 12,11Z" />
                                                        </svg>
                                                    </td>
                                                    <td class="text-left">
                                                        <strong class="empty" id="customer_name"></strong>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width: 8px">
                                                        <svg style="width:20px;height:20px" viewBox="0 0 24 24">
                                                            <path fill="#909090" d="M20,15.5C18.8,15.5 17.5,15.3 16.4,14.9C16.3,14.9 16.2,14.9 16.1,14.9C15.8,14.9 15.6,15 15.4,15.2L13.2,17.4C10.4,15.9 8,13.6 6.6,10.8L8.8,8.6C9.1,8.3 9.2,7.9 9,7.6C8.7,6.5 8.5,5.2 8.5,4C8.5,3.5 8,3 7.5,3H4C3.5,3 3,3.5 3,4C3,13.4 10.6,21 20,21C20.5,21 21,20.5 21,20V16.5C21,16 20.5,15.5 20,15.5M5,5H6.5C6.6,5.9 6.8,6.8 7,7.6L5.8,8.8C5.4,7.6 5.1,6.3 5,5M19,19C17.7,18.9 16.4,18.6 15.2,18.2L16.4,17C17.2,17.2 18.1,17.4 19,17.4V19Z" />
                                                        </svg>
                                                    </td>
                                                    <td class="text-left">
                                                        <strong class="empty" id="customer_phone"></strong>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-md-6">
                                        <table class="table mb-0">
                                            <tbody>
                                                <tr>
                                                    <td style="width: 8px">
                                                        <svg style="width:20px;height:20px" viewBox="0 0 24 24">
                                                            <path fill="#909090" d="M20,8H4V6H20M20,18H4V12H20M20,4H4C2.89,4 2,4.89 2,6V18A2,2 0 0,0 4,20H20A2,2 0 0,0 22,18V6C22,4.89 21.1,4 20,4Z" />
                                                        </svg>
                                                    </td>
                                                    <td class="text-left">
                                                        <strong class="empty" id="payment_nominal"></strong>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="width: 8px">
                                                        <svg style="width:20px;height:20px" viewBox="0 0 24 24">
                                                            <path fill="#909090" d="M12,20A8,8 0 0,0 20,12A8,8 0 0,0 12,4A8,8 0 0,0 4,12A8,8 0 0,0 12,20M12,2A10,10 0 0,1 22,12A10,10 0 0,1 12,22C6.47,22 2,17.5 2,12A10,10 0 0,1 12,2M12.5,7V12.25L17,14.92L16.25,16.15L11,13V7H12.5Z" />
                                                        </svg>
                                                    </td>
                                                    <td class="text-left">
                                                        <strong class="empty" id="tgl_krm"></strong>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-md-12">
                                        <table class="table mb-0">
                                            <tbody>
                                                <tr class="border-bottom">
                                                    <td style="width: 8px">
                                                        <svg style="width:20px;height:20px" viewBox="0 0 24 24">
                                                            <path fill="#909090" d="M12,6.5A2.5,2.5 0 0,1 14.5,9A2.5,2.5 0 0,1 12,11.5A2.5,2.5 0 0,1 9.5,9A2.5,2.5 0 0,1 12,6.5M12,2A7,7 0 0,1 19,9C19,14.25 12,22 12,22C12,22 5,14.25 5,9A7,7 0 0,1 12,2M12,4A5,5 0 0,0 7,9C7,10 7,12 12,18.71C17,12 17,10 17,9A5,5 0 0,0 12,4Z" />
                                                        </svg>
                                                    </td>
                                                    <td class="text-left">
                                                        <strong class="empty" id="customer_address"></strong>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-md-12">
                                        <BR>
                                        <div class="remove" id="dropship"></div>
                                        <div class="remove" id="merchant_notes"></div>
                                        <div class="table-responsive">
                                            <table class="tablepo table table-striped table-sm display table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 8px">No</th>
                                                        <th>Nama Produk</th>
                                                        <th class="text-right">Qty</th>
                                                        <th class="text-right">Harga</th>
                                                        <th class="text-right">Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="remove" id="items">
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th class="text-right" colspan="4">Subtotal</th>
                                                        <th class="text-right empty" id="subtotal"></th>
                                                    </tr>
                                                    <tr>
                                                        <th class="text-right" colspan="4">Ongkir</th>
                                                        <th class="text-right empty" id="shipping"></th>
                                                    </tr>
                                                    <tr class="remove" id="voucher">
                                                    </tr>
                                                    <tr>
                                                        <th class="text-right" colspan="4">Total</th>
                                                        <th class="text-right empty" id="alltotal"></th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                        <div class="is-floating-label internal_notes">
                                            <label class="form-label">Internal Note</label>
                                            <textarea class="form-control" rows="3" name="internal_notes" id="internal_notes"></textarea>
                                        </div>
                                        <button id="save" class="mt-3 btn btn-primary btn-block">Save</button>
                                    </div>
                                </div>
                            </div>
                        </div>
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
<?= toast(); ?>
<?= blueimp(); ?>
<script src="<?= base_url('assets/'); ?>vendor/validate/jquery.validate.min.js"></script>
<script>
    $(document).ready(function() {
        $('#fileupload').fileupload({
            url: '<?= base_url('refund/upload/'); ?>',
            acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
            maxNumberOfFiles: 3,
            disableImageResize: false,
            imageMaxWidth: 1000,
            imageMaxHeight: 1000
        });
        $('#fileupload').on('fileuploaddone', function(e, data) {
            $.each(data.result.files, function(index, file) {
                if (file.url) {
                    $('<input>').attr({
                        type: 'hidden',
                        class: 'refund_file',
                        id: rawurlencode(file.name),
                        name: 'file',
                        value: file.name
                    }).appendTo('form');
                }
            });
        });
        $('#fileupload').on('fileuploaddestroy', function(e, data) {
            $("*[id='" + getNameFile(data.url) + "']").remove();
        });
        $('.is-floating-label input, .is-floating-label textarea').on('focus blur', function(e) {
            $(this).parents('.is-floating-label').toggleClass('is-focused', (e.type === 'focus' || this.value.length > 0));
        }).trigger('blur');
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
                "url": "<?= base_url('order/get_data/closed?start=' . $filter_start . '&end=' . $filter_end . '&payment=' . $filter_payment); ?>",
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
                    return `<a class='btn_edit item_name text-success' data-id="` + row['_id'] + `">` + data + `</a>`;
                }
            }, {
                "class": "text-right",
                "data": "refund",
                render: function(data, type, row, meta) {
                    result = data ? separator(data.refund_price) : '';
                    if (result) {
                        label = data.refund_paid ? 'label label-success' : 'label label-danger';
                        return '<span class="' + label + '" id="' + row['_id'] + '">' + result + '</span>';
                    } else {
                        return '<span id="' + row['_id'] + '"></span>';
                    }
                }
            }, {
                "data": "customer",
                render: function(data, type, row, meta) {
                    return data.name + ' <a class="sendwa text-success" data-id="' + row['_id'] + '">' + data.phone + '</a>';
                }
            }, {
                "data": "recipient",
                render: function(data, type, row, meta) {
                    return data.name;
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
        $('#submit').on('click', function(e) {
            $('#form_edit').submit();
        });
        $('#save').on('click', function(e) {
            var object = {};
            $('#save').prop('disabled', true);
            object['_id'] = $('#_id').val();
            object['name'] = $('#customer_name').text();
            object['internal_notes'] = $('#internal_notes').val();
            var jsonString = JSON.stringify(object);
            $.ajax({
                type: "POST",
                url: '<?= base_url('refund/update_order/') ?>',
                data: {
                    data: jsonString
                },
                success: function(response) {
                    var result = $.parseJSON(response);
                    if (result.status == 'success') {
                        $.toast({
                            heading: 'Success',
                            text: 'Edit Order ' + result.name,
                            icon: 'success',
                            showHideTransition: 'slide',
                            hideAfter: 1000,
                            position: 'top-right',
                            afterHidden: function() {
                                $('#save').prop('disabled', false);
                            }
                        });
                    } else {
                        $.toast({
                            heading: 'Failed',
                            text: 'Same Value ' + result.status,
                            icon: 'error',
                            showHideTransition: 'slide',
                            hideAfter: 1000,
                            position: 'top-right'
                        });
                        $('#submit').prop('disabled', false);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                }
            });
        });
        $("#form_edit").submit(function(event) {
            event.preventDefault();
            var object = {};
            var array = [];
            $('#submit').prop('disabled', true);
            object['_id'] = $('#_id').val();
            object['name'] = $('#customer_name').text();
            object['phone'] = $('#customer_phone').text();
            object['inv'] = $('#invno').text();
            object['refund_category'] = $('input[name=refund_category]:checked').val();
            object['refund_price'] = $('#refund_price').val();
            object['refund_notes'] = $('#refund_notes').val();
            object['refund_paid'] = $('input[name=refund_paid]:checked').val();
            object['refund_method'] = $('input[name=refund_method]:checked').val();
            if (object['refund_method'] == 'voucher' && object['refund_paid'] == 'true') {
                object['refund_voucher'] = getVoucherCode(object['name'], object['inv']);
            }
            $('form#form_edit .refund_file').each(function() {
                var value = $(this).val();
                array.push(value);
            });
            object['file'] = array;
            var jsonString = JSON.stringify(object);
            $.ajax({
                type: "POST",
                url: '<?= base_url('refund/update_order/') ?>',
                data: {
                    data: jsonString
                },
                success: function(response) {
                    var result = $.parseJSON(response);
                    if (result.status == 'success') {
                        if (result.refund_price) {
                            $('span#' + result._id).removeClass().text(separator(result.refund_price)).addClass(result.label);
                        } else {
                            $('span#' + result._id).removeClass().text('');
                        }
                        $.toast({
                            heading: 'Success',
                            text: 'Edit Order ' + result.name,
                            icon: 'success',
                            showHideTransition: 'slide',
                            hideAfter: 1000,
                            position: 'top-right',
                            afterHidden: function() {
                                $('#modal-form').modal('toggle');
                                $('#submit').prop('disabled', false);
                            }
                        });
                    } else {
                        $.toast({
                            heading: 'Failed',
                            text: 'Same Value ' + result.status,
                            icon: 'error',
                            showHideTransition: 'slide',
                            hideAfter: 1000,
                            position: 'top-right'
                        });
                        $('#submit').prop('disabled', false);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                }
            });
        });
        $('#datatable').on('click', '.btn_edit', function() {
            var id = $(this).attr('data-id');
            $('.empty,tbody.files').empty();
            $('.remove').html('');
            $('.refund_file').remove();
            $('.is-floating-label').removeClass('is-focused');
            $('#refund_price,#refund_notes,#internal_notes').val('');
            $.ajax({
                type: "POST",
                url: '<?= base_url('refund/get_order') ?>',
                data: {
                    data: id
                },
                success: function(response) {
                    var array = $.parseJSON(response);
                    if (array.is_dropship === true) {
                        $('#dropship').html(`<div class="alert alert-secondary mb-2" role="alert">
                            <p>Penerima:</p>
                            <p><b>` + array.recipient.name + ` (` + array.recipient.phone + `)</b></p>
                            <p><b>` + array.recipient.address + `</b></p>
                        </div>`);
                    }
                    if (array.merchant_notes) {
                        $('#merchant_notes').html(`<div class="alert alert-warning mb-3" role="alert">
                            <p>Catatan Penjual: <b>` + array.merchant_notes + `</b></p>
                        </div>`);
                    }
                    if (array.internal_notes) {
                        $('.internal_notes').addClass('is-focused');
                        $('#internal_notes').val(array.internal_notes);
                    }
                    if (array.voucher) {
                        $('#voucher').html(`<th class="text-right" colspan="4">Voucher (` + array.voucher + `)</th>
                            <th class="text-right">- ` + separator(array.price.discount) + `</th>`);
                    }
                    if (array.items) {
                        for (let i = 0; i < array.items.length; i++) {
                            var note = array.items[i].note ? "<br><small>" + array.items[i].note + "</small>" : "";
                            $('#items').append(`<tr>
                            <td class="text-right">` + (Number(i) + 1) + `</td>
                            <td>` + array.items[i].name + note + `</td>
                            <td class="text-right qty">` + array.items[i].qty + `</td>
                            <td class="text-right price">` + separator(array.items[i].price) + `</td>
                            <td class="text-right total">` + separator(array.items[i].qty * array.items[i].price) + `</td>
                        </tr>`);
                        }
                    }
                    if (array.refund) {
                        $('.is-floating-label').addClass('is-focused');
                        $('#' + array.refund.refund_category.replace(/\s/g, "")).prop('checked', true);
                        $('#refund_price').val(array.refund.refund_price);
                        $('#' + array.refund.refund_method).prop('checked', true);
                        $('#refund_notes').val(array.refund.refund_notes);
                        $('#refund_paid' + array.refundpaid).prop('checked', true);
                        $('#refund_voucher').text(array.refund.refund_voucher);
                        if (Array.isArray(array.refund.file)) {
                            for (let i = 0; i < array.refund.file.length; i++) {
                                $('<input>').attr({
                                    type: 'hidden',
                                    class: 'refund_file',
                                    id: rawurlencode(array.refund.file[i]),
                                    name: 'file',
                                    value: array.refund.file[i]
                                }).appendTo('form');
                            }
                            $.ajax({
                                    url: $('#fileupload').fileupload('option', 'url'),
                                    dataType: 'json',
                                    context: $('#fileupload')[0]
                                })
                                .always(function() {
                                    $(this).removeClass('fileupload-processing');
                                })
                                .done(function(result) {
                                    var obj = {};
                                    var arr = [];
                                    if (array.refund.file) {
                                        for (let i = 0; i < array.refund.file.length; i++) {
                                            var pos = result.files.map(function(e) {
                                                return e.name;
                                            }).indexOf(array.refund.file[i]);
                                            arr.push(result.files[pos]);
                                        }
                                    }
                                    obj['files'] = arr;
                                    $(this)
                                        .fileupload('option', 'done')
                                        .call(this, $.Event('done'), {
                                            result: obj
                                        });
                                });
                        }
                    } else {
                        $('.checked').prop('checked', true);
                        $('.unchecked').prop('checked', false);
                    }
                    $('#_id').val(array._id);
                    $('#transaction_date').text(array.tgl_trx);
                    $('#invno').text(array.invno);
                    $('#customer_name').text(array.customer.name);
                    $('#customer_address').text(array.address);
                    $('#customer_phone').text(array.customer.phone);
                    $('#payment_nominal').text(array.payment_nominal);
                    $('#tgl_krm').text(array.tgl_krm);
                    $('#subtotal').text(separator(array.price.subtotal));
                    $('#shipping').text(separator(array.price.shipping));
                    $('#alltotal').text(separator(array.price.total));
                    $('#modal-form').modal('show');
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                }
            });
        });
        $('#datatable').on('click', '.sendwa', function() {
            var id = $(this).attr('data-id');
            $.ajax({
                type: "POST",
                url: '<?= base_url('refund/sendwa') ?>',
                data: {
                    data: id
                },
                success: function(response) {
                    var array = $.parseJSON(response);
                    window.open('https://api.whatsapp.com/send?phone=' + array.phone + '&text=' + array.text, '_blank');
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                }
            });
        });
    });

    function separator(data) {
        return data.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    function getNameFile(str) {
        return str.split('?file=')[1];
    }

    function rawurlencode(str) {
        str = (str + '').toString();
        return encodeURIComponent(str).replace(/!/g, '%21').replace(/'/g, '%27').replace(/\(/g, '%28').
        replace(/\)/g, '%29').replace(/\*/g, '%2A');
    }

    function getVoucherCode(name, inv) {
        var first3 = name.substring(0, 3);
        var last3 = inv.slice(-4);
        const month = new Array();
        month[0] = "JAN";
        month[1] = "FEB";
        month[2] = "MAR";
        month[3] = "APR";
        month[4] = "MAY";
        month[5] = "JUN";
        month[6] = "JUL";
        month[7] = "AUG";
        month[8] = "SEP";
        month[9] = "OCT";
        month[10] = "NOV";
        month[11] = "DEC";
        const d = new Date();
        var result = month[d.getMonth()] + first3 + last3;
        return result.toUpperCase().replace(/\s/g, "");
    }
</script>