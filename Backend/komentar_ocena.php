<?php
session_start();
require_once 'dbconn.php';

if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_name'])) {
    http_response_code(403);
    echo 'Niste prijavljeni.';
    exit();
}

$korisnik = $_SESSION['user_name'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['komentar']) && isset($_POST['izvodjac'])) {
        // Upis komentara
        $izvodjac = $_POST['izvodjac'];
        $komentar = $_POST['komentar'];
        $stmt = $conn->prepare("INSERT INTO komentari (izvodjac, korisnik, komentar) VALUES (?, ?, ?)");
        $stmt->execute([$izvodjac, $korisnik, $komentar]);
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }
    if (isset($_POST['ocena']) && isset($_POST['izvodjac'])) {
        // Upis ocene
        $izvodjac = $_POST['izvodjac'];
        $ocena = intval($_POST['ocena']);
        $stmt = $conn->prepare("INSERT INTO ocene (izvodjac, korisnik, ocena) VALUES (?, ?, ?)");
        $stmt->execute([$izvodjac, $korisnik, $ocena]);
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }
}
// Ako nije POST ili fali podatak
http_response_code(400);
echo 'Neispravan zahtev.'; 