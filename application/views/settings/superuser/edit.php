<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12 pad0">
            <div class="ibox ">
                <div class="ibox-title collapse-link">
                    <h5>Edit Super User</h5>
                    <div class="ibox-tools">
                        <a>
                            <span class="fa arrow"></span>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <form method="post" id="edit_user">
                        <input type="hidden" class="form-control" name="id" value="<?= $user[0]['_id'] ?>">
                        <div class="form-group row"><label class="col-sm-2 col-form-label">Nama Lengkap</label>
                            <div class="col-sm-10"><input type="text" class="form-control" name="name" value="<?= $user[0]['name'] ?>"></div>
                        </div>
                        <div class="form-group row"><label class="col-sm-2 col-form-label">Role</label>
                            <div class="col-sm-10">
                                <select name="role" class="form-control" id="role">
                                    <?php foreach ($role as $data) : ?>
                                        <option value="<?= $data; ?>" <?php if ($data == $user[0]['role']) : ?> selected<?php endif; ?>><?= $data; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row"><label class="col-sm-2 col-form-label">No WA</label>
                            <div class="col-sm-10"><input type="text" class="form-control" name="phone_number" value="<?= $user[0]['phone_number'] ?>"></div>
                        </div>
                        <div class="form-group row"><label class="col-sm-2 col-form-label">Email</label>
                            <div class="col-sm-10"><input type="text" class="form-control" name="email" value="<?= $user[0]['email'] ?>"></div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-4 col-sm-offset-2 mt-2">
                                <button class="btn btn-primary btn-sm" type="submit" name="tambah">Submit</button>
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
        $("#edit_user").validate({
            rules: {
                name: {
                    required: true
                },
                phone_number: {
                    required: true,
                    number: true,
                    remote: {
                        url: "<?= base_url('settings/check_superuser/phone_number/' . $user[0]['_id']); ?>",
                        type: "post"
                    }
                },
                email: {
                    emailfull: true,
                    remote: {
                        url: "<?= base_url('settings/check_superuser/email/' . $user[0]['_id']); ?>",
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
            }
        });
        $("#role").select2({
            theme: 'bootstrap4',
            language: 'id'
        });
    });
</script>