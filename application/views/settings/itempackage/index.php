<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12 pad0">
            <div class="ibox ">
                <div class="ibox-title d-flex align-items-center justify-content-between">
                    <h5>Data Item</h5>
                </div>
                <div class="ibox-content">
                    <div class="tabs-container">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-sm display" width="100%">
                                <thead>
                                    <tr>
                                        <th width=8px>No</th>
                                        <th>SKU</th>
                                        <th>Nama</th>
                                        <th>Station</th>
                                        <th>Komposisi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1;
                                    foreach ($item as $data) :
                                    ?>
                                        <tr class="<?= $data['_id'] ?>">
                                            <td><?= $no++ ?></td>
                                            <td class="item_barcode"><?= $data['barcode'] ?></td>
                                            <td><a href='<?= base_url('settings/add_item_package/' . $data['_id']) ?>'><?= $data['name'] ?></a></td>
                                            <td class="item_station"><?= $data['station'] ?></td>
                                            <td class="item_active"><?= $data['composition'] ? count($data['composition']) : 0 ?></td>
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
</div>
<?= core_script(); ?>
<?= datatables(); ?>
<script>
    $(document).ready(function() {
        $('table.display').DataTable({
            responsive: true,
            pageLength: 25,
            dom: '<"html5buttons">lTfgitp'
        });
    });
</script>