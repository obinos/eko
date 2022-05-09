<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12 pad0">
            <div class="ibox ">
                <div class="ibox-content">
                    <form method="post" id="filter_user">
                        <div class="form-row d-flex align-items-end">
                            <div class="col-lg-10 my-1">
                                <p>Status PO</p>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text width46"><svg style="width:20px;height:20px;margin:auto" viewBox="0 0 24 24">
                                                <path fill="#173b60" d="M3,6H21V18H3V6M12,9A3,3 0 0,1 15,12A3,3 0 0,1 12,15A3,3 0 0,1 9,12A3,3 0 0,1 12,9M7,8A2,2 0 0,1 5,10V14A2,2 0 0,1 7,16H17A2,2 0 0,1 19,14V10A2,2 0 0,1 17,8H7Z" />
                                            </svg></div>
                                    </div>
                                    <select name="filter_status" class="form-control" id="filter_status">
                                        <?php foreach ($status as $value) : ?>
                                            <option value="<?= $value; ?>" <?php if ($value == $filter_status) : ?> selected<?php endif; ?>><?= $value; ?></option>
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
                    <h5>Data PO</h5>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table id="datatable" class="table table-striped table-sm display" width="100%">
                            <thead>
                                <tr>
                                    <th style="width: 8px">No</th>
                                    <th>Dibuat</th>
                                    <th>Diedit</th>
                                    <th>Tgl Trx</th>
                                    <th>Nomer PO</th>
                                    <th>Supplier</th>
                                    <th>Status</th>
                                    <th>Maker</th>
                                    <th>Editor</th>
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
                <h3 class="modal-title">View PO</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox ">
                            <div class="d-flex align-items-center justify-content-center mb-2">
                                <!-- <div class='btn-group btn-group-sm text-right'> -->
                                <div class="row">
                                    <div class="col-lg-3 col-6 px-3 py-2">
                                        <button class='btn btn-block btn-secondary realisasiPO btnPO closedPO'>
                                            <svg class="mr-2" width="16" height="16" viewBox="0 0 16 16" fill="currentColor">
                                                <path fill-rule="evenodd" d="M8 7.5a.5.5 0 0 1 .5.5v1.5H10a.5.5 0 0 1 0 1H8.5V12a.5.5 0 0 1-1 0v-1.5H6a.5.5 0 0 1 0-1h1.5V8a.5.5 0 0 1 .5-.5z" />
                                                <path d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1zm3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4h-3.5zM2 5h12v9a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V5z" />
                                            </svg>Add Purchase
                                        </button>
                                    </div>
                                    <div class="col-lg-3 col-6 px-3 py-2">
                                        <button class='btn btn-block btn-info duplicatePO btnPO'>
                                            <svg class="mr-2" width="16" height="16" viewBox="0 0 16 16" fill="currentColor">
                                                <path d="M13 0H6a2 2 0 0 0-2 2 2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h7a2 2 0 0 0 2-2 2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zm0 13V4a2 2 0 0 0-2-2H5a1 1 0 0 1 1-1h7a1 1 0 0 1 1 1v10a1 1 0 0 1-1 1zM3 4a1 1 0 0 1 1-1h7a1 1 0 0 1 1 1v10a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V4z" />
                                            </svg>Duplicate
                                        </button>
                                    </div>
                                    <div class="col-lg-3 col-6 px-3 py-2">
                                        <button class='btn btn-block btn-dark printPO btnPO'>
                                            <svg class="mr-2" width="16" height="16" viewBox="0 0 16 16" fill="currentColor">
                                                <path d="M2.5 8a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z" />
                                                <path d="M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2H5zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4V3zm1 5a2 2 0 0 0-2 2v1H2a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v-1a2 2 0 0 0-2-2H5zm7 2v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1z" />
                                            </svg>Print
                                        </button>
                                    </div>
                                    <div class="col-lg-3 col-6 px-3 py-2">
                                        <button class='btn btn-block btn-success pdfPO btnPO'>
                                            <svg class="mr-2" width="16" height="16" viewBox="0 0 16 16" fill="currentColor">
                                                <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5v2z" />
                                                <path d="M4.603 14.087a.81.81 0 0 1-.438-.42c-.195-.388-.13-.776.08-1.102.198-.307.526-.568.897-.787a7.68 7.68 0 0 1 1.482-.645 19.697 19.697 0 0 0 1.062-2.227 7.269 7.269 0 0 1-.43-1.295c-.086-.4-.119-.796-.046-1.136.075-.354.274-.672.65-.823.192-.077.4-.12.602-.077a.7.7 0 0 1 .477.365c.088.164.12.356.127.538.007.188-.012.396-.047.614-.084.51-.27 1.134-.52 1.794a10.954 10.954 0 0 0 .98 1.686 5.753 5.753 0 0 1 1.334.05c.364.066.734.195.96.465.12.144.193.32.2.518.007.192-.047.382-.138.563a1.04 1.04 0 0 1-.354.416.856.856 0 0 1-.51.138c-.331-.014-.654-.196-.933-.417a5.712 5.712 0 0 1-.911-.95 11.651 11.651 0 0 0-1.997.406 11.307 11.307 0 0 1-1.02 1.51c-.292.35-.609.656-.927.787a.793.793 0 0 1-.58.029zm1.379-1.901c-.166.076-.32.156-.459.238-.328.194-.541.383-.647.547-.094.145-.096.25-.04.361.01.022.02.036.026.044a.266.266 0 0 0 .035-.012c.137-.056.355-.235.635-.572a8.18 8.18 0 0 0 .45-.606zm1.64-1.33a12.71 12.71 0 0 1 1.01-.193 11.744 11.744 0 0 1-.51-.858 20.801 20.801 0 0 1-.5 1.05zm2.446.45c.15.163.296.3.435.41.24.19.407.253.498.256a.107.107 0 0 0 .07-.015.307.307 0 0 0 .094-.125.436.436 0 0 0 .059-.2.095.095 0 0 0-.026-.063c-.052-.062-.2-.152-.518-.209a3.876 3.876 0 0 0-.612-.053zM8.078 7.8a6.7 6.7 0 0 0 .2-.828c.031-.188.043-.343.038-.465a.613.613 0 0 0-.032-.198.517.517 0 0 0-.145.04c-.087.035-.158.106-.196.283-.04.192-.03.469.046.822.024.111.054.227.09.346z" />
                                            </svg>PDF
                                        </button>
                                    </div>
                                    <div class="col-lg-3 col-6 px-3 py-2">
                                        <button class='btn btn-block btn-primary excelBuyer btnPO'>
                                            <svg class="mr-2" width="16" height="16" viewBox="0 0 16 16" fill="currentColor">
                                                <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V9H3V2a1 1 0 0 1 1-1h5.5v2zM3 12v-2h2v2H3zm0 1h2v2H4a1 1 0 0 1-1-1v-1zm3 2v-2h3v2H6zm4 0v-2h3v1a1 1 0 0 1-1 1h-2zm3-3h-3v-2h3v2zm-7 0v-2h3v2H6z" />
                                            </svg>Excel Buyer
                                        </button>
                                    </div>
                                    <div class="col-lg-3 col-6 px-3 py-2">
                                        <button class='btn btn-block btn-primary excelPO btnPO'>
                                            <svg class="mr-2" width="16" height="16" viewBox="0 0 16 16" fill="currentColor">
                                                <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V9H3V2a1 1 0 0 1 1-1h5.5v2zM3 12v-2h2v2H3zm0 1h2v2H4a1 1 0 0 1-1-1v-1zm3 2v-2h3v2H6zm4 0v-2h3v1a1 1 0 0 1-1 1h-2zm3-3h-3v-2h3v2zm-7 0v-2h3v2H6z" />
                                            </svg>Excel Rekap
                                        </button>
                                    </div>
                                    <div class="col-lg-3 col-6 px-3 py-2">
                                        <button class='btn btn-block btn-orange editPO btnPO closedPO'>
                                            <svg class="mr-2" width="16" height="16" viewBox="0 0 16 16" fill="currentColor">
                                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                                            </svg>Edit
                                        </button>
                                    </div>
                                    <div class="col-lg-3 col-6 px-3 py-2">
                                        <button class='btn btn-block btn-danger deletePO btnPO closedPO'>
                                            <svg class="mr-2" width="16" height="16" viewBox="0 0 16 16" fill="currentColor">
                                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                                                <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
                                            </svg>Delete
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="ibox-content content-print">
                                <div class="row justify-content-between d-flex align-items-center mb-2">
                                    <div class="col-8">
                                        <h3 class="text-success my-1" id="pono"></h3>
                                    </div>
                                    <div class="col-4">
                                        <p class="text-success text-right" id="created_at"></p>
                                    </div>
                                </div>
                                <div class="row justify-content-center d-flex align-items-center">
                                    <div class="col-md-6">
                                        <table class="table mb-0">
                                            <tbody>
                                                <tr class="border-bottom">
                                                    <td style="width: 8px">
                                                        <svg style="width:20px;height:20px" viewBox="0 0 24 24">
                                                            <path fill="#909090" d="M5.06 3C4.63 3 4.22 3.14 3.84 3.42S3.24 4.06 3.14 4.5L2.11 8.91C1.86 10 2.06 10.95 2.72 11.77L3 12.05V19C3 19.5 3.2 20 3.61 20.39S4.5 21 5 21H19C19.5 21 20 20.8 20.39 20.39S21 19.5 21 19V12.05L21.28 11.77C21.94 10.95 22.14 10 21.89 8.91L20.86 4.5C20.73 4.06 20.5 3.7 20.13 3.42C19.77 3.14 19.38 3 18.94 3H5.06M18.89 4.97L19.97 9.38C20.06 9.81 19.97 10.2 19.69 10.55C19.44 10.86 19.13 11 18.75 11C18.44 11 18.17 10.9 17.95 10.66C17.73 10.43 17.61 10.16 17.58 9.84L16.97 5L18.89 4.97M5.06 5H7.03L6.42 9.84C6.3 10.63 5.91 11 5.25 11C4.84 11 4.53 10.86 4.31 10.55C4.03 10.2 3.94 9.81 4.03 9.38L5.06 5M9.05 5H11V9.7C11 10.05 10.89 10.35 10.64 10.62C10.39 10.88 10.08 11 9.7 11C9.36 11 9.07 10.88 8.84 10.59S8.5 10 8.5 9.66V9.5L9.05 5M13 5H14.95L15.5 9.5C15.58 9.92 15.5 10.27 15.21 10.57C14.95 10.87 14.61 11 14.2 11C13.89 11 13.61 10.88 13.36 10.62C13.11 10.35 13 10.05 13 9.7V5M7.45 12.05C8.08 12.67 8.86 13 9.8 13C10.64 13 11.38 12.67 12 12.05C12.69 12.67 13.45 13 14.3 13C15.17 13 15.92 12.67 16.55 12.05C17.11 12.67 17.86 13 18.8 13H19.03V19H5V13H5.25C6.16 13 6.89 12.67 7.45 12.05Z" />
                                                        </svg>
                                                    </td>
                                                    <td class="text-left">
                                                        <strong class="empty" id="supplier"></strong>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-md-6">
                                        <table class="table mb-0">
                                            <tbody>
                                                <tr class="border-bottom">
                                                    <td style="width: 8px">
                                                        <svg style="width:20px;height:20px" viewBox="0 0 24 24">
                                                            <path fill="#909090" d="M19,3A2,2 0 0,1 21,5V19A2,2 0 0,1 19,21H5A2,2 0 0,1 3,19V5A2,2 0 0,1 5,3H9.18C9.6,1.84 10.7,1 12,1C13.3,1 14.4,1.84 14.82,3H19M12,3A1,1 0 0,0 11,4A1,1 0 0,0 12,5A1,1 0 0,0 13,4A1,1 0 0,0 12,3M7,7V5H5V19H19V5H17V7H7M11,9H13V13.5H11V9M11,15H13V17H11V15Z" />
                                                        </svg>
                                                    </td>
                                                    <td class="text-left">
                                                        <strong class="empty" id="status"></strong>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-md-12">
                                        <BR>
                                        <div class="table-responsive">
                                            <table class="tablepo table table-striped table-sm display table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 8px">No</th>
                                                        <th>Nama Produk</th>
                                                        <th class="text-right">Qty Beli</th>
                                                        <th>Satuan</th>
                                                        <th class="text-right">Qty Pack</th>
                                                        <th class="text-right">Harga</th>
                                                        <th class="text-right">Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="remove" id="items">
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th class="text-right" colspan="6">Total</th>
                                                        <th class="text-right empty" id="total"></th>
                                                    </tr>
                                                </tfoot>
                                            </table>
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
</div>
<?= core_script(); ?>
<?= datatables(); ?>
<?= select2(); ?>
<?= toast(); ?>
<script src="<?= base_url('assets/'); ?>vendor/printThis/printThis.js"></script>
<script>
    $(document).ready(function() {
        $("#filter_status").select2({
            theme: 'bootstrap4',
            language: 'id'
        });
        $('#datatable').DataTable({
            "pageLength": 50,
            "dom": '<"html5buttons">lTfgitp',
            "processing": true,
            "serverSide": true,
            "order": [
                [4, 'desc']
            ],
            "aLengthMenu": [
                [10, 20, 50, 100, -1],
                [10, 20, 50, 100, 'All']
            ],
            "ajax": {
                "url": "<?= base_url('po/get_po?status=' . $filter_status); ?>",
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
                "data": "created_at",
                render: function(data, type, row, meta) {
                    var created_at = data ? data.slice(-16) : "";
                    return created_at;
                }
            }, {
                "data": "updated_at",
                render: function(data, type, row, meta) {
                    var updated_at = data ? data.slice(-16) : "";
                    return updated_at;
                }
            }, {
                "data": "transaction_date",
                render: function(data, type, row, meta) {
                    var transaction_date = data ? data.slice(-10) : "";
                    return transaction_date;
                }
            }, {
                "data": "pono",
                render: function(data, type, row, meta) {
                    return `<a class='btn_edit text-success' data-id="` + row['_id'] + `">` + data + `</a>`;
                }
            }, {
                "data": "supplier",
                render: function(data, type, row, meta) {
                    var supplier = data ? data : "";
                    return supplier;
                }
            }, {
                "data": "status",
                render: function(data, type, row, meta) {
                    var status = data == 'closed' ? '<span class="text-danger">' + data + '</span' : data;
                    return status;
                }
            }, {
                "data": "usermaker",
                render: function(data, type, row, meta) {
                    var usermaker = data ? data : "";
                    return usermaker;
                }
            }, {
                "data": "userupdate",
                render: function(data, type, row, meta) {
                    var userupdate = data ? data : "";
                    return userupdate;
                }
            }]
        });
        $('#datatable').on('click', '.btn_edit', function() {
            var id = $(this).attr('data-id');
            $('.empty').empty();
            $('.remove').html('');
            $.ajax({
                type: "POST",
                url: '<?= base_url('po/view_po') ?>',
                data: {
                    data: id
                },
                success: function(response) {
                    var array = $.parseJSON(response);
                    for (let i = 0; i < array.items.length; i++) {
                        var notes = array.items[i].notes ? `<br><small>` + array.items[i].notes + `</small>` : ``;
                        $('#items').append(`<tr>
                            <td class="text-right">` + (Number(i) + 1) + `</td>
                            <td>` + array.items[i].name + notes + `</td>
                            <td class="text-right">` + separator(array.items[i].qty_unit) + `</td>
                            <td>` + array.items[i].unit + `</td>
                            <td class="text-right">` + separator(array.items[i].qty) + `</td>
                            <td class="text-right">` + separator(array.items[i].price) + `</td>
                            <td class="text-right">` + separator(array.items[i].total_price) + `</td>
                        </tr>`);
                    }
                    $('.btnPO').attr({
                        'id': array._id,
                        'data-date': array.transaction_date,
                        'data-po': array.pono
                    });
                    $('#created_at').text(array.created);
                    $('#pono').text(array.pono);
                    $('#total').text(separator(array.total));
                    $('#supplier').text(array.supplier);
                    $('#status').text(array.status.toUpperCase());
                    if (array.status == 'closed') {
                        $('.closedPO').hide();
                    } else {
                        $('.closedPO').show();
                    }
                    $('#modal-form').modal('show');
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                }
            });
        });
        $('.realisasiPO').click(function() {
            window.location = "<?= base_url('po/realisasi/') ?>" + this.id;
        });
        $('.duplicatePO').click(function() {
            window.location = "<?= base_url('po/duplicate/') ?>" + this.id;
        });
        $('.editPO').click(function() {
            window.location = "<?= base_url('po/edit/') ?>" + this.id;
        });
        $('.pdfPO').click(function() {
            window.location = "<?= base_url('po/pdf/') ?>" + this.id;
        });
        $('.excelBuyer').click(function() {
            window.location = "<?= base_url('po/excel_buyer/') ?>" + $(this).attr('data-date') + "/" + this.id;
        });
        $('.excelPO').click(function() {
            window.location = "<?= base_url('po/po_excel/') ?>" + $(this).attr('data-date') + "/" + this.id;
        });
        $('.printPO').click(function(e) {
            $(".content-print").printThis();
        });
        $('.deletePO').click(function() {
            $('#modal-form').modal('toggle');
            var datapo = $(this).attr('data-po');
            Swal({
                title: 'Hapus PO ' + datapo + '?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#45eba5',
                cancelButtonColor: '#fd8664',
                confirmButtonText: 'Delete'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        type: "POST",
                        url: '<?= base_url('po/delete_po') ?>',
                        data: {
                            data: this.id
                        },
                        success: function(response) {
                            var result = $.parseJSON(response);
                            if (result.status == 'success') {
                                $.toast({
                                    heading: 'Success',
                                    text: 'Delete PO ' + result.pono,
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
                                    text: 'Delete PO ' + result.pono,
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

    function separator(data) {
        if (data)
            return data.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        else
            return '';
    }
</script>