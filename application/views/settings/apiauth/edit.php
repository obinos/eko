<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12 pad0">
            <div class="ibox ">
                <div class="ibox-title collapse-link">
                    <h5>Edit Data API</h5>
                    <div class="ibox-tools">
                        <a>
                            <span class="fa arrow"></span>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <form method="post" id="edit_apiauth">
                        <input type="hidden" class="form-control" name="id" value="<?= $api[0]['_id'] ?>">
                        <div class="form-group row"><label class="col-sm-2 col-form-label">Username</label>
                            <div class="col-sm-10"><input type="text" class="form-control" name="user" value="<?= $api[0]['user'] ?>"></div>
                        </div>
                        <div class="form-group row"><label class="col-sm-2 col-form-label">Password</label>
                            <div class="col-sm-10"><input type="text" class="form-control" name="password" value="<?= $api[0]['password'] ?>"></div>
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
        $("#edit_apiauth").validate({
            rules: {
                name: {
                    required: true
                },
                phone_number: {
                    required: true
                }
            },
            messages: {
                name: {
                    required: "kolom harus diisi."
                },
                phone_number: {
                    required: "kolom harus diisi."
                }
            }
        });
    });
</script>