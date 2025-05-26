<?php
session_start();
if (!isset($_SESSION['utilisateur'])) {
    header("Location: connexion.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reserver_id'])) {
    $id_trajet = (int) $_POST['reserver_id'];

    try {
        $pdo = new PDO("mysql:host=localhost;dbname=ecoride;charset=utf8", "root", "");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Vérifier crédits utilisateur
        $stmt = $pdo->prepare("SELECT credits FROM utilisateurs WHERE id = ?");
        $stmt->execute([$_SESSION['utilisateur']['id']]);
        $credits = $stmt->fetchColumn();

        if ($credits >= 1) {
            // Réserver
            $pdo->prepare("INSERT INTO reservations (utilisateur_id, covoiturage_id) VALUES (?, ?)")
                ->execute([$_SESSION['utilisateur']['id'], $id_trajet]);

            // Décrémenter crédits
            $pdo->prepare("UPDATE utilisateurs SET credits = credits - 1 WHERE id = ?")
                ->execute([$_SESSION['utilisateur']['id']]);

            $_SESSION['utilisateur']['credits']--;
            echo "<p style='color:green;'>Réservation effectuée !</p>";
        } else {
            echo "<p style='color:red;'>Pas assez de crédits.</p>";
        }
    } catch (Exception $e) {
        echo "Erreur : " . $e->getMessage();
    }
}
?>



<?php require_once('../src/includes/header.php'); ?>

<main class="trajets">
    <h1>Liste des covoiturages disponibles</h1>

    <div class="trajet">
        <p><strong>De :</strong> Paris → <strong>À :</strong> Lyon</p>
        <p><strong>Date :</strong> 2025-06-01</p>
        <p><strong>Conducteur :</strong> Sophie D.</p>
    </div>

    <div class="trajet">
        <p><strong>De :</strong> Marseille → <strong>À :</strong> Toulouse</p>
        <p><strong>Date :</strong> 2025-06-03</p>
        <p><strong>Conducteur :</strong> Ahmed B.</p>
    </div>

    <div class="trajet">
        <p><strong>De :</strong> Lille → <strong>À :</strong> Bruxelles</p>
        <p><strong>Date :</strong> 2025-06-05</p>
        <p><strong>Conducteur :</strong> Clara M.</p>
    </div>
</main>

// Avant le <form> de réservation ou sur une page détail :

    $stmtAvis = $pdo->prepare("
    SELECT a.note, a.commentaire, u.pseudo, a.date
    FROM avis a
    JOIN utilisateurs u ON a.utilisateur_id = u.id
    WHERE a.covoiturage_id = ?
    ");
    $stmtAvis->execute([$covoiturage['id']]);
    $avisList = $stmtAvis->fetchAll();
    ?>

    <h3>Notes & Avis</h3>
    <?php if ($avisList): ?>
        <?php foreach ($avisList as $avis): ?>
            <p><strong><?= htmlspecialchars($avis['pseudo']) ?></strong> (<?= $avis['note'] ?>/5) : <?= htmlspecialchars($avis['commentaire']) ?> - <?= $avis['date'] ?></p>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Aucun avis pour ce trajet.</p>
    <?php endif; ?>


<form method="post">
    <input type="hidden" name="reserver_id" value="<?= $covoiturage['id'] ?>">
    <button type="submit">Réserver (1 crédit)</button>
</form>

    <?php if (isset($_SESSION['utilisateur'])): ?>
        <form method="post" action="ajouter_favori.php">
            <input type="hidden" name="covoiturage_id" value="<?= $covoiturage['id'] ?>">
            <button type="submit">❤️ Ajouter aux favoris</button>
        </form>
    <?php endif; ?>


    <?php require_once('../src/includes/footer.php'); ?>
