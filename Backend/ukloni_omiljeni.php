<?php

session_start();
require_once 'dbconn.php';


if(!isset($_SESSION['user_id']) || !isset($_POST['izvodjac'])){
    http_response_code(400);
    echo"Nedostaju podaci";
    exit;
}


$korisnik_id = $_SESSION['user_id'];
$izvodjac = $_POST['izvodjac'];


$stmt= $conn->prepare("DELETE FROM omiljeni_izvodjaci WHERE korisnik_id = ? AND izvodjac = ?");
if($stmt->execute([$korisnik_id,$izvodjac])){
    echo"Izvodjac uuklonjen iz omiljenih! ";
}else{
    echo"greska pri uklanjanju";
};



?>