<link href="<?= base_url('assets/'); ?>vendor/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css" rel="stylesheet" type="text/css">
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12 pad0">
            <div class="ibox ">
                <div class="ibox-title collapse-link">
                    <h5>Add Data Telegram</h5>
                    <div class="ibox-tools">
                        <a>
                            <span class="fa arrow"></span>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <form method="post" id="add_message">
                        <input type="hidden" id="app" name="app" value="telegram">
                        <div class="form-group row"><label class="col-sm-2 col-form-label">Code</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="code" name="code">
                            </div>
                        </div>
                        <div class="form-group row"><label class="col-sm-2 col-form-label">Desc</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="desc" name="desc">
                            </div>
                        </div>
                        <div class="form-group row"><label class="col-sm-2 col-form-label">Message</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" rows="9" id="message" name="message"></textarea>
                            </div>
                        </div>
                        <div class="form-group row"><label class="col-sm-2 col-form-label">Validation</label>
                            <div class="col-sm-10">
                                <div class="form-check abc-radio abc-radio-primary form-check-inline ml-2">
                                    <input class="form-check-input" type="radio" id="activetrue" value="true" name="validation">
                                    <label class="form-check-label" for="activetrue"> True
                                    </label>
                                </div>
                                <div class="form-check abc-radio abc-radio-danger form-check-inline">
                                    <input class="form-check-input" type="radio" id="activefalse" value="false" name="validation">
                                    <label class="form-check-label" for="activefalse" checked> False
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-4 col-sm-offset-2 mt-2">
                                <button class="btn btn-primary btn-sm" type="submit">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= core_script(); ?>
<?= toast(); ?>
<script src="<?= base_url('assets/'); ?>vendor/validate/jquery.validate.min.js"></script>
<script>
    $(document).ready(function() {
        $("#add_message").validate({
            rules: {
                code: {
                    required: true,
                    remote: {
                        url: "<?= base_url('message/check_message/telegram'); ?>",
                        type: "post",
                        data: {
                            id: function() {
                                return null;
                            }
                        }
                    }
                },
                message: {
                    required: true
                }
            },
            messages: {
                code: {
                    required: "kolom harus diisi.",
                    remote: "code sudah terdaftar."
                },
                message: {
                    required: "kolom harus diisi."
                }
            },
            submitHandler: function() {
                $('button[type="submit"]').attr('disabled', 'disabled');
                var object = {};
                object['app'] = $('#app').val();
                object['code'] = $('#code').val();
                object['desc'] = $('#desc').val();
                object['message'] = $('#message').val();
                object['validation'] = $('input[name=validation]:checked').val();
                var jsonString = JSON.stringify(object);
                $.ajax({
                    type: "POST",
                    url: '<?= base_url('message/update_message') ?>',
                    data: {
                        data: jsonString
                    },
                    success: function(response) {
                        $('#add_message')[0].reset();
                        var result = $.parseJSON(response);
                        console.log(result);
                        if (result.status == 'success') {
                            $.toast({
                                heading: 'Success',
                                text: 'Add Message ' + result.code,
                                icon: 'success',
                                showHideTransition: 'slide',
                                hideAfter: 1500,
                                position: 'top-right',
                                afterHidden: function() {
                                    window.location = "<?= base_url('message/telegram') ?>";
                                }
                            });
                        } else {
                            $.toast({
                                heading: 'Failed',
                                text: 'Same Value',
                                icon: 'error',
                                showHideTransition: 'slide',
                                hideAfter: 1500,
                                position: 'top-right',
                                afterHidden: function() {
                                    $('button[type="submit"]').removeAttr('disabled');
                                }
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
</script>