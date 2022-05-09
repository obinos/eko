<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12 pad0">
            <div class="ibox">
                <div class="ibox-title collapse-link bg-light">
                    <h5>Tanggal Pengiriman</h5>
                    <div class="ibox-tools">
                        <a>
                            <span class="fa arrow"></span>
                        </a>
                    </div>
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
    <?php if ($rute) { ?>
        <div class="row">
            <div class="col-lg-12 pad0">
                <div class="ibox border-bottom">
                    <div class="ibox-title collapse-link bg-light">
                        <h5>Print Urutan Kurir</h5>
                        <div class="ibox-tools">
                            <a>
                                <span class="fa arrow"></span>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="table-responsive">
                            <table id="rute_courier" class="table table-striped table-sm display" width="100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Maker</th>
                                        <th>Kurir</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    foreach ($rute as $rut) : ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= $rut['created_at'] ?></td>
                                            <td><?= $rut['user'] ?></td>
                                            <td><?= count($rut['data']) ?></td>
                                            <td>
                                                <div class='btn-group btn-group-sm'>
                                                    <a class='btn_view btn btn-success' title="View" id="<?= $rut['_id'] ?>">
                                                        <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor">
                                                            <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z" />
                                                            <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z" />
                                                        </svg>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
    <?php if ($order) {
        foreach ($order as $ord) :
            $keys = array_column($ord['recipient'], 'lower');
            array_multisort($keys, SORT_ASC, $ord['recipient']);
            $jmlorder = $ord['total'] == $ord['order'] ? $ord['total'] : $ord['total'] . '/' . $ord['order'];
            $idcourier = $ord['_id'] ? $ord['name'] . ' - ' . $ord['_id'] : 'NULL'; ?>
            <div class="row">
                <div class="col-lg-12 pad0">
                    <div class="ibox">
                        <div class="ibox-title d-flex align-items-center justify-content-between bg-light">
                            <h5><?= $idcourier . ' - ' . $jmlorder . ' (' . thousand($ord['nominal']) . ')' ?></h5>
                            <a class='btn btn-warning btn-sm PrintCourierList text-dark' data-tooltip="tooltip" data-placement="top" title="Print Packinglist" id="<?= $ord['_id'] ?>">
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="#212121">
                                    <path d="M2.5 8a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z" />
                                    <path d="M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2H5zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4V3zm1 5a2 2 0 0 0-2 2v1H2a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v-1a2 2 0 0 0-2-2H5zm7 2v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1z" />
                                </svg> Print List
                            </a>
                        </div>
                        <div class="ibox-content">
                            <div class="table-responsive">
                                <table id="<?= $ord['_id'] ?>" class="table table-striped table-sm display" width="100%">
                                    <thead>
                                        <tr>
                                            <th width="3%">No</th>
                                            <th width="15%">Nama</th>
                                            <th width="32%">Alamat</th>
                                            <th width="32%">Catatan</th>
                                            <th width="8%" class="text-right">COD</th>
                                            <th width="10%" class="text-right">Print</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        foreach ($ord['recipient'] as $data) :
                                            $hub = $data['merchant_notes'] && $data['preferences'] ? "\n" : null;
                                            $gift = $data['customer_phone'] == $data['phone'] ? null : ' <span class="badge badge-success">gift</span>';
                                            $preferences = $data['preferences'] ? implode("\n", $data['preferences']) : null;
                                            $shipping = strpos($data['shipping'], 'Sidoarjo') !== false ? 'Sidoarjo' : $data['shipping'];
                                            $address = strpos(ucwords($data['address']), $shipping) !== false ? $data['address'] : $data['address'] . ', ' . $shipping;
                                        ?>
                                            <tr class="<?= count_cust_ord($data['new_customer']) ?>">
                                                <td><?= $no++ ?></td>
                                                <td><?= $data['name'] . $gift ?></td>
                                                <td><?= $address ?></td>
                                                <td><?= nl2br($data['merchant_notes'] . $hub . $preferences) ?></td>
                                                <td class="text-right"><?= $data['payment'] ? thousand($data['payment'][0]['payment_amount']) : null ?></td>
                                                <td>
                                                    <div class='btn-group btn-group-sm'>
                                                        <a class='btn btn-danger PrintAll text-dark' title="Print All" id="<?= $data['id_order'] ?>"><b>All</b></a>
                                                        <a class='btn btn-success PrintInvoice' title="Print Invoice" id="<?= $data['id_order'] ?>">
                                                            <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor">
                                                                <path d="M1.92.506a.5.5 0 0 1 .434.14L3 1.293l.646-.647a.5.5 0 0 1 .708 0L5 1.293l.646-.647a.5.5 0 0 1 .708 0L7 1.293l.646-.647a.5.5 0 0 1 .708 0L9 1.293l.646-.647a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .801.13l.5 1A.5.5 0 0 1 15 2v12a.5.5 0 0 1-.053.224l-.5 1a.5.5 0 0 1-.8.13L13 14.707l-.646.647a.5.5 0 0 1-.708 0L11 14.707l-.646.647a.5.5 0 0 1-.708 0L9 14.707l-.646.647a.5.5 0 0 1-.708 0L7 14.707l-.646.647a.5.5 0 0 1-.708 0L5 14.707l-.646.647a.5.5 0 0 1-.708 0L3 14.707l-.646.647a.5.5 0 0 1-.801-.13l-.5-1A.5.5 0 0 1 1 14V2a.5.5 0 0 1 .053-.224l.5-1a.5.5 0 0 1 .367-.27zm.217 1.338L2 2.118v11.764l.137.274.51-.51a.5.5 0 0 1 .707 0l.646.647.646-.646a.5.5 0 0 1 .708 0l.646.646.646-.646a.5.5 0 0 1 .708 0l.646.646.646-.646a.5.5 0 0 1 .708 0l.646.646.646-.646a.5.5 0 0 1 .708 0l.646.646.646-.646a.5.5 0 0 1 .708 0l.509.509.137-.274V2.118l-.137-.274-.51.51a.5.5 0 0 1-.707 0L12 1.707l-.646.647a.5.5 0 0 1-.708 0L10 1.707l-.646.647a.5.5 0 0 1-.708 0L8 1.707l-.646.647a.5.5 0 0 1-.708 0L6 1.707l-.646.647a.5.5 0 0 1-.708 0L4 1.707l-.646.647a.5.5 0 0 1-.708 0l-.509-.51z" />
                                                                <path d="M3 4.5a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 1 1 0 1h-6a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h6a.5.5 0 0 1 0 1h-6a.5.5 0 0 1-.5-.5zm8-6a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5z" />
                                                            </svg>
                                                        </a>
                                                        <a class='btn btn-primary PrintPackinglist' title="Print Packinglist" id="<?= $data['id_order'] ?>">
                                                            <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor">
                                                                <path d="M8.186 1.113a.5.5 0 0 0-.372 0L1.846 3.5l2.404.961L10.404 2l-2.218-.887zm3.564 1.426L5.596 5 8 5.961 14.154 3.5l-2.404-.961zm3.25 1.7-6.5 2.6v7.922l6.5-2.6V4.24zM7.5 14.762V6.838L1 4.239v7.923l6.5 2.6zM7.443.184a1.5 1.5 0 0 1 1.114 0l7.129 2.852A.5.5 0 0 1 16 3.5v8.662a1 1 0 0 1-.629.928l-7.185 2.874a.5.5 0 0 1-.372 0L.63 13.09a1 1 0 0 1-.63-.928V3.5a.5.5 0 0 1 .314-.464L7.443.184z" />
                                                            </svg>
                                                        </a>
                                                        <a class='btn btn-orange PrintLabel' title="Print Label Kirim" id="<?= $data['id_order'] ?>">
                                                            <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor">
                                                                <path d="M6 4.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0zm-1 0a.5.5 0 1 0-1 0 .5.5 0 0 0 1 0z" />
                                                                <path d="M2 1h4.586a1 1 0 0 1 .707.293l7 7a1 1 0 0 1 0 1.414l-4.586 4.586a1 1 0 0 1-1.414 0l-7-7A1 1 0 0 1 1 6.586V2a1 1 0 0 1 1-1zm0 5.586 7 7L13.586 9l-7-7H2v4.586z" />
                                                            </svg>
                                                        </a>
                                                        <a class='btn btn-warning PrintLabel2' title="Print Label Kirim 2x" id="<?= $data['id_order'] ?>">
                                                            <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor">
                                                                <path d="M3 2v4.586l7 7L14.586 9l-7-7H3zM2 2a1 1 0 0 1 1-1h4.586a1 1 0 0 1 .707.293l7 7a1 1 0 0 1 0 1.414l-4.586 4.586a1 1 0 0 1-1.414 0l-7-7A1 1 0 0 1 2 6.586V2z" />
                                                                <path d="M5.5 5a.5.5 0 1 1 0-1 .5.5 0 0 1 0 1zm0 1a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3zM1 7.086a1 1 0 0 0 .293.707L8.75 15.25l-.043.043a1 1 0 0 1-1.414 0l-7-7A1 1 0 0 1 0 7.586V3a1 1 0 0 1 1-1v5.086z" />
                                                            </svg>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    <?php endforeach;
    } ?>
</div>
<div id="modal-form" class="modal fade bd-example-modal-xl" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Rute Kurir</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="d-flex justify-content-between">
                    <div class='mb-3 btn-group btn-group-sm btnprintrute'>
                    </div>
                    <div class='mb-3 btn-group btn-group-sm'>
                        <a class='btn btn-dark copy-button text-white' title="Copy Text" onclick="copyVariable('#copy_text')">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="#ffffff">
                                <path d="M13 0H6a2 2 0 0 0-2 2 2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h7a2 2 0 0 0 2-2 2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zm0 13V4a2 2 0 0 0-2-2H5a1 1 0 0 1 1-1h7a1 1 0 0 1 1 1v10a1 1 0 0 1-1 1zM3 4a1 1 0 0 1 1-1h7a1 1 0 0 1 1 1v10a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V4z" />
                            </svg> Copy Text
                        </a>
                    </div>
                </div>
                <p class="pace-inactive" id="copy_text">test</p>
                <div class="table-responsive">
                    <table id="modal_rute_courier" class="table table-striped table-sm display" width="100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kurir</th>
                                <th>Time</th>
                                <th>Order</th>
                                <th>Note</th>
                            </tr>
                        </thead>
                        <tbody class="tbody_modal">
                        </tbody>
                    </table>
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
        $('.copy-button').click(function() {
            $.toast({
                heading: 'Success',
                text: 'Copy Text',
                icon: 'success',
                showHideTransition: 'slide',
                hideAfter: 1000,
                position: 'top-right'
            });
        });
        $('.date').datepicker({
            format: 'dd-mm-yyyy',
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            autoclose: true
        });
        $('.PrintAll').click(function() {
            var id = this.id;
            $.ajax({
                url: "<?= base_url("thermal/all_print/") ?>" + id,
                type: "post",
                success: function(result) {
                    console.log('sukses')
                }
            });
        });
        $('.PrintPackinglist').click(function() {
            var id = this.id;
            $.ajax({
                url: "<?= base_url("thermal/print_packinglist/") ?>" + id,
                type: "post",
                success: function(result) {
                    console.log('sukses')
                }
            });
        });
        $('.PrintInvoice').click(function() {
            var id = this.id;
            $.ajax({
                url: "<?= base_url("thermal/print_invoice/") ?>" + id,
                type: "post",
                success: function(result) {
                    console.log('sukses')
                }
            });
        });
        $('.PrintLabel').click(function() {
            var id = this.id;
            $.ajax({
                url: "<?= base_url("thermal/print_label/") ?>" + id + "/false",
                type: "post",
                success: function(result) {
                    console.log('sukses')
                }
            });
        });
        $('.PrintLabel2').click(function() {
            var id = this.id;
            $.ajax({
                url: "<?= base_url("thermal/print_label_2/") ?>" + id,
                type: "post",
                success: function(result) {
                    console.log('sukses')
                }
            });
        });
        $('.PrintCourierList').click(function() {
            var id = this.id;
            $.ajax({
                url: "<?= base_url("thermal/print_courier_list_thermal/$filter_date/") ?>" + id,
                type: "post",
                success: function(result) {
                    console.log('sukses')
                }
            });
        });
        $('.btnprintrute').on('click', '.PrintRuteCourier', function() {
            var id = this.id;
            var status = $(this).attr('data-status');
            $.ajax({
                url: "<?= base_url("thermal/print_rutecourier/") ?>" + id + '/' + status,
                type: "post",
                success: function(result) {
                    console.log('sukses')
                }
            });
        });
        $('.btn_view').on('click', function(e) {
            var id = $(this).attr('id');
            $('.tbody_modal').empty();
            $('.printrak').remove();
            $('.PrintRuteCourier').attr('id', id);
            $.ajax({
                type: "POST",
                url: '<?= base_url('thermal/get_rute') ?>',
                data: {
                    data: id
                },
                success: function(response) {
                    var result = $.parseJSON(response);
                    $('p#copy_text').text(result[0].text);
                    for (let i = 0; i < result[0].split; i++) {
                        var rak = i + 1;
                        var btn = rak == 1 ? `btn-primary` : (rak == 2 ? `btn-warning` : `btn-danger`);
                        $('.btnprintrute').append(`<a class='btn ` + btn + ` PrintRuteCourier text-dark printrak' data-status="rak-` + rak + `" data-tooltip="tooltip" data-placement="top" title="Print Rak-` + rak + `" id="` + result[0]._id + `">
                            <svg width="16" height="16" viewBox="0 0 16 16" fill="#212121">
                                <path d="M2.5 8a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z" />
                                <path d="M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2H5zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4V3zm1 5a2 2 0 0 0-2 2v1H2a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v-1a2 2 0 0 0-2-2H5zm7 2v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1z" />
                            </svg> Rak-` + rak + `
                        </a>`);
                    }
                    if (result[0].data) {
                        for (let i = 0; i < result[0].data.length; i++) {
                            $('.tbody_modal').append(`<tr>
                            <td>` + (parseInt(i) + 1) + `</td>
                            <td>` + result[0].data[i]._id + `</td>
                            <td>` + result[0].data[i].time + `</td>
                            <td>` + result[0].data[i].order + `</td>
                            <td>` + result[0].data[i].note.join('<br>') + `</td>
                        </tr>`);
                        }
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                }
            });
            $('#modal-form').modal('show');
        });
    });

    function copyVariable(element) {
        var $temp = $("<textarea>");
        var brRegex = /<br\s*[\/]?>/gi;
        $("body").append($temp);
        $temp.val($(element).html().replace(brRegex, "\r\n")).select();
        document.execCommand("copy");
        $temp.remove();
    }
</script>