<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12 pad0">
            <div class="ibox">
                <div class="ibox-content">
                    <form method="post" id="filter_user">
                        <div class="form-row align-items-end">
                            <div class="col-lg-5 my-1">
                                <p>Tanggal</p>
                                <div class="input-group date">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text width46"><svg style="width:20px;height:20px;margin:auto" viewBox="0 0 24 24">
                                                <path fill="#173b60" d="M9,10H7V12H9V10M13,10H11V12H13V10M17,10H15V12H17V10M19,3H18V1H16V3H8V1H6V3H5C3.89,3 3,3.9 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V5A2,2 0 0,0 19,3M19,19H5V8H19V19Z"></path>
                                            </svg></div>
                                    </div>
                                    <input type="text" class="form-control" name="filter_date" placeholder="Input Tanggal" value="<?= $filter_date ?>" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-lg-5 my-1">
                                <p>Warehouse / Store</p>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text width46"><svg style="width:20px;height:20px;margin:auto" viewBox="0 0 24 24">
                                                <path fill="#173b60" d="M6 19H8V21H6V19M12 3L2 8V21H4V13H20V21H22V8L12 3M8 11H4V9H8V11M14 11H10V9H14V11M20 11H16V9H20V11M6 15H8V17H6V15M10 15H12V17H10V15M10 19H12V21H10V19M14 19H16V21H14V19Z" />
                                            </svg></div>
                                    </div>
                                    <select name="filter_store" class="form-control" id="filter_store">
                                        <option></option>
                                        <?php foreach ($store as $s) : ?>
                                            <option value="<?= $s['_id']; ?>" <?php if ($s['_id'] == $filter_store) : ?> selected<?php endif; ?>><?= $s['name']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-2 my-1">
                                <button type="submit" class="btn btn-lg btn-warning btn-block">Filter</button>
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
                    <h5>Data Stock</h5>
                    <div class='btn-group btn-group-sm'>
                        <a class='btn btn-primary btn-sm' href='<?= base_url(); ?>stock/excel/<?= $filter_date ?>/<?= $filter_store ?>'>
                            <svg class="mr-2" width="14px" height="14px" viewBox="0 0 16 16" fill="currentColor">
                                <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V9H3V2a1 1 0 0 1 1-1h5.5v2zM3 12v-2h2v2H3zm0 1h2v2H4a1 1 0 0 1-1-1v-1zm3 2v-2h3v2H6zm4 0v-2h3v1a1 1 0 0 1-1 1h-2zm3-3h-3v-2h3v2zm-7 0v-2h3v2H6z" />
                            </svg>Export Excel</a>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table id="datatable" class="table table-bordered table-striped table-sm" width="100%">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th class="text-center">SKU</th>
                                    <th class="text-center">Station</th>
                                    <th class="text-center">Item</th>
                                    <th class="text-center">Stock</th>
                                    <th class="text-center">Satuan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                foreach ($stock as $data) :
                                ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= $data['barcode'] ?></td>
                                        <td><?= $data['station'] ?></td>
                                        <td><a class="ledger" data-toggle="modal" href='#modal-form' data-id="<?= $data['_id'] ?>" data-name="<?= $data['name'] ?>" data-condition="good"><?= $data['name'] ?></a></td>
                                        <td class="text-right"><?= $data['stock'] ?></td>
                                        <td><?= $data['weight_unit'] ?></td>
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
<div id="modal-form" class="modal fade" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h4 class="modal-title"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-striped table-sm display table-modal" width="100%">
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?= core_script(); ?>
<?= datatables(); ?>
<?= datepicker(); ?>
<?= select2(); ?>
<script>
    $(document).ready(function() {
        $("#filter_store").select2({
            placeholder: 'Pilih Store',
            theme: 'bootstrap4',
            language: 'id'
        });
        $('#datatable').DataTable({
            pageLength: -1,
            responsive: true,
            dom: '<"html5buttons">lTfgitp'
        });
        $('.date').datepicker({
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            autoclose: true
        });
        $('#datatable').on('click', '.ledger', function(e) {
            $(".modal-title").text($(this).attr('data-name') + ' - ' + $(this).attr('data-condition').toUpperCase());
            $(".table-modal").empty();
            var object = {};
            object['id_item'] = $(this).attr('data-id');
            object['condition'] = $(this).attr('data-condition');
            object['transaction_date'] = '<?= $filter_date ?>';
            var jsonString = JSON.stringify(object);
            $.ajax({
                type: "POST",
                url: '<?= base_url('stock/get_stock?id_warehouse=' . $filter_store) ?>',
                data: {
                    data: jsonString
                },
                success: function(response) {
                    var result = $.parseJSON(response);
                    $(".table-modal").append(`<thead>
                            <tr>
                                <th>No</th>
                                <th>` + result.th1 + `</th>
                                <th>` + result.th2 + `</th>
                                <th>Qty</th>
                            </tr>
                        </thead>
                        <tbody>`);
                    for (var i = 0; i < result.data.length; i++) {
                        var no = i + 1;
                        if (result.th2 == 'Tipe') {
                            var typemaker = result.data[i].maker ? result.data[i].type + ' (' + result.data[i].maker + ')' : result.data[i].type;
                            var th1 = result.data[i].date;
                            var th2 = typemaker;
                            var qty = result.data[i].qty;
                        } else if (result.th2 == 'Supplier') {
                            var th1 = result.data[i].pono;
                            var th2 = result.data[i].supplier;
                            var qty = result.data[i].qty;
                        } else if (result.th2 == 'Status') {
                            var th1 = result.data[i].station;
                            var th2 = result.data[i].status;
                            var qty = result.data[i].qty;
                        }
                        $(".table-modal").append(`
                            <tr>
                                <td>` + no + `</td>
                                <td>` + th1 + `</td>
                                <td>` + th2 + `</td>
                                <td class="text-right">` + qty + `</td>
                            </tr>`);
                    }
                    $(".table-modal").append(`</tbody>`);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                }
            });
        });
    });
</script>