<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: html/login.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="sr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Van Gogh</title>

  <!-- Google font -->
  <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet" />
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="../style.css">
</head>
<a href="../nastupi.php" class="btn btn-secondary mb-4" style="position:absolute; top:24px; left:36px;">
    ← Nazad na nastupe
</a>
<body>
    <section class="top container">
    <div class="row align-items-start">
      <!-- Leva kolona: slika -->
      <div class="col-md-5" id="aca-lukas-slika">
        <img src="../images/van.jpeg" class="img-fluid" alt="Van Gogh" />
      </div>

      <!-- Desna kolona: tekst -->
      <div class="col-md-7 ps-4">
        <div class="naslov">
          <h2>Van Gogh</h2>
        </div>

        <div class="o-izvodjacu"><h5> <b>O izvođaču</b></h5></div>

        <div class="opis">
        Van Gogh je poznata srpska rok grupa osnovana 1986. godine. Njihov energični zvuk i hitovi poput „Neko te ima“ i „Strast“ učinili su ih jednom od najuticajnijih rok grupa na ovim prostorima.
        </div>

        <div class="detalji-nastupa">
          <h5>Detalji o nastupu</h5>
          <div class="row fw-bold">
            <div class="col-4">Datum</div>
            <div class="col-4">Vreme</div>
            <div class="col-4">Scena</div>
          </div>
          <div class="row ">
            <div class="col-4">26.3.2025</div>
            <div class="col-4">21:00</div>
            <div class="col-4">Treca scena</div>
          </div>
        </div>
      </div>
    </div>
  </section>


    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <div class="container">
  <div class="row text-center">
    <div class="col-md-6 mb-5">
      <h3>KOMENTARIŠITE IZVOĐAČA</h3>
      <form method="POST" action="../Backend/komentar_ocena.php">
        <input type="hidden" name="izvodjac" value="Van Gogh">
        <div class="custom-box mb-3">
          <textarea class="form-control comment-box mb-3" name="komentar" rows="5" placeholder="Komentarišite.." required></textarea>
        </div>
        <div class="d-flex gap-2 justify-content-center">
          <button type="submit" class="submit-btn">Pošalji komentar</button>
          <button id="Dodaj-u-omiljene" class="submit-btn" type="button" data-izvodjac="Van Gogh">Dodaj u omiljene</button>
          <a href="https://www.facebook.com/sharer/sharer.php?u=https://tvoj-sajt.com/saznaj-aca-lukas.php" target="_blank" class="share-fb-link">Podeli na Facebook</a>
        </div>
      </form>
    </div>

    <div class="col-md-6 mb-5">
      <h3>OCENITE IZVOĐAČA</h3>
      <form method="POST" action="../Backend/komentar_ocena.php">
        <input type="hidden" name="izvodjac" value="Van Gogh">
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
    // Postavi početnu vrednost
    output.textContent = slider.value; 

    // Ažuriraj prikaz kada se slider pomera
    slider.addEventListener('input', () => {
      output.textContent = slider.value;
    });
  }
</script>
<script src="js/dodaj_u_omiljene.js"></script>
</body>
</html>