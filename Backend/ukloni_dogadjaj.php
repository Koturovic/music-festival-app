<?php
session_start();
require_once 'dbconn.php';

if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['organizator', 'admin'])) {
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