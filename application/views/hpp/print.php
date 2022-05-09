<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12 pad0">
            <div class="ibox ">
                <div class="ibox-title justify-content-between">
                    <h5>Data HPP</h5>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table id="datatable" class="table table-bordered table-sm content-print" width="100%">
                            <thead>
                                <tr>
                                    <th class="text-center" width="5%">No</th>
                                    <th class="text-center">Nama Produk</th>
                                    <th class="text-center">Supplier</th>
                                    <th class="text-center">Harga Jual</th>
                                    <th class="text-center">HPP</th>
                                    <th class="text-center">Selisih</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                foreach ($result as $data) :
                                ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= $data['name'] ?></td>
                                        <td><?= $data['supplier'] ?></td>
                                        <td class="text-right"><?= thousand($data['price']) ?></td>
                                        <td class="text-right"><?= thousand($data['hpp']) ?></td>
                                        <td class="text-right"><?= $data['percentage'] ?></td>
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
<script src="<?= base_url('assets/'); ?>vendor/printThis/printThis.js"></script>
<script>
    $(document).ready(function() {
        $(".content-print").printThis();
    });
</script>