<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12 pad0">
            <div class="ibox ">
                <div class="ibox-title collapse-link">
                    <h5>Add Super User</h5>
                    <div class="ibox-tools">
                        <a>
                            <span class="fa arrow"></span>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <form method="post" id="add_user">
                        <div class="form-group row"><label class="col-sm-2 col-form-label">Nama Lengkap</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="name">
                                <span class="form-text m-b-none errorname"></span>
                            </div>
                        </div>
                        <div class="form-group row"><label class="col-sm-2 col-form-label">Role</label>
                            <div class="col-sm-10">
                                <select name="role" class="form-control" id="role">
                                    <?php foreach ($role as $data) : ?>
                                        <option value="<?= $data; ?>"><?= $data; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row"><label class="col-sm-2 col-form-label">No WA</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="phone_number">
                                <span class="form-text m-b-none errorPhone_number"></span>
                            </div>
                        </div>
                        <div class="form-group row"><label class="col-sm-2 col-form-label">Email</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="email">
                                <span class="form-text m-b-none erroremail"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-4 col-sm-offset-2 mt-2">
                                <button class="btn btn-primary btn-sm" type="submit">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= core_script(); ?>
<?= select2(); ?>
<script src="<?= base_url('assets/'); ?>vendor/validate/jquery.validate.min.js"></script>
<script>
    $(document).ready(function() {
        $("#add_user").validate({
            rules: {
                name: {
                    required: true
                },
                phone_number: {
                    required: true,
                    number: true,
                    remote: {
                        url: "<?= base_url('user/check_superuser/phone_number/add'); ?>",
                        type: "post"
                    }
                },
                email: {
                    emailfull: true,
                    remote: {
                        url: "<?= base_url('user/check_superuser/email/add'); ?>",
                        type: "post"
                    }
                }
            },
            messages: {
                name: {
                    required: "kolom harus diisi."
                },
                phone_number: {
                    required: "kolom harus diisi.",
                    number: "masukkan angka saja.",
                    remote: "no hp sudah terdaftar."
                },
                email: {
                    emailfull: "masukkan email yg valid.",
                    remote: "email sudah terdaftar."
                }
            },
            errorPlacement: function(error, element) {
                if (element.attr("name") == "name")
                    error.insertAfter(".errorname");
                else if (element.attr("name") == "phone_number")
                    error.insertAfter(".errorPhone_number");
                else if (element.attr("name") == "email")
                    error.insertAfter(".erroremail");
            }
        });
        $("#role").select2({
            theme: 'bootstrap4',
            language: 'id'
        });
    });
</script>