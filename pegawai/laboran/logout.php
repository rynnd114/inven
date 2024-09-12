<?php
session_start();
session_unset();
session_destroy();

header("Location: /inven/pegawai/laboran/login.php");
exit;
?>
