<?php
require '../../../../config/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $room = isset($_POST['room']) ? $_POST['room'] : 'D203'; // Nilai default 'D203' jika tidak ada input
    $brand = $_POST['brand'];
    $model = $_POST['model'];
    $serial_number = $_POST['serial_number'];
    $purchase_date = $_POST['purchase_date'];
    $keterangan = isset($_POST['keterangan']) ? $_POST['keterangan'] : 'Original';
    $ram = $_POST['ram'];
    $memori = $_POST['memori'];
    $os = $_POST['os'];
    $processor = $_POST['processor'];
    $layar = $_POST['layar'];
    $kondisi = isset($_POST['kondisi']) ? $_POST['kondisi'] : 'Baik';

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
    $imagesJson = !empty($uploadedImages) ? json_encode($uploadedImages) : '';

    // Prepare data for insertion
    $sql = "INSERT INTO laptops (room, brand, model, serial_number, purchase_date, images, keterangan, ram, memori, os, processor, layar, kondisi) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$room, $brand, $model, $serial_number, $purchase_date, $imagesJson, $keterangan, $ram, $memori, $os, $processor, $layar, $kondisi]);
    
    // Get the ID of the inserted record
    $lastInsertId = $pdo->lastInsertId();

    // Generate QR code URL using the API
    $qr_code_text = "https://lab-invent.my.id/generate_pdf.php?id=" . $lastInsertId; // Replace with your actual URL
    $qr_code_url = "https://api.qrserver.com/v1/create-qr-code/?data=" . urlencode($qr_code_text) . "&size=150x150";

    // Save the generated QR code to a file
    $qrImageData = file_get_contents($qr_code_url);
    $qrFileName = 'qr_' . $lastInsertId . '.png';
    file_put_contents('../../../../uploads/' . $qrFileName, $qrImageData);

    header("Location: index.php");
}
include '../../../../component/header.php';
?>

<h1 class="h3 mb-4 text-gray-800">Add New Laptop</h1>
<form method="post" enctype="multipart/form-data" class="mb-4">
    <div class="form-group">
        <label>Brand</label>
        <input type="text" name="brand" class="form-control" required>
    </div>
    <div class="form-group">
        <label>Model</label>
        <input type="text" name="model" class="form-control" required>
    </div>
    <div class="form-group">
        <label>Serial Number</label>
        <input type="text" name="serial_number" class="form-control" required>
    </div>
    <div class="form-group">
        <label>Purchase Date</label>
        <input type="date" name="purchase_date" class="form-control" required>
    </div>
    <div class="form-group">
        <label>RAM</label>
        <input type="text" name="ram" class="form-control" required>
    </div>
    <div class="form-group">
        <label>Memori</label>
        <input type="text" name="memori" class="form-control" required>
    </div>
    <div class="form-group">
        <label>OS</label>
        <input type="text" name="os" class="form-control" required>
    </div>
    <div class="form-group">
        <label>Processor</label>
        <input type="text" name="processor" class="form-control" required>
    </div>
    <div class="form-group">
        <label>Layar</label>
        <input type="text" name="layar" class="form-control" required>
    </div>
    <div class="form-group">
        <label>Images</label>
        <input type="file" name="images[]" class="form-control" multiple>
    </div>
    <button type="submit" class="btn btn-primary">Add</button>
</form>

<?php include '../../../../component/footer.php'; ?>
