<?php
include("connexion.php");
if($_SERVER["REQUEST_METHOD"]=="POST"){
    $nom=$_POST["categoryName"];
    $request= "INSERT INTO categorie(LABEL) VALUES('$nom')";
    $res=mysqli_query($link,$request);
    header("location:dashboard.php");
    mysqli_close($link);
}

?>
