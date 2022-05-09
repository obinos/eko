<?php
$this->load->library('pdf');
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

$pdf->setPrintHeader(false);
$pdf->SetAutoPageBreak(true, PDF_MARGIN_BOTTOM);
$pdf->AddPage('');
$pdf->SetFont('helvetica', '', 10);
$heading = '<h1 align="center">INVOICE</h1>';
$pdf->writeHTML($heading);
$pdf->Image('../public/assets/img/logo_aratamart_invoice.jpg', '', '', 50, 25, 'JPG', '', '', true, '300', '', false, false, '', $fitbox, false, false);
$payment = payment_string($order[0]['payment'], 'nominal');
$shipping = strpos($order[0]['shipping'], 'Sidoarjo') !== false ? 'Sidoarjo' : $order[0]['shipping'];
foreach ($order[0]['payment'] as $p) {
    if ($p->is_paid === false) {
        $lunas = '<strong color="#FABE0E">BELUM LUNAS</strong>';
    }
}
if ($lunas) {
    $datalunas = $lunas;
    $pdf->Image('../public/assets/img/belumlunas.png', '', 60, '', '', 'PNG', '', '', false, 72, '', false, false, '', false, false, true);
} else {
    $datalunas = '<strong color="#8AB661">LUNAS</strong>';
    $pdf->Image('../public/assets/img/lunas.png', '', 60, '', '', 'PNG', '', '', false, 72, '', false, false, '', false, false, true);
}
$pdf->SetAlpha(1);
$html1 = '
<br>
<br>
<table>
    <tbody>
        <tr>
            <td style="width: 50%"></td>
            <td style="width: 50%" align="right">
                ' . datephp('d-m-Y H:i', $order[0]['transaction_date']) . '
                <br><strong>' . $order[0]['invno'] . '</strong>
                <br>' . $datalunas . '
            </td>
        </tr>
    </tbody>
</table>
<br>
<br>
<table>
    <tbody>
        <tr>
            <td style="width: 9%">
                Nama
            </td>
            <td style="width: 2%">
                :
            </td>
            <td style="width: 37%">
                <strong>' . $order[0]['customer']->name . '</strong>
            </td>
            <td style="width: 13%">
                Payment
            </td>
            <td style="width: 2%">
                :
            </td>
            <td style="width: 37%">
                <strong>' . $payment . '</strong>
            </td>
        </tr>
        <tr>
            <td>
                No HP
            </td>
            <td>
                :
            </td>
            <td>
                <strong>' . $order[0]['customer']->phone . '</strong>
            </td>
            <td>
                Pengiriman
            </td>
            <td>
                :
            </td>
            <td>
                <strong>' . $shipping . ' - ' . datephp('d M Y', $order[0]['delivery_time']) . '</strong>
            </td>
        </tr>
    </tbody>
</table>
<table>
    <tbody>
        <tr>
            <td style="width: 9%">
                Alamat
            </td>
            <td style="width: 2%">
                :
            </td>
            <td style="width: 89%">
                <strong>' . $order[0]['customer']->address . '</strong>
            </td>
        </tr>
        <tr>
            <td>
                Note
            </td>
            <td>
                :
            </td>
            <td>
                <strong>' . $order[0]['merchant_notes'] . '</strong>
            </td>
        </tr>
    </tbody>
</table>
<br>
<br>
<table border="1" cellspacing="0" cellpadding="3">
    <thead>
        <tr>
            <th style="width: 7%" align="center"><strong>No</strong></th>
            <th style="width: 62%" align="center"><strong>Nama Produk</strong></th>
            <th style="width: 7%" align="center"><strong>Qty</strong></th>
            <th style="width: 12%" align="center"><strong>Harga</strong></th>
            <th style="width: 12%" align="center"><strong>Total</strong></th>
        </tr>
    </thead>
    <tbody>';
$no = 1;
$html2 = '';
$items = json_decode(json_encode($order[0]['items']), true);
$keys = array_column($items, 'name');
array_multisort($keys, SORT_ASC, $items);
foreach ($items as $item) {
    if ($item['note']) {
        $note = '<br /><small>' . $item['note'] . '</small>';
    } else {
        $note = null;
    }
    $html2 = $html2 . '
        <tr>
            <td style="width: 7%" align="right">' . $no++ . '</td>
            <td style="width: 62%">' . $item['name'] . $note . '</td>
            <td style="width: 7%" align="right">' . $item['qty'] . '</td>
            <td style="width: 12%" align="right">' . thousand($item['price']) . '</td>
            <td style="width: 12%" align="right">' . thousand($item['qty'] * $item['price']) . '</td>
        </tr>';
}
$voucher = null;
if ($order[0]['voucher']) {
    $voucher = '
    <tr>
        <th align="right" colspan="4">Voucher (<strong color="#8AB661">' . $order[0]['voucher'] . '</strong>)</th>
        <th align="right" color="#8AB661">- ' . thousand($order[0]['price']->discount) . '</th>
    </tr>';
}
$html3 = '
    </tbody>
    <tfoot>
        <tr>
            <th align="right" colspan="4"><strong>Subtotal</strong></th>
            <th align="right"><strong>' . thousand($order[0]['price']->subtotal) . '</strong></th>
        </tr>
        <tr>
            <th align="right" colspan="4"><strong>Ongkir</strong></th>
            <th align="right"><strong>' . thousand($order[0]['price']->shipping) . '</strong></th>
        </tr>' . $voucher . '
        <tr>
            <th align="right" colspan="4"><strong>Total</strong></th>
            <th align="right"><strong>' . thousand($order[0]['price']->total) . '</strong></th>
        </tr>
    </tfoot>
</table>';
if (strpos($payment, 'BCA') !== false || strpos($payment, 'Mandiri') !== false) {
    $html4 = '<p><b>Informasi Rekening :</b></p>';
    foreach ($order[0]['payment'] as $p) {
        if (strpos($p->method, 'BCA') !== false) {
            $html5 = '<p><b>' . $p->method . ' : ' . $p->payment_number . '</b></p>';
        } elseif (strpos($p->method, 'Mandiri') !== false) {
            $html6 = '<p><b>' . $p->method . ' : ' . $p->payment_number . '</b></p>';
        }
    }
    $pay = $html4 . $html5 . $html6;
}
$html = $html1 . $html2 . $html3 . $pay;
$pdf->writeHTML($html);
$pdf->Output($order[0]['invno'] . '_' . time() . '.pdf', 'I');
