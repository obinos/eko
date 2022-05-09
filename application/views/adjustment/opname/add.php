<link href="<?= base_url('assets/'); ?>vendor/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css" rel="stylesheet" type="text/css">
<div class="wrapper wrapper-content animated fadeInRight">
    <?php if ($this->uri->segment(2) == 'add_opname') { ?>
        <div class="row">
            <div class="col-lg-12 pad0">
                <div class="ibox ">
                    <div class="ibox-title d-flex align-items-center justify-content-between">
                        <h5>Station</h5>
                    </div>
                    <div class="ibox-content">
                        <form method="post" id="form">
                            <div class="form-row d-flex align-items-center">
                                <div class="col-xl-10 my-1">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text width46"><svg style="width:20px;height:20px;margin:auto" viewBox="0 0 24 24">
                                                    <path fill="#173b60" d="M6 19H8V21H6V19M12 3L2 8V21H4V13H20V21H22V8L12 3M8 11H4V9H8V11M14 11H10V9H14V11M20 11H16V9H20V11M6 15H8V17H6V15M10 15H12V17H10V15M10 19H12V21H10V19M14 19H16V21H14V19Z" />
                                                </svg></div>
                                        </div>
                                        <select name="filter_station" class="form-control" id="filter_station">
                                            <option></option>
                                            <?php foreach ($station as $s) : ?>
                                                <option value="<?= $s; ?>" <?php if ($s == $filter_station) : ?> selected<?php endif; ?>><?= $s; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-2 my-1">
                                    <button class="btn btn-lg btn-warning btn-block btn-filter">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
    <div class="row">
        <div class="col-lg-12 pad0">
            <div class="ibox ">
                <div class="ibox-title d-flex align-items-center justify-content-between">
                    <h5>Input Stock Opname</h5>
                </div>
                <div class="ibox-content">
                    <form method="post" id="form">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-row d-flex align-items-end">
                                    <div class="form-group mb-1 col-5 col-sm-8">
                                        <label class="ml-1">Nama Produk</label>
                                    </div>
                                    <div class="form-group mb-1 col-2 col-sm-1">
                                        <label class="ml-1">Good</label>
                                    </div>
                                    <div class="form-group mb-1 col-2 col-sm-1">
                                        <label class="ml-1">Fisik</label>
                                    </div>
                                    <div class="form-group mb-1 col-3 col-sm-2">
                                        <label class="ml-1">Selisih</label>
                                    </div>
                                </div>
                                <?php if ($items) {
                                    foreach ($items as $k => $i) { ?>
                                        <div id="inputFormRow">
                                            <div class="form-row" id="first_typeahead">
                                                <div class="form-group col-5 col-sm-8">
                                                    <input type="search" name="name[]" class="form-control m-input typeahead" id="name" autocomplete="off" data-id="<?= $i->id_item ?>" value="<?= $i->active . ' ' . $i->barcode . ' - ' . $i->name ?>">
                                                </div>
                                                <div class="form-group col-2 col-sm-1">
                                                    <input type="text" name="good[]" class="form-control m-input text-right good" autocomplete="off" data-id="<?= $i->id_item ?>" disabled value="<?= $i->good ?>">
                                                </div>
                                                <div class="form-group col-2 col-sm-1">
                                                    <input type="number" name="fisik[]" class="form-control m-input text-right fisik" autocomplete="off" data-id="<?= $i->id_item ?>">
                                                </div>
                                                <div class="form-group col-3 col-sm-2">
                                                    <div class="input-group">
                                                        <input type="text" name="selisih[]" class="form-control m-input selisih text-right" autocomplete="off" data-id="<?= $i->id_item ?>" data-hpp="<?= $i->hpp ?>" disabled>
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
                                <?php }
                                } ?>
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
                    </form>
                    <button class="btn btn-warning btn-block" id="btn-modal" data-toggle="modal" href='#modal-form'>Submit</button>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="modal-form" class="modal fade" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h4 class="modal-title">List produk belum pernah stock opname seminggu terakhir</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-striped table-sm display" width="100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Station</th>
                                <th>Nama</th>
                                <th>Stock</th>
                            </tr>
                        </thead>
                        <tbody class="table-modal">
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary btn-sm" id="submit">Submit</button>
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
        $("#filter_station").select2({
            placeholder: 'Pilih Station',
            theme: 'bootstrap4',
            language: 'id'
        });
        $('.is-floating-label input, .is-floating-label textarea').on('focus blur', function(e) {
            $(this).parents('.is-floating-label').toggleClass('is-focused', (e.type === 'focus' || this.value.length > 0));
        }).trigger('blur');
        $(document).on('keypress', '.fisik', function(e) {
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
                $('.good[data-id=' + id + ']').val('');
                $('.fisik[data-id=' + id + ']').val('');
                $('.selisih[data-id=' + id + ']').val('');
            } else {
                $(this).closest('#inputFormRow').remove();
            }
        });
        typeahead('first_typeahead');
        math('first_typeahead');
        $('#btn-modal').on('click', function(e) {
            $(".table-modal").empty();
            var object = {};
            var array = [];
            $('input.selisih').each(function() {
                if ($(this).val() != "") {
                    var item = {};
                    var id = $(this).attr('data-id');
                    item['_id'] = id;
                    array.push(item);
                }
            });
            object['item'] = array;
            var jsonString = JSON.stringify(object);
            $.ajax({
                type: "POST",
                url: '<?= base_url('adjustment/check_item') ?>',
                data: {
                    data: jsonString
                },
                success: function(response) {
                    var result = $.parseJSON(response);
                    if (result.data != 'failed') {
                        for (var i = 0; i < result.data.length; i++) {
                            var no = i + 1;
                            // var adj = result.data[i].adjustment === true ? ' class=""' : ' class="table-warning"';
                            $(".table-modal").append(`
                            <tr>
                            <td class="text-right">` + no + `</td>
                                <td>` + result.data[i].station + `</td>
                                <td>` + result.data[i].name + `</td>
                                <td class="text-right">` + result.data[i].stock + `</td>
                            </tr>`);
                        }
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                }
            });
        });
        $('#submit').on('click', function(e) {
            $('#submit').prop('disabled', true);
            e.preventDefault();
            var id = $(this).attr('data-id');
            var object = {};
            var array = [];
            $('input.selisih').each(function() {
                if ($(this).val() != "") {
                    var item = {};
                    var id = $(this).attr('data-id');
                    item['_id'] = id;
                    item['physic'] = Number($('.fisik[data-id=' + id + ']').val());
                    item['difference'] = Number($('.selisih[data-id=' + id + ']').val());
                    item['hpp'] = $(this).attr('data-hpp');
                    array.push(item);
                }
            });
            object['item'] = array;
            object['notes'] = $('textarea[name=notes').val();
            var jsonString = JSON.stringify(object);
            $.ajax({
                type: "POST",
                url: '<?= base_url('adjustment/update_opname') ?>',
                data: {
                    data: jsonString
                },
                success: function(response) {
                    var result = $.parseJSON(response);
                    if (result.status == 'success') {
                        $.toast({
                            heading: 'Success',
                            text: 'Add Stock Opname',
                            icon: 'success',
                            showHideTransition: 'slide',
                            hideAfter: 1500,
                            position: 'top-right',
                            afterHidden: function() {
                                window.location = "<?= base_url('adjustment/opname') ?>";
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
                    <input type="text" name="good[]" class="form-control m-input text-right good" autocomplete="off" disabled>
                </div>
                <div class="form-group col-2 col-sm-1">
                    <input type="number" name="fisik[]" class="form-control m-input text-right fisik" autocomplete="off">
                </div>
                <div class="form-group col-3 col-sm-2">
                    <div class="input-group">
                        <input type="text" name="selisih[]" class="form-control m-input selisih text-right" autocomplete="off" disabled>
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
        $('#' + id + ' input.fisik').on('change', function() {
            var id = $(this).attr('data-id');
            var fisik = $('.fisik[data-id=' + id + ']').val();
            var good = $('.good[data-id=' + id + ']').val();
            var selisih = Number(fisik) - Number(good);
            $('.selisih[data-id=' + id + ']').val(selisih);
        });
    }

    function typeahead(id) {
        $('#' + id + ' input.typeahead').typeahead({
            items: 20,
            source: <?= $typeahead ?>,
            displayText: function(item) {
                var icon = item.active === true ? "✅" : "❌";
                return icon + ' ' + item.barcode + ' - ' + item.name;
            },
            afterSelect: function(event) {
                $.ajax({
                    type: "POST",
                    url: '<?= base_url('adjustment/ledger_stock/') ?>',
                    data: {
                        id: event._id,
                        condition: 'good'
                    },
                    success: function(response) {
                        var result = $.parseJSON(response);
                        $('#' + id + ' input.good').val(result.good.toFixed(2)).attr('data-id', event._id);
                    }
                });
                if (event.purchase_price) {
                    if (event.purchase_price.avg_price) {
                        var hpp = event.purchase_price.avg_price;
                    } else if (event.purchase_price.last) {
                        var hpp = event.purchase_price.last.price;
                    }
                }
                var datahpp = hpp ? hpp : 0;
                $('#' + id + ' input.typeahead').attr('data-id', event._id);
                $('#' + id + ' input.fisik').val('').attr('data-id', event._id).focus();
                $('#' + id + ' input.selisih').val('').attr({
                    'data-id': event._id,
                    'data-hpp': datahpp
                });
                $('#' + id + ' button#removeRow').attr('data-id', event._id);
            }
        });
    }
</script>