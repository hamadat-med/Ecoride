<?php require_once('../src/includes/header.php'); ?>

<main class="recherche">
    <h1>Résultats de votre recherche</h1>

    <?php
    if (isset($_GET['depart'], $_GET['arrivee'], $_GET['date'])) {
        $depart = htmlspecialchars($_GET['depart']);
        $arrivee = htmlspecialchars($_GET['arrivee']);
        $date = htmlspecialchars($_GET['date']);

        echo "<p>Trajets trouvés de <strong>$depart</strong> à <strong>$arrivee</strong> le <strong>$date</strong> :</p>";

        // Simulation de trajets :
        echo "<div class='trajet'>
                <p><strong>Conducteur :</strong> Laura V.</p>
                <p><strong>Heure :</strong> 08:00</p>
              </div>";
        echo "<div class='trajet'>
                <p><strong>Conducteur :</strong> Mehdi R.</p>
                <p><strong>Heure :</strong> 14:30</p>
              </div>";
    } else {
        echo "<p>Veuillez remplir le formulaire de recherche.</p>";
    }
    ?>
</main>

<?php require_once('../src/includes/footer.php'); ?>
