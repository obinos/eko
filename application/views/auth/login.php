<div class="row d-flex align-items-center justify-content-center text-center">
    <div class="col-md-7">
        <img src="<?= base_url('assets/'); ?>img/login<?= getenv("APP_BRAND") ?>.svg" class="img-auth img-fluid mx-auto my-auto" width="1600px">
    </div>
    <div class="col-md-5">
        <img src="<?= base_url('assets/'); ?>img/aratawidegreen.svg" class="img-fluid" width="120">
        <h2 class="font-bold">Login</h2>
        <p> untuk masuk ke Dashboard Merchant</p>
        <form class="auth mt-5" id="form" method="post">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="bg-light input-group-addon"><svg width="16px" height="16px" viewBox="0 0 16 16" fill="currentColor">
                            <path fill-rule="evenodd" d="M11 1H5a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1zM5 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H5z" />
                            <path fill-rule="evenodd" d="M8 14a1 1 0 1 0 0-2 1 1 0 0 0 0 2z" />
                        </svg>
                    </span>
                </div>
                <input type="text" class="form-control" id="phone_number" name="phone_number" placeholder="Masukkan no whatsapp...">
            </div>
            <span class="errorPhone_number"></span>
            <button type="submit" class="btn btn-lg btn-primary block full-width m-t mb-4">Login</button>
        </form>
        <p class="m-t text-center"> <small>Copyright &copy; <?= date('Y') . ' ' . $this->lang->line('copyright'); ?></small> </p>
    </div>
</div>

<?= core_script_footer(); ?>
<?= toast(); ?>
<?= validate(); ?>
<script type="text/javascript">
    $(document).ready(function() {
        $("#form").validate({
            rules: {
                phone_number: {
                    required: true,
                    number: true
                }
            },
            messages: {
                phone_number: {
                    required: "kolom harus diisi.",
                    number: "masukkan angka saja."
                }
            },
            errorPlacement: function(error, element) {
                if (element.attr("name") == "phone_number")
                    error.insertAfter(".errorPhone_number");
            },
            submitHandler: function() {
                var object = {};
                object['action'] = 'login';
                object['phone_number'] = $('#phone_number').val();
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
                            if (result.pin == 'true') {
                                var message = 'No hp terdaftar, silahkan masukkan PIN';
                            } else {
                                var message = 'OTP terkirim, silahkan cek whatsapp';
                            }
                            $.toast({
                                heading: 'Success',
                                text: message,
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
                                var message = 'Gagal mengirim OTP ke nomer ' + $('#phone_number').val();
                            } else {
                                var message = 'No ' + $('#phone_number').val() + ' belum terdaftar';
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
</script>