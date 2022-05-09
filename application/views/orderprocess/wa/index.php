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
                                <button type="submit" class="btn btn-lg btn-warning btn-block">Filter</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 pad0">
            <div class="ibox">
                <div class="ibox-title collapse-link bg-light">
                    <h5>Send WA Custom</h5>
                    <div class="ibox-tools">
                        <a>
                            <span class="fa arrow"></span>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="form-row align-items-center">
                        <div class="col-lg-5 my-1">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text width46"><svg style="width:20px;height:20px;margin:auto" viewBox="0 0 24 24">
                                            <path fill="#173b60" d="M5,20.5A3.5,3.5 0 0,1 1.5,17A3.5,3.5 0 0,1 5,13.5A3.5,3.5 0 0,1 8.5,17A3.5,3.5 0 0,1 5,20.5M5,12A5,5 0 0,0 0,17A5,5 0 0,0 5,22A5,5 0 0,0 10,17A5,5 0 0,0 5,12M14.8,10H19V8.2H15.8L13.86,4.93C13.57,4.43 13,4.1 12.4,4.1C11.93,4.1 11.5,4.29 11.2,4.6L7.5,8.29C7.19,8.6 7,9 7,9.5C7,10.13 7.33,10.66 7.85,10.97L11.2,13V18H13V11.5L10.75,9.85L13.07,7.5M19,20.5A3.5,3.5 0 0,1 15.5,17A3.5,3.5 0 0,1 19,13.5A3.5,3.5 0 0,1 22.5,17A3.5,3.5 0 0,1 19,20.5M19,12A5,5 0 0,0 14,17A5,5 0 0,0 19,22A5,5 0 0,0 24,17A5,5 0 0,0 19,12M16,4.8C17,4.8 17.8,4 17.8,3C17.8,2 17,1.2 16,1.2C15,1.2 14.2,2 14.2,3C14.2,4 15,4.8 16,4.8Z" />
                                        </svg></div>
                                </div>
                                <select name="filter_courier" class="form-control" id="filter_courier">
                                    <option></option>
                                    <?php foreach ($courier as $val) : ?>
                                        <option value="<?= $val['_id']; ?>"><?= $val['name']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-5 my-1">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text width46"><svg style="width:20px;height:20px;margin:auto" viewBox="0 0 24 24">
                                            <path fill="#173b60" d="M20,15.5C18.8,15.5 17.5,15.3 16.4,14.9C16.3,14.9 16.2,14.9 16.1,14.9C15.8,14.9 15.6,15 15.4,15.2L13.2,17.4C10.4,15.9 8,13.6 6.6,10.8L8.8,8.6C9.1,8.3 9.2,7.9 9,7.6C8.7,6.5 8.5,5.2 8.5,4C8.5,3.5 8,3 7.5,3H4C3.5,3 3,3.5 3,4C3,13.4 10.6,21 20,21C20.5,21 21,20.5 21,20V16.5C21,16 20.5,15.5 20,15.5M5,5H6.5C6.6,5.9 6.8,6.8 7,7.6L5.8,8.8C5.4,7.6 5.1,6.3 5,5M19,19C17.7,18.9 16.4,18.6 15.2,18.2L16.4,17C17.2,17.2 18.1,17.4 19,17.4V19Z" />
                                        </svg></div>
                                </div>
                                <select name="filter_wa" class="form-control" id="filter_wa">
                                    <option></option>
                                    <?php foreach ($hpcourier as $hp) : ?>
                                        <option value="<?= $hp['phone']; ?>"><?= $hp['name']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-2 my-1">
                            <button class='btn btn-lg btn-block btn-primary wa-custom'>Send WA</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php foreach ($courier as $value) :
        $keys = array_column($value['recipient'], 'lower');
        array_multisort($keys, SORT_ASC, $value['recipient']); ?>
        <div class="row">
            <div class="col-lg-12 pad0">
                <div class="ibox">
                    <div class="ibox-title d-flex align-items-center justify-content-between bg-info">
                        <h5><?= $value['_id'] ? $value['name'] . ' - ' . $value['_id'] . ' (' . $value['phone'] . ')' : 'NULL' ?></h5>
                        <textarea class="pace-inactive" id="<?= $value['_id'] ?>"><?= $value['textwa'] ?></textarea>
                        <?php if ($value['_id']) { ?>
                            <div class='btn-group btn-group-sm'>
                                <button class='btn btn-primary btn-sm wa-button' data-id='<?= $value['_id'] ?>' data-phone='<?= $value['phone'] ?>' data-textwa='<?= $value['textwa'] ?>' data-tooltip="tooltip" data-placement="top" title="Send WA">
                                    <svg width="16px" height="16px" viewBox="0 0 16 16" fill="currentColor">
                                        <path d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z" />
                                    </svg></button>
                                <button class='btn btn-dark btn-sm copy-button' data-id='<?= $value['_id'] ?>' data-tooltip="tooltip" data-placement="top" title="Copy Text" onclick="copyVariable('#<?= $value['_id'] ?>')">
                                    <svg width="16px" height="16px" viewBox="0 0 16 16" fill="currentColor">
                                        <path d="M13 0H6a2 2 0 0 0-2 2 2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h7a2 2 0 0 0 2-2 2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zm0 13V4a2 2 0 0 0-2-2H5a1 1 0 0 1 1-1h7a1 1 0 0 1 1 1v10a1 1 0 0 1-1 1zM3 4a1 1 0 0 1 1-1h7a1 1 0 0 1 1 1v10a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V4z" />
                                    </svg></button>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="ibox-content">
                        <?php if ($value['time_courier']) { ?>
                            <p class="text-primary">Paket Siap: <strong><?= $value['time_courier'] ?></strong></p>
                            <p class="mb-2 text-primary">Customer Terima: <strong><?= $value['time_customer'] ?></strong></p>
                        <?php } ?>
                        <div class="table-responsive">
                            <table class="table table-striped table-sm display" width="100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>No HP</th>
                                        <th>Alamat</th>
                                        <th>Catatan</th>
                                        <th width="8%" class="text-right">COD</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = 1;
                                    foreach ($value['recipient'] as $key => $data) :
                                        $hub = $data->merchant_notes && $data->preferences ? "\n" : null;
                                        $preferences = $data->preferences ? implode("\n", $data->preferences) : null;
                                        $shipping = strpos($data->shipping, 'Sidoarjo') !== false ? 'Sidoarjo' : $data->shipping;
                                        $address = strpos(ucwords($data->address), $shipping) !== false ? $data->address : $data->address . ', ' . $shipping;
                                    ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= $data->name ?></td>
                                            <td><?= $data->phone ?></td>
                                            <td><?= $address ?></td>
                                            <td><?= nl2br($data->merchant_notes . $hub . $preferences) ?></td>
                                            <td class="text-right"><?= $data->payment ? thousand($data->payment[0]->payment_amount) : null ?></td>
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
<?= select2(); ?>
<?= toast(); ?>
<script>
    $(document).ready(function() {
        $('.copy-button').click(function() {
            $.toast({
                heading: 'Success',
                text: 'Copy Text',
                icon: 'success',
                showHideTransition: 'slide',
                hideAfter: 1000,
                position: 'top-right'
            });
        });
        $('.date').datepicker({
            format: 'dd-mm-yyyy',
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            autoclose: true
        });
        $("#filter_courier").select2({
            placeholder: 'Pilih Kurir',
            theme: 'bootstrap4',
            language: 'id'
        });
        $("#filter_wa").select2({
            placeholder: 'Input no WA',
            theme: 'bootstrap4',
            language: 'id',
            tags: true
        });
        $('.wa-button,.wa-custom').on('click', function(e) {
            e.preventDefault();
            $('.wa-button,.wa-custom').prop('disabled', true);
            var id_courier = $(this).attr('data-id') ? $(this).attr('data-id') : $('select[name=filter_courier]').val();
            var filter_wa = $(this).attr('data-phone') ? $(this).attr('data-phone') : $('select[name=filter_wa]').val();
            var filter_textwa = $(this).attr('data-phone') ? $(this).attr('data-textwa') : $('textarea#' + id_courier).val();
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
                            hp: filter_wa,
                            textwa: filter_textwa
                        },
                        success: function(response) {
                            $.toast({
                                heading: 'Success',
                                text: 'Send WA',
                                icon: 'success',
                                showHideTransition: 'slide',
                                hideAfter: 5000,
                                position: 'top-right',
                                afterHidden: function() {
                                    $('.wa-button,.wa-custom').prop('disabled', false);
                                }
                            });
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.log(textStatus, errorThrown);
                        }
                    });
                } else {
                    $('.wa-button,.wa-custom').prop('disabled', false);
                }
            });
        });
    });

    function copyVariable(element) {
        var $temp = $("<textarea>");
        var brRegex = /<br\s*[\/]?>/gi;
        $("body").append($temp);
        $temp.val($(element).html().replace(brRegex, "\r\n")).select();
        document.execCommand("copy");
        $temp.remove();
    }
</script>