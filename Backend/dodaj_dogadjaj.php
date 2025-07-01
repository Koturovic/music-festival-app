<?php
session_start();
require_once 'dbconn.php';

if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'organizator') {
    header('Location: ../index.html');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $datum = trim($_POST['datum']);
    $scena = trim($_POST['scena']);
    $zanr = trim($_POST['zanr']);
    $izvodjac = trim($_POST['izvodjac']);

    if (empty($datum) || empty($scena) || empty($zanr) || empty($izvodjac)) {
        die('Sva polja su obavezna!');
    }

    try {
        $stmt = $conn->prepare('INSERT INTO dogadjaji (datum, scena, zanr, izvodjac) VALUES (?, ?, ?, ?)');
        $stmt->execute([$datum, $scena, $zanr, $izvodjac]);
        header('Location: ../organizator_edit.php');
        exit();
    } catch (PDOException $e) {
        die('Greška pri unosu: ' . $e->getMessage());
    }
} else {
    header('Location: ../organizator_edit.php');
    exit();
}
