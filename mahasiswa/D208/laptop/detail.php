<?php
require '../../../config/database.php';
require '../../../config/configure.php';

$id = $_GET['id'];
$query = $pdo->prepare("SELECT * FROM laptops WHERE id = ?");
$query->execute([$id]);
$laptop = $query->fetch(PDO::FETCH_ASSOC);

// Fetch update history
$historyQuery = $pdo->prepare("SELECT * FROM laptop_history WHERE laptop_id = ? ORDER BY updated_at DESC");
$historyQuery->execute([$id]);
$updateHistory = $historyQuery->fetchAll(PDO::FETCH_ASSOC);

// Function to generate barcode
function generateBarcode($value)
{
    $generator = new Picqer\Barcode\BarcodeGeneratorPNG();
    return 'data:image/png;base64,' . base64_encode($generator->getBarcode($value, $generator::TYPE_CODE_128));
}

// QR code image file name
$qrFileName = 'qr_' . $id . '.png';
$qrImagePath = '../../../uploads/' . $qrFileName;
?>

<?php include '../../../component/header.php'; ?>

<h1 class="h3 mb-4 text-gray-800">Laptop Details</h1>
<table class="table">
    <tr>
        <th>ID</th>
        <td><?php echo htmlspecialchars($laptop['id']); ?></td>
    </tr>
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
        <th>RAM</th>
        <td><?php echo htmlspecialchars($laptop['ram']); ?></td>
    </tr>
    <tr>
        <th>Memory</th>
        <td><?php echo htmlspecialchars($laptop['memori']); ?></td>
    </tr>
    <tr>
        <th>Operating System</th>
        <td><?php echo htmlspecialchars($laptop['os']); ?></td>
    </tr>
    <tr>
        <th>Processor</th>
        <td><?php echo htmlspecialchars($laptop['processor']); ?></td>
    </tr>
    <tr>
        <th>Screen</th>
        <td><?php echo htmlspecialchars($laptop['layar']); ?></td>
    </tr>
    <tr>
        <th>Condition</th>
        <td><?php echo htmlspecialchars($laptop['kondisi']); ?></td>
    </tr>
    <tr>
        <th>Keterangan</th>
        <td><?php echo htmlspecialchars($laptop['keterangan']); ?></td>
    </tr>
</table>

<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">Image Preview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <img id="modalImage" src="" class="img-fluid">
            </div>
        </div>
    </div>
</div>

<h2 class="h4 mb-4 text-gray-800">Update History</h2>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Update Date</th>
            <th>Brand</th>
            <th>Model</th>
            <th>Serial Number</th>
            <th>Purchase Date</th>
            <th>RAM</th>
            <th>Memory</th>
            <th>OS</th>
            <th>Processor</th>
            <th>Screen</th>
            <th>Condition</th>
            <th>Keterangan</th>
            <th>Image</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($updateHistory) {
            foreach ($updateHistory as $history) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars(formatTanggal($history['updated_at'])) . '</td>'; // Format the date
                echo '<td>' . htmlspecialchars($history['brand']) . '</td>';
                echo '<td>' . htmlspecialchars($history['model']) . '</td>';
                echo '<td>' . htmlspecialchars($history['serial_number']) . '</td>';
                echo '<td>' . htmlspecialchars(formatTanggal($history['purchase_date'])) . '</td>'; // Format the date
                echo '<td>' . htmlspecialchars($history['ram']) . '</td>';
                echo '<td>' . htmlspecialchars($history['memori']) . '</td>';
                echo '<td>' . htmlspecialchars($history['os']) . '</td>';
                echo '<td>' . htmlspecialchars($history['processor']) . '</td>';
                echo '<td>' . htmlspecialchars($history['layar']) . '</td>';
                echo '<td>' . htmlspecialchars($history['kondisi']) . '</td>';
                echo '<td>' . htmlspecialchars($history['keterangan']) . '</td>';
                echo '<td>';
                $historyImages = json_decode($history['images'] ?? '[]', true);
                if ($historyImages) {
                    foreach ($historyImages as $image) {
                        echo '<a href="#" class="enlarge-image">';
                        echo '<img src="../../../uploads/' . htmlspecialchars($image) . '" class="img-thumbnail" style="width: 100px; height: auto; margin-right: 10px;">';
                        echo '</a>';
                    }
                } else {
                    echo '<p>No images available.</p>';
                }
                echo '</td>';
                echo '</tr>';
            }
        } else {
            echo '<tr><td colspan="13">No update history available.</td></tr>';
        }
        ?>
    </tbody>
</table>

<a href="../../../generate_pdf_laptop.php?id=<?php echo $id; ?>" class="btn btn-secondary">Download PDF</a>

<?php include '../../../component/footer.php'; ?>