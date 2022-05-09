<div class="row d-flex align-items-center justify-content-center text-center">
    <div class="col-md-7">
        <img src="<?= base_url('assets/'); ?>img/authentication<?= getenv("APP_BRAND") ?>.svg" class="img-auth img-fluid mx-auto my-auto" width="600px">
    </div>
    <div class="col-md-5">
        <img src="<?= base_url('assets/'); ?>img/aratawidegreen.svg" class="img-fluid" width="120">
        <h2 class="font-bold">Masukkan kode PIN</h2>
        <p>Kode PIN dibutuhkan untuk keamanan nomor HP anda</p>
        <form class="pin mt-4" id="form" method="post">
            <input class="border-otp" id="codeBox1" name="codeBox1" type="password" pattern="[0-9]*" inputmode="numeric" maxlength="1" onkeyup="onKeyUpEvent(1, event)" onfocus="onFocusEvent(1)" />
            <input class="border-otp" id="codeBox2" name="codeBox2" type="password" pattern="[0-9]*" inputmode="numeric" maxlength="1" onkeyup="onKeyUpEvent(2, event)" onfocus="onFocusEvent(2)" />
            <input class="border-otp" id="codeBox3" name="codeBox3" type="password" pattern="[0-9]*" inputmode="numeric" maxlength="1" onkeyup="onKeyUpEvent(3, event)" onfocus="onFocusEvent(3)" />
            <input class="border-otp" id="codeBox4" name="codeBox4" type="password" pattern="[0-9]*" inputmode="numeric" maxlength="1" onkeyup="onKeyUpEvent(4, event)" onfocus="onFocusEvent(4)" />
            <input class="border-otp" id="codeBox5" name="codeBox5" type="password" pattern="[0-9]*" inputmode="numeric" maxlength="1" onkeyup="onKeyUpEvent(5, event)" onfocus="onFocusEvent(5)" />
            <input class="border-otp" id="codeBox6" name="codeBox6" type="password" pattern="[0-9]*" inputmode="numeric" maxlength="1" onkeyup="onKeyUpEvent(6, event)" onfocus="onFocusEvent(6)" />
            <div class="errorOTP"></div>
            <button type="submit" class="btn btn-lg btn-primary block full-width m-t mb-2">Verifikasi</button>
            <p>Lupa PIN anda? <a class="changeotp text-success">Klik disini</a> untuk verifikasi ulang</p>
        </form>
        <p class="m-t text-center"> <small>Copyright &copy; <?= date('Y') . ' ' . $this->lang->line('copyright'); ?></small> </p>
    </div>
</div>
<?= core_script_footer(); ?>
<?= toast(); ?>
<?= validate(); ?>
<script type="text/javascript">
    $("#codeBox1").focus();
    $(document).ready(function() {
        $('.changeotp').on('click', function(e) {
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
                            text: 'Verifikasi OTP, sudah dikirimkan',
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
                            text: 'Sistem Gagal, mengirimkan verifikasi OTP',
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
        $("#form").validate({
            rules: {
                codeBox6: {
                    required: true
                }
            },
            messages: {
                codeBox6: {
                    required: "kolom harus diisi."
                }
            },
            errorPlacement: function(error, element) {
                if (element.attr("name") == "codeBox6")
                    error.insertAfter(".errorOTP");
            },
            submitHandler: function() {
                var object = {};
                object['action'] = 'pin';
                object['pin'] = $('#codeBox1').val() + $('#codeBox2').val() + $('#codeBox3').val() + $('#codeBox4').val() + $('#codeBox5').val() + $('#codeBox6').val();
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
                                text: 'PIN valid',
                                icon: 'success',
                                showHideTransition: 'slide',
                                hideAfter: 1000,
                                position: 'top-right',
                                afterHidden: function() {
                                    window.location = "<?= base_url() ?>" + result.redirect;
                                }
                            });
                        } else {
                            if (result.pin == 'true') {
                                var message = 'Kode PIN salah';
                            } else {
                                var message = 'No HP belum terdaftar';
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
    });

    function getCodeBoxElement(index) {
        return document.getElementById('codeBox' + index);
    }

    function onKeyUpEvent(index, event) {
        const eventCode = event.which || event.keyCode;
        if (getCodeBoxElement(index).value.length === 1) {
            if (index !== 6) {
                getCodeBoxElement(index + 1).focus();
                $('button[type=submit]').prop('disabled', false);
            } else {
                $('button[type=submit]').prop('disabled', true);
                $("#form").submit();
            }
        }
        if (eventCode === 8 && index !== 1) {
            getCodeBoxElement(index - 1).select();
            $('button[type=submit]').prop('disabled', false);
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