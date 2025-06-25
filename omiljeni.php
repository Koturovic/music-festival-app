<?php
session_start();

// var_dump($_SESSION);
if (!isset($_SESSION['user_id'])) {
    header("Location: html/login.html");
    exit();
}
require_once 'Backend/dbconn.php';
$korisnik = $_SESSION['user_id'];
try {
    $stmt = $conn->prepare("SELECT izvodjac FROM omiljeni_izvodjaci WHERE korisnik = ?");
    $stmt->execute([$korisnik]);
    $omiljeni_izvodjaci = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "<div style='color:red'>Greška u upitu: " . $e->getMessage() . "</div>";
    $omiljeni_izvodjaci = [];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="style.css">
    <title>Vaši omiljeni izvođači</title>
</head>
<a href="nastupi.php" class="btn btn-secondary mb-4" style="position:absolute; top:24px; left:36px;">
    ← Nazad na nastupe
</a>
<body>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <div class="container mt-5 dogadjaji-section">
        <h2 class="mb-4 text-black text-center">LISTA OMILJENIH IZVOĐAČA</h2>
        <table class="table table-dark table-hover dogadjaji-table" style="opacity:0.95;">
            <thead>
                <tr>
                  
                  <th class="text-start">Izvođač</th>
                  <th class="text-center"></th>

                  
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($omiljeni_izvodjaci)): ?>
                   
                    <?php $rb = 1; foreach ($omiljeni_izvodjaci as $d): ?>
                    <tr>
                        
                        <td><?= $rb++ ?>. <?= htmlspecialchars($d['izvodjac']) ?></td>
                        <td class="text-end">
                            <form method="POST" action="Backend/ukloni_omiljeni.php" class="d-inline">
                                <input type="hidden" name="izvodjac" value="<?= htmlspecialchars($d['izvodjac']) ?>">
                                <button type="button" class="btn btn-danger btn-sm ukloni-btn" data-izvodjac="<?= htmlspecialchars($d['izvodjac']) ?>">Ukloni</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="4" class="text-center">Nema omiljenih izvođača za prikaz.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <script src="html/js/ukloni_iz_omiljenih.js">
   </script>
    
</body>
</html>