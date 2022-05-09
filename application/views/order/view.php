<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12 pad0">
            <div class="ibox ">
                <div class="ibox-title d-flex align-items-center justify-content-between">
                    <h5>Detail Transaksi</h5>
                    <div class="btn-group">
                        <a class='btn btn-primary btn-sm' data-tooltip="tooltip" data-placement="top" title="Kirim Rincian" href='https://api.whatsapp.com/send?phone=<?= nohp($order[0]['customer']->phone) ?>&text=<?= $rincian ?>' target="_blank">
                            <svg width="16px" height="16px" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z" />
                            </svg></a>
                        <a class='btn btn-success btn-sm' data-tooltip="tooltip" data-placement="top" title="Download" href='<?= base_url('order/download/' . $order[0]['_id']); ?>'>
                            <svg width="16px" height="16px" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z" />
                                <path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z" />
                            </svg></a>
                        <a class='btn btn-warning btn-sm' data-tooltip="tooltip" data-placement="top" title="Edit" href='<?= base_url('order/edit/' . $order[0]['_id']); ?>'>
                            <svg width="16px" height="16px" viewBox="0 0 16 16" fill="currentColor">
                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456l-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                            </svg></a>
                    </div>
                </div>
                <div class="ibox-content content-print">
                    <div class="row justify-content-center d-flex align-items-center">
                        <div class="col-md-6">
                            <p><?= datephp('d-m-Y H:i', $order[0]['transaction_date']) ?></p>
                            <h3 class="my-1"><?= $order[0]['invno'] ?></h3>
                            <div class="btn-group mb-3">
                                <button data-toggle="dropdown" class="btn btn-<?= $status_order['button'] ?> btn-sm dropdown-toggle">
                                    Order <?= $status_order['title'] ?></button>
                                <ul class="dropdown-menu animated fadeInRight m-t-xs">
                                    <?php foreach ($data_status as $key => $val) {
                                        if ($order[0]['status'] != $key) { ?>
                                            <li><a class='dropdown-item' id="<?= $key ?>" href="<?= base_url("order/update_status/$key/" . $order[0]['_id']) ?>"><?= $val ?></a></li>
                                    <?php }
                                    } ?>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <?php foreach ($order[0]['payment'] as $p => $pay) {
                                $first = first_word($pay->method);
                                $alert = $pay->is_paid === true ? 'success' : 'warning';
                                $checkbox = $pay->is_paid === true ? 'checked' : null; ?>
                                <div class="button-paid">
                                    <div class="alert<?= $first . $pay->payment_amount ?> d-flex align-items-center justify-content-between alert alert-<?= $alert ?> mb-2 p-2">
                                        <div>
                                            <p id="alert<?= $first . $pay->payment_amount ?>"><?= $pay->method . ' (' . thousand($pay->payment_amount) . ')' ?></p>
                                            <div id="alert<?= $first . $pay->payment_amount ?>">
                                                <?php if ($pay->paid_at) { ?>
                                                    <small id="alert<?= $first . $pay->payment_amount ?>"><?= datephp('d M y', $pay->paid_at) ?></small>
                                                <?php } ?>
                                            </div>
                                        </div>
                                        <div>
                                            <input class="switch-input" type="checkbox" name="switch<?= $first . $pay->payment_amount ?>" id="switch<?= $first . $pay->payment_amount ?>" data-id="<?= $order[0]['_id'] ?>" data-name="<?= $pay->method ?>" data-amount="<?= $pay->payment_amount ?>" <?= $checkbox ?>>
                                            <label class="switch-label" for="switch<?= $first . $pay->payment_amount ?>"></label>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="col-md-6">
                            <table class="table mb-0">
                                <tbody>
                                    <tr>
                                        <td style="width: 8px">
                                            <svg style="width:20px;height:20px" viewBox="0 0 24 24">
                                                <path fill="#909090" d="M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2M7.07,18.28C7.5,17.38 10.12,16.5 12,16.5C13.88,16.5 16.5,17.38 16.93,18.28C15.57,19.36 13.86,20 12,20C10.14,20 8.43,19.36 7.07,18.28M18.36,16.83C16.93,15.09 13.46,14.5 12,14.5C10.54,14.5 7.07,15.09 5.64,16.83C4.62,15.5 4,13.82 4,12C4,7.59 7.59,4 12,4C16.41,4 20,7.59 20,12C20,13.82 19.38,15.5 18.36,16.83M12,6C10.06,6 8.5,7.56 8.5,9.5C8.5,11.44 10.06,13 12,13C13.94,13 15.5,11.44 15.5,9.5C15.5,7.56 13.94,6 12,6M12,11A1.5,1.5 0 0,1 10.5,9.5A1.5,1.5 0 0,1 12,8A1.5,1.5 0 0,1 13.5,9.5A1.5,1.5 0 0,1 12,11Z" />
                                            </svg>
                                        </td>
                                        <td class="text-left">
                                            <strong id="customer_name"><?= $order[0]['customer']->name ?></strong>
                                        </td>
                                        <td style="width: 8px" class="text-right">
                                            <a data-tooltip="tooltip" data-placement="top" title="Copy Nama" class="copy-button" onclick="copyVariable('#customer_name')">
                                                <svg style="width:20px;height:20px" viewBox="0 0 24 24">
                                                    <path fill="#8ab662" d="M19,21H8V7H19M19,5H8A2,2 0 0,0 6,7V21A2,2 0 0,0 8,23H19A2,2 0 0,0 21,21V7A2,2 0 0,0 19,5M16,1H4A2,2 0 0,0 2,3V17H4V3H16V1Z" />
                                                </svg>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 8px">
                                            <svg style="width:20px;height:20px" viewBox="0 0 24 24">
                                                <path fill="#909090" d="M20,15.5C18.8,15.5 17.5,15.3 16.4,14.9C16.3,14.9 16.2,14.9 16.1,14.9C15.8,14.9 15.6,15 15.4,15.2L13.2,17.4C10.4,15.9 8,13.6 6.6,10.8L8.8,8.6C9.1,8.3 9.2,7.9 9,7.6C8.7,6.5 8.5,5.2 8.5,4C8.5,3.5 8,3 7.5,3H4C3.5,3 3,3.5 3,4C3,13.4 10.6,21 20,21C20.5,21 21,20.5 21,20V16.5C21,16 20.5,15.5 20,15.5M5,5H6.5C6.6,5.9 6.8,6.8 7,7.6L5.8,8.8C5.4,7.6 5.1,6.3 5,5M19,19C17.7,18.9 16.4,18.6 15.2,18.2L16.4,17C17.2,17.2 18.1,17.4 19,17.4V19Z" />
                                            </svg>
                                        </td>
                                        <td class="text-left">
                                            <strong id="customer_phone"><?= nohp($order[0]['customer']->phone) ?></strong>
                                        </td>
                                        <td style="width: 16px">
                                            <div class="d-flex flex-row">
                                                <a data-tooltip="tooltip" data-placement="top" title="WA Chat" class="copy-button" href="https://wa.me/<?= nohp($order[0]['customer']->phone) ?>" target="_blank">
                                                    <svg style="width:21px;height:21px" class="mr-2" viewBox="0 0 24 24">
                                                        <path fill="#8ab662" d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91C2.13 13.66 2.59 15.36 3.45 16.86L2.05 22L7.3 20.62C8.75 21.41 10.38 21.83 12.04 21.83C17.5 21.83 21.95 17.38 21.95 11.92C21.95 9.27 20.92 6.78 19.05 4.91C17.18 3.03 14.69 2 12.04 2M12.05 3.67C14.25 3.67 16.31 4.53 17.87 6.09C19.42 7.65 20.28 9.72 20.28 11.92C20.28 16.46 16.58 20.15 12.04 20.15C10.56 20.15 9.11 19.76 7.85 19L7.55 18.83L4.43 19.65L5.26 16.61L5.06 16.29C4.24 15 3.8 13.47 3.8 11.91C3.81 7.37 7.5 3.67 12.05 3.67M8.53 7.33C8.37 7.33 8.1 7.39 7.87 7.64C7.65 7.89 7 8.5 7 9.71C7 10.93 7.89 12.1 8 12.27C8.14 12.44 9.76 14.94 12.25 16C12.84 16.27 13.3 16.42 13.66 16.53C14.25 16.72 14.79 16.69 15.22 16.63C15.7 16.56 16.68 16.03 16.89 15.45C17.1 14.87 17.1 14.38 17.04 14.27C16.97 14.17 16.81 14.11 16.56 14C16.31 13.86 15.09 13.26 14.87 13.18C14.64 13.1 14.5 13.06 14.31 13.3C14.15 13.55 13.67 14.11 13.53 14.27C13.38 14.44 13.24 14.46 13 14.34C12.74 14.21 11.94 13.95 11 13.11C10.26 12.45 9.77 11.64 9.62 11.39C9.5 11.15 9.61 11 9.73 10.89C9.84 10.78 10 10.6 10.1 10.45C10.23 10.31 10.27 10.2 10.35 10.04C10.43 9.87 10.39 9.73 10.33 9.61C10.27 9.5 9.77 8.26 9.56 7.77C9.36 7.29 9.16 7.35 9 7.34C8.86 7.34 8.7 7.33 8.53 7.33Z" />
                                                    </svg>
                                                </a>
                                                <a data-tooltip="tooltip" data-placement="top" title="Copy No HP" class="copy-button" onclick="copyVariable('#customer_phone')">
                                                    <svg style="width:20px;height:20px" viewBox="0 0 24 24">
                                                        <path fill="#8ab662" d="M19,21H8V7H19M19,5H8A2,2 0 0,0 6,7V21A2,2 0 0,0 8,23H19A2,2 0 0,0 21,21V7A2,2 0 0,0 19,5M16,1H4A2,2 0 0,0 2,3V17H4V3H16V1Z" />
                                                    </svg>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="border-bottom">
                                        <td style="width: 8px">
                                            <svg style="width:20px;height:20px" viewBox="0 0 24 24">
                                                <path fill="#909090" d="M12,6.5A2.5,2.5 0 0,1 14.5,9A2.5,2.5 0 0,1 12,11.5A2.5,2.5 0 0,1 9.5,9A2.5,2.5 0 0,1 12,6.5M12,2A7,7 0 0,1 19,9C19,14.25 12,22 12,22C12,22 5,14.25 5,9A7,7 0 0,1 12,2M12,4A5,5 0 0,0 7,9C7,10 7,12 12,18.71C17,12 17,10 17,9A5,5 0 0,0 12,4Z" />
                                            </svg>
                                        </td>
                                        <td class="text-left">
                                            <strong id="customer_address"><?= $address ?></strong>
                                        </td>
                                        <td style="width: 8px" class="text-right">
                                            <a data-tooltip="tooltip" data-placement="top" title="Copy Alamat" class="copy-button" onclick="copyVariable('#customer_address')">
                                                <svg style="width:20px;height:20px" viewBox="0 0 24 24">
                                                    <path fill="#8ab662" d="M19,21H8V7H19M19,5H8A2,2 0 0,0 6,7V21A2,2 0 0,0 8,23H19A2,2 0 0,0 21,21V7A2,2 0 0,0 19,5M16,1H4A2,2 0 0,0 2,3V17H4V3H16V1Z" />
                                                </svg>
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table mb-0">
                                <tbody>
                                    <tr>
                                        <td style="width: 8px">
                                            <svg style="width:20px;height:20px" viewBox="0 0 24 24">
                                                <path fill="#909090" d="M12,3A4,4 0 0,1 16,7C16,7.73 15.81,8.41 15.46,9H18C18.95,9 19.75,9.67 19.95,10.56C21.96,18.57 22,18.78 22,19A2,2 0 0,1 20,21H4A2,2 0 0,1 2,19C2,18.78 2.04,18.57 4.05,10.56C4.25,9.67 5.05,9 6,9H8.54C8.19,8.41 8,7.73 8,7A4,4 0 0,1 12,3M12,5A2,2 0 0,0 10,7A2,2 0 0,0 12,9A2,2 0 0,0 14,7A2,2 0 0,0 12,5M6,11V19H8V16.5L9,17.5V19H11V17L9,15L11,13V11H9V12.5L8,13.5V11H6M15,11C13.89,11 13,11.89 13,13V17C13,18.11 13.89,19 15,19H18V14H16V17H15V13H18V11H15Z" />
                                            </svg>
                                        </td>
                                        <td class="text-left">
                                            <strong><?= $shipping_weight ?> kg</strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="width: 8px">
                                            <svg style="width:20px;height:20px" viewBox="0 0 24 24">
                                                <path fill="#909090" d="M12,20A8,8 0 0,0 20,12A8,8 0 0,0 12,4A8,8 0 0,0 4,12A8,8 0 0,0 12,20M12,2A10,10 0 0,1 22,12A10,10 0 0,1 12,22C6.47,22 2,17.5 2,12A10,10 0 0,1 12,2M12.5,7V12.25L17,14.92L16.25,16.15L11,13V7H12.5Z" />
                                            </svg>
                                        </td>
                                        <td class="text-left">
                                            <strong><?= $delivery_time ?></strong>
                                        </td>
                                    </tr>
                                    <tr class="border-bottom">
                                        <td style="width: 8px">
                                            <svg style="width:20px;height:20px" viewBox="0 0 24 24">
                                                <path fill="#909090" d="M18.13 12L19.39 10.74C19.83 10.3 20.39 10.06 21 10V9L15 3H5C3.89 3 3 3.89 3 5V19C3 20.1 3.89 21 5 21H11V19.13L11.13 19H5V5H12V12H18.13M14 4.5L19.5 10H14V4.5M19.13 13.83L21.17 15.87L15.04 22H13V19.96L19.13 13.83M22.85 14.19L21.87 15.17L19.83 13.13L20.81 12.15C21 11.95 21.33 11.95 21.53 12.15L22.85 13.47C23.05 13.67 23.05 14 22.85 14.19Z" />
                                            </svg>
                                        </td>
                                        <td class="text-left">
                                            <strong><?= $order[0]['merchant_notes']; ?></strong>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-12">
                            <BR>
                            <?php if ($order[0]['is_dropship'] == true) { ?>
                                <div class="alert alert-secondary mb-2" role="alert">
                                    <p>Penerima:</p>
                                    <p><b><?= $order[0]['recipient']->name . ' (' . nohp($order[0]['recipient']->phone) . ')' ?></b></p>
                                    <p><b><?= $order[0]['recipient']->address ?></b></p>
                                </div>
                            <?php } ?>
                            <div class="alert alert-danger mb-2" role="alert">
                                <p>Internal Notes: <b><?= $order[0]['refund']->refund_notes ? nl2br("\n" . $order[0]['internal_notes'] . "\n" . $order[0]['refund']->refund_notes) : nl2br("\n" . $order[0]['internal_notes']); ?></b></p>
                            </div>
                            <div class="table-responsive">
                                <table class="tbproduk table table-striped table-sm display table-bordered">
                                    <thead>
                                        <tr>
                                            <th style="width: 8px">No</th>
                                            <th>Nama Produk</th>
                                            <th class="text-right">Qty</th>
                                            <th class="text-right">Harga</th>
                                            <th class="text-right">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $no = 1;
                                        $items = json_decode(json_encode($order[0]['items']), true);
                                        $keys = array_column($items, 'name');
                                        array_multisort($keys, SORT_ASC, $items);
                                        foreach ($items as $item) :
                                            if ($item['note']) {
                                                $note = "<br><small>" . $item['note'] . "</small>";
                                            } else {
                                                $note = null;
                                            }
                                        ?>
                                            <tr>
                                                <td class="text-right"><?= $no++; ?></td>
                                                <td><?= $item['name'] . $note ?></td>
                                                <td class="text-right"><?= $item['qty'] ?></td>
                                                <td class="text-right"><?= thousand($item['price']) ?></td>
                                                <td class="text-right"><?= thousand($item['qty'] * $item['price']) ?></td>
                                            </tr>
                                        <?php endforeach; ?>

                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th class="text-right" colspan="4">Subtotal</th>
                                            <th class="text-right"><?= thousand($order[0]['price']->subtotal - $order[0]['price']->return); ?></th>
                                        </tr>
                                        <tr>
                                            <th class="text-right" colspan="4">Ongkir</th>
                                            <th class="text-right"><?= thousand($order[0]['price']->shipping); ?></th>
                                        </tr>
                                        <?php if ($order[0]['voucher']) { ?>
                                            <tr>
                                                <th class="text-right text-danger" colspan="4">Voucher (<?= $order[0]['voucher'] ?>)</th>
                                                <th class="text-right text-danger">- <?= thousand($order[0]['price']->discount); ?></th>
                                            </tr>
                                        <?php } ?>
                                        <tr>
                                            <th class="text-right" colspan="4">Total</th>
                                            <th class="text-right"><?= thousand($order[0]['price']->total); ?></th>
                                        </tr>
                                        <tr>
                                            <th class="text-right" colspan="4">Refund</th>
                                            <th class="text-right table-warning"><?= thousand($order[0]['refund']->refund_price); ?></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <form method="post" id="input_kresek" action="<?= base_url("order/update_kresek") ?>">
                                <input type="hidden" name="id" value="<?= $order[0]['_id'] ?>">
                                <div class="form-row align-items-center">
                                    <div class="col-lg-10 my-1">
                                        <div class="input-group date">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text width46"><svg style="width:20px;height:20px;margin:auto" viewBox="0 0 24 24">
                                                        <path fill="currentColor" d="M19 6H17C17 3.2 14.8 1 12 1S7 3.2 7 6H5C3.9 6 3 6.9 3 8V20C3 21.1 3.9 22 5 22H19C20.1 22 21 21.1 21 20V8C21 6.9 20.1 6 19 6M12 3C13.7 3 15 4.3 15 6H9C9 4.3 10.3 3 12 3M19 20H5V8H19V20M12 12C10.3 12 9 10.7 9 9H7C7 11.8 9.2 14 12 14S17 11.8 17 9H15C15 10.7 13.7 12 12 12Z" />
                                                    </svg></div>
                                            </div>
                                            <input type="text" class="form-control" name="kresek" placeholder="Input Kresek" value="<?= $order[0]['kresek'] ?>" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-lg-2 my-1">
                                        <button type="submit" class="btn btn-warning btn-block">Save</button>
                                    </div>
                                    <span class="form-text m-b-none errorkresek"></span>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= core_script(); ?>
<?= datatables(); ?>
<?= toast(); ?>
<script src="<?= base_url('assets/'); ?>vendor/validate/jquery.validate.min.js"></script>
<script>
    $(document).ready(function() {
        $("#input_kresek").validate({
            rules: {
                kresek: {
                    required: true,
                    number: true
                }
            },
            messages: {
                kresek: {
                    required: "kolom harus diisi.",
                    number: "masukkan angka saja."
                }
            },
            errorPlacement: function(error, element) {
                if (element.attr("name") == "kresek")
                    error.insertAfter(".errorkresek");
            }
        });
        $('.copy-button').click(function() {
            Swal({
                title: 'Data',
                text: 'berhasil dicopy',
                type: 'success',
                showConfirmButton: false,
                timer: 1500
            })
        });
        $('.switch-input').change(function() {
            var object = {};
            object['id'] = $(this).attr('data-id');
            object['name'] = $(this).attr('data-name');
            object['payment'] = this.checked ? 'true' : 'false';
            object['amount'] = $(this).attr('data-amount');
            var jsonString = JSON.stringify(object);
            $.ajax({
                type: "POST",
                url: '<?= base_url('order/update_paid/') ?>',
                data: {
                    data: jsonString
                },
                success: function(response) {
                    var result = $.parseJSON(response);
                    if (result.status == 'success') {
                        $.toast({
                            heading: 'Success',
                            text: 'Change Status Payment',
                            icon: 'success',
                            showHideTransition: 'slide',
                            hideAfter: 1000,
                            position: 'top-right',
                            afterHidden: function() {
                                $('.' + result.id).addClass(result.new).removeClass(result.old);
                                if (result.date) {
                                    $('div#' + result.id).append('<small id="' + result.id + '">' + result.date + '</small>');
                                } else {
                                    $('small#' + result.id).remove();
                                }
                            }
                        });
                    } else {
                        $.toast({
                            heading: 'Failed',
                            text: result.text,
                            icon: 'error',
                            showHideTransition: 'slide',
                            hideAfter: 1000,
                            position: 'top-right'
                        });
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(textStatus, errorThrown);
                }
            });
        });
    });

    function copyVariable(element) {
        var $temp = $("<input>");
        $("body").append($temp);
        $temp.val($(element).text()).select();
        document.execCommand("copy");
        $temp.remove();
    }
</script>