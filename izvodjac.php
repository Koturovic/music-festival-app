<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}
require_once 'Backend/dbconn.php';

if (!isset($_GET['ime'])) {
    die('Nedostaje ime izvođača!');
}
$ime = $_GET['ime'];

// Ucitavamo podatke o izvođaču iz baze
$stmt = $conn->prepare("SELECT * FROM izvodjaci WHERE ime = ?");
$stmt->execute([$ime]);
$izvodjac = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$izvodjac) {
    die('Izvođač nije pronađen!');
}

// Učitavamo detalje o nastupu 
$stmt = $conn->prepare("SELECT * FROM dogadjaji WHERE izvodjac = ?");
$stmt->execute([$ime]);
$nastup = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="sr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= htmlspecialchars($izvodjac['ime']) ?></title>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="style.css">
</head>
<a href="nastupi.php" class="btn btn-secondary mb-4" style="position:absolute; top:24px; left:36px;">
    ← Nazad na nastupe
</a>
<body>
<section class="top container">
  <div class="row align-items-start">
    <div class="col-md-5" id="izvodjac-slika">
      <?php if (!empty($izvodjac['slika'])): ?>
        <img src="<?= htmlspecialchars($izvodjac['slika']) ?>" class="img-fluid" alt="<?= htmlspecialchars($izvodjac['ime']) ?>" />
      <?php endif; ?>
    </div>
    <div class="col-md-7 ps-4">
      <div class="naslov">
        <h2><?= htmlspecialchars($izvodjac['ime']) ?></h2>
      </div>
      <div class="o-izvodjacu"><h5><b>O izvođaču</b></h5></div>
      <div class="opis">
        <?= htmlspecialchars($izvodjac['opis']) ?>
      </div>
      <div class="detalji-nastupa">
        <h5>Detalji o nastupu</h5>
        <?php if ($nastup): ?>
        <div class="row fw-bold">
          <div class="col-4">Datum</div>
          <div class="col-4">Žanr/Vreme</div>
          <div class="col-4">Scena</div>
        </div>
        <div class="row">
          <div class="col-4"><?= date('d.m.Y', strtotime($nastup['datum'])) ?></div>
          <div class="col-4"><?= htmlspecialchars($nastup['zanr']) ?></div>
          <div class="col-4"><?= htmlspecialchars($nastup['scena']) ?></div>
        </div>
        <?php else: ?>
        <div>Nema podataka o nastupu.</div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</section>


<div class="container" id="komentari-padding">
  <div class="row text-center">
    <div class="col-md-6 mb-5">
      <h3>KOMENTARIŠITE IZVOĐAČA</h3>
      <form method="POST" action="Backend/komentar_ocena.php">
        <input type="hidden" name="izvodjac" value="<?= htmlspecialchars($izvodjac['ime']) ?>">
        <div class="custom-box mb-3">
          <textarea class="form-control comment-box mb-3" name="komentar" rows="5" placeholder="Komentarišite.." required></textarea>
        </div>
        <div class="d-flex gap-2 justify-content-center align-items-center mt-3">
          <button type="submit" class="submit-btn">Pošalji komentar</button>
          <button id="Dodaj-u-omiljene" class="submit-btn" type="button" data-izvodjac="<?= htmlspecialchars($izvodjac['ime']) ?>">Dodaj u omiljene</button>
        </div>
      </form>
    </div>
    <div class="col-md-6 mb-5">
      <h3>OCENITE IZVOĐAČA</h3>
      <form method="POST" action="Backend/komentar_ocena.php">
        <input type="hidden" name="izvodjac" value="<?= htmlspecialchars($izvodjac['ime']) ?>">
        <div class="mb-3">
          <label for="customRange3" class="form-label">
            Ocena: <span id="rangeValue">5</span>
          </label>
          <input type="range" class="form-range" min="1" max="10" step="1" value="5" id="customRange3" name="ocena">
        </div>
        <button type="submit" class="submit-btn">Pošalji ocenu</button>
      </form>
    </div>
  </div>
</div>

<script>
  const slider = document.getElementById('customRange3');
  const output = document.getElementById('rangeValue');
  if (slider && output) {
    output.textContent = slider.value;
    slider.addEventListener('input', () => {
      output.textContent = slider.value;
    });
  }
</script>
<script src="js/dodaj_u_omiljene.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 