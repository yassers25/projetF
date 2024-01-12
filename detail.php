<?php
include('connexion.php');
session_start();

if (isset($_GET['Envoyer'])) {
    $email = $_SESSION['email'];
    $req1 = "SELECT ID_USER from user WHERE EMAIL = '$email'";
    $res1 = mysqli_query($link, $req1);
    $row1 = mysqli_fetch_assoc($res1);
    $id1 = $row1['ID_USER'];
    $ide = $_GET['idevent'];
    $comment = $_GET['comment'];

    $req2 = "INSERT INTO `comment`(`ID_USER`, `ID_EVENT`, `TEXTE`) VALUES ('$id1','$ide','$comment')";
    $res2 = mysqli_query($link, $req2);

    if ($res2) {
        header('Location: detail.php');
    } else {
        echo "Error: " . mysqli_error($link);
    }
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Événements</title>
    <link rel="stylesheet" href="detail.css">
    <style>
        .card_img {
            margin-left: 1350px;
        }
        a{
  font-size: 1.25em;
  color : #1b4353;
}
    </style>

</head>

<body>
    <div>
        <div class="header">
            <nav>
                <img width='150px' src="img/ensa1.png">
                <ul>
                    <li><a href="home.php">Accueil</a></li>
                    <li><a href="events.php">Nos Evenements</a></li>
                    <li><a href="authentification.php">Admin</a></li>
                    <li><a href="deconnexion_etudiant.php">Deconnexion</a></li>
                </ul>
            </nav>
        </div>
        <section>
            <section id="title">
                <h1>Détails de nos événements:</h1>
                <div class="register">
                    <a class="cry" href="inscription.php">S'inscrir a un evenement</a>
                </div>
            </section>

            <?php
            include('connexion.php');
            
            if (isset($_SESSION['email']) && $_SESSION['loggedin']) {
                $query = "SELECT e.ID_EVENT, e.TITRE, e.IMAGE, e.DESCRIPTION, e.DATE, e.LOCATION, c.TEXTE, u.NOM, u.PRENOM 
                          FROM event e
                          LEFT JOIN comment c ON e.ID_EVENT = c.ID_EVENT
                          LEFT JOIN user u ON c.ID_USER = u.ID_USER";
                $result = mysqli_query($link, $query);

                $currentEventID = null;

                while ($row = mysqli_fetch_assoc($result)) {
                    if ($currentEventID != $row['ID_EVENT']) {
                        // Print event details only if the event ID changes
                        echo '<div class="card">';
                        echo '<img class="card_img" width="100px" src="photo/' . $row['IMAGE'] . '">';
                        echo '<div class="m">';
                        echo '<h2 class="card__content">' . $row['TITRE'] . '</h2>';
                        echo '<p class="card__content"><h4>Description</h4>' . $row['DESCRIPTION'] . '</p>';
                        echo '<p class="card__date"><h4>Date</h4></p>' . $row['DATE'];
                        echo '<p><h4>Location</h4> ' . $row['LOCATION'] . '</p>';

                        // Add Comment Form
                        echo '<form action="detail.php" method="get">';
                        echo '<input type="hidden" name="idevent" value="' . $row['ID_EVENT'] . '">';
                        echo '<label><h3>Ajouter un commentaire </h3></label>';
                        echo '<input class="comment" type="text" name="comment" placeholder="Votre commentaire">';
                        echo '<input class="ajout_comment" type="submit" name="Envoyer" value="Ajouter un commentaire">';
                        echo '</form>';

                        $currentEventID = $row['ID_EVENT'];
                    }

                    if ($row['TEXTE'] != NULL) {
                        // Print comments only if there are any
                        echo '<h3>Liste des commentaires</h3>';
                        echo '<ul>';
                        do {
                            // Check if $row is not null before accessing its values
                            if ($row !== null) {
                                echo '<li>' . strtoupper($row['NOM']) . ' ' . strtoupper($row['PRENOM']) . ' : ' . $row['TEXTE'] . '</li><br>';
                            }
                        } while (($row = mysqli_fetch_assoc($result)) !== null && $row['ID_EVENT'] == $currentEventID);
                        echo '</ul>';
                    } else {
                        echo "<p>Pas de commentaire</p>";
                    }
                    echo '</div>';
                    echo '</div>';
                }
            }
            ?>
        </section>
    </div>
</body>

</html>
