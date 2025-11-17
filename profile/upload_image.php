<?php
if (isset($_POST['upload']) && isset($_FILES['photo'])) {
    $email = $_COOKIE['email'] ?? null;

    if ($email) {
        $target_dir = "../uploads/"; // dossier où stocker les images
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0755, true);
        }

        $file_name = basename($_FILES["photo"]["name"]);
        $target_file = $target_dir . uniqid() . "_" . $file_name;

        // Vérifie si c'est bien une image
        $check = getimagesize($_FILES["photo"]["tmp_name"]);
        if ($check !== false) {
            // Déplace l’image et enregistre le chemin dans la base
            if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
                $stmt = $db->prepare("UPDATE utilisateurs SET photo_profil = :photo WHERE email = :email");
                $stmt->execute([
                    'photo' => $target_file,
                    'email' => $email
                ]);
                echo "<p>Photo de profil mise à jour !</p>";
            } else {
                echo "<p>Erreur lors du téléversement.</p>";
            }
        } else {
            echo "<p>Le fichier n’est pas une image valide.</p>";
        }
    } else {
        echo "<p>Utilisateur non connecté.</p>";
    }
}
?>
