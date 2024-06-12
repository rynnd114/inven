<?php
require_once('vendor/autoload.php'); // Path ke autoload.php dari TCPDF

// Fungsi untuk membuat barcode
function createBarcode($text, $filename) {
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // Set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetTitle('Barcode');
    $pdf->SetSubject('Barcode');
    $pdf->SetKeywords('TCPDF, PDF, barcode');

    // Set font
    $pdf->SetFont('helvetica', '', 12);

    // Add a page
    $pdf->AddPage();

    // Set the barcode format
    $style = array(
        'border' => true,
        'padding' => 4,
        'fgcolor' => array(0, 0, 0),
        'bgcolor' => false, //array(255, 255, 255),
        'text' => true,
        'position' => 'S',
        'align' => 'C',
        'stretchtext' => 4
    );

    // Add barcode
    $pdf->write1DBarcode($text, 'C128', '', '', '', 18, 0.4, $style, 'N');

    // Output as PNG image
    $pdf->Output($filename, 'F');
}

// Panggil fungsi untuk membuat barcode
$filename = 'barcode_' . $laptop['id'] . '.png'; // Nama file berdasarkan ID laptop
createBarcode($laptop['serial_number'], $filename); // Gunakan serial number sebagai input untuk barcode


echo 'Barcode telah dibuat.';
?>
