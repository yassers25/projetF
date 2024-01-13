<?php
session_start();
include("connexion.php");

// Function to get events for a specific day
function getEventsForDay($date, $link)
{
    $events = array();
    $sql = "SELECT * FROM event WHERE DATE(DATE) = '$date'";
    $result = mysqli_query($link, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $events[] = $row;
        }
    }

    return $events;
}

// Function to get events for a specific month
function getEventsForMonth($year, $month, $link)
{
    $events = array();
    $firstDay = "$year-$month-01";
    $lastDay = date("Y-m-t", strtotime($firstDay));
    $sql = "SELECT * FROM event WHERE DATE(DATE) BETWEEN '$firstDay' AND '$lastDay'";
    $result = mysqli_query($link, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $events[] = $row;
        }
    }

    return $events;
}

// Function to get events for a specific year
function getEventsForYear($year, $link)
{
    $events = array();
    $sql = "SELECT * FROM event WHERE YEAR(DATE) = $year";
    $result = mysqli_query($link, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $events[] = $row;
        }
    }

    return $events;
}

// Function to get users for a specific event
function getUsersForEvent($eventId, $link)
{
    $users = array();
    $sql = "SELECT * FROM user u
            INNER JOIN inscription eu ON u.ID_USER = eu.ID_USER
            WHERE eu.ID_EVENT = $eventId";
    $result = mysqli_query($link, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $users[] = $row;
        }
    }

    return $users;
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="dash_styles.css">
    <title>Statistics</title>
    <style>
        h3.activated {
            background-size: 100% 100%;
            background-position: 0% 100%;
            transition: background-position 0.7s, background-size 0.5s ease-in-out;
        }
    </style>
</head>

<body>
    <?php
    include("sidebar.php");
    ?>

    <div class="container">
        <h3>Statistics</h3>

        <?php
        if (isset($_GET['year'])) {
            $selectedYear = intval($_GET['year']);
            $months = range(1, 12);

            // Display months for the selected year
            echo '<ul class="responsive-table">';
            foreach ($months as $month) {
                $events = getEventsForMonth($selectedYear, $month, $link);
                echo '<li class="table-header li_head">';
                echo '<div class="col col-1"><a href="stats.php?year=' . $selectedYear . '&month=' . $month . '">' . date('F', mktime(0, 0, 0, $month, 1)) . '</a></div>';
                echo '</li>';

                // Display days for the selected month
                echo '<li class="table-header li_head">';
                echo '<div class="col col-1">Day</div>';
                echo '<div class="col col-2">Events</div>';
                echo '<div class="col col-3">Users</div>'; // Added this line
                echo '</li>';

                $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $selectedYear);
                for ($day = 1; $day <= $daysInMonth; $day++) {
                    $date = "$selectedYear-$month-$day";
                    $events = getEventsForDay($date, $link);

                    // Only display the day if there are events
                    if (!empty($events)) {
                        echo '<li class="table-row">';
                        echo '<div class="col col-1">' . $day . '</div>';
                        echo '<div class="col col-2">';
                        foreach ($events as $event) {
                            echo '<span style="font-weight: bold; text-transform:uppercase;font-size: 19px;">' . $event['TITRE'] . '</span><br>';
                        }
                        echo '</div>';
                        echo '<div class="col col-3">';

                        // Display users for each event
                        foreach ($events as $event) {
                            $eventId = $event['ID_EVENT'];
                            $users = getUsersForEvent($eventId, $link);

                            foreach ($users as $user) {
                                echo $user['NOM'] . " " . $user['PRENOM'] . '<br>';
                            }
                        }

                        echo '</div>';
                        echo '</li>';
                    }
                }
            }
            echo '</ul>';
        } elseif (isset($_GET['month'])) {
            $selectedYear = intval($_GET['year']);
            $selectedMonth = intval($_GET['month']);
            $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $selectedMonth, $selectedYear);
            $days = range(1, $daysInMonth);

            // Display days for the selected month
            echo '<ul class="responsive-table">';
            echo '<li class="table-header li_head">';
            echo '<div class="col col-1">Day</div>';
            echo '<div class="col col-2">Events</div>';
            echo '<div class="col col-3">Users</div>'; // Added this line
            echo '</li>';

            foreach ($days as $day) {
                $date = "$selectedYear-$selectedMonth-$day";
                $events = getEventsForDay($date, $link);

                // Only display the day if there are events
                if (!empty($events)) {
                    echo '<li class="table-row">';
                    echo '<div class="col col-1">' . $day . '</div>';
                    echo '<div class="col col-2">';
                    foreach ($events as $event) {
                        echo $event['TITRE'] . '<br>';
                    }
                    echo '</div>';
                    echo '<div class="col col-3">';

                    // Display users for each event
                    foreach ($events as $event) {
                        $eventId = $event['ID_EVENT'];
                        $users = getUsersForEvent($eventId, $link);

                        foreach ($users as $user) {
                            echo $user['username'] . '<br>';
                        }
                    }

                    echo '</div>';
                    echo '</li>';
                }
            }
            echo '</ul>';
        } else {
            // Display years
            $sql = "SELECT DISTINCT YEAR(DATE) AS event_year FROM event";
            $result = mysqli_query($link, $sql);

            if ($result && mysqli_num_rows($result) > 0) {
                echo '<ul class="responsive-table">';
                echo '<li class="table-header li_head">';
                echo '<div class="col col-1">Year</div>';
                echo '<div class="col col-2">Events</div>';
                echo '</li>';

                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<li class="table-row">';
                    echo '<div class="col col-1"><a href="stats.php?year=' . $row['event_year'] . '">' . $row['event_year'] . '</a></div>';
                    echo '<div class="col col-2">';
                    $events = getEventsForYear($row['event_year'], $link);
                    foreach ($events as $event) {
                        echo $event['TITRE'] . '<br>';
                    }
                    echo '</div>';
                    echo '</li>';
                }
                echo '</ul>';
            } else {
                echo 'No events found.';
            }
        }
        ?>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/js/bootstrap.bundle.min.js"></script>
    <script>
        window.addEventListener("load", () => {
            const titles = Array.from(document.getElementsByTagName("h3"));

            titles.map((title) => {
                title.classList.add("activated");
            })
        });

    </script>
</body>

</html>