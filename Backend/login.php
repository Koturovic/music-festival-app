<?php
session_start();
require_once 'dbconn.php';
$admin_secret = isset($_POST['admin_secret']) ? $_POST['admin_secret'] : '';
require_once __DIR__ . '/../config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Preuzimanje i sanitizacija podataka
    $name = trim($_POST['name']);
    $password = trim($_POST['password']);
    //$role = ($_POST['uloga']); // ne koristimo 

    if (empty($name) || empty($password)) {
        die("Sva polja su obavezna!");
    }

    // Provera korisnika u bazi
    $stmt = $conn->prepare("SELECT id, name, email, password, role FROM posetioci WHERE name = :name");
    $stmt->bindParam(":name", $name);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Provera lozinke
        if (password_verify($password, $user['password'])) {
            // Provera da li je korisnik blokiran
            $stmt_blok = $conn->prepare("SELECT blokiran FROM posetioci WHERE id = ?");
            $stmt_blok->execute([$user['id']]);
            if ($stmt_blok->fetchColumn()) {
                session_destroy();
                header("Location: ../blokiran.html");
                exit();
            }
            // ako je korisnik uneo administratorsku lozinku redirektuje ga na admin_index.php
            if ($admin_secret === ADMIN_SECRET) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['name'];
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['role'] = 'admin';
                header("Location: ../admin_index.php");
                exit();
            }
            // Uspešno logovanje po ulozi iz baze
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['role'] = $user['role'];
            if($_SESSION['role'] === 'organizator'){
                header("Location: ../organizator_index.php");
            }elseif($_SESSION['role'] === 'posetioc'){
                header("Location: ../nastupi.php");
            }elseif($_SESSION['role'] === 'admin'){
                header("Location: ../admin_index.php");
            }elseif($_SESSION['role'] === 'izvodjac'){
                header("Location: ../izvodjac_index.php");
            }else{
                header("Location: ../index.html");
            }
            exit;
        } else {
            die("Pogrešna lozinka!");
        }
    } else {
        die("Korisnik sa ovim imenom ne postoji!");
    }
}
?> 