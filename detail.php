<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Événements</title>
    <link rel="stylesheet" href="detail.css">
</head>

<body>
    <div>
        <div class="header">
            <nav>
                <img width='150px' src="img/ensa1.png">
                <ul>
                    <li><a href="">Accueil</a></li>
                    <li><a href="detail.php">Nos Evenements</a></li>
                    <li><a href="formulaire.php">Inscription</a></li>
                </ul>
            </nav>
        </div>
        <section>
            <section id="title">
                <h1>Détail de nos événements:</h1>
                <div class="register">
                    
                </div>
            </section>

            <?php
            include('connexion.php');
            session_start();
            if (isset($_SESSION['email']) && $_SESSION['loggedin']) {
                $query = "SELECT e.ID_EVENT, e.TITRE, e.DESCRIPTION, e.DATE, e.LOCATION, c.TEXTE, u.NOM, u.PRENOM 
                            FROM event e
                            LEFT JOIN comment c ON e.ID_EVENT = c.ID_EVENT
                            LEFT JOIN user u ON c.ID_USER = u.ID_USER";
                $result = mysqli_query($link, $query);

                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<div class="card">';
                    echo '<h2 class="card__content">' . $row['TITRE'] . '</h2>';
                    echo '<p class="card__content">Description :' . $row['DESCRIPTION'] . '</p>';
                    echo '<p class="card__date">Date : ' . $row['DATE'] . '</p>';
                    echo '<p>Location: ' . $row['LOCATION'] . '</p>';
                    echo '<form action="traitement.php" method="get">';
                    echo '<label>Ajouter un commentaire :</label><br><br>';
                    echo '<input class="comment" type="text" name="comment" placeholder="Votre commentaire">';
                    echo '<input class="ajout_comment" type="submit" name="Envoyer">';
                    echo '</form>';
                    $_SESSION['idevent'] = $row['ID_EVENT'];
                    
                    if ($row['TEXTE'] == NULL) {
                        echo "<p>Pas de commentaire</p>";
                    } else {
                        echo '<p>' . strtoupper($row['NOM']) . ' ' . strtoupper($row['PRENOM']) . ': ' . $row['TEXTE'] . '</p><br>';
                    }

                    echo '</div>';
                }

            ?>
        </section>
    </div>
</body>

</html>
