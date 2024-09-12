<?php
require '../../../../config/database.php';
require '../../../../config/configure.php';


$id = $_GET['id'];
$query = $pdo->prepare("SELECT * FROM furniture WHERE id = ?");
$query->execute([$id]);
$furniture = $query->fetch(PDO::FETCH_ASSOC);

// Fetch update history
$historyQuery = $pdo->prepare("SELECT * FROM furniture_history WHERE furniture_id = ? ORDER BY changed_at DESC");
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
$qrImagePath = '../../../../uploads/' . $qrFileName;
?>

<?php include '../../../../component/header.php'; ?>

<h1 class="h3 mb-4 text-gray-800">Furniture Details</h1>
<table class="table">
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
        <th>Jumlah</th>
        <td><?php echo htmlspecialchars($furniture['jumlah']); ?></td>
    </tr>
    <tr>
        <th>Keterangan</th>
        <td><?php echo htmlspecialchars($furniture['keterangan']); ?></td>
    </tr>
    <tr>
        <th>QR Code</th>
        <td>
            <img src="<?php echo $qrImagePath; ?>" alt="QR Code">
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
            <th>Nama Furniture</th>
            <th>Merk</th>
            <th>Jumlah</th>
            <th>Keterangan</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($updateHistory) {
            foreach ($updateHistory as $history) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars(formatTanggal($history['changed_at'])) . '</td>'; // Format the date
                echo '<td>' . htmlspecialchars($history['nama_furniture']) . '</td>';
                echo '<td>' . htmlspecialchars($history['merk']) . '</td>';
                echo '<td>' . htmlspecialchars($history['jumlah']) . '</td>';
                echo '<td>' . htmlspecialchars($history['keterangan']) . '</td>';
                echo '<td>';
                $historyImages = json_decode($history['image'] ?? '[]', true);
                if ($historyImages) {
                    foreach ($historyImages as $image) {
                        echo '<a href="#" class="enlarge-image">';
                        echo '<img src="../../../../uploads/' . htmlspecialchars($image) . '" class="img-thumbnail" style="width: 100px; height: auto; margin-right: 10px;">';
                        echo '</a>';
                    }
                } else {
                    echo '<p>No images available.</p>';
                }
                echo '</td>';
                echo '</tr>';
            }
        } else {
            echo '<tr><td colspan="7">No update history available.</td></tr>';
        }
        ?>
    </tbody>
</table>

<a href="update.php?id=<?php echo $id; ?>" class="btn btn-primary">Edit</a>
<a href="../../../../generate_pdf_furniture.php?id=<?php echo $id; ?>" class="btn btn-secondary">Download PDF</a>

<?php include '../../../../component/footer.php'; ?>

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

git config --global user.email "you@example.com"
git config --global user.name "Your Name"