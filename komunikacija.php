<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'izvodjac') {
    header('Location: index.html');
    exit();
}
require_once 'Backend/dbconn.php';
$izvodjac_ime = $_SESSION['user_name'];

// Odgovaranje na komentar
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['komentar_id'], $_POST['odgovor'])) {
    $stmt = $conn->prepare("UPDATE komentari SET odgovor_izvodjaca = ? WHERE id = ? AND izvodjac = ?");
    $stmt->execute([trim($_POST['odgovor']), intval($_POST['komentar_id']), $izvodjac_ime]);
}

// Prikaz komentara
$stmt = $conn->prepare("SELECT * FROM komentari WHERE izvodjac = ?");
$stmt->execute([$izvodjac_ime]);
$komentari = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Komunikacija sa fanovima</title>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4 text-black text-center">Komunikacija sa fanovima</h2>
    <table class="table table-dark table-hover">
        <thead>
            <tr>
                <th>Korisnik</th>
                <th>Komentar</th>
                <th>Vaš odgovor</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($komentari as $k): ?>
                <tr>
                    <td><?= htmlspecialchars($k['korisnik']) ?></td>
                    <td><?= htmlspecialchars($k['komentar']) ?></td>
                    <td>
                        <?php if (!empty($k['odgovor_izvodjaca'])): ?>
                            <b><?= htmlspecialchars($k['odgovor_izvodjaca']) ?></b>
                        <?php else: ?>
                            <form method="POST" class="d-flex">
                                <input type="hidden" name="komentar_id" value="<?= $k['id'] ?>">
                                <input type="text" name="odgovor" class="form-control me-2" placeholder="Odgovorite..." required>
                                <button type="submit" class="btn btn-primary btn-sm">Pošalji</button>
                            </form>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html> 