<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12 pad0">
            <div class="ibox ">
                <div class="ibox-content">
                    <form method="post" id="form_filter">
                        <div class="form-row d-flex align-items-end">
                            <div class="col-lg-10 my-1">
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
                                <button type="submit" class="btn btn-warning btn-block btn-lg">Select</button>
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
                    <a class='btn btn-primary btn-sm' href='<?= base_url(); ?>stock/print_opname/'>
                        <svg class="mr-2" width="14px" height="14px" viewBox="0 0 16 16" fill="currentColor">
                            <path d="M2.5 8a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z" />
                            <path d="M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2H5zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4V3zm1 5a2 2 0 0 0-2 2v1H2a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v-1a2 2 0 0 0-2-2H5zm7 2v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1z" />
                        </svg>Stock Opname</a>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table id="datatable" class="table table-bordered table-striped table-sm" width="100%">
                            <thead>
                                <tr>
                                    <th class="text-center align-middle" rowspan="2">No</th>
                                    <th class="text-center align-middle" rowspan="2">SKU</th>
                                    <th class="text-center align-middle" rowspan="2">Supplier</th>
                                    <th class="text-center align-middle" rowspan="2">Item</th>
                                    <th class="text-center align-middle" rowspan="2">Station</th>
                                    <th class="text-center align-middle" rowspan="2">Qty Available</th>
                                    <th class="text-center" colspan="3">Qty Physical</th>
                                    <th class="text-center align-middle" rowspan="2">Open PO</th>
                                </tr>
                                <tr>
                                    <th class="text-center">Good</th>
                                    <th class="text-center">Damage</th>
                                    <th class="text-center">Reject</th>
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
                                        <td><?= $data['supplier'] ?></td>
                                        <td><?= $data['name'] ?></td>
                                        <td><?= $data['station'] ?></td>
                                        <td class="text-right"><a class="ledger" data-toggle="modal" href='#modal-form' data-id="<?= $data['_id'] ?>" data-name="<?= $data['name'] ?>" data-condition="open-onprocess"><?= $data['stock'] ?></a></td>
                                        <td class="text-right"><a class="ledger" data-toggle="modal" href='#modal-form' data-id="<?= $data['_id'] ?>" data-name="<?= $data['name'] ?>" data-condition="good"><?= $data['qty_physical']['good'] ?></a></td>
                                        <td class="text-right"><a class="ledger" data-toggle="modal" href='#modal-form' data-id="<?= $data['_id'] ?>" data-name="<?= $data['name'] ?>" data-condition="damage"><?= $data['qty_physical']['damage'] ?></a></td>
                                        <td class="text-right"><a class="ledger" data-toggle="modal" href='#modal-form' data-id="<?= $data['_id'] ?>" data-name="<?= $data['name'] ?>" data-condition="reject"><?= $data['qty_physical']['reject'] ?></a></td>
                                        <td class="text-right"><a class="ledger" data-toggle="modal" href='#modal-form' data-id="<?= $data['_id'] ?>" data-name="<?= $data['name'] ?>" data-condition="open"><?= $data['open_po'] ?></a></td>
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
            dom: '<"html5buttons">lTfgitp',
            aLengthMenu: [
                [10, 20, 50, 100, -1],
                [10, 20, 50, 100, 'All']
            ]
        });
        $('#datatable').on('click', '.ledger', function(e) {
            $(".modal-title").text($(this).attr('data-name') + ' - ' + $(this).attr('data-condition').toUpperCase());
            $(".table-modal").empty();
            var object = {};
            object['id_item'] = $(this).attr('data-id');
            object['condition'] = $(this).attr('data-condition');
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