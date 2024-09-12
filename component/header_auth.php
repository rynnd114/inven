<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>SB-Admin 2 - Auth</title>
    <link href="style/css/sb-admin-2.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #FFA500; /* Warna oranye */
        }
        .btn-primary {
            background-color: #FFA500;
            border-color: #FFA500;
        }
        .btn-primary:hover {
            background-color: #FF8C00;
            border-color: #FF8C00;
        }
        .card {
            border-color: #FFA500;
        }
        .text-primary {
            color: #FFA500 !important;
        }
    </style>
    <!-- Tambahkan CSS lain jika diperlukan -->
</head>
<body class="bg-gradient">

<div class="container">
