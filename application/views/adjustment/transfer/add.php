<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12 pad0">
            <div class="ibox ">
                <div class="ibox-title d-flex align-items-center justify-content-between">
                    <h5>Input Transfer Condition</h5>
                </div>
                <div class="ibox-content">
                    <!-- <form method="post" id="form"> -->
                    <form action="/action_page.php">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-row d-flex align-items-end">
                                    <div class="form-group mb-1 col-5 col-sm-8">
                                        <label class="ml-1">Nama Produk</label>
                                    </div>
                                    <div class="form-group mb-1 col-2 col-sm-1">
                                        <label class="ml-1">Good</label>
                                    </div>
                                    <div class="form-group mb-1 col-2 col-sm-1">
                                        <label class="ml-1">Damage</label>
                                    </div>
                                    <div class="form-group mb-1 col-3 col-sm-2">
                                        <label class="ml-1">Reject</label>
                                    </div>
                                </div>
                                <div id="inputFormRow">
                                    <div class="form-row" id="first_typeahead">
                                        <div class="form-group col-5 col-sm-8">
                                            <input type="search" name="name[]" class="form-control m-input typeahead" id="name" autocomplete="off">
                                        </div>
                                        <div class="form-group col-2 col-sm-1">
                                            <input type="number" name="good[]" class="form-control m-input text-right good" autocomplete="off">
                                        </div>
                                        <div class="form-group col-2 col-sm-1">
                                            <input type="number" name="damage[]" class="form-control m-input text-right damage" autocomplete="off">
                                        </div>
                                        <div class="form-group col-3 col-sm-2">
                                            <div class="input-group">
                                                <input type="number" name="reject[]" class="form-control m-input reject text-right" autocomplete="off">
                                                <div class="input-group-append">
                                                    <button id="removeRow" type="button" class="btn btn-danger"><svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                                            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                                                            <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
                                                        </svg></button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="newRow"></div>
                            </div>
                        </div>
                        <div class="hr-line-dashed"></div>
                        <div class="is-floating-label mb-3">
                            <label class="form-label">Note</label>
                            <textarea class="form-control" rows="2" name="notes"></textarea>
                        </div>
                    </form>
                    <button class="btn btn-warning btn-block" id="submit">Submit</button>
                </div>
            </div>
        </div>
    </div>
</div>
<?= core_script(); ?>
<?= toast(); ?>
<script src="<?= base_url('assets/'); ?>vendor/typehead/bootstrap3-typeahead.min.js"></script>
<script>
    $(document).ready(function() {
        $('.is-floating-label input, .is-floating-label textarea').on('focus blur', function(e) {
            $(this).parents('.is-floating-label').toggleClass('is-focused', (e.type === 'focus' || this.value.length > 0));
        }).trigger('blur');
        $(document).on('keypress', '.good,.damage,.reject', function(e) {
            if (e.which == 13) {
                e.preventDefault();
                var html = '';
                var id = new Date().getTime();
                html += `<div id="inputFormRow">
                        <div class="form-row" id="` + id + `" >
                            <div class="form-group col-5 col-sm-8">
                                <input type="search" name="name[]" class="form-control m-input typeahead" id="name" autocomplete="off">
                            </div>
                            <div class="form-group col-2 col-sm-1">
                                <input type="number" name="good[]" class="form-control m-input text-right good" autocomplete="off">
                            </div>
                            <div class="form-group col-2 col-sm-1">
                                <input type="number" name="damage[]" class="form-control m-input text-right damage" autocomplete="off">
                            </div>
                            <div class="form-group col-3 col-sm-2">
                                <div class="input-group">
                                    <input type="number" name="reject[]" class="form-control m-input reject text-right" autocomplete="off">
                                    <div class="input-group-append">
                                        <button id="removeRow" type="button" class="btn btn-danger"><svg width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                                                <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
                                            </svg></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>`;
                $('#newRow').append(html);
                typeahead(id);
                math(id);
                $('#' + id + ' input.typeahead').focus()
            }
        });
        $(document).on('click', '#removeRow', function() {
            var id = $(this).attr('data-id');
            var inputFormRow = $("div[id*='inputFormRow']").length;
            if (inputFormRow == 1) {
                $('.typeahead[data-id=' + id + ']').val('');
                $('.good[data-id=' + id + ']').val('').prop('disabled', false);
                $('.damage[data-id=' + id + ']').val('').prop('disabled', false);
                $('.reject[data-id=' + id + ']').val('').prop('disabled', false);
            } else {
                $(this).closest('#inputFormRow').remove();
            }
        });
        typeahead('first_typeahead');
        math('first_typeahead');
        $('#submit').on('click', function(e) {
            $('#submit').prop('disabled', true);
            e.preventDefault();
            Swal({
                title: 'Are You sure?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#45eba5',
                cancelButtonColor: '#fd8664',
                confirmButtonText: 'Submit'
            }).then((result) => {
                if (result.value) {
                    var object = {};
                    var array = [];
                    $('input.typeahead').each(function() {
                        var item = {};
                        var id = $(this).attr('data-id');
                        item['_id'] = id;
                        if ($('.good[data-id=' + id + ']').is(':disabled')) {
                            item['damage'] = $('.damage[data-id=' + id + ']').val();
                            item['reject'] = $('.reject[data-id=' + id + ']').val();
                            item['good'] = (Number(item['damage']) + Number(item['reject'])) * -1;
                        } else if ($('.damage[data-id=' + id + ']').is(':disabled')) {
                            item['good'] = $('.good[data-id=' + id + ']').val();
                            item['reject'] = $('.reject[data-id=' + id + ']').val();
                            item['damage'] = (Number(item['good']) + Number(item['reject'])) * -1;
                        } else if ($('.reject[data-id=' + id + ']').is(':disabled')) {
                            item['good'] = $('.good[data-id=' + id + ']').val();
                            item['damage'] = $('.damage[data-id=' + id + ']').val();
                            item['reject'] = (Number(item['damage']) + Number(item['good'])) * -1;
                        }
                        array.push(item);
                    });
                    object['item'] = array;
                    object['notes'] = $('textarea[name=notes').val();
                    var jsonString = JSON.stringify(object);
                    $.ajax({
                        type: "POST",
                        url: '<?= base_url('adjustment/update_transfer') ?>',
                        data: {
                            data: jsonString
                        },
                        success: function(response) {
                            var result = $.parseJSON(response);
                            if (result.status == 'success') {
                                $.toast({
                                    heading: 'Success',
                                    text: 'Add Transfer Condition',
                                    icon: 'success',
                                    showHideTransition: 'slide',
                                    hideAfter: 1500,
                                    position: 'top-right',
                                    afterHidden: function() {
                                        window.location = "<?= base_url('adjustment/transfer') ?>";
                                    }
                                });
                            } else {
                                $.toast({
                                    heading: 'Failed',
                                    text: result.text,
                                    icon: 'error',
                                    showHideTransition: 'slide',
                                    hideAfter: 1500,
                                    position: 'top-right',
                                    afterHidden: function() {
                                        $('#submit').prop('disabled', false);
                                    }
                                });
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.log(textStatus, errorThrown);
                        }
                    });
                } else {
                    $('#submit').prop('disabled', false);
                }
            });
        });
    });

    function math(id) {
        $('#' + id + ' input.good,#' + id + ' input.damage,#' + id + ' input.reject').on('change', function() {
            var id = $(this).attr('data-id');
            $('.good[data-id=' + id + ']').removeClass('is-invalid');
            $('.damage[data-id=' + id + ']').removeClass('is-invalid');
            $('.reject[data-id=' + id + ']').removeClass('is-invalid');
            var good = $('.good[data-id=' + id + ']').val();
            var damage = $('.damage[data-id=' + id + ']').val();
            var reject = $('.reject[data-id=' + id + ']').val();
            if ($('.good[data-id=' + id + ']').is(':disabled')) {
                var selisih = Number(good) - (Number(damage) + Number(reject));
            } else if ($('.damage[data-id=' + id + ']').is(':disabled')) {
                var selisih = Number(damage) - (Number(good) + Number(reject));
            } else if ($('.reject[data-id=' + id + ']').is(':disabled')) {
                var selisih = Number(reject) - (Number(good) + Number(damage));
            }
            if (selisih < 0) {
                $(this).addClass('is-invalid');
            }
        });
    }

    function typeahead(id) {
        $('#' + id + ' input.typeahead').typeahead({
            items: 20,
            source: function(query, process) {
                jQuery.ajax({
                    url: '<?= base_url('adjustment/data_transfer/') ?>',
                    type: 'GET',
                    dataType: 'json',
                    success: function(json) {
                        process(json);
                    }
                });
            },
            displayText: function(item) {
                return item.active + ' ' + item.name + ' (' + item.condition + ': ' + item.stock + ')';
            },
            afterSelect: function(event) {
                $('#' + id + ' input.typeahead').attr('data-id', event.id_item);
                $('#' + id + ' input.good').val('').attr('data-id', event.id_item).prop('disabled', false);
                $('#' + id + ' input.damage').val('').attr('data-id', event.id_item).prop('disabled', false);
                $('#' + id + ' input.reject').val('').attr('data-id', event.id_item).prop('disabled', false);
                $('#' + id + ' button#removeRow').attr('data-id', event.id_item);
                $('#' + id + ' input.' + event.condition).val(event.stock).prop('disabled', true);
            }
        });
    }
</script>