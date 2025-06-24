<?php  

$sName = "localhost";
$uName = "root";
$pass  = "Ubuntuvm2025@";
$db_name = "music-festival-posetioci";

try {
	$conn = new PDO("mysql:host=$sName;dbname=$db_name", $uName, $pass);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);




	// dohhvatanje dogadja iz baze:
	$stmt = $conn->prepare("SELECT izvodjac, scena, zanr, datum FROM dogadjaji");
	$stmt->execute();
	$dogadjaji = $stmt->fetchAll(PDO::FETCH_ASSOC);
}catch(Exception $e){
	echo "Connection failed: ". $e->getMessage();
	$dogadjaji = [];
	exit;
}