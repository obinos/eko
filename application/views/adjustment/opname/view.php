<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12 pad0">
            <div class="ibox ">
                <div class="ibox-title d-flex align-items-center justify-content-between">
                    <h5>Data Stock Opname</h5>
                    <div class='btn-group btn-group-sm'>
                        <a class='btn btn-warning btn-sm' href='<?= base_url('adjustment/re_opname/' . $adjustment[0]['_id']->id); ?>'>
                            <svg class="mr-2" width="14px" height="14px" viewBox="0 0 16 16" fill="currentColor">
                                <path d="M11.534 7h3.932a.25.25 0 0 1 .192.41l-1.966 2.36a.25.25 0 0 1-.384 0l-1.966-2.36a.25.25 0 0 1 .192-.41zm-11 2h3.932a.25.25 0 0 0 .192-.41L2.692 6.23a.25.25 0 0 0-.384 0L.342 8.59A.25.25 0 0 0 .534 9z" />
                                <path fill-rule="evenodd" d="M8 3c-1.552 0-2.94.707-3.857 1.818a.5.5 0 1 1-.771-.636A6.002 6.002 0 0 1 13.917 7H12.9A5.002 5.002 0 0 0 8 3zM3.1 9a5.002 5.002 0 0 0 8.757 2.182.5.5 0 1 1 .771.636A6.002 6.002 0 0 1 2.083 9H3.1z" />
                            </svg>Re-Stock Opname</a>
                        <a class='btn btn-primary btn-sm' href='<?= base_url('adjustment/excel_opname/' . $adjustment[0]['_id']->id); ?>'>
                            <svg class="mr-2" width="14px" height="14px" viewBox="0 0 16 16" fill="currentColor">
                                <path fill-rule="evenodd" d="M.5 8a.5.5 0 0 1 .5.5V12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V8.5a.5.5 0 0 1 1 0V12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V8.5A.5.5 0 0 1 .5 8z" />
                                <path fill-rule="evenodd" d="M5 7.5a.5.5 0 0 1 .707 0L8 9.793 10.293 7.5a.5.5 0 1 1 .707.707l-2.646 2.647a.5.5 0 0 1-.708 0L5 8.207A.5.5 0 0 1 5 7.5z" />
                                <path fill-rule="evenodd" d="M8 1a.5.5 0 0 1 .5.5v8a.5.5 0 0 1-1 0v-8A.5.5 0 0 1 8 1z" />
                            </svg>Export Excel</a>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="row justify-content-center d-flex align-items-center">
                        <div class="col-lg-4 my-1">
                            <div class="widget style1 bg-info">
                                <div class="row d-flex align-items-center">
                                    <div class="col-3">
                                        <svg style="width:40px;height:40px" viewBox="0 0 24 24">
                                            <path fill="currentColor" d="M4,6H6V18H4V6M7,6H8V18H7V6M9,6H12V18H9V6M13,6H14V18H13V6M16,6H18V18H16V6M19,6H20V18H19V6M2,4V8H0V4A2,2 0 0,1 2,2H6V4H2M22,2A2,2 0 0,1 24,4V8H22V4H18V2H22M2,16V20H6V22H2A2,2 0 0,1 0,20V16H2M22,20V16H24V20A2,2 0 0,1 22,22H18V20H22Z" />
                                        </svg>
                                    </div>
                                    <div class="col-9 text-right">
                                        <p>Nomer</p>
                                        <h3 class="font-bold"><?= $adjustment[0]['_id']->no ?></h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 my-1">
                            <div class="widget style1 bg-info">
                                <div class="row d-flex align-items-center">
                                    <div class="col-3">
                                        <svg style="width:40px;height:40px" viewBox="0 0 24 24">
                                            <path fill="currentColor" d="M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2M7.07,18.28C7.5,17.38 10.12,16.5 12,16.5C13.88,16.5 16.5,17.38 16.93,18.28C15.57,19.36 13.86,20 12,20C10.14,20 8.43,19.36 7.07,18.28M18.36,16.83C16.93,15.09 13.46,14.5 12,14.5C10.54,14.5 7.07,15.09 5.64,16.83C4.62,15.5 4,13.82 4,12C4,7.59 7.59,4 12,4C16.41,4 20,7.59 20,12C20,13.82 19.38,15.5 18.36,16.83M12,6C10.06,6 8.5,7.56 8.5,9.5C8.5,11.44 10.06,13 12,13C13.94,13 15.5,11.44 15.5,9.5C15.5,7.56 13.94,6 12,6M12,11A1.5,1.5 0 0,1 10.5,9.5A1.5,1.5 0 0,1 12,8A1.5,1.5 0 0,1 13.5,9.5A1.5,1.5 0 0,1 12,11Z" />
                                        </svg>
                                    </div>
                                    <div class="col-9 text-right">
                                        <p>Maker</p>
                                        <h3 class="font-bold"><?= $adjustment[0]['_id']->usermaker ?></h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 my-1">
                            <div class="widget style1 bg-info">
                                <div class="row d-flex align-items-center">
                                    <div class="col-3">
                                        <svg style="width:40px;height:40px" viewBox="0 0 24 24">
                                            <path fill="currentColor" d="M19,4H18V2H16V4H8V2H6V4H5A2,2 0 0,0 3,6V20A2,2 0 0,0 5,22H19A2,2 0 0,0 21,20V6A2,2 0 0,0 19,4M19,20H5V10H19V20M5,8V6H19V8H5M10.56,18.46L16.5,12.53L15.43,11.47L10.56,16.34L8.45,14.23L7.39,15.29L10.56,18.46Z" />
                                        </svg>
                                    </div>
                                    <div class="col-9 text-right">
                                        <p>Create</p>
                                        <h3 class="font-bold"><?= $adjustment[0]['_id']->created_at ?></h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 mt-3">
                            <?php if ($adjustment[0]['_id']->notes) { ?>
                                <div class="alert alert-success" role="alert">
                                    <p>Note: <b><?= $adjustment[0]['_id']->notes; ?></b></p>
                                </div>
                        </div>
                        <div class="col-lg-12">
                        <?php } ?>
                        <div class="table-responsive">
                            <table class="table table-striped table-sm display table-bordered">
                                <thead>
                                    <tr>
                                        <th style="width: 5%">No</th>
                                        <th style="width: 10%">SKU</th>
                                        <th style="width: 45%">Nama Produk</th>
                                        <th style="width: 10%" class="text-right">Stok Fisik</th>
                                        <th style="width: 10%" class="text-right">Selisih</th>
                                        <th style="width: 20%" class="text-right">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    foreach ($adjustment[0]['items'] as $k => $i) :
                                    ?>
                                        <tr class="<?= $i->table ?>">
                                            <td class="text-right"><?= $no++; ?></td>
                                            <td><?= $i->barcode ?></td>
                                            <td><?= $i->name ?></td>
                                            <td class="text-right"><?= $i->physic ?></td>
                                            <td class="text-right"><?= $i->difference ?></td>
                                            <td class="text-right"><?= thousand($i->difference * $i->hpp) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th class="text-right" colspan="5">Total</th>
                                        <th class="text-right"><?= thousand($adjustment[0]['_id']->total); ?></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= core_script(); ?>