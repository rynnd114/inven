<?php
require '../config/database.php';
require '../../middleware.php';


$id = $_GET['id'];
$query = $pdo->prepare("SELECT * FROM update_history WHERE laptop_id = ?");
$query->execute([$id]);
$history = $query->fetchAll(PDO::FETCH_ASSOC);

$laptopQuery = $pdo->prepare("SELECT * FROM laptops WHERE id = ?");
$laptopQuery->execute([$id]);
$laptop = $laptopQuery->fetch(PDO::FETCH_ASSOC);
$existingImages = json_decode($laptop['images'] ?? '[]', true);

?>
<?php include '../component/header.php'; ?>

<h1 class="h3 mb-4 text-gray-800">Update History</h1>
<div class="card mb-4">
    <div class="card-body">
        <?php if ($history): ?>
            <?php foreach ($history as $update): ?>
                <div class="mb-3">
                    <p><strong>Old Brand:</strong> <?php echo htmlspecialchars($update['old_brand']); ?></p>
                    <p><strong>Old Model:</strong> <?php echo htmlspecialchars($update['old_model']); ?></p>
                    <p><strong>Old Serial Number:</strong> <?php echo htmlspecialchars($update['old_serial_number']); ?></p>
                    <p><strong>Old Purchase Date:</strong> <?php echo htmlspecialchars($update['old_purchase_date']); ?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No update history available.</p>
        <?php endif; ?>
    </div>
</div>

<h1 class="h3 mb-4 text-gray-800">Existing Images</h1>
<div class="row">
    <?php if ($existingImages): ?>
        <?php foreach ($existingImages as $image): ?>
            <div class="col-md-3 img-preview">
                <img src="../uploads/<?php echo htmlspecialchars($image); ?>" class="img-thumbnail">
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No existing images.</p>
    <?php endif; ?>
</div>

<?php include '../component/footer.php'; ?>
