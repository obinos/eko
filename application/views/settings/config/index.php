<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12 pad0">
            <div class="ibox ">
                <div class="ibox-title d-flex align-items-center justify-content-between bg-info">
                    <h5>Setting Config</h5>
                </div>
                <div class="ibox-content">
                    <form class="edit_config" id="MAX_LIMIT_ORDER">
                        <div class="form-group  row"><label class="col-sm-2 col-form-label">Max Limit Order</label>
                            <div class="col-sm-10">
                                <div class="input-group">
                                    <input type="hidden" name="_id" value="MAX_LIMIT_ORDER">
                                    <input type="text" class="form-control" id="MAX_LIMIT_ORDER" name="val" value="<?= $config['MAX_LIMIT_ORDER'] ?>"> <span class="input-group-append"> <button type="submit" class="btn btn-primary">Save
                                        </button> </span>
                                </div>
                                <span class="err form-text m-b-none errorvalMAX_LIMIT_ORDER"></span>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                    </form>
                    <div class="form-group  row"><label class="col-sm-2 col-form-label">Free Ongkir</label>
                        <div class="col-sm-10">
                            <input class="switch-input" type="checkbox" name="val" id="FREE_ONGKIR" <?= $config['FREE_ONGKIR'] ? 'checked' : null; ?>>
                            <label class="switch-label" for="FREE_ONGKIR"></label>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
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
        $(".edit_config").each(function() {
            var id = this.id;
            $("#" + id).validate({
                rules: {
                    val: {
                        required: true,
                        number: true
                    }
                },
                messages: {
                    val: {
                        required: "kolom harus diisi.",
                        number: "input angka saja."
                    }
                },
                errorPlacement: function(error, element) {
                    if (element.attr("name") == "val")
                        error.insertAfter(".errorval" + id);
                },
                submitHandler: function() {
                    var object = {};
                    object['_id'] = id;
                    object['val'] = $("#" + id + "[name=val]").val();
                    var jsonString = JSON.stringify(object);
                    $.ajax({
                        type: "POST",
                        url: '<?= base_url('config/update_config') ?>',
                        data: {
                            data: jsonString
                        },
                        success: function(response) {
                            $('input.error').removeClass('error');
                            $('label.error').hide();
                            var result = $.parseJSON(response);
                            if (result.status == 'success') {
                                $('#' + result._id).val(result.val);
                                $.toast({
                                    heading: 'Success',
                                    text: 'Update Value ' + ucwords(result._id),
                                    icon: 'success',
                                    showHideTransition: 'slide',
                                    hideAfter: 1000,
                                    position: 'top-right'
                                });
                            } else {
                                $.toast({
                                    heading: 'Failed',
                                    text: 'Same Value ' + ucwords(result._id),
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
        $('.switch-input').change(function() {
            var object = {};
            object['_id'] = this.id;
            object['val'] = this.checked ? 'true' : 'false';
            var jsonString = JSON.stringify(object);
            $.ajax({
                type: "POST",
                url: '<?= base_url('config/update_config') ?>',
                data: {
                    data: jsonString
                },
                success: function(response) {
                    var result = $.parseJSON(response);
                    if (result.status == 'success') {
                        $.toast({
                            heading: 'Success',
                            text: 'Update Value ' + ucwords(result._id),
                            icon: 'success',
                            showHideTransition: 'slide',
                            hideAfter: 1000,
                            position: 'top-right'
                        });
                    } else {
                        $.toast({
                            heading: 'Failed',
                            text: 'Same Value ' + ucwords(result._id),
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
        });
    });

    function ucwords(string) {
        var id = string.replace(/_/gi, ' ');
        ucword = id.toLowerCase().replace(/\b[a-z]/g, function(letter) {
            return letter.toUpperCase();
        });
        return ucword;
    }
</script>