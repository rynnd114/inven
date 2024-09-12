<?php
require '../../../config/database.php';
require '../../../config/configure.php';

$query = $pdo->query("SELECT * FROM furniture WHERE room = 'Komputasi'");
$furnitures = $query->fetchAll(PDO::FETCH_ASSOC);

include '../../../component/header.php';
?>

<h1 class="h3 mb-4 text-gray-800">Furniture List in Komputasi</h1>
<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No.</th>
                <th>ID</th>
                <th>Nama Furniture</th>
                <th>Merk</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $counter = 1;
            foreach ($furnitures as $furniture) :
            ?>
                <tr class="clickable-row" data-href="detail.php?id=<?php echo $furniture['id']; ?>">
                    <td><?php echo $counter; ?></td>
                    <td><?php echo htmlspecialchars($furniture['id']); ?></td>
                    <td><?php echo htmlspecialchars($furniture['nama_furniture']); ?></td>
                    <td><?php echo htmlspecialchars($furniture['merk']); ?></td>
                </tr>
            <?php
                $counter++;
            endforeach;
            ?>
        </tbody>
    </table>
</div>

<?php include '../../../component/footer.php'; ?>
