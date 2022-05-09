<div class="text-center animated fadeInDown">
    <h1 class="m-0">Page Not Found</h1>
    <img src="<?= base_url('assets/'); ?>img/404<?= getenv("APP_BRAND") ?>.svg" class="img-fluid my-4" width="600px">
    <br>
    <a href="#" onclick="history.back()" class="text-success">&larr; Go Back</a>
    <p class="m-t text-center"> <small>Copyright &copy; <?= date('Y') . ' ' . $this->lang->line('copyright'); ?></small> </p>
</div>