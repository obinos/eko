<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12 pad0">
            <div class="ibox">
                <div class="ibox-title collapse-link bg-light">
                    <h5>Tanggal Pengiriman</h5>
                    <div class="ibox-tools">
                        <a>
                            <span class="fa arrow"></span>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <form method="post" id="filter_user">
                        <div class="form-row align-items-center">
                            <div class="col-lg-10 my-1">
                                <div class="input-group date">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text width46"><svg style="width:20px;height:20px;margin:auto" viewBox="0 0 24 24">
                                                <path fill="#173b60" d="M9,10H7V12H9V10M13,10H11V12H13V10M17,10H15V12H17V10M19,3H18V1H16V3H8V1H6V3H5C3.89,3 3,3.9 3,5V19A2,2 0 0,0 5,21H19A2,2 0 0,0 21,19V5A2,2 0 0,0 19,3M19,19H5V8H19V19Z"></path>
                                            </svg></div>
                                    </div>
                                    <input type="text" class="form-control" name="filter_date" placeholder="Input Tanggal" value="<?= $filter_date ?>" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-lg-2 my-1">
                                <button type="submit" class="btn btn-warning btn-block">Filter</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php foreach ($courier as $value) :
        $keys = array_column($value['recipient'], 'lower');
        array_multisort($keys, SORT_ASC, $value['recipient']);
        $order = $value['total'] == $value['order'] ? $value['total'] : $value['total'] . '/' . $value['order']; ?>
        <div class="row">
            <div class="col-lg-12 pad0">
                <div class="ibox">
                    <div class="ibox-title d-flex align-items-center justify-content-between bg-info">
                        <h5><?= $value['_id'] ? $value['name'] . ' - ' . $value['_id'] . ' (' . $order . ' = ' . thousand($value['nominal']) . ')' : 'NULL' ?></h5>
                    </div>
                    <div class="ibox-content">
                        <div class="table-responsive">
                            <table class="table table-striped table-sm display" width="100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>No HP</th>
                                        <th>Alamat</th>
                                        <th>Catatan</th>
                                        <th>COD</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    foreach ($value['recipient'] as $key => $data) :
                                    ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= $data->name ?></td>
                                            <td><?= $data->phone ?></td>
                                            <td><?= $data->address ?></td>
                                            <td><?= $data->merchant_notes ?></td>
                                            <td><?= $data->payment ? thousand($data->payment[0]->payment_amount) : null ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<?= core_script(); ?>
<?= datepicker(); ?>
<?= toast(); ?>
<script>
    $(document).ready(function() {
        $('.date').datepicker({
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            autoclose: true
        });
        $('.wa-button').on('click', function(e) {
            e.preventDefault();
            var id_courier = $(this).attr('data-id');
            Swal({
                title: 'Are You sure?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#45eba5',
                cancelButtonColor: '#fd8664',
                confirmButtonText: 'Send'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        type: "POST",
                        url: '<?= base_url('orderprocess/send_wa_courier') ?>',
                        data: {
                            date: '<?= $filter_date ?>',
                            id: id_courier
                        },
                        success: function(response) {
                            $.toast({
                                heading: 'Success',
                                text: 'Send WA',
                                icon: 'success',
                                showHideTransition: 'slide',
                                hideAfter: 1500,
                                position: 'top-right'
                            });
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.log(textStatus, errorThrown);
                        }
                    });
                }
            });
        });
    });
</script>