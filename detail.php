<?php
require 'config/database.php';
require 'config/configure.php';
require 'vendor/autoload.php'; // Memuat autoload.php dari Composer

use Picqer\Barcode\BarcodeGeneratorPNG;

$id = $_GET['id'];
$query = $pdo->prepare("SELECT * FROM laptops WHERE id = ?");
$query->execute([$id]);
$laptop = $query->fetch(PDO::FETCH_ASSOC);

// Fetch update history
$historyQuery = $pdo->prepare("SELECT * FROM update_history WHERE laptop_id = ? ORDER BY updated_at DESC");
$historyQuery->execute([$id]);
$updateHistory = $historyQuery->fetchAll(PDO::FETCH_ASSOC);

// Fungsi untuk menghasilkan barcode
function generateBarcode($value)
{
    $generator = new BarcodeGeneratorPNG();
    return 'data:image/png;base64,' . base64_encode($generator->getBarcode($value, $generator::TYPE_CODE_128));
}
?>

<?php include 'header.php'; ?>

<h1 class="h3 mb-4 text-gray-800">Laptop Details</h1>
<table class="table">
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
        <td><?php echo htmlspecialchars(formatTanggal($laptop['purchase_date'])) ?>
    </tr>
    <tr>
        <th>Keterangan</th>
        <td><?php echo htmlspecialchars($laptop['keterangan']); ?></td>
    </tr>
    <tr>
        <th>Barcode</th>
        <td>
            <img src="<?php echo generateBarcode($laptop['serial_number']); ?>" alt="Barcode">
        </td>
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
            <th>Old Brand</th>
            <th>Old Model</th>
            <th>Old Serial Number</th>
            <th>Old Purchase Date</th>
            <th>Keterangan</th>
            <th>Image</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($updateHistory) {
            foreach ($updateHistory as $history) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars(formatTanggal($history['updated_at'])) . '</td>'; // Panggil fungsi formatTanggal() untuk update_at
                echo '<td>' . htmlspecialchars($history['old_brand']) . '</td>';
                echo '<td>' . htmlspecialchars($history['old_model']) . '</td>';
                echo '<td>' . htmlspecialchars($history['old_serial_number']) . '</td>';
                echo '<td>' . htmlspecialchars(formatTanggal($history['old_purchase_date'])) . '</td>'; // Panggil fungsi formatTanggal() untuk old_purchase_date
                echo '<td>' . htmlspecialchars($history['keterangan']) . '</td>';
                echo '<td>';
                $historyImages = json_decode($history['images'] ?? '[]', true);
                if ($historyImages) {
                    foreach ($historyImages as $image) {
                        echo '<a href="#" class="enlarge-image">';
                        echo '<img src="uploads/' . htmlspecialchars($image) . '" class="img-thumbnail" style="width: 100px; height: auto; margin-right: 10px;">';
                        echo '</a>';
                    }
                } else {
                    echo '<p>No images available.</p>';
                }
                echo '</td>';
                echo '</tr>';
            }
        } else {
            echo '<tr><td colspan="6">No update history available.</td></tr>';
        }
        ?>
    </tbody>



</table>


<a href="update.php?id=<?php echo $id; ?>" class="btn btn-primary">Edit</a>

<?php include 'footer.php'; ?>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const images = document.querySelectorAll(".enlarge-image");
        images.forEach(function(image) {
            image.addEventListener("click", function() {
                const imageUrl = this.querySelector('img').getAttribute("src"); // Get the src attribute of the img inside the clicked element
                const modalImage = document.getElementById("modalImage");
                modalImage.setAttribute("src", imageUrl);
                const modal = new bootstrap.Modal(document.getElementById('imageModal'));
                modal.show();
            });
        });
    });
</script>