<?php
require '../config/database.php';
require '../config/configure.php';
require '../../middleware.php';


$query = $pdo->query("SELECT * FROM laptops WHERE room = 'D208'");
$laptops = $query->fetchAll(PDO::FETCH_ASSOC);

include '../component/header.php';
?>

<h1 class="h3 mb-4 text-gray-800">Inventory List</h1>
<a href="create.php" class="btn btn-primary mb-3">Add New Laptop</a>
<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No.</th>
                <th>ID</th>
                <th>Brand</th>
                <th>Model</th>
                <th>Serial Number</th>
                <th>Purchase Date</th>
                <th>Keterangan</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $counter = 1;
            foreach ($laptops as $laptop) :
            ?>
                <tr class="clickable-row" data-href="detail.php?id=<?php echo $laptop['id']; ?>">
                    <td><?php echo $counter; ?></td>
                    <td><?php echo htmlspecialchars($laptop['id']); ?></td>
                    <td><?php echo htmlspecialchars($laptop['brand']); ?></td>
                    <td><?php echo htmlspecialchars($laptop['model']); ?></td>
                    <td><?php echo htmlspecialchars($laptop['serial_number']); ?></td>
                    <td><?php echo htmlspecialchars(formatTanggal($laptop['purchase_date']))?></td>
                    <td><?php echo htmlspecialchars($laptop['keterangan']); ?></td>
                    <td>
                        <a href="update.php?id=<?php echo $laptop['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="delete.php?id=<?php echo $laptop['id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                        <a href="history.php?id=<?php echo $laptop['id']; ?>" class="btn btn-info btn-sm">View History</a>
                    </td>
                </tr>
            <?php
                $counter++;
            endforeach;
            ?>
        </tbody>
    </table>
</div>

<?php include '../component/footer.php'; ?>
