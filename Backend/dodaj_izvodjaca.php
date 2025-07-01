<?php
session_start();
require_once 'dbconn.php';

if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'izvodjac') {
    header('Location: ../index.html');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ime = trim($_POST['ime']);
    $zanr = trim($_POST['zanr']);
    $opis = trim($_POST['opis']);
    

    if (empty($ime) || empty($zanr) || empty($opis)) {
        die('Sva polja su obavezna!');
    }

    try {
        $stmt = $conn->prepare('INSERT INTO izvodjaci (ime, zanr, opis) VALUES (?, ?, ?)');
        $stmt->execute([$ime, $zanr, $opis]);
        header('Location: ../izvodjac_edit.php');
        exit();
    } catch (PDOException $e) {
        die('Greška pri unosu: ' . $e->getMessage());
    }
} else {
    header('Location: ../izvodjac_edit.php');
    exit();
}
