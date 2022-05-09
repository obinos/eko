<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12 pad0">
            <div class="ibox ">
                <div class="ibox-title d-flex align-items-center justify-content-between">
                    <h5>Data Super User</h5>
                    <div class="btn-group">
                        <button data-toggle="dropdown" class="btn btn-primary btn-sm dropdown-toggle">
                            <svg width="16px" height="16px" viewBox="0 0 16 16" fill="currentColor">
                                <path fill-rule="evenodd" d="M2.5 11.5A.5.5 0 0 1 3 11h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4A.5.5 0 0 1 3 7h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4A.5.5 0 0 1 3 3h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z" />
                            </svg> Menu</button>
                        <ul class="dropdown-menu animated fadeInRight m-t-xs">
                            <li><a class='dropdown-item' href='<?= base_url(); ?>settings/add_superuser/'>
                                    <svg class="mr-2" width="16px" height="16px" viewBox="0 0 16 16" fill="currentColor">
                                        <path fill-rule="evenodd" d="M11 14s1 0 1-1-1-4-6-4-6 3-6 4 1 1 1 1h10zm-9.995-.944v-.002.002zM1.022 13h9.956a.274.274 0 0 0 .014-.002l.008-.002c-.001-.246-.154-.986-.832-1.664C9.516 10.68 8.289 10 6 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664a1.05 1.05 0 0 0 .022.004zm9.974.056v-.002.002zM6 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4zm3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0zm4.5 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1H13V5.5a.5.5 0 0 1 .5-.5z" />
                                        <path fill-rule="evenodd" d="M13 7.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 0 1H14v1.5a.5.5 0 0 1-1 0v-2z" />
                                    </svg> Add Super User</a></li>
                        </ul>
                    </div>
                </div>
                <div class="ibox-content pagination-footable">
                    <div class="row justify-content-between">
                        <div class="col-lg-4">
                            <div class="input-group mb-3">
                                <div class="input-group-append">
                                    <button class="btn btn-warning rounded-left" type="button">
                                        <svg style="width: 14px;height: 14px;margin: 0px 0px 3px 0px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="4" stroke-linecap="round" stroke-linejoin="round">
                                            <circle cx="11" cy="11" r="8"></circle>
                                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                        </svg>
                                    </button>
                                </div>
                                <input type="text" class="form-control bg-light small rounded-right" id="filter" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="total-rows text-right">menampilkan <span id="total-row"></span> data</div>
                        </div>
                    </div>
                    <table class="footable table table-stripped" id="table" data-page-size="20" data-limit-navigation="4" data-filter=#filter>
                        <thead>
                            <tr>
                                <th data-toggle="true" data-type="numeric">No</th>
                                <th>Nama</th>
                                <th data-hide="phone">Role</th>
                                <th data-hide="phone,tablet">Phone</th>
                                <th data-hide="phone">Email</th>
                                <th data-hide="phone,tablet">Join</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            foreach ($user as $data) :
                            ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= $data['name'] ?></td>
                                    <td><?= $data['role'] ?></td>
                                    <td><?= $data['phone_number'] ?></td>
                                    <td><?= $data['email'] ?></td>
                                    <td><?= datephp('d M y', $data['created_at']) ?></td>
                                    <td>
                                        <div class='btn-group btn-group-sm'>
                                            <a class='btn btn-warning' data-tooltip="tooltip" data-placement="top" title="Edit" href='<?= base_url('settings/edit_superuser/' . $data['_id']); ?>'>
                                                <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor">
                                                    <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                                    <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                                                </svg>
                                            </a>
                                            <a class='btn btn-danger delete-button' data-tooltip="tooltip" data-placement="top" title="Delete" href='<?= base_url('settings/delete_superuser/' . $data['_id']); ?>'>
                                                <svg width="16px" height="16px" viewBox="0 0 16 16" fill="currentColor">
                                                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                                                    <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
                                                </svg>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <div class="foo-pagination">
                        <ul class="pagination float-right"></ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= core_script(); ?>
<?= footable(); ?>