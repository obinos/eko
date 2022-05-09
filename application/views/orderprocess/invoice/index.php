<style media="print">
    /* Use A5 paper */
    @page {
        size: 148mm 210mm;
        margin: 10mm 10mm;
    }

    .dvbreak {
        page-break-after: always;
    }

    .table-bordered td,
    .table-bordered th {
        border: 1px solid #000000 !important;
    }

    .ibox-content {
        width: 140mm;
        font-size: 0.7rem;
        border: 0;
    }

    h1 {
        color: black;
    }

    .dvheader {
        display: table-header-group;
    }

    .tbproduk {
        margin-bottom: 10mm;
    }
</style>

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
                    <h5>Data Order</h5>
                    <a class='aprint btn btn-primary btn-sm text-dark'>
                        <svg width="14px" height="14px" viewBox="0 0 16 16" fill="currentColor">
                            <path d="M2.5 8a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z" />
                            <path d="M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2H5zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4V3zm1 5a2 2 0 0 0-2 2v1H2a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v-1a2 2 0 0 0-2-2H5zm7 2v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1z" />
                        </svg> Print</a>
                </div>
                <div class="ibox-content content-print">
                    <?php
                    foreach ((array)$order as $data) : if ($data['id_courier']) $data['id_courier'] = '(' . $data['id_courier'] . ')';
                    ?>
                        <div class="row justify-content-center align-items-center mb-1">
                            <div class="col-6">
                                <div class="text-<?= packinglist_payment($data['payment'][0]->method, $message[0]["qris"]) ?>">
                                    <img src="<?= base_url('assets/'); ?>img/aratamart_logo.png" class="img-fluid" width="150px">
                                    <h2>Invoice</h2>
                                </div>
                            </div>
                            <?php if ($message[0]["qris"]) {
                                if (strpos($data['payment'][0]->method, 'COD') !== false && getimagesize(base_url('assets/uploads/' . $message[0]["qris"])) !== false) { ?>
                                    <div class="col-6">
                                        <div class="text-right">
                                            <img src="<?= base_url('assets/uploads/' . $message[0]["qris"]); ?>" class="img-fluid" width="150px">
                                        </div>
                                    </div>
                            <?php }
                            } ?>
                        </div>
                        <div class="table-responsive">
                            <table class="tbheader table table-striped table-sm display" width="100%">
                                <tbody>
                                    <tr>
                                        <td><b>Penerima</b></td>
                                        <td><?= $data['recipient']->name ?></td>
                                        <td><b>No Order</b></td>
                                        <td><?= $data['invno'] . ' ' . $data['id_courier'] ?></td>
                                    </tr>
                                    <tr>
                                        <td><b>Alamat</b></td>
                                        <td><?= $data['recipient']->address ?></td>
                                        <td><b>Pengiriman</b></td>
                                        <td><?= datephp('d M y', $data['delivery_time']) . ' - ' . ucwords($data['delivery_shift']) ?></td>
                                    </tr>
                                    <tr>
                                        <td><b>No HP</b></td>
                                        <td><?= $data['recipient']->phone ?></td>
                                        <td><b>Metode Pembayaran</b></td>
                                        <td><?= payment_string($data['payment']) ?></td>
                                    </tr>
                                </tbody>
                            </table>
                            <p>Catatan Penjual: <b><?= nl2br($data['merchant_notes']); ?></b></p>
                            <BR>
                            <table class="tbproduk table table-striped table-sm display  table-bordered" width="100%">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th width="60%">Nama Produk</th>
                                        <th width="5%" class="text-right">Qty</th>
                                        <?php if ($data['is_dropship'] == false) { ?>
                                            <th width="15%" class="text-right">Harga</th>
                                            <th width="15%" class="text-right">Total</th>
                                        <?php } ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    foreach ($data['items'] as $item) :
                                        if ($item['note']) {
                                            $note = "<br><small>" . $item['note'] . "<small>";
                                        } else {
                                            $note = null;
                                        }
                                    ?>
                                        <tr>
                                            <td align="right"><?= $no++; ?></td>
                                            <td><?= $item['name'] . $note ?></td>
                                            <td align="right"><?= $item['qty'] ?></td>
                                            <?php if ($data['is_dropship'] == false) { ?>
                                                <td align="right"><?= thousand($item['price']) ?></td>
                                                <td align="right"><?= thousand($item['qty'] * $item['price']) ?></td>
                                            <?php } ?>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <?php if ($data['is_dropship'] == false) { ?>
                                    <tfoot>
                                        <tr>
                                            <th class="text-right" colspan="4">Subtotal</th>
                                            <th class="text-right"><?= thousand($data['price']->subtotal); ?></th>
                                        </tr>
                                        <tr>
                                            <th class="text-right" colspan="4">Ongkir</th>
                                            <th class="text-right"><?= thousand($data['price']->shipping); ?></th>
                                        </tr>
                                        <?php if ($data['voucher']) { ?>
                                            <tr>
                                                <th class="text-right" colspan="4">Voucher (<?= $data['voucher'] ?>)</th>
                                                <th class="text-right">- <?= thousand($data['price']->discount); ?></th>
                                            </tr>
                                        <?php } ?>
                                        <tr>
                                            <th class="text-right" colspan="4">Total</th>
                                            <th class="text-right"><?= thousand($data['price']->total); ?></th>
                                        </tr>
                                    </tfoot>
                                <?php } ?>
                            </table>
                            <div class="dvbreak"></div>
                        </div>
                        <br>
                        <br>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?= core_script(); ?>
<?= datepicker(); ?>
<script src="<?= base_url('assets/'); ?>vendor/printThis/printThis.js"></script>
<script>
    $(document).ready(function() {
        $('.date').datepicker({
            format: 'dd-mm-yyyy',
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            autoclose: true
        });
        $('.aprint').click(function(e) {
            $(".content-print").printThis({
                importStyle: true, // import style tags
            });
        });
    });
</script>