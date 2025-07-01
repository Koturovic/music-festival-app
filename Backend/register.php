<?php
session_start();
require_once 'dbconn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Preuzimanje i sanitizacija podataka
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $role = ($_POST['uloga']);

    if (empty($name) || empty($email) || empty($password)) {
        die("Sva polja su obavezna!");
    }

    // Provera da li email već postoji
    // sprecava SQL injection

    $stmt = $conn->prepare("SELECT id FROM posetioci WHERE email = :email");
    $stmt->bindParam(":email", $email);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        die("Korisnik sa ovom email adresom već postoji!");
    }

    // Hesiraj lozinku
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Ubaci korisnika u bazu
    $stmt = $conn->prepare("INSERT INTO posetioci (name, email, password, role) VALUES (:name, :email, :password, :role)");
    
    $stmt->bindParam(":name", $name);
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":password", $hashed_password);
    $stmt->bindParam(":role", $role);
    
    if ($stmt->execute()) {
        $last_id = $conn->lastInsertId();
        $_SESSION['user_id'] = $last_id;
        $_SESSION['user_name'] = $name;
        $_SESSION['user_email'] = $email;
        $_SESSION['role'] = $role;
        if($role === 'organizator'){
            header("Location: ../organizator_index.php");
        }elseif($role === 'posetioc'){
            header("Location: ../nastupi.php");
        }elseif($role === 'admin'){
            header("Location: ../admin_index.php");
        }elseif($role === 'izvodjac'){
            header("Location: ../izvodjac_index.php");
        }else{
            header("Location: ../index.html");
        }
        exit;
    } else {
        echo "Greška prilikom registracije.";
    }
}
?>
