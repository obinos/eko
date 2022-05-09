<link href="<?= base_url('assets/'); ?>vendor/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css" rel="stylesheet" type="text/css">
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12 pad0">
            <div class="ibox ">
                <div class="ibox-content">
                    <form method="post">
                        <div class="form-row d-flex align-items-end">
                            <div class="col-lg-3 my-1">
                                <p>Station</p>
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
                            <div class="col-lg-3 my-1">
                                <p>Product Active</p>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text width46"><svg style="width:20px;height:20px;margin:auto" viewBox="0 0 24 24">
                                                <path fill="#173b60" d="M23,12L20.56,9.22L20.9,5.54L17.29,4.72L15.4,1.54L12,3L8.6,1.54L6.71,4.72L3.1,5.53L3.44,9.21L1,12L3.44,14.78L3.1,18.47L6.71,19.29L8.6,22.47L12,21L15.4,22.46L17.29,19.28L20.9,18.46L20.56,14.78L23,12M10,17L6,13L7.41,11.59L10,14.17L16.59,7.58L18,9L10,17Z" />
                                            </svg></div>
                                    </div>
                                    <select name="filter_active" class="form-control" id="filter_active">
                                        <option></option>
                                        <?php foreach ($active as $key => $val) : ?>
                                            <option value="<?= $key; ?>" <?php if ($key == $filter_active) : ?> selected<?php endif; ?>><?= $val; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3 my-1">
                                <p>Best Seller</p>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text width46"><svg style="width:20px;height:20px;margin:auto" viewBox="0 0 24 24">
                                                <path fill="#173b60" d="M18.65,2.85L19.26,6.71L22.77,8.5L21,12L22.78,15.5L19.24,17.29L18.63,21.15L14.74,20.54L11.97,23.3L9.19,20.5L5.33,21.14L4.71,17.25L1.22,15.47L3,11.97L1.23,8.5L4.74,6.69L5.35,2.86L9.22,3.5L12,0.69L14.77,3.46L18.65,2.85M9.5,7A1.5,1.5 0 0,0 8,8.5A1.5,1.5 0 0,0 9.5,10A1.5,1.5 0 0,0 11,8.5A1.5,1.5 0 0,0 9.5,7M14.5,14A1.5,1.5 0 0,0 13,15.5A1.5,1.5 0 0,0 14.5,17A1.5,1.5 0 0,0 16,15.5A1.5,1.5 0 0,0 14.5,14M8.41,17L17,8.41L15.59,7L7,15.59L8.41,17Z" />
                                            </svg></div>
                                    </div>
                                    <select name="filter_bestseller" class="form-control" id="filter_bestseller">
                                        <option></option>
                                        <?php foreach ($active as $key => $val) : ?>
                                            <option value="<?= $key; ?>" <?php if ($key == $filter_bestseller) : ?> selected<?php endif; ?>><?= $val; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3 my-1">
                                <button type="submit" class="btn btn-warning btn-block btn-lg">Filter</button>
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
                    <a class='btn btn-sm btn-primary' href='<?= base_url(); ?>item/excel/'>
                        <svg class="mr-2" width="16px" height="16px" viewBox="0 0 16 16" fill="currentColor">
                            <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V9H3V2a1 1 0 0 1 1-1h5.5v2zM3 12v-2h2v2H3zm0 1h2v2H4a1 1 0 0 1-1-1v-1zm3 2v-2h3v2H6zm4 0v-2h3v1a1 1 0 0 1-1 1h-2zm3-3h-3v-2h3v2zm-7 0v-2h3v2H6z" />
                        </svg> Export Excel</a>
                </div>
                <div class="ibox-content">
                    <div class="tabs-container">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-sm display" width="100%">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center">Active</th>
                                        <th class="text-center">Promo</th>
                                        <th class="text-center">Create</th>
                                        <th class="text-center">SKU</th>
                                        <th class="text-center">Kategori</th>
                                        <th class="text-center">Nama</th>
                                        <th class="text-center">Harga</th>
                                        <th class="text-center">Berat</th>
                                        <th class="text-center">Unit</th>
                                        <th class="text-center">Supplier</th>
                                        <th class="text-center">Stock</th>
                                        <th class="text-center">Avg HPP</th>
                                        <th class="text-center">Station</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1;
                                    foreach ($item as $data) :
                                        $price = $data['price'] > $data['sales_price'] ? '<s>' . thousand($data['price']) . '</s> ' . thousand($data['sales_price']) : thousand($data['price']);
                                    ?>
                                        <tr class="<?= $data['_id'] ?>">
                                            <td><?= $no++ ?></td>
                                            <td class="item_active"><?= check_boolean($data['active']) ?></td>
                                            <td class="item_is_bestseller"><?= check_boolean($data['is_bestseller'], 'is_bestseller') ?></td>
                                            <td class="item_created_at"><span class="pace-inactive"><?= datephp('Ymd', $data['created_at']) ?></span><?= datephp('d M y', $data['created_at']) ?></td>
                                            <td class="item_barcode"><?= $data['barcode'] ?></td>
                                            <td class="item_category"><?= $data['category'] ?></td>
                                            <td><a class='btn_edit item_name text-success' data-id="<?= $data['_id'] ?>"><?= $data['name'] ?></a></td>
                                            <td class="item_price text-right <?= $data['bg_hpp'] ?>"><?= $price ?></td>
                                            <td class="item_weight text-right"><?= $data['weight'] ?></td>
                                            <td class="item_weight_unit"><?= $data['weight_unit'] ?></td>
                                            <td class="item_supplier"><?= $data['supplier'] ?></td>
                                            <td class="item_stock text-right"><?= $data['stock'] ?></td>
                                            <td class="item_hpp text-right"><?= $data['purchase_price']->avg_price ? thousand($data['purchase_price']->avg_price) : null ?></td>
                                            <td class="item_station"><?= $data['station'] ?></td>
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
            <form role="form" id="form_edit">
                <div class="modal-header bg-light">
                    <h3 class="modal-title">Edit Produk</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body pb-1">
                    <div class="row">
                        <div class="col-sm-12">
                            <input type="hidden" id="id">
                            <div class="row">
                                <div class="col-6">
                                    <label>Active</label>
                                    <div class="form-group new-error d-flex align-items-center">
                                        <div class="form-check abc-radio abc-radio-primary form-check-inline">
                                            <input class="form-check-input" type="radio" id="activetrue" value="true" name="active">
                                            <label class="form-check-label" for="activetrue"> True
                                            </label>
                                        </div>
                                        <div class="form-check abc-radio abc-radio-danger form-check-inline">
                                            <input class="form-check-input" type="radio" id="activefalse" value="false" name="active">
                                            <label class="form-check-label" for="activefalse"> False
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <label>Best Seller</label>
                                    <div class="form-group new-error d-flex align-items-center">
                                        <div class="form-check abc-radio abc-radio-primary form-check-inline">
                                            <input class="form-check-input" type="radio" id="is_bestsellertrue" value="true" name="is_bestseller">
                                            <label class="form-check-label" for="is_bestsellertrue"> True
                                            </label>
                                        </div>
                                        <div class="form-check abc-radio abc-radio-danger form-check-inline">
                                            <input class="form-check-input" type="radio" id="is_bestsellerfalse" value="false" name="is_bestseller">
                                            <label class="form-check-label" for="is_bestsellerfalse"> False
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <label>Stock Managed</label>
                                    <div class="form-group new-error d-flex align-items-center">
                                        <div class="form-check abc-radio abc-radio-primary form-check-inline">
                                            <input class="form-check-input" type="radio" id="stock_managedtrue" value="true" name="stock_managed">
                                            <label class="form-check-label" for="stock_managedtrue"> True
                                            </label>
                                        </div>
                                        <div class="form-check abc-radio abc-radio-danger form-check-inline">
                                            <input class="form-check-input" type="radio" id="stock_managedfalse" value="false" name="stock_managed">
                                            <label class="form-check-label" for="stock_managedfalse"> False
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <label>Kirim Sore</label>
                                    <div class="form-group new-error d-flex align-items-center">
                                        <div class="form-check abc-radio abc-radio-primary form-check-inline">
                                            <input class="form-check-input" type="radio" id="is_preordertrue" value="true" name="is_preorder">
                                            <label class="form-check-label" for="is_preordertrue"> True
                                            </label>
                                        </div>
                                        <div class="form-check abc-radio abc-radio-danger form-check-inline">
                                            <input class="form-check-input" type="radio" id="is_preorderfalse" value="false" name="is_preorder">
                                            <label class="form-check-label" for="is_preorderfalse"> False
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6 pr-1">
                                    <div class="form-group new-error"><label>Kategori</label> <select name="id_category" class="form-control" id="id_category">
                                            <option value="">Pilih Kategori</option>
                                            <?php foreach ($category as $cat) : ?>
                                                <option value="<?= $cat['_id']; ?>"><?= $cat['name']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6 pl-1">
                                    <div class="form-group new-error"><label>Supplier</label> <select name="id_supplier" class="form-control" id="id_supplier">
                                            <option value="">Pilih Supplier</option>
                                            <?php foreach ($supplier as $sup) : ?>
                                                <option value="<?= $sup['_id']; ?>"><?= $sup['name']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group new-error"><label>Nama</label> <input type="text" class="form-control" id="name" name="name">
                                <span class="form-text m-b-none errorname"></span>
                            </div>
                            <div class="form-group"><label>Alias</label> <input type="text" class="form-control" id="alias" name="alias">
                            </div>
                            <div class="row">
                                <div class="col-3 pr-1">
                                    <div class="form-group new-error"><label>Station</label> <input type="text" class="form-control" id="station" name="station"></div>
                                </div>
                                <div class="col-3 px-1">
                                    <div class="form-group new-error"><label>SKU</label> <input type="text" class="form-control" id="sku" name="sku">
                                        <span class="form-text m-b-none errorsku"></span>
                                    </div>
                                </div>
                                <div class="col-3 px-1">
                                    <div class="form-group new-error"><label>Berat</label> <input type="text" class="form-control" id="weight" name="weight">
                                        <span class="form-text m-b-none errorweight"></span>
                                    </div>
                                </div>
                                <div class="col-3 pl-1">
                                    <div class="form-group new-error"><label>Satuan</label> <select name="weight_unit" class="form-control" id="weight_unit">
                                            <option value="">Pilih Satuan</option>
                                            <?php foreach ($satuan as $sat) : ?>
                                                <option value="<?= $sat ?>"><?= $sat ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <span class="form-text m-b-none errorweight_unit"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-4 pr-1">
                                    <div class="form-group new-error"><label>Harga</label> <input type="number" class="form-control" id="price" name="price">
                                        <span class="form-text m-b-none errorprice"></span>
                                    </div>
                                </div>
                                <div class="col-4 px-1">
                                    <div class="form-group new-error"><label>Promo</label> <input type="number" class="form-control" id="sales_price" name="sales_price">
                                        <span class="form-text m-b-none errorsales_price"></span>
                                    </div>
                                </div>
                                <div class="col-4 pl-1">
                                    <div class="form-group new-error"><label>Avg HPP</label> <input type="number" class="form-control" id="hpp" name="hpp">
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="form-group new-error"><label>Stock</label> <input type="text" class="form-control" id="stock" name="stock"></div> -->
                            <div class="row">
                                <div class="col-3 pr-1">
                                    <div class="form-group new-error"><label>Kuota</label> <input type="number" class="form-control" id="stock_default" name="stock_default"></div>
                                </div>
                                <div class="col-3 px-1">
                                    <div class="form-group new-error"><label>Stock Min</label> <input type="number" class="form-control" id="stock_min" name="stock_min">
                                        <span class="form-text m-b-none errorstock_min"></span>
                                    </div>
                                </div>
                                <div class="col-3 px-1">
                                    <div class="form-group new-error"><label>Stock Max</label> <input type="number" class="form-control" id="stock_max" name="stock_max">
                                        <span class="form-text m-b-none errorstock_max"></span>
                                    </div>
                                </div>
                                <div class="col-3 pl-1">
                                    <div class="form-group new-error"><label>Order Limit</label> <input type="number" class="form-control" id="order_limit" name="order_limit">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-3 pr-1">
                                    <div class="form-group new-error"><label>Margin</label>
                                        <div class="input-group m-b">
                                            <input type="number" class="form-control pr-0" id="current_profit" name="current_profit" disabled>
                                            <div class="input-group-append">
                                                <span class="input-group-addon bg-light">%</span>
                                            </div>
                                        </div>
                                        <span class="form-text m-b-none errorcurrent_profit"></span>
                                    </div>
                                </div>
                                <div class="col-3 px-1">
                                    <div class="form-group new-error"><label>Profit Min</label>
                                        <div class="input-group m-b">
                                            <input type="number" class="form-control" id="profit_min" name="profit_min">
                                            <div class="input-group-append">
                                                <span class="input-group-addon bg-light">%</span>
                                            </div>
                                        </div>
                                        <span class="form-text m-b-none errorprofit_min"></span>
                                    </div>
                                </div>
                                <div class="col-3 px-1">
                                    <div class="form-group new-error"><label>Best Profit</label>
                                        <div class="input-group m-b">
                                            <input type="number" class="form-control" id="profit_best" name="profit_best">
                                            <div class="input-group-append">
                                                <span class="input-group-addon bg-light">%</span>
                                            </div>
                                        </div>
                                        <span class="form-text m-b-none errorprofit_best"></span>
                                    </div>
                                </div>
                                <div class="col-3 pl-1">
                                    <div class="form-group new-error"><label>Profit Max</label>
                                        <div class="input-group m-b">
                                            <input type="number" class="form-control" id="profit_max" name="profit_max">
                                            <div class="input-group-append">
                                                <span class="input-group-addon bg-light">%</span>
                                            </div>
                                        </div>
                                        <span class="form-text m-b-none errorprofit_max"></span>
                                    </div>
                                </div>
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
        $('#price,#sales_price').on('change', function() {
            var price = $('#sales_price').val();
            var hpp = $('#hpp').val();
            var margin = ((Number(price) - Number(hpp)) / Number(price)) * 100;
            var current_profit = margin ? margin.toFixed(2) : 0;
            $('#current_profit').val(current_profit);
        });
        $("#filter_station").select2({
            placeholder: 'Pilih Station',
            theme: 'bootstrap4',
            language: 'id'
        });
        $("#filter_active").select2({
            placeholder: 'Produk Aktif',
            theme: 'bootstrap4',
            language: 'id'
        });
        $("#filter_bestseller").select2({
            placeholder: 'Best Seller',
            theme: 'bootstrap4',
            language: 'id'
        });
        var id = $('#id').val();
        $('#submit').on('click', function(e) {
            $('#submit').prop('disabled', true);
            e.preventDefault();
            var price = $('#price').val();
            var sales_price = $('#sales_price').val();
            var discount = (((price - sales_price) / price) * 100).toFixed(2);
            if (sales_price && discount > 60) {
                $('#modal-form').modal('hide');
                Swal({
                    title: 'Harga Promo',
                    text: 'lebih dari 60%',
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#45eba5',
                    cancelButtonColor: '#fd8664',
                    confirmButtonText: 'Lanjut'
                }).then((result) => {
                    if (result.value) {
                        $('#form_edit').submit();
                        $('#submit').prop('disabled', false);
                    } else {
                        $('#modal-form').modal('show');
                        $('#submit').prop('disabled', false);
                    }
                })
            } else {
                $('#form_edit').submit();
                $('#submit').prop('disabled', false);
            }
        });
        $("#form_edit").validate({
            rules: {
                sku: {
                    remote: {
                        url: "<?= base_url('item/check_item/'); ?>",
                        type: "post",
                        data: {
                            id: function() {
                                return $("#id").val();
                            }
                        }
                    }
                },
                name: {
                    required: true,
                },
                price: {
                    required: true,
                    number: true
                },
                sales_price: {
                    number: true,
                    max: function() {
                        return parseInt($('#price').val());
                    }
                },
                weight: {
                    required: true,
                    number: true
                },
                weight_unit: {
                    required: true
                },
                stock_min: {
                    min: 0,
                    max: function() {
                        return parseInt($('#stock_max').val()) ? parseInt($('#stock_max').val()) : 1000;
                    }
                },
                stock_max: {
                    min: function() {
                        return parseInt($('#stock_min').val()) ? parseInt($('#stock_min').val()) : 0;
                    }
                },
                profit_min: {
                    min: 0,
                    max: function() {
                        return parseInt($('#profit_max').val()) ? parseInt($('#profit_max').val()) : 100;
                    }
                },
                profit_best: {
                    min: function() {
                        return parseInt($('#profit_min').val()) ? parseInt($('#profit_min').val()) : 0;
                    },
                    max: function() {
                        return parseInt($('#profit_max').val()) ? parseInt($('#profit_max').val()) : 100;
                    }
                },
                profit_max: {
                    min: function() {
                        return parseInt($('#profit_min').val()) ? parseInt($('#profit_min').val()) : 0;
                    },
                    max: 100
                }
            },
            messages: {
                sku: {
                    remote: "SKU sudah terdaftar."
                },
                name: {
                    required: "kolom harus diisi."
                },
                price: {
                    required: "kolom harus diisi.",
                    number: "masukkan angka saja."
                },
                sales_price: {
                    number: "masukkan angka saja.",
                    max: "promo harus lebih kecil dari harga"
                },
                weight: {
                    required: "kolom harus diisi.",
                    number: "masukkan angka saja."
                },
                weight_unit: {
                    required: "kolom harus diisi."
                },
                stock_min: {
                    min: "minimal 0",
                    max: "harus kurang dari stock max"
                },
                stock_max: {
                    min: "harus lebih dari stock min / 0"
                },
                profit_min: {
                    min: "minimal 0",
                    max: "harus kurang dari profit max / 100"
                },
                profit_best: {
                    min: "harus lebih dari profit min / 0",
                    max: "harus kurang dari profit max / 100"
                },
                profit_max: {
                    min: "harus lebih dari profit min / 0",
                    max: "maksimal 100"
                }
            },
            errorPlacement: function(error, element) {
                if (element.attr("name") == "sku")
                    error.insertAfter(".errorsku");
                else if (element.attr("name") == "name")
                    error.insertAfter(".errorname");
                else if (element.attr("name") == "price")
                    error.insertAfter(".errorprice");
                else if (element.attr("name") == "sales_price")
                    error.insertAfter(".errorsales_price");
                else if (element.attr("name") == "weight")
                    error.insertAfter(".errorweight");
                else if (element.attr("name") == "weight_unit")
                    error.insertAfter(".errorweight_unit");
                else if (element.attr("name") == "stock_min")
                    error.insertAfter(".errorstock_min");
                else if (element.attr("name") == "stock_max")
                    error.insertAfter(".errorstock_max");
                else if (element.attr("name") == "profit_min")
                    error.insertAfter(".errorprofit_min");
                else if (element.attr("name") == "profit_best")
                    error.insertAfter(".errorprofit_best");
                else if (element.attr("name") == "profit_max")
                    error.insertAfter(".errorprofit_max");
            },
            submitHandler: function() {
                var object = {};
                object['_id'] = $('#id').val();
                object['active'] = $('input[name=active]:checked').val();
                object['is_bestseller'] = $('input[name=is_bestseller]:checked').val();
                object['stock_managed'] = $('input[name=stock_managed]:checked').val();
                object['is_preorder'] = $('input[name=is_preorder]:checked').val();
                object['barcode'] = $('#sku').val();
                object['station'] = $('#station').val();
                object['id_category'] = $('#id_category option:selected').val();
                object['id_supplier'] = $('#id_supplier option:selected').val();
                object['name'] = $('#name').val();
                object['alias'] = $('#alias').val();
                object['price'] = $('#price').val();
                object['sales_price'] = $('#sales_price').val();
                object['hpp'] = $('#hpp').val();
                object['weight'] = $('#weight').val();
                object['weight_unit'] = $('#weight_unit option:selected').val();
                // object['stock'] = $('#stock').val();
                object['stock_default'] = $('#stock_default').val();
                object['stock_min'] = $('#stock_min').val();
                object['stock_max'] = $('#stock_max').val();
                object['profit_min'] = $('#profit_min').val();
                object['profit_best'] = $('#profit_best').val();
                object['profit_max'] = $('#profit_max').val();
                object['order_limit'] = $('#order_limit').val();
                var jsonString = JSON.stringify(object);
                $.ajax({
                    type: "POST",
                    url: '<?= base_url('item/update_item/') ?>',
                    data: {
                        data: jsonString
                    },
                    success: function(response) {
                        var result = $.parseJSON(response);
                        if (result.status == 'success') {
                            if (result.active) {
                                $('tr.' + result._id + ' td.item_active').html(`<svg width="22" height="22" fill="#8ab661" viewBox="0 0 16 16">
                                    <path d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm10.03 4.97a.75.75 0 0 1 .011 1.05l-3.992 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.75.75 0 0 1 1.08-.022z"/>
                                </svg>`);
                            } else {
                                $('tr.' + result._id + ' td.item_active').html(`<svg width="22" height="22" fill="#fd8664" viewBox="0 0 16 16">
                                    <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
                                    <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                                </svg>`);
                            }
                            if (result.is_bestseller) {
                                $('tr.' + result._id + ' td.item_is_bestseller').html(`<svg width="22" height="22" fill="#8ab661" viewBox="0 0 16 16">
                                    <path d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2zm10.03 4.97a.75.75 0 0 1 .011 1.05l-3.992 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.75.75 0 0 1 1.08-.022z"/>
                                </svg>`);
                            } else {
                                $('tr.' + result._id + ' td.item_is_bestseller').html(``);
                            }
                            $('tr.' + result._id + ' td.item_barcode').text(result.barcode);
                            $('tr.' + result._id + ' td.item_category').text(result.category);
                            $('tr.' + result._id + ' a.item_name').text(result.name);
                            $('tr.' + result._id + ' td.item_price').removeClass('table-danger table-success');
                            var price = result.price > result.sales_price ? '<s>' + separator(result.price) + '</s> ' + separator(result.sales_price) : separator(result.price);
                            if (result.bg_hpp) {
                                $('tr.' + result._id + ' td.item_price').addClass(result.bg_hpp).html(price);
                            } else {
                                $('tr.' + result._id + ' td.item_price').html(price);
                            }
                            $('tr.' + result._id + ' td.item_hpp').html(separator(result.purchase_price.avg_price));
                            $('tr.' + result._id + ' td.item_weight').text(result.weight);
                            $('tr.' + result._id + ' td.item_weight_unit').text(result.weight_unit);
                            $('tr.' + result._id + ' td.item_supplier').text(result.supplier);
                            $('tr.' + result._id + ' td.item_station').text(result.station);
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
            $('select#id_category option').removeAttr('selected');
            $('select#id_supplier option').removeAttr('selected');
            $('select#weight_unit option').removeAttr('selected');
            $.ajax({
                type: "POST",
                url: '<?= base_url('item/get_item') ?>',
                data: {
                    data: id
                },
                success: function(response) {
                    var result = $.parseJSON(response);
                    if (result[0].id_supplier)
                        $('select#id_supplier option[value=' + result[0].id_supplier + ']').attr('selected', 'selected');
                    if (result[0].id_category)
                        $('select#id_category option[value=' + result[0].id_category + ']').attr('selected', 'selected');
                    if (result[0].weight_unit)
                        $('select#weight_unit option[value=' + result[0].weight_unit + ']').attr('selected', 'selected');
                    var price = result[0].sales_price ? result[0].sales_price : result[0].price;
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
                    var hpp = avg_price ? avg_price : last_price;
                    var margin = ((Number(price) - Number(hpp)) / Number(price)) * 100;
                    var current_profit = margin ? margin.toFixed(2) : 0;
                    $('#id').val(result[0]._id);
                    $('#active' + result[0].active.toString() + '[name=active]').prop('checked', true);
                    $('#is_bestseller' + result[0].is_bestseller.toString() + '[name=is_bestseller]').prop('checked', true);
                    if (result[0].is_preorder)
                        $('#is_preorder' + result[0].is_preorder.toString() + '[name=is_preorder]').prop('checked', true);
                    else
                        $('#is_preorderfalse[name=is_preorder]').prop('checked', true);
                    $('#sku').val(result[0].barcode);
                    $('#name').val(result[0].name);
                    $('#alias').val(result[0].alias);
                    $('#price').val(result[0].price);
                    $('#sales_price').val(result[0].sales_price);
                    $('#weight').val(result[0].weight);
                    $('#stock_managed' + result[0].stock_managed.toString() + '[name=stock_managed]').prop('checked', true);
                    $('#stock_default').val(result[0].stock_default);
                    $('#stock_min').val(result[0].stock_min);
                    $('#stock_max').val(result[0].stock_max);
                    $('#profit_min').val(result[0].profit_min);
                    $('#profit_best').val(result[0].profit_best);
                    $('#profit_max').val(result[0].profit_max);
                    $('#hpp').val(hpp);
                    $('#order_limit').val(result[0].order_limit);
                    $('#current_profit').val(current_profit);
                    $('#station').val(result[0].station);
                    $('#modal-form').modal('show');
                    $('#modal-form').on('shown.bs.modal', function(e) {
                        $(".select2-container--bootstrap4").removeAttr("style");
                        $("#id_category").select2({
                            theme: 'bootstrap4',
                            language: 'id'
                        });
                        $("#id_supplier").select2({
                            theme: 'bootstrap4',
                            language: 'id'
                        });
                        $("#weight_unit").select2({
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
        $('table.display').DataTable({
            responsive: true,
            pageLength: -1,
            dom: '<"html5buttons">lTfgitp',
            aLengthMenu: [
                [10, 20, 50, 100, -1],
                [10, 20, 50, 100, 'All']
            ]
        });
    });

    function separator(data) {
        return data.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }
</script>