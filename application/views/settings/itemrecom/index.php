<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <?php foreach ($item as $data) { ?>
            <div class="col-xl-3 col-lg-4 col-md-6 pad0">
                <div class="ibox">
                    <div class="ibox-title collapse-link bg-info">
                        <h5>Produk <?= $data['urut'] ?></h5>
                        <div class="ibox-tools">
                            <a>
                                <span class="fa arrow text-dark"></span>
                            </a>
                        </div>
                    </div>
                    <div class="ibox-content">
                        <div class="img-item<?= $data['urut'] ?>">
                            <?php if ($data['id_item']) { ?>
                                <img class="img-fluid mx-auto d-block mb-3" src="<?= str_replace("/photos", getenv("URL_IMG_ITEM"), $data['photo']) ?>">
                            <?php } ?>
                        </div>
                        <div class="input-group">
                            <input type="search" name="product<?= $data['urut'] ?>" class="form-control m-input product<?= $data['urut'] ?>" id="<?= $data['urut'] ?>" autocomplete="off" value="<?= $data['name'] ?>" placeholder="Pilih Produk">
                            <div class="input-group-append del-<?= $data['urut'] ?>">
                                <?php if ($data['id_item']) { ?>
                                    <button id="removeRow" type="button" class="btn btn-danger" data-id="<?= $data['urut'] ?>"><svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                                            <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
                                        </svg></button>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
<?= core_script(); ?>
<?= toast(); ?>
<script src="<?= base_url('assets/'); ?>vendor/typehead/bootstrap3-typeahead.min.js"></script>
<script>
    $(document).ready(function() {
        $(".m-input").each(function() {
            typeahead(this.id);
        });
        $('.input-group-append').on('click', '.btn-danger', function(e) {
            e.preventDefault();
            var id = $(this).attr('data-id');
            Swal({
                title: 'Are You sure?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#45eba5',
                cancelButtonColor: '#fd8664',
                confirmButtonText: 'Delete'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        type: "POST",
                        url: '<?= base_url('settings/update_itemrecom') ?>',
                        data: {
                            urut: id
                        },
                        success: function(response) {
                            var result = $.parseJSON(response);
                            if (result.status == 'success') {
                                $('.product' + result.urut).val('');
                                $('.img-item' + result.urut).html('');
                                $('.del-' + result.urut).html('');
                                $.toast({
                                    heading: 'Success',
                                    text: 'Delete Produk ' + result.urut,
                                    icon: 'success',
                                    showHideTransition: 'slide',
                                    hideAfter: 1500,
                                    position: 'top-right'
                                });
                            } else {
                                $.toast({
                                    heading: 'Failed',
                                    text: 'Delete Produk ' + result.urut,
                                    icon: 'error',
                                    showHideTransition: 'slide',
                                    hideAfter: 1500,
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
    });

    function typeahead(id) {
        $('#' + id).typeahead({
            items: 20,
            source: <?= json_encode($this->aratadb->select(['_id', 'name'])->order_by(['name' => 'ASC'])->where(['merchant' => '606eba1c099777608a38aeda', 'active' => true])->get('items'), true); ?>,
            displayText: function(item) {
                return item.name;
            },
            afterSelect: function(event) {
                $.ajax({
                    type: "POST",
                    url: '<?= base_url('settings/update_itemrecom/') ?>',
                    data: {
                        id_item: event._id,
                        urut: id
                    },
                    success: function(response) {
                        var result = $.parseJSON(response);
                        if (result.status == 'success') {
                            $('.img-item' + result.urut).html('<img class="img-fluid mx-auto d-block mb-3" src="' + result.photo.replace('/photos', '<?= getenv("URL_IMG_ITEM") ?>') + '">');
                            $('.del-' + result.urut).html(`<button id="removeRow" type="button" class="btn btn-danger" data-id="` + result.urut + `"><svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                                <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
                            </svg></button>`);
                            $.toast({
                                heading: 'Success',
                                text: 'Update Produk ' + result.urut,
                                icon: 'success',
                                showHideTransition: 'slide',
                                hideAfter: 1000,
                                position: 'top-right'
                            });
                        } else {
                            $.toast({
                                heading: 'Failed',
                                text: 'Update Produk ' + result.urut,
                                icon: 'error',
                                showHideTransition: 'slide',
                                hideAfter: 1000,
                                position: 'top-right',
                                afterHidden: function() {
                                    $('#submit').prop('disabled', false);
                                }
                            });
                        }
                    }
                });
            }
        });
    }
</script>