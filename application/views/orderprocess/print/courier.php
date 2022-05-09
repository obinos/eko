<link href="<?= base_url('assets/'); ?>vendor/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css" rel="stylesheet" type="text/css">
<style media="print">
    /* Use A5 paper */
    @page {
        size: 148mm 210mm;
        margin: 10mm 10mm;
    }

    .table-bordered td,
    .table-bordered th {
        border: 1px solid #000000 !important;
    }

    .content-print {
        width: 72%;
        font-size: 1rem;
        border: 0;
    }
</style>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12 pad0">
            <div class="ibox mb-3">
                <div class="ibox-content">
                    <form method="post" id="form">
                        <div class="form-row d-flex align-items-end">
                            <div class="col-xl-5 my-1">
                                <fieldset>
                                    <div class="row">
                                        <div class="col-sm-2 my-1">
                                            <strong>Station :</strong>
                                        </div>
                                        <div class="col-sm-10 pl-0 my-1">
                                            <?php foreach ($station as $val) { ?>
                                                <div class="form-check abc-checkbox abc-checkbox-success form-check-inline mr-0">
                                                    <input class="form-check-input" type="checkbox" name="filter_station[]" id="<?= $val ?>" value="<?= $val ?>" <?= filter_status($filter_station, $val) ?>>
                                                    <label class="form-check-label boolean" for="<?= $val ?>"> <?= $val ?> </label>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                            <div class="col-xl-5 my-1">
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
                                <button class="btn btn-warning btn-block btn-filter btn-lg">Filter</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php if ($print) { ?>
        <div class="alert alert-danger mb-2" role="alert">
            <p>Pastikan proses rute kurir sudah fix / selesai, sebelum klik tombol print. Di cetak di kertas A5</p>
        </div>
        <button class="btn btn-primary btn-block btn-lg mb-3 btn-print">Print</button>
        <div class="row">
            <?php foreach ($print as $k => $v) : ?>
                <div class="col-lg-6 pad0">
                    <div class="ibox">
                        <div class="ibox-title d-flex align-items-center justify-content-between bg-info">
                            <h5><?= $k ?></h5>
                        </div>
                        <div class="ibox-content">
                            <?php foreach ($v['item'] as $key => $data) : ?>
                                <div class="table-responsive content-print">
                                    <table class="table table-bordered table-striped table-sm" width="100%">
                                        <thead>
                                            <tr>
                                                <th width="10px">No</th>
                                                <th width="15px">Qty</th>
                                                <th><?= $k ?> - Produk Station <?= $key ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $no = 1;
                                            foreach ($data as $d) :
                                            ?>
                                                <tr>
                                                    <td class="text-right"><?= $no++; ?></td>
                                                    <td class="text-right"><?= $d->qty ?></td>
                                                    <td><?= $d->name ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php } ?>
</div>
<?= core_script(); ?>
<?= datepicker(); ?>
<?= toast(); ?>
<script src="<?= base_url('assets/'); ?>vendor/printThis/printThis.js"></script>
<script>
    $(document).ready(function() {
        $(".btn-print").click(function() {
            $(".content-print").printThis({
                importStyle: true
            });
        });
        $('.date').datepicker({
            format: 'dd-mm-yyyy',
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            autoclose: true
        });
        $(".btn-filter").click(function() {
            checked = $("input[type=checkbox]:checked").length;
            if (!checked) {
                $.toast({
                    heading: 'Silahkan',
                    text: 'pilih station dulu',
                    icon: 'error',
                    showHideTransition: 'slide',
                    hideAfter: 1500,
                    position: 'top-right'
                });
                return false;
            } else {
                $('#form').submit()
            }
        });
    });
</script>