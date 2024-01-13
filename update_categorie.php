<?php
session_start();
include("connexion.php");


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["categoryId"])) {
    $name = $_POST["categoryName"];
    $categoryId = $_POST["categoryId"];

    $query = "UPDATE categorie SET LABEL='$name' WHERE ID_CATEGORIE = $categoryId";
    
    if (mysqli_query($link, $query)) {
        header("location:dashboard.php");
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($link);
    }
}
?>
