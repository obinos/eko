<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12 pad0">
            <div class="ibox ">
                <div class="ibox-title d-flex align-items-center justify-content-between">
                    <h5>Data Rekap PO</h5>
                </div>
                <?php foreach ((array)$order as $key => $val) : ?>
                    <div class="ibox-content content-print">
                        <h2><?= $key . ' - ' . count($val) ?></h2>
                        <?php
                        $no = 1;
                        foreach ((array)$val as $data) :
                        ?>
                            <div class="table-responsive">
                                <table class="tbheader table table-striped table-sm display" width="100%">
                                    <tbody>
                                        <tr>
                                            <td width="5px"><b><?= $no++ ?></b></td>
                                            <td width="20px"><b>Nama</b></td>
                                            <td><?= $data['recipient']['name'] ?></td>
                                        </tr>
                                        <tr>
                                            <td width="5px"></td>
                                            <td width="20px"><b>Alamat</b></td>
                                            <td><?= $data['recipient']['address'] ?></td>
                                        </tr>
                                        <?php if ($data['merchant_notes']) { ?>
                                            <tr>
                                                <td width="5px"></td>
                                                <td width="20px"><b>Catatan</b></td>
                                                <td><?= $data['merchant_notes'] ?></td>
                                            </tr>
                                        <?php } ?>
                                        <tr>
                                            <td width="5px"></td>
                                            <td width="20px"><b>No HP</b></td>
                                            <td><?= $data['recipient']['phone'] ?></td>
                                        </tr>
                                        <?php if (strpos($data['payment'][0]['method'], 'COD') !== false) { ?>
                                            <tr>
                                                <td width="5px"></td>
                                                <td width="20px">
                                                    <h2><b>COD</b></h2>
                                                </td>
                                                <td>
                                                    <h2><b><?= thousand($data['price']['total']) ?></b>
                                                        <h2>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endforeach; ?>
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