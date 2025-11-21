<?php
if (!isset($_POST['pseudo'])) {
    http_response_code(400);
    echo "Erreur : pseudo manquant.";
    exit;
}

$pseudo = $_POST['pseudo'];

$serveur = "localhost";
$utilisateur = "root";
$motdepasse = "";
$basededonnees = "site-web2";    

$conn = new mysqli($serveur, $utilisateur, $motdepasse, $basededonnees);

if ($conn->connect_error) {
    http_response_code(500);
    die("Erreur de connexion : " . $conn->connect_error);
}

// ajoute une victoire au joueur
$sql = "UPDATE utilisateurs SET victoires = victoires + 1 WHERE pseudo = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $pseudo);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo "Victoire ajoutée avec succès pour $pseudo !";
} else {
    echo "Aucun joueur trouvé pour $pseudo.";
}

$stmt->close();
$conn->close();
?>
