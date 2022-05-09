<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12 pad0">
            <div class="ibox ">
                <div class="ibox-title d-flex align-items-center justify-content-between">
                    <h5>Data Customer</h5>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table id="datatable" class="table table-striped table-sm display" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Join</th>
                                    <th>Nama</th>
                                    <th>Phone</th>
                                    <th>Address</th>
                                    <th>Order</th>
                                    <th>Nominal</th>
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
<?= core_script(); ?>
<?= datatables(); ?>
<script>
    $(document).ready(function() {
        $('#datatable').DataTable({
            "pageLength": 20,
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
                "url": "<?= base_url('customer/get_data'); ?>",
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
                    return data.slice(-10);
                }
            }, {
                "data": "name"
            }, {
                "data": "phone"
            }, {
                "data": "count_address"
            }, {
                "data": "order"
            }, {
                "class": "text-right",
                "data": "total",
                render: $.fn.dataTable.render.number('.', ',', 0, '')
            }, {
                "data": '_id',
                render: function(data, type, row, meta) {
                    return `<div class='btn-group btn-group-sm'>
                    <a class='btn btn-primary' data-tooltip="tooltip" data-placement="top" title="View" href='<?= base_url('customer/view/') ?>` + data + `'>
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor">
                            <path fill-rule="evenodd" d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.134 13.134 0 0 0 1.66 2.043C4.12 11.332 5.88 12.5 8 12.5c2.12 0 3.879-1.168 5.168-2.457A13.134 13.134 0 0 0 14.828 8a13.133 13.133 0 0 0-1.66-2.043C11.879 4.668 10.119 3.5 8 3.5c-2.12 0-3.879 1.168-5.168 2.457A13.133 13.133 0 0 0 1.172 8z" />
                            <path fill-rule="evenodd" d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z" />
                        </svg>
                    </a>
                    </div>`;
                }
            }]
        });
    });
</script>