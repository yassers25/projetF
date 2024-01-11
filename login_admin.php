<?php
session_start();
include("connexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nom = $_POST['nom'];
    $password =$_POST['password'];

    // Requête SQL pour vérifier l'existence du nom
    $query = "SELECT * FROM admin WHERE nom = '$nom'";
    $resultat = mysqli_query($link, $query);

    if (mysqli_num_rows($resultat) > 0) {
        $user = mysqli_fetch_assoc($resultat);
        
        if ($password == $user['PASSWORD']) {  // Vérification du mot de passe 

            // Enregistrement des données de l'utilisateur dans la session
            $_SESSION['loggedin'] = true;
            $_SESSION['ID_ADMIN'] = $user['ID_ADMIN'];
            $_SESSION['NOM'] = $user['NOM'];
            $_SESSION['PRENOM'] = $user['PRENOM'];
            $_SESSION['TEL'] = $user['TEL'];
            $_SESSION['PASSWORD'] = $user['PASSWORD'];
           
            header("Location: ajouter_evenement.php");
            exit;
        } else {
            echo '<p style="color: red; font-weight: bold; text-align: center; font-size: 1.5em;">Le mot de passe est incorrect.</p>';
        }
    } else {
        echo '<p style="color: red; font-weight: bold; text-align: center; font-size: 1.5em;">Le nom n\'existe pas.</p>';
    }
    // Fermeture de la connexion
    mysqli_close($link);
}
?>
