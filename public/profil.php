<?php
session_start();

// Vérification de l'utilisateur connecté
if (!isset($_SESSION['utilisateur'])) {
    header("Location: connexion.php");
    exit;
}

$utilisateur = $_SESSION['utilisateur'];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mon Profil - EcoRide</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f4f4f4;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 60px auto;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        h1 {
            color: #27ae60;
            margin-bottom: 20px;
        }

        p {
            font-size: 18px;
            margin: 10px 0;
        }

        a {
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
            background: #e74c3c;
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            transition: background 0.3s ease;
        }

        a:hover {
            background: #c0392b;
        }

        @media (max-width: 600px) {
            .container {
                margin: 20px;
                padding: 20px;
            }

            p {
                font-size: 16px;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Bienvenue, <?= htmlspecialchars($utilisateur['pseudo'] ?? 'Utilisateur') ?> !</h1>
    <p><strong>Email :</strong> <?= htmlspecialchars($utilisateur['email'] ?? 'Inconnu') ?></p>
    <p><strong>Rôle :</strong> <?= htmlspecialchars($utilisateur['role'] ?? 'Non défini') ?></p>
    <p><strong>Crédits :</strong> <?= htmlspecialchars($utilisateur['credits'] ?? '0') ?></p>

    <a href="logout.php">Se déconnecter</a>
</div>
</body>
</html>
