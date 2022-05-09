<div class="row d-flex align-items-center justify-content-center text-center">
    <div class="col-md-7">
        <img src="<?= base_url('assets/'); ?>img/authentication<?= getenv("APP_BRAND") ?>.svg" class="img-auth img-fluid mx-auto my-auto" width="600px">
    </div>
    <div class="col-md-5">
        <img src="<?= base_url('assets/'); ?>img/aratawidegreen.svg" class="img-fluid" width="120">
        <h2 class="font-bold">Masukkan 4 angka OTP</h2>
        <p>Kode OTP sudah dikirimkan melalui WhatsApp</p>
        <p>ke nomer <span class="font-weight-bold"><?= nohpdash(nohpnol($this->session->userdata('otp_phone'))) ?></span></p>
        <form class="otp mt-4" id="form" method="post">
            <input class="border-otp" id="codeBox1" name="codeBox1" type="number" maxlength="1" onkeyup="onKeyUpEvent(1, event)" onfocus="onFocusEvent(1)" />
            <input class="border-otp" id="codeBox2" name="codeBox2" type="number" maxlength="1" onkeyup="onKeyUpEvent(2, event)" onfocus="onFocusEvent(2)" />
            <input class="border-otp" id="codeBox3" name="codeBox3" type="number" maxlength="1" onkeyup="onKeyUpEvent(3, event)" onfocus="onFocusEvent(3)" />
            <input class="border-otp" id="codeBox4" name="codeBox4" type="number" maxlength="1" onkeyup="onKeyUpEvent(4, event)" onfocus="onFocusEvent(4)" />
            <div class="errorOTP"></div>
            <button type="submit" class="btn btn-lg btn-primary block full-width m-t mb-2">Verifikasi</button>
            <p>mohon menunggu <span class="text-success" id="timer"></span> untuk mengirim ulang OTP</p>
            <div id="send-again">
            </div>
        </form>
        <p class="m-t text-center"> <small>Copyright &copy; <?= date('Y') . ' ' . $this->lang->line('copyright'); ?></small> </p>
    </div>
</div>
<?= core_script_footer(); ?>
<?= toast(); ?>
<?= validate(); ?>
<script type="text/javascript">
    $("#codeBox1").focus();
    let timerOn = true;

    function timer(remaining) {
        var m = Math.floor(remaining / 60);
        var s = remaining % 60;
        m = m < 10 ? '0' + m : m;
        s = s < 10 ? '0' + s : s;
        document.getElementById('timer').innerHTML = m + ':' + s;
        remaining -= 1;
        if (remaining >= 0 && timerOn) {
            setTimeout(function() {
                timer(remaining);
            }, 1000);
            return;
        }
        if (!timerOn) {
            return;
        }
        $("#send-again").html("<p class='text-muted mt-2'>Tidak menerima kode OTP?</p><a class='btn btn-warning btn-block text-dark' id='changeotp'>Kirim Ulang</a>");
    }
    timer(60);
    $(document).ready(function() {
        $("#form").validate({
            rules: {
                codeBox4: {
                    required: true
                }
            },
            messages: {
                codeBox4: {
                    required: "kolom harus diisi."
                }
            },
            errorPlacement: function(error, element) {
                if (element.attr("name") == "codeBox4")
                    error.insertAfter(".errorOTP");
            },
            submitHandler: function() {
                var object = {};
                object['action'] = 'otp';
                object['otp'] = $('#codeBox1').val() + $('#codeBox2').val() + $('#codeBox3').val() + $('#codeBox4').val();
                var jsonString = JSON.stringify(object);
                $.ajax({
                    type: "POST",
                    url: '<?= base_url('auth/check_auth/') ?>',
                    data: {
                        data: jsonString
                    },
                    success: function(response) {
                        var result = $.parseJSON(response);
                        if (result.status == 'success') {
                            $.toast({
                                heading: 'Success',
                                text: 'OTP valid, silahkan set PIN',
                                icon: 'success',
                                showHideTransition: 'slide',
                                hideAfter: 1000,
                                position: 'top-right',
                                afterHidden: function() {
                                    window.location = "<?= base_url() ?>" + result.redirect;
                                }
                            });
                        } else {
                            if (result.otp == 'true') {
                                var message = 'Kode OTP kadaluarsa, silahkan tekan tombol kirim ulang';
                            } else {
                                var message = 'Kode OTP salah, silahkan cek kembali';
                            }
                            $.toast({
                                heading: 'Failed',
                                text: message,
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
            }
        });
        $('#send-again').on('click', '#changeotp', function(e) {
            e.preventDefault();
            var object = {};
            object['action'] = 'changeotp';
            var jsonString = JSON.stringify(object);
            $.ajax({
                type: "POST",
                url: '<?= base_url('auth/check_auth/') ?>',
                data: {
                    data: jsonString
                },
                success: function(response) {
                    var result = $.parseJSON(response);
                    if (result.status == 'success') {
                        $.toast({
                            heading: 'Success',
                            text: 'OTP baru, sudah dikirimkan kembali',
                            icon: 'success',
                            showHideTransition: 'slide',
                            hideAfter: 1000,
                            position: 'top-right',
                            afterHidden: function() {
                                window.location = "<?= base_url('auth/otp') ?>";
                            }
                        });
                    } else {
                        $.toast({
                            heading: 'Failed',
                            text: 'Sistem Gagal, mengirimkan OTP',
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

    function getCodeBoxElement(index) {
        return document.getElementById('codeBox' + index);
    }

    function onKeyUpEvent(index, event) {
        const eventCode = event.which || event.keyCode;
        if (getCodeBoxElement(index).value.length === 1) {
            if (index !== 4) {
                getCodeBoxElement(index + 1).focus();
            } else {
                getCodeBoxElement(index).blur();
                // Submit code
            }
        }
        if (eventCode === 8 && index !== 1) {
            getCodeBoxElement(index - 1).focus();
        }
    }

    function onFocusEvent(index) {
        for (item = 1; item < index; item++) {
            const currentElement = getCodeBoxElement(item);
            if (!currentElement.value) {
                currentElement.focus();
                break;
            }
        }
    }
</script>