<?php
session_start();

if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'izvodjac') {
    header('Location: index.html');
    exit();
}
require_once 'Backend/dbconn.php';
$izvodjac_ime = $_SESSION['user_name'];

// Broj komentara
$stmt = $conn->prepare("SELECT COUNT(*) FROM komentari WHERE izvodjac = ?");
$stmt->execute([$izvodjac_ime]);
$broj_komentara = $stmt->fetchColumn();

// Prosecna ocena
$stmt = $conn->prepare("SELECT AVG(ocena) FROM ocene WHERE izvodjac = ?");
$stmt->execute([$izvodjac_ime]);
$prosecna_ocena = $stmt->fetchColumn();
$prosecna_ocena = $prosecna_ocena ? round($prosecna_ocena, 2) : 'N/A';

// Broj omiljenih
$stmt = $conn->prepare("SELECT COUNT(*) FROM omiljeni_izvodjaci WHERE izvodjac = ?");
$stmt->execute([$izvodjac_ime]);
$broj_omiljenih = $stmt->fetchColumn();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Statistika popularnosti</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4 text-black text-center">Statistika popularnosti</h2>
    <ul class="list-group">
        <li class="list-group-item">Broj komentara: <b><?= $broj_komentara ?></b></li>
        <li class="list-group-item">Prosečna ocena: <b><?= $prosecna_ocena ?></b></li>
        <li class="list-group-item">Broj korisnika koji su vas dodali u omiljene: <b><?= $broj_omiljenih ?></b></li>
    </ul>
</div>
</body>
</html> 