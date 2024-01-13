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

    // Delete child records from inscription table
    $delete_inscription_query = "DELETE FROM inscription WHERE ID_EVENT = $event_delete";
    mysqli_query($link, $delete_inscription_query);

    // Now, delete the record from the event table
    $delete_event_query = "DELETE FROM event WHERE ID_EVENT = $event_delete";
    if (mysqli_query($link, $delete_event_query)) {
        if (mysqli_affected_rows($link) > 0) {
            // Event deleted successfully
            echo "<script>alert('Evenement est supprimée!!'); window.location.href = 'dashboard.php';</script>";
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
