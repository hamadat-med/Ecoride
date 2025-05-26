

<?php
session_start();

try {
    $pdo = new PDO("mysql:host=localhost:3307;dbname=ecoride;charset=utf8", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}

$erreurs = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $mot_de_passe = $_POST['mot_de_passe'];

    $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE email = ?");
    $stmt->execute([$email]);
    $utilisateur = $stmt->fetch();

    if ($utilisateur && password_verify($mot_de_passe, $utilisateur['mot_de_passe'])) {
        $_SESSION['utilisateur'] = [
            'id' => $utilisateur['id'],
            'pseudo' => $utilisateur['pseudo'],
            'email' => $utilisateur['email'],
            'role' => $utilisateur['role'],
            'credits' => $utilisateur['credits']
        ];
        header("Location: profil.php");
        exit;
    } else {
        $erreurs[] = "Identifiants incorrects.";
    }
}
?>

<?php require_once('../src/includes/header.php'); ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion - EcoRide</title>
</head>
<body>
<h1>Connexion à EcoRide</h1>

<?php if (!empty($erreurs)) : ?>
    <ul style="color:red;">
        <?php foreach ($erreurs as $erreur) : ?>
            <li><?= htmlspecialchars($erreur) ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<form method="post">
    <label>Email :</label><br>
    <input type="email" name="email" required><br><br>

    <label>Mot de passe :</label><br>
    <input type="password" name="mot_de_passe" required><br><br>

    <button type="submit">Se connecter</button>
</form>

    <p>Pas encore de compte ? <a href="inscription.php">Inscrivez-vous ici</a>.</p>
</main>

<?php require_once('../src/includes/footer.php'); ?>
