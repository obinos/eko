<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12 pad0">
            <div class="ibox ">
                <div class="ibox-content">
                    <form method="post" id="filter_user">
                        <div class="form-row d-flex align-items-end">
                            <div class="col-lg-10 my-1">
                                <p>Supplier</p>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text width46"><svg style="width:20px;height:20px;margin:auto" viewBox="0 0 24 24">
                                                <path fill="currentColor" d="M18.36 9L18.96 12H5.04L5.64 9H18.36M20 4H4V6H20V4M20 7H4L3 12V14H4V20H14V14H18V20H20V14H21V12L20 7M6 18V14H12V18H6Z" />
                                            </svg></div>
                                    </div>
                                    <select name="filter_supplier" class="form-control" id="filter_supplier">
                                        <option></option>
                                        <?php foreach ($supplier as $val) : ?>
                                            <option value="<?= $val['_id']; ?>" <?php if ($val['_id'] == $filter_supplier) : ?> selected<?php endif; ?>><?= $val['name']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-2 my-1">
                                <button type="submit" class="btn btn-warning btn-block btn-lg">Filter</button>
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
                    <h5>Data HPP</h5>
                    <a class='btn btn-sm btn-primary text-dark' href='<?= base_url('hpp/print/' . $filter_supplier); ?>'>
                        <svg class="mr-2" width="16px" height="16px" viewBox="0 0 16 16" fill="currentColor">
                            <path d="M2.5 8a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z" />
                            <path d="M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2H5zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4V3zm1 5a2 2 0 0 0-2 2v1H2a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v-1a2 2 0 0 0-2-2H5zm7 2v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1z" />
                        </svg>Print</a>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table id="datatable" class="table table-striped table-sm display" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>SKU</th>
                                    <th>Station</th>
                                    <th>Nama</th>
                                    <th>Supplier</th>
                                    <th>Harga</th>
                                    <th>HPP</th>
                                    <th>Selisih</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
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
        $("#filter_supplier").select2({
            placeholder: 'Pilih Supplier',
            theme: 'bootstrap4',
            language: 'id'
        });
        $('#datatable').DataTable({
            "pageLength": 50,
            "dom": '<"html5buttons">lTfgitp',
            "processing": true,
            "serverSide": true,
            "order": [],
            "aLengthMenu": [
                [10, 20, 50, 100, -1],
                [10, 20, 50, 100, 'All']
            ],
            "ajax": {
                "url": "<?= base_url('hpp/get_data?supplier=' . $filter_supplier); ?>",
                "type": "POST"
            },
            "columns": [{
                "data": null,
                "sortable": false,
                render: function(data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            }, {
                "data": "barcode",
                render: function(data, type, row, meta) {
                    return data ? data : null;
                }
            }, {
                "data": "station",
                render: function(data, type, row, meta) {
                    return data ? data : null;
                }
            }, {
                "data": "name",
                render: function(data, type, row, meta) {
                    return data ? data : null;
                }
            }, {
                "data": "supplier",
                render: function(data, type, row, meta) {
                    return data ? data : null;
                }
            }, {
                "class": "text-right",
                "data": "price",
                render: $.fn.dataTable.render.number('.', ',', 0, '')
            }, {
                "class": "text-right",
                "data": "hpp",
                render: $.fn.dataTable.render.number('.', ',', 0, '')
            }, {
                "class": "text-right",
                "data": "percentage"
            }]
        });
    });
</script>