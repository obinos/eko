<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12 pad0">
            <div class="ibox ">
                <div class="ibox-title d-flex align-items-center justify-content-between">
                    <h5>Detail Transaksi</h5>
                </div>
                <div class="ibox-content content-print">
                    <div class="row justify-content-between d-flex align-items-center">
                        <div class="col-md-6 mb-2">
                            <p><?= datephp('d-m-Y H:i', $order[0]['transaction_date']) ?></p>
                            <h3 class="my-1"><?= $order[0]['invno'] ?></h3>
                        </div>
                        <div class="col-md-6 mb-2 text-right">
                            <span class="p-2 text-dark badge badge-lg badge-<?= $status_order['button'] ?>">Order <?= $status_order['title'] ?></span>
                        </div>
                    </div>
                    <div class="row justify-content-center d-flex align-items-center">
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
                                                <path fill="#909090" d="M20,8H4V6H20M20,18H4V12H20M20,4H4C2.89,4 2,4.89 2,6V18A2,2 0 0,0 4,20H20A2,2 0 0,0 22,18V6C22,4.89 21.1,4 20,4Z" />
                                            </svg>
                                        </td>
                                        <td class="text-left">
                                            <strong><?= payment_string($order[0]['payment'], 'nominal') ?></strong>
                                        </td>
                                    </tr>
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
                                    <tr class="border-bottom">
                                        <td style="width: 8px">
                                            <svg style="width:20px;height:20px" viewBox="0 0 24 24">
                                                <path fill="#909090" d="M12,20A8,8 0 0,0 20,12A8,8 0 0,0 12,4A8,8 0 0,0 4,12A8,8 0 0,0 12,20M12,2A10,10 0 0,1 22,12A10,10 0 0,1 12,22C6.47,22 2,17.5 2,12A10,10 0 0,1 12,2M12.5,7V12.25L17,14.92L16.25,16.15L11,13V7H12.5Z" />
                                            </svg>
                                        </td>
                                        <td class="text-left">
                                            <strong><?= $delivery_time ?></strong>
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
                            <div class="alert alert-success mb-3" role="alert">
                                <p>Catatan Penjual: <b><?= $order[0]['merchant_notes']; ?></b></p>
                            </div>
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
                                                <td class="text-right"><?= thousand(($item['qty'] * $item['price']) - round($item['qty_return'] * $item['price'])) ?></td>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= core_script(); ?>