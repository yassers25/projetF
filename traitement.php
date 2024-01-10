<?php
include('connexion.php');
session_start();
if(isset($_GET['Envoyer'])){
  $email = $_SESSION['email'];
  $req1 = "SELECT ID_USER from user WHERE EMAIL = '$email'";
  $res1 = mysqli_query($link,$req1);
  $row1 = mysqli_fetch_assoc($res1);
  $id1 = $row1['ID_USER'];
  $idevent = $_SESSION['idevent'];
  $comment = $_GET['comment'];
  $req2 = "INSERT INTO `comment`(`ID_USER`, `ID_EVENT`, `TEXTE`) VALUES ('$id1','$idevent','$comment')";
  $res2 = mysqli_query($link,$req2);
  if($res2)
  {
    header('Location: detail.php');
  }

}

?>