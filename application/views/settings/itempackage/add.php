<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12 pad0">
            <div class="ibox ">
                <div class="ibox-title d-flex align-items-center justify-content-between bg-info">
                    <h5><?= $item[0]['name'] ?></h5>
                </div>
                <div class="ibox-content">
                    <form method="post" id="form">
                        <input type="hidden" name="_id" id="_id" value="<?= $item[0]['_id'] ?>">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-row d-flex align-items-end">
                                    <div class="form-group mb-1 col-7">
                                        <label class="ml-1">Nama Produk</label>
                                    </div>
                                    <div class="form-group mb-1 col-2">
                                        <label class="ml-1">Qty</label>
                                    </div>
                                    <div class="form-group mb-1 col-3">
                                        <label class="ml-1">Satuan</label>
                                    </div>
                                </div>
                                <?php if ($composition) {
                                    foreach ($composition as $com) { ?>
                                        <div id="inputFormRow">
                                            <div class="form-row" id="<?= $com['id_item'] ?>">
                                                <div class="form-group col-7">
                                                    <input type="search" name="name[]" class="form-control m-input typeahead" id="name" autocomplete="off" data-id="<?= $com['id_item'] ?>" value="<?= $com['name'] ?>">
                                                </div>
                                                <div class="form-group col-2">
                                                    <input type="number" name="qty[]" class="form-control m-input qty" id="qty" autocomplete="off" data-id="<?= $com['id_item'] ?>" value="<?= $com['qty'] ?>">
                                                </div>
                                                <div class="form-group col-3">
                                                    <div class="input-group">
                                                        <input type="text" name="unit[]" class="form-control m-input unit" autocomplete="off" data-id="<?= $com['id_item'] ?>" value="<?= $com['unit'] ?>" disabled>
                                                        <div class="input-group-append">
                                                            <button id="removeRow" type="button" class="btn btn-danger" data-id="<?= $com['id_item'] ?>"><svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                                                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                                                                    <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
                                                                </svg></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php }
                                } else { ?>
                                    <div id="inputFormRow">
                                        <div class="form-row" id="first_typeahead">
                                            <div class="form-group col-7">
                                                <input type="search" name="name[]" class="form-control m-input typeahead" id="name" autocomplete="off">
                                            </div>
                                            <div class="form-group col-2">
                                                <input type="number" name="qty[]" class="form-control m-input qty" id="qty" autocomplete="off">
                                            </div>
                                            <div class="form-group col-3">
                                                <div class="input-group">
                                                    <input type="text" name="unit[]" class="form-control m-input unit" autocomplete="off" disabled>
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
                                <?php } ?>
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
<script src="<?= base_url('assets/'); ?>vendor/typehead/bootstrap3-typeahead.min.js"></script>
<script>
    $(document).ready(function() {
        $(document).on('keypress', '.qty', function(e) {
            if (e.which == 13) {
                e.preventDefault();
                var html = '';
                var id = new Date().getTime();
                html += `<div id="inputFormRow">
                        <div class="form-row" id="` + id + `" >
                            <div class="form-group col-7">
                                <input type="search" name="name[]" class="form-control m-input typeahead" id="name" autocomplete="off">
                            </div>
                            <div class="form-group col-2">
                                <input type="number" name="qty[]" class="form-control m-input qty" id="qty" autocomplete="off">
                            </div>
                            <div class="form-group col-3">
                                <div class="input-group">
                                    <input type="text" name="unit[]" class="form-control m-input unit" autocomplete="off" disabled>
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
                typeahead(id);
                $('#' + id + ' input.typeahead').focus()
            }
        });
        $(document).on('click', '#removeRow', function() {
            var id = $(this).attr('data-id');
            var inputFormRow = $("div[id*='inputFormRow']").length;
            if (inputFormRow == 1) {
                $('.typeahead[data-id=' + id + ']').val('');
                $('.qty[data-id=' + id + ']').val('');
                $('.unit[data-id=' + id + ']').val('');
            } else {
                $(this).closest('#inputFormRow').remove();
            }
        });
        <?php if ($composition) {
            foreach ($composition as $com) { ?>
                typeahead('<?= $com['id_item'] ?>');
            <?php }
        } else { ?>
            typeahead('first_typeahead');
        <?php } ?>
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
                    var object = {};
                    var array = [];
                    object['_id'] = $('#_id').val();
                    $('input.qty').each(function() {
                        if ($(this).val() != "") {
                            var item = {};
                            var id = $(this).attr('data-id');
                            item['_id'] = id;
                            item['qty'] = $('.qty[data-id=' + id + ']').val();
                            array.push(item);
                        }
                    });
                    object['item'] = array;
                    var jsonString = JSON.stringify(object);
                    $.ajax({
                        type: "POST",
                        url: '<?= base_url('settings/update_item_package') ?>',
                        data: {
                            data: jsonString
                        },
                        success: function(response) {
                            var result = $.parseJSON(response);
                            if (result.status == 'success') {
                                $.toast({
                                    heading: 'Success',
                                    text: 'Update Item Package',
                                    icon: 'success',
                                    showHideTransition: 'slide',
                                    hideAfter: 1000,
                                    position: 'top-right',
                                    afterHidden: function() {
                                        window.location = "<?= base_url('settings/item_package') ?>";
                                    }
                                });
                            } else {
                                $.toast({
                                    heading: 'Failed',
                                    text: result.text,
                                    icon: 'error',
                                    showHideTransition: 'slide',
                                    hideAfter: 1000,
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
                } else {
                    $('#submit').prop('disabled', false);
                }
            });
        });
    });

    function typeahead(id) {
        $('#' + id + ' input.typeahead').typeahead({
            items: 20,
            source: function(query, process) {
                jQuery.ajax({
                    url: '<?= base_url('settings/data_item/') ?>',
                    type: 'GET',
                    dataType: 'json',
                    success: function(json) {
                        process(json);
                    }
                });
            },
            displayText: function(item) {
                return item.name;
            },
            afterSelect: function(event) {
                $('#' + id + ' input.typeahead').attr('data-id', event._id);
                $('#' + id + ' input.qty').val('').attr('data-id', event._id).focus();
                $('#' + id + ' input.unit').val(event.weight_unit).attr('data-id', event._id);
                $('#' + id + ' button#removeRow').attr('data-id', event._id);
            }
        });
    }
</script>