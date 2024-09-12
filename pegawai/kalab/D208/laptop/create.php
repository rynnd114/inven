<?php
require '../../../../config/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $room = isset($_POST['room']) ? $_POST['room'] : 'D208'; // Nilai default 'D203' jika tidak ada input
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

    // Generate QR code using the API
    $apiUrl = 'https://api.qr-code-generator.com/v1/create?access-token=JfJ24EoNdGJQofoVLxLGR3YqsJGm3PrHETTsqMWTiulL29AytvasNDnbV_jhHD_P';
    $qrData = [
        "frame_name" => "no-frame",
        "qr_code_text" => "https://lab-invent.my.id/generate_pdf.php?id=" . $lastInsertId, // Replace with your actual URL
        "image_format" => "PNG",
        "qr_code_logo" => "scan-me-square"
    ];

    $ch = curl_init($apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($qrData));
    $response = curl_exec($ch);
    curl_close($ch);

    // Save the generated QR code to a file
    $qrFileName = 'qr_' . $lastInsertId . '.png';
    file_put_contents('../../../../uploads/' . $qrFileName, $response);

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
