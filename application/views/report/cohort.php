<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12 pad0">
            <div class="ibox ">
                <div class="ibox-title d-flex align-items-center justify-content-between">
                    <h5>Transaksi > 0</h5>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm">
                            <thead>
                                <tr>
                                    <th>Cohort</th>
                                    <th>Customer</th>
                                    <?php for ($x = $count_trx1; $x > 0; $x--) { ?>
                                        <th>Week<?= $count_trx1 - $x ?></th>
                                    <?php } ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                foreach ($trx1 as $data) :
                                ?>
                                    <tr>
                                        <td><?= $data['cohort'] ?></td>
                                        <td><?= $data['merchant'] ?></td>
                                        <?php for ($x = $count_trx1; $x > 0; $x--) { ?>
                                            <td class="<?= color_cohort_new($data[$count_trx1 - $x]) ?>"><?= check_cohort($data[$count_trx1 - $x]) ?></td>
                                        <?php } ?>
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