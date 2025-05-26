<?php
session_start();
if (!isset($_SESSION['utilisateur'])) {
    header("Location: connexion.php");
    exit;
}

$pdo = new PDO("mysql:host=localhost;dbname=ecoride;charset=utf8", "root", "");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$stmt = $pdo->prepare("
    SELECT c.* FROM favoris f
    JOIN covoiturages c ON c.id = f.covoiturage_id
    WHERE f.utilisateur_id = ?
");
$stmt->execute([$_SESSION['utilisateur']['id']]);
$favoris = $stmt->fetchAll();
?>

<h1>Mes favoris</h1>
<?php foreach ($favoris as $trajet): ?>
    <div>
        <p><?= htmlspecialchars($trajet['depart']) ?> → <?= htmlspecialchars($trajet['destination']) ?></p>
    </div>
<?php endforeach; ?>
