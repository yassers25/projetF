<?php
header('Content-Type: application/json');
include("connexion.php");

if (isset($_GET['event_id'])) {
    $event_id = intval($_GET['event_id']);
    $participant_query = "SELECT username FROM inscription WHERE ID_EVENT = $event_id";
    $result = mysqli_query($link, $participant_query);

    if ($result) {
        $participants = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $participants[] = $row['username']; // Extract 'username' from the result
        }

        // Send a well-formed JSON response
        echo json_encode($participants);
    } else {
        // Handle the case where the query fails
        echo json_encode(array('error' => 'Query failed'));
    }
} else {
    // Handle the case where 'event_id' is not set
    echo json_encode(array('error' => 'Event ID not set'));
}
?>
