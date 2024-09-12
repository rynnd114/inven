<?php
require '../../../config/database.php';
require '../../../config/configure.php';

$query = $pdo->query("SELECT * FROM furniture WHERE room = 'D208'");
$furnitures = $query->fetchAll(PDO::FETCH_ASSOC);

include '../../../component/header.php';
?>

<h1 class="h3 mb-4 text-gray-800">Furniture List in D208</h1>
<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No.</th>
                <th>ID</th>
                <th>Nama Furniture</th>
                <th>Merk</th>
                <th>Jumlah</th>
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
                    <td><?php echo htmlspecialchars($furniture['jumlah']); ?></td>

                </tr>
            <?php
                $counter++;
            endforeach;
            ?>
        </tbody>
    </table>
</div>

<?php include '../../../component/footer.php'; ?>
