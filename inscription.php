<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer le nombre d'événements souhaités par le participant
    $nombreEvenements = isset($_POST['nombre_evenements']) ? intval($_POST['nombre_evenements']) : 0;

    // Stocker le nombre d'événements dans la session
    $_SESSION['nombre_evenements'] = $nombreEvenements;

    // Rediriger vers la page suivante où les événements seront sélectionnés
    header("Location: selection_evenements.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sélection du nombre d'événements</title>
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
    max-width: 400px;
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

input {
    width: calc(100% - 24px);
    padding: 12px;
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

/* Style facultatif pour rendre le champ de saisie plus attrayant */
input:focus {
    outline: none;
    border: 1px solid #1b4353;
    box-shadow: 0 0 5px rgba(27, 67, 83, 0.5);
}

    </style>
</head>
<body>
    <h1>Sélection du nombre d'événements</h1>

    <form action="#" method="post">
        <label for="nombre_evenements">Entrez le nombre d'événements auxquels vous souhaitez participer :</label>
        <input type="number" name="nombre_evenements" required min="1">

        <input type="submit" value="Continuer">
    </form>
</body>
</html>
