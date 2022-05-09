<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12 pad0">
            <div class="ibox ">
                <div class="ibox-title d-flex align-items-center justify-content-between">
                    <h5>Data User Arata</h5>
                    <div class="btn-group">
                        <button data-toggle="dropdown" class="btn btn-primary btn-sm dropdown-toggle">
                            <svg width="16px" height="16px" viewBox="0 0 16 16" fill="currentColor">
                                <path fill-rule="evenodd" d="M2.5 11.5A.5.5 0 0 1 3 11h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4A.5.5 0 0 1 3 7h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4A.5.5 0 0 1 3 3h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z" />
                            </svg> Menu</button>
                        <ul class="dropdown-menu animated fadeInRight m-t-xs">
                            <li><a class="dropdown-item" href="#" data-toggle='modal' data-target='#uploadData'> <svg class="mr-2" width="16px" height="16px" viewBox="0 0 16 16" fill="currentColor">
                                        <path fill-rule="evenodd" d="M.5 8a.5.5 0 0 1 .5.5V12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V8.5a.5.5 0 0 1 1 0V12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V8.5A.5.5 0 0 1 .5 8zM5 4.854a.5.5 0 0 0 .707 0L8 2.56l2.293 2.293A.5.5 0 1 0 11 4.146L8.354 1.5a.5.5 0 0 0-.708 0L5 4.146a.5.5 0 0 0 0 .708z" />
                                        <path fill-rule="evenodd" d="M8 2a.5.5 0 0 1 .5.5v8a.5.5 0 0 1-1 0v-8A.5.5 0 0 1 8 2z" />
                                    </svg> Upload CSV</a></li>
                        </ul>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table id="datatable" class="table table-striped table-sm display" width="100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>No HP</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Upload Modal-->
<div class="modal fade" id="uploadData" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h4 class="modal-title" id="exampleModalLabel">Upload Data</h4>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body bodyUploadModal">
                <a class="btn btn-block btn-success mb-4" href="<?= base_url('assets/'); ?>download/uploadDataLeadsMerchant.csv">Download Template CSV</a>
                <form class="form-horizontal" action="<?= base_url('arata/upload_csv'); ?>" method="post" name="frmCSVImport" id="frmCSVImport" enctype="multipart/form-data">
                    <div class="custom-file mb-4">
                        <input type="file" class="custom-file-input" name="file" id="file" accept=".csv" required>
                        <label class="custom-file-label">Choose file (.csv)</label>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="submit" name="import" class="btn btn-primary">Upload</button>
                        <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= core_script(); ?>
<?= datatables(); ?>
<script>
    $('.custom-file-input').on('change', function() {
        let fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass("selected").html(fileName);
    });
    $('#datatable').DataTable({
        "pageLength": 20,
        "dom": '<"html5buttons">lTfgitp',
        "processing": true,
        "serverSide": true,
        "order": [
            [3, 'desc']
        ],
        "aLengthMenu": [
            [5, 10, 20, 50, 100],
            [5, 10, 20, 50, 100]
        ],
        "ajax": {
            "url": "<?= base_url('arata/get_data/arata'); ?>",
            "type": "POST"
        },
        "columns": [{
            "data": null,
            "sortable": false,
            render: function(data, type, row, meta) {
                return meta.row + meta.settings._iDisplayStart + 1;
            }
        }, {
            "data": "name"
        }, {
            "data": "phone_number"
        }, {
            "data": "created_at",
            render: function(data, type, row, meta) {
                var created_date = new Date(parseInt(data.$date.$numberLong));
                var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                return created_date.getDate() + ' ' + months[created_date.getMonth()] + ' ' + parseInt(created_date.getFullYear() - 2000).toString();
            }
        }]
    });
</script>