<?php
// Connexion à la base
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "site-web2";

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
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $requete = $db->prepare("INSERT INTO utilisateurs (pseudo, email, password,token) VALUES (:pseudo, :email, :password,'')");
    $requete->execute([
        'pseudo' => $username,
        'email' => $email,
        'password' => $password
    ]);
    echo "Inscription réussie ! Vous pouvez maintenant vous connecter.";
    header('Location: /ProjetHangMan/power4-web/templates/login/login.php');
    exit;
}
?>