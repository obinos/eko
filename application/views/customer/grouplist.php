<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12 pad0">
            <div class="ibox ">
                <div class="ibox-title d-flex align-items-center justify-content-between">
                    <h5>List Customer</h5>
                    <div class='btn-group btn-group-sm'>
                        <a class='btn btn-primary btn-sm' href='<?= base_url('customer/export_excel/' . $circle); ?>'>
                            <svg class="mr-2" width="14px" height="14px" viewBox="0 0 16 16" fill="currentColor">
                                <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V9H3V2a1 1 0 0 1 1-1h5.5v2zM3 12v-2h2v2H3zm0 1h2v2H4a1 1 0 0 1-1-1v-1zm3 2v-2h3v2H6zm4 0v-2h3v1a1 1 0 0 1-1 1h-2zm3-3h-3v-2h3v2zm-7 0v-2h3v2H6z" />
                            </svg>Export Excel</a>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="row d-flex align-items-center">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table id="datatable" class="table table-striped table-sm display" width="100%">
                                    <thead>
                                        <tr>
                                            <th style="width: 8px">No</th>
                                            <th>First Order</th>
                                            <th>Last Order</th>
                                            <th>Nama</th>
                                            <th>Phone</th>
                                            <th>Order</th>
                                            <th>Nominal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        foreach ($customer['data'] as $data) :
                                            $search = array('$name', '$lastorder');
                                            $replace = array($data['name'], substr($data['last'], 9));
                                            $greeting = str_replace($search, $replace, $message);
                                        ?>
                                            <tr>
                                                <td class="text-right"><?= $no++; ?></td>
                                                <td><span class="pace-inactive"><?= substr($data['first'], 0, 8) ?></span><?= substr($data['first'], 9) ?></td>
                                                <td><span class="pace-inactive"><?= substr($data['last'], 0, 8) ?></span><?= substr($data['last'], 9) ?></td>
                                                <td><?= $data['name'] ?></td>
                                                <td><a class="wa" href="https://api.whatsapp.com/send?phone=<?= nohp($data['_id']) ?>&text=<?= urlencode($greeting) ?>" target="_blank"><?= $data['_id'] ?></a></td>
                                                <td class="text-right"><?= $data['order'] ?></td>
                                                <td class="text-right"><?= thousand($data['total']) ?></td>
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
</div>
<?= core_script(); ?>
<?= datatables(); ?>
<script>
    $(document).ready(function() {
        $('#datatable').DataTable({
            pageLength: 50,
            responsive: true,
            dom: '<"html5buttons">lTfgitp'
        });
        $('#datatable').on('click', '.wa', function() {
            $(this).addClass("text-danger");
        });
    });
</script>