<?php
include("connexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['event_delete'])) {
    $event_delete = intval($_POST['event_delete']);

    // Check for associated comments
    $check_comments_query = "SELECT * FROM comment WHERE ID_EVENT = $event_delete";
    $result = mysqli_query($link, $check_comments_query);

    if ($result && mysqli_num_rows($result) > 0) {
        $delete_comments_query = "DELETE FROM comment WHERE ID_EVENT = $event_delete";
        mysqli_query($link, $delete_comments_query);
    }

    $delete_event_query = "DELETE FROM event WHERE ID_EVENT = $event_delete";
    if (mysqli_query($link, $delete_event_query)) {
        if (mysqli_affected_rows($link) > 0) {
            header("Location: dashboard.php");
            exit();
        } else {
            echo "Event not found.";
        }
    } else {
        echo "Error deleting event: " . mysqli_error($link);
    }
} else {
    echo "Invalid request or event ID not set";
}
?>
