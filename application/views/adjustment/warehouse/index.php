<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12 pad0">
            <div class="ibox ">
                <div class="ibox-title d-flex align-items-center justify-content-between">
                    <h5>Data Transfer Warehouse</h5>
                    <div class='btn-group btn-group-sm'>
                        <a class='btn btn-primary btn-sm' href='<?= base_url(); ?>adjustment/add_warehouse/'>
                            <svg class="mr-2" width="14px" height="14px" viewBox="0 0 16 16" fill="currentColor">
                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
                            </svg>Add Transfer Warehouse</a>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table id="datatable" class="table table-striped table-sm display" width="100%">
                            <thead>
                                <tr>
                                    <th style="width: 7%">No</th>
                                    <th style="width: 10%">Tanggal</th>
                                    <th style="width: 10%">Kode</th>
                                    <th style="width: 10%">Item</th>
                                    <th style="width: 10%">Maker</th>
                                    <th style="width: 53%">Notes</th>
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
<?= toast(); ?>
<script>
    $(document).ready(function() {
        $('#datatable').DataTable({
            "pageLength": 50,
            "dom": '<"html5buttons">lTfgitp',
            "processing": true,
            "serverSide": true,
            "order": [
                [1, 'desc']
            ],
            "aLengthMenu": [
                [10, 20, 50, 100, -1],
                [10, 20, 50, 100, 'All']
            ],
            "ajax": {
                "url": "<?= base_url('adjustment/get_adjustment/TW'); ?>",
                "type": "POST"
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
                    return data ? data.slice(-16) : "";
                }
            }, {
                "data": "no",
                render: function(data, type, row, meta) {
                    return `<a href='<?= base_url('adjustment/view_warehouse/') ?>` + row['_id'] + `'>` + data + `</a>`;
                }
            }, {
                "class": "text-right",
                "data": "items"
            }, {
                "data": "usermaker",
                render: function(data, type, row, meta) {
                    return data ? data : "";
                }
            }, {
                "data": "notes",
                render: function(data, type, row, meta) {
                    return data ? data : "";
                }
            }]
        });
    });
</script>