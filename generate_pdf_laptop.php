<?php
require 'vendor/autoload.php'; // Pastikan path ke autoload.php sesuai dengan struktur proyek Anda
require 'config/database.php';
require 'config/configure.php';
require 'middleware.php';

use Dompdf\Dompdf;
use Dompdf\Options;

$id = $_GET['id'];
$query = $pdo->prepare("SELECT * FROM laptops WHERE id = ?");
$query->execute([$id]);
$laptop = $query->fetch(PDO::FETCH_ASSOC);

// Fetch update history
$historyQuery = $pdo->prepare("SELECT * FROM laptop_history WHERE laptop_id = ? ORDER BY updated_at DESC");
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
    <title>Laptop Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
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
    <h1>Laptop Details</h1>
    <table>
        <tr>
            <th>Brand</th>
            <td><?php echo htmlspecialchars($laptop['brand']); ?></td>
        </tr>
        <tr>
            <th>Model</th>
            <td><?php echo htmlspecialchars($laptop['model']); ?></td>
        </tr>
        <tr>
            <th>Serial Number</th>
            <td><?php echo htmlspecialchars($laptop['serial_number']); ?></td>
        </tr>
        <tr>
            <th>Purchase Date</th>
            <td><?php echo htmlspecialchars(formatTanggal($laptop['purchase_date'])); ?></td>
        </tr>
        <tr>
            <th>Keterangan</th>
            <td><?php echo htmlspecialchars($laptop['keterangan']); ?></td>
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
                <th>Old Brand</th>
                <th>Old Model</th>
                <th>Old Serial Number</th>
                <th>Old Purchase Date</th>
                <th>Keterangan</th>
                <th>Image</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($updateHistory as $history): ?>
                <tr>
                    <td><?php echo htmlspecialchars(formatTanggal($history['updated_at'])); ?></td>
                    <td><?php echo htmlspecialchars($history['old_brand']); ?></td>
                    <td><?php echo htmlspecialchars($history['old_model']); ?></td>
                    <td><?php echo htmlspecialchars($history['old_serial_number']); ?></td>
                    <td><?php echo htmlspecialchars(formatTanggal($history['old_purchase_date'])); ?></td>
                    <td><?php echo htmlspecialchars($history['keterangan']); ?></td>
                    <td>
                        <?php
                        $historyImages = json_decode($history['images'] ?? '[]', true);
                        if ($historyImages) {
                            foreach ($historyImages as $image) {
                                echo '<img src="data:image/jpeg;base64,' . htmlspecialchars($image) . '" class="img-thumbnail">';
                            }
                        } else {
                            echo '<p>No images available.</p>';
                        }
                        ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($updateHistory)): ?>
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
$dompdf->stream('laptop_details.pdf', ['Attachment' => false]);
?>
