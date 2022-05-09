<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12 pad0">
            <div class="ibox ">
                <div class="ibox-title d-flex align-items-center justify-content-between">
                    <h5>Data Pembelian</h5>
                    <div class="btn-group">
                        <button data-toggle="dropdown" class="btn btn-primary btn-sm dropdown-toggle">
                            <svg width="16px" height="16px" viewBox="0 0 16 16" fill="currentColor">
                                <path fill-rule="evenodd" d="M2.5 11.5A.5.5 0 0 1 3 11h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4A.5.5 0 0 1 3 7h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4A.5.5 0 0 1 3 3h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z" />
                            </svg> Menu</button>
                        <ul class="dropdown-menu animated fadeInRight m-t-xs">
                            <li><a class='dropdown-item aprint'>
                                    <svg class="mr-2" width="14px" height="14px" viewBox="0 0 16 16" fill="currentColor">
                                        <path d="M2.5 8a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z" />
                                        <path d="M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2H5zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4V3zm1 5a2 2 0 0 0-2 2v1H2a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v-1a2 2 0 0 0-2-2H5zm7 2v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1z" />
                                    </svg> Print</a></li>
                            <li><a class='dropdown-item pdfPurchase'>
                                    <svg class="mr-2" width="14px" height="14px" viewBox="0 0 16 16" fill="currentColor">
                                        <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5v2z" />
                                        <path d="M4.603 14.087a.81.81 0 0 1-.438-.42c-.195-.388-.13-.776.08-1.102.198-.307.526-.568.897-.787a7.68 7.68 0 0 1 1.482-.645 19.697 19.697 0 0 0 1.062-2.227 7.269 7.269 0 0 1-.43-1.295c-.086-.4-.119-.796-.046-1.136.075-.354.274-.672.65-.823.192-.077.4-.12.602-.077a.7.7 0 0 1 .477.365c.088.164.12.356.127.538.007.188-.012.396-.047.614-.084.51-.27 1.134-.52 1.794a10.954 10.954 0 0 0 .98 1.686 5.753 5.753 0 0 1 1.334.05c.364.066.734.195.96.465.12.144.193.32.2.518.007.192-.047.382-.138.563a1.04 1.04 0 0 1-.354.416.856.856 0 0 1-.51.138c-.331-.014-.654-.196-.933-.417a5.712 5.712 0 0 1-.911-.95 11.651 11.651 0 0 0-1.997.406 11.307 11.307 0 0 1-1.02 1.51c-.292.35-.609.656-.927.787a.793.793 0 0 1-.58.029zm1.379-1.901c-.166.076-.32.156-.459.238-.328.194-.541.383-.647.547-.094.145-.096.25-.04.361.01.022.02.036.026.044a.266.266 0 0 0 .035-.012c.137-.056.355-.235.635-.572a8.18 8.18 0 0 0 .45-.606zm1.64-1.33a12.71 12.71 0 0 1 1.01-.193 11.744 11.744 0 0 1-.51-.858 20.801 20.801 0 0 1-.5 1.05zm2.446.45c.15.163.296.3.435.41.24.19.407.253.498.256a.107.107 0 0 0 .07-.015.307.307 0 0 0 .094-.125.436.436 0 0 0 .059-.2.095.095 0 0 0-.026-.063c-.052-.062-.2-.152-.518-.209a3.876 3.876 0 0 0-.612-.053zM8.078 7.8a6.7 6.7 0 0 0 .2-.828c.031-.188.043-.343.038-.465a.613.613 0 0 0-.032-.198.517.517 0 0 0-.145.04c-.087.035-.158.106-.196.283-.04.192-.03.469.046.822.024.111.054.227.09.346z" />
                                    </svg> Export PDF</a></li>
                            <li><a class='dropdown-item' href='<?= base_url('purchase/repeat_purchase/' . $purchase[0]['_id']); ?>'>
                                    <svg class="mr-2" width="14px" height="14px" viewBox="0 0 16 16" fill="currentColor">
                                        <path d="M9 5.5a.5.5 0 0 0-1 0V7H6.5a.5.5 0 0 0 0 1H8v1.5a.5.5 0 0 0 1 0V8h1.5a.5.5 0 0 0 0-1H9V5.5z" />
                                        <path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zm3.915 10L3.102 4h10.796l-1.313 7h-8.17zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z" />
                                    </svg> Ulangi Pembelian</a></li>
                            <?php if (hplus1($purchase[0]['created_at']) && $purchase[0]['is_cancel'] !== true) { ?>
                                <li><a class='dropdown-item' href='<?= base_url('purchase/edit_purchase/' . $purchase[0]['_id']); ?>'>
                                        <svg class="mr-2" width="14px" height="14px" viewBox="0 0 16 16" fill="currentColor">
                                            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                                        </svg> Edit Pembelian</a></li>
                            <?php } ?>
                            <?php if ($purchase[0]['is_cancel'] !== true) { ?>
                                <li><a class='dropdown-item del-button' data-id='<?= $purchase[0]['_id'] ?>'>
                                        <svg class="mr-2" width="14px" height="14px" viewBox="0 0 16 16" fill="currentColor">
                                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z" />
                                            <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                                        </svg> Batalkan Pembelian</a></li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
                <div class="ibox-content content-print">
                    <div class="row justify-content-center d-flex align-items-center">
                        <div class="col-lg-6">
                            <table class="table mb-0">
                                <tbody>
                                    <tr>
                                        <td style="width: 80px">
                                            No
                                        </td>
                                        <td class="text-left">
                                            <strong>: <?= $purchase[0]['no'] ?></strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 80px">
                                            Supplier
                                        </td>
                                        <td class="text-left">
                                            <strong>: <?= $purchase[0]['supplier'] ?></strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 80px">
                                            Tanggal
                                        </td>
                                        <td class="text-left">
                                            <strong>: <?= $purchase[0]['transaction_date'] ?></strong>
                                        </td>
                                    </tr>
                                    <tr class="border-bottom">
                                        <td style="width: 80px">
                                            Maker
                                        </td>
                                        <td class="text-left">
                                            <strong>: <?= $purchase[0]['usermaker'] ?></strong>
                                        </td>
                                    </tr>
                                    <?php if ($purchase[0]['userupdate']) { ?>
                                        <tr class="border-bottom">
                                            <td style="width: 80px">
                                                Editor
                                            </td>
                                            <td class="text-left">
                                                <strong>: <?= $purchase[0]['userupdate'] ?></strong>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                    <?php if ($purchase[0]['pono']) { ?>
                                        <tr class="border-bottom">
                                            <td style="width: 80px">
                                                Nomer PO
                                            </td>
                                            <td class="text-left">
                                                <strong>: <?= $purchase[0]['pono'] ?></strong>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-lg-6">
                            <?php if ($purchase[0]["file"]) { ?>
                                <img class="img-fluid mx-auto d-block" src="<?= base_url('assets/uploads/invoice/' . $purchase[0]["file"]); ?>" width="40%">
                            <?php } ?>
                        </div>
                        <div class="col-lg-12 mt-3">
                            <div class="table-responsive">
                                <table class="table table-striped table-sm display table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width: 3%">No</th>
                                            <th style="width: 7%">SKU</th>
                                            <th style="width: 5%">Station</th>
                                            <th style="width: 35%">Nama Produk</th>
                                            <th style="width: 10%" class="text-right">Qty Beli</th>
                                            <th style="width: 10%">Unit</th>
                                            <th style="width: 10%" class="text-right">Qty Pack</th>
                                            <th style="width: 10%" class="text-right">Harga Per Pack</th>
                                            <th style="width: 10%" class="text-right">Total Harga</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        foreach ($item as $i) :
                                        ?>
                                            <tr>
                                                <td class="text-right"><?= $no++; ?></td>
                                                <td><?= $i['barcode'] ?></td>
                                                <td class="<?= $i['colorstation'] ?>"><?= $i['station'] ?></td>
                                                <td><?= $i['name'] ?></td>
                                                <td class="text-right"><?= $i['qty_unit'] ?></td>
                                                <td><?= $i['unit'] ?></td>
                                                <td class="text-right"><?= thousand($i['qty']) ?></td>
                                                <td class="text-right"><?= thousand($i['price']) ?></td>
                                                <td class="text-right"><?= thousand($i['total_price']) ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th class="text-right" colspan="8">Total</th>
                                            <th class="text-right"><?= thousand($purchase[0]['total']); ?></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="alert alert-warning" role="alert">
                                <p>Note: <b><?= $purchase[0]['notes']; ?></b></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= core_script(); ?>
<?= toast(); ?>
<script src="<?= base_url('assets/'); ?>vendor/printThis/printThis.js"></script>
<script>
    $(document).ready(function() {
        $('.aprint').click(function(e) {
            $(".content-print").printThis();
        });
        $('.pdfPurchase').click(function() {
            window.location = "<?= base_url('purchase/pdf/' . $purchase[0]['_id']) ?>";
        });
        $('.del-button').on('click', function(e) {
            e.preventDefault();
            var id = $(this).attr('data-id');
            Swal({
                title: 'Batalkan Pembelian ?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#45eba5',
                cancelButtonColor: '#fd8664',
                confirmButtonText: 'Yes',
                cancelButtonText: 'No'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        type: "POST",
                        url: '<?= base_url('purchase/cancel_purchase') ?>',
                        data: {
                            data: id
                        },
                        success: function(response) {
                            var result = $.parseJSON(response);
                            if (result.status == 'success') {
                                $.toast({
                                    heading: 'Success',
                                    text: 'Batalkan Pembelian ' + result.no,
                                    icon: 'success',
                                    showHideTransition: 'slide',
                                    hideAfter: 2000,
                                    position: 'top-right',
                                    afterHidden: function() {
                                        window.location = "<?= base_url('purchase/index') ?>";
                                    }
                                });
                            } else {
                                $.toast({
                                    heading: 'Failed',
                                    text: 'Batalkan Pembelian ' + result.no,
                                    icon: 'error',
                                    showHideTransition: 'slide',
                                    hideAfter: 2000,
                                    position: 'top-right'
                                });
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.log(textStatus, errorThrown);
                        }
                    });
                }
            })
        });
    });
</script>