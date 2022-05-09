<div class="wrapper wrapper-content animated fadeInRight align-items-center justify-content-between">
    <div class="row">
        <div class="col-lg-12 pad0">
            <div class="ibox ">
                <div class="ibox-content">
                    <div class="form-row align-items-center">
                        <div class="col-12">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text width46"><svg style="width:20px;height:20px;margin:auto" viewBox="0 0 24 24">
                                            <path fill="#173b60" d="M3,22L4.5,20.5L6,22L7.5,20.5L9,22L10.5,20.5L12,22L13.5,20.5L15,22L16.5,20.5L18,22L19.5,20.5L21,22V2L19.5,3.5L18,2L16.5,3.5L15,2L13.5,3.5L12,2L10.5,3.5L9,2L7.5,3.5L6,2L4.5,3.5L3,2M18,9H6V7H18M18,13H6V11H18M18,17H6V15H18V17Z" />
                                        </svg></div>
                                </div>
                                <input type="text" class="form-control" id="noinvoice" placeholder="Search Invoice" autocomplete="off">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6 pad0">
            <div class="ibox mb-0">
                <div class="ibox-title d-flex align-items-center justify-content-between">
                    <h5>Data Order</h5>
                </div>
                <div class="ibox-content data-analytics">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 pad0">
                            <div class="card bg-success mb-3">
                                <div class="widget style1">
                                    <div class="row align-items-center">
                                        <div class="col-4">
                                            <svg width="60px" height="60px" viewBox="0 0 16 16" fill="currentColor">
                                                <path d="M9 5.5a.5.5 0 0 0-1 0V7H6.5a.5.5 0 0 0 0 1H8v1.5a.5.5 0 0 0 1 0V8h1.5a.5.5 0 0 0 0-1H9V5.5z" />
                                                <path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zm3.915 10L3.102 4h10.796l-1.313 7h-8.17zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z" />
                                            </svg>
                                        </div>
                                        <div class="col-8 text-right">
                                            <span>Order Baru</span>
                                            <h2 class="font-bold order-open"><?= $count_open ? $count_open : 0 ?></h2>
                                            <span class="font-bold"><?= rupiah($total_open ? $total_open : 0) ?></span>
                                        </div>
                                    </div>
                                </div>
                                <a class="card-footer d-flex align-items-center justify-content-between text-dark list-order-open">
                                    <p>View List</p>
                                    <div class="text-white"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#212121" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M9 18l6-6-6-6" />
                                        </svg>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 pad0">
                            <div class="card bg-warning mb-3">
                                <div class="widget style1">
                                    <div class="row align-items-center">
                                        <div class="col-4">
                                            <svg width="60px" height="60px" viewBox="0 0 16 16" fill="currentColor">
                                                <path d="M6.5 7a.5.5 0 0 0 0 1h4a.5.5 0 0 0 0-1h-4z" />
                                                <path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zm3.915 10L3.102 4h10.796l-1.313 7h-8.17zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z" />
                                            </svg>
                                        </div>
                                        <div class="col-8 text-right">
                                            <span>Order Diproses</span>
                                            <h2 class="font-bold order-onprocess"><?= $count_onprocess ? $count_onprocess : 0 ?></h2>
                                            <span class="font-bold"><?= rupiah($total_onprocess ? $total_onprocess : 0) ?></span>
                                        </div>
                                    </div>
                                </div>
                                <a class="card-footer d-flex align-items-center justify-content-between text-dark list-order-onprocess">
                                    <p>View List</p>
                                    <div class="text-white"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#212121" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M9 18l6-6-6-6" />
                                        </svg>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 pad0">
            <div class="ibox mb-0">
                <div class="ibox-title d-flex align-items-center justify-content-between">
                    <h5>Tanggal Pengiriman</h5>
                    <button class="btn btn-sm btn-primary" id="date-close-cancel">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-1">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="16" y1="2" x2="16" y2="6"></line>
                            <line x1="8" y1="2" x2="8" y2="6"></line>
                            <line x1="3" y1="10" x2="21" y2="10"></line>
                        </svg>
                        <span><?= date('d-m-Y') . ' - ' . date('d-m-Y') ?></span>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down ml-1">
                            <polyline points="6 9 12 15 18 9"></polyline>
                        </svg>
                    </button>
                </div>
                <div class="ibox-content data-analytics">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 pad0">
                            <div class="card bg-primary mb-3">
                                <div class="widget style1">
                                    <div class="row align-items-center">
                                        <div class="col-4">
                                            <svg width="60px" height="60px" viewBox="0 0 16 16" fill="currentColor">
                                                <path d="M11.354 6.354a.5.5 0 0 0-.708-.708L8 8.293 6.854 7.146a.5.5 0 1 0-.708.708l1.5 1.5a.5.5 0 0 0 .708 0l3-3z" />
                                                <path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zm3.915 10L3.102 4h10.796l-1.313 7h-8.17zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z" />
                                            </svg>
                                        </div>
                                        <div class="col-8 text-right">
                                            <span>Order Terkirim</span>
                                            <h2 class="font-bold order-closed"><?= $count_closed ? $count_closed : 0 ?></h2>
                                            <span class="font-bold total-closed"><?= rupiah($total_closed ? $total_closed : 0) ?></span>
                                        </div>
                                    </div>
                                </div>
                                <a class="card-footer d-flex align-items-center justify-content-between text-dark list-order-closed">
                                    <p>View List</p>
                                    <div class="text-white"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#212121" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M9 18l6-6-6-6" />
                                        </svg>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 pad0">
                            <div class="card bg-danger mb-3">
                                <div class="widget style1">
                                    <div class="row align-items-center">
                                        <div class="col-4">
                                            <svg width="60px" height="60px" viewBox="0 0 16 16" fill="currentColor">
                                                <path d="M7.354 5.646a.5.5 0 1 0-.708.708L7.793 7.5 6.646 8.646a.5.5 0 1 0 .708.708L8.5 8.207l1.146 1.147a.5.5 0 0 0 .708-.708L9.207 7.5l1.147-1.146a.5.5 0 0 0-.708-.708L8.5 6.793 7.354 5.646z" />
                                                <path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1H.5zm3.915 10L3.102 4h10.796l-1.313 7h-8.17zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0zm7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0z" />
                                            </svg>
                                        </div>
                                        <div class="col-8 text-right">
                                            <span>Order Batal</span>
                                            <h2 class="font-bold order-canceled"><?= $count_canceled ? $count_canceled : 0 ?></h2>
                                            <span class="font-bold total-canceled"><?= rupiah($total_canceled ? $total_canceled : 0) ?></span>
                                        </div>
                                    </div>
                                </div>
                                <a class="card-footer d-flex align-items-center justify-content-between text-dark list-order-canceled">
                                    <p>View List</p>
                                    <div class="text-white"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#212121" stroke-width="3" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M9 18l6-6-6-6" />
                                        </svg>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <a href="<?= base_url('order/gift'); ?>" class="btn btn-info btn-block btn-lg my-3">Order Gift</a>
    <div class="row">
        <div class="col-lg-12 pad0">
            <div class="ibox ">
                <div class="ibox-title d-flex align-items-center justify-content-between">
                    <h5>Unique Customer</h5>
                    <button class="btn btn-sm btn-primary" id="unique_customer">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-1">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="16" y1="2" x2="16" y2="6"></line>
                            <line x1="8" y1="2" x2="8" y2="6"></line>
                            <line x1="3" y1="10" x2="21" y2="10"></line>
                        </svg>
                        <span><?= date('d-m-Y') . ' - ' . date('d-m-Y') ?></span>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-down ml-1">
                            <polyline points="6 9 12 15 18 9"></polyline>
                        </svg>
                    </button>
                </div>
                <div class="ibox-content data-analytics">
                    <div class="row">
                        <div class="col-lg-3 col-md-6 col-sm-6 pad0">
                            <div class="card bg-success mb-3">
                                <div class="widget style1">
                                    <div class="row align-items-center">
                                        <div class="col-4">
                                            <svg width="60px" height="60px" viewBox="0 0 16 16" fill="currentColor">
                                                <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                                                <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z" />
                                            </svg>
                                        </div>
                                        <div class="col-8 text-right">
                                            <span>Order Baru</span>
                                            <h2 class="font-bold unique-open"><?= $uniqueopen ?></h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 pad0">
                            <div class="card bg-warning mb-3">
                                <div class="widget style1">
                                    <div class="row align-items-center">
                                        <div class="col-4">
                                            <svg width="60px" height="60px" viewBox="0 0 16 16" fill="currentColor">
                                                <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                                                <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z" />
                                            </svg>
                                        </div>
                                        <div class="col-8 text-right">
                                            <span>Order Onprocess</span>
                                            <h2 class="font-bold unique-onprocess"><?= $uniqueonprocess ?></h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 pad0">
                            <div class="card bg-primary mb-3">
                                <div class="widget style1">
                                    <div class="row align-items-center">
                                        <div class="col-4">
                                            <svg width="60px" height="60px" viewBox="0 0 16 16" fill="currentColor">
                                                <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                                                <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z" />
                                            </svg>
                                        </div>
                                        <div class="col-8 text-right">
                                            <span>Order Terkirim</span>
                                            <h2 class="font-bold unique-closed"><?= $uniqueclosed ?></h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-sm-6 pad0">
                            <div class="card bg-danger mb-3">
                                <div class="widget style1">
                                    <div class="row align-items-center">
                                        <div class="col-4">
                                            <svg width="60px" height="60px" viewBox="0 0 16 16" fill="currentColor">
                                                <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                                                <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z" />
                                            </svg>
                                        </div>
                                        <div class="col-8 text-right">
                                            <span>Order Batal</span>
                                            <h2 class="font-bold unique-canceled"><?= $uniquecanceled ?></h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= core_script(); ?>
<?= daterangepicker(); ?>
<?= toast(); ?>
<script src="<?= base_url('assets/'); ?>vendor/typehead/bootstrap3-typeahead.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        <?php if ($name) { ?>
            $.toast({
                heading: 'Welcome Back',
                text: '<?= $name ?>',
                icon: 'success',
                showHideTransition: 'slide',
                hideAfter: 1500,
                position: 'top-right'
            });
        <?php } ?>
        $('#noinvoice').typeahead({
            items: 20,
            source: <?= $all_order ?>,
            displayText: function(item) {
                return item.invno + ' ' + item.customer.name + ' (' + item.customer.phone + ') - ' + item.recipient.name + ' (' + item.recipient.phone + ')';
            },
            afterSelect: function(event) {
                if (event._id.$oid)
                    var id = event._id.$oid;
                else
                    var id = event._id;
                window.location = "<?= base_url('order/view/'); ?>" + id;
            }
        });
        var start = moment();
        var end = moment();
        $('#date-close-cancel').daterangepicker({
            startDate: start,
            endDate: end,
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        }, cc);
        var start2 = moment();
        var end2 = moment();
        $('#unique_customer').daterangepicker({
            startDate: start2,
            endDate: end2,
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        }, uc);
        $('.list-order-open').click(function() {
            window.location = "<?= base_url("order/list/open") ?>";
        });
        $('.list-order-onprocess').click(function() {
            window.location = "<?= base_url("order/list/onprocess") ?>";
        });
        $('.list-order-closed').click(function() {
            window.location = "<?= base_url("order/list/closed?start=") ?>" + $('#date-close-cancel span').text().substring(0, 10) + "&end=" + $('#date-close-cancel span').text().substring(13, 23);
        });
        $('.list-order-canceled').click(function() {
            window.location = "<?= base_url("order/list/canceled?start=") ?>" + $('#date-close-cancel span').text().substring(0, 10) + "&end=" + $('#date-close-cancel span').text().substring(13, 23);
        });
    });

    function cc(start, end) {
        $('#date-close-cancel span').html(start.format('DD-MM-YYYY') + ' - ' + end.format('DD-MM-YYYY'));
        $.ajax({
            url: "<?= base_url('order/'); ?>close_cancel?start=" + start.format('DD-MM-YYYY') + "&end=" + end.format('DD-MM-YYYY'),
            type: "post",
            success: function(data2) {
                var order2 = $.parseJSON(data2);
                $(".order-closed").text(order2["count_closed"]);
                $(".order-canceled").text(order2["count_canceled"]);
                $(".total-closed").text(rupiah(order2["total_closed"]));
                $(".total-canceled").text('- ' + rupiah(order2["total_canceled"]));
            }
        });
    }

    function uc(start2, end2) {
        $('#unique_customer span').html(start2.format('DD-MM-YYYY') + ' - ' + end2.format('DD-MM-YYYY'));
        $.ajax({
            url: "<?= base_url('order/'); ?>unique_customer?start=" + start2.format('DD-MM-YYYY') + "&end=" + end2.format('DD-MM-YYYY'),
            type: "post",
            success: function(data3) {
                var order3 = $.parseJSON(data3);
                $(".unique-open").text(order3["open"]);
                $(".unique-onprocess").text(order3["onprocess"]);
                $(".unique-closed").text(order3["closed"]);
                $(".unique-canceled").text(order3["canceled"]);
            }
        });
    }

    function rupiah(angka) {
        var reverse = angka.toString().split('').reverse().join(''),
            ribuan = reverse.match(/\d{1,3}/g);
        ribuan = ribuan.join('.').split('').reverse().join('');
        return 'Rp ' + ribuan;
    }
</script>