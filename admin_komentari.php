<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: html/login.html");
    exit();
}
require_once 'Backend/dbconn.php';


if (isset($_POST['obrisi_komentar']) && isset($_POST['komentar_id'])) {
    $stmt = $conn->prepare("DELETE FROM komentari WHERE id = ?");
    $stmt->execute([$_POST['komentar_id']]);
    header("Location: admin_komentari.php");
    exit();
}


$stmt = $conn->query("SELECT * FROM komentari ORDER BY id DESC");
$komentari = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin - Komentari</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4">Svi komentari</h2>
    <table class="table table-dark table-hover">
        <thead>
            <tr>
                
                <th>Izvođač</th>
                <th>Korisnik</th>
                <th>Komentar</th>
                <th>Odgovor izvođača</th>
                <th>Akcija</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($komentari as $k): ?>
                <tr>
                    
                    <td><?= htmlspecialchars($k['izvodjac']) ?></td>
                    <td><?= htmlspecialchars($k['korisnik']) ?></td>
                    <td><?= htmlspecialchars($k['komentar']) ?></td>
                    <td><?= htmlspecialchars($k['odgovor_izvodjaca'] ?? '') ?></td>
                    <td>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="komentar_id" value="<?= $k['id'] ?>">
                            <button type="submit" name="obrisi_komentar" class="btn btn-danger btn-sm" onclick="return confirm('Obrisati komentar?')">Obriši</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($komentari)): ?>
                <tr><td colspan="5">Nema komentara za prikaz.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>