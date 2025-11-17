<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "site-web";

try {
    $db = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

$email = $_GET['email'] ?? '';

if ($email) {
    $stmt = $db->prepare("SELECT photo_profil FROM utilisateurs WHERE email = :email");
    $stmt->execute([':email' => $email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && !empty($user['photo_profil'])) {
        header("Content-Type: image/jpeg"); // ou image/png selon le format uploadé
        echo $user['photo_profil'];
        exit;
    }
}

// Si pas de photo, image par défaut
header("Content-Type: image/png");
readfile('../images/default.png');
exit;
?>
