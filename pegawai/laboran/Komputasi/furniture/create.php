<?php
require '../../../../config/database.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_furniture = $_POST['nama_furniture'];
    $merk = $_POST['merk'];
    $jumlah = $_POST['jumlah'];
    $room = isset($_POST['room']) ? $_POST['room'] : 'Komputasi';
    $image = $_FILES['image']['name'];

    // Upload image
    move_uploaded_file($_FILES['image']['tmp_name'], '../../../../uploads/' . $image);

    // Prepare data for insertion
    $sql = "INSERT INTO furniture (nama_furniture, merk, jumlah, room, image) VALUES (?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nama_furniture, $merk, $jumlah, $room, $image]);

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

<h1 class="h3 mb-4 text-gray-800">Add New Furniture</h1>
<form method="post" class="mb-4" enctype="multipart/form-data">
    <div class="form-group">
        <label>Nama Furniture</label>
        <input type="text" name="nama_furniture" class="form-control" required>
    </div>
    <div class="form-group">
        <label>Merk</label>
        <input type="text" name="merk" class="form-control" required>
    </div>
    <div class="form-group">
        <label>Jumlah</label>
        <input type="number" name="jumlah" class="form-control" required>
    </div>
    <div class="form-group">
        <label>Image</label>
        <input type="file" name="image" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary">Add</button>
</form>

<?php include '../../../../component/footer.php'; ?>