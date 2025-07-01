<?php
session_start();
require_once 'dbconn.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'organizator') {
    http_response_code(403);
    exit('Nemaš dozvolu!');
}

if (isset($_POST['dogadjaj_id'])) {
    $dogadjaj_id = intval($_POST['dogadjaj_id']);
    $stmt = $conn->prepare("DELETE FROM dogadjaji WHERE id = ?");
    if ($stmt->execute([$dogadjaj_id])) {
        echo 'Uspesno obrisano';
    } else {
        echo 'greska';
    }
}
?>