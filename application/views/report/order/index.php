<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12 pad0">
            <div class="ibox ">
                <div class="ibox-title d-flex align-items-center justify-content-between">
                    <h5>Data Rekap Order</h5>
                </div>
                <div class="ibox-content">
                    <form method="post" id="filter_user" action="<?= base_url('report/order_excel/') ?>">
                        <div class="form-row align-items-center">
                            <div class="col-lg-4 my-1">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text width46"><svg style="width:20px;height:20px;margin:auto" viewBox="0 0 24 24">
                                                <path fill="#173b60" d="M19 20C19 21.11 18.11 22 17 22C15.89 22 15 21.1 15 20C15 18.89 15.89 18 17 18C18.11 18 19 18.9 19 20M7 18C5.89 18 5 18.89 5 20C5 21.1 5.89 22 7 22C8.11 22 9 21.11 9 20S8.11 18 7 18M7.2 14.63L7.17 14.75C7.17 14.89 7.28 15 7.42 15H19V17H7C5.89 17 5 16.1 5 15C5 14.65 5.09 14.32 5.24 14.04L6.6 11.59L3 4H1V2H4.27L5.21 4H20C20.55 4 21 4.45 21 5C21 5.17 20.95 5.34 20.88 5.5L17.3 11.97C16.96 12.58 16.3 13 15.55 13H8.1L7.2 14.63M8.5 11H10V9H7.56L8.5 11M11 9V11H14V9H11M14 8V6H11V8H14M17.11 9H15V11H16L17.11 9M18.78 6H15V8H17.67L18.78 6M6.14 6L7.08 8H10V6H6.14Z" />
                                            </svg></div>
                                    </div>
                                    <select name="filter_status" class="form-control" id="filter_status">
                                        <option></option>
                                        <?php foreach ($status as $x => $x_value) : ?>
                                            <option value="<?= $x; ?>" <?php if ($x == $filter_status) : ?> selected<?php endif; ?>><?= $x_value; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 my-1">
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
                            <div class="col-lg-2 my-1">
                                <button type="submit" class="btn btn-warning btn-block">Export</button>
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
                    <h5>Data Rekap Payment</h5>
                </div>
                <div class="ibox-content">
                    <form method="post" id="filter_user" action="<?= base_url('report/payment_excel/') ?>">
                        <div class="form-row align-items-center">
                            <div class="col-lg-4 my-1">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text width46"><svg style="width:20px;height:20px;margin:auto" viewBox="0 0 24 24">
                                                <path fill="#173b60" d="M19 20C19 21.11 18.11 22 17 22C15.89 22 15 21.1 15 20C15 18.89 15.89 18 17 18C18.11 18 19 18.9 19 20M7 18C5.89 18 5 18.89 5 20C5 21.1 5.89 22 7 22C8.11 22 9 21.11 9 20S8.11 18 7 18M7.2 14.63L7.17 14.75C7.17 14.89 7.28 15 7.42 15H19V17H7C5.89 17 5 16.1 5 15C5 14.65 5.09 14.32 5.24 14.04L6.6 11.59L3 4H1V2H4.27L5.21 4H20C20.55 4 21 4.45 21 5C21 5.17 20.95 5.34 20.88 5.5L17.3 11.97C16.96 12.58 16.3 13 15.55 13H8.1L7.2 14.63M8.5 11H10V9H7.56L8.5 11M11 9V11H14V9H11M14 8V6H11V8H14M17.11 9H15V11H16L17.11 9M18.78 6H15V8H17.67L18.78 6M6.14 6L7.08 8H10V6H6.14Z" />
                                            </svg></div>
                                    </div>
                                    <select name="filter_status" class="form-control" id="filter_status2">
                                        <option></option>
                                        <?php foreach ($status as $x => $x_value) : ?>
                                            <option value="<?= $x; ?>" <?php if ($x == $filter_status) : ?> selected<?php endif; ?>><?= $x_value; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 my-1">
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
                            <div class="col-lg-2 my-1">
                                <button type="submit" class="btn btn-warning btn-block">Export</button>
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
                    <h5>Data Rekap Purchase</h5>
                </div>
                <div class="ibox-content">
                    <form method="post" id="filter_user" action="<?= base_url('report/purchase_excel/') ?>">
                        <div class="form-row align-items-center">
                            <div class="col-lg-10 my-1">
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
                            <div class="col-lg-2 my-1">
                                <button type="submit" class="btn btn-warning btn-block">Export</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= core_script(); ?>
<?= datepicker(); ?>
<?= datatables(); ?>
<?= select2(); ?>
<script>
    $(document).ready(function() {
        $('.input-daterange').datepicker({
            keyboardNavigation: false,
            forceParse: false,
            autoclose: true
        });
        $("#filter_status").select2({
            placeholder: 'Pilih Order',
            theme: 'bootstrap4',
            language: 'id'
        });
        $("#filter_status2").select2({
            placeholder: 'Pilih Order',
            theme: 'bootstrap4',
            language: 'id'
        });
        $('#datatable').DataTable({
            pageLength: 25,
            responsive: true,
            dom: '<"html5buttons">lTfgitp',
        });
    });
</script>