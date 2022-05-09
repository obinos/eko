<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12 pad0">
            <div class="ibox ">
                <div class="ibox-content">
                    <form method="post" id="filter_user">
                        <div class="form-row d-flex align-items-end">
                            <div class="col-lg-3 my-1">
                                <p>Station</p>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text width46"><svg style="width:20px;height:20px;margin:auto" viewBox="0 0 24 24">
                                                <path fill="#173b60" d="M6 19H8V21H6V19M12 3L2 8V21H4V13H20V21H22V8L12 3M8 11H4V9H8V11M14 11H10V9H14V11M20 11H16V9H20V11M6 15H8V17H6V15M10 15H12V17H10V15M10 19H12V21H10V19M14 19H16V21H14V19Z" />
                                            </svg></div>
                                    </div>
                                    <select name="filter_station" class="form-control" id="filter_station">
                                        <option></option>
                                        <?php foreach ($station as $s) : ?>
                                            <option value="<?= $s; ?>" <?php if ($s == $filter_station) : ?> selected<?php endif; ?>><?= $s; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3 my-1">
                                <p>Product Active</p>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text width46"><svg style="width:20px;height:20px;margin:auto" viewBox="0 0 24 24">
                                                <path fill="#173b60" d="M23,12L20.56,9.22L20.9,5.54L17.29,4.72L15.4,1.54L12,3L8.6,1.54L6.71,4.72L3.1,5.53L3.44,9.21L1,12L3.44,14.78L3.1,18.47L6.71,19.29L8.6,22.47L12,21L15.4,22.46L17.29,19.28L20.9,18.46L20.56,14.78L23,12M10,17L6,13L7.41,11.59L10,14.17L16.59,7.58L18,9L10,17Z" />
                                            </svg></div>
                                    </div>
                                    <select name="filter_active" class="form-control" id="filter_active">
                                        <option></option>
                                        <?php foreach ($active as $key => $val) : ?>
                                            <option value="<?= $key; ?>" <?php if ($key == $filter_active) : ?> selected<?php endif; ?>><?= $val; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3 my-1">
                                <p>Stock Default</p>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text width46"><svg style="width:20px;height:20px;margin:auto" viewBox="0 0 24 24">
                                                <path fill="#173b60" d="M19,8V5H5V8H9A3,3 0 0,0 12,11A3,3 0 0,0 15,8H19M19,3A2,2 0 0,1 21,5V12A2,2 0 0,1 19,14H5A2,2 0 0,1 3,12V5A2,2 0 0,1 5,3H19M3,15H9A3,3 0 0,0 12,18A3,3 0 0,0 15,15H21V19A2,2 0 0,1 19,21H5A2,2 0 0,1 3,19V15Z" />
                                            </svg></div>
                                    </div>
                                    <select name="filter_stock" class="form-control" id="filter_stock">
                                        <option></option>
                                        <?php foreach ($active as $key => $val) : ?>
                                            <option value="<?= $key; ?>" <?php if ($key == $filter_stock) : ?> selected<?php endif; ?>><?= $val; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3 my-1">
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
                    <h5>Data Stock Opname</h5>
                    <a class='btn btn-primary btn-sm text-dark print'>
                        <svg class="mr-2" width="14px" height="14px" viewBox="0 0 16 16" fill="currentColor">
                            <path d="M2.5 8a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z" />
                            <path d="M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2H5zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4V3zm1 5a2 2 0 0 0-2 2v1H2a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v-1a2 2 0 0 0-2-2H5zm7 2v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1z" />
                        </svg>Print</a>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive content-print">
                        <h3><?= dateindo(time() * 1000) ?></h3>
                        <table class="table table-bordered table-sm" width="100%">
                            <thead>
                                <tr>
                                    <th class="text-center" width="3%">No</th>
                                    <th class="text-center" width="5%">SKU</th>
                                    <th class="text-center">Nama Produk</th>
                                    <th class="text-center">Aktif</th>
                                    <th class="text-center">Station</th>
                                    <th class="text-center">Web</th>
                                    <th class="text-center">Baru</th>
                                    <th class="text-center">Proses</th>
                                    <th class="text-center">Total</th>
                                    <th class="text-center">Fisik</th>
                                    <th class="text-center">Hasil Opname</th>
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
                                        <td><?= $data['name'] ?></td>
                                        <td><?= $data['active'] ?></td>
                                        <td><?= $data['station'] ?></td>
                                        <td><?= $data['stock'] ?></td>
                                        <td><?= $data['open'] ?></td>
                                        <td><?= $data['onprocess'] ?></td>
                                        <td><strong><?= $data['total'] ?></strong></td>
                                        <td></td>
                                        <td></td>
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
<?= select2(); ?>
<script src="<?= base_url('assets/'); ?>vendor/printThis/printThis.js"></script>
<script>
    $(document).ready(function() {
        $("#filter_station").select2({
            placeholder: 'Pilih Station',
            theme: 'bootstrap4',
            language: 'id'
        });
        $("#filter_active").select2({
            placeholder: 'Produk Aktif',
            theme: 'bootstrap4',
            language: 'id'
        });
        $("#filter_stock").select2({
            placeholder: 'Stock Default',
            theme: 'bootstrap4',
            language: 'id'
        });
        $('.print').on('click', function() {
            $(".content-print").printThis();
        });
    });
</script>