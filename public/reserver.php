$conducteur_email = "conducteur@example.com"; // à récupérer dynamiquement

$subject = "Nouvelle réservation EcoRide";
$message = "Un passager a réservé votre trajet du $date_depart.";
$headers = "From: noreply@ecoride.com";

mail($conducteur_email, $subject, $message, $headers);
