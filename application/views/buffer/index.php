<div class="wrapper wrapper-content animated fadeInRight">
    <?php
    $stat = 1;
    foreach ($stock as $ord) :
    ?>
        <div class="row">
            <div class="col-lg-12 pad0">
                <div class="ibox ">
                    <div class="ibox-title d-flex align-items-center justify-content-between">
                        <h5>Supplier: <?= $ord[0]['supplier'] ?></h5>
                    </div>
                    <div class="ibox-content">
                        <div class="row d-flex align-items-center">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table id="datatable<?= $stat++; ?>" class="table table-striped table-sm table-bordered display" width="100%">
                                        <thead>
                                            <tr>
                                                <th style="width: 8px">No</th>
                                                <th>SKU</th>
                                                <th>Station</th>
                                                <th>Nama</th>
                                                <th>Jual</th>
                                                <th>Stock</th>
                                                <th>Min</th>
                                                <th>Max</th>
                                                <th>Purchase</th>
                                                <th>Last HPP</th>
                                                <th>Avg HPP</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $no = 1;
                                            foreach ($ord as $key => $data) :
                                            ?>
                                                <tr>
                                                    <td class="text-right"><?= $no++; ?></td>
                                                    <td><?= $data['barcode'] ?></td>
                                                    <td><?= $data['station'] ?></td>
                                                    <td><?= $data['name'] ?></td>
                                                    <td class="text-right"><?= thousand($data['price']) ?></td>
                                                    <td class="text-right"><?= $data['stock'] ?></td>
                                                    <td class="text-right"><?= $data['stock_min'] ?></td>
                                                    <td class="text-right"><?= $data['stock_max'] ?></td>
                                                    <td class="text-right"><?= $data['purchase'] ?></td>
                                                    <td class="text-right"><?= thousand($data['last_hpp']) ?></td>
                                                    <td class="text-right"><?= thousand($data['avg_hpp']) ?></td>
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
    <?php endforeach; ?>
</div>
<?= core_script(); ?>
<?= datatables(); ?>
<script>
    $(document).ready(function() {
        var no = 0;
        $(".table").each(function() {
            no = no + 1;
            $('#datatable' + no).DataTable({
                pageLength: 10,
                responsive: true,
                dom: '<"html5buttons">lTfgitp'
            });
        });
    });
</script>