<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12 pad0">
            <div class="ibox ">
                <div class="ibox-title d-flex align-items-center justify-content-between">
                    <h5>Data Cluster</h5>
                    <a class='btn btn-sm btn-primary btn_add' data-tooltip="tooltip" data-placement="top" data-toggle="modal" href='#modal-form'>
                        <svg class="mr-2" width="16px" height="16px" viewBox="0 0 16 16" fill="currentColor">
                            <path fill-rule="evenodd" d="M11 14s1 0 1-1-1-4-6-4-6 3-6 4 1 1 1 1h10zm-9.995-.944v-.002.002zM1.022 13h9.956a.274.274 0 0 0 .014-.002l.008-.002c-.001-.246-.154-.986-.832-1.664C9.516 10.68 8.289 10 6 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664a1.05 1.05 0 0 0 .022.004zm9.974.056v-.002.002zM6 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4zm3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0zm4.5 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5z" />
                            <path fill-rule="evenodd" d="M13 7.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0v-2z" />
                        </svg> Add Cluster</a>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table id="datatable" class="table table-striped table-sm display" width="100%">
                            <thead>
                                <tr>
                                    <th style="width: 8px">Code</th>
                                    <th>Nama</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($cluster as $data) : ?>
                                    <tr id="<?= $data['_id'] ?>">
                                        <td class="itemcode"><?= $data['code'] ?></td>
                                        <td class="itemname"><?= $data['name'] ?></td>
                                        <td>
                                            <div class='btn-group btn-group-sm'>
                                                <a class='btn btn-warning btn_edit' data-tooltip="tooltip" data-placement="top" data-toggle="modal" data-id="<?= $data['_id'] ?>" title="Edit Cluster" href='#modal-form'>
                                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor">
                                                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                                                    </svg>
                                                </a>
                                                <a class='btn btn-danger del-button' data-tooltip="tooltip" data-placement="top" title="Delete" data-id='<?= $data['_id'] ?>'>
                                                    <svg width="16px" height="16px" viewBox="0 0 16 16" fill="currentColor">
                                                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                                                        <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
                                                    </svg>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
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
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <h3 class="m-t-none m-b">Data Cluster</h3>
                        <form role="form" id="form_edit">
                            <input type="hidden" id="id">
                            <div class="form-group new-error"><label>Code</label> <input type="text" class="form-control" id="code" name="code">
                                <span class="form-text m-b-none errorcode"></span>
                            </div>
                            <div class="form-group new-error"><label>Nama</label> <input type="text" class="form-control" id="name" name="name">
                                <span class="form-text m-b-none errorname"></span>
                            </div>
                            <div>
                                <button class="btn btn-sm btn-primary float-right m-t-n-xs" id="submit" type="submit">Submit</button>
                                <button class="btn btn-secondary btn-sm float-right m-t-n-xs mr-2" data-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= core_script(); ?>
<?= datatables(); ?>
<?= toast(); ?>
<script src="<?= base_url('assets/'); ?>vendor/validate/jquery.validate.min.js"></script>
<script>
    $(document).ready(function() {
        $('#datatable').DataTable({
            pageLength: 25,
            responsive: true,
            dom: '<"html5buttons">lTfgitp',
            order: [
                [0, 'asc']
            ]
        });
        $("#form_edit").validate({
            rules: {
                code: {
                    required: true
                },
                name: {
                    required: true,
                    remote: {
                        url: "<?= base_url('cluster/check_cluster/'); ?>",
                        type: "post",
                        data: {
                            id: function() {
                                return $("#id").val();
                            }
                        }
                    }
                }
            },
            messages: {
                code: {
                    required: "kolom harus diisi."
                },
                name: {
                    required: "kolom harus diisi.",
                    remote: "nama sudah terdaftar."
                }
            },
            errorPlacement: function(error, element) {
                if (element.attr("name") == "code")
                    error.insertAfter(".errorcode");
                else if (element.attr("name") == "name")
                    error.insertAfter(".errorname");
            },
            submitHandler: function() {
                var object = {};
                object['_id'] = $('#id').val();
                object['code'] = $('#code').val();
                object['name'] = $('#name').val();
                var jsonString = JSON.stringify(object);
                $.ajax({
                    type: "POST",
                    url: '<?= base_url('cluster/update_cluster/') ?>',
                    data: {
                        data: jsonString
                    },
                    success: function(response) {
                        var result = $.parseJSON(response);
                        if (result.status == 'success') {
                            if (result.action == 'Edit') {
                                $('tr#' + result._id + ' td.itemcode').text(result.code);
                                $('tr#' + result._id + ' td.itemname').text(result.name);
                            } else {
                                $('#datatable tbody').prepend(`
                                <tr id="` + result._id + `">
                                    <td class="itemcode">` + result.code + `</td>
                                    <td class="itemname">` + result.name + `</td>
                                    <td>
                                        <div class='btn-group btn-group-sm'>
                                            <a class='btn btn-warning btn_edit' data-tooltip="tooltip" data-placement="top" data-toggle="modal" data-id="` + result._id + `" title="Edit Cluster" href='#modal-form'>
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
                                text: result.action + ' Cluster ' + result.name,
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
        $('#datatable').on('click', '.btn_edit', function(e) {
            $('.form-control').removeClass('error');
            $('label.error').remove();
            var id = $(this).attr('data-id');
            $('#id').val($(this).attr('data-id'));
            $('#name').val($('tr#' + id + ' td.itemname').text());
            $('#code').val($('tr#' + id + ' td.itemcode').text());
        });
        $('.btn_add').on('click', function(e) {
            $('.form-control').removeClass('error');
            $('label.error').remove();
            $('#id').val('');
            $('#name').val('');
            $('#code').val('');
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
                        url: '<?= base_url('cluster/delete_cluster') ?>',
                        data: {
                            data: id
                        },
                        success: function(response) {
                            var result = $.parseJSON(response);
                            if (result.status == 'success') {
                                $.toast({
                                    heading: 'Success',
                                    text: 'Delete Cluster ' + result.name,
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
                                    text: 'Delete Cluster ' + result.name,
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