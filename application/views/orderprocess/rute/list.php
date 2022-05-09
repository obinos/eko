<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12 pad0">
            <div class="ibox ">
                <div class="ibox-title d-flex align-items-center justify-content-between">
                    <h5>Data Urutan Kurir</h5>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table id="datatable" class="table table-striped table-sm display" width="100%">
                            <thead>
                                <tr>
                                    <th style="width: 8px">No</th>
                                    <th>Create</th>
                                    <th>Tgl Kirim</th>
                                    <th>Editor</th>
                                    <th>Kurir</th>
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
                "url": "<?= base_url('orderprocess/get_data'); ?>",
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
                "data": "delivery_time",
                render: function(data, type, row, meta) {
                    var delivery_time = data ? data.slice(-10) : "";
                    return delivery_time;
                }
            }, {
                "data": "user",
                render: function(data, type, row, meta) {
                    var user = data ? data : "";
                    return user;
                }
            }, {
                "data": "courier"
            }, {
                "data": "_id",
                render: function(data, type, row, meta) {
                    return `<div class='btn-group btn-group-sm'>
                        <a class='btn btn-warning' data-tooltip="tooltip" data-placement="top" title="Edit Rute" href='<?= base_url('orderprocess/edit_rute/') ?>` + data + `'>
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor">
                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                            </svg>
                        </a>
                        <a class='btn btn-danger del-button' data-tooltip="tooltip" data-placement="top" title="Delete" data-id=` + data + `>
                            <svg width="16px" height="16px" viewBox="0 0 16 16" fill="currentColor">
                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                                <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
                            </svg>
                        </a>
                    </div>`;
                }
            }]
        });
        $('#datatable').on('click', '.del-button', function(e) {
            e.preventDefault();
            var id = $(this).attr('data-id');
            Swal({
                title: 'Are You sure?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#45eba5',
                cancelButtonColor: '#fd8664',
                confirmButtonText: 'Delete'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        type: "POST",
                        url: '<?= base_url('orderprocess/delete_rute') ?>',
                        data: {
                            data: id
                        },
                        success: function(response) {
                            var result = $.parseJSON(response);
                            if (result.status == 'success') {
                                $.toast({
                                    heading: 'Success',
                                    text: 'Delete Rute',
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
                                    text: 'Delete Rute',
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