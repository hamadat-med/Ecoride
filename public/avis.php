<?php
session_start();
if (!isset($_SESSION['utilisateur'])) {
    header("Location: connexion.php");
    exit;
}

$pdo = new PDO("mysql:host=localhost;dbname=ecoride;charset=utf8", "root", "");
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Vérifier si l'utilisateur a réservé ce trajet
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $covoiturage_id = (int)$_POST['covoiturage_id'];
    $note = (int)$_POST['note'];
    $commentaire = trim($_POST['commentaire']);

    // Éviter plusieurs avis pour le même trajet
    $check = $pdo->prepare("SELECT COUNT(*) FROM avis WHERE utilisateur_id = ? AND covoiturage_id = ?");
    $check->execute([$_SESSION['utilisateur']['id'], $covoiturage_id]);

    if ($check->fetchColumn() == 0) {
        $stmt = $pdo->prepare("INSERT INTO avis (utilisateur_id, covoiturage_id, note, commentaire) VALUES (?, ?, ?, ?)");
        $stmt->execute([$_SESSION['utilisateur']['id'], $covoiturage_id, $note, $commentaire]);
        $message = "Avis enregistré !";
    } else {
        $message = "Vous avez déjà laissé un avis.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laisser un avis</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<h1>Laisser un avis</h1>
<?php if (isset($message)) echo "<p>$message</p>"; ?>
<form method="post">
    <label>ID du covoiturage :</label>
    <input type="number" name="covoiturage_id" required><br>
    <label>Note (1 à 5) :</label>
    <input type="number" name="note" min="1" max="5" required><br>
    <label>Commentaire :</label><br>
    <textarea name="commentaire" rows="4" cols="50"></textarea><br>
    <button type="submit">Envoyer l'avis</button>
</form>
</body>
</html>
