<?php
require 'config/database.php';

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM update_history WHERE laptop_id = ? ORDER BY updated_at DESC");
$stmt->execute([$id]);
$history = $stmt->fetchAll(PDO::FETCH_ASSOC);

include 'header.php';
?>

<h1 class="h3 mb-4 text-gray-800">Update History</h1>
<a href="index.php" class="btn btn-secondary mb-3">Back to Inventory List</a>
<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No.</th> <!-- Kolom tambahan untuk nomor urut -->
                <th>ID</th>
                <th>Old Brand</th>
                <th>Old Model</th>
                <th>Old Serial Number</th>
                <th>Old Purchase Date</th>
                <th>Updated At</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            $counter = 1; // Inisialisasi variabel counter untuk nomor urut
            foreach ($history as $entry): ?>
            <tr>
                <td><?php echo $counter; ?></td> <!-- Tampilkan nomor urut -->
                <td><?php echo htmlspecialchars($entry['id']); ?></td>
                <td><?php echo htmlspecialchars($entry['old_brand']); ?></td>
                <td><?php echo htmlspecialchars($entry['old_model']); ?></td>
                <td><?php echo htmlspecialchars($entry['old_serial_number']); ?></td>
                <td><?php echo htmlspecialchars($entry['old_purchase_date']); ?></td>
                <td><?php echo htmlspecialchars($entry['updated_at']); ?></td>
            </tr>
            <?php 
            $counter++; // Increment counter setiap kali baris data selesai diproses
            endforeach; ?>
        </tbody>
    </table>
</div>

<?php include 'footer.php'; ?>
