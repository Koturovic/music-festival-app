<?php
require_once 'dbconn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Preuzimanje i sanitizacija podataka
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($email) || empty($password)) {
        die("Sva polja su obavezna!");
    }

    // Provera korisnika u bazi
    $stmt = $conn->prepare("SELECT id, name, email, password FROM posetioci WHERE email = :email");
    $stmt->bindParam(":email", $email);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Provera lozinke
        if (password_verify($password, $user['password'])) {
            // Uspesno logovanje
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_email'] = $user['email'];
            
            echo "Uspešno logovanje!";
            header("Location: ../index.html");
            exit;
        } else {
            die("Pogrešna lozinka!");
        }
    } else {
        die("Korisnik sa ovom email adresom ne postoji!");
    }
}
?> 