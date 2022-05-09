<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12 pad0">
            <div class="ibox ">
                <div class="ibox-title d-flex align-items-center justify-content-between">
                    <h5>Data User POS</h5>
                    <a class='btn btn-sm btn-primary btn_add' data-tooltip="tooltip" data-placement="top" data-toggle="modal" href='#modal-form'>
                        <svg class="mr-2" width="14px" height="14px" viewBox="0 0 16 16" fill="currentColor">
                            <path fill-rule="evenodd" d="M11 14s1 0 1-1-1-4-6-4-6 3-6 4 1 1 1 1h10zm-9.995-.944v-.002.002zM1.022 13h9.956a.274.274 0 0 0 .014-.002l.008-.002c-.001-.246-.154-.986-.832-1.664C9.516 10.68 8.289 10 6 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664a1.05 1.05 0 0 0 .022.004zm9.974.056v-.002.002zM6 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4zm3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0zm4.5 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5z" />
                            <path fill-rule="evenodd" d="M13 7.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0v-2z" />
                        </svg>Add User</a>
                </div>
                <div class="ibox-content">
                    <div class="tabs-container">
                        <div class="table-responsive">
                            <table class="table table-striped table-sm display" id="datatable" width="100%">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center">Nama</th>
                                        <th class="text-center">Phone</th>
                                        <th class="text-center">Role</th>
                                        <th class="text-center">Store</th>
                                        <th class="text-center">Join</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1;
                                    foreach ($pos as $data) : ?>
                                        <tr class="<?= $data['_id'] ?>">
                                            <td><?= $no++ ?></td>
                                            <td class="name"><?= $data['name'] ?></td>
                                            <td class="phone"><?= $data['phone'] ?></td>
                                            <td class="role"><?= $data['role'] ?></td>
                                            <td class="store"><?= $data['store'] ?></td>
                                            <td class="created_at"><?= $data['created_at'] ?></td>
                                            <td>
                                                <div class='btn-group btn-group-sm'>
                                                    <a class='btn btn-warning btn_edit' data-tooltip="tooltip" data-placement="top" data-toggle="modal" data-id="<?= $data['_id'] ?>" title="Edit Voucher" href='#modal-form'>
                                                        <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor">
                                                            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                                            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                                                        </svg>
                                                    </a>
                                                    <a class='btn btn-danger del-button' data-tooltip="tooltip" data-placement="top" title="Delete" data-id="<?= $data['_id'] ?>">
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
</div>
<div id="modal-form" class="modal fade" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h3 class="modal-title">Data User</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form role="form" id="form_edit">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <input type="hidden" id="id">
                            <div class="form-group new-error"><label>Nama</label> <input type="text" class="form-control" id="name" name="name">
                                <span class="form-text m-b-none errorname"></span>
                            </div>
                            <div class="form-group new-error"><label>No HP</label>
                                <input type="text" class="form-control" name="phone_number" id="phone_number">
                                <span class="form-text m-b-none errorphone_number"></span>
                            </div>
                            <div class="form-group new-error"><label>Role</label> <select name="role" class="form-control" id="role">
                                    <?php foreach ($role as $s) : ?>
                                        <option value="<?= $s; ?>"><?= $s; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <span class="form-text m-b-none errorrole"></span>
                            </div>
                            <div class="form-group new-error"><label>Store</label> <select name="store" class="form-control" id="store">
                                    <?php foreach ($store as $s) : ?>
                                        <option value="<?= $s['_id']; ?>"><?= $s['name']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <span class="form-text m-b-none errorstore"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button class="btn btn-secondary btn-sm float-right m-t-n-xs mr-2" data-dismiss="modal">Close</button>
                    <button class="btn btn-sm btn-primary float-right m-t-n-xs" id="submit" type="submit">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?= core_script(); ?>
<?= datatables(); ?>
<?= select2(); ?>
<?= toast(); ?>
<script src="<?= base_url('assets/'); ?>vendor/validate/jquery.validate.min.js"></script>
<script>
    $(document).ready(function() {
        $('table.display').DataTable({
            responsive: true,
            pageLength: -1,
            order: [
                [1, 'asc']
            ],
            dom: '<"html5buttons">lTfgitp'
        });
        $("#form_edit").validate({
            rules: {
                phone_number: {
                    required: true,
                    number: true,
                    remote: {
                        url: "<?= base_url('user/check_user/pos'); ?>",
                        type: "post",
                        data: {
                            id: function() {
                                return $("#id").val();
                            }
                        }
                    }
                },
                name: {
                    required: true
                },
                role: {
                    required: true
                },
                store: {
                    required: true
                }
            },
            messages: {
                phone_number: {
                    required: "kolom harus diisi.",
                    remote: "nohp sudah terdaftar.",
                    number: "masukkan angka saja."
                },
                name: {
                    required: "kolom harus diisi."
                },
                role: {
                    required: "kolom harus diisi."
                },
                store: {
                    required: "kolom harus diisi."
                }
            },
            errorPlacement: function(error, element) {
                if (element.attr("name") == "phone_number")
                    error.insertAfter(".errorphone_number");
                else if (element.attr("name") == "name")
                    error.insertAfter(".errorname");
                else if (element.attr("name") == "role")
                    error.insertAfter(".errorrole");
                else if (element.attr("name") == "store")
                    error.insertAfter(".errorstore");
            },
            submitHandler: function() {
                var object = {};
                object['_id'] = $('#id').val();
                object['phone_number'] = $('#phone_number').val();
                object['name'] = $('#name').val();
                object['role'] = $('#role option:selected').val();
                object['id_store'] = $('#store option:selected').val();
                object['store'] = $('#store option:selected').text();
                var jsonString = JSON.stringify(object);
                $.ajax({
                    type: "POST",
                    url: '<?= base_url('user/update_posuser/') ?>',
                    data: {
                        data: jsonString
                    },
                    success: function(response) {
                        var result = $.parseJSON(response);
                        if (result.status == 'success') {
                            if (result.action == 'Edit') {
                                $('tr.' + result._id + ' td.name').text(result.name);
                                $('tr.' + result._id + ' td.phone').text(result.phone);
                                $('tr.' + result._id + ' td.role').text(result.role);
                                $('tr.' + result._id + ' td.store').text(result.store);
                            } else {
                                $('#datatable tbody').prepend(`
                                <tr id="` + result._id + `">
                                    <td>0</td>
                                    <td class="name">` + result.name + `</td>
                                    <td class="phone">` + result.phone + `</td>
                                    <td class="role">` + result.role + `</td>
                                    <td class="store">` + result.store + `</td>
                                    <td class="created_at">` + result.created_at + `</td>
                                    <td>
                                        <div class='btn-group btn-group-sm'>
                                            <a class='btn btn-warning btn_edit' data-tooltip="tooltip" data-placement="top" data-toggle="modal" data-id="` + result._id + `" title="Edit Voucher" href='#modal-form'>
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
                                text: result.action + ' POS User ' + result.name,
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
            var id = $(this).attr('data-id');
            $('#form_edit')[0].reset();
            $('.form-control').removeClass('error');
            $('label.error').remove();
            $.ajax({
                type: "POST",
                url: '<?= base_url('user/get_posuser/') ?>',
                data: {
                    data: id
                },
                success: function(response) {
                    var result = $.parseJSON(response);
                    $('select#store option').removeAttr('selected');
                    $('#id').val(result[0]._id);
                    $('#name').val(result[0].name);
                    $('#phone_number').val(result[0].phone);
                    if (result[0].role)
                        $('option[value=' + result[0].role + ']').attr('selected', 'selected');
                    if (result[0].id_store)
                        $('option[value=' + result[0].id_store + ']').attr('selected', 'selected');
                    $('#modal-form').on('shown.bs.modal', function(e) {
                        $(".select2-container--bootstrap4").removeAttr("style");
                        $("#role").select2({
                            theme: 'bootstrap4',
                            language: 'id'
                        });
                        $("#store").select2({
                            theme: 'bootstrap4',
                            language: 'id'
                        });
                    });
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                }
            });
        });
        $('.btn_add').on('click', function(e) {
            $('.form-control').removeClass('error');
            $('label.error').remove();
            $('#form_edit')[0].reset();
            $('#id').val('');
            $('#modal-form').on('shown.bs.modal', function(e) {
                $(".select2-container--bootstrap4").removeAttr("style");
                $("#role").select2({
                    theme: 'bootstrap4',
                    language: 'id'
                });
                $("#store").select2({
                    theme: 'bootstrap4',
                    language: 'id'
                });
            });
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
                        url: '<?= base_url('user/delete_posuser') ?>',
                        data: {
                            data: id
                        },
                        success: function(response) {
                            var result = $.parseJSON(response);
                            if (result.status == 'success') {
                                $.toast({
                                    heading: 'Success',
                                    text: 'Delete POS User ' + result.name,
                                    icon: 'success',
                                    showHideTransition: 'slide',
                                    hideAfter: 1000,
                                    position: 'top-right',
                                    afterHidden: function() {
                                        $('tr.' + result.id).remove();
                                    }
                                });
                            } else {
                                $.toast({
                                    heading: 'Failed',
                                    text: 'Delete POS User ' + result.name,
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
        });
    });
</script>