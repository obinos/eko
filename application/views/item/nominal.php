<link href="<?= base_url('assets/'); ?>vendor/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css" rel="stylesheet" type="text/css">
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12 pad0">
            <div class="ibox ">
                <div class="ibox-title d-flex align-items-center justify-content-between bg-success">
                    <h5>Total : Rp. <?= $total ?></h5>
                </div>
                <div class="ibox-content">
                    <div class="tabs-container">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-sm display" width="100%">
                                <thead>
                                    <tr>
                                        <th class="text-center">No</th>
                                        <th class="text-center">Station</th>
                                        <th class="text-center">Nama</th>
                                        <th class="text-center">Stock</th>
                                        <th class="text-center">Avg HPP</th>
                                        <th class="text-center">Nominal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1;
                                    foreach ($item as $data) :
                                    ?>
                                        <tr class="<?= $data['_id'] ?>">
                                            <td><?= $no++ ?></td>
                                            <td><?= $data['station'] ?></td>
                                            <td><?= $data['name'] ?></td>
                                            <td class="text-right"><?= $data['stock'] ?></td>
                                            <td class="text-right"><?= $data['avg_price'] ?></td>
                                            <td class="text-right"><?= $data['nominal'] ?></td>
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
            pageLength: -1,
            dom: '<"html5buttons">lTfgitp',
            aLengthMenu: [
                [10, 20, 50, 100, -1],
                [10, 20, 50, 100, 'All']
            ]
        });
    });
</script>