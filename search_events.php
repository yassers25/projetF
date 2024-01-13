<?php
session_start();
include("connexion.php");

$searchEvents = isset($_GET['event_search']) ? $_GET['event_search'] : '';

if ($searchEvents !== '') {
    $eventSql = "SELECT event.*, COUNT(inscription.ID_USER) AS num_participants
                FROM event
                LEFT JOIN inscription ON event.ID_EVENT = inscription.ID_EVENT
                WHERE event.TITRE LIKE '%$searchEvents%'
                GROUP BY event.ID_EVENT
                ORDER BY event.ID_EVENT DESC";
} else {
    $eventSql = "SELECT event.*, COUNT(inscription.ID_USER) AS num_participants
                FROM event
                LEFT JOIN inscription ON event.ID_EVENT = inscription.ID_EVENT
                GROUP BY event.ID_EVENT
                ORDER BY event.ID_EVENT DESC";
}

$eventResult = mysqli_query($link, $eventSql);
?>

<ul class="responsive-table">
    <li class="table-header li_head">
        <div class="col col-1">Id</div>
        <div class="col col-2">Nom Evenement</div>
        <div class="col col-2">Description</div>
        <div class="col col-2">Categorie</div>
        <div class="col col-3">Numero des participants</div>
        <div class="col col-4">Action</div>
    </li>

    <?php
    $i = 1;
    if (mysqli_num_rows($eventResult) > 0) {
        while ($row = mysqli_fetch_assoc($eventResult)) { ?>
            <li class="table-row">
                <div class="col col-1">
                    <?php echo $i; ?>
                </div>
                <div class="col col-2">
                    <?php echo $row['TITRE']; ?>
                </div>
                <div class="col col-2" style="overflow: hidden;">
                    <?php echo $row['DESCRIPTION']; ?>
                </div>
                <div class="col col-2">
                    <?php
                    $categoryId = $row['ID_CATEGORIE'];
                    $categoryQuery = "SELECT LABEL FROM categorie WHERE ID_CATEGORIE = $categoryId";
                    $categoryResult = mysqli_query($link, $categoryQuery);

                    if ($categoryResult && mysqli_num_rows($categoryResult) > 0) {
                        $categoryData = mysqli_fetch_assoc($categoryResult);
                        echo $categoryData['LABEL'];
                    } else {
                        echo "Category Not Found";
                    }
                    ?>
                </div>
                <div class="col col-3">
                    <?php echo $row['num_participants']; ?>
                </div>
                <div class="col col-4">
                    <button class="btn open-button" onclick="openFormEvent(<?php echo $row['ID_EVENT']; ?>)"
                        type="button">
                        <i class="fas fa-edit"></i>
                    </button>
                    <form method="post" action="delete_event.php" style="display: inline-block;">
                        <input type="hidden" name="event_delete" value="<?php echo $row['ID_EVENT']; ?>">
                        <button type="submit" name="delete_event" class="btn">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </form>
                </div>
            </li>
            <?php
            $i++;
        }
    }
    ?>
</ul>
