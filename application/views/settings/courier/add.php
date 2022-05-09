<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12 pad0">
            <div class="ibox ">
                <div class="ibox-title collapse-link">
                    <h5>Add Kurir</h5>
                    <div class="ibox-tools">
                        <a>
                            <span class="fa arrow"></span>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <form method="post" id="add_courier">
                        <div class="form-group row"><label class="col-sm-2 col-form-label">ID</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="id">
                                <span class="form-text m-b-none errorid"></span>
                            </div>
                        </div>
                        <div class="form-group row"><label class="col-sm-2 col-form-label">Urutan</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="order">
                                <span class="form-text m-b-none errororder"></span>
                            </div>
                        </div>
                        <div class="form-group row"><label class="col-sm-2 col-form-label">Nama</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="name">
                                <span class="form-text m-b-none errorname"></span>
                            </div>
                        </div>
                        <div class="form-group row"><label class="col-sm-2 col-form-label">No WA</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="phone">
                                <span class="form-text m-b-none errorPhone"></span>
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
<script src="<?= base_url('assets/'); ?>vendor/validate/jquery.validate.min.js"></script>
<script>
    $(document).ready(function() {
        $("#add_courier").validate({
            rules: {
                id: {
                    required: true,
                    minlength: 2,
                    maxlength: 4
                },
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
                id: {
                    required: "kolom harus diisi.",
                    minlength: "minimal 2 karakter.",
                    maxlength: "maksimal 4 karakter."
                },
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