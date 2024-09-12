<?php
require '../../../../config/database.php';

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
    $ram = $_POST['ram'];
    $memori = $_POST['memori'];
    $os = $_POST['os'];
    $processor = $_POST['processor'];
    $layar = $_POST['layar'];
    $kondisi = $_POST['kondisi'];

    // Handle file uploads
    $uploadedImages = [];
    if (!empty($_FILES['images']['name'][0])) {
        $totalFiles = count($_FILES['images']['name']);
        for ($i = 0; $i < $totalFiles; $i++) {
            $fileName = $_FILES['images']['name'][$i];
            $fileTmpName = $_FILES['images']['tmp_name'][$i];
            $fileDestination = '../../../../uploads/' . $fileName;
            if (move_uploaded_file($fileTmpName, $fileDestination)) {
                $uploadedImages[] = $fileName;
            }
        }
    }

    // Merge existing and new images
    $existingImages = json_decode($laptop['images'] ?? '[]', true);
    if (!is_array($existingImages)) {
        $existingImages = [];
    }
    $allImages = array_merge($existingImages, $uploadedImages);
    $imagesJson = !empty($allImages) ? json_encode($allImages) : $laptop['images'];

    $sql = "INSERT INTO laptop_history (laptop_id, brand, model, serial_number, purchase_date, images, keterangan, ram, memori, os, processor, layar, kondisi, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id, $laptop['brand'], $laptop['model'], $laptop['serial_number'], $laptop['purchase_date'], $laptop['images'], $laptop['keterangan'], $laptop['ram'], $laptop['memori'], $laptop['os'], $laptop['processor'], $laptop['layar'], $laptop['kondisi']]);

    $query = $pdo->prepare("UPDATE laptops SET brand = ?, model = ?, serial_number = ?, purchase_date = ?, images = ?, keterangan = ?, ram = ?, memori = ?, os = ?, processor = ?, layar = ?, kondisi = ? WHERE id = ?");
    $query->execute([$brand, $model, $serial_number, $purchase_date, $imagesJson, $keterangan, $ram, $memori, $os, $processor, $layar, $kondisi, $id]);

    header("Location: detail.php?id=$id");
    exit;
}
?>

<?php include '../../../../component/header.php'; ?>

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
        <label for="ram">RAM</label>
        <input type="text" class="form-control" id="ram" name="ram" value="<?php echo htmlspecialchars($laptop['ram']); ?>" required>
    </div>
    <div class="form-group">
        <label for="memori">Memory</label>
        <input type="text" class="form-control" id="memori" name="memori" value="<?php echo htmlspecialchars($laptop['memori']); ?>" required>
    </div>
    <div class="form-group">
        <label for="os">Operating System</label>
        <input type="text" class="form-control" id="os" name="os" value="<?php echo htmlspecialchars($laptop['os']); ?>" required>
    </div>
    <div class="form-group">
        <label for="processor">Processor</label>
        <input type="text" class="form-control" id="processor" name="processor" value="<?php echo htmlspecialchars($laptop['processor']); ?>" required>
    </div>
    <div class="form-group">
        <label for="layar">Screen</label>
        <input type="text" class="form-control" id="layar" name="layar" value="<?php echo htmlspecialchars($laptop['layar']); ?>" required>
    </div>
    <div class="form-group">
        <label for="kondisi">Condition</label>
        <input type="text" class="form-control" id="kondisi" name="kondisi" value="<?php echo htmlspecialchars($laptop['kondisi']); ?>" required>
    </div>
    <div class="form-group">
        <label for="keterangan">Keterangan</label>
        <input type="text" class="form-control" id="keterangan" name="keterangan" value="<?php echo htmlspecialchars($laptop['keterangan']); ?>" required>
    </div>
    <div class="form-group">
        <label for="images">Upload New Images</label>
        <input type="file" class="form-control-file" id="images" name="images[]" multiple>
        <div id="image_preview" class="row mt-3"></div>
    </div>
    <button type="submit" class="btn btn-primary">Update</button>
</form>

<?php include '../../../../component/footer.php'; ?>
