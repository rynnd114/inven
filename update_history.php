<?php
require 'config/database.php';

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM laptops WHERE id = ?");
$stmt->execute([$id]);
$laptop = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $brand = $_POST['brand'];
    $model = $_POST['model'];
    $serial_number = $_POST['serial_number'];
    $purchase_date = $_POST['purchase_date'];

    // Simpan data lama ke tabel update_history
    $sql = "INSERT INTO update_history (laptop_id, old_brand, old_model, old_serial_number, old_purchase_date) VALUES (?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id, $laptop['brand'], $laptop['model'], $laptop['serial_number'], $laptop['purchase_date']]);

    // Update data di tabel laptops
    $sql = "UPDATE laptops SET brand = ?, model = ?, serial_number = ?, purchase_date = ? WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$brand, $model, $serial_number, $purchase_date, $id]);

    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Laptop</title>
</head>
<body>
    <h1>Edit Laptop</h1>
    <form method="post">
        <label>Brand:</label>
        <input type="text" name="brand" value="<?php echo htmlspecialchars($laptop['brand']); ?>" required><br>
        <label>Model:</label>
        <input type="text" name="model" value="<?php echo htmlspecialchars($laptop['model']); ?>" required><br>
        <label>Serial Number:</label>
        <input type="text" name="serial_number" value="<?php echo htmlspecialchars($laptop['serial_number']); ?>" required><br>
        <label>Purchase Date:</label>
        <input type="date" name="purchase_date" value="<?php echo htmlspecialchars($laptop['purchase_date']); ?>" required><br>
        <input type="submit" value="Update">
    </form>
</body>
</html>
