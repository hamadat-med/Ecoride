<?php require_once('../src/includes/header.php'); ?>

<main class="contact">
    <h1>Contactez-nous</h1>
    <form method="post" action="#">
        <label for="nom">Nom :</label>
        <input type="text" name="nom" id="nom" required>

        <label for="email">Email :</label>
        <input type="email" name="email" id="email" required>

        <label for="message">Message :</label>
        <textarea name="message" id="message" required></textarea>

        <button type="submit">Envoyer</button>
    </form>
</main>

<?php require_once('../src/includes/footer.php'); ?>
