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
$izvodjaci_stmt = $conn->query("SELECT id, ime,zanr,opis FROM izvodjaci");
$izvodjaci_lista = $izvodjaci_stmt->fetchAll(PDO::FETCH_ASSOC);

try {
    $stmt = $conn->query("SELECT ime, zanr, opis FROM izvodjaci");
    $izvodjaci = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "<div style='color:red'>Greška u upitu: " . $e->getMessage() . "</div>";
    $izvodjaci = [];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    
    <title>Dodavanje informacija o sebi</title>
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



<div class="text-center mb-4">
    <button class="btn btn-success" id="showAddFormBtn">Dodaj informacije o sebi</button>
</div>

<!--  (skrivena dok se ne klikne dugme) -->
<div id="addFormDiv" style="display:none;" class="mb-4">

    <form method="POST" action="Backend/dodaj_izvodjaca.php" class="row g-3 justify-content-center">
        <div class="col-md-2">
            <input type="text" name="ime" class="form-control" placeholder="Ime" required>
        </div>
        
        <div class="col-md-2">
            <input type="text" name="opis" class="form-control" placeholder="Opis" required>
        </div>
        <div class="col-md-2">
            <input type="text" name="zanr" class="form-control" placeholder="Žanr" required>
        </div>
        
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary">Sačuvaj</button>
        </div>
    </form>
</div>
  
<div class="container mt-5 dogadjaji-section" style="padding-top: 100px;">
        <h2 class="mb-4 text-black text-center">IZVODJACI</h2>
        <table class="table table-dark table-hover dogadjaji-table" style="opacity:0.95;">
            <thead>
                <tr>
                    <th>IME</th>
                    <th>ZANR</th>
                    <th>OPIS</th>
        
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($izvodjaci)): ?>
                    <?php foreach ($izvodjaci as $d): ?>
                    <tr>
                        
                        <td><?= htmlspecialchars($d['ime']) ?></td>
                        <td><?= htmlspecialchars($d['zanr']) ?></td>
                        <td><?= htmlspecialchars($d['opis']) ?></td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="4">Nema izvodjaca za prikaz.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>    



<script>

document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('showAddFormBtn').onclick = function() {
        document.getElementById('addFormDiv').style.display = 'block';
    };
});
</script>


</body>
</html>