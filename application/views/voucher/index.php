<link href="<?= base_url('assets/'); ?>vendor/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css" rel="stylesheet" type="text/css">
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12 pad0">
            <div class="ibox ">
                <div class="ibox-title d-flex align-items-center justify-content-between">
                    <h5>Data Voucher</h5>
                    <a class='btn btn-sm btn-primary btn_add' data-toggle="modal" href='#modal-form'>
                        <svg class="mr-2" width="16px" height="16px" viewBox="0 0 16 16" fill="currentColor">
                            <path fill-rule="evenodd" d="M11 14s1 0 1-1-1-4-6-4-6 3-6 4 1 1 1 1h10zm-9.995-.944v-.002.002zM1.022 13h9.956a.274.274 0 0 0 .014-.002l.008-.002c-.001-.246-.154-.986-.832-1.664C9.516 10.68 8.289 10 6 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664a1.05 1.05 0 0 0 .022.004zm9.974.056v-.002.002zM6 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4zm3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0zm4.5 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5z" />
                            <path fill-rule="evenodd" d="M13 7.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0v-2z" />
                        </svg> Add Voucher</a>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table id="datatable" class="table table-striped table-sm display" width="100%">
                            <thead>
                                <tr>
                                    <th style="width: 8px">No</th>
                                    <th>Public</th>
                                    <th>Code</th>
                                    <th>Expired</th>
                                    <th>Min Order</th>
                                    <th>Limit</th>
                                    <th>Max Usage</th>
                                    <th>Type</th>
                                    <th>Nominal</th>
                                    <th>Update</th>
                                    <th>Maker</th>
                                    <th>Editor</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="modal-view" class="modal fade" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h3 class="modal-title">View Voucher</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <rect x="0" y="0" width="24" height="24" />
                            <circle fill="#328225" opacity="0.3" cx="12" cy="12" r="10" />
                            <path d="M12.0355339,10.6213203 L14.863961,7.79289322 C15.2544853,7.40236893 15.8876503,7.40236893 16.2781746,7.79289322 C16.6686989,8.18341751 16.6686989,8.81658249 16.2781746,9.20710678 L13.4497475,12.0355339 L16.2781746,14.863961 C16.6686989,15.2544853 16.6686989,15.8876503 16.2781746,16.2781746 C15.8876503,16.6686989 15.2544853,16.6686989 14.863961,16.2781746 L12.0355339,13.4497475 L9.20710678,16.2781746 C8.81658249,16.6686989 8.18341751,16.6686989 7.79289322,16.2781746 C7.40236893,15.8876503 7.40236893,15.2544853 7.79289322,14.863961 L10.6213203,12.0355339 L7.79289322,9.20710678 C7.40236893,8.81658249 7.40236893,8.18341751 7.79289322,7.79289322 C8.18341751,7.40236893 8.81658249,7.40236893 9.20710678,7.79289322 L12.0355339,10.6213203 Z" fill="#328225" />
                        </g>
                    </svg>
                </button>
            </div>
            <div class="modal-body">
                <div class="row m-0 ">
                    <div class="col-3 p-1">
                        <div class="card bg-success mb-3">
                            <div class="widget style1">
                                <div class="row align-items-center justify-content-between">
                                    <strong>Baru: </strong>
                                    <strong id="view_baru"></strong>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-3 p-1">
                        <div class="card bg-warning mb-3">
                            <div class="widget style1">
                                <div class="row align-items-center justify-content-between">
                                    <strong>Proses: </strong>
                                    <strong id="view_proses"></strong>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-3 p-1">
                        <div class="card bg-primary mb-3">
                            <div class="widget style1">
                                <div class="row align-items-center justify-content-between">
                                    <strong>Selesai: </strong>
                                    <strong id="view_selesai"></strong>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-3 p-1">
                        <div class="card bg-danger mb-3">
                            <div class="widget style1">
                                <div class="row align-items-center justify-content-between">
                                    <strong>Cancel: </strong>
                                    <strong id="view_cancel"></strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6 pr-1">
                        <table class="table table-striped">
                            <tbody>
                                <tr>
                                    <th scope="row">Code</th>
                                    <td id="view_code"></td>
                                </tr>
                                <tr>
                                    <th scope="row">Expired</th>
                                    <td id="view_expired"></td>
                                </tr>
                                <tr>
                                    <th scope="row">Min Order</th>
                                    <td id="view_min_order"></td>
                                </tr>
                                <tr>
                                    <th scope="row">Pembelian ke-</th>
                                    <td id="view_order_usage"></td>
                                </tr>
                                <tr>
                                    <th scope="row">Limit</th>
                                    <td id="view_limit"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-6 pl-1">
                        <table class="table table-striped">
                            <tbody>
                                <tr>
                                    <th scope="row">Max Usage</th>
                                    <td id="view_max_usage"></td>
                                </tr>
                                <tr>
                                    <th scope="row">Type</th>
                                    <td id="view_type"></td>
                                </tr>
                                <tr>
                                    <th scope="row">Nominal</th>
                                    <td id="view_nominal"></td>
                                </tr>
                                <tr>
                                    <th scope="row">No HP</th>
                                    <td id="view_hp"></td>
                                </tr>
                                <tr>
                                    <th scope="row">Checkout</th>
                                    <td id="view_is_public"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="modal-form" class="modal fade" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h3 class="modal-title">Data Voucher</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form role="form" id="form_edit">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <input type="hidden" id="id">
                            <div class="form-group new-error"><label>Code <svg class="mb-2" width="6" height="6" fill="#fd8664" viewBox="0 0 16 16">
                                        <path d="M8 0a1 1 0 0 1 1 1v5.268l4.562-2.634a1 1 0 1 1 1 1.732L10 8l4.562 2.634a1 1 0 1 1-1 1.732L9 9.732V15a1 1 0 1 1-2 0V9.732l-4.562 2.634a1 1 0 1 1-1-1.732L6 8 1.438 5.366a1 1 0 0 1 1-1.732L7 6.268V1a1 1 0 0 1 1-1z" />
                                    </svg></label> <input type="text" class="form-control" id="code" name="code">
                                <span class="form-text m-b-none errorcode"></span>
                            </div>
                            <div class="form-group new-error"><label>Expired <svg class="mb-2" width="6" height="6" fill="#fd8664" viewBox="0 0 16 16">
                                        <path d="M8 0a1 1 0 0 1 1 1v5.268l4.562-2.634a1 1 0 1 1 1 1.732L10 8l4.562 2.634a1 1 0 1 1-1 1.732L9 9.732V15a1 1 0 1 1-2 0V9.732l-4.562 2.634a1 1 0 1 1-1-1.732L6 8 1.438 5.366a1 1 0 0 1 1-1.732L7 6.268V1a1 1 0 0 1 1-1z" />
                                    </svg></label>
                                <input type="text" class="form-control date" name="expired" id="expired" autocomplete="off">
                                <span class="form-text m-b-none errorexpired"></span>
                            </div>
                            <div class="form-group new-error"><label>Min Order (Rp.) <svg class="mb-2" width="6" height="6" fill="#fd8664" viewBox="0 0 16 16">
                                        <path d="M8 0a1 1 0 0 1 1 1v5.268l4.562-2.634a1 1 0 1 1 1 1.732L10 8l4.562 2.634a1 1 0 1 1-1 1.732L9 9.732V15a1 1 0 1 1-2 0V9.732l-4.562 2.634a1 1 0 1 1-1-1.732L6 8 1.438 5.366a1 1 0 0 1 1-1.732L7 6.268V1a1 1 0 0 1 1-1z" />
                                    </svg></label> <input type="number" class="form-control" id="min_order" name="min_order">
                                <span class="form-text m-b-none errormin_order"></span>
                            </div>
                            <div class="form-group new-error"><label>Pembelian ke- (jika 0, untuk semua customer)</label> <input type="number" class="form-control" id="order_usage" name="order_usage">
                            </div>
                            <div class="form-group new-error"><label>Limit (Jumlah Voucher) <svg class="mb-2" width="6" height="6" fill="#fd8664" viewBox="0 0 16 16">
                                        <path d="M8 0a1 1 0 0 1 1 1v5.268l4.562-2.634a1 1 0 1 1 1 1.732L10 8l4.562 2.634a1 1 0 1 1-1 1.732L9 9.732V15a1 1 0 1 1-2 0V9.732l-4.562 2.634a1 1 0 1 1-1-1.732L6 8 1.438 5.366a1 1 0 0 1 1-1.732L7 6.268V1a1 1 0 0 1 1-1z" />
                                    </svg></label> <input type="number" class="form-control" id="limit" name="limit">
                                <div class="form-check abc-checkbox abc-checkbox-success form-check-inline mt-1 pl-0">
                                    <input class="form-check-input check-item" type="checkbox" id="unlimited" value="unlimited">
                                    <label class="form-check-label voucher" for="unlimited"> unlimited </label>
                                </div>
                                <span class="form-text m-b-none errorlimit"></span>
                            </div>
                            <div class="form-group new-error"><label>Max Usage (per No HP) <svg class="mb-2" width="6" height="6" fill="#fd8664" viewBox="0 0 16 16">
                                        <path d="M8 0a1 1 0 0 1 1 1v5.268l4.562-2.634a1 1 0 1 1 1 1.732L10 8l4.562 2.634a1 1 0 1 1-1 1.732L9 9.732V15a1 1 0 1 1-2 0V9.732l-4.562 2.634a1 1 0 1 1-1-1.732L6 8 1.438 5.366a1 1 0 0 1 1-1.732L7 6.268V1a1 1 0 0 1 1-1z" />
                                    </svg></label> <input type="number" class="form-control" id="max_usage" name="max_usage">
                                <span class="form-text m-b-none errormax_usage"></span>
                            </div>
                            <div class="form-group new-error"><label>Type <svg class="mb-2" width="6" height="6" fill="#fd8664" viewBox="0 0 16 16">
                                        <path d="M8 0a1 1 0 0 1 1 1v5.268l4.562-2.634a1 1 0 1 1 1 1.732L10 8l4.562 2.634a1 1 0 1 1-1 1.732L9 9.732V15a1 1 0 1 1-2 0V9.732l-4.562 2.634a1 1 0 1 1-1-1.732L6 8 1.438 5.366a1 1 0 0 1 1-1.732L7 6.268V1a1 1 0 0 1 1-1z" />
                                    </svg></label> <select name="type" class="form-control" id="type">
                                    <?php foreach ($tipe as $t) : ?>
                                        <option value="<?= $t; ?>"><?= $t; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group new-error"><label>Nominal <svg class="mb-2" width="6" height="6" fill="#fd8664" viewBox="0 0 16 16">
                                        <path d="M8 0a1 1 0 0 1 1 1v5.268l4.562-2.634a1 1 0 1 1 1 1.732L10 8l4.562 2.634a1 1 0 1 1-1 1.732L9 9.732V15a1 1 0 1 1-2 0V9.732l-4.562 2.634a1 1 0 1 1-1-1.732L6 8 1.438 5.366a1 1 0 0 1 1-1.732L7 6.268V1a1 1 0 0 1 1-1z" />
                                    </svg></label> <input type="number" class="form-control" id="nominal" name="nominal">
                                <span class="form-text m-b-none errornominal"></span>
                            </div>
                            <div class="form-group new-error"><label>No HP (Multiple Allowed)</label>
                                <select name="hp" class="form-control" id="hp" multiple="multiple">
                                </select>
                            </div>
                            <label>Ditampilkan di checkout ?</label>
                            <div class="form-group d-flex align-items-center">
                                <div class="form-check abc-radio abc-radio-primary form-check-inline">
                                    <input class="form-check-input" type="radio" id="is_publictrue" value="true" name="is_public">
                                    <label class="form-check-label" for="is_publictrue"> Ya
                                    </label>
                                </div>
                                <div class="form-check abc-radio abc-radio-danger form-check-inline">
                                    <input class="form-check-input" type="radio" id="is_publicfalse" value="false" name="is_public">
                                    <label class="form-check-label" for="is_publicfalse"> Tidak
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <label style="position: absolute;left: 17px;"><svg class="mb-2" width="6" height="6" fill="#fd8664" viewBox="0 0 16 16">
                            <path d="M8 0a1 1 0 0 1 1 1v5.268l4.562-2.634a1 1 0 1 1 1 1.732L10 8l4.562 2.634a1 1 0 1 1-1 1.732L9 9.732V15a1 1 0 1 1-2 0V9.732l-4.562 2.634a1 1 0 1 1-1-1.732L6 8 1.438 5.366a1 1 0 0 1 1-1.732L7 6.268V1a1 1 0 0 1 1-1z" />
                        </svg>required</label>
                    <button class="btn btn-sm btn-primary float-right m-t-n-xs" id="submit" type="submit">Submit</button>
                    <button class="btn btn-secondary btn-sm float-right m-t-n-xs mr-2" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= core_script(); ?>
<?= datatables(); ?>
<?= toast(); ?>
<?= datepicker(); ?>
<?= select2(); ?>
<script src="<?= base_url('assets/'); ?>vendor/validate/jquery.validate.min.js"></script>
<script>
    $(document).ready(function() {
        $('#datatable').DataTable({
            "pageLength": 50,
            "dom": '<"html5buttons">lTfgitp',
            "processing": true,
            "serverSide": true,
            "order": [
                [2, 'asc']
            ],
            "aLengthMenu": [
                [10, 20, 50, 100, -1],
                [10, 20, 50, 100, 'All']
            ],
            "ajax": {
                "url": "<?= base_url('voucher/get_data'); ?>",
                "type": "POST"
            },
            "createdRow": function(row, data, index) {
                $(row).attr('id', data._id);
            },
            "columns": [{
                "data": null,
                "sortable": false,
                render: function(data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            }, {
                "class": "is_public",
                "data": "is_public",
                render: function(data, type, row, meta) {
                    var is_public = data ? `<svg width="22" height="22" fill="#8ab661" viewBox="0 0 16 16">
        <path d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm10.03 4.97a.75.75 0 0 1 .011 1.05l-3.992 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.75.75 0 0 1 1.08-.022z"></path>
      </svg>` : `<svg width="22" height="22" fill="#fd8664" viewBox="0 0 16 16">
        <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"></path>
        <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"></path>
      </svg>`;
                    return is_public;
                }
            }, {
                "class": "code",
                "data": "code"
            }, {
                "class": "expired",
                "data": "expired",
                render: function(data, type, row, meta) {
                    var expired = data ? data.slice(-10) : "";
                    return expired;
                }
            }, {
                "class": "text-right min_order",
                "data": "min_order"
            }, {
                "class": "text-right limit",
                "data": "limit",
                render: function(data, type, row, meta) {
                    var limit = data > 100000 ? 'unlimited' : data;
                    return limit;
                }
            }, {
                "class": "text-right max_usage",
                "data": "max_usage",
                render: function(data, type, row, meta) {
                    var max_usage = data > 100000 ? 'unlimited' : data;
                    return max_usage;
                }
            }, {
                "class": "type",
                "data": "type"
            }, {
                "class": "text-right nominal",
                "data": "nominal",
                render: $.fn.dataTable.render.number('.', ',', 0, '')
            }, {
                "class": "updated_at",
                "data": "updated_at",
                render: function(data, type, row, meta) {
                    var updated_at = data ? data.slice(-10) : "";
                    return updated_at;
                }
            }, {
                "class": "usermaker",
                "data": "usermaker",
                render: function(data, type, row, meta) {
                    var usermaker = data ? data : "";
                    return usermaker;
                }
            }, {
                "class": "userupdate",
                "data": "userupdate",
                render: function(data, type, row, meta) {
                    var userupdate = data ? data : "";
                    return userupdate;
                }
            }, {
                "data": "_id",
                render: function(data, type, row, meta) {
                    return `<div class='btn-group btn-group-sm'>
                        <a class='btn btn-primary btn_view' data-tooltip="tooltip" data-placement="top" data-toggle="modal" data-id=` + data + ` data-code=` + row.code + ` title="View Voucher" href='#modal-view'>
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor">
                                <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z" />
                                <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z" />
                            </svg>
                        </a>
                        <a class='btn btn-warning btn_edit' data-tooltip="tooltip" data-placement="top" data-toggle="modal" data-id=` + data + ` title="Edit Voucher" href='#modal-form'>
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor">
                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                            </svg>
                        </a>
                        <a class='btn btn-danger del-button' data-tooltip="tooltip" data-placement="top" title="Delete" data-id=` + data + ` data-code=` + row.code + `>
                            <svg width="16px" height="16px" viewBox="0 0 16 16" fill="currentColor">
                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                                <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
                            </svg>
                        </a>
                    </div>`;
                }
            }]
        });
        $("#unlimited").click(function() {
            if ($(this).is(":checked"))
                $("#limit").prop("disabled", true);
            else
                $("#limit").prop("disabled", false);
        });
        $("#form_edit").validate({
            rules: {
                code: {
                    required: true,
                    remote: {
                        url: "<?= base_url('voucher/check_voucher/'); ?>",
                        type: "post",
                        data: {
                            id: function() {
                                return $("#id").val();
                            }
                        }
                    }
                },
                expired: {
                    required: true
                },
                min_order: {
                    required: true
                },
                limit: {
                    required: true
                },
                max_usage: {
                    required: true
                },
                nominal: {
                    required: true,
                    number: true
                },
                type: {
                    required: true
                }
            },
            messages: {
                code: {
                    required: "kolom harus diisi.",
                    remote: "nama sudah terdaftar."
                },
                expired: {
                    required: "kolom harus diisi."
                },
                min_order: {
                    required: "kolom harus diisi."
                },
                limit: {
                    required: "kolom harus diisi."
                },
                max_usage: {
                    required: "kolom harus diisi."
                },
                nominal: {
                    required: "kolom harus diisi.",
                    number: "masukkan angka saja."
                },
                type: {
                    required: "kolom harus diisi."
                }
            },
            errorPlacement: function(error, element) {
                if (element.attr("name") == "code")
                    error.insertAfter(".errorcode");
                else if (element.attr("name") == "expired")
                    error.insertAfter(".errorexpired");
                else if (element.attr("name") == "min_order")
                    error.insertAfter(".errormin_order");
                else if (element.attr("name") == "limit")
                    error.insertAfter(".errorlimit");
                else if (element.attr("name") == "max_usage")
                    error.insertAfter(".errormax_usage");
                else if (element.attr("name") == "nominal")
                    error.insertAfter(".errornominal");
                else if (element.attr("name") == "type")
                    error.insertAfter(".errortype");
            },
            submitHandler: function() {
                var object = {};
                var array = [];
                object['_id'] = $('#id').val();
                object['code'] = $('#code').val();
                object['expired'] = $('#expired').val();
                object['min_order'] = $('#min_order').val();
                object['order_usage'] = $('#order_usage').val();
                if ($("#unlimited").is(":checked"))
                    object['limit'] = 'unlimited';
                else
                    object['limit'] = $('#limit').val();
                object['max_usage'] = $('#max_usage').val();
                object['nominal'] = $('#nominal').val();
                object['type'] = $('#type').val();
                $('ul.select2-selection__rendered li.select2-selection__choice').each(function() {
                    var value = $(this).attr('title');
                    array.push(value);
                });
                object['hp'] = array;
                object['is_public'] = $('input[name=is_public]:checked').val();
                var jsonString = JSON.stringify(object);
                $.ajax({
                    type: "POST",
                    url: '<?= base_url('voucher/update_voucher/') ?>',
                    data: {
                        data: jsonString
                    },
                    success: function(response) {
                        var result = $.parseJSON(response);
                        if (result.status == 'success') {
                            var is_public = result.is_public ? `<svg width="22" height="22" fill="#8ab661" viewBox="0 0 16 16">
                                <path d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm10.03 4.97a.75.75 0 0 1 .011 1.05l-3.992 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.75.75 0 0 1 1.08-.022z"></path>
                            </svg>` : `<svg width="22" height="22" fill="#fd8664" viewBox="0 0 16 16">
                                <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"></path>
                                <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"></path>
                            </svg>`;
                            if (result.action == 'Edit') {
                                $('tr#' + result._id + ' td.is_public').html(is_public);
                                $('tr#' + result._id + ' td.code').text(result.code);
                                $('tr#' + result._id + ' td.expired').text(result.expired);
                                $('tr#' + result._id + ' td.min_order').text(result.min_order);
                                $('tr#' + result._id + ' td.limit').text(result.limit);
                                $('tr#' + result._id + ' td.max_usage').text(result.max_usage);
                                $('tr#' + result._id + ' td.nominal').text(result.nominal.toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."));
                                $('tr#' + result._id + ' td.type').text(result.type);
                                $('tr#' + result._id + ' td.updated_at').text(result.updated_at);
                                $('tr#' + result._id + ' td.userupdate').text(result.userupdate);
                            } else {
                                $('#datatable tbody').prepend(`
                                <tr id="` + result._id + `">
                                    <td>0</td>
                                    <td class="is_public">` + is_public + `</td>
                                    <td class="code">` + result.code + `</td>
                                    <td class="expired">` + result.expired1 + `</td>
                                    <td class="text-right min_order">` + result.min_order + `</td>
                                    <td class="text-right limit">` + result.newlimit + `</td>
                                    <td class="text-right max_usage">` + result.max_usage + `</td>
                                    <td class="type">` + result.type + `</td>
                                    <td class="text-right nominal">` + result.nominal.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".") + `</td>
                                    <td class="updated_at">` + result.updated_at1 + `</td>
                                    <td class="usermaker">` + result.usermaker + `</td>
                                    <td class="userupdate"></td>
                                    <td>
                                        <div class='btn-group btn-group-sm'>
                                            <a class='btn btn-warning btn_edit' data-tooltip="tooltip" data-placement="top" data-toggle="modal" data-id="` + result._id + `" title="Edit Voucher" href='#modal-form'>
                                                <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor">
                                                    <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                                    <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                                                </svg>
                                            </a>
                                            <a class='btn btn-danger del-button' data-tooltip="tooltip" data-placement="top" title="Delete" data-id='` + result._id + `'>
                                                <svg width="16px" height="16px" viewBox="0 0 16 16" fill="currentColor">
                                                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                                                    <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
                                                </svg>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                `)
                            }
                            $.toast({
                                heading: 'Success',
                                text: result.action + ' Voucher ' + result.code,
                                icon: 'success',
                                showHideTransition: 'slide',
                                hideAfter: 1000,
                                position: 'top-right',
                                afterHidden: function() {
                                    $('#modal-form').modal('toggle');
                                }
                            });
                        } else {
                            $.toast({
                                heading: 'Failed',
                                text: 'Same Value',
                                icon: 'error',
                                showHideTransition: 'slide',
                                hideAfter: 1000,
                                position: 'top-right'
                            });
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(textStatus, errorThrown);
                    }
                });
            }
        });
        $('#datatable').on('click', '.btn_view', function(e) {
            var id = $(this).attr('data-code');
            $.ajax({
                type: "POST",
                url: '<?= base_url('voucher/view_voucher') ?>',
                data: {
                    data: id
                },
                success: function(response) {
                    var result = $.parseJSON(response);
                    baru = result[0].open ? result[0].open : 0;
                    proses = result[0].onprocess ? result[0].onprocess : 0;
                    selesai = result[0].closed ? result[0].closed : 0;
                    cancel = result[0].canceled ? result[0].canceled : 0;
                    $('#view_code').text(result[0]._id);
                    $('#view_expired').text(result[0].expired1);
                    $('#view_min_order').text(result[0].min_order);
                    $('#view_order_usage').text(result[0].order_usage);
                    $('#view_limit').text(result[0].limit1);
                    $('#view_max_usage').text(result[0].max_usage);
                    $('#view_nominal').text(result[0].nominal);
                    $('#view_type').text(result[0].type);
                    $('#view_hp').text(result[0].hp1);
                    $('#view_is_public').text(result[0].is_public1);
                    $('#view_baru').text(baru);
                    $('#view_proses').text(proses);
                    $('#view_selesai').text(selesai);
                    $('#view_cancel').text(cancel);
                    $('#modal-view').on('shown.bs.modal', function(e) {
                        $('.date').datepicker({
                            todayBtn: "linked",
                            keyboardNavigation: false,
                            forceParse: false,
                            autoclose: true
                        });
                    });
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                }
            });
        });
        $('#datatable').on('click', '.btn_edit', function(e) {
            var id = $(this).attr('data-id');
            $('#form_edit')[0].reset();
            $('#hp').empty();
            $("#limit").prop("disabled", false);
            $('input#nominal').removeAttr('min max');
            $.ajax({
                type: "POST",
                url: '<?= base_url('voucher/get_voucher') ?>',
                data: {
                    data: id
                },
                success: function(response) {
                    var result = $.parseJSON(response);
                    if (result[0].hp) {
                        var hp = '';
                        for (let i = 0; i < result[0].hp.length; i++) {
                            hp = hp + '<option value=' + result[0].hp[i] + ' selected>' + result[0].hp[i] + '</option>';
                        }
                        $('#hp').append(hp);
                    }
                    $('.form-control').removeClass('error');
                    $('label.error').remove();
                    $('select#type option').removeAttr('selected');
                    $('#id').val(result[0]._id);
                    $('#code').val(result[0].code);
                    $('#expired').val(result[0].expired1);
                    $('#min_order').val(result[0].min_order);
                    $('#order_usage').val(result[0].order_usage);
                    $('#limit').val(result[0].limit);
                    $('#max_usage').val(result[0].max_usage);
                    $('#nominal').val(result[0].nominal);
                    $('#is_public' + result[0].is_public.toString() + '[name=is_public]').prop('checked', true);
                    if (result[0].type)
                        $('option[value=' + result[0].type + ']').attr('selected', 'selected');
                    $('select#type').on('change', function() {
                        var val = this.value;
                        if (val == 'percent') {
                            $('input#nominal').attr({
                                'min': 0,
                                'max': 100
                            });
                        } else if (val == 'value') {
                            $('input#nominal').removeAttr('min max');
                        }
                    });
                    $('#modal-form').on('shown.bs.modal', function(e) {
                        $('.date').datepicker({
                            todayBtn: "linked",
                            keyboardNavigation: false,
                            forceParse: false,
                            autoclose: true
                        });
                        $(".select2-container--bootstrap4").removeAttr("style");
                        $("#hp").select2({
                            tags: true,
                            theme: 'bootstrap4',
                            language: 'id'
                        });
                    });
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                }
            });
        });
        $('.btn_add').on('click', function(e) {
            $('.form-control').removeClass('error');
            $("#limit").prop("disabled", false);
            $('label.error').remove();
            $('#form_edit')[0].reset();
            $('#id').val('');
            $('option[value=value]').attr('selected', 'selected');
            $('input#nominal').removeAttr('min max');
            $('select#type').on('change', function() {
                var val = this.value;
                if (val == 'percent') {
                    $('input#nominal').attr({
                        'min': 0,
                        'max': 100
                    });
                } else if (val == 'value') {
                    $('input#nominal').removeAttr('min max');
                }
            });
            $('#modal-form').on('shown.bs.modal', function(e) {
                $('.date').datepicker({
                    todayBtn: "linked",
                    keyboardNavigation: false,
                    forceParse: false,
                    autoclose: true
                });
                $(".select2-container--bootstrap4").removeAttr("style");
                $("#hp").select2({
                    tags: true,
                    theme: 'bootstrap4',
                    language: 'id'
                });
            });
        });
        $('#datatable').on('click', '.del-button', function(e) {
            e.preventDefault();
            var id = $(this).attr('data-id');
            var codevoucher = $(this).attr('data-code');
            Swal({
                title: 'Hapus Voucher<br>' + codevoucher + ' ?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#45eba5',
                cancelButtonColor: '#fd8664',
                confirmButtonText: 'Delete'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        type: "POST",
                        url: '<?= base_url('voucher/delete_voucher') ?>',
                        data: {
                            data: id
                        },
                        success: function(response) {
                            var result = $.parseJSON(response);
                            if (result.status == 'success') {
                                $.toast({
                                    heading: 'Success',
                                    text: 'Delete Voucher ' + result.code,
                                    icon: 'success',
                                    showHideTransition: 'slide',
                                    hideAfter: 1500,
                                    position: 'top-right',
                                    afterHidden: function() {
                                        $('tr#' + result.id).remove();
                                    }
                                });
                            } else {
                                $.toast({
                                    heading: 'Failed',
                                    text: 'Delete Voucher ' + result.code,
                                    icon: 'error',
                                    showHideTransition: 'slide',
                                    hideAfter: 1500,
                                    position: 'top-right'
                                });
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.log(textStatus, errorThrown);
                        }
                    });
                }
            });
        });
    });
</script>