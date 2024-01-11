<?php
session_start();
include("connexion.php");

$listeEvenements = array();

// Requête SQL pour récupérer les événements depuis la base de données
$query = "SELECT ID_EVENT, TITRE FROM event";
$result = mysqli_query($link, $query);

// Vérifier si la requête a réussi
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $listeEvenements[] = $row;
    }
} else {
    echo "Erreur lors de l'exécution de la requête : " . mysqli_error($link);
}
if (isset($_POST['sub'])) {
    // Récupérer le nombre d'événements depuis le formulaire
    $nombreEvenements = $_POST['nombre_evenements'];

    // Boucle pour traiter chaque choix d'événement
    for ($i = 1; $i <= $nombreEvenements; $i++) {
        // Récupérer l'ID de l'événement sélectionné depuis le formulaire
        $idEvenement = $_POST['evenement' . $i];
        $ID_USER = $_SESSION['ID_USER'];

        // Afficher les valeurs pour débogage
        echo "ID_USER : $ID_USER, ID_EVENT : $idEvenement <br>";

        // Votre requête d'insertion dans la table inscription
        $insertQuery = "INSERT INTO inscription (ID_USER, ID_EVENT) VALUES ('$ID_USER', '$idEvenement')";

        // Exécuter la requête
        $result = mysqli_query($link, $insertQuery);

        // Vérifier si l'insertion a réussi
        if (!$result) {
            echo "Erreur lors de l'insertion : " . mysqli_error($link);
        } else {
            echo "Insertion réussie <br>";
        }
    }

    // Fermer la connexion à la base de données
    mysqli_close($link);

    // Rediriger l'utilisateur vers une page de confirmation
    header("Location: confirmation.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription à un événement</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 10px;
        }

        select, input {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        input[type="submit"] {
            background-color: #4caf50;
            color: #fff;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
    <script>
        // Fonction pour afficher dynamiquement les listes déroulantes en fonction du nombre choisi
        function afficherListesDeroulantes() {
            var nombreEvenements = document.getElementById('nombre_evenements').value;
            var conteneurListes = document.getElementById('conteneur_listes_deroulantes');
            conteneurListes.innerHTML = '';

            for (var i = 1; i <= nombreEvenements; i++) {
                var select = document.createElement('select');
                select.name = 'evenement' + i;
                select.id = 'evenement' + i;

                <?php foreach ($listeEvenements as $evenement): ?>
                    var option = document.createElement('option');
                    option.value = '<?php echo $evenement['ID_EVENT']; ?>';
                    option.text = '<?php echo $evenement['TITRE']; ?>';
                    select.appendChild(option);
                <?php endforeach; ?>

                var label = document.createElement('label');
                label.htmlFor = 'evenement' + i;
                label.innerHTML = 'Choix de l\'événement ' + i + ' : ';

                conteneurListes.appendChild(label);
                conteneurListes.appendChild(select);
                conteneurListes.appendChild(document.createElement('br'));
            }
        }
    </script>
</head>
<body>
    

<!-- Formulaire pour choisir le nombre d'événements -->
<form method="post" action="traitement.php"> <!-- Remplacez "traitement.php" par le script qui traitera le formulaire -->
    <label for="nombre_evenements">Choisissez le nombre d'événements :</label>
    <input type="number" name="nombre_evenements" id="nombre_evenements" min="1" onchange="afficherListesDeroulantes()" required>
    
    <!-- Conteneur pour les listes déroulantes générées dynamiquement -->
    <div id="conteneur_listes_deroulantes"></div>

    <!-- Bouton pour soumettre les choix -->
    <input type="submit" value="Soumettre les choix" name="sub">
</form>

</body>
</html>
