<?php
session_start();
require_once 'dbconn.php';

if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['admin', 'organizator'])) {
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
        
        // Kreiraj obaveštenja za korisnike koji imaju ovog izvođača u omiljenim
        $stmt = $conn->prepare("SELECT korisnik FROM omiljeni_izvodjaci WHERE izvodjac = ?");
        $stmt->execute([$izvodjac]);
        $korisnici = $stmt->fetchAll(PDO::FETCH_COLUMN);
        foreach ($korisnici as $korisnik_id) {
            $poruka = "Vaš omiljeni izvođač $izvodjac ima novi nastup $datum!";
            $stmt2 = $conn->prepare("INSERT INTO obavestenja (korisnik_id, izvodjac, poruka) VALUES (?, ?, ?)");
            $stmt2->execute([$korisnik_id, $izvodjac, $poruka]);
        }
        if ($_SESSION['role'] === 'admin') {
            header('Location: ../admin_edit.php');
        } else {
            header('Location: ../organizator_edit.php');
        }
        exit();
    } catch (PDOException $e) {
        die('Greška pri unosu: ' . $e->getMessage());
    }
} else {
    if ($_SESSION['role'] === 'admin') {
        header('Location: ../admin_edit.php');
    } else {
        header('Location: ../organizator_edit.php');
    }
    exit();
}