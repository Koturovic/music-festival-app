<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="sr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Aca Lukas</title>

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
        <img src="../images/aca-lukas.png" class="img-fluid" alt="Aca Lukas" />
      </div>

      <!-- Desna kolona: tekst -->
      <div class="col-md-7 ps-4">
        <div class="naslov">
          <h2>Aca Lukas</h2>
        </div>

        <div class="o-izvodjacu"><h5> <b>O izvođaču</b></h5></div>

        <div class="opis">
          Aca Lukas je popularni srpski pevač poznat po energičnim nastupima i prepoznatljivom spoju turbo-folka i pop-rock zvuka. Njegova muzička karijera traje više od dve decenije, a hitovi poput „Lična karta“ i „Upali svetlo“ učinili su ga jednim od najpoznatijih izvođača na Balkanu.
        </div>

        <div class="detalji-nastupa">
          <h5>Detalji o nastupu</h5>
          <div class="row fw-bold">
            <div class="col-4">Datum</div>
            <div class="col-4">Vreme</div>
            <div class="col-4">Scena</div>
          </div>
          <div class="row ">
            <div class="col-4">21.3.2025</div>
            <div class="col-4">21:00</div>
            <div class="col-4">Glavna scena</div>
          </div>
        </div>
      </div>
    </div>
  </section>


  
    
    
    
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <div class="container" id="komentari-padding">
  <div class="row text-center">
    <div class="col-md-6 mb-5">
      <h3>KOMENTARIŠITE IZVOĐAČA</h3>
      <form method="POST" action="../Backend/komentar_ocena.php">
        <input type="hidden" name="izvodjac" value="Aca Lukas">
        <div class="custom-box mb-3">
          <textarea class="form-control comment-box mb-3" name="komentar" rows="5" placeholder="Komentarišite.." required></textarea>
        </div>
        <div class="d-flex gap-2 justify-content-center align-items-center mt-3">
          <button type="submit" class="submit-btn">Pošalji komentar</button>
          <button id="Dodaj-u-omiljene" class="submit-btn" type="button" data-izvodjac="Aco Pejovic">Dodaj u omiljene</button>
          <a href="https://www.facebook.com/sharer/sharer.php?u=https://tvoj-sajt.com/saznaj-aca-lukas.php" target="_blank" class="share-fb-link">Podeli na Facebook</a>
        </div>
      </form>
    </div>

    <div class="col-md-6 mb-5">
      <h3>OCENITE IZVOĐAČA</h3>
      <form method="POST" action="../Backend/komentar_ocena.php">
        <input type="hidden" name="izvodjac" value="Aca Lukas">
        <div class="mb-3">
          <label for="customRange3" class="form-label">
            Ocena: <span id="rangeValue">5</span>
          </label>
          <input type="range" class="form-range" min="1" max="10" step="1" value="5" id="customRange3" name="ocena">
        </div>
        <button type="submit" class="submit-btn">Pošalji ocenu</button>
      </form>
      <a href="https://www.youtube.com/watch?v=QwZT7T-TXT0" target="_blank" class="btn btn-warning mt-2">Pogledaj intervju sa izvođačem</a>
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