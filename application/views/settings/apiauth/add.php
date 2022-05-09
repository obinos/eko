<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12 pad0">
            <div class="ibox ">
                <div class="ibox-title collapse-link">
                    <h5>Add Data API</h5>
                    <div class="ibox-tools">
                        <a>
                            <span class="fa arrow"></span>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <form method="post" id="add_leads_merchant">
                        <div class="form-group row"><label class="col-sm-2 col-form-label">User</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="user">
                                <span class="form-text m-b-none erroruser"></span>
                            </div>
                        </div>
                        <div class="form-group row"><label class="col-sm-2 col-form-label">Password</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" name="password">
                                <span class="form-text m-b-none errorpassword"></span>
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
        $("#add_leads_merchant").validate({
            rules: {
                user: {
                    required: true
                },
                password: {
                    required: true
                }
            },
            messages: {
                user: {
                    required: "kolom harus diisi."
                },
                password: {
                    required: "kolom harus diisi."
                }
            },
            errorPlacement: function(error, element) {
                if (element.attr("name") == "user")
                    error.insertAfter(".erroruser");
                else if (element.attr("name") == "password")
                    error.insertAfter(".errorpassword");
            }
        });
    });
</script>