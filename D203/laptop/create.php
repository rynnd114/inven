<?php
require '../../config/database.php';
require '../../middleware.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $room = isset($_POST['room']) ? $_POST['room'] : 'D203'; // Nilai default 'D203' jika tidak ada input
    $brand = $_POST['brand'];
    $model = $_POST['model'];
    $serial_number = $_POST['serial_number'];
    $purchase_date = $_POST['purchase_date'];
    $images = $_POST['images'];

    // Prepare data for insertion
    $sql = "INSERT INTO laptops (room, brand, model, serial_number, purchase_date, images) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$room, $brand, $model, $serial_number, $purchase_date, $images]);
    
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
    file_put_contents('../../uploads/' . $qrFileName, $response);

    header("Location: index.php");
}
include '../../component/header.php';
?>

<h1 class="h3 mb-4 text-gray-800">Add New Laptop</h1>
<form method="post" class="mb-4">
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
        <label>Images</label>
        <input type="file" name="images" class="form-control" multiple>
    </div>
    <button type="submit" class="btn btn-primary">Add</button>
</form>

<?php include '../../component/footer.php'; ?>