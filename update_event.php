<?php
session_start();
include("connexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["eventId"])) {
    $name = $_POST["eventName"];
    $date=$_POST["eventDate"];
    $desc=$_POST["eventDesc"];
    $local=$_POST["eventloc"];
    $eventId = $_POST["eventId"];

    $query = "UPDATE event SET TITRE='$name', DESCRIPTION='$desc', DATE='$date', LOCATION='$local' WHERE ID_EVENT = $eventId";
    
    if (mysqli_query($link, $query)) {
        header("location:dashboard.php");
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($link);
    }
}
?>
