<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-md-6 col-xl-4 pad0">
            <div class="ibox ">
                <div class="ibox-title collapse-link bg-light">
                    <h5>Data Kurir</h5>
                    <div class="ibox-tools">
                        <a>
                            <span class="fa arrow"></span>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table table-hover no-margins table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center">Nama</th>
                                    <th class="text-center">Jumlah</th>
                                    <th class="text-center">Berat</th>
                                </tr>
                            </thead>
                            <tbody id="kurir">
                                <?php foreach ($kurir as $val) : ?>
                                    <tr id="<?= $val['_id'] ?>">
                                        <td class="name_courier"><?= $val['name'] . ' (<strong>' . $val['_id'] . '</strong>)' ?></td>
                                        <td class="text-right count_courier <?= $val['count_color'] ?>"><?= $val['count'] ?></td>
                                        <td class="text-right total_weight <?= $val['weight_color'] ?>"><?= $val['shipping_weight'] ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
    <?php foreach ($order as $val) : ?>
        <div class="row">
            <div class="col-lg-12 pad0">
                <div class="ibox ">
                    <div class="ibox-title d-flex align-items-center justify-content-between">
                        <h5><?= $val['name'] . ' - ' . $val['count'] ?></h5>
                        <select name="cluster" class="form-control cluster" id="<?= $val['_id'] ?>" style="width:200px">
                            <option></option>
                            <?php foreach ($courier as $cour) : ?>
                                <option value="<?= $cour['_id']; ?>"><?= $cour['name']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="ibox-content">
                        <div class="table-responsive">
                            <table id="datatable" class="table tablepo table-bordered table-striped table-sm" width="100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th width="15%">Nama</th>
                                        <th width="45%">Alamat</th>
                                        <th width="30%">Catatan</th>
                                        <th>Payment</th>
                                        <th>Berat</th>
                                        <th>Total</th>
                                        <th width="10%">Kurir</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($val['order']) {
                                        $no = 1;
                                        foreach ($val['order'] as $key => $data) :
                                            $hub = $data->merchant_notes && $data->preferences ? "\n" : null;
                                            $preferences = $data->preferences ? implode("\n", $data->preferences) : null;
                                            $payment = payment_string($data->payment);
                                            $shipping = strpos($data->shipping, 'Sidoarjo') !== false ? 'Sidoarjo' : $data->shipping;
                                            $address = strpos(ucwords($data->address), $shipping) !== false ? $data->address : $data->address . ', ' . $shipping;
                                    ?>
                                            <tr>
                                                <td><?= $no++; ?></td>
                                                <td><?= $data->name ?></td>
                                                <td><?= $address ?></td>
                                                <td><?= nl2br($data->merchant_notes . $hub . $preferences) ?></td>
                                                <td class="<?= warning_courier($payment) ?>"><?= $payment ?></td>
                                                <td class="text-right"><?= round($data->shipping_weight / 1000, 2) ?></td>
                                                <td class="text-right <?= warning_courier($data->total) ?>"><?= thousand($data->total) ?></td>
                                                <td><select name="courier" class="courier <?= $val['_id'] ?>" id="<?= $data->id_order ?>">
                                                        <option></option>
                                                        <?php foreach ($courier as $res) : ?>
                                                            <option value="<?= $res['_id']; ?>" <?php if ($res['_id'] == $data->courier) : ?> selected<?php endif; ?>><?= $res['name']; ?></option>
                                                        <?php endforeach; ?>
                                                    </select></td>
                                            </tr>
                                    <?php endforeach;
                                    } ?>
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
<script type="text/javascript">
    $(document).ready(function() {
        $('.date').datepicker({
            format: 'dd-mm-yyyy',
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            autoclose: true
        });
        $(".cluster").on('change', function() {
            var id = this.id;
            var courier = $("option:selected", this).val();
            $('.' + id + ' option').removeAttr('selected');
            if (courier) {
                $('.' + id + ' option[value=' + courier + ']').attr("selected", "selected");
            }
            var object = {};
            var array = [];
            $('select.' + id).each(function() {
                var item = {};
                item['id_order'] = this.id;
                item['id_courier'] = $('#' + this.id + ' option:selected').val();
                array.push(item);
            });
            object['date'] = '<?= $filter_date ?>';
            object['item'] = array;
            var jsonString = JSON.stringify(object);
            inputcourier(jsonString);
        });
        $(".courier").on('change', function() {
            var object = {};
            var array = [];
            var item = {};
            item['id_order'] = this.id;
            item['id_courier'] = $('#' + this.id + ' option:selected').val();
            array.push(item);
            object['date'] = '<?= $filter_date ?>';
            object['item'] = array;
            var jsonString = JSON.stringify(object);
            inputcourier(jsonString);
        });
    });

    function inputcourier(jsonString) {
        $.ajax({
            type: "POST",
            url: '<?= base_url('orderprocess/input_courier/') ?>',
            data: {
                data: jsonString
            },
            success: function(response) {
                var result = $.parseJSON(response);
                console.log(result);
                $('tr#NULL').remove();
                var table1 = '<table><tr><th>Kurir</th><th>Order</th><th>Berat</th></tr>';
                var table2 = '';
                var table3 = '</table>';
                result.forEach(function(e) {
                    if (e._id == 'NULL') {
                        $('tbody#kurir').prepend(`<tr id="` + e._id + `">
                                        <td class="name_courier">` + e.name + `</td>
                                        <td class="text-right count_courier ` + e.count_color + `">` + e.count + `</td>
                                        <td class="text-right total_weight ` + e.weight_color + `">` + e.shipping_weight + `</td>
                                    </tr>`);
                    } else {
                        $('#' + e._id + ' .count_courier').text(e.count).removeClass("table-warning table-success table-danger").addClass(e.count_color);
                        $('#' + e._id + ' .total_weight').text(e.shipping_weight).removeClass("table-warning table-danger").addClass(e.weight_color);
                    }
                    var shipping_weight = e.shipping_weight > 45 ? '<b>' + e.shipping_weight + '</b>' : e.shipping_weight;
                    table2 = table2 + '<tr><td style="width:20%">' + e._id + '</td><td style="width:25%">' + e.count + '</td><td class="text-right" style="width:15%">' + shipping_weight + '</td></tr>';
                });
                $.toast({
                    text: table1 + table2 + table3,
                    bgColor: '#FABE0E',
                    textColor: '#212121',
                    stack: false,
                    hideAfter: false
                });
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    }
</script>