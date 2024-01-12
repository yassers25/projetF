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

/* Style facultatif pour rendre le champ de sélection plus attrayant */
select:focus {
    outline: none;
    border: 1px solid #1b4353;
    box-shadow: 0 0 5px rgba(27, 67, 83, 0.5);
}

    </style>
</head>
<body>
    <h1>Sélection des événements</h1>

    <form action="traitement_selection.php" method="post">
        <?php
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
