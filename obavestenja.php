<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: html/login.html");
    exit();
}
require_once 'Backend/dbconn.php';
$user_id = $_SESSION['user_id'];

$conn->prepare("UPDATE obavestenja SET procitano = 1 WHERE korisnik_id = ?")->execute([$user_id]);

$stmt = $conn->prepare("SELECT * FROM obavestenja WHERE korisnik_id = ? ORDER BY vreme DESC");
$stmt->execute([$user_id]);
$obavestenja = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Obaveštenja</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Vaša obaveštenja</h2>
    <ul class="list-group">
        <?php foreach ($obavestenja as $o): ?>
            <li class="list-group-item<?= $o['procitano'] ? '' : ' list-group-item-info' ?>">
                <?= htmlspecialchars($o['poruka']) ?>
                <span class="text-muted float-end"><?= date('d.m.Y H:i', strtotime($o['vreme'])) ?></span>
            </li>
        <?php endforeach; ?>
        <?php if (empty($obavestenja)): ?>
            <li class="list-group-item">Nemate obaveštenja.</li>
        <?php endif; ?>
    </ul>
</div>
</body>
</html> 