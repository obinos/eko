<link href="<?= base_url('assets/'); ?>vendor/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css" rel="stylesheet" type="text/css">
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12 pad0">
            <div class="ibox ">
                <div class="ibox-content">
                    <form method="post" id="form_filter">
                        <div class="form-row d-flex align-items-end">
                            <div class="col-lg-10 my-1">
                                <p>Store</p>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text width46"><svg style="width:20px;height:20px;margin:auto" viewBox="0 0 24 24">
                                                <path fill="#173b60" d="M6 19H8V21H6V19M12 3L2 8V21H4V13H20V21H22V8L12 3M8 11H4V9H8V11M14 11H10V9H14V11M20 11H16V9H20V11M6 15H8V17H6V15M10 15H12V17H10V15M10 19H12V21H10V19M14 19H16V21H14V19Z" />
                                            </svg></div>
                                    </div>
                                    <select name="filter_store" class="form-control" id="filter_store">
                                        <option></option>
                                        <?php foreach ($store as $s) : ?>
                                            <option value="<?= $s['_id']; ?>" <?php if ($s['_id'] == $filter_store) : ?> selected<?php endif; ?>><?= $s['name']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-2 my-1">
                                <button type="submit" class="btn btn-warning btn-block btn-lg">Select</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 pad0">
            <div class="ibox ">
                <div class="ibox-title d-flex align-items-center justify-content-between">
                    <h5>Data Item</h5>
                    <a class='btn btn-sm btn-primary btn_sync text-dark'>
                        <svg class="mr-2" width="16px" height="16px" viewBox="0 0 16 16" fill="currentColor">
                            <path d="M11.534 7h3.932a.25.25 0 0 1 .192.41l-1.966 2.36a.25.25 0 0 1-.384 0l-1.966-2.36a.25.25 0 0 1 .192-.41zm-11 2h3.932a.25.25 0 0 0 .192-.41L2.692 6.23a.25.25 0 0 0-.384 0L.342 8.59A.25.25 0 0 0 .534 9z" />
                            <path fill-rule="evenodd" d="M8 3c-1.552 0-2.94.707-3.857 1.818a.5.5 0 1 1-.771-.636A6.002 6.002 0 0 1 13.917 7H12.9A5.002 5.002 0 0 0 8 3zM3.1 9a5.002 5.002 0 0 0 8.757 2.182.5.5 0 1 1 .771.636A6.002 6.002 0 0 1 2.083 9H3.1z" />
                        </svg> Sync Price</a>
                </div>
                <div class="ibox-content">
                    <div class="tabs-container">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-sm display" width="100%">
                                <thead>
                                    <tr>
                                        <th class="align-middle text-center" rowspan="2">No</th>
                                        <th class="align-middle text-center" rowspan="2">SKU</th>
                                        <th class="align-middle text-center" rowspan="2">Station</th>
                                        <th class="align-middle text-center" rowspan="2">Nama</th>
                                        <th class="align-middle text-center" rowspan="2">Harga</th>
                                        <th class="align-middle text-center" rowspan="2">Avg HPP</th>
                                        <th class="text-center" colspan="6">Store</th>
                                    </tr>
                                    <tr>
                                        <th class="text-center">Rak</th>
                                        <th class="text-center">R/P</th>
                                        <th class="text-center">Unit</th>
                                        <th class="text-center">Harga</th>
                                        <th class="text-center">Diskon</th>
                                        <th class="text-center">Jual</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($item) {
                                        $no = 1;
                                        foreach ($item as $data) :
                                    ?>
                                            <tr class="<?= $data['_id'] ?>">
                                                <td><?= $no++ ?></td>
                                                <td class="item_barcode"><?= $data['barcode'] ?></td>
                                                <td class="item_station"><?= $data['station'] ?></td>
                                                <td><a class='btn_edit item_name text-success' data-id="<?= $data['_id'] ?>"><?= $data['name'] ?></a></td>
                                                <td class="text-right item_price"><?= $data['price'] ?></td>
                                                <td class="text-right item_avg_hpp"><?= $data['avg_hpp'] ?></td>
                                                <td class="item_rack"><?= $data['rack'] ?></td>
                                                <td class="item_retur"><?= $data['retur'] ?></td>
                                                <td class="item_unit"><?= $data['unit'] ?></td>
                                                <td class="text-right item_base_price"><?= $data['base_price'] ?></td>
                                                <td class="text-right item_discount"><?= $data['discount'] ?></td>
                                                <td class="text-right item_sales_price <?= $data['label'] ?>"><?= $data['sales_price'] ?></td>
                                            </tr>
                                    <?php endforeach;
                                    } ?>
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
            <form role="form" id="form_edit">
                <div class="modal-header bg-light">
                    <h3 class="modal-title"></h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body pb-1">
                    <div class="row">
                        <div class="col-sm-12">
                            <input type="hidden" id="id">
                            <input type="hidden" id="avg_hpp">
                            <div class="form-group new-error"><label>Harga</label> <input type="number" class="form-control" id="base_price" name="base_price">
                                <span class="form-text m-b-none errorbase_price"></span>
                            </div>
                            <div class="form-group new-error"><label>Discount</label> <input type="number" class="form-control" id="discount" name="discount">
                                <span class="form-text m-b-none errordiscount"></span>
                            </div>
                            <div class="form-group new-error"><label>Satuan</label> <select name="unit" class="form-control" id="unit">
                                    <option value="">Pilih Satuan</option>
                                    <?php foreach ($satuan as $sat) : ?>
                                        <option value="<?= $sat ?>"><?= $sat ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <span class="form-text m-b-none errorunit"></span>
                            </div>
                            <div class="form-group new-error"><label>Rak</label> <input type="text" class="form-control" id="rack" name="rack">
                                <span class="form-text m-b-none errorrack"></span>
                            </div>
                            <div class="form-group new-error"><label>Retur/Putus</label> <select name="retur" class="form-control" id="retur">
                                    <option value="">Pilih Status</option>
                                    <?php foreach ($retur as $ret) : ?>
                                        <option value="<?= $ret ?>"><?= $ret ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <span class="form-text m-b-none errorretur"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <div class="modal-footer bg-light">
                <button class="btn btn-secondary btn-sm float-right m-t-n-xs mr-2" data-dismiss="modal">Close</button>
                <button class="btn btn-sm btn-primary float-right m-t-n-xs" id="submit" type="submit">Submit</button>
            </div>
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
        $("#filter_store").select2({
            placeholder: 'Pilih Store',
            theme: 'bootstrap4',
            language: 'id'
        });
        $('table.display').DataTable({
            responsive: true,
            pageLength: -1,
            dom: '<"html5buttons">lTfgitp',
            aLengthMenu: [
                [10, 20, 50, 100, -1],
                [10, 20, 50, 100, 'All']
            ]
        });
        $('#submit').on('click', function(e) {
            $('#submit').prop('disabled', true);
            e.preventDefault();
            $('#form_edit').submit();
            $('#submit').prop('disabled', false);
        });
        $("#form_edit").validate({
            rules: {
                base_price: {
                    required: true
                },
                discount: {
                    max: function() {
                        return parseInt($('#base_price').val());
                    }
                },
                unit: {
                    required: true
                }
            },
            messages: {
                base_price: {
                    required: "kolom harus diisi."
                },
                discount: {
                    max: "diskon harus lebih kecil dari harga"
                },
                unit: {
                    required: "kolom harus diisi."
                }
            },
            errorPlacement: function(error, element) {
                if (element.attr("name") == "base_price")
                    error.insertAfter(".errorbase_price");
                else if (element.attr("name") == "discount")
                    error.insertAfter(".errordiscount");
                else if (element.attr("name") == "unit")
                    error.insertAfter(".errorunit");
            },
            submitHandler: function() {
                var object = {};
                object['_id'] = $('#id').val();
                object['id_store'] = "<?= $filter_store ?>";
                object['base_price'] = $('#base_price').val();
                object['discount'] = $('#discount').val();
                object['unit'] = $('#unit option:selected').val();
                object['rack'] = $('#rack').val();
                object['retur'] = $('#retur option:selected').val();
                var jsonString = JSON.stringify(object);
                $.ajax({
                    type: "POST",
                    url: '<?= base_url('item/update_item_store/') ?>',
                    data: {
                        data: jsonString
                    },
                    success: function(response) {
                        var result = $.parseJSON(response);
                        if (result.status == 'success') {
                            $('tr.' + result._id + ' td.item_sales_price').removeClass('table-danger table-success');
                            $('tr.' + result._id + ' td.item_base_price').text(result.base_price);
                            $('tr.' + result._id + ' td.item_discount').text(result.discount);
                            $('tr.' + result._id + ' td.item_unit').text(result.unit);
                            $('tr.' + result._id + ' td.item_rack').text(result.rack);
                            $('tr.' + result._id + ' td.item_retur').text(result.retur);
                            $('tr.' + result._id + ' td.item_sales_price').addClass(result.label).text(result.sales_price);
                            $.toast({
                                heading: 'Success',
                                text: 'Edit Item ' + result.name,
                                icon: 'success',
                                showHideTransition: 'slide',
                                hideAfter: 1000,
                                position: 'top-right',
                                afterHidden: function() {
                                    $('#modal-form').modal('hide');
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
            $('.form-control').removeClass('error');
            $('label.error').remove();
            $('select#unit option').removeAttr('selected');
            $.ajax({
                type: "POST",
                url: '<?= base_url('item/get_item') ?>',
                data: {
                    data: id
                },
                success: function(response) {
                    var result = $.parseJSON(response);
                    if (result[0].store_price) {
                        if (result[0].store_price["<?= $filter_store ?>"]) {
                            $('select#unit option[value=' + result[0].store_price["<?= $filter_store ?>"].unit + ']').attr('selected', 'selected');
                            $('select#retur option[value=' + result[0].store_price["<?= $filter_store ?>"].retur + ']').attr('selected', 'selected');
                            var base_price = result[0].store_price["<?= $filter_store ?>"].base_price;
                            var discount = result[0].store_price["<?= $filter_store ?>"].discount;
                            var rack = result[0].store_price["<?= $filter_store ?>"].rack;
                        }
                    }
                    if (result[0].purchase_price) {
                        if (result[0].purchase_price.avg_price) {
                            var avg_price = result[0].purchase_price.avg_price;
                        } else {
                            var avg_price = 0;
                        }
                        if (result[0].purchase_price.last) {
                            var last_price = result[0].purchase_price.last.price;
                        } else {
                            var last_price = 0;
                        }
                    } else {
                        var avg_price = 0;
                        var last_price = 0;
                    }
                    var avg_hpp = avg_price ? avg_price : last_price;
                    base_price = base_price ? base_price : result[0].price;
                    $('#id').val(result[0]._id);
                    $('.modal-title').text(result[0].name);
                    $('#avg_hpp').val(avg_hpp);
                    $('#base_price').val(base_price);
                    $('#rack').val(rack);
                    $('#discount').val(discount);
                    $('#modal-form').modal('show');
                    $('#modal-form').on('shown.bs.modal', function(e) {
                        $(".select2-container--bootstrap4").removeAttr("style");
                        $("#unit").select2({
                            theme: 'bootstrap4',
                            tags: true,
                            language: 'id'
                        });
                        $("#retur").select2({
                            theme: 'bootstrap4',
                            tags: true,
                            language: 'id'
                        });
                    });
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                }
            });
        });
        $('.btn_sync').on('click', function(e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: '<?= base_url('item/sync_price/') ?>',
                data: {
                    data: "<?= $filter_store ?>"
                },
                success: function(response) {
                    var result = $.parseJSON(response);
                    if (result.status == 'success') {
                        $.toast({
                            heading: 'Success',
                            text: 'Sync Item',
                            icon: 'success',
                            showHideTransition: 'slide',
                            hideAfter: 1000,
                            position: 'top-right',
                            afterHidden: function() {
                                $('#form_filter').submit();
                            }
                        });
                    } else {
                        $.toast({
                            heading: 'Failed',
                            text: 'Sync Item',
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

    function separator(data) {
        return data.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }
</script>