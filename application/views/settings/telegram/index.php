<link href="<?= base_url('assets/'); ?>vendor/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css" rel="stylesheet" type="text/css">
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12 pad0">
            <div class="ibox ">
                <div class="ibox-title d-flex align-items-center justify-content-between">
                    <h5>Data User Telegram</h5>
                </div>
                <div class="ibox-content">
                    <div class="tabs-container">
                        <div class="table-responsive">
                            <table id="datatable" class="table table-striped table-bordered table-sm display" width="100%">
                                <thead>
                                    <tr>
                                        <th style="width: 8px">No</th>
                                        <th>ID Telegram</th>
                                        <th>Username</th>
                                        <!-- <th>Phone</th> -->
                                        <th>Active</th>
                                        <th>Role</th>
                                        <th>Last Text</th>
                                        <th>Join</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1;
                                    foreach ($telegram as $data) : ?>
                                        <tr class="<?= $data['_id'] ?>">
                                            <td><?= $no++ ?></td>
                                            <td class="id_telegram"><?= $data['id_telegram'] ?></td>
                                            <td class="username"><?= $data['username'] ?></td>
                                            <!-- <td class="phone"><?= $data['phone'] ?></td> -->
                                            <td class="is_active"><?= check_boolean($data['is_active']) ?></td>
                                            <td class="role"><?= implode(', ', $data['role']) ?></td>
                                            <td class="last_text"><?= $data['last_text'] ?></td>
                                            <td class="created_at"><span class="pace-inactive"><?= datephp('Ymd', $data['created_at']) ?></span><?= datephp('d M y', $data['created_at']) ?></td>
                                            <td>
                                                <div class='btn-group btn-group-sm'>
                                                    <a class='btn btn-warning btn_edit' data-tooltip="tooltip" data-placement="top" data-toggle="modal" data-id="<?= $data['_id'] ?>" title="Edit Data" href='#modal-form'>
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
</div>
<div id="modal-form" class="modal fade" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-light">
                <h3 class="modal-title">Edit User</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form role="form" id="form_edit">
                <div class="modal-body pb-1">
                    <div class="row">
                        <div class="col-sm-12">
                            <input type="hidden" id="id">
                            <div class="form-group new-error"><label>Username</label>
                                <input type="text" class="form-control" id="username" name="username">
                                <span class="form-text m-b-none errorusername"></span>
                            </div>
                            <!-- <div class="form-group new-error"><label>Phone</label>
                                <input type="text" class="form-control" id="phone" name="phone">
                                <span class="form-text m-b-none errorphone"></span>
                            </div> -->
                            <div class="form-group new-error"><label>Role</label>
                                <span class="select_pure mb-3"></span>
                            </div>
                            <div class="form-group new-error d-flex align-items-center"><label>Active : </label>
                                <div class="form-check abc-radio abc-radio-primary form-check-inline ml-2">
                                    <input class="form-check-input" type="radio" id="is_activetrue" value="true" name="is_active">
                                    <label class="form-check-label" for="is_activetrue"> True
                                    </label>
                                </div>
                                <div class="form-check abc-radio abc-radio-danger form-check-inline">
                                    <input class="form-check-input" type="radio" id="is_activefalse" value="false" name="is_active">
                                    <label class="form-check-label" for="is_activefalse"> False
                                    </label>
                                </div>
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
<?= toast(); ?>
<?= selectpure(); ?>
<script src="<?= base_url('assets/'); ?>vendor/validate/jquery.validate.min.js"></script>
<script>
    $(document).ready(function() {
        $('#datatable').DataTable({
            pageLength: 25,
            responsive: true,
            dom: '<"html5buttons">lTfgitp'
        });
        var id = $('#id').val();
        $("#form_edit").validate({
            rules: {
                username: {
                    required: true,
                    // },
                    // phone: {
                    //     number: true
                }
            },
            messages: {
                username: {
                    required: "kolom harus diisi."
                    // },
                    // phone: {
                    //     number: "masukkan angka saja."
                }
            },
            errorPlacement: function(error, element) {
                if (element.attr("name") == "username")
                    error.insertAfter(".errorusername");
                // else if (element.attr("name") == "phone")
                //     error.insertAfter(".errorphone");
            },
            submitHandler: function() {
                var object = {};
                var array = [];
                object['_id'] = $('#id').val();
                object['username'] = $('#username').val();
                // object['phone'] = $('#phone').val();
                $('i.select-pure-close').each(function() {
                    var value = $(this).attr('data-value');
                    array.push(value);
                });
                object['role'] = array;
                object['is_active'] = $('input[name=is_active]:checked').val();
                var jsonString = JSON.stringify(object);
                $.ajax({
                    type: "POST",
                    url: '<?= base_url('telegram/update_telegram/') ?>',
                    data: {
                        data: jsonString
                    },
                    success: function(response) {
                        var result = $.parseJSON(response);
                        if (result.status == 'success') {
                            $('tr.' + result._id + ' td.username').text(result.username);
                            // $('tr.' + result._id + ' td.phone').text(result.phone);
                            $('tr.' + result._id + ' td.role').text(result.role);
                            if (result.is_active) {
                                $('tr.' + result._id + ' td.is_active').html(`<svg width="22" height="22" fill="#8ab661" viewBox="0 0 16 16">
                                    <path d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm10.03 4.97a.75.75 0 0 1 .011 1.05l-3.992 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.75.75 0 0 1 1.08-.022z"/>
                                </svg>`);
                            } else {
                                $('tr.' + result._id + ' td.is_active').html(`<svg width="22" height="22" fill="#fd8664" viewBox="0 0 16 16">
                                    <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                                </svg>`);
                            }
                            $.toast({
                                heading: 'Success',
                                text: 'Edit Item ' + result.username,
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
                                text: 'Same Value ' + result.status,
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
        $('.btn_edit').on('click', function(e) {
            var id = $(this).attr('data-id');
            $('#form_edit')[0].reset();
            $('.select_pure').empty();
            $.ajax({
                type: "POST",
                url: '<?= base_url('telegram/get_telegram') ?>',
                data: {
                    data: id
                },
                success: function(response) {
                    var result = $.parseJSON(response);
                    $('.form-control').removeClass('error');
                    $('label.error').remove();
                    $('#id').val(result.user[0]._id);
                    $('#username').val(result.user[0].username);
                    $('#phone').val(result.user[0].phone);
                    var role = result.user[0].role ? result.user[0].role : null;
                    $('#is_active' + result.user[0].is_active.toString() + '[name=is_active]').prop('checked', true);
                    const myOptions = result.code;
                    var instance = new SelectPure(".select_pure", {
                        options: myOptions,
                        multiple: true,
                        // autocomplete: true,
                        value: role,
                        icon: "select-pure-close"
                    });
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                }
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
                        url: '<?= base_url('telegram/delete_telegram') ?>',
                        data: {
                            data: id
                        },
                        success: function(response) {
                            var result = $.parseJSON(response);
                            if (result.status == 'success') {
                                $.toast({
                                    heading: 'Success',
                                    text: 'Delete Data ' + result.username,
                                    icon: 'success',
                                    showHideTransition: 'slide',
                                    hideAfter: 1500,
                                    position: 'top-right',
                                    afterHidden: function() {
                                        $('tr.' + result.id).remove();
                                    }
                                });
                            } else {
                                $.toast({
                                    heading: 'Failed',
                                    text: 'Delete Data ' + result.username,
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