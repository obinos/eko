<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12 pad0">
            <div class="ibox ">
                <div class="ibox-title d-flex align-items-center justify-content-between">
                    <h5>Data Profit</h5>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table id="datatable" class="table table-striped table-sm display" width="100%">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th class="text-center">Tanggal</th>
                                    <th class="text-center">Total Harga</th>
                                    <th class="text-center">Total HPP</th>
                                    <th class="text-center">Profit</th>
                                </tr>
                            </thead>
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
                <h4 class="modal-title">Detail Profit</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-striped table-sm display" width="100%">
                        <thead>
                            <tr>
                                <th>Station</th>
                                <th>Total Harga</th>
                                <th>Total HPP</th>
                                <th>Profit</th>
                            </tr>
                        </thead>
                        <tbody class="table-modal">
                        </tbody>
                    </table>
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
                "url": "<?= base_url('profit/get_data'); ?>",
                "type": "POST"
            },
            "columns": [{
                "class": "text-right",
                "data": null,
                "sortable": false,
                render: function(data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            }, {
                "class": "text-right",
                "data": "created_at",
                render: function(data, type, row, meta) {
                    return data.slice(-10);
                }
            }, {
                "class": "text-right",
                "data": "totalprice",
                render: $.fn.dataTable.render.number('.', ',', 0, '')
            }, {
                "class": "text-right",
                "data": "totalhpp",
                render: $.fn.dataTable.render.number('.', ',', 0, '')
            }, {
                "class": "text-right",
                "data": "profit",
                render: function(data, type, row, meta) {
                    return `<a class="profit" data-toggle="modal" href='#modal-form' data-id=` + row['_id'] + `>` + data + `</a>`;
                }
            }]
        });
        $('#datatable').on('click', '.profit', function(e) {
            $(".table-modal").empty();
            $.ajax({
                type: "POST",
                url: '<?= base_url('profit/get_profit') ?>',
                data: {
                    data: $(this).attr('data-id')
                },
                success: function(response) {
                    var result = $.parseJSON(response);
                    for (var i = 0; i < result[0].detail.length; i++) {
                        $(".table-modal").append(`
                            <tr>
                                <td>` + result[0].detail[i].station + `</td>
                                <td class="text-right">` + result[0].detail[i].totalprice.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".") + `</td>
                                <td class="text-right">` + result[0].detail[i].totalhpp.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".") + `</td>
                                <td class="text-right">` + result[0].detail[i].profit + `</td>
                            </tr>`);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                }
            });
        });
    });
</script>