<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: html/login.html");
    exit();
}
require_once 'Backend/dbconn.php';

// Dodavanje nove ankete
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pitanje'])) {
    $pitanje = trim($_POST['pitanje']);
    if ($pitanje !== '') {
        $stmt = $conn->prepare("INSERT INTO ankete (pitanje) VALUES (?)");
        $stmt->execute([$pitanje]);
    }
}

// Prikaz svih anketa
$ankete = $conn->query("SELECT * FROM ankete ORDER BY vreme_kreiranja DESC")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin - Ankete</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Kreiraj novu anketu</h2>
    <form method="POST" class="mb-4">
        <input type="text" name="pitanje" class="form-control mb-2" placeholder="Unesi pitanje ankete" required>
        <button type="submit" class="btn btn-primary">Kreiraj anketu</button>
    </form>
    <h3>Postojeće ankete</h3>
    <ul class="list-group">
        <?php foreach ($ankete as $a): ?>
            <li class="list-group-item"><?= htmlspecialchars($a['pitanje']) ?> <?= $a['aktivna'] ? '(Aktivna)' : '(Neaktivna)' ?></li>
        <?php endforeach; ?>
    </ul>
</div>
</body>
</html> 