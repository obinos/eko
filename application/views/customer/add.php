<link href="<?= base_url('assets/'); ?>vendor/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css" rel="stylesheet" type="text/css">
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12 pad0">
            <div class="ibox ">
                <div class="ibox-title d-flex align-items-center justify-content-between">
                    <h5>Add Customer</h5>
                </div>
                <div class="ibox-content">
                    <form method="post" id="form">
                        <div class="form-group row"><label class="col-sm-2 col-form-label">Nama</label>
                            <div class="col-sm-10"><input type="text" class="form-control name" name="name"></div>
                        </div>
                        <div class="form-group row"><label class="col-sm-2 col-form-label">No HP</label>
                            <div class="col-sm-10"><input type="text" class="form-control phone" name="phone"></div>
                        </div>
                        <div class="form-group row"><label class="col-sm-2 col-form-label">Preferences</label>
                            <div class="col-sm-10">
                                <select name="preferences" class="form-control" id="preferences" multiple="multiple">
                                    <?php if ($customer[0]['preferences']) {
                                        foreach ($customer[0]['preferences'] as $preferences) { ?>
                                            <option value='<?= $preferences ?>' selected><?= $preferences ?></option>
                                    <?php }
                                    } ?>
                                </select>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-row d-flex align-items-end">
                                    <div class="form-group mb-1 col-2">
                                        <label class="ml-1">Title</label>
                                    </div>
                                    <div class="form-group mb-1 col-4">
                                        <label class="ml-1">Alamat</label>
                                    </div>
                                    <div class="form-group mb-1 col-2">
                                        <label class="ml-1">Cluster</label>
                                    </div>
                                    <div class="form-group mb-1 col-2">
                                        <label class="ml-1">Latitude</label>
                                    </div>
                                    <div class="form-group mb-1 col-2">
                                        <label class="ml-1">Longitude</label>
                                    </div>
                                </div>
                                <?php $time = time(); ?>
                                <div id="inputFormRow">
                                    <div class="form-row">
                                        <div class="form-group col-2">
                                            <input type="text" name="shipping_name[]" class="form-control m-input shipping_name" autocomplete="off" data-id="<?= $time ?>" value="<?= $val->title ?>">
                                        </div>
                                        <div class="form-group col-4">
                                            <div class="input-group m-b">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-addon abcradio">
                                                        <div class="form-check abc-radio abc-radio-success">
                                                            <input class="form-check-input main_address" type="radio" id="check-<?= $time ?>" value="true" data-id="<?= $time ?>" name="main_address" <?= $main_address ?>>
                                                            <label class="form-check-label none" for="check-<?= $time ?>"></label>
                                                        </div>
                                                    </span>
                                                </div>
                                                <input type="text" name="shipping_address[]" class="form-control m-input shipping_address" autocomplete="off" data-id="<?= $time ?>" value="<?= $val->address ?>">
                                            </div>
                                        </div>
                                        <div class="form-group col-2">
                                            <select name="id_cluster[]" class="form-control id_cluster" id="id_cluster" data-id="<?= $time ?>">
                                                <option></option>
                                                <?php foreach ($cluster as $value) : ?>
                                                    <option value="<?= $value['_id']; ?>" <?php if ($value['_id'] == $val->id_cluster) : ?> selected<?php endif; ?>><?= $value['name']; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="form-group col-2">
                                            <input type="text" name="latitude[]" class="form-control m-input latitude" autocomplete="off" data-id="<?= $time ?>" value="<?= $val->latitude ?>">
                                        </div>
                                        <div class="form-group col-2">
                                            <div class="input-group">
                                                <input type="text" name="longitude[]" class="form-control m-input longitude" autocomplete="off" data-id="<?= $time ?>" value="<?= $val->longitude ?>">
                                                <div class="input-group-append">
                                                    <button id="removeRow" type="button" class="btn btn-danger"><svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                                            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                                                            <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
                                                        </svg></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="newRow"></div>
                            </div>
                        </div>
                    </form>
                    <button class="btn btn-warning btn-block" id="submit">Submit</button>
                </div>
            </div>
        </div>
    </div>
</div>
<?= core_script(); ?>
<?= toast(); ?>
<?= select2(); ?>
<script src="<?= base_url('assets/'); ?>vendor/validate/jquery.validate.min.js"></script>
<script>
    $(document).ready(function() {
        $("#preferences").select2({
            tags: true,
            theme: 'bootstrap4',
            language: 'id'
        });
        $(document).on('keypress', '.latitude,.longitude,.shipping_name,.shipping_address,.id_cluster', function(e) {
            if (e.which == 13) {
                var html = '';
                var id = new Date().getTime();
                html += `<div id="inputFormRow">
                        <div class="form-row" id="` + id + `">
                            <div class="form-group col-2">
                                <input type="text" name="shipping_name[]" class="form-control m-input shipping_name" autocomplete="off" data-id="` + id + `">
                            </div>
                            <div class="form-group col-4">
                                <div class="input-group m-b">
                                    <div class="input-group-prepend">
                                        <span class="input-group-addon abcradio">
                                            <div class="form-check abc-radio abc-radio-success">
                                                <input class="form-check-input main_address" type="radio" id="check-` + id + `" value="true" data-id="` + id + `" name="main_address">
                                                <label class="form-check-label none" for="check-` + id + `"></label>
                                            </div>
                                        </span>
                                    </div>
                                    <input type="text" name="shipping_address[]" class="form-control m-input shipping_address" autocomplete="off" data-id="` + id + `">
                                </div>
                            </div>
                            <div class="form-group col-2">
                                <select name="id_cluster[]" class="form-control id_cluster" id="id_cluster" data-id="` + id + `">
                                    <option></option>
                                    <?php foreach ($cluster as $value) : ?>
                                        <option value="<?= $value['_id']; ?>"><?= $value['name']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group col-2">
                                <input type="text" name="latitude[]" class="form-control m-input latitude" autocomplete="off" data-id="` + id + `">
                            </div>
                            <div class="form-group col-2">
                                <div class="input-group">
                                    <input type="text" name="longitude[]" class="form-control m-input longitude" autocomplete="off" data-id="` + id + `">
                                    <div class="input-group-append">
                                        <button id="removeRow" type="button" class="btn btn-danger"><svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                                            <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
                                        </svg></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>`;
                $('#newRow').append(html);
                $('#' + id + ' input.shipping_name').focus()
            }
        });
        $(document).on('click', '#removeRow', function() {
            var inputFormRow = $("div[id*='inputFormRow']").length;
            if (inputFormRow == 1) {
                $('.shipping_name').val('');
                $('.shipping_address').val('');
                $('.latitude').val('');
                $('.longitude').val('');
                $('.id_cluster').val('');
            } else {
                $(this).closest('#inputFormRow').remove();
            }
        });
        $("#form").validate({
            rules: {
                name: {
                    required: true
                },
                phone: {
                    required: true,
                    number: true,
                    remote: {
                        url: "<?= base_url('customer/check_customer/add'); ?>",
                        type: "post"
                    }
                }
            },
            messages: {
                name: {
                    required: "kolom harus diisi."
                },
                phone: {
                    required: "kolom harus diisi.",
                    number: "masukkan angka saja.",
                    remote: "no hp sudah terdaftar."
                }
            },
            submitHandler: function() {
                var object = {};
                var array = [];
                var arr = [];
                object['name'] = $('input[name=name]').val();
                object['phone'] = $('input[name=phone]').val();
                $('ul.select2-selection__rendered li.select2-selection__choice').each(function() {
                    var value = $(this).attr('title');
                    arr.push(value);
                });
                object['preferences'] = arr;
                $('input.shipping_address').each(function() {
                    if ($(this).val() != "") {
                        var id = $(this).attr('data-id');
                        var address = {};
                        address['shipping_name'] = $('.shipping_name[data-id=' + id + ']').val();
                        address['shipping_address'] = $('.shipping_address[data-id=' + id + ']').val();
                        address['main_address'] = $('.main_address[data-id=' + id + ']:checked').val();
                        address['latitude'] = $('.latitude[data-id=' + id + ']').val();
                        address['longitude'] = $('.longitude[data-id=' + id + ']').val();
                        address['id_cluster'] = $('.id_cluster[data-id=' + id + ']').val();
                        array.push(address);
                    }
                });
                object['address'] = array;
                var jsonString = JSON.stringify(object);
                $.ajax({
                    type: "POST",
                    url: '<?= base_url('customer/update_customer/') ?>',
                    data: {
                        data: jsonString
                    },
                    success: function(response) {
                        var result = $.parseJSON(response);
                        if (result.status == 'success') {
                            $.toast({
                                heading: 'Success',
                                text: 'Add Customer',
                                icon: 'success',
                                showHideTransition: 'slide',
                                hideAfter: 1500,
                                position: 'top-right',
                                afterHidden: function() {
                                    window.location = "<?= base_url('customer/list') ?>";
                                }
                            });
                        } else {
                            $.toast({
                                heading: 'Failed',
                                text: result.text,
                                icon: 'error',
                                showHideTransition: 'slide',
                                hideAfter: 1500,
                                position: 'top-right',
                                afterHidden: function() {
                                    $('#submit').prop('disabled', false);
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
        $('#submit').on('click', function(e) {
            $('#submit').prop('disabled', true);
            e.preventDefault();
            Swal({
                title: 'Are You sure?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#45eba5',
                cancelButtonColor: '#fd8664',
                confirmButtonText: 'Submit'
            }).then((result) => {
                if (result.value) {
                    $('#form').submit();
                    $('#submit').prop('disabled', false);
                } else {
                    $('#submit').prop('disabled', false);
                }
            })
        });
    });
</script>