<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12 pad0">
            <div class="ibox mb-3">
                <div class="ibox-content">
                    <form method="post" id="form">
                        <div class="form-row d-flex align-items-end">
                            <div class="col-xl-10 my-1">
                                <p class="mb-1">Tanggal Kirim</p>
                                <div class="input-group date">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text width46"><svg style="width:20px;height:20px;margin:auto" viewBox="0 0 24 24">
                                                <path fill="#173b60" d="M9,10H7V12H9V10M13,10H11V12H13V10M17,10H15V12H17V10M19,3H18V1H16V3H8V1H6V3H5C3.89,3 3,3.9 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V5A2,2 0 0,0 19,3M19,19H5V8H19V19Z"></path>
                                            </svg></div>
                                    </div>
                                    <input type="text" class="form-control" name="filter_date" placeholder="Input Tanggal" value="<?= $filter_date ?>" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-xl-2 my-1">
                                <button class="btn btn-warning btn-block btn-filter">Filter</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php if ($station) { ?>
        <div class="alert alert-danger mb-2" role="alert">
            <p>Pastikan proses rute kurir sudah fix / selesai, sebelum klik tombol print</p>
        </div>
        <button class="btn btn-primary btn-block btn-lg mb-3 btn-print">Print</button>
        <div class="row">
            <div class="col-lg-12 pad0">
                <div class="ibox">
                    <div class="ibox-title justify-content-between">
                        <h5>Data Stocker</h5>
                    </div>
                    <div class="ibox-content">
                        <?php $dateindo = dateindo((strtotime($filter_date) * 1000), 'd-m-Y');
                        foreach ($station as $key => $val) : ?>
                            <div class="table-responsive">
                                <table id="datatable" class="table table-bordered table-sm content-print" width="100%">
                                    <thead>
                                        <tr>
                                            <th colspan="5">
                                                <p>Nama Station: <?= $key ?></p>
                                            </th>
                                            <th colspan="5">
                                                <p class="text-right">Tgl Kirim: <?= $dateindo ?></p>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th class="text-center" width="3%">
                                                <p>No</p>
                                            </th>
                                            <th class="text-center" width="32%">
                                                <p>Nama Produk</p>
                                            </th>
                                            <th class="text-center" width="10%">
                                                <p>Qty order per pack</p>
                                            </th>
                                            <th class="text-center" width="5%">
                                                <p>Stock Awal</p>
                                            </th>
                                            <th class="text-center" width="5%">
                                                <p>Stock Masuk</p>
                                            </th>
                                            <th class="text-center" width="5%">
                                                <p>Brg Siap Dijual</p>
                                            </th>
                                            <th class="text-center" width="5%">
                                                <p>Sisa Stock (gram)</p>
                                            </th>
                                            <th class="text-center" width="5%">
                                                <p>Sisa Reject</p>
                                            </th>
                                            <th class="text-center" width="30%">
                                                <p>Detail Qty</p>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        $keys = array_column($val, 'nama_produk');
                                        array_multisort($keys, SORT_ASC, $val);
                                        foreach ($val as $data) :
                                        ?>
                                            <tr>
                                                <td class="text-right">
                                                    <h3 class="font-weight-normal my-0"><?= $no++; ?></h3>
                                                </td>
                                                <td>
                                                    <h3 class="font-weight-normal my-0"><?= $data['nama_produk'] ?></h3>
                                                </td>
                                                <td class="text-right">
                                                    <h3 class="font-weight-normal my-0"><?= $data['qty2'] ? $data['qty2'] : $data['qty'] ?></h3>
                                                </td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td>
                                                    <h3 class="font-weight-normal my-0"><?= $data['total_courier'] ?></h3>
                                                    <h3 class="font-weight-normal my-0"><?= nl2br($data['note']) ?></h3>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php if ($key == '4' || $key == '5A' || $key == '5B' || $key == '5C') { ?>
                                <div class="display" id="break_page" style='page-break-after:always'></div>
                        <?php }
                        endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
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
        $(".btn-print").click(function() {
            $(".content-print, #break_page").printThis();
        });
    });
</script>