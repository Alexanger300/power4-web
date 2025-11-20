<?php
// Début de session
session_start();

// Vider les variables de session
$_SESSION = array();

// Supprimer le cookie qui est associé à la session
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Supprimer les cookies personnalisés
setcookie('email', '', time() - 3600, '/');
setcookie('token', '', time() - 3600, '/');

// Détruire la session
session_destroy();

// Redirection
header("Location: ../../templates/login/login.php");
exit();
?>
