<?php
session_start();
require_once 'Backend/dbconn.php';

$rezultati = [];
$kriterijumi = [
    'zanr' => 'Žanr',
    'datum' => 'Vreme nastupa',
    'scena' => 'Scena'
];
$izabrani = isset($_GET['kriterijum']) ? $_GET['kriterijum'] : 'zanr';
$pojam = isset($_GET['pojam']) ? trim($_GET['pojam']) : '';

if ($pojam !== '' && isset($kriterijumi[$izabrani])) {
    if ($izabrani === 'datum') {
        // Pretraga po datumu (vreme nastupa)
        $stmt = $conn->prepare("SELECT * FROM dogadjaji WHERE datum LIKE ?");
        $stmt->execute(["%$pojam%"]);
    } else {
        $stmt = $conn->prepare("SELECT * FROM dogadjaji WHERE $izabrani LIKE ?");
        $stmt->execute(["%$pojam%"]);
    }
    $rezultati = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="sr">
<head>
    <meta charset="UTF-8">
    <title>Pretraga izvođača</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4">Pretraži izvođače po kriterijumu</h2>
    <form method="get" class="row g-3 align-items-center mb-4">
        <div class="col-auto">
            <label for="kriterijum" class="col-form-label">Pretraži po:</label>
        </div>
        <div class="col-auto">
            <select name="kriterijum" id="kriterijum" class="form-select">
                <?php foreach ($kriterijumi as $key => $label): ?>
                    <option value="<?= $key ?>" <?= $izabrani === $key ? 'selected' : '' ?>><?= $label ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-auto">
            <input type="text" name="pojam" class="form-control" placeholder="Unesite..." value="<?= htmlspecialchars($pojam) ?>">
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-primary">Pretraži</button>
        </div>
    </form>

    <?php if ($pojam !== ''): ?>
        <h4>Rezultati pretrage:</h4>
        <?php if ($rezultati): ?>
            <table class="table table-dark table-hover">
                <thead>
                    <tr>
                        <th>Izvođač</th>
                        <th>Žanr</th>
                        <th>Datum</th>
                        <th>Scena</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rezultati as $r): ?>
                        <tr>
                            <td><?= htmlspecialchars($r['izvodjac']) ?></td>
                            <td><?= htmlspecialchars($r['zanr']) ?></td>
                            <td><?= date('d.m.Y', strtotime($r['datum'])) ?></td>
                            <td><?= htmlspecialchars($r['scena']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="alert alert-warning">Nema rezultata za zadatu pretragu.</div>
        <?php endif; ?>
    <?php endif; ?>
</div>
</body>
</html>
