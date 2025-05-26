<?php
session_start();
if (!isset($_SESSION['utilisateur']) || $_SESSION['utilisateur']['role'] !== 'admin') {
    header("Location: connexion.php");
    exit;
}

try {
    $pdo = new PDO("mysql:host=localhost:3307;dbname=ecoride;charset=utf8", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Liste utilisateurs
    $stmtUsers = $pdo->query("SELECT id, pseudo, email, role, credits FROM utilisateurs");

    // Liste covoiturages
    $stmtCovoit = $pdo->query("SELECT * FROM covoiturages");

} catch (Exception $e) {
    die("Erreur : " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Admin - EcoRide</title>
</head>
<body>
<h1>Panneau d'administration</h1>
<h2>Utilisateurs</h2>
<table border="1">
    <tr><th>ID</th><th>Pseudo</th><th>Email</th><th>Rôle</th><th>Crédits</th></tr>
    <?php while ($u = $stmtUsers->fetch()) : ?>
        <tr>
            <td><?= $u['id'] ?></td>
            <td><?= htmlspecialchars($u['pseudo']) ?></td>
            <td><?= htmlspecialchars($u['email']) ?></td>
            <td><?= $u['role'] ?></td>
            <td><?= $u['credits'] ?></td>
        </tr>
    <?php endwhile; ?>
</table>

<h2>Covoiturages</h2>
<table border="1">
    <tr><th>ID</th><th>Départ</th><th>Arrivée</th><th>Date</th><th>Places</th><th>Conducteur</th></tr>
    <?php while ($c = $stmtCovoit->fetch()) : ?>
        <tr>
            <td><?= $c['id'] ?></td>
            <td><?= htmlspecialchars($c['ville_depart']) ?></td>
            <td><?= htmlspecialchars($c['ville_arrivee']) ?></td>
            <td><?= $c['date'] ?></td>
            <td><?= $c['places'] ?></td>
            <td><?= $c['conducteur'] ?></td>
        </tr>
    <?php endwhile; ?>
</table>

<a href="profil.php">Retour au profil</a>
</body>
</html>
