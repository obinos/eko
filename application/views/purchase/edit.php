<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12 pad0">
            <div class="ibox ">
                <div class="ibox-title d-flex align-items-center justify-content-between">
                    <h5>Edit Pembelian</h5>
                </div>
                <div class="ibox-content">
                    <form method="post" id="form">
                        <input type="hidden" name="_id" id="_id" value="<?= $purchase[0]['_id'] ?>">
                        <input type="hidden" name="file" id="file" value="<?= $purchase[0]['file'] ?>">
                        <div class="form-group row"><label class="col-sm-2 col-form-label">Supplier</label>
                            <div class="col-sm-10">
                                <select name="supplier" class="form-control" id="supplier">
                                    <option></option>
                                    <?php foreach ($supplier as $value) : ?>
                                        <option value="<?= $value['_id']; ?>" <?php if ($value['_id'] == $purchase[0]['id_supplier']) : ?> selected<?php endif; ?>><?= $value['name']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <span class="form-text m-b-none errorsupplier"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2 col-form-label">Tanggal</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control date" name="inputdate" value="<?= datephp('Y-m-d', $purchase[0]['transactiondate']) ?>" autocomplete="off">
                            </div>
                        </div>
                        <div class="form-group row"><label class="col-sm-2 col-form-label">Total Pembelian</label>
                            <div class="col-sm-10"><input type="text" class="form-control total_buy" name="total_buy" disabled value="<?= thousand($purchase[0]['total']) ?>"></div>
                        </div>
                        <div class="form-group row"><label class="col-sm-2 col-form-label">Diskon</label>
                            <div class="col-sm-10"><input type="text" class="form-control discount" name="discount"></div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-row d-flex align-items-end">
                                    <div class="form-group mb-1 col-1">
                                        <label class="ml-1">Station</label>
                                    </div>
                                    <div class="form-group mb-1 col-2 col-sm-3">
                                        <label class="ml-1">Nama Produk</label>
                                    </div>
                                    <div class="form-group mb-1 col-1">
                                        <label class="ml-1">Qty Beli</label>
                                    </div>
                                    <div class="form-group mb-1 col-1">
                                        <label class="ml-1">Unit</label>
                                    </div>
                                    <div class="form-group mb-1 col-1">
                                        <label class="ml-1">Qty Pack</label>
                                    </div>
                                    <div class="form-group mb-1 col-1">
                                        <label class="ml-1">Harga Satuan</label>
                                    </div>
                                    <div class="form-group mb-1 col-2">
                                        <label class="ml-1">Total Harga</label>
                                    </div>
                                    <div class="form-group mb-1 col-3 col-sm-2">
                                        <label class="ml-1">HPP</label>
                                    </div>
                                </div>
                                <?php foreach ($item as $i) { ?>
                                    <div id="inputFormRow">
                                        <div class="form-row" id="<?= $i['id_item'] ?>">
                                            <div class="form-group col-1">
                                                <input type="text" name="station[]" class="form-control m-input station <?= $i['colorstation'] ?>" autocomplete="off" data-id="<?= $i['id_item'] ?>" disabled value="<?= $i['station'] ?>">
                                            </div>
                                            <div class="form-group col-2 col-sm-3">
                                                <input type="search" name="name[]" class="form-control m-input typeahead" id="name" autocomplete="off" data-id="<?= $i['id_item'] ?>" value="<?= $i['name'] . ' (' . $i['weight'] . $i['unit'] . ')' ?>">
                                            </div>
                                            <div class="form-group col-1">
                                                <input type="text" name="qty_beli[]" class="form-control m-input text-right qty_beli" autocomplete="off" data-id="<?= $i['id_item'] ?>" data-weight="<?= $i['weight'] ?>" value="<?= thousand($i['qty_unit']) ?>">
                                            </div>
                                            <div class="form-group col-1">
                                                <input type="text" name="weight_unit[]" class="form-control m-input weight_unit" autocomplete="off" data-id="<?= $i['id_item'] ?>" disabled value="<?= $i['unit'] ?>">
                                            </div>
                                            <div class="form-group col-1">
                                                <input type="text" name="qty_pack[]" class="form-control m-input text-right qty_pack" autocomplete="off" data-id="<?= $i['id_item'] ?>" value="<?= thousand($i['qty']) ?>">
                                            </div>
                                            <div class="form-group col-1">
                                                <input type="text" name="price_pack[]" class="form-control m-input text-right price_pack" autocomplete="off" data-id="<?= $i['id_item'] ?>" value="<?= thousand($i['price']) ?>">
                                            </div>
                                            <div class="form-group col-2">
                                                <input type="text" name="total_price[]" class="form-control m-input text-right total_price" autocomplete="off" data-id="<?= $i['id_item'] ?>" value="<?= thousand($i['total_price']) ?>">
                                            </div>
                                            <div class="form-group col-3 col-sm-2">
                                                <div class="input-group">
                                                    <input type="text" name="hpp[]" class="form-control m-input text-right hpp" autocomplete="off" data-id="<?= $i['id_item'] ?>" value="<?= thousand($i['price']) ?>" disabled>
                                                    <div class="input-group-append">
                                                        <button id="removeRow" type="button" class="btn btn-danger" data-id="<?= $i['id_item'] ?>"><svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
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
                                <a class="btn btn-primary text-dark" id="addrow"><svg width="16px" height="16px" viewBox="0 0 16 16" class="mr-2" fill="currentColor">
                                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                        <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z" />
                                    </svg>Add Row</a>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="is-floating-label mb-3">
                            <label class="form-label">Note</label>
                            <textarea class="form-control" rows="2" name="notes"><?= $purchase[0]['notes'] ?></textarea>
                        </div>
                    </form>
                    <form id="fileupload" action="<?= base_url('purchase/upload/'); ?>" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <noscript><input type="hidden" name="redirect" value="https://blueimp.github.io/jQuery-File-Upload/" /></noscript>
                            <div class="row fileupload-buttonbar">
                                <div class="col-lg-2">
                                    <span class="btn btn-success fileinput-button">
                                        <span><svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                                <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z" />
                                                <path d="M7.646 1.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 2.707V11.5a.5.5 0 0 1-1 0V2.707L5.354 4.854a.5.5 0 1 1-.708-.708l3-3z" />
                                            </svg> Upload Nota</span>
                                        <input type="file" name="files[]" multiple />
                                    </span>
                                    <span class="fileupload-process"></span>
                                </div>
                                <div class="col-lg-10 fileupload-progress fade">
                                    <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                                        <div class="progress-bar progress-bar-striped bg-success" style="width: 0%;"></div>
                                    </div>
                                    <div class="progress-extended">&nbsp;</div>
                                </div>
                            </div>
                        </div>
                        <table role="presentation" class="table table-striped">
                            <tbody class="files"></tbody>
                        </table>
                    </form>
                    <button class="btn btn-warning btn-block" id="submit">Submit</button>
                </div>
            </div>
        </div>
    </div>
</div>
<?= core_script(); ?>
<?= datepicker(); ?>
<?= select2(); ?>
<?= toast(); ?>
<?= blueimp(); ?>
<script src="<?= base_url('assets/'); ?>vendor/validate/jquery.validate.min.js"></script>
<script src="<?= base_url('assets/'); ?>vendor/typehead/bootstrap3-typeahead.min.js"></script>
<script>
    $(document).ready(function() {
        $('input.discount').on('change', function() {
            var val = integer(this.value);
            $('input.discount').val(separator(val));
            hpp();
        });
        $('.date').datepicker({
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            autoclose: true
        });
        $("#supplier").select2({
            placeholder: 'Pilih Supplier',
            theme: 'bootstrap4',
            language: 'id'
        });
        $('.is-floating-label input, .is-floating-label textarea').on('focus blur', function(e) {
            $(this).parents('.is-floating-label').toggleClass('is-focused', (e.type === 'focus' || this.value.length > 0));
        }).trigger('blur');
        $('#fileupload').fileupload({
            url: '<?= base_url('purchase/upload/'); ?>',
            acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i,
            maxNumberOfFiles: 1,
            disableImageResize: false,
            imageMaxWidth: 1000,
            imageMaxHeight: 1000
        });
        $.ajax({
                url: $('#fileupload').fileupload('option', 'url'),
                dataType: 'json',
                context: $('#fileupload')[0]
            })
            .always(function() {
                $(this).removeClass('fileupload-processing');
            })
            .done(function(result) {
                var pos = result.files.map(function(e) {
                    return e.name;
                }).indexOf('<?= $purchase[0]['file'] ?>');
                var obj = {};
                var arr = [];
                arr.push(result.files[pos]);
                obj['files'] = arr;
                $(this)
                    .fileupload('option', 'done')
                    .call(this, $.Event('done'), {
                        result: obj
                    });
            });
        $('#fileupload').on('fileuploaddone', function(e, data) {
            $.each(data.result.files, function(index, file) {
                if (file.url) {
                    $('#file').val(file.name);
                } else if (file.error) {
                    console.log(file.name);
                }
            });
        });
        $(document).on('keypress', '.price_pack,.total_price', function(e) {
            if (e.which == 13) {
                addrow();
            }
        });
        $('#addrow').on('click', function(e) {
            addrow();
        });
        $(document).on('click', '#removeRow', function() {
            var total_buy = $('.total_buy').val();
            var id = $(this).attr('data-id');
            var total_price = $('.total_price[data-id=' + id + ']').val();
            var inputFormRow = $("div[id*='inputFormRow']").length;
            if (total_price) {
                total = integer(total_buy) - integer(total_price);
                $('.total_buy').val(separator(total));
            }
            if (inputFormRow == 1) {
                $('.station[data-id=' + id + ']').val('').removeClass('form-control-warning form-control-danger');
                $('.typeahead[data-id=' + id + ']').val('');
                $('.qty_beli[data-id=' + id + ']').val('');
                $('.qty_pack[data-id=' + id + ']').val('');
                $('.weight_unit[data-id=' + id + ']').val('');
                $('.price_pack[data-id=' + id + ']').val('');
                $('.total_price[data-id=' + id + ']').val('');
                $('.hpp[data-id=' + id + ']').val('');
            } else {
                $(this).closest('#inputFormRow').remove();
            }
        });
        <?php foreach ($item as $a) { ?>
            typeahead('<?= $a['id_item'] ?>');
            math('<?= $a['id_item'] ?>');
        <?php } ?>
        $("#form").validate({
            rules: {
                supplier: {
                    required: true
                }
            },
            messages: {
                supplier: {
                    required: "kolom harus diisi."
                }
            },
            errorPlacement: function(error, element) {
                if (element.attr("name") == "supplier")
                    error.insertAfter(".errorsupplier");
            },
            submitHandler: function() {
                var object = {};
                var array = [];
                object['supplier'] = $('select[name=supplier]').val();
                object['date'] = $('input[name=inputdate]').val();
                object['total_buy'] = integer($('input[name=total_buy]').val());
                object['discount'] = integer($('input[name=discount]').val());
                object['notes'] = $('textarea[name=notes').val();
                object['file'] = $('#file').val();
                object['_id'] = $('#_id').val();
                $('input.total_price').each(function() {
                    if ($(this).val() != "") {
                        var item = {};
                        var id = $(this).attr('data-id');
                        item['_id'] = id;
                        item['qty_beli'] = integer($('.qty_beli[data-id=' + id + ']').val());
                        item['qty_pack'] = integer($('.qty_pack[data-id=' + id + ']').val());
                        item['price_pack'] = integer($('.price_pack[data-id=' + id + ']').val());
                        item['total_price'] = integer($('.total_price[data-id=' + id + ']').val());
                        item['weight_unit'] = $('.weight_unit[data-id=' + id + ']').val();
                        array.push(item);
                    }
                });
                object['item'] = array;
                var jsonString = JSON.stringify(object);
                $.ajax({
                    type: "POST",
                    url: '<?= base_url('purchase/update_purchase/') ?>',
                    data: {
                        data: jsonString
                    },
                    success: function(response) {
                        var result = $.parseJSON(response);
                        if (result.status == 'success') {
                            $.toast({
                                heading: 'Success',
                                text: 'Edit Purchase',
                                icon: 'success',
                                showHideTransition: 'slide',
                                hideAfter: 1500,
                                position: 'top-right',
                                afterHidden: function() {
                                    window.location = "<?= base_url('purchase/index') ?>";
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

    function math(id) {
        $('#' + id + ' input.qty_beli').on('change', function() {
            var id = $(this).attr('data-id');
            var weight_unit = $('.weight_unit[data-id=' + id + ']').val();
            var weight = Number($('.qty_beli[data-id=' + id + ']').attr('data-weight'));
            var qty_beli = $('.qty_beli[data-id=' + id + ']').val();
            if (qty_beli) {
                var qty_pack = weight_unit == 'gr' ? Math.floor(integer(qty_beli) / weight) : qty_beli;
                if (qty_pack) {
                    var price_pack = integer($('.price_pack[data-id=' + id + ']').val());
                    var total_price = Math.ceil(price_pack * qty_pack);
                    $('.total_price[data-id=' + id + ']').val(separator(total_price));
                }
                $('.qty_pack[data-id=' + id + ']').val(separator(qty_pack));
            } else {
                $('.qty_pack[data-id=' + id + ']').val('');
                // $('.price_pack[data-id=' + id + ']').val('');
                $('.total_price[data-id=' + id + ']').val('');
            }
            $('.qty_beli[data-id=' + id + ']').val(separator(qty_beli));
            total_buy();
            hpp();
        });
        $('#' + id + ' input.total_price').on('change', function() {
            var id = $(this).attr('data-id');
            var qty_pack = $('.qty_pack[data-id=' + id + ']').val();
            var total_price = $('.total_price[data-id=' + id + ']').val();
            if (qty_pack && total_price) {
                var price_pack = Math.ceil(integer(total_price) / integer(qty_pack));
                $('.price_pack[data-id=' + id + ']').val(separator(price_pack));
            }
            $('.total_price[data-id=' + id + ']').val(separator(total_price));
            total_buy();
            hpp();
        });
        $('#' + id + ' input.price_pack,#' + id + ' input.qty_pack').on('change', function() {
            var id = $(this).attr('data-id');
            var qty_pack = $('.qty_pack[data-id=' + id + ']').val();
            var price_pack = $('.price_pack[data-id=' + id + ']').val();
            if (qty_pack && price_pack) {
                var total_price = Math.ceil(integer(price_pack) * integer(qty_pack));
                $('.total_price[data-id=' + id + ']').val(separator(total_price));
            }
            $('.price_pack[data-id=' + id + ']').val(separator(price_pack));
            $('.qty_pack[data-id=' + id + ']').val(separator(qty_pack));
            total_buy();
            hpp();
        });
    }

    function addrow() {
        var html = '';
        var id = new Date().getTime();
        html += `<div id="inputFormRow">
            <div class="form-row" id="` + id + `" >
                <div class="form-group col-1">
                    <input type="text" name="station[]" class="form-control m-input station" autocomplete="off" disabled>
                </div>
                <div class="form-group col-2 col-sm-3">
                    <input type="search" name="name[]" class="form-control m-input typeahead" autocomplete="off">
                </div>
                <div class="form-group col-1">
                    <input type="text" name="qty_beli[]" class="form-control m-input text-right qty_beli" autocomplete="off">
                </div>
                <div class="form-group col-1">
                    <input type="text" name="weight_unit[]" class="form-control m-input weight_unit" autocomplete="off" disabled>
                </div>
                <div class="form-group col-1">
                    <input type="text" name="qty_pack[]" class="form-control m-input text-right qty_pack" autocomplete="off">
                </div>
                <div class="form-group col-1">
                    <input type="text" name="price_pack[]" class="form-control m-input text-right price_pack" autocomplete="off">
                </div>
                <div class="form-group col-2">
                    <input type="text" name="total_price[]" class="form-control m-input text-right total_price" autocomplete="off">
                </div>
                <div class="form-group col-3 col-sm-2">
                    <div class="input-group">
                        <input type="text" name="hpp[]" class="form-control m-input text-right hpp" autocomplete="off" disabled>
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

    function integer(data) {
        return Number(data.replace(/\D/g, ""));
    }

    function separator(data) {
        return data.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    function hpp() {
        var total_buy = $('.total_buy').val() ? $('.total_buy').val() : '0';
        var discount = $('.discount').val() ? $('.discount').val() : '0';
        $(".total_price").each(function() {
            var id = $(this).attr('data-id');
            var total_price = $(this).val();
            var qty_pack = $('.qty_pack[data-id=' + id + ']').val();
            if (total_price && qty_pack && discount != '0') {
                var ratio = integer(total_price) / integer(total_buy) * 100;
                var hpp = Math.ceil((integer(total_price) - (integer(discount) * ratio / 100)) / integer(qty_pack));
            } else {
                var hpp = $('.price_pack[data-id=' + id + ']').val();
            }
            $('.hpp[data-id=' + id + ']').val(separator(hpp));
        });
    }

    function total_buy() {
        var total_buy = 0;
        $(".total_price").each(function() {
            var tb = integer($(this).val());
            total_buy = total_buy + tb;
            $('.total_buy').val(separator(total_buy));
        });
    }

    function typeahead(id) {
        $('#' + id + ' input.typeahead').typeahead({
            items: 20,
            source: <?= $typeahead ?>,
            displayText: function(item) {
                var icon = item.active === true ? "✅" : "❌";
                return icon + ' ' + item.name + ' (' + item.weight + 'gr)';
            },
            afterSelect: function(event) {
                if (event.purchase_price) {
                    if (event.purchase_price.last) {
                        var price_pack = event.purchase_price.last.price ? separator(event.purchase_price.last.price) : null;
                    }
                }
                var clsstation = Number(event.station) < 5 ? 'form-control-warning' : 'form-control-danger';
                $('#' + id + ' input.typeahead').attr('data-id', event._id);
                $('#' + id + ' input.qty_beli').val('').attr({
                    'data-id': event._id,
                    'data-weight': event.weight
                }).focus();
                $('#' + id + ' input.weight_unit').val(event.weight_unit).attr('data-id', event._id);
                $('#' + id + ' input.station').val(event.station).attr('data-id', event._id).removeClass('form-control-warning form-control-danger').addClass(clsstation);
                $('#' + id + ' input.qty_pack').val('').attr('data-id', event._id);
                $('#' + id + ' input.price_pack').val(price_pack).attr('data-id', event._id);
                $('#' + id + ' input.total_price').val('').attr('data-id', event._id);
                $('#' + id + ' input.hpp').val(price_pack).attr('data-id', event._id);
                $('#' + id + ' button#removeRow').attr('data-id', event._id);
                total_buy();
            }
        });
    }
</script>