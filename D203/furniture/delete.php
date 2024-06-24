<?php
require '../../config/database.php';
require '../../middleware.php';


$id = $_GET['id'];
$sql = "DELETE FROM furniture WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);

header("Location: index.php");
?>
