<link href="<?= base_url('assets/'); ?>vendor/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css" rel="stylesheet" type="text/css">
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12 pad0">
            <div class="ibox ">
                <div class="ibox-title d-flex align-items-center justify-content-between">
                    <h5>Data Payment Type</h5>
                    <a class='btn btn-sm btn-primary btn_add' data-tooltip="tooltip" data-placement="top" data-toggle="modal" href='#modal-form'>
                        <svg class="mr-2" width="14px" height="14px" viewBox="0 0 16 16" fill="currentColor">
                            <path fill-rule="evenodd" d="M11 14s1 0 1-1-1-4-6-4-6 3-6 4 1 1 1 1h10zm-9.995-.944v-.002.002zM1.022 13h9.956a.274.274 0 0 0 .014-.002l.008-.002c-.001-.246-.154-.986-.832-1.664C9.516 10.68 8.289 10 6 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664a1.05 1.05 0 0 0 .022.004zm9.974.056v-.002.002zM6 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4zm3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0zm4.5 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5z" />
                            <path fill-rule="evenodd" d="M13 7.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0v-2z" />
                        </svg>Add Payment</a>
                </div>
                <div class="ibox-content">
                    <div class="tabs-container">
                        <div class="table-responsive">
                            <table class="table table-striped table-sm display" id="datatable" width="100%">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center">Active</th>
                                        <th class="text-center">Is Payment</th>
                                        <th class="text-center">Created</th>
                                        <th class="text-center">Updated</th>
                                        <th class="text-center">Nama</th>
                                        <th class="text-center">No Account</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1;
                                    foreach ($payment as $data) : ?>
                                        <tr class="<?= $data['_id'] ?>">
                                            <td><?= $no++ ?></td>
                                            <td class="active"><?= check_boolean($data['active']) ?></td>
                                            <td class="is_payment"><?= check_boolean($data['is_payment']) ?></td>
                                            <td class="created_at"><?= datephp('d-m-Y', $data['created_at']) ?></td>
                                            <td class="updated_at"><?= datephp('d-m-Y', $data['updated_at']) ?></td>
                                            <td class="name"><?= $data['name'] ?></td>
                                            <td class="accountno text-right"><?= $data['accountno'] ?></td>
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
                <h3 class="modal-title">Data Payment</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form role="form" id="form_edit">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <input type="hidden" id="id">
                            <div class="row">
                                <div class="col-6">
                                    <label>Active</label>
                                    <div class="form-group new-error d-flex align-items-center">
                                        <div class="form-check abc-radio abc-radio-primary form-check-inline">
                                            <input class="form-check-input" type="radio" id="activetrue" value="true" name="active">
                                            <label class="form-check-label" for="activetrue"> True
                                            </label>
                                        </div>
                                        <div class="form-check abc-radio abc-radio-danger form-check-inline">
                                            <input class="form-check-input" type="radio" id="activefalse" value="false" name="active" checked>
                                            <label class="form-check-label" for="activefalse"> False
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <label>Is Payment</label>
                                    <div class="form-group new-error d-flex align-items-center">
                                        <div class="form-check abc-radio abc-radio-primary form-check-inline">
                                            <input class="form-check-input" type="radio" id="is_paymenttrue" value="true" name="is_payment">
                                            <label class="form-check-label" for="is_paymenttrue"> True
                                            </label>
                                        </div>
                                        <div class="form-check abc-radio abc-radio-danger form-check-inline">
                                            <input class="form-check-input" type="radio" id="is_paymentfalse" value="false" name="is_payment">
                                            <label class="form-check-label" for="is_paymentfalse"> False
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group new-error"><label>Nama</label> <input type="text" class="form-control" id="name" name="name">
                                <span class="form-text m-b-none errorname"></span>
                            </div>
                            <div class="form-group new-error"><label>No Account</label>
                                <input type="text" class="form-control" name="accountno" id="accountno">
                                <span class="form-text m-b-none erroraccountno"></span>
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
                [5, 'asc']
            ],
            dom: '<"html5buttons">lTfgitp'
        });
        $("#form_edit").validate({
            rules: {
                accountno: {
                    number: true,
                    remote: {
                        url: "<?= base_url('payment/check_payment'); ?>",
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
                }
            },
            messages: {
                accountno: {
                    remote: "no account sudah terdaftar.",
                    number: "masukkan angka saja."
                },
                name: {
                    required: "kolom harus diisi."
                }
            },
            errorPlacement: function(error, element) {
                if (element.attr("name") == "accountno")
                    error.insertAfter(".erroraccountno");
                else if (element.attr("name") == "name")
                    error.insertAfter(".errorname");
            },
            submitHandler: function() {
                var object = {};
                object['_id'] = $('#id').val();
                object['accountno'] = $('#accountno').val();
                object['name'] = $('#name').val();
                object['active'] = $('input[name=active]:checked').val();
                object['is_payment'] = $('input[name=is_payment]:checked').val();
                var jsonString = JSON.stringify(object);
                $.ajax({
                    type: "POST",
                    url: '<?= base_url('payment/update_payment/') ?>',
                    data: {
                        data: jsonString
                    },
                    success: function(response) {
                        var result = $.parseJSON(response);
                        if (result.status == 'success') {
                            if (result.action == 'Edit') {
                                if (result.active) {
                                    $('tr.' + result._id + ' td.active').html(`<svg width="22" height="22" fill="#8ab661" viewBox="0 0 16 16">
                                    <path d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm10.03 4.97a.75.75 0 0 1 .011 1.05l-3.992 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.75.75 0 0 1 1.08-.022z"/>
                                </svg>`);
                                } else {
                                    $('tr.' + result._id + ' td.active').html(`<svg width="22" height="22" fill="#fd8664" viewBox="0 0 16 16">
                                    <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                                </svg>`);
                                }
                                if (result.is_payment) {
                                    $('tr.' + result._id + ' td.is_payment').html(`<svg width="22" height="22" fill="#8ab661" viewBox="0 0 16 16">
                                    <path d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm10.03 4.97a.75.75 0 0 1 .011 1.05l-3.992 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.75.75 0 0 1 1.08-.022z"/>
                                </svg>`);
                                } else {
                                    $('tr.' + result._id + ' td.is_payment').html(``);
                                }
                                $('tr.' + result._id + ' td.updated_at').text(result.updated_at);
                                $('tr.' + result._id + ' td.name').text(result.name);
                                $('tr.' + result._id + ' td.accountno').text(result.accountno);
                            } else {
                                if (result.active) {
                                    var active = `<svg width="22" height="22" fill="#8ab661" viewBox="0 0 16 16">
                                    <path d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm10.03 4.97a.75.75 0 0 1 .011 1.05l-3.992 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.75.75 0 0 1 1.08-.022z"/>
                                </svg>`;
                                } else {
                                    var active = `<svg width="22" height="22" fill="#fd8664" viewBox="0 0 16 16">
                                    <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                                </svg>`;
                                }
                                if (result.ispayment) {
                                    var is_payment = `<svg width="22" height="22" fill="#8ab661" viewBox="0 0 16 16">
                                    <path d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm10.03 4.97a.75.75 0 0 1 .011 1.05l-3.992 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.75.75 0 0 1 1.08-.022z"/>
                                </svg>`;
                                } else {
                                    var is_payment = ``;
                                }
                                $('#datatable tbody').prepend(`
                                <tr id="` + result._id + `">
                                    <td>0</td>
                                    <td class="active">` + active + `</td>
                                    <td class="is_payment">` + is_payment + `</td>
                                    <td class="created_at">` + result.created_at + `</td>
                                    <td class="updated_at"></td>
                                    <td class="name">` + result.name + `</td>
                                    <td class="accountno text-right">` + result.accountno + `</td>
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
                                text: result.action + ' Payment ' + result.name,
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
                url: '<?= base_url('payment/get_payment/') ?>',
                data: {
                    data: id
                },
                success: function(response) {
                    var result = $.parseJSON(response);
                    $('#id').val(result[0]._id);
                    $('#name').val(result[0].name);
                    $('#accountno').val(result[0].accountno);
                    $('#active' + result[0].active.toString() + '[name=active]').prop('checked', true);
                    $('#is_payment' + result[0].is_payment.toString() + '[name=is_payment]').prop('checked', true);
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
                        url: '<?= base_url('payment/delete_payment') ?>',
                        data: {
                            data: id
                        },
                        success: function(response) {
                            var result = $.parseJSON(response);
                            if (result.status == 'success') {
                                $.toast({
                                    heading: 'Success',
                                    text: 'Delete Payment ' + result.name,
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
                                    text: 'Delete Payment ' + result.name,
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