<?php
session_start();
include("connexion.php");

$search = isset($_GET['category_search']) ? $_GET['category_search'] : '';

if ($search !== '') {
    $sql = "SELECT categorie.ID_CATEGORIE, categorie.LABEL, COUNT(event.ID_EVENT) AS num_events
                         FROM categorie
                         LEFT JOIN event ON categorie.ID_CATEGORIE = event.ID_CATEGORIE
                         WHERE categorie.LABEL LIKE '%$search%'
                         GROUP BY categorie.ID_CATEGORIE, categorie.label";
} else {
    $sql = "SELECT categorie.ID_CATEGORIE, categorie.LABEL, COUNT(event.ID_EVENT) AS num_events
                         FROM categorie
                         LEFT JOIN event ON categorie.ID_CATEGORIE = event.ID_CATEGORIE
                         GROUP BY categorie.ID_CATEGORIE, categorie.label";
}

$result = mysqli_query($link, $sql);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css"
          integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh"
          crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
          integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
          crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="dash_styles.css">
    <title>Dashboard</title>
    
</head>

<body class="fixed-nav ">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">

    <a class="navbar-brand" href="dashboard.php">Dashboard</a>

    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse"
            data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false"
            aria-label="Toggle navigation">

        <span class="navbar-toggler-icon"></span>

    </button>

    <div class="collapse navbar-collapse" id="navbarResponsive">

        <ul class="navbar-nav navbar-sidenav" id="exampleAccordion">

            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Dashboard">

                <a class="nav-link" href="dashboard.php">

                    <i class="fa fa-fw fa-dashboard"></i>

                    <span class="nav-link-text">Dashboard</span>

                </a>

            </li>

            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Charts">
                <a class="nav-link" href="product.php">
                    <i class="fa fa-check-square"></i>
                    <span class="nav-link-text">Ajouter Categorie</span>
                </a>

            </li>

            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Charts">

                <a class="nav-link" href="ajouter_evenement.php">

                    <i class="fa fas fa-user"></i>

                    <span class="nav-link-text">Ajouter Evenement</span>

                </a>

            </li>

        </ul>

        <ul class="navbar-nav ml-auto">

            <li class="nav-item">

                <a href="logout.php" class="nav-link" data-toggle="modal" data-target="#exampleModal">

                    <i class="fa fa-fw fa-sign-out"></i>Logout</a>

            </li>

        </ul>

    </div>

</nav>



<div class="container">
    <h3>Catégories</h3>
    <form method="GET">
        <input type="text" name="category_search" placeholder="Search for categories...">
        <button type="submit">Search</button>
    </form>

    <ul class="responsive-table">
        <li class="table-header">
            <div class="col col-1">Id</div>
            <div class="col col-2">Nom Categorie</div>
            <div class="col col-3">Numero des évènments</div>
            <div class="col col-4">Action</div>
        </li>

        <?php
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                ?>
                <li class="table-row">
                    <div class="col col-1" data-label="Job Id"><?php echo $row['ID_CATEGORIE']; ?></div>
                    <div class="col col-2" data-label="Customer Name"><?php echo $row['LABEL']; ?></div>
                    <div class="col col-3" data-label="Amount"><?php echo $row['num_events']; ?></div>
                    <div class="col col-4" data-label="Payment Status">
    
        <button class="btn open-button" onclick="openForm()" type="button">
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
            }
        }
        ?>
    </ul>
</div>



<div class="container">
    <div class="table-responsive">
        <h3 class="fancy">Evenements</h3>
        <form method="GET">
            <input type="text" name="event_search" placeholder="Search for events...">
            <button type="submit">Search</button>
        </form>

        <ul class="responsive-table">
            <li class="table-header li_head">
                <div class="col col-1">Id</div>
                <div class="col col-2">Nom Evenement</div>
                <div class="col col-3">Numero des participants</div>
                <div class="col col-4">Action</div>
            </li>

            <?php
            $search = isset($_GET['event_search']) ? $_GET['event_search'] : '';

            if ($search !== '') {
                $sql = "SELECT * FROM event WHERE TITRE LIKE '%$search%'";
            } else {
                $sql = "SELECT * FROM event";
            }
            $result = mysqli_query($link, $sql);

            if (mysqli_num_rows($result) > 0) {
                // output data of each row
                while ($row = mysqli_fetch_assoc($result)) { ?>
                    <li class="table-row">
                        <div class="col col-1"><?php echo $row['ID_EVENT']; ?></div>
                        <div class="col col-2"> <?php echo $row['TITRE']; ?></div>
                        <div class="col col-3"> <?php echo 1 ?></div>
                        <div class="col col-4">
                            <a href="edit_event.php/<?php echo $row['ID_EVENT']; ?>"
                               style="display: inline-block; margin-right: 10px;">
                                <button type="button" class="btn">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </a>
                            <form method="post" action="delete_event.php" style="display: inline-block;">
                                <input type="hidden" name="event_delete" value="<?php echo $row['ID_EVENT']; ?>">
                                <button type="submit" name="delete_event" class="btn">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </div>
                    </li>
                    <?php
                }
            }
            mysqli_close($link);
            ?>
        </ul>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/js/bootstrap.bundle.min.js"></script>


<script>
    function openForm() {
        document.getElementById("myForm").style.display = "block";
    }

    function closeForm() {
        document.getElementById("myForm").style.display = "none";
    }
</script>



</body>
</html>
