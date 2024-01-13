<?php
include("connexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cat_delete'])) {
    $cat_delete = intval($_POST['cat_delete']);

    // Check for associated events
    $check_events_query = "SELECT * FROM event WHERE ID_CATEGORIE = $cat_delete";
    $result = mysqli_query($link, $check_events_query);

    if ($result && mysqli_num_rows($result) > 0) {
        // Check for associated comments and delete them
        while ($row = mysqli_fetch_assoc($result)) {
            $event_delete = $row['ID_EVENT'];

            // Check for associated comments
            $check_comments_query = "SELECT * FROM comment WHERE ID_EVENT = $event_delete";
            $comments_result = mysqli_query($link, $check_comments_query);

            if ($comments_result && mysqli_num_rows($comments_result) > 0) {
                $delete_comments_query = "DELETE FROM comment WHERE ID_EVENT = $event_delete";
                mysqli_query($link, $delete_comments_query);
            }

            // Delete the event
            $delete_event_query = "DELETE FROM event WHERE ID_EVENT = $event_delete";
            mysqli_query($link, $delete_event_query);
        }
    }

    // Delete the category
    $delete_category_query = "DELETE FROM categorie WHERE ID_CATEGORIE = $cat_delete";
    if (mysqli_query($link, $delete_category_query)) {
        if (mysqli_affected_rows($link) > 0) {
            // Category deleted successfully
            echo "<script>alert('Catégorie est supprimée!!'); window.location.href = '/projetf/dashboard.php';</script>";
            exit();
        } else {
            echo "Category not found.";
        }
    } else {
        echo "Error deleting category: " . mysqli_error($link);
    }
} else {
    echo "Invalid request or category ID not set";
}
?>
