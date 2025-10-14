<?php
// Connexion à la base
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

// Vérifier formulaire
if (isset($_POST['ok'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = md5($_POST['password']); // hachage MD5

    $requete = $db->prepare("INSERT INTO utilisateurs (pseudo, email, password) VALUES (:pseudo, :email, :password)");
    $requete->execute([
        'pseudo' => $username,
        'email' => $email,
        'password' => $password
    ]);

    header('Location: login.php');
    echo "Inscription réussie ! Vous pouvez maintenant vous connecter.";
    exit;
}
?>
