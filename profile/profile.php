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

// Vérifier que les cookies existent
$email = $_COOKIE['email'] ?? '';
$token = $_COOKIE['token'] ?? '';

// Requête sécurisée pour récupérer l'utilisateur
if ($email && $token) {
    $req = $db->prepare("SELECT * FROM utilisateurs WHERE email = :email AND token = :token");
    $req->execute([
        ':email' => $email,
        ':token' => $token
    ]);
    $rep = $req->fetch(PDO::FETCH_ASSOC);
} else {
    $rep = false;
}

// === Gérer l'upload de la photo dans la base ===
$uploadMsg = '';
if ($rep && isset($_POST['upload']) && isset($_FILES['photo'])) {
    $imageData = file_get_contents($_FILES['photo']['tmp_name']); // lire l'image en binaire
    $stmt = $db->prepare("UPDATE utilisateurs SET photo_profil = :photo WHERE email = :email");
    if ($stmt->execute([':photo' => $imageData, ':email' => $email])) {
        $uploadMsg = "Photo téléchargée avec succès !";
        // Mettre à jour la variable pour l'affichage immédiat
        $rep['photo_profil'] = $imageData;
    } else {
        $uploadMsg = "Erreur lors de l'upload.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Profil Puissance 4</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .profile-photo {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
        }
    </style>
</head>
<body class="profile-page">

<?php if ($rep): ?>
    <p class="profile-title">Profil de l'utilisateur</p>
    <div class="profile-container">
        <div class="profile-left">
            <p class="profile-info"><strong>Nom d'utilisateur:</strong> <?php echo htmlspecialchars($rep['pseudo']); ?></p>
            <p class="profile-info"><strong>Email:</strong> <?php echo htmlspecialchars($rep['email']); ?></p>
            <p class="profile-info"><strong>Date de création:</strong> <?php echo htmlspecialchars($rep['date']); ?></p>
        </div>
        <div class="profile-right">
        <p class="profile-info" id="profile-photo-label"><strong>Photo de profil:</strong></p>
            <form action="" method="POST" enctype="multipart/form-data" id="photoForm">
            <input type="file" name="photo" id="photoInput" accept="image/*" style="display:none;">
        <?php
            if (!empty($rep['photo_profil'])) {
                echo "<img src='show_image.php?email=" . urlencode($rep['email']) . "' alt='Photo de profil' class='profile-photo' id='profileImage'>";
            } else {
                echo "<img src='../images/default.png' alt='Photo par défaut' class='profile-photo' id='profileImage'>";
    }
    ?>
</form>
<p><?php echo $uploadMsg; ?></p>
<script>
    const profileImg = document.getElementById('profileImage');
    const photoInput = document.getElementById('photoInput');
    const photoForm = document.getElementById('photoForm');

    // Quand on clique sur l'image
        profileImg.addEventListener('click', () => {
        photoInput.click(); // ouvre le sélecteur de fichiers
    });

// Quand on choisit un fichier, le formulaire est automatiquement soumis
    photoInput.addEventListener('change', () => {
        if(photoInput.files.length > 0){
            photoForm.submit();
    }
});
</script>
        </div>
    </div>
<div>
    <button class="menu-button" onclick="window.location.href='../home_page/home_page.html'">Accueil</button>
</div>

<?php else: ?>
    <p>Vous n'êtes pas connecté.</p>
    <button class="menu-button" onclick="window.location.href='../login/login.php'">Se connecter</button>
<?php endif; ?>

</body>
</html>