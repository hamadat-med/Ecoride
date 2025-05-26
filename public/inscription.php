<?php
session_start();

// Connexion PDO
try {
    $pdo = new PDO("mysql:host=localhost:3307;dbname=ecoride;charset=utf8", "root", "");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (Exception $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}

// Traitement du formulaire
$erreurs = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pseudo = trim($_POST['pseudo']);
    $email = trim($_POST['email']);
    $mot_de_passe = $_POST['mot_de_passe'];

    // Vérifications
    if (strlen($pseudo) < 3) {
        $erreurs[] = "Le pseudo doit contenir au moins 3 caractères.";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erreurs[] = "L'email n'est pas valide.";
    }
    if (strlen($mot_de_passe) < 8) {
        $erreurs[] = "Le mot de passe doit contenir au moins 8 caractères.";
    }

    // Si tout est ok
    if (empty($erreurs)) {
        // Vérifier si l'utilisateur existe déjà
        $stmt = $pdo->prepare("SELECT id FROM utilisateurs WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->rowCount() > 0) {
            $erreurs[] = "Un compte avec cet email existe déjà.";
        } else {
            // Hasher le mot de passe
            $hash = password_hash($mot_de_passe, PASSWORD_DEFAULT);

            // Insertion
            $insert = $pdo->prepare("INSERT INTO utilisateurs (pseudo, email, mot_de_passe) VALUES (?, ?, ?)");
            $insert->execute([$pseudo, $email, $hash]);

            $_SESSION['success'] = "Inscription réussie ! Vous pouvez vous connecter.";
            header("Location: connexion.php");
            exit;
        }
    }
}
?>
<?php require_once('../src/includes/header.php'); ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription - EcoRide</title>
</head>
<body>
<h1>Créer un compte EcoRide</h1>

<?php if (!empty($erreurs)) : ?>
    <ul style="color:red;">
        <?php foreach ($erreurs as $erreur) : ?>
            <li><?= htmlspecialchars($erreur) ?></li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<form method="post">
    <label>Pseudo :</label><br>
    <input type="text" name="pseudo" required><br><br>

    <label>Email :</label><br>
    <input type="email" name="email" required><br><br>

    <label>Mot de passe :</label><br>
    <input type="password" name="mot_de_passe" required><br><br>

    <button type="submit">S'inscrire</button>
</form>
</body>
</html>
<?php require_once('../src/includes/footer.php'); ?>