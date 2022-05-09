<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12 pad0">
            <div class="ibox ">
                <div class="ibox-content">
                    <form method="post" id="filter_user">
                        <div class="form-row d-flex align-items-end">
                            <div class="col-lg-10 my-1">
                                <p>Tanggal Dibuat</p>
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
                    <h5>Data Purchase</h5>
                    <div class='btn-group btn-group-sm'>
                        <a class='btn btn-primary btn-sm' href='<?= base_url(); ?>purchase/add_purchase/'>
                            <svg class="mr-2" width="14px" height="14px" viewBox="0 0 16 16" fill="currentColor">
                                <path fill-rule="evenodd" d="M8 7.5a.5.5 0 0 1 .5.5v1.5H10a.5.5 0 0 1 0 1H8.5V12a.5.5 0 0 1-1 0v-1.5H6a.5.5 0 0 1 0-1h1.5V8a.5.5 0 0 1 .5-.5z" />
                                <path d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1zm3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4h-3.5zM2 5h12v9a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V5z" />
                            </svg>Add Purchase</a>
                    </div>
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
                                    <th>Kode</th>
                                    <th>Supplier</th>
                                    <th class="text-right">Total</th>
                                    <th width="25%">Note</th>
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
<?= core_script(); ?>
<?= datatables(); ?>
<?= datepicker(); ?>
<script>
    $(document).ready(function() {
        $('.input-daterange').datepicker({
            format: 'dd-mm-yyyy',
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
                [4, 'desc']
            ],
            "aLengthMenu": [
                [10, 20, 50, 100, -1],
                [10, 20, 50, 100, 'All']
            ],
            "ajax": {
                "url": "<?= base_url('purchase/get_purchase?start=' . $filter_start . '&end=' . $filter_end); ?>",
                "type": "POST"
            },
            "createdRow": function(row, data, index) {
                if (data.is_cancel) {
                    $(row).addClass('table-danger')
                }
            },
            "columns": [{
                "data": null,
                "sortable": false,
                render: function(data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            }, {
                "data": "created_at1",
                render: function(data, type, row, meta) {
                    return data.slice(-16);
                }
            }, {
                "data": "updated_at",
                render: function(data, type, row, meta) {
                    return data.slice(-16);
                }
            }, {
                "data": "transaction_date",
                render: function(data, type, row, meta) {
                    return data.slice(-10);
                }
            }, {
                "class": "text-right",
                "data": "no",
                render: function(data, type, row, meta) {
                    return `<a href='<?= base_url('purchase/view_purchase/') ?>` + row['_id'] + `'>` + data + `</a>`;
                }
            }, {
                "data": "supplier",
                render: function(data, type, row, meta) {
                    var supplier = data ? data : "";
                    return supplier;
                }
            }, {
                "class": "text-right",
                "data": "total",
                render: $.fn.dataTable.render.number('.', ',', 0, '')
            }, {
                "data": "notes",
                render: function(data, type, row, meta) {
                    var notes = data ? data : "";
                    return notes;
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
    });
</script>