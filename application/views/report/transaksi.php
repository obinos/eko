<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12 pad0">
            <div class="ibox ">
                <div class="ibox-title d-flex align-items-center justify-content-between">
                    <h5>Data Transaksi Arata</h5>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table id="datatable" class="table table-striped table-sm display" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Date</th>
                                    <th>Nama</th>
                                    <th>No HP</th>
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
<?= datatables(); ?>
<script>
    $('#datatable').DataTable({
        "pageLength": 20,
        "dom": '<"html5buttons">lTfgitp',
        "processing": true,
        "serverSide": true,
        "order": [
            [1, 'desc']
        ],
        "aLengthMenu": [
            [5, 10, 20, 50, 100],
            [5, 10, 20, 50, 100]
        ],
        "ajax": {
            "url": "<?= base_url('arata/get_data/arata_trx'); ?>",
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
                var created_date = new Date(parseInt(data.$date.$numberLong));
                var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                return created_date.getDate() + ' ' + months[created_date.getMonth()] + ' ' + parseInt(created_date.getFullYear() - 2000).toString();
            }
        }, {
            "data": "name"
        }, {
            "data": "phone_number"
        }, {
            "data": "nominal"
        }]
    });
</script>