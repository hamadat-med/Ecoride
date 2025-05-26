<?php
session_start();
if (!isset($_SESSION['utilisateur'])) {
    header("Location: connexion.php");
    exit;
}

$pdo = new PDO("mysql:host=localhost;dbname=ecoride;charset=utf8", "root", "");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$covoiturage_id = (int)$_POST['covoiturage_id'];
$utilisateur_id = $_SESSION['utilisateur']['id'];

$stmt = $pdo->prepare("INSERT IGNORE INTO favoris (utilisateur_id, covoiturage_id) VALUES (?, ?)");
$stmt->execute([$utilisateur_id, $covoiturage_id]);

header("Location: favoris.php");
exit;
