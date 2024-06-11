<?php
require 'config/database.php';

$id = $_GET['id'];
$query = $pdo->prepare("SELECT * FROM laptops WHERE id = ?");
$query->execute([$id]);
$laptop = $query->fetch(PDO::FETCH_ASSOC);
?>

<?php include 'header.php'; ?>

<h1 class="h3 mb-4 text-gray-800">Laptop Details</h1>
<div class="card mb-4">
    <div class="card-body">
        <h5 class="card-title">Brand: <?php echo htmlspecialchars($laptop['brand']); ?></h5>
        <p class="card-text">Model: <?php echo htmlspecialchars($laptop['model']); ?></p>
        <p class="card-text">Serial Number: <?php echo htmlspecialchars($laptop['serial_number']); ?></p>
        <p class="card-text">Purchase Date: <?php echo htmlspecialchars($laptop['purchase_date']); ?></p>
        <h5 class="card-title">Images:</h5>
        <div class="row">
            <?php
            $images = json_decode($laptop['images'], true);
            if ($images) {
                foreach ($images as $image) {
                    echo '<div class="col-md-3">';
                    echo '<img src="uploads/' . htmlspecialchars($image) . '" class="img-thumbnail">';
                    echo '</div>';
                }
            } else {
                echo '<p>No images available.</p>';
            }
            ?>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
