<?php
session_start();
require_once 'Backend/dbconn.php';
// Prikaz samo aktivne ankete
$anketa = $conn->query("SELECT * FROM ankete WHERE aktivna = 1 ORDER BY vreme_kreiranja DESC LIMIT 1")->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['odgovor'], $_POST['anketa_id'])) {
    $odgovor = trim($_POST['odgovor']);
    $anketa_id = intval($_POST['anketa_id']);
    $korisnik_id = $_SESSION['user_id'] ?? null;
    if ($odgovor !== '') {
        $stmt = $conn->prepare("INSERT INTO anketa_odgovori (anketa_id, korisnik_id, odgovor) VALUES (?, ?, ?)");
        $stmt->execute([$anketa_id, $korisnik_id, $odgovor]);
        $poruka = "Hvala na odgovoru!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Anketa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <?php if (isset($poruka)) echo '<div class="alert alert-success">'.$poruka.'</div>'; ?>
    <?php if ($anketa): ?>
        <h2><?= htmlspecialchars($anketa['pitanje']) ?></h2>
        <form method="POST">
            <input type="hidden" name="anketa_id" value="<?= $anketa['id'] ?>">
            <textarea name="odgovor" class="form-control mb-2" placeholder="Vaš odgovor..." required></textarea>
            <button type="submit" class="btn btn-primary">Pošalji odgovor</button>
        </form>
    <?php else: ?>
        <div class="alert alert-info">Trenutno nema aktivnih anketa.</div>
    <?php endif; ?>
</div>
</body>
</html> 