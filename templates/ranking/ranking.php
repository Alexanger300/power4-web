<?php // Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "site-web2"; // Nom de la base de données

try {
    $db = new PDO("mysql:host=$servername;dbname=$dbname;charset=utf8", $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Requête pour obtenir le classement
$sql = "SELECT pseudo, victoires,défaites FROM utilisateurs ORDER BY victoires DESC";
$resultat = $db->query($sql);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Classement des joueurs</title>
    <link rel="stylesheet" href="../../assets/style/style.css">
</head>

<body class="classement-body">
<button id="Return" class="Return" onclick="window.location.href='../home_page/home_page.html'">Retour au menu</button>
<h1>🏆 Classement des joueurs 🏆</h1>

<table id="classement">
    <thead>
        <tr>
            <th data-type="number" data-order="desc">Rang ⬇️</th>
            <th data-type="string" data-order="asc">Pseudo 🔤</th>
            <th data-type="number" data-order="desc">Victoires ⬇️</th>
            <th data-type="number" data-order="desc">Défaites ⬇️</th>
        </tr>
    </thead>
    <tbody>
    <?php
    if ($resultat && $resultat->rowCount() > 0) {
        $rang = 1;
        while ($ligne = $resultat->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>" . $rang . "</td>";
            echo "<td>" . htmlspecialchars($ligne["pseudo"]) . "</td>";
            echo "<td>" . htmlspecialchars($ligne["victoires"]) . "</td>";
            echo "<td>" . htmlspecialchars($ligne["défaites"]) . "</td>";
            echo "</tr>";
            $rang++;
        }
    } else {
        echo "<tr><td colspan='4'>Aucun joueur trouvé</td></tr>";
    }
    ?>
    </tbody>
</table>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const table = document.getElementById('classement');
    const headers = table.querySelectorAll('th');

    headers.forEach((header, index) => {
        header.addEventListener('click', () => {
            const type = header.getAttribute('data-type');
            const order = header.getAttribute('data-order');
            const tbody = table.querySelector('tbody');
            const rows = Array.from(tbody.querySelectorAll('tr'));

            rows.sort((a, b) => {
                const cellA = a.children[index].textContent.trim();
                const cellB = b.children[index].textContent.trim();

                if (type === 'number') {
                    return order === 'asc'
                        ? parseFloat(cellA) - parseFloat(cellB)
                        : parseFloat(cellB) - parseFloat(cellA);
                } else {
                    return order === 'asc'
                        ? cellA.localeCompare(cellB, 'fr', {numeric: true})
                        : cellB.localeCompare(cellA, 'fr', {numeric: true});
                }
            });

            tbody.innerHTML = '';
            rows.forEach(row => tbody.appendChild(row));

            header.setAttribute('data-order', order === 'asc' ? 'desc' : 'asc');
        });
    });
});
</script>

</body>
</html>

<?php
$db = null; // Ferme la connexion proprement
?>
