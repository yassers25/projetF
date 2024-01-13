<?php
session_start();
include("connexion.php");

$search = isset($_GET['category_search']) ? $_GET['category_search'] : '';

if ($search !== '') {
    $sql = "SELECT categorie.ID_CATEGORIE, categorie.LABEL, COUNT(event.ID_EVENT) AS num_events
                         FROM categorie
                         LEFT JOIN event ON categorie.ID_CATEGORIE = event.ID_CATEGORIE
                         WHERE categorie.LABEL LIKE '%$search%'
                         GROUP BY categorie.ID_CATEGORIE, categorie.label
                         ORDER BY categorie.ID_CATEGORIE DESC";
} else {
    $sql = "SELECT categorie.ID_CATEGORIE, categorie.LABEL, COUNT(event.ID_EVENT) AS num_events
                         FROM categorie
                         LEFT JOIN event ON categorie.ID_CATEGORIE = event.ID_CATEGORIE
                         GROUP BY categorie.ID_CATEGORIE, categorie.label
                         ORDER BY categorie.ID_CATEGORIE DESC";
}

$result = mysqli_query($link, $sql);

if (mysqli_num_rows($result) > 0) {
    ?>
    <li class="table-header">
        <div class="col col-1">Id</div>
        <div class="col col-2">Nom Categorie</div>
        <div class="col col-3">Numero des évènments</div>
        <div class="col col-4">Action</div>
    </li>
    <?php
    $j = 1;
    while ($row = mysqli_fetch_assoc($result)) {
        $_SESSION["id" . $row['ID_CATEGORIE']] = $row['ID_CATEGORIE'];
        ?>
        <li class="table-row">
            <div class="col col-1" data-label="Id_categ">
                <?php echo $j; ?>
            </div>
            <div class="col col-2" data-label="nom_categ">
                <?php echo $row['LABEL']; ?>
            </div>
            <div class="col col-3" data-label="num_event">
                <?php echo $row['num_events']; ?>
            </div>
            <div class="col col-4" data-label="action">
                <button class="btn open-button" onclick="openForm(<?php echo $row['ID_CATEGORIE']; ?>)" type="button">
                    <i class="fas fa-edit"></i>
                </button>

                <form method="post" action="delete_categorie.php" style="display: inline-block;">
                    <input type="hidden" name="cat_delete" value="<?php echo $row['ID_CATEGORIE']; ?>">
                    <button type="submit" name="delete_event" class="btn">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </form>
            </div>
        </li>
        <?php
        $j++;
    }
} else {
    echo "<li class='table-header'><div class='col col-1'>Id</div><div class='col col-2'>Nom Categorie</div><div class='col col-3'>Numero des évènments</div><div class='col col-4'>Action</div></li><li>No results found.</li>";
}

mysqli_close($link);
?>
