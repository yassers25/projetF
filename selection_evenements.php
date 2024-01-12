<?php
session_start();
include('connexion.php');

// Vérifier si le nombre d'événements est défini dans la session
if (!isset($_SESSION['nombre_evenements'])) {
    // Rediriger vers la page précédente si le nombre n'est pas défini
    header("Location: page_precedente.php");
    exit();
}

$nombreEvenements = $_SESSION['nombre_evenements'];

// Effectuer la requête pour récupérer les événements disponibles
$query = "SELECT ID_EVENT, TITRE FROM event";
$result = mysqli_query($link, $query);

// Vérifier si la requête a réussi
if ($result) {
    $evenementsDisponibles = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    // Gérer l'erreur de requête
    die("Erreur lors de la récupération des événements : " . mysqli_error($link));
}

// Déclarer des variables pour stocker les messages
$erreurMessage = "";
$succesMessage = "";
$erreurOccur = false; // Indicateur d'erreur

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer l'ID de l'utilisateur depuis la session
    $idUser = $_SESSION['ID_USER'];

    // Récupérer les sélections de l'utilisateur
    $nombreEvenements = $_SESSION['nombre_evenements'];

    // Initialiser un tableau pour stocker les événements sélectionnés
    $evenementsSelectionnes = array();

    // Vérifier si l'événement a déjà été sélectionné
    for ($i = 1; $i <= $nombreEvenements; $i++) {
        $evenementSelectionne = $_POST["evenement_$i"];

        if (in_array($evenementSelectionne, $evenementsSelectionnes)) {
            $erreurOccur = true;
            $erreurMessage = "Vous avez déjà sélectionné le même événement plusieurs fois.";
            break; // Arrêtez la boucle dès qu'une erreur est détectée
        }

        // Ajouter l'événement à la liste des événements sélectionnés
        $evenementsSelectionnes[] = $evenementSelectionne;
    }

    // Exécuter la requête d'insertion uniquement si aucune erreur n'est survenue
    if (!$erreurOccur) {
        // Préparer la requête d'insertion dans la table d'inscription
        $insertionQuery = "INSERT INTO inscription (ID_USER, ID_EVENT) VALUES ";

        for ($i = 1; $i <= $nombreEvenements; $i++) {
            $evenementSelectionne = $_POST["evenement_$i"];

            // Ajouter l'ID de l'utilisateur à la requête d'insertion
            $insertionQuery .= "($idUser, $evenementSelectionne), ";
        }

        // Supprimer la virgule finale et exécuter la requête
        $insertionQuery = rtrim($insertionQuery, ", ");
        $resultInsertion = mysqli_query($link, $insertionQuery);

        // Vérifier si l'insertion a réussi
        if ($resultInsertion) {
            $succesMessage = "Sélection des événements réussie.";
        } else {
            // Gérer l'erreur d'insertion
            $erreurMessage = "Erreur lors de l'insertion dans la table d'inscription : " . mysqli_error($link);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sélection des événements</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
            text-align: center;
        }

        h1 {
            color: #1b4353;
        }

        form {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            font-size: 18px;
            font-weight: bold;
            color: #333;
            margin-bottom: 10px;
            text-align: left;
        }

        select {
            width: calc(100% - 24px);
            padding: 10px;
            margin-bottom: 20px;
            font-size: 16px;
            color: #555;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #1b4353;
            color: white;
            padding: 14px 24px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 18px;
        }

        input[type="submit"]:hover {
            background-color: #1565C0;
        }

        select:focus {
            outline: none;
            border: 1px solid #1b4353;
            box-shadow: 0 0 5px rgba(27, 67, 83, 0.5);
        }
    </style>
</head>
<body>
    <h1>Sélection des événements</h1>

    <form action="#" method="post">
        <?php
        // Afficher les messages d'erreur ou de succès
        if (!empty($erreurMessage)) {
            echo "<div style='background-color: #f44336; color: white; padding: 15px; border-radius: 10px; text-align: center;'>$erreurMessage</div>";
        }

        if (!empty($succesMessage)) {
            echo "<div style='background-color: #4CAF50; color: white; padding: 15px; border-radius: 10px; text-align: center;'>$succesMessage</div>";
        }

        // Générer dynamiquement les listes déroulantes
        for ($i = 1; $i <= $nombreEvenements; $i++) {
            echo "<label for='evenement_$i'>Sélectionnez l'événement $i :</label>";
            echo "<select name='evenement_$i'>";
            
            // Boucler à travers les événements disponibles pour créer les options
            foreach ($evenementsDisponibles as $evenement) {
                echo "<option value='{$evenement['ID_EVENT']}'>{$evenement['TITRE']}</option>";
            }

            echo "</select>";
            echo "<br><br>";
        }
        ?>
        <input type="submit" value="Soumettre la sélection">
    </form>
</body>
</html>
