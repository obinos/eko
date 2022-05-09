<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12 pad0">
            <div class="ibox ">
                <div class="ibox-title d-flex align-items-center justify-content-between">
                    <h5>Tanggal Pengiriman</h5>
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
    <?php foreach ($order as $k => $v) : ?>
        <div class="row">
            <div class="col-lg-12 pad0">
                <div class="ibox ">
                    <div class="ibox-title bg-info d-flex align-items-center justify-content-between">
                        <h5><?= $k ?></h5>
                    </div>
                    <div class="ibox-content">
                        <div class="table-responsive">
                            <table id="datatable" class="table tablepo table-bordered table-striped table-sm display" width="100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Alamat</th>
                                        <th width="400px">Cluster</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    foreach ($v as $data) :
                                        $shipping = strpos($data['shipping'], 'Sidoarjo') !== false ? 'Sidoarjo' : $data['shipping'];
                                        $address = strpos(ucwords($data['recipient']->address), $shipping) !== false ? $data['recipient']->address : $data['recipient']->address . ', ' . $shipping;
                                    ?>
                                        <tr class="<?= count_cust_ord($data['new_customer']) ?>">
                                            <td><?= $no++; ?></td>
                                            <td><?= $data['recipient']->name ?></td>
                                            <td><?= $address ?></td>
                                            <td><select name="cluster" class="cluster" id="<?= $data['_id'] ?>" data-phone="<?= $data['customer']->phone ?>" data-address="<?= $data['recipient']->address ?>">
                                                    <option></option>
                                                    <?php foreach ($cluster as $val) : ?>
                                                        <option value="<?= $val['_id']; ?>" <?php if ($val['_id'] == $data['recipient']->id_cluster) : ?> selected<?php endif; ?>><?= $val['code'] . ' ' . $val['name']; ?></option>
                                                    <?php endforeach; ?>
                                                </select></td>
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
            format: 'dd-mm-yyyy',
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            autoclose: true
        });
        $(".cluster").on('change', function() {
            var object = {};
            object['_id'] = $(this).attr('id');
            object['phone'] = $(this).attr('data-phone');
            object['address'] = $(this).attr('data-address');
            object['cluster'] = $(this).val();
            var jsonString = JSON.stringify(object);
            $.ajax({
                type: "POST",
                url: '<?= base_url('orderprocess/update_cluster/') ?>',
                data: {
                    data: jsonString
                },
                success: function(response) {
                    var result = $.parseJSON(response);
                    if (result.status == 'success') {
                        $.toast({
                            heading: 'Success',
                            text: 'Input Cluster ' + result.name,
                            icon: 'success',
                            showHideTransition: 'slide',
                            hideAfter: 1000,
                            position: 'top-right'
                        });
                    } else {
                        $.toast({
                            heading: 'Failed',
                            text: 'Same Value' + result.name,
                            icon: 'error',
                            showHideTransition: 'slide',
                            hideAfter: 1000,
                            position: 'top-right'
                        });
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                }
            });
        });
    });
</script>