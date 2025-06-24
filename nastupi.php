<?php
session_start();

// var_dump($_SESSION);
if (!isset($_SESSION['user_id'])) {
    header("Location: html/login.html");
    exit();
}
require_once 'Backend/dbconn.php';

try {
    $stmt = $conn->query("SELECT izvodjac, scena, zanr, datum FROM dogadjaji ORDER BY datum ASC");
    $dogadjaji = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "<div style='color:red'>Greška u upitu: " . $e->getMessage() . "</div>";
    $dogadjaji = [];
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
    <!--Proba-->
    <title>Nastupi</title>
</head>
<body>
    <div class="container mt-3 text-end">
        <a href="../music-festival-app/Backend/logout.php" class="btn btn-danger">Logout</a>
    </div>
    
    
    <!--<div class="program">
        <div class="container">
            Predstojeci dogadjaji  *** PREDSTOJECI DOGADJAJI
        </div>
    </div> -->

    

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  
  
  
  <div class="container text-center mt-5">
  <h2 class="mb-3">KO NASTUPA OVE GODINE?</h2>
  <p>Pogledajte neke od najistaknutijih izvođača koji će nastupiti na našem festivalu!</p>

  <div id="nastupi" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
      <!-- Slajd 1 -->
      <div class="carousel-item active">
        <div class="row justify-content-center">
          <div class="col-6 col-md-3">
            <img src="images/aca-lukas.png" alt="Aca Lukas" class="d-block w-100">
            <p class="artist-name">Aca Lukas</p>
            <button class="btn btn-outline-dark learn-more-btn" onclick="window.location.href='html/saznaj-aca-lukas.php'">SAZNAJ VIŠE</button>
          </div>
          <div class="col-6 col-md-3">
            <img src="images/aco-pejovic.jpg" class="d-block w-100" alt="Aco Pejovic">
            <p class="artist-name">Aco Pejovic</p>
            <button class="btn btn-outline-dark learn-more-btn" onclick="window.location.href='html/saznaj-aca-pejovic.php'">SAZNAJ VIŠE</button>
          </div>
          <div class="col-6 col-md-3 d-none d-md-block">
            <img src="images/Dragana-Mirkovic-2.jpg" class="d-block w-100" alt="">
            <p class="artist-name">Dragana Mirkovic</p>
            <button class="btn btn-outline-dark learn-more-btn" onclick="window.location.href='html/saznaj-dragana.php'">SAZNAJ VIŠE</button>
          </div>
          <div class="col-6 col-md-3 d-none d-md-block">
            <img src="images/sasa-matic.jpg" class="d-block w-100" alt="Sasa Matic">
            <p class="artist-name">Sasa Matic</p>
            <button class="btn btn-outline-dark learn-more-btn" onclick="window.location.href='html/saznaj-sasa.php'">SAZNAJ VIŠE</button>
          </div>
        </div>
      </div>
      
      <!-- Slajd 2 -->
      <div class="carousel-item">
        <div class="row justify-content-center">
          <div class="col-6 col-md-3">
            <img src="images/milica.jpeg" class="d-block w-100" alt="Milica Pavlovic">
            <p class="artist-name">Milica Pavlovic</p>
            <button class="btn btn-outline-dark learn-more-btn" onclick="window.location.href='html/saznaj-milica-pavlovic.php'">SAZNAJ VIŠE</button>
          </div>
          <div class="col-6 col-md-3">
            <img src="images/marija.jpg" class="d-block w-100" alt="Marija Šerifović">
            <p class="artist-name">Marija Šerifović</p>
            <button class="btn btn-outline-dark learn-more-btn" onclick="window.location.href='html/saznaj-marija-serifovic.php'">SAZNAJ VIŠE</button>
          </div>
          <div class="col-6 col-md-3 d-none d-md-block">
            <img src="images/slobaa.jpg" class="d-block w-100" alt="Sloba">
            <p class="artist-name">Sloba Radanovic</p>
            <button class="btn btn-outline-dark learn-more-btn" onclick="window.location.href='html/saznaj-sloba-radanovic.php'">SAZNAJ VIŠE</button>
          </div>
          <div class="col-6 col-md-3 d-none d-md-block">
            <img src="images/van.jpeg" class="d-block w-100" alt="Van Gogh">
            <p class="artist-name">Van Gogh</p>
            <button class="btn btn-outline-dark learn-more-btn" onclick="window.location.href='html/saznaj-van-gog.php'">SAZNAJ VIŠE</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Dugmad -->
    <button class="carousel-control-prev" type="button" data-bs-target="#nastupi" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Prethodni</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#nastupi" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Sledeći</span>
    </button>
  </div>
</div>

<div class="container mt-5 dogadjaji-section">
        <h2 class="mb-4 text-white">PREDSTOJEĆI DOGAĐAJI</h2>
        <table class="table table-dark table-hover dogadjaji-table" style="opacity:0.95;">
            <thead>
                <tr>
                    <th>DATUM</th>
                    <th>Scena</th>
                    <th>Vreme</th>
                    <th>Izvodjac</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($dogadjaji)): ?>
                    <?php foreach ($dogadjaji as $d): ?>
                    <tr>
                        <td><?= date('d/m/Y', strtotime($d['datum'])) ?></td>
                        <td><?= htmlspecialchars($d['scena']) ?></td>
                        <td><?= htmlspecialchars($d['zanr']) ?></td>
                        <td><?= htmlspecialchars($d['izvodjac']) ?></td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="4">Nema događaja za prikaz.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

   

    

</body>
</html>