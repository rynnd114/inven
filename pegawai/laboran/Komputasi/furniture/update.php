<?php
require '../../../../config/database.php';


$id = $_GET['id'];
$query = $pdo->prepare("SELECT * FROM furniture WHERE id = ?");
$query->execute([$id]);
$furniture = $query->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_furniture = $_POST['nama_furniture'];
    $merk = $_POST['merk'];
    $jumlah = $_POST['jumlah'];
    $keterangan = $_POST['keterangan'];

    // Handle file uploads
    $uploadedImages = [];
    if (!empty($_FILES['image']['name'][0])) {
        $totalFiles = count($_FILES['image']['name']);
        for ($i = 0; $i < $totalFiles; $i++) {
            $fileName = $_FILES['image']['name'][$i];
            $fileTmpName = $_FILES['image']['tmp_name'][$i];
            $fileDestination = '../../../../uploads/' . $fileName;
            if (move_uploaded_file($fileTmpName, $fileDestination)) {
                $uploadedImages[] = $fileName;
            }
        }
    }

    // Merge existing and new images
    $existingImages = json_decode($furniture['image'] ?? '[]', true);
    if (!is_array($existingImages)) {
        $existingImages = [];
    }
    $allImages = array_merge($existingImages, $uploadedImages);
    $imagesJson = !empty($allImages) ? json_encode($allImages) : $furniture['image'];

    // Insert into history
    $sql = "INSERT INTO furniture_history (furniture_id, nama_furniture, merk, jumlah, image, keterangan, changed_at) VALUES (?, ?, ?, ?, ?, ?, NOW())";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id, $furniture['nama_furniture'], $furniture['merk'], $furniture['jumlah'], $furniture['image'], $furniture['keterangan']]);

    // Update furniture
    $query = $pdo->prepare("UPDATE furniture SET nama_furniture = ?, merk = ?, jumlah = ?, image = ?, keterangan = ? WHERE id = ?");
    $query->execute([$nama_furniture, $merk, $jumlah, $imagesJson, $keterangan, $id]);

    header("Location: detail.php?id=$id");
    exit;
}
?>

<?php include '../../../../component/header.php'; ?>

<h1 class="h3 mb-4 text-gray-800">Edit Furniture</h1>
<form action="update.php?id=<?php echo $id; ?>" method="POST" enctype="multipart/form-data">
    <div class="form-group">
        <label for="nama_furniture">Nama Furniture</label>
        <input type="text" class="form-control" id="nama_furniture" name="nama_furniture" value="<?php echo htmlspecialchars($furniture['nama_furniture']); ?>" required>
    </div>
    <div class="form-group">
        <label for="merk">Merk</label>
        <input type="text" class="form-control" id="merk" name="merk" value="<?php echo htmlspecialchars($furniture['merk']); ?>" required>
    </div>
    <div class="form-group">
        <label for="jumlah">Jumlah</label>
        <input type="number" class="form-control" id="jumlah" name="jumlah" value="<?php echo htmlspecialchars($furniture['jumlah']); ?>" required>
    </div>
    <div class="form-group">
        <label for="keterangan">Keterangan</label>
        <input type="text" class="form-control" id="keterangan" name="keterangan" value="<?php echo htmlspecialchars($furniture['keterangan']); ?>" required>
    </div>
    <div class="form-group">
        <label for="image">Upload New Images</label>
        <input type="file" class="form-control-file" id="image" name="image[]" multiple>
        <div id="image_preview" class="row mt-3"></div>
    </div>
    <button type="submit" class="btn btn-primary">Update</button>
</form>

<?php include '../../../../component/footer.php'; ?>
