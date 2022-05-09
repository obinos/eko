<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12 pad0">
            <div class="ibox ">
                <div class="ibox-content">
                    <div class="form-row d-flex align-items-end">
                        <div class="col-lg-6 my-1">
                            <p>Asal Warehouse / Store</p>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text width46"><svg style="width:20px;height:20px;margin:auto" viewBox="0 0 24 24">
                                            <path fill="#173b60" d="M6 19H8V21H6V19M12 3L2 8V21H4V13H20V21H22V8L12 3M8 11H4V9H8V11M14 11H10V9H14V11M20 11H16V9H20V11M6 15H8V17H6V15M10 15H12V17H10V15M10 19H12V21H10V19M14 19H16V21H14V19Z" />
                                        </svg></div>
                                </div>
                                <select name="filter_store1" class="form-control" id="filter_store1">
                                    <option></option>
                                    <?php foreach ($store as $s) : ?>
                                        <option value="<?= $s['_id']; ?>" <?php if ($s['_id'] == $filter_store1) : ?> selected<?php endif; ?>><?= $s['name']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6 my-1">
                            <p>Menuju Warehouse / Store</p>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text width46"><svg style="width:20px;height:20px;margin:auto" viewBox="0 0 24 24">
                                            <path fill="#173b60" d="M6 19H8V21H6V19M12 3L2 8V21H4V13H20V21H22V8L12 3M8 11H4V9H8V11M14 11H10V9H14V11M20 11H16V9H20V11M6 15H8V17H6V15M10 15H12V17H10V15M10 19H12V21H10V19M14 19H16V21H14V19Z" />
                                        </svg></div>
                                </div>
                                <select name="filter_store2" class="form-control" id="filter_store2">
                                    <option></option>
                                    <?php foreach ($store as $s) : ?>
                                        <option value="<?= $s['_id']; ?>" <?php if ($s['_id'] == $filter_store2) : ?> selected<?php endif; ?>><?= $s['name']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 pad0">
            <div class="ibox ">
                <div class="ibox-title d-flex align-items-center justify-content-between">
                    <h5>Input Transfer Warehouse</h5>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-row d-flex align-items-end">
                                <div class="form-group mb-1 col-5 col-sm-8">
                                    <label class="ml-1">Nama Produk</label>
                                </div>
                                <div class="form-group mb-1 col-2 col-sm-1">
                                    <label class="ml-1">Awal</label>
                                </div>
                                <div class="form-group mb-1 col-2 col-sm-1">
                                    <label class="ml-1">Transfer</label>
                                </div>
                                <div class="form-group mb-1 col-3 col-sm-2">
                                    <label class="ml-1">Akhir</label>
                                </div>
                            </div>
                            <div id="inputFormRow">
                                <div class="form-row" id="first_typeahead">
                                    <div class="form-group col-5 col-sm-8">
                                        <input type="search" name="name[]" class="form-control m-input typeahead" id="name" autocomplete="off">
                                    </div>
                                    <div class="form-group col-2 col-sm-1">
                                        <input type="number" name="awal[]" class="form-control m-input text-right awal" autocomplete="off" disabled>
                                    </div>
                                    <div class="form-group col-2 col-sm-1">
                                        <input type="number" name="transfer[]" class="form-control m-input text-right transfer" autocomplete="off">
                                    </div>
                                    <div class="form-group col-3 col-sm-2">
                                        <div class="input-group">
                                            <input type="number" name="akhir[]" class="form-control m-input akhir text-right" autocomplete="off" disabled>
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
                            <a class="btn btn-primary text-dark" id="addrow"><svg width="16px" height="16px" viewBox="0 0 16 16" class="mr-2" fill="currentColor">
                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                    <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
                                </svg>Add Row</a>
                        </div>
                    </div>
                    <div class="hr-line-dashed"></div>
                    <div class="is-floating-label mb-3">
                        <label class="form-label">Note</label>
                        <textarea class="form-control" rows="2" name="notes"></textarea>
                    </div>
                    <button class="btn btn-warning btn-block" id="submit">Submit</button>
                </div>
            </div>
        </div>
    </div>
</div>
<?= core_script(); ?>
<?= select2(); ?>
<?= toast(); ?>
<script src="<?= base_url('assets/'); ?>vendor/typehead/bootstrap3-typeahead.min.js"></script>
<script>
    $(document).ready(function() {
        $("#filter_store1").select2({
            placeholder: 'Pilih Store',
            theme: 'bootstrap4',
            language: 'id'
        });
        $("#filter_store2").select2({
            placeholder: 'Pilih Store',
            theme: 'bootstrap4',
            language: 'id'
        });
        $('#filter_store1, #filter_store2').on('change', function() {
            if ($('#filter_store1').val() == $('#filter_store2').val()) {
                $.toast({
                    heading: 'Failed',
                    text: 'Warehouse / Store sama',
                    icon: 'error',
                    showHideTransition: 'slide',
                    hideAfter: 1500,
                    position: 'top-right',
                    afterHidden: function() {
                        $('#submit, .typeahead, .transfer').prop('disabled', true);
                    }
                });
            } else {
                window.location = "<?= base_url('adjustment/add_warehouse?filter_store1=') ?>" + $('#filter_store1').val() + "&filter_store2=" + $('#filter_store2').val();
            }
        });
        $('.is-floating-label input, .is-floating-label textarea').on('focus blur', function(e) {
            $(this).parents('.is-floating-label').toggleClass('is-focused', (e.type === 'focus' || this.value.length > 0));
        }).trigger('blur');
        $(document).on('keypress', '.transfer', function(e) {
            if (e.which == 13) {
                addrow();
            }
        });
        $('#addrow').on('click', function(e) {
            addrow();
        });
        $(document).on('click', '#removeRow', function() {
            var id = $(this).attr('data-id');
            var inputFormRow = $("div[id*='inputFormRow']").length;
            if (inputFormRow == 1) {
                $('.typeahead[data-id=' + id + ']').val('');
                $('.awal[data-id=' + id + ']').val('');
                $('.transfer[data-id=' + id + ']').val('');
                $('.akhir[data-id=' + id + ']').val('');
            } else {
                $(this).closest('#inputFormRow').remove();
            }
        });
        typeahead('first_typeahead');
        math('first_typeahead');
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
                    $('input.typeahead').each(function() {
                        var item = {};
                        var id = $(this).attr('data-id');
                        item['_id'] = id;
                        item['awal'] = $('.awal[data-id=' + id + ']').val();
                        item['transfer'] = $('.transfer[data-id=' + id + ']').val();
                        item['akhir'] = $('.akhir[data-id=' + id + ']').val();
                        array.push(item);
                    });
                    object['store1'] = $('#filter_store1').val();
                    object['store2'] = $('#filter_store2').val();
                    object['item'] = array;
                    object['notes'] = $('textarea[name=notes').val();
                    var jsonString = JSON.stringify(object);
                    $.ajax({
                        type: "POST",
                        url: '<?= base_url('adjustment/update_warehouse') ?>',
                        data: {
                            data: jsonString
                        },
                        success: function(response) {
                            var result = $.parseJSON(response);
                            if (result.status == 'success') {
                                $.toast({
                                    heading: 'Success',
                                    text: 'Add Transfer Warehouse',
                                    icon: 'success',
                                    showHideTransition: 'slide',
                                    hideAfter: 1500,
                                    position: 'top-right',
                                    afterHidden: function() {
                                        window.location = "<?= base_url('adjustment/warehouse') ?>";
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
                } else {
                    $('#submit').prop('disabled', false);
                }
            });
        });
    });

    function addrow() {
        var html = '';
        var id = new Date().getTime();
        html += `<div id="inputFormRow">
            <div class="form-row" id="` + id + `" >
                <div class="form-group col-5 col-sm-8">
                    <input type="search" name="name[]" class="form-control m-input typeahead" id="name" autocomplete="off">
                </div>
                <div class="form-group col-2 col-sm-1">
                    <input type="number" name="awal[]" class="form-control m-input text-right awal" autocomplete="off" disabled>
                </div>
                <div class="form-group col-2 col-sm-1">
                    <input type="number" name="transfer[]" class="form-control m-input text-right transfer" autocomplete="off">
                </div>
                <div class="form-group col-3 col-sm-2">
                    <div class="input-group">
                        <input type="number" name="akhir[]" class="form-control m-input akhir text-right" autocomplete="off" disabled>
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
        math(id);
        $('#' + id + ' input.typeahead').focus()
    }

    function math(id) {
        $('#' + id + ' input.transfer').on('change', function() {
            var id = $(this).attr('data-id');
            var awal = $('.awal[data-id=' + id + ']').val();
            var transfer = $('.transfer[data-id=' + id + ']').val();
            var akhir = Number(awal) - Number(transfer);
            $('.akhir[data-id=' + id + ']').val(akhir);
        });
    }

    function typeahead(id) {
        $('#' + id + ' input.typeahead').typeahead({
            items: 20,
            source: <?= $typeahead ?>,
            displayText: function(item) {
                return item.active + ' ' + item.name;
            },
            afterSelect: function(event) {
                $('#' + id + ' input.typeahead').attr('data-id', event._id);
                $('#' + id + ' input.awal').val(event.stock).attr('data-id', event._id);
                $('#' + id + ' input.transfer').val('').attr('data-id', event._id).focus();
                $('#' + id + ' input.akhir').val('').attr('data-id', event._id);
                $('#' + id + ' button#removeRow').attr('data-id', event._id);
            }
        });
    }
</script>