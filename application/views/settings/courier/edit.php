<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12 pad0">
            <div class="ibox ">
                <div class="ibox-title collapse-link">
                    <h5>Edit Kurir</h5>
                    <div class="ibox-tools">
                        <a>
                            <span class="fa arrow"></span>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <form method="post" id="edit_courier">
                        <input type="hidden" class="form-control" name="id" value="<?= $courier[0]['_id'] ?>">
                        <div class="form-group row"><label class="col-sm-2 col-form-label">Urutan</label>
                            <div class="col-sm-10"><input type="text" class="form-control" name="order" value="<?= $courier[0]['order'] ?>"></div>
                        </div>
                        <div class="form-group row"><label class="col-sm-2 col-form-label">Nama Lengkap</label>
                            <div class="col-sm-10"><input type="text" class="form-control" name="name" value="<?= $courier[0]['name'] ?>"></div>
                        </div>
                        <div class="form-group row"><label class="col-sm-2 col-form-label">No WA</label>
                            <div class="col-sm-10"><input type="text" class="form-control" name="phone" value="<?= nohp($courier[0]['phone']) ?>"></div>
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
<script src="<?= base_url('assets/'); ?>vendor/validate/jquery.validate.min.js"></script>
<script>
    $(document).ready(function() {
        $("#edit_courier").validate({
            rules: {
                order: {
                    required: true,
                    number: true
                },
                name: {
                    required: true
                },
                phone: {
                    required: true,
                    number: true
                }
            },
            messages: {
                order: {
                    required: "kolom harus diisi.",
                    number: "masukkan angka saja."
                },
                name: {
                    required: "kolom harus diisi."
                },
                phone: {
                    required: "kolom harus diisi.",
                    number: "masukkan angka saja."
                }
            }
        });
    });
</script>