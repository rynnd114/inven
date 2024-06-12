<?php
require 'config/database.php';

$id = $_GET['id'];
$query = $pdo->prepare("SELECT * FROM laptops WHERE id = ?");
$query->execute([$id]);
$laptop = $query->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $brand = $_POST['brand'];
    $model = $_POST['model'];
    $serial_number = $_POST['serial_number'];
    $purchase_date = $_POST['purchase_date'];
    $keterangan = $_POST['keterangan'];

    // Handle file uploads
    $uploadedImages = [];
    if (!empty($_FILES['images']['name'][0])) {
        $totalFiles = count($_FILES['images']['name']);
        for ($i = 0; $i < $totalFiles; $i++) {
            $fileName = $_FILES['images']['name'][$i];
            $fileTmpName = $_FILES['images']['tmp_name'][$i];
            $fileDestination = 'uploads/' . $fileName;
            if (move_uploaded_file($fileTmpName, $fileDestination)) {
                $uploadedImages[] = $fileName;
            }
        }
    }

    // Merge existing and new images
    // Merge existing and new images
    $existingImages = json_decode($laptop['images'] ?? '[]', true);
    if (!is_array($existingImages)) {
        $existingImages = [];
    }
    $allImages = array_merge($existingImages, $uploadedImages);
    $imagesJson = !empty($allImages) ? json_encode($allImages) : $laptop['images'];


    $sql = "INSERT INTO update_history (laptop_id, old_brand, old_model, old_serial_number, old_purchase_date, images, keterangan) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id, $laptop['brand'], $laptop['model'], $laptop['serial_number'], $laptop['purchase_date'], $laptop['images'], $laptop['keterangan']]);

    $query = $pdo->prepare("UPDATE laptops SET brand = ?, model = ?, serial_number = ?, purchase_date = ?, images = ?, keterangan = ? WHERE id = ?");
    $query->execute([$brand, $model, $serial_number, $purchase_date, $imagesJson,  $keterangan, $id]);

    header("Location: detail.php?id=$id");
    exit;
}
?>

<?php include 'header.php'; ?>

<h1 class="h3 mb-4 text-gray-800">Edit Laptop</h1>
<form action="update.php?id=<?php echo $id; ?>" method="POST" enctype="multipart/form-data">
    <div class="form-group">
        <label for="brand">Brand</label>
        <input type="text" class="form-control" id="brand" name="brand" value="<?php echo htmlspecialchars($laptop['brand']); ?>" required>
    </div>
    <div class="form-group">
        <label for="model">Model</label>
        <input type="text" class="form-control" id="model" name="model" value="<?php echo htmlspecialchars($laptop['model']); ?>" required>
    </div>
    <div class="form-group">
        <label for="serial_number">Serial Number</label>
        <input type="text" class="form-control" id="serial_number" name="serial_number" value="<?php echo htmlspecialchars($laptop['serial_number']); ?>" required>
    </div>
    <div class="form-group">
        <label for="purchase_date">Purchase Date</label>
        <input type="date" class="form-control" id="purchase_date" name="purchase_date" value="<?php echo htmlspecialchars($laptop['purchase_date']); ?>" required>
    </div>
    <div class="form-group">
        <label for="keterangan">Keterangan</label>
        <input type="text" class="form-control" id="keterangan" name="keterangan" value="<?php echo htmlspecialchars($laptop['keterangan']); ?>" required>    </div>
    <div class="form-group">
        <label for="images">Upload New Images</label>
        <input type="file" class="form-control-file" id="images" name="images[]" multiple>
        <div id="image_preview" class="row mt-3"></div>
    </div>
    <button type="submit" class="btn btn-primary">Update</button>
</form>

<?php include 'footer.php'; ?>