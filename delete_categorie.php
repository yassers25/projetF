<?php
include("connexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cat_delete'])) {
    $cat_delete = $_POST['cat_delete'];
    $delete_events_query = "DELETE FROM event WHERE ID_CATEGORIE = $cat_delete";
    if (mysqli_query($link, $delete_events_query)) {
        $delete_query = "DELETE FROM categorie WHERE ID_CATEGORIE = $cat_delete";
        if (mysqli_query($link, $delete_query)) {
            header("location: /projetf/dashboard.php");
        } else {
            echo "Error deleting category: " . mysqli_error($link);
        }
    } else {
        echo "Error deleting associated events: " . mysqli_error($link);
    }
} else {
    echo "Invalid request or category ID not set";
}
?>
