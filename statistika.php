<?php
session_start();

if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || !in_array($_SESSION['role'], ['izvodjac', 'admin'])) {
    header('Location: index.php');
    exit();
}
require_once 'Backend/dbconn.php';

// Ako je admin, može da bira izvodjacaa
if ($_SESSION['role'] === 'admin') {
    // Prikupi sve izvođače
    $stmt = $conn->query("SELECT ime FROM izvodjaci");
    $svi_izvodjaci = $stmt->fetchAll(PDO::FETCH_COLUMN);
    // Izabrani izvođač
    if (isset($_GET['izvodjac']) && in_array($_GET['izvodjac'], $svi_izvodjaci)) {
        $izvodjac_ime = $_GET['izvodjac'];
    } else {
        $izvodjac_ime = $svi_izvodjaci[0] ?? '';
    }
} else {
    $izvodjac_ime = $_SESSION['user_name'];
}

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
    <?php if ($_SESSION['role'] === 'admin'): ?>
        <a href="admin_index.php" class="btn btn-secondary mb-4" style="position:absolute; top:24px; left:36px;">← Nazad na admin stranicu</a>
        <form method="get" class="mb-4 text-center">
            <label for="izvodjac">Izaberi izvođača:</label>
            <select name="izvodjac" id="izvodjac" class="form-control d-inline-block w-auto mx-2">
                <?php foreach ($svi_izvodjaci as $ime): ?>
                    <option value="<?= htmlspecialchars($ime) ?>" <?= ($izvodjac_ime === $ime) ? 'selected' : '' ?>><?= htmlspecialchars($ime) ?></option>
                <?php endforeach; ?>
            </select>
            <button type="submit" class="btn btn-primary btn-sm">Prikaži</button>
        </form>
    <?php elseif ($_SESSION['role'] === 'izvodjac'): ?>
        <a href="izvodjac_index.php" class="btn btn-secondary mb-4" style="position:absolute; top:24px; left:36px;">← Nazad na početnu</a>
    <?php endif; ?>
    <ul class="list-group">
        <li class="list-group-item">Izvođač: <strong><?= htmlspecialchars($izvodjac_ime) ?></strong></li>
        <li class="list-group-item">Broj komentara: <strong><?= $broj_komentara ?></strong></li>
        <li class="list-group-item">Prosečna ocena: <strong><?= $prosecna_ocena ?></strong></li>
        <li class="list-group-item">Broj korisnika koji su vas dodali u omiljene: <strong><?= $broj_omiljenih ?></strong></li>
    </ul>
</div>
</body>
</html> 