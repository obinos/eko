<div class="footer">
    <div class="text-center">
        Copyright &copy; <?= date('Y') . ' Arata Mart' ?>
    </div>
</div>
</div>
</div>
<!-- Scroll to Top Button-->
<a class="scroll-to-top" href="#page-top">
    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M18 15l-6-6-6 6" />
    </svg>
</a>
<!-- Custom and plugin javascript -->
<script src="<?= base_url('assets/'); ?>vendor/sweetalert/sweetalert2.all.min.js"></script>
<script>
    $(document).ready(function() {
        $('.logout-button').on('click', function(e) {
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
    });
</script>
</body>

</html>