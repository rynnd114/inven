<?php
require 'vendor/autoload.php'; // Pastikan path ke autoload.php sesuai dengan struktur proyek Anda
require 'config/database.php';
require 'config/configure.php';

use Dompdf\Dompdf;
use Dompdf\Options;

$id = $_GET['id'];
$query = $pdo->prepare("SELECT * FROM furniture WHERE id = ?");
$query->execute([$id]);
$furniture = $query->fetch(PDO::FETCH_ASSOC);

// Fetch update history
$historyQuery = $pdo->prepare("SELECT * FROM furniture_history WHERE furniture_id = ? ORDER BY changed_at DESC");
$historyQuery->execute([$id]);
$updateHistory = $historyQuery->fetchAll(PDO::FETCH_ASSOC);

// Function to generate barcode (using Picqer Barcode)
function generateBarcode($value)
{
    $generator = new Picqer\Barcode\BarcodeGeneratorPNG();
    return 'data:image/png;base64,' . base64_encode($generator->getBarcode($value, $generator::TYPE_CODE_128));
}

// Create new Dompdf instance
$options = new Options();
$options->set('isHtml5ParserEnabled', true); // Aktifkan parser HTML5
$options->set('isPhpEnabled', true); // Aktifkan evaluasi PHP dalam dokumen

$dompdf = new Dompdf($options);

// Load HTML content
ob_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Furniture Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table,
        th,
        td {
            border: 1px solid black;
            padding: 8px;
        }

        th {
            background-color: #f2f2f2;
        }

        .barcode {
            width: 200px;
        }

        .img-thumbnail {
            width: 100px;
            height: auto;
            margin-right: 10px;
        }
    </style>
</head>

<body>
    <h1>Furniture Details</h1>
    <table>
        <tr>
            <th>ID</th>
            <td><?php echo htmlspecialchars($furniture['id']); ?></td>
        </tr>
        <tr>
            <th>Nama Furniture</th>
            <td><?php echo htmlspecialchars($furniture['nama_furniture']); ?></td>
        </tr>
        <tr>
            <th>Merk</th>
            <td><?php echo htmlspecialchars($furniture['merk']); ?></td>
        </tr>
        <tr>
            <th>Kondisi</th>
            <td><?php echo htmlspecialchars($furniture['kondisi']); ?></td>
        </tr>
        <tr>
            <th>Keterangan</th>
            <td><?php echo htmlspecialchars($furniture['keterangan']); ?></td>
        </tr>
        <tr>
            <th>QR Code</th>
            <td><img src="<?php echo htmlspecialchars($qrImagePath); ?>" class="barcode" alt="QR Code"></td>
        </tr>
    </table>

    <h2>Update History</h2>
    <table>
        <thead>
            <tr>
                <th>Update Date</th>
                <th>Nama Furniture</th>
                <th>Merk</th>
                <th>Kondisi</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($updateHistory as $history) : ?>
                <tr>
                    <td><?php echo htmlspecialchars(formatTanggal($history['changed_at'])); ?></td>
                    <td><?php echo htmlspecialchars($history['nama_furniture']); ?></td>
                    <td><?php echo htmlspecialchars($history['merk']); ?></td>
                    <td><?php echo htmlspecialchars($history['kondisi']); ?></td>
                    <td><?php echo htmlspecialchars($history['keterangan']); ?></td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($updateHistory)) : ?>
                <tr>
                    <td colspan="7">No update history available.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>

</html>
<?php
$html = ob_get_clean();
$dompdf->loadHtml($html);

// Render PDF (optional settings)
$dompdf->setPaper('A4', 'portrait'); // Set ukuran kertas dan orientasi (portrait atau landscape)

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF (inline download)
$dompdf->stream('furniture_details.pdf', ['Attachment' => false]);
?>