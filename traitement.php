<?php
include('connexion_try.php');
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
        header('Location: details_try.php');
    } else {
        echo "Error: " . mysqli_error($link);
    }
}
?>
