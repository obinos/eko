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
        <button class="btn btn-primary btn-block btn-lg mb-3 btn-print">Print</button>
        <div class="row">
            <div class="col-lg-12 pad0">
                <div class="ibox">
                    <div class="ibox-title justify-content-between">
                        <h5>Data Rekap</h5>
                    </div>
                    <div class="ibox-content">
                        <?php $dateindo = dateindo((strtotime($filter_date) * 1000), 'd-m-Y');
                        foreach ($station as $key => $val) : ?>
                            <div class="table-responsive">
                                <table id="datatable" class="table table-bordered table-sm content-print" width="100%">
                                    <thead>
                                        <tr>
                                            <th colspan="2">
                                                <p>Nama Station: <?= $key ?></p>
                                            </th>
                                            <th colspan="3">
                                                <p class="text-right">Tgl Kirim: <?= $dateindo ?></p>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th class="text-center" width="2%">
                                                <p>No</p>
                                            </th>
                                            <th class="text-center" width="30%">
                                                <p>Nama Produk</p>
                                            </th>
                                            <th class="text-center" width="43%">
                                                <p>Catatan</p>
                                            </th>
                                            <th class="text-center" width="7%">
                                                <p>Req</p>
                                            </th>
                                            <th class="text-center" width="8%">
                                                <p>Total</p>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        $keys = array_column($val, 'nama_produk');
                                        array_multisort($keys, SORT_ASC, $val);
                                        foreach ($val as $data) :
                                            if ($data['nama_produk'] == 'Special Request' && $data['note']) {
                                                $note = "<br>" . $data['note'];
                                            } else {
                                                $note = null;
                                            }
                                        ?>
                                            <tr>
                                                <td class="text-right">
                                                    <h6 class="font-weight-normal my-0"><?= $no++; ?></h6>
                                                </td>
                                                <td>
                                                    <h6 class="font-weight-normal my-0"><?= $data['nama_produk'] . $note ?></h6>
                                                </td>
                                                <td>
                                                    <h6 class="font-weight-normal my-0"><?= nl2br($data['note']) ?></h6>
                                                </td>
                                                <td class="text-right">
                                                    <h6 class="font-weight-normal my-0"><?= $data['qty2'] ? $data['qty2'] : $data['qty'] ?></h6>
                                                </td>
                                                <td class="text-right">
                                                    <h6 class="font-weight-normal my-0"><?= $data['total_berat'] . ' ' . $data['satuan'] ?></h6>
                                                    <!-- <h6 class="font-weight-normal my-0"><?= $data['qty'] * $data['berat'] . ' ' . $data['satuan'] ?></h6> -->
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endforeach; ?>
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
            $(".content-print").printThis();
        });
    });
</script>