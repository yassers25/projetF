<?php
include("connexion.php");
session_start();

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer l'ID de l'utilisateur depuis la session
    $idUser = $_SESSION['ID_USER'];

    // Récupérer les sélections de l'utilisateur
    $nombreEvenements = $_SESSION['nombre_evenements'];

    // Initialiser un tableau pour stocker les événements sélectionnés
    $evenementsSelectionnes = array();

    // Préparer la requête d'insertion dans la table d'inscription
    $insertionQuery = "INSERT INTO inscription (ID_USER, ID_EVENT) VALUES ";

    for ($i = 1; $i <= $nombreEvenements; $i++) {
        $evenementSelectionne = $POST["evenement$i"];

        // Vérifier si l'événement a déjà été sélectionné
        if (in_array($evenementSelectionne, $evenementsSelectionnes)) {
            echo "<style>#message1 { background-color: #f44336; color: white; padding: 15px; border-radius: 10px; text-align: center; }</style>";
            echo "<div id='message1'>Vous avez déjà sélectionné le même événement plusieurs fois.</div>";
            exit();
        }

        // Ajouter l'événement à la liste des événements sélectionnés
        $evenementsSelectionnes[] = $evenementSelectionne;

        // Ajouter l'ID de l'utilisateur à la requête d'insertion
        $insertionQuery .= "($idUser, $evenementSelectionne), ";
    }

    // Supprimer la virgule finale et exécuter la requête
    $insertionQuery = rtrim($insertionQuery, ", ");
    $resultInsertion = mysqli_query($link, $insertionQuery);

    // Vérifier si l'insertion a réussi
    if ($resultInsertion) {
        echo "<style>#message { background-color: #4CAF50; color: white; padding: 15px; border-radius: 10px; text-align: center; }</style>";
        echo "<div id='message'>Sélection des événements réussie.</div>";
    } else {
        // Gérer l'erreur d'insertion
        die("Erreur lors de l'insertion dans la table d'inscription : " . mysqli_error($link));
    }
}
?>
