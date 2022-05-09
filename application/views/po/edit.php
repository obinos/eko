<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12 pad0">
            <div class="ibox ">
                <div class="ibox-title d-flex align-items-center justify-content-between">
                    <h5><?= $heading ?> PO</h5>
                </div>
                <div class="ibox-content">
                    <form method="post" id="form">
                        <div class="form-group row"><label class="col-sm-2 col-form-label">Supplier</label>
                            <div class="col-sm-10">
                                <select name="supplier" class="form-control" id="supplier">
                                    <option></option>
                                    <?php foreach ($supplier as $value) : ?>
                                        <option value="<?= $value['_id']; ?>" <?php if ($value['_id'] == $po[0]['id_supplier']) : ?> selected<?php endif; ?>><?= $value['name']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <span class="form-text m-b-none errorsupplier"></span>
                            </div>
                        </div>
                        <div class="form-group row"><label class="col-sm-2 col-form-label">Total PO</label>
                            <div class="col-sm-10"><input type="text" class="form-control total_buy" name="total_buy" disabled value="<?= thousand($po[0]['total']) ?>"></div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-row d-flex align-items-end">
                                    <div class="form-group mb-1 col-1">
                                        <label class="ml-1">Station</label>
                                    </div>
                                    <div class="form-group mb-1 col-4 col-sm-5">
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
                                    <div class="form-group mb-1 col-3 col-sm-2">
                                        <label class="ml-1">Total Harga</label>
                                    </div>
                                </div>
                                <?php foreach ($item as $i) { ?>
                                    <div id="inputFormRow">
                                        <div class="form-row" id="first_typeahead">
                                            <div class="form-group col-1">
                                                <input type="text" name="station[]" class="form-control m-input station <?= $i['colorstation'] ?>" autocomplete="off" data-id="<?= $i['id_item'] ?>" disabled value="<?= $i['station'] ?>">
                                            </div>
                                            <div class="form-group col-4 col-sm-5">
                                                <input type="search" name="name[]" class="form-control m-input typeahead" id="name" autocomplete="off" data-id="<?= $i['id_item'] ?>" value="<?= $i['name'] . ' (' . $i['weight'] . $i['unit'] . ')' ?>">
                                            </div>
                                            <div class="form-group col-1">
                                                <input type="text" name="qty_beli[]" class="form-control m-input text-right qty_beli" autocomplete="off" data-id="<?= $i['id_item'] ?>" data-name="<?= $i['name'] ?>" data-weight="<?= $i['weight'] ?>" value="<?= thousand($i['qty_unit']) ?>">
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
                                            <div class="form-group col-3 col-sm-2">
                                                <div class="input-group">
                                                    <input type="text" name="total_price[]" class="form-control m-input total_price text-right" autocomplete="off" data-id="<?= $i['id_item'] ?>" value="<?= thousand($i['total_price']) ?>">
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
                    </form>
                    <button class="btn btn-warning btn-block" id="submit">Submit</button>
                </div>
            </div>
        </div>
    </div>
</div>
<?= core_script(); ?>
<?= select2(); ?>
<?= toast(); ?>
<script src="<?= base_url('assets/'); ?>vendor/validate/jquery.validate.min.js"></script>
<script src="<?= base_url('assets/'); ?>vendor/typehead/bootstrap3-typeahead.min.js"></script>
<script>
    $(document).ready(function() {
        var inputFormRow = $("div[id*='inputFormRow']").length;
        if (inputFormRow < 1) {
            addrow();
        }
        $("#supplier").select2({
            placeholder: 'Pilih Supplier',
            theme: 'bootstrap4',
            language: 'id'
        });
        $(document).on('keypress', '.qty_beli,.qty_pack,.price_pack,.total_price', function(e) {
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
                $('.weight_unit[data-id=' + id + ']').val('');
                $('.qty_pack[data-id=' + id + ']').val('');
                $('.price_pack[data-id=' + id + ']').val('');
                $('.total_price[data-id=' + id + ']').val('');
            } else {
                $(this).closest('#inputFormRow').remove();
            }
        });
        typeahead('first_typeahead');
        math('first_typeahead');
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
                object['_id'] = '<?= $idpo ?>';
                object['status'] = 'open';
                object['supplier'] = $('select[name=supplier]').val();
                $('input.qty_beli').each(function() {
                    if ($(this).val() != "") {
                        var item = {};
                        var id = $(this).attr('data-id');
                        item['_id'] = id;
                        item['name'] = $(this).attr('data-name');
                        item['qty_beli'] = integer($('.qty_beli[data-id=' + id + ']').val());
                        item['weight_unit'] = $('.weight_unit[data-id=' + id + ']').val();
                        item['qty_pack'] = integer($('.qty_pack[data-id=' + id + ']').val());
                        item['price_pack'] = integer($('.price_pack[data-id=' + id + ']').val());
                        item['total_price'] = integer($('.total_price[data-id=' + id + ']').val());
                        array.push(item);
                    }
                });
                object['item'] = array;
                object['total_buy'] = integer($('input[name=total_buy]').val());
                var jsonString = JSON.stringify(object);
                $.ajax({
                    type: "POST",
                    url: '<?= base_url('po/update_po') ?>',
                    data: {
                        data: jsonString
                    },
                    success: function(response) {
                        var result = $.parseJSON(response);
                        if (result.result == 'success') {
                            $.toast({
                                heading: 'Success',
                                text: '<?= $heading ?> PO',
                                icon: 'success',
                                showHideTransition: 'slide',
                                hideAfter: 1500,
                                position: 'top-right',
                                afterHidden: function() {
                                    window.location = "<?= base_url('po/list') ?>";
                                }
                            });
                        } else {
                            $.toast({
                                heading: 'Failed',
                                text: '<?= $heading ?> PO',
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
                $('.total_price[data-id=' + id + ']').val('');
            }
            $('.qty_beli[data-id=' + id + ']').val(separator(qty_beli));
            total_buy();
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
                <div class="form-group col-4 col-sm-5">
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
                <div class="form-group col-3 col-sm-2">
                    <div class="input-group">
                        <input type="text" name="total_price[]" class="form-control m-input text-right total_price" autocomplete="off">
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

    function total_buy() {
        var total_buy = 0;
        $(".total_price").each(function() {
            var tb = integer($(this).val());
            total_buy = total_buy + tb;
            $('.total_buy').val(separator(total_buy));
        });
    }

    function integer(data) {
        if (data)
            return Number(data.replace(/\D/g, ""));
        else
            return data;
    }

    function separator(data) {
        if (data)
            return data.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        else
            return data;
    }

    function typeahead(id) {
        $('#' + id + ' input.typeahead').typeahead({
            items: 20,
            source: <?= json_encode($this->aratadb->select(['_id', 'name', 'station', 'active', 'weight_unit', 'weight', 'purchase_price'])->order_by(['active' => 'DESC', 'name' => 'ASC'])->where(['merchant' => '606eba1c099777608a38aeda'])->get('items'), true); ?>,
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
                    'data-name': event.name,
                    'data-weight': event.weight
                }).focus();
                $('#' + id + ' input.weight_unit').val(event.weight_unit).attr('data-id', event._id);
                $('#' + id + ' input.station').val(event.station).attr('data-id', event._id).removeClass('form-control-warning form-control-danger').addClass(clsstation);
                $('#' + id + ' input.qty_pack').val('').attr('data-id', event._id);
                $('#' + id + ' input.price_pack').val(price_pack).attr('data-id', event._id);
                $('#' + id + ' input.total_price').val('').attr('data-id', event._id);
                $('#' + id + ' button#removeRow').attr('data-id', event._id);
            }
        });
    }
</script>