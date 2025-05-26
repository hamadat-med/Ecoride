<?php
session_start();

require_once 'connexion.php'; // ou adaptez le chemin selon votre structure
session_start();

if (!isset($_SESSION['utilisateur'])) {
    header("Location: ../connexion.php");
    exit;
}

$utilisateur = $_SESSION['utilisateur'];
?>
<?php
$stmt = $pdo->prepare("SELECT * FROM reservations WHERE conducteur_id = ? AND vu = 0");
$stmt->execute([$_SESSION['utilisateur']['id']]);
$notifications = $stmt->fetchAll();

foreach ($notifications as $notif) {
    echo "<p>🚗 Nouvelle réservation pour votre trajet du " . $notif['date_depart'] . "</p>";
    // Mettre à jour comme "vu"
    $update = $pdo->prepare("UPDATE reservations SET vu = 1 WHERE id = ?");
    $update->execute([$notif['id']]);
}
?>
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mon Profil - EcoRide</title>
</head>
<body>
<h1>Bienvenue, <?= htmlspecialchars($utilisateur['pseudo']) ?> !</h1>
<p>Email : <?= htmlspecialchars($utilisateur['email']) ?></p>
<p>Rôle : <?= htmlspecialchars($utilisateur['role']) ?></p>
<p>Crédits : <?= htmlspecialchars($utilisateur['credits']) ?></p>

<a href="logout.php">Se déconnecter</a>
</body>
</html>
