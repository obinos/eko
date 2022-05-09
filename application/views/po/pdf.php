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
$heading = '<h1 align="center">Purchase Order</h1><br>';
$pdf->writeHTML($heading);
$pdf->Image('../public/assets/img/logo_aratamart_invoice.jpg', '', '', 50, 25, 'JPG', '', '', true, '300', '', false, false, '', $fitbox, false, false);
$style = array(
    'position' => 'R',
    'align' => 'C',
    'stretch' => false,
    'fitwidth' => true,
    'cellfitalign' => '',
    'border' => false,
    'hpadding' => 'auto',
    'vpadding' => 'auto',
    'fgcolor' => array(0, 0, 0),
    'bgcolor' => false, //array(255,255,255),
    'text' => true,
    'font' => 'helvetica',
    'fontsize' => 8,
    'stretchtext' => 4
);
$pdf->write1DBarcode($po[0]['pono'], 'C39', '', '', '', 18, 0.4, $style, 'N');
$html1 = '
<table>
    <tbody>
        <tr>
            <td style="width: 80%">
            </td>
            <td style="width: 20%">
            </td>
        </tr>
        <tr>
            <td>
                Supplier : <strong>' . $po[0]['supplier'] . '</strong>
            </td>
            <td align="right">
                <strong>' . datephp('d-m-Y H:i', $po[0]['created_at']) . '</strong>
            </td>
        </tr>
    </tbody>
</table>
<br>
<br>
<table border="1" cellspacing="0" cellpadding="3">
    <thead>
        <tr>
            <th style="width: 5%" align="center"><strong>No</strong></th>
            <th style="width: 45%" align="center"><strong>Nama Produk</strong></th>
            <th style="width: 10%" align="center"><strong>Qty Beli</strong></th>
            <th style="width: 8%" align="center"><strong>Satuan</strong></th>
            <th style="width: 9%" align="center"><strong>Qty Pack</strong></th>
            <th style="width: 10%" align="center"><strong>Harga</strong></th>
            <th style="width: 13%" align="center"><strong>Total</strong></th>
        </tr>
    </thead>
    <tbody>';
$no = 1;
$html2 = '';
$items = json_decode(json_encode($po[0]['items']), true);
$keys = array_column($items, 'name');
array_multisort($keys, SORT_ASC, $items);
foreach ($items as $item) {
    $html2 = $html2 . '
        <tr>
            <td style="width: 5%" align="right">' . $no++ . '</td>
            <td style="width: 45%">' . $item['name'] . $note . '</td>
            <td style="width: 10%" align="right">' . thousand($item['qty_unit']) . '</td>
            <td style="width: 8%">' . $item['unit'] . '</td>
            <td style="width: 9%" align="right">' . thousand($item['qty']) . '</td>
            <td style="width: 10%" align="right">' . thousand($item['price']) . '</td>
            <td style="width: 13%" align="right">' . thousand($item['total_price']) . '</td>
        </tr>';
}
$html3 = '
    </tbody>
    <tfoot>
        <tr>
            <th colspan="6" align="right"><strong>Total</strong></th>
            <th align="right"><strong>' . thousand($po[0]['total']) . '</strong></th>
        </tr>
    </tfoot>
</table>';
$html = $html1 . $html2 . $html3;
$pdf->writeHTML($html);
$pdf->Output($po[0]['pono'] . '_' . time() . '.pdf', 'I');
