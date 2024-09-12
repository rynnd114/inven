<?php
session_start();
session_unset();
session_destroy();

header("Location: /inven/pegawai/login.php");
exit;
?>
