<?php
require 'config/database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $brand = $_POST['brand'];
    $model = $_POST['model'];
    $serial_number = $_POST['serial_number'];
    $purchase_date = $_POST['purchase_date'];

    $sql = "INSERT INTO laptops (brand, model, serial_number, purchase_date) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$brand, $model, $serial_number, $purchase_date]);

    header("Location: index.php");
}

include 'header.php';
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
    <button type="submit" class="btn btn-primary">Add</button>
</form>

<?php include 'footer.php'; ?>
