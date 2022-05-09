<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12 pad0">
            <div class="ibox ">
                <div class="ibox-title d-flex align-items-center justify-content-between">
                    <h5>Data Voucher</h5>
                    <div class='btn-group btn-group-sm'>
                        <a class='btn btn-primary btn-sm' href='<?= base_url(); ?>voucher/' data-tooltip="tooltip" data-placement="top" title="Setting Voucher">
                            <svg width="16px" height="16px" viewBox="0 0 16 16" fill="currentColor">
                                <path d="M8 4.754a3.246 3.246 0 1 0 0 6.492 3.246 3.246 0 0 0 0-6.492zM5.754 8a2.246 2.246 0 1 1 4.492 0 2.246 2.246 0 0 1-4.492 0z" />
                                <path d="M9.796 1.343c-.527-1.79-3.065-1.79-3.592 0l-.094.319a.873.873 0 0 1-1.255.52l-.292-.16c-1.64-.892-3.433.902-2.54 2.541l.159.292a.873.873 0 0 1-.52 1.255l-.319.094c-1.79.527-1.79 3.065 0 3.592l.319.094a.873.873 0 0 1 .52 1.255l-.16.292c-.892 1.64.901 3.434 2.541 2.54l.292-.159a.873.873 0 0 1 1.255.52l.094.319c.527 1.79 3.065 1.79 3.592 0l.094-.319a.873.873 0 0 1 1.255-.52l.292.16c1.64.893 3.434-.902 2.54-2.541l-.159-.292a.873.873 0 0 1 .52-1.255l.319-.094c1.79-.527 1.79-3.065 0-3.592l-.319-.094a.873.873 0 0 1-.52-1.255l.16-.292c.893-1.64-.902-3.433-2.541-2.54l-.292.159a.873.873 0 0 1-1.255-.52l-.094-.319zm-2.633.283c.246-.835 1.428-.835 1.674 0l.094.319a1.873 1.873 0 0 0 2.693 1.115l.291-.16c.764-.415 1.6.42 1.184 1.185l-.159.292a1.873 1.873 0 0 0 1.116 2.692l.318.094c.835.246.835 1.428 0 1.674l-.319.094a1.873 1.873 0 0 0-1.115 2.693l.16.291c.415.764-.42 1.6-1.185 1.184l-.291-.159a1.873 1.873 0 0 0-2.693 1.116l-.094.318c-.246.835-1.428.835-1.674 0l-.094-.319a1.873 1.873 0 0 0-2.692-1.115l-.292.16c-.764.415-1.6-.42-1.184-1.185l.159-.291A1.873 1.873 0 0 0 1.945 8.93l-.319-.094c-.835-.246-.835-1.428 0-1.674l.319-.094A1.873 1.873 0 0 0 3.06 4.377l-.16-.292c-.415-.764.42-1.6 1.185-1.184l.292.159a1.873 1.873 0 0 0 2.692-1.115l.094-.319z" />
                            </svg></a>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table id="datatable" class="table table-bordered table-striped table-sm display" width="100%">
                            <thead>
                                <tr>
                                    <th class="align-middle text-center" rowspan="2">No</th>
                                    <th class="align-middle text-center" rowspan="2">Code</th>
                                    <th class="align-middle text-center" rowspan="2">Type</th>
                                    <th class="align-middle text-center" rowspan="2">Nominal</th>
                                    <th class="text-center" colspan="4">Usage</th>
                                    <th class="align-middle text-center" rowspan="2">Total Usage</th>
                                </tr>
                                <tr>
                                    <th class="text-center">Baru</th>
                                    <th class="text-center">Proses</th>
                                    <th class="text-center">Selesai</th>
                                    <th class="text-center">Batal</th>
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
            <div class="modal-header">
                <h4 class="modal-title"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-striped table-sm display" width="100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Invoice</th>
                                <th>Nama</th>
                                <th>Total</th>
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
                [1, 'asc']
            ],
            "aLengthMenu": [
                [10, 20, 50, 100, -1],
                [10, 20, 50, 100, 'All']
            ],
            "ajax": {
                "url": "<?= base_url('voucher/get_data_report'); ?>",
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
                "data": "_id",
                render: function(data, type, row, meta) {
                    var _id = data ? data : "";
                    return _id;
                }
            }, {
                "data": "type",
                render: function(data, type, row, meta) {
                    var ty = data ? data : "";
                    return ty;
                }
            }, {
                "class": "text-right",
                "data": "nominal",
                render: function(data, type, row, meta) {
                    var ty = data ? separator(data) : "";
                    return ty;
                }
            }, {
                "class": "text-right",
                "data": "open",
                render: function(data, type, row, meta) {
                    var ty = data ? data : "0";
                    return `<a class='voucher' data-toggle='modal' href='#modal-form' data-code='` + row._id + `' data-status='open'>` + ty + `</a>`;
                }
            }, {
                "class": "text-right",
                "data": "onprocess",
                render: function(data, type, row, meta) {
                    var ty = data ? data : "0";
                    return `<a class='voucher' data-toggle='modal' href='#modal-form' data-code='` + row._id + `' data-status='onprocess'>` + ty + `</a>`;
                }
            }, {
                "class": "text-right",
                "data": "closed",
                render: function(data, type, row, meta) {
                    var ty = data ? data : "0";
                    return `<a class='voucher' data-toggle='modal' href='#modal-form' data-code='` + row._id + `' data-status='closed'>` + ty + `</a>`;
                }
            }, {
                "class": "text-right",
                "data": "canceled",
                render: function(data, type, row, meta) {
                    var ty = data ? data : "0";
                    return `<a class='voucher' data-toggle='modal' href='#modal-form' data-code='` + row._id + `' data-status='canceled'>` + ty + `</a>`;
                }
            }, {
                "class": "text-right",
                "data": "total_usage",
                render: function(data, type, row, meta) {
                    var ty = data ? data : "";
                    return ty;
                }
            }]
        });
        $('#datatable').on('click', '.voucher', function(e) {
            $(".modal-title").text($(this).attr('data-code') + ' - ' + $(this).attr('data-status').toUpperCase());
            $(".table-modal").empty();
            var object = {};
            object['code'] = $(this).attr('data-code');
            object['status'] = $(this).attr('data-status');
            var jsonString = JSON.stringify(object);
            $.ajax({
                type: "POST",
                url: '<?= base_url('voucher/get_order') ?>',
                data: {
                    data: jsonString
                },
                success: function(response) {
                    var result = $.parseJSON(response);
                    for (var i = 0; i < result.data.length; i++) {
                        var no = i + 1;
                        $(".table-modal").append(`
                            <tr>
                                <td>` + no + `</td>
                                <td><a href='<?= base_url('voucher/view_order/') ?>` + result.data[i]._id + `'>` + result.data[i].invno + `</a></td>
                                <td>` + result.data[i].customer.name + `</td>
                                <td class="text-right">` + result.data[i].price.total.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".") + `</td>
                            </tr>`);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                }
            });
        });
    });

    function separator(data) {
        if (data)
            return data.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        else
            return data;
    }
</script>