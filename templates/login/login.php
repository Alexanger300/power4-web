<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Puissance 4</title>
  <link rel="stylesheet" href="../../assets/style/style.css">
  <div id="login-title">Puissance 4 - Connexion</div>
</head>
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

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $pass  = isset($_POST['password']) ? $_POST['password'] : '';

    if ($email !== '' && $pass !== '') {
        $token = bin2hex(random_bytes(32)); // Générer un token sécurisé
        // Récupérer l'utilisateur uniquement par email
        $stmt = $db->prepare("SELECT * FROM utilisateurs WHERE email = :email LIMIT 1");
        $stmt->execute(['email' => $email]);
        $rep = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($rep) {
            // Vérifier le mot de passe haché avec password_verify
            if (isset($rep['password']) && password_verify($pass, $rep['password'])) {
                $db->exec("UPDATE utilisateurs SET token = '$token' WHERE email = '$email'");
                setcookie("token", $token, time() + 3600, "/"); // Cookie valide 1 heure
                setcookie("email", $email, time() + 3600, "/"); // Cookie valide 1 heure
                echo "<script>
                localStorage.setItem('pseudo', '". addslashes($rep['pseudo']) ."');
                window.location.href = '../home_page/home_page.html';
      </script>";
exit;
            } else {
                $error_msg="Email ou mot de passe incorrect";
            }
        } else {
            $error_msg="Email ou mot de passe incorrect";
        }
    }
}
?>
<body class="login-page">
  <div class="login-container">
    <form method="POST" action="">
      <label for="email">Adresse email :</label>
      <input type="email" id="email" name="email" required>

      <label for="password">Mot de passe :</label>
      <input type="password" id="password" name="password" required>

      <button type="ok">Se connecter</button>

    <p>Pas encore de compte ? <a href="/ProjetHangMan/power4-web/templates/inscription/inscription.php">Inscrivez-vous ici</a></p>
    </form>

    <?php
    if (isset($error_msg)) {
      ?>
        <p class="error-message"> <?php echo $error_msg; ?>  </p>
      <?php
    }
    ?>
  </div>
</body>
</html>