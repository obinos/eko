<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12 pad0">
            <div class="ibox ">
                <div class="ibox-title d-flex align-items-center justify-content-between">
                    <h5>Detail Customer</h5>
                    <div class='btn-group btn-group-sm'>
                        <a class='btn btn-primary btn-sm' href='<?= base_url('customer/edit/' . $customer[0]['_id']); ?>'>
                            <svg class="mr-2" width="14px" height="14px" viewBox="0 0 16 16" fill="currentColor">
                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                            </svg>Edit Customer</a>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="row d-flex align-items-center">
                        <div class="col-lg-4 my-1">
                            <div class="widget style1 bg-info">
                                <div class="row d-flex align-items-center">
                                    <div class="col-3">
                                        <svg style="width:40px;height:40px" viewBox="0 0 24 24">
                                            <path fill="currentColor" d="M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2M7.07,18.28C7.5,17.38 10.12,16.5 12,16.5C13.88,16.5 16.5,17.38 16.93,18.28C15.57,19.36 13.86,20 12,20C10.14,20 8.43,19.36 7.07,18.28M18.36,16.83C16.93,15.09 13.46,14.5 12,14.5C10.54,14.5 7.07,15.09 5.64,16.83C4.62,15.5 4,13.82 4,12C4,7.59 7.59,4 12,4C16.41,4 20,7.59 20,12C20,13.82 19.38,15.5 18.36,16.83M12,6C10.06,6 8.5,7.56 8.5,9.5C8.5,11.44 10.06,13 12,13C13.94,13 15.5,11.44 15.5,9.5C15.5,7.56 13.94,6 12,6M12,11A1.5,1.5 0 0,1 10.5,9.5A1.5,1.5 0 0,1 12,8A1.5,1.5 0 0,1 13.5,9.5A1.5,1.5 0 0,1 12,11Z" />
                                        </svg>
                                    </div>
                                    <div class="col-9 text-right">
                                        <p>Nama</p>
                                        <h3 class="font-bold"><?= $customer[0]['name'] ?></h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 my-1">
                            <div class="widget style1 bg-info">
                                <div class="row d-flex align-items-center">
                                    <div class="col-3">
                                        <svg style="width:40px;height:40px" viewBox="0 0 24 24">
                                            <path fill="currentColor" d="M20,15.5C18.8,15.5 17.5,15.3 16.4,14.9C16.3,14.9 16.2,14.9 16.1,14.9C15.8,14.9 15.6,15 15.4,15.2L13.2,17.4C10.4,15.9 8,13.6 6.6,10.8L8.8,8.6C9.1,8.3 9.2,7.9 9,7.6C8.7,6.5 8.5,5.2 8.5,4C8.5,3.5 8,3 7.5,3H4C3.5,3 3,3.5 3,4C3,13.4 10.6,21 20,21C20.5,21 21,20.5 21,20V16.5C21,16 20.5,15.5 20,15.5M5,5H6.5C6.6,5.9 6.8,6.8 7,7.6L5.8,8.8C5.4,7.6 5.1,6.3 5,5M19,19C17.7,18.9 16.4,18.6 15.2,18.2L16.4,17C17.2,17.2 18.1,17.4 19,17.4V19Z" />
                                        </svg>
                                    </div>
                                    <div class="col-9 text-right">
                                        <p>Phone</p>
                                        <h3 class="font-bold"><?= $customer[0]['phone'] ?></h3>
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
                                        <p>Join</p>
                                        <h3 class="font-bold"><?= datephp('d M y', $customer[0]['created_at']) ?></h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mt-3">
                            <div class="table-responsive">
                                <table class="table table-striped table-sm table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width: 8px">No</th>
                                            <th>Nama</th>
                                            <th>Alamat</th>
                                            <th>Location</th>
                                            <th>Cluster</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        foreach ($shipping_address as $item) :
                                            $maps = $item['latitude'] && $item['longitude'] ? '<a href="https://www.google.com/maps/place/' . $item['latitude'] . ',' . $item['longitude'] . '" target="_blank">maps</a>' : null;
                                            $main = $item['is_main_address'] === true ? 'table-success' : null;
                                        ?>
                                            <tr class="<?= $main ?>">
                                                <td class="text-right"><?= $no++; ?></td>
                                                <td><?= $item['title'] ?></td>
                                                <td><?= $item['address'] ?></td>
                                                <td><?= $maps ?></td>
                                                <td><?= $item['cluster'] ?></td>
                                            </tr>
                                        <?php endforeach; ?>

                                    </tbody>
                                </table>
                            </div>
                            <?php if ($voucher) { ?>
                                <div class="alert alert-warning mb-2" role="alert">
                                    <p>Voucher: <b><?= implode(", ", $voucher); ?></b></p>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    $stat = 1;
    foreach ($order as $ord) :
    ?>
        <div class="row">
            <div class="col-lg-12 pad0">
                <div class="ibox ">
                    <div class="ibox-title d-flex align-items-center justify-content-between <?= $ord[0]['bg'] ?>">
                        <h5>History Order <?= $ord[0]['res'] ?></h5>
                    </div>
                    <div class="ibox-content">
                        <div class="row d-flex align-items-center">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table id="datatable<?= $stat++; ?>" class="table table-striped table-sm table-bordered display" width="100%">
                                        <thead>
                                            <tr>
                                                <th style="width: 8px">No</th>
                                                <th>Tgl Beli</th>
                                                <th>Tgl Kirim</th>
                                                <th>Invoice</th>
                                                <th>Voucher</th>
                                                <th>Nominal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $no = 1;
                                            foreach ($ord as $key => $data) :
                                            ?>
                                                <tr>
                                                    <td class="text-right"><?= $no++; ?></td>
                                                    <td><span class="pace-inactive"><?= $data['transaction_date_number'] ?></span><?= $data['transaction_date'] ?></td>
                                                    <td><span class="pace-inactive"><?= $data['delivery_time_number'] ?></span><?= $data['delivery_time'] ?></td>
                                                    <td><a href="<?= $data['invno_link'] ?>"><?= $data['invno'] ?></a></td>
                                                    <td><?= $data['voucher'] ?></td>
                                                    <td class="text-right"><?= $data['total'] ?></td>
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