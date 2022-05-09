<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12 pad0">
            <div class="ibox ">
                <div class="ibox-title d-flex align-items-center justify-content-between">
                    <h5>Tanggal Pengiriman</h5>
                </div>
                <div class="ibox-content">
                    <form method="post" id="filter_user">
                        <div class="form-row align-items-center">
                            <div class="col-lg-10 my-1">
                                <div class="input-group date">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text width46"><svg style="width:20px;height:20px;margin:auto" viewBox="0 0 24 24">
                                                <path fill="#173b60" d="M9,10H7V12H9V10M13,10H11V12H13V10M17,10H15V12H17V10M19,3H18V1H16V3H8V1H6V3H5C3.89,3 3,3.9 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V5A2,2 0 0,0 19,3M19,19H5V8H19V19Z"></path>
                                            </svg></div>
                                    </div>
                                    <input type="text" class="form-control" name="filter_date" placeholder="Input Tanggal" value="<?= $filter_date ?>" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-lg-2 my-1">
                                <button type="submit" class="btn btn-warning btn-block">Filter</button>
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
                    <h5>Data Rekap PO</h5>
                    <div class="btn-group">
                        <button data-toggle="dropdown" class="btn btn-primary btn-sm dropdown-toggle">
                            <svg width="16px" height="16px" viewBox="0 0 16 16" fill="currentColor">
                                <path fill-rule="evenodd" d="M2.5 11.5A.5.5 0 0 1 3 11h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4A.5.5 0 0 1 3 7h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4A.5.5 0 0 1 3 3h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z" />
                            </svg> Menu</button>
                        <ul class="dropdown-menu animated fadeInRight m-t-xs">
                            <li><a class='dropdown-item' href='<?= base_url(); ?>po/excel/<?= $filter_date ?>'>
                                    <svg class="mr-2" width="14px" height="14px" viewBox="0 0 16 16" fill="currentColor">
                                        <path fill-rule="evenodd" d="M.5 8a.5.5 0 0 1 .5.5V12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V8.5a.5.5 0 0 1 1 0V12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V8.5A.5.5 0 0 1 .5 8z" />
                                        <path fill-rule="evenodd" d="M5 7.5a.5.5 0 0 1 .707 0L8 9.793 10.293 7.5a.5.5 0 1 1 .707.707l-2.646 2.647a.5.5 0 0 1-.708 0L5 8.207A.5.5 0 0 1 5 7.5z" />
                                        <path fill-rule="evenodd" d="M8 1a.5.5 0 0 1 .5.5v8a.5.5 0 0 1-1 0v-8A.5.5 0 0 1 8 1z" />
                                    </svg> Export Excel</a></li>
                        </ul>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table id="datatable" class="table tablepo table-bordered table-striped table-sm" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Supplier</th>
                                    <th>Nama Produk</th>
                                    <th>Qty order/pack</th>
                                    <th>Berat</th>
                                    <th>Total</th>
                                    <th>Satuan</th>
                                    <th>Current Stock/pack</th>
                                    <th>Stock / satuan</th>
                                    <th>PO Open</th>
                                    <th>Input PO</th>
                                    <th>Catatan PO</th>
                                    <th>Catatan Produk</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                foreach ($recap as $data) :
                                ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= $data['supplier'] ?></td>
                                        <td><?= $data['nama_produk'] ?></td>
                                        <td class="text-right"><?= $data['qty'] ?></td>
                                        <td class="text-right"><?= $data['berat'] ?></td>
                                        <td class="text-right"><?= $data['total_berat'] ?></td>
                                        <td><?= $data['satuan'] ?></td>
                                        <td class="text-right"><?= $data['stock_physic'] ?></td>
                                        <td class="text-right"><?= $data['stock_physic_weight'] ?></td>
                                        <td class="text-right"><?= $openpo[$data['id_item']] ?></td>
                                        <td><input class="inputpo text-right" type="text" value="<?= $inputpo[$data['id_item']] ?>" data-id="<?= $data['id_item'] ?>" data-supplier="<?= $data['id_supplier'] ?>" data-name="<?= $data['nama_produk'] ?>" data-weight="<?= $data['berat'] ?>" data-unit="<?= $data['satuan'] ?>"></td>
                                        <td><textarea data-id="<?= $data['id_item'] ?>" name="notes[<?= $data['id_item'] ?>]"></textarea></td>
                                        <td><?= nl2br($data['note']) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <button id="submit" class="btn btn-warning btn-block">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= core_script(); ?>
<?= datepicker(); ?>
<?= toast(); ?>
<script>
    $(document).ready(function() {
        $('.date').datepicker({
            format: 'dd-mm-yyyy',
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            autoclose: true
        });
        $("#submit").on('click', function(e) {
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
                    object['filter_date'] = "<?= $filter_date ?>";
                    $('input.inputpo').each(function() {
                        qty_unit = $(this).val();
                        if (qty_unit !== "0" && qty_unit !== "") {
                            var item = {};
                            id = $(this).attr('data-id');
                            item['id_item'] = id;
                            item['id_supplier'] = $(this).attr('data-supplier');
                            item['name'] = $(this).attr('data-name');
                            item['qty'] = Math.floor(integer(qty_unit) / integer($(this).attr('data-weight')));
                            item['qty_unit'] = qty_unit;
                            item['notes'] = $('textarea[data-id=' + id + ']').val();
                            item['unit'] = $(this).attr('data-unit');
                            array.push(item);
                        }
                    });
                    object['item'] = array;
                    var jsonString = JSON.stringify(object);
                    $.ajax({
                        type: "POST",
                        url: '<?= base_url('po/input/') ?>',
                        data: {
                            data: jsonString
                        },
                        success: function(response) {
                            var result = $.parseJSON(response);
                            if (result.status == 'success') {
                                $.toast({
                                    heading: 'Success',
                                    text: 'Add PO',
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
                    $('#submit').prop('disabled', false);
                } else {
                    $('#submit').prop('disabled', false);
                }
            })
        });
    });

    function integer(data) {
        return Number(data.replace(/\D/g, ""));
    }
</script>