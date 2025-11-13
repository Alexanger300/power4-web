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
$basededonnees = "site-web"; 

$conn = new mysqli($serveur, $utilisateur, $motdepasse, $basededonnees);

if ($conn->connect_error) {
    http_response_code(500);
    die("Erreur de connexion : " . $conn->connect_error);
}

// ⚠️ colonne "défaites" avec accent → entourée de backticks !
$sql = "UPDATE utilisateurs SET `défaites` = `défaites` + 1 WHERE pseudo = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $pseudo);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo "Défaite ajoutée avec succès pour $pseudo !";
} else {
    echo "Aucun joueur trouvé pour $pseudo.";
}

$stmt->close();
$conn->close();
?>
