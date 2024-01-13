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
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function () {
            $("#addCategoryLink").click(function () {
                $("#addCategoryModal").modal("show");
            });
        });
    </script>
    <script>
    $(document).ready(function () {
        $("#search").on("input", function () {
            var searchValue = $(this).val();

            // Use AJAX to fetch search results
            $.ajax({
                url: "search_categories.php", // Replace with your actual PHP file for searching categories
                method: "GET",
                data: { category_search: searchValue },
                success: function (response) {
                    // Update the content with the new search results
                    $(".responsive-table").html(response);
                }
            });
        });
    });
</script>
<script>
$(document).ready(function () {
    $("#search_event").on("input", function () {
        var searchValue = $(this).val();

        // Use AJAX to fetch search results
        $.ajax({
            url: "search_events.php", // Replace with your actual PHP file for searching events
            method: "GET",
            data: { event_search: searchValue },
            success: function (response) {
                // Update the content with the new search results
                $(".responsive-table").html(response);
            }
        });
    });
});
</script>


    <style>

#search:focus {
    outline: none;
    border: 2px solid black; /* or any other border style you prefer */
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
}
#search {
    border-width: 1px; /* Set the border width to 1px */
    border-color: #ccc;
}

h3.activated{
  background-size: 100% 100%;
  background-position: 0% 100%;
  transition: background-position 0.7s, background-size 0.5s ease-in-out;
}

    </style>
    <link rel="stylesheet" href="dash_styles.css">
    <title>Dashboard</title>

</head>

<body>

<?php
        include("sidebar.php");
    ?>

    <div class="modal fade" id="addCategoryModal" tabindex="-1" role="dialog" aria-labelledby="addCategoryModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCategoryModalLabel">Ajouter catégorie</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Add Category Form -->
                    <form id="addCategoryForm" method="post" action="add_cat.php">
                        <div class="form-group">
                            <label for="categoryName">Nom Catégorie</label>
                            <input type="text" class="form-control" id="categoryName" name="categoryName" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Ajout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

<div class="container">
    <h3>Catégories</h3>
    <form method="GET" class="search-bar">
        <input type="text" name="category_search" id="search" placeholder="Search..."
            style="border: 1px solid #ccc; border-radius: 10px; box-shadow: 0 0 5px rgba(0, 0, 0, 0.1); padding:0.3rem 0.7rem 0.3rem 0.8rem;margin-bottom:0.5rem;">
    </form>

    <ul class="responsive-table">
        <li class="table-header">
            <div class="col col-1">Id</div>
            <div class="col col-2">Nom Categorie</div>
            <div class="col col-3">Numero des évènments</div>
            <div class="col col-4">Action</div>
        </li>

        <?php
        $j = 1;
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $_SESSION["id" . $row['ID_CATEGORIE']] = $row['ID_CATEGORIE'];
                ;

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
        }
        ?>
    </ul>
</div>
<!-- Add this within your <body> tag -->
<div class="form-popup" id="myForm"
    style="display:none;color:white;position:absolute;background:#014373;left:32rem;padding:0.6rem 1.3rem 1.7rem 1.3rem;border-radius:20px;bottom:12rem;filter: none;">
    <form action="update_categorie.php" method="post" class="form-container" onsubmit="submitForm()">
        <h2>Edit Category</h2>

        <div class="form-group">
            <label for="categoryName"><b>Nom du Categorie</b></label>
            <input type="text" class="form-control" value="" placeholder="Enter Category Name" name="categoryName"
                required>
        </div>

        <!-- Include a hidden input field to store the category ID -->
        <input type="hidden" name="categoryId" id="categoryId" value="">

        <button type="submit" class="btn btn-primary">Update</button>
        <button type="button" class="btn cancel btn-danger" onclick="closeForm()">Close</button>
    </form>
</div>



<div class="container" style="overflow:hidden;">
    <div class="table-responsive" style="overflow:hidden;">
        <h3 class="fancy">Evenements</h3>
        <form method="GET">
        <input type="text" id="search_event" name="event_search" placeholder="Search..."
            style="border: 1px solid #ccc; border-radius: 10px; box-shadow: 0 0 5px rgba(0, 0, 0, 0.1); padding:0.3rem 0.7rem 0.3rem 0.8rem;margin-bottom:0.5rem;">
    </form>

        <ul class="responsive-table" style="overflow:hidden;">
            <li class="table-header li_head" style="overflow:hidden;">
                <div class="col col-1">Id</div>
                <div class="col col-2">Nom Evenement</div>
                <div class="col col-2">Description</div>
                <div class="col col-2">Categorie</div>
                <div class="col col-3">Numero des participants</div>
                <div class="col col-4">Action</div>
            </li>

            <?php
            $search = isset($_GET['event_search']) ? $_GET['event_search'] : '';

            if ($search !== '') {
                $sql = "SELECT event.*, COUNT(inscription.ID_USER) AS num_participants
                            FROM event
                            LEFT JOIN inscription ON event.ID_EVENT = inscription.ID_EVENT
                            WHERE event.TITRE LIKE '%$search%'
                            GROUP BY event.ID_EVENT
                            ORDER BY event.ID_EVENT DESC";
            } else {
                $sql = "SELECT event.*, COUNT(inscription.ID_USER) AS num_participants
                            FROM event
                            LEFT JOIN inscription ON event.ID_EVENT = inscription.ID_EVENT
                            GROUP BY event.ID_EVENT
                            ORDER BY event.ID_EVENT DESC";
            }

            $result = mysqli_query($link, $sql);

            $i = 1;

            if (mysqli_num_rows($result) > 0) {
                // output data of each row
                while ($row = mysqli_fetch_assoc($result)) { ?>
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
                            <!-- <button class="btn open-button" onclick="openParticipantModal(<?php echo $row['ID_EVENT']; ?>)"> -->
                            <?php echo $row['num_participants']; ?>
                            <!-- </button> -->
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
            mysqli_close($link);
            ?>
        </ul>
    </div>
</div>

<div class="form-popup" id="eventForm"
    style="display:none;position:absolute;color:white;background:#014373;left:30rem;padding:0.6rem 1.3rem 2rem 1.3rem;border-radius:20px;top:3rem;max-width:400px;filter: none;">
    <form action="update_event.php" method="post" class="form-container" onsubmit="submitFormEvent()">
        <h2>Edit Event</h2>
        <div class="form-group">
            <label for="eventName">Nom Evenement</label>
            <input type="text" class="form-control" value="" name="eventName" required>
        </div>
        <div class="form-group">
            <label for="eventDesc">Description</label>
            <input type="text" class="form-control" value="" name="eventDesc" required>
        </div>
        <div class="form-group">
            <label for="eventloc">Location</label>
            <input type="text" class="form-control" value="" name="eventloc" required>
        </div>
        <div class="form-group">
            <label for="eventDate">Date</label>
            <input type="date" class="form-control" value="" name="eventDate" required>
        </div>

        <input type="hidden" name="eventId" id="eventId" value="">
        <button type="submit" class="btn btn-primary">Update</button>
        <button type="button" class="btn cancel btn-danger" onclick="closeFormEvent()">Close</button>
    </form>
</div>

<div class="modal" id="participantModal">
    <div class="modal-content">
        <span class="close" onclick="closeParticipantModal()">&times;</span>
        <h2>Participants</h2>
        <ul id="participantList"></ul>
    </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/js/bootstrap.bundle.min.js"></script>



<script>
    var categoryId;
    var eventId;

    function openFormEvent(id) {
        eventId = id;

        document.getElementById("eventId").value = eventId;

        var form = document.getElementById("eventForm");
        form.style.display = "block";

        form.style.filter = "none";

        var elementsToBlur = document.querySelectorAll(".container, .navbar");
        elementsToBlur.forEach(function (element) {
            element.style.opacity = 0.3;
        });

        var windowHeight = window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight;
        var formHeight = form.clientHeight;
        form.style.top = (windowHeight - formHeight) / 2 + "px";

        form.scrollIntoView({ behavior: 'smooth' });
    }

    function closeFormEvent() {
        // Hide the form
        document.getElementById("eventForm").style.display = "none";

        // Restore full opacity to the background
        var body = document.getElementsByTagName("body")[0];
        body.style.opacity = 1;

        // Restore full opacity for container and navbar
        var elementsToBlur = document.querySelectorAll(".container, .navbar");
        elementsToBlur.forEach(function (element) {
            element.style.opacity = 1;
        });
    }

    function submitFormEvent() {
        // Use AJAX or any method to send the data to update_event.php
        var name = document.getElementById("eventName").value;

        // Use Fetch API to send the data to update_event.php
        fetch("update_event.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: "eventName=" + encodeURIComponent(name) + "&eventId=" + eventId
        })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                // Handle the response as needed
            })
            .catch(error => console.error("Error:", error));
    }
    function openForm(id) {
        categoryId = id;

        // Set the category ID in the hidden input field
        document.getElementById("categoryId").value = categoryId;

        // Display the form
        var form = document.getElementById("myForm");
        form.style.display = "block";

        form.style.filter = "none";

        var elementsToBlur = document.querySelectorAll(".container, .navbar");
        elementsToBlur.forEach(function (element) {
            element.style.opacity = 0.3;
        });

        // Center the form
        var windowHeight = window.innerHeight || document.documentElement.clientHeight || document.body.clientHeight;
        var formHeight = form.clientHeight;
        form.style.top = (windowHeight - formHeight) / 2 + "px";
    }

    function closeForm() {
        // Hide the form
        document.getElementById("myForm").style.display = "none";

        // Restore full opacity to the background
        var body = document.getElementsByTagName("body")[0];
        body.style.opacity = 1;

        // Restore full opacity for container and navbar
        var elementsToBlur = document.querySelectorAll(".container, .navbar");
        elementsToBlur.forEach(function (element) {
            element.style.opacity = 1;
        });
    }



    function submitForm() {
        // Use AJAX or any method to send the data to update_categorie.php
        var name = document.getElementById("categoryName").value;

        // Use Fetch API to send the data to update_categorie.php
        fetch("update_categorie.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: "categoryName=" + encodeURIComponent(name) + "&categoryId=" + categoryId
        })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                // Handle the response as needed
            })
            .catch(error => console.error("Error:", error));
    }

    function handleInput(event) {
        if (event.keyCode === 13) {
            event.preventDefault(); // Prevent the form from being submitted twice
            document.forms[0].submit(); // Submit the form
        }
    }
    window.addEventListener("load", () => {
    const titles = Array.from(document.getElementsByTagName("h3"));

    titles.map((title) => {
        title.classList.add("activated");
    })
});
</script>



</body>

</html>
