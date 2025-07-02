<?php
session_start();

// var_dump($_SESSION);
if (!isset($_SESSION['user_id'])) {
    header("Location: html/login.html");
    exit();
}
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'izvodjac') {
 
  header("Location: index.html");
  exit();
}
require_once 'Backend/dbconn.php';
$izvodjac_ime = $_SESSION['user_name'];
$ocene= [];
try {
    $stmt = $conn->prepare("SELECT korisnik, ocena FROM ocene  WHERE izvodjac = ?");
    $stmt->execute([$izvodjac_ime]);
    $ocene = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "<div style='color:red'>Greška u upitu: " . $e->getMessage() . "</div>";
    $ocene = [];
}


$komentari = [];

try{
    $stmt = $conn->prepare("SELECT korisnik, komentar FROM komentari where izvodjac = ?");
    $stmt->execute([$izvodjac_ime]);
    $komentari = $stmt->fetchAll(PDO::FETCH_ASSOC);
}catch(PDOException $e) {
    echo "<div style='color:red'>Greška u upitu: " . $e->getMessage() . "</div>";
    $komentari = [];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    
    <title>Komentari i ocene</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="style.css">
</head>
<body>


    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>




  
<div class="container mt-5 dogadjaji-section" style="padding-top: 100px;">
        <h2 class="mb-4 text-black text-center">Ocene</h2>
        <table class="table table-dark table-hover dogadjaji-table" style="opacity:0.95;">
            <thead>
                <tr>
                    
                    <th>Korisnik</th>
                    <th>Ocena</th>
                    
                    
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($ocene)): ?>
                    <?php foreach ($ocene as $d): ?>
                    <tr>
                        
                        
                        <td><?= htmlspecialchars($d['korisnik']) ?></td>
                        <td><?= htmlspecialchars($d['ocena']) ?></td>
                        
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="4">Nema ocene za prikaz.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>    

    <div class="container mt-5 dogadjaji-section" style="padding-top: 100px;">
        <h2 class="mb-4 text-black text-center">Komentari</h2>
        <table class="table table-dark table-hover dogadjaji-table" style="opacity:0.95;">
            <thead>
                <tr>
                    
                    <th>Korisnik</th>
                    <th>Komentar</th>
                    
                    
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($komentari)): ?>
                    <?php foreach ($komentari as $d): ?>
                    <tr>
                        
                        
                        <td><?= htmlspecialchars($d['korisnik']) ?></td>
                        <td><?= htmlspecialchars($d['komentar']) ?></td>
                        
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="4">Nema komentara za prikaz.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>    








</body>
</html>