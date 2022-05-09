const title = $('.flash-data').data('title');
const text = $('.flash-data').data('text');
const type = $('.flash-data').data('type');
const show = $('.flash-data').data('show');
const link = $('.flash-data').data('link');

if (title) {
    if (show) {
        Swal({
            title: title,
            text: text,
            type: type,
            confirmButtonColor: '#45eba5',
        });
    } else if (link) {
        Swal({
            title: title,
            text: text,
            type: type,
            showCloseButton: true,
            showCancelButton: false,
            confirmButtonColor: '#45eba5',
            confirmButtonText: 'Pilih Paket'
        }).then((result) => {
            if (result.value) {
                window.location = link;
            }
        });
    } else {
        Swal({
            title: title,
            text: text,
            type: type,
            showConfirmButton: false,
            timer: 1000
        })
    }
}

$('.delete-button').on('click', function (e) {
    e.preventDefault();
    const href = $(this).attr('href');
    Swal({
        title: 'Are You sure?',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#45eba5',
        cancelButtonColor: '#fd8664',
        confirmButtonText: 'Delete'
    }).then((result) => {
        if (result.value) {
            document.location.href = href;
        }
    })

});
$('.logout-button').on('click', function (e) {
    e.preventDefault();
    const href = $(this).attr('href');
    Swal({
        title: 'Ready to Leave?',
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#45eba5',
        cancelButtonColor: '#fd8664',
        confirmButtonText: 'Logout'
    }).then((result) => {
        if (result.value) {
            document.location.href = href;
        }
    })

});