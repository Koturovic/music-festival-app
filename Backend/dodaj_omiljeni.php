<?php

session_start();
require_once 'dbconn.php';


if(!isset($_SESSION['user_id']) || !isset($_SESSION['user_name']) || !isset($_POST['izvodjac'])){
    http_response_code(400);
    echo"Nema svih podataka";
    exit;
}


$korisnik = $_SESSION['user_id'];
$izvodjac = $_POST['izvodjac'];

// proverava da li vec postoji u omiljenim za tog korisnika:
$stmt= $conn->prepare("SELECT * FROM omiljeni_izvodjaci WHERE korisnik = ? AND izvodjac = ?");
$stmt->execute([$korisnik,$izvodjac]);
if($stmt->rowCount()> 0){
    echo "Izvodjac vec postoji u omiljenim!";
    exit;
}

// dodavanje izvodjaca u omiljene
$stmt= $conn->prepare("INSERT INTO omiljeni_izvodjaci (korisnik, izvodjac) VALUES (?,?)");
if($stmt->execute([$korisnik,$izvodjac])){
    echo "Uspesno dodato u omiljene !";
}else{
    echo"Greska pri dodavanju";
}
?>