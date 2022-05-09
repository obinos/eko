<link href="<?= base_url('assets/'); ?>vendor/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css" rel="stylesheet" type="text/css">
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12 pad0">
            <div class="ibox ">
                <div class="ibox-title d-flex align-items-center justify-content-between">
                    <h5>Filter Order</h5>
                </div>
                <div class="ibox-content">
                    <form method="post" id="form">
                        <div class="form-row d-flex align-items-center">
                            <div class="col-xl-5 my-1">
                                <fieldset>
                                    <div class="row">
                                        <div class="col-sm-2 my-1">
                                            <strong>Order :</strong>
                                        </div>
                                        <div class="col-sm-10 pl-0 my-1">
                                            <?php foreach ($status as $key => $val) { ?>
                                                <div class="form-check abc-checkbox abc-checkbox-success form-check-inline mr-0">
                                                    <input class="form-check-input" type="checkbox" name="filter_status[]" id="<?= $key ?>" value="<?= $key ?>" <?= filter_status($filter_status, $key) ?>>
                                                    <label class="form-check-label boolean" for="<?= $key ?>"> <?= $val ?> </label>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                            <div class="col-xl-5 my-1">
                                <div class="input-daterange input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text width46"><svg style="width:20px;height:20px;margin:auto" viewBox="0 0 24 24">
                                                <path fill="#173b60" d="M9,10H7V12H9V10M13,10H11V12H13V10M17,10H15V12H17V10M19,3H18V1H16V3H8V1H6V3H5C3.89,3 3,3.9 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V5A2,2 0 0,0 19,3M19,19H5V8H19V19Z"></path>
                                            </svg></div>
                                    </div>
                                    <input type="search" class="form-control" name="filter_start" placeholder="Start Date" value="<?= value($filter_start) ?>" autocomplete="off">
                                    <input type="search" class="form-control" name="filter_end" placeholder="End Date" value="<?= value($filter_end) ?>" autocomplete="off">
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
    <div class="row">
        <div class="col-lg-12 pad0">
            <div class="ibox ">
                <div class="ibox-title d-flex align-items-center justify-content-between">
                    <h5>Rekap Produk</h5>
                    <form method="post" action="<?= base_url('recapitem/excel/') ?>">
                        <?php foreach ($filter_status as $stat) { ?>
                            <input type="hidden" name="excel_status[]" value="<?= $stat ?>">
                        <?php } ?>
                        <input type="hidden" name="excel_start" value="<?= $filter_start ?>">
                        <input type="hidden" name="excel_end" value="<?= $filter_end ?>">
                        <button class='btn btn-primary btn-sm export-excel' type="submit">
                            <svg class="mr-2" width="14px" height="14px" viewBox="0 0 16 16" fill="currentColor">
                                <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V9H3V2a1 1 0 0 1 1-1h5.5v2zM3 12v-2h2v2H3zm0 1h2v2H4a1 1 0 0 1-1-1v-1zm3 2v-2h3v2H6zm4 0v-2h3v1a1 1 0 0 1-1 1h-2zm3-3h-3v-2h3v2zm-7 0v-2h3v2H6z" />
                            </svg>Export Excel</button>
                    </form>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table id="datatable" class="table table-bordered table-striped table-sm" width="100%">
                            <thead>
                                <tr>
                                    <th class="text-center" width="10px">No</th>
                                    <th class="text-center">SKU</th>
                                    <th class="text-center">Station</th>
                                    <th class="text-center">Supplier</th>
                                    <th class="text-center">Nama Produk</th>
                                    <th class="text-center" width="5%">Qty order/ pack</th>
                                    <th class="text-center">Detail Qty</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                foreach ($recap as $data) :
                                ?>
                                    <tr>
                                        <td class="text-right"><?= $no++; ?></td>
                                        <td><?= $data['sku'] ?></td>
                                        <td><?= $data['station'] ?></td>
                                        <td><?= $data['supplier'] ?></td>
                                        <td><?= $data['nama_produk'] ?></td>
                                        <td class="text-right"><?= $data['qty'] ?></td>
                                        <td><?= $data['penerima'] ?></td>
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
<?= core_script(); ?>
<?= datatables(); ?>
<?= datepicker(); ?>
<?= toast(); ?>
<script>
    $(document).ready(function() {
        $('.input-daterange').datepicker({
            keyboardNavigation: false,
            forceParse: false,
            autoclose: true
        });
        $(".btn-filter").click(function() {
            checked = $("input[type=checkbox]:checked").length;
            if (!checked) {
                $.toast({
                    heading: 'Silahkan',
                    text: 'pilih status order',
                    icon: 'warning',
                    showHideTransition: 'slide',
                    hideAfter: 1500,
                    position: 'top-right'
                });
                return false;
            } else {
                $('#form').submit()
            }
        });
        $('#datatable').DataTable({
            pageLength: -1,
            responsive: true,
            dom: '<"html5buttons">lTfgitp',
            order: [
                [2, 'asc']
            ],
            aLengthMenu: [
                [25, 50, 100, -1],
                ['25', '50', '100', 'All']
            ]
        });
    });
</script>