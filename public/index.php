<?php
require_once('../src/includes/header.php');
?>

<main class="home">
    <section class="presentation">
        <h1>Bienvenue sur <span class="highlight">EcoRide</span> 🌱</h1>
        <p>La plateforme de covoiturage écologique pour réduire l’impact environnemental des déplacements.</p>
        <img src="assets/img/ecoride_banner.jpg" alt="EcoRide" class="banner">
    </section>

    <section class="search">
        <h2>Recherchez un trajet</h2>
        <form action="recherche.php" method="get">
            <input type="text" name="depart" placeholder="Ville de départ" required>
            <input type="text" name="arrivee" placeholder="Ville d’arrivée" required>
            <input type="date" name="date" required>
            <button type="submit">Rechercher</button>
        </form>
    </section>
</main>

<?php
require_once('../src/includes/footer.php');
?>
