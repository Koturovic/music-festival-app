<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: html/login.html");
    exit();
}
require_once 'Backend/dbconn.php';

// Blokiranje korisnika
if (isset($_POST['blokiraj']) && isset($_POST['korisnik_id'])) {
    $stmt = $conn->prepare("UPDATE posetioci SET blokiran = 1 WHERE id = ?");
    $stmt->execute([$_POST['korisnik_id']]);
    header("Location: admin_korisnici.php");
    exit();
}

// Odblokiranjeee korisnika
if (isset($_POST['odblokiraj']) && isset($_POST['korisnik_id'])) {
    $stmt = $conn->prepare("UPDATE posetioci SET blokiran = 0 WHERE id = ?");
    $stmt->execute([$_POST['korisnik_id']]);
    header("Location: admin_korisnici.php");
    exit();
}

// Prikaz svih korisnika
$stmt = $conn->query("SELECT id, name, email, blokiran FROM posetioci");
$korisnici = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin - Korisnici</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
<div class="container mt-5">
    <h2 class="mb-4">Svi korisnici</h2>
    <table class="table table-dark table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Korisničko ime</th>
                <th>Email</th>
                <th>Status</th>
                <th>Akcija</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($korisnici as $k): ?>
                <tr>
                    <td><?= $k['id'] ?></td>
                    <td><?= htmlspecialchars($k['name']) ?></td>
                    <td><?= htmlspecialchars($k['email']) ?></td>
                    <td>
                        <?php if ($k['blokiran']): ?>
                            <span class="text-danger">Blokiran</span>
                        <?php else: ?>
                            <span class="text-success">Aktivan</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if ($k['blokiran']): ?>
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="korisnik_id" value="<?= $k['id'] ?>">
                                <button type="submit" name="odblokiraj" class="btn btn-success btn-sm">Odblokiraj</button>
                            </form>
                        <?php else: ?>
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="korisnik_id" value="<?= $k['id'] ?>">
                                <button type="submit" name="blokiraj" class="btn btn-warning btn-sm" onclick="return confirm('Blokirati korisnika?')">Blokiraj</button>
                            </form>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($korisnici)): ?>
                <tr><td colspan="5">Nema korisnika za prikaz.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>