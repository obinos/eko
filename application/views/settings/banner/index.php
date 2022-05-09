<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-4 pad0">
            <div class="ibox ">
                <div class="ibox-title collapse-link bg-light">
                    <h5>Banner 1</h5>
                    <div class="ibox-tools">
                        <a>
                            <span class="fa arrow"></span>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <?php if ($banner1) {
                        if (getimagesize(getenv("URL_IMG") . $banner1) !== false) { ?>
                            <img class="img-fluid mx-auto d-block" src="<?= getenv("URL_IMG") . $banner1; ?>">
                    <?php }
                    } ?>
                    <?php echo form_open_multipart('settings/upload_banner/1') ?>
                    <div class="custom-file mt-3">
                        <input id="logo" type="file" class="custom-file-input" name="userfile">
                        <label for="logo" class="custom-file-label">Choose file...</label>
                    </div>
                    <div class="mt-2">
                        <button class="btn btn-warning btn-sm shadow-sm" type="submit" name="submit">
                            <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z" />
                                <path d="M7.646 1.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 2.707V11.5a.5.5 0 0 1-1 0V2.707L5.354 4.854a.5.5 0 1 1-.708-.708l3-3z" />
                            </svg> Upload</button>
                        <a class="btn btn-danger btn-sm shadow-sm delete-button" href="<?= base_url('settings/delete_banner/') . base64_encode($banner1); ?>">
                            <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                                <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
                            </svg> Delete</a>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 pad0">
            <div class="ibox ">
                <div class="ibox-title collapse-link bg-light">
                    <h5>Banner 2</h5>
                    <div class="ibox-tools">
                        <a>
                            <span class="fa arrow"></span>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <?php if ($banner2) {
                        if (getimagesize(getenv("URL_IMG") . $banner2) !== false) { ?>
                            <img class="img-fluid mx-auto d-block" src="<?= getenv("URL_IMG") . $banner2; ?>">
                    <?php }
                    } ?>
                    <?php echo form_open_multipart('settings/upload_banner/2') ?>
                    <div class="custom-file mt-3">
                        <input id="logo" type="file" class="custom-file-input" name="userfile">
                        <label for="logo" class="custom-file-label">Choose file...</label>
                    </div>
                    <div class="mt-2">
                        <button class="btn btn-warning btn-sm shadow-sm" type="submit" name="submit">
                            <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z" />
                                <path d="M7.646 1.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 2.707V11.5a.5.5 0 0 1-1 0V2.707L5.354 4.854a.5.5 0 1 1-.708-.708l3-3z" />
                            </svg> Upload</button>
                        <a class="btn btn-danger btn-sm shadow-sm delete-button" href="<?= base_url('settings/delete_banner/') . base64_encode($banner2); ?>">
                            <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                                <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
                            </svg> Delete</a>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 pad0">
            <div class="ibox ">
                <div class="ibox-title collapse-link bg-light">
                    <h5>Banner 3</h5>
                    <div class="ibox-tools">
                        <a>
                            <span class="fa arrow"></span>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <?php if ($banner3) {
                        if (getimagesize(getenv("URL_IMG") . $banner3) !== false) { ?>
                            <img class="img-fluid mx-auto d-block" src="<?= getenv("URL_IMG") . $banner3; ?>">
                    <?php }
                    } ?>
                    <?php echo form_open_multipart('settings/upload_banner/3') ?>
                    <div class="custom-file mt-3">
                        <input id="logo" type="file" class="custom-file-input" name="userfile">
                        <label for="logo" class="custom-file-label">Choose file...</label>
                    </div>
                    <div class="mt-2">
                        <button class="btn btn-warning btn-sm shadow-sm" type="submit" name="submit">
                            <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z" />
                                <path d="M7.646 1.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 2.707V11.5a.5.5 0 0 1-1 0V2.707L5.354 4.854a.5.5 0 1 1-.708-.708l3-3z" />
                            </svg> Upload</button>
                        <a class="btn btn-danger btn-sm shadow-sm delete-button" href="<?= base_url('settings/delete_banner/') . base64_encode($banner3); ?>">
                            <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                                <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
                            </svg> Delete</a>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 pad0">
            <div class="ibox ">
                <div class="ibox-title collapse-link bg-light">
                    <h5>Banner 4</h5>
                    <div class="ibox-tools">
                        <a>
                            <span class="fa arrow"></span>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <?php if ($banner4) {
                        if (getimagesize(getenv("URL_IMG") . $banner4) !== false) { ?>
                            <img class="img-fluid mx-auto d-block" src="<?= getenv("URL_IMG") . $banner4; ?>">
                    <?php }
                    } ?>
                    <?php echo form_open_multipart('settings/upload_banner/4') ?>
                    <div class="custom-file mt-3">
                        <input id="logo" type="file" class="custom-file-input" name="userfile">
                        <label for="logo" class="custom-file-label">Choose file...</label>
                    </div>
                    <div class="mt-2">
                        <button class="btn btn-warning btn-sm shadow-sm" type="submit" name="submit">
                            <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z" />
                                <path d="M7.646 1.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 2.707V11.5a.5.5 0 0 1-1 0V2.707L5.354 4.854a.5.5 0 1 1-.708-.708l3-3z" />
                            </svg> Upload</button>
                        <a class="btn btn-danger btn-sm shadow-sm delete-button" href="<?= base_url('settings/delete_banner/') . base64_encode($banner4); ?>">
                            <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                                <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
                            </svg> Delete</a>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 pad0">
            <div class="ibox ">
                <div class="ibox-title collapse-link bg-light">
                    <h5>Banner 5</h5>
                    <div class="ibox-tools">
                        <a>
                            <span class="fa arrow"></span>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <?php if ($banner5) {
                        if (getimagesize(getenv("URL_IMG") . $banner5) !== false) { ?>
                            <img class="img-fluid mx-auto d-block" src="<?= getenv("URL_IMG") . $banner5; ?>">
                    <?php }
                    } ?>
                    <?php echo form_open_multipart('settings/upload_banner/5') ?>
                    <div class="custom-file mt-3">
                        <input id="logo" type="file" class="custom-file-input" name="userfile">
                        <label for="logo" class="custom-file-label">Choose file...</label>
                    </div>
                    <div class="mt-2">
                        <button class="btn btn-warning btn-sm shadow-sm" type="submit" name="submit">
                            <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z" />
                                <path d="M7.646 1.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 2.707V11.5a.5.5 0 0 1-1 0V2.707L5.354 4.854a.5.5 0 1 1-.708-.708l3-3z" />
                            </svg> Upload</button>
                        <a class="btn btn-danger btn-sm shadow-sm delete-button" href="<?= base_url('settings/delete_banner/') . base64_encode($banner5); ?>">
                            <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                                <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
                            </svg> Delete</a>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 pad0">
            <div class="ibox ">
                <div class="ibox-title collapse-link bg-light">
                    <h5>Banner 6</h5>
                    <div class="ibox-tools">
                        <a>
                            <span class="fa arrow"></span>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <?php if ($banner6) {
                        if (getimagesize(getenv("URL_IMG") . $banner6) !== false) { ?>
                            <img class="img-fluid mx-auto d-block" src="<?= getenv("URL_IMG") . $banner6; ?>">
                    <?php }
                    } ?>
                    <?php echo form_open_multipart('settings/upload_banner/6') ?>
                    <div class="custom-file mt-3">
                        <input id="logo" type="file" class="custom-file-input" name="userfile">
                        <label for="logo" class="custom-file-label">Choose file...</label>
                    </div>
                    <div class="mt-2">
                        <button class="btn btn-warning btn-sm shadow-sm" type="submit" name="submit">
                            <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z" />
                                <path d="M7.646 1.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 2.707V11.5a.5.5 0 0 1-1 0V2.707L5.354 4.854a.5.5 0 1 1-.708-.708l3-3z" />
                            </svg> Upload</button>
                        <a class="btn btn-danger btn-sm shadow-sm delete-button" href="<?= base_url('settings/delete_banner/') . base64_encode($banner6); ?>">
                            <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                                <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
                            </svg> Delete</a>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 pad0">
            <div class="ibox ">
                <div class="ibox-title collapse-link bg-light">
                    <h5>Banner 7</h5>
                    <div class="ibox-tools">
                        <a>
                            <span class="fa arrow"></span>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <?php if ($banner7) {
                        if (getimagesize(getenv("URL_IMG") . $banner7) !== false) { ?>
                            <img class="img-fluid mx-auto d-block" src="<?= getenv("URL_IMG") . $banner7; ?>">
                    <?php }
                    } ?>
                    <?php echo form_open_multipart('settings/upload_banner/7') ?>
                    <div class="custom-file mt-3">
                        <input id="logo" type="file" class="custom-file-input" name="userfile">
                        <label for="logo" class="custom-file-label">Choose file...</label>
                    </div>
                    <div class="mt-2">
                        <button class="btn btn-warning btn-sm shadow-sm" type="submit" name="submit">
                            <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z" />
                                <path d="M7.646 1.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 2.707V11.5a.5.5 0 0 1-1 0V2.707L5.354 4.854a.5.5 0 1 1-.708-.708l3-3z" />
                            </svg> Upload</button>
                        <a class="btn btn-danger btn-sm shadow-sm delete-button" href="<?= base_url('settings/delete_banner/') . base64_encode($banner7); ?>">
                            <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                                <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
                            </svg> Delete</a>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 pad0">
            <div class="ibox ">
                <div class="ibox-title collapse-link bg-light">
                    <h5>Banner 8</h5>
                    <div class="ibox-tools">
                        <a>
                            <span class="fa arrow"></span>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <?php if ($banner8) {
                        if (getimagesize(getenv("URL_IMG") . $banner8) !== false) { ?>
                            <img class="img-fluid mx-auto d-block" src="<?= getenv("URL_IMG") . $banner8; ?>">
                    <?php }
                    } ?>
                    <?php echo form_open_multipart('settings/upload_banner/8') ?>
                    <div class="custom-file mt-3">
                        <input id="logo" type="file" class="custom-file-input" name="userfile">
                        <label for="logo" class="custom-file-label">Choose file...</label>
                    </div>
                    <div class="mt-2">
                        <button class="btn btn-warning btn-sm shadow-sm" type="submit" name="submit">
                            <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z" />
                                <path d="M7.646 1.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 2.707V11.5a.5.5 0 0 1-1 0V2.707L5.354 4.854a.5.5 0 1 1-.708-.708l3-3z" />
                            </svg> Upload</button>
                        <a class="btn btn-danger btn-sm shadow-sm delete-button" href="<?= base_url('settings/delete_banner/') . base64_encode($banner8); ?>">
                            <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                                <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
                            </svg> Delete</a>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 pad0">
            <div class="ibox ">
                <div class="ibox-title collapse-link bg-light">
                    <h5>Banner 9</h5>
                    <div class="ibox-tools">
                        <a>
                            <span class="fa arrow"></span>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <?php if ($banner9) {
                        if (getimagesize(getenv("URL_IMG") . $banner9) !== false) { ?>
                            <img class="img-fluid mx-auto d-block" src="<?= getenv("URL_IMG") . $banner9; ?>">
                    <?php }
                    } ?>
                    <?php echo form_open_multipart('settings/upload_banner/9') ?>
                    <div class="custom-file mt-3">
                        <input id="logo" type="file" class="custom-file-input" name="userfile">
                        <label for="logo" class="custom-file-label">Choose file...</label>
                    </div>
                    <div class="mt-2">
                        <button class="btn btn-warning btn-sm shadow-sm" type="submit" name="submit">
                            <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z" />
                                <path d="M7.646 1.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 2.707V11.5a.5.5 0 0 1-1 0V2.707L5.354 4.854a.5.5 0 1 1-.708-.708l3-3z" />
                            </svg> Upload</button>
                        <a class="btn btn-danger btn-sm shadow-sm delete-button" href="<?= base_url('settings/delete_banner/') . base64_encode($banner9); ?>">
                            <svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                                <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
                            </svg> Delete</a>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= core_script(); ?>
<script>
    $(document).ready(function() {
        $('.custom-file-input').on('change', function() {
            let fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').addClass("selected").html(fileName);
        });
    });
</script>