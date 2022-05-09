<link href="<?= base_url('assets/'); ?>vendor/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css" rel="stylesheet" type="text/css">
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12 px-1">
            <div class="ibox mb-3">
                <div class="ibox-content">
                    <form method="post" id="filter_user">
                        <div class="form-row d-flex align-items-end">
                            <div class="col-lg-4 my-1">
                                <p>Tanggal Pengiriman</p>
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
                                <button type="submit" class="btn btn-warning btn-block btn-lg">Filter</button>
                            </div>
                            <div class="col-lg-4 my-1">
                                <p>Jam Mulai</p>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text width46"><svg style="width:20px;height:20px;margin:auto" viewBox="0 0 24 24">
                                                <path fill="#173b60" d="M12,20A7,7 0 0,1 5,13A7,7 0 0,1 12,6A7,7 0 0,1 19,13A7,7 0 0,1 12,20M12,4A9,9 0 0,0 3,13A9,9 0 0,0 12,22A9,9 0 0,0 21,13A9,9 0 0,0 12,4M12.5,8H11V14L15.75,16.85L16.5,15.62L12.5,13.25V8M7.88,3.39L6.6,1.86L2,5.71L3.29,7.24L7.88,3.39M22,5.72L17.4,1.86L16.11,3.39L20.71,7.25L22,5.72Z" />
                                            </svg></div>
                                    </div>
                                    <select name="filter_start" class="form-control" id="filter_start">
                                        <?php foreach ($start as $value) : ?>
                                            <option value="<?= $value; ?>" <?php if ($value == $filter_start) : ?> selected<?php endif; ?>><?= $value; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-2 my-1">
                                <button class="btn btn-success btn-block btn-lg" id="kalibrasi">Kalibrasi</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <?php if ($courier) { ?>
        <div class="row d-flex justify-content-center">
            <?php foreach ($courier as $k => $val) {
                $rak = $k == 0 ? 'rak-1' : ($k == 1 ? 'rak-2' : 'rak-3');
                $theme = $k == 0 ? 'primary-element' : ($k == 1 ? 'warning-element' : 'danger-element');
                $bg = $k == 0 ? 'bg-primary' : ($k == 1 ? 'bg-warning' : 'bg-danger'); ?>
                <div class="col-lg-4 px-1">
                    <div class="ibox mb-3">
                        <div class="ibox-title d-flex align-items-center justify-content-between <?= $bg ?>">
                            <h5><?= $rak ?></h5>
                        </div>
                        <div class="ibox-content p-3">
                            <ul class="sortable-list connectList agile-list" id="<?= $rak ?>">
                                <?php $no = 1;
                                foreach ($val as $cou) { ?>
                                    <li class="theme <?= $theme ?>" id="<?= $cou['_id'] ?>">
                                        <div class="row justify-content-center d-flex align-items-center">
                                            <div class="col-3">
                                                <h4 class="m-0 urut"><?= $no++ ?>.</h4>
                                            </div>
                                            <div class="col-3">
                                                <h4 class="m-0"><?= $cou['_id'] ?></h4>
                                            </div>
                                            <div class="col-3">
                                                <h4 class="m-0 time" data-nominal="<?= $cou['nominal'] ?>">__:__</h4>
                                            </div>
                                            <div class="col-3">
                                                <h4 class="m-0 order"><?= $cou['total'] == $cou['order'] ? $cou['order'] : $cou['total'] . '/' . $cou['order'] ?></h4>
                                            </div>
                                            <div class="col-12">
                                                <?php $num = 1;
                                                foreach ($cou['cat'] as $cat) {
                                                    $numcheck = $num++; ?>
                                                    <div class="form-check abc-checkbox abc-checkbox-success">
                                                        <input class="cat" type="hidden" value="<?= $cat ?>">
                                                        <input class="form-check-input note" type="checkbox" value="<?= $cat ?>" id="<?= $cou['_id'] . $numcheck ?>">
                                                        <label class="form-check-label boolean" for="<?= $cou['_id'] . $numcheck ?>">
                                                            <?= $cat ?>
                                                        </label>
                                                    </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <button class="btn btn-warning btn-block btn-lg mb-3" id="submit">Submit</button>
        </div>
    <?php } ?>
</div>
<?= core_script(); ?>
<?= toast(); ?>
<?= sortable(); ?>
<?= datepicker(); ?>
<?= select2(); ?>
<script>
    $(document).ready(function() {
        $('.date').datepicker({
            format: 'dd-mm-yyyy',
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            autoclose: true
        });
        $("#filter_start").select2({
            theme: 'bootstrap4',
            language: 'id',
            tags: true
        });
        $("#rak-1, #rak-2, #rak-3").sortable({
            connectWith: ".connectList",
            update: function(event, ui) {
                $(".theme").removeClass("danger-element primary-element warning-element");
                for (let i = 1; i <= $(".agile-list").length; i++) {
                    var no = 1;
                    var theme = i == 1 ? 'primary-element' : (i == 2 ? 'warning-element' : 'danger-element');
                    $("#rak-" + i + " .theme").each(function() {
                        var id = $(this).attr('id');
                        $("#" + id).addClass(theme);
                        $("#" + id + " input.hidden").val(theme);
                        $("#" + id + " .urut").text(no++ + '.');
                    });
                }
            }
        }).disableSelection();
        $('#kalibrasi').on('click', function(e) {
            e.preventDefault();
            var cekrak = $("#rak-3 li").length;
            price = cekrak < 1 ? 115000 : 105000;
            kalibrasi = string_time($("#filter_start").val());
            rak1_time = kalibrasi;
            rak2_time = Number(kalibrasi) + 5;
            rak3_time = Number(kalibrasi) + 10;
            for (let i = 1; i <= $(".agile-list").length; i++) {
                norak = rak = 0;
                rak_time = i == 1 ? Number(kalibrasi) : (i == 2 ? Number(kalibrasi) + 5 : Number(kalibrasi) + 10);
                $('#rak-' + i + ' li .time').each(function() {
                    nominal = $(this).attr('data-nominal');
                    selisih = norak++ == 0 ? 0 : Math.ceil(Number(nominal) / price);
                    rak = selisih + rak;
                    time = rak_time + rak;
                    $(this).text(time_convert(time));
                });
            }
            $.toast({
                heading: 'Success',
                text: 'Kalibrasi Waktu',
                icon: 'success',
                showHideTransition: 'slide',
                hideAfter: 1000,
                position: 'top-right'
            });
        });
        $('#submit').on('click', function(e) {
            $('#submit').prop('disabled', true);
            e.preventDefault();
            Swal({
                title: 'Are You sure?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#45eba5',
                cancelButtonColor: '#fd8664',
                confirmButtonText: 'Submit'
            }).then((result) => {
                if (result.value) {
                    var object = {};
                    var array = [];
                    for (let i = 1; i <= $(".agile-list").length; i++) {
                        $("#rak-" + i + " .theme").each(function() {
                            var item = {};
                            var note = [];
                            var cat = [];
                            var id = $(this).attr('id');
                            item['_id'] = id;
                            item['status'] = 'rak-' + i;
                            item['time'] = $("#" + id + " .time").text();
                            item['order'] = $("#" + id + " .order").text();
                            item['nominal'] = $("#" + id + " .time").attr('data-nominal');
                            $("#" + id + " input[type=checkbox]:checked").each(function() {
                                note.push($(this).val());
                            });
                            $("#" + id + " input[type=hidden]").each(function() {
                                cat.push($(this).val());
                            });
                            item['note'] = note;
                            item['cat'] = cat;
                            array.push(item);
                        });
                    }
                    object['data'] = array;
                    object['date'] = '<?= $filter_date ?>';
                    var jsonString = JSON.stringify(object);
                    $.ajax({
                        type: "POST",
                        url: '<?= base_url('orderprocess/update_rute/') ?>',
                        data: {
                            data: jsonString
                        },
                        success: function(response) {
                            var result = $.parseJSON(response);
                            if (result.status == 'success') {
                                $.toast({
                                    heading: 'Success',
                                    text: 'Urutkan Kurir',
                                    icon: 'success',
                                    showHideTransition: 'slide',
                                    hideAfter: 1500,
                                    position: 'top-right',
                                    afterHidden: function() {
                                        $('#submit').prop('disabled', false);
                                        window.location = "<?= base_url('orderprocess/rute/rute_list') ?>";
                                    }
                                });
                            } else {
                                $.toast({
                                    heading: 'Failed',
                                    text: 'Urutkan Kurir',
                                    icon: 'error',
                                    showHideTransition: 'slide',
                                    hideAfter: 1500,
                                    position: 'top-right',
                                    afterHidden: function() {
                                        $('#submit').prop('disabled', false);
                                    }
                                });
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.log(textStatus, errorThrown);
                        }
                    });
                } else {
                    $('#submit').prop('disabled', false);
                }
            })
        });
    });

    function string_time(string) {
        var data = string.split(":");
        var menit = (Number(data[0]) * 60) + Number(data[1]);
        return menit;
    }

    function time_convert(num) {
        var hours = Math.floor(num / 60);
        var hour = hours.length == 1 ? hours : '0' + hours;
        var minutes = num % 60;
        if (minutes == 0)
            var minute = '00';
        else if (minutes < 10)
            var minute = '0' + minutes;
        else
            var minute = minutes;
        return hour + ":" + minute;
    }
</script>