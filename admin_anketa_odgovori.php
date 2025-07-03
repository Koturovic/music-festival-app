<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: html/login.html");
    exit();
}
require_once 'Backend/dbconn.php';

// Prikaz svih anketa
$ankete = $conn->query("SELECT * FROM ankete ORDER BY vreme_kreiranja DESC")->fetchAll(PDO::FETCH_ASSOC);
$odgovori = [];
if (isset($_GET['anketa_id'])) {
    $anketa_id = intval($_GET['anketa_id']);
    $stmt = $conn->prepare("SELECT * FROM anketa_odgovori WHERE anketa_id = ? ORDER BY vreme DESC");
    $stmt->execute([$anketa_id]);
    $odgovori = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Odgovori na ankete</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Odgovori na ankete</h2>
    <form method="get" class="mb-4">
        <label for="anketa_id">Izaberi anketu:</label>
        <select name="anketa_id" id="anketa_id" class="form-control d-inline-block w-auto mx-2">
            <?php foreach ($ankete as $a): ?>
                <option value="<?= $a['id'] ?>" <?= (isset($_GET['anketa_id']) && $_GET['anketa_id'] == $a['id']) ? 'selected' : '' ?>><?= htmlspecialchars($a['pitanje']) ?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit" class="btn btn-primary btn-sm">Prikaži odgovore</button>
    </form>
    <?php if ($odgovori): ?>
        <ul class="list-group">
            <?php foreach ($odgovori as $o): ?>
                <li class="list-group-item">
                    <?php
                    if ($o['korisnik_id']) {
                        $stmt_ime = $conn->prepare("SELECT name FROM posetioci WHERE id = ?");
                        $stmt_ime->execute([$o['korisnik_id']]);
                        $ime_korisnika = $stmt_ime->fetchColumn();
                        $prikaz_ime = $ime_korisnika ? htmlspecialchars($ime_korisnika) : 'Nepoznat korisnik';
                    } else {
                        $prikaz_ime = 'Gost';
                    }
                    ?>
                    <b>Korisnik:</b> <?= $prikaz_ime ?> <br>
                    <b>Odgovor:</b> <?= htmlspecialchars($o['odgovor']) ?> <br>
                    <span class="text-muted">Vreme: <?= htmlspecialchars($o['vreme']) ?></span>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php elseif(isset($_GET['anketa_id'])): ?>
        <div class="alert alert-info">Nema odgovora za ovu anketu.</div>
    <?php endif; ?>
</div>
</body>
</html> 