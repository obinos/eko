<!DOCTYPE html>
<html lang="en">

<head>
    <link href="<?= base_url('assets/'); ?>css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= base_url('assets/'); ?>css/animate.min.css" rel="stylesheet">
    <link href="<?= base_url('assets/'); ?>css/style.css" rel="stylesheet">
    <link href="<?= base_url('assets/'); ?>css/<?= getenv("APP_BRAND") ?>.css" rel="stylesheet">
</head>

<body>
    <div class="table-responsive">
        <table id="datatable" class="table table-striped table-sm display" width="100%">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tgl Transaksi</th>
                    <th>Type</th>
                    <th>Qty</th>
                </tr>
            </thead>
        </table>
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
                    "url": "<?= base_url('stock/get_data/?id_item=' . $id_item . '&condition=' . $condition); ?>",
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
                        var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                        return created_date.getDate() + ' ' + months[created_date.getMonth()] + ' ' + parseInt(created_date.getFullYear() - 2000).toString();
                    }
                }, {
                    "data": "type"
                }, {
                    "data": "qty"
                }]
            });
        });
    </script>
</body>

</html>