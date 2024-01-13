<?php
session_start();
include("connexion.php");
if(isset($_SESSION['loggedin'])&& $_SESSION['loggedin'] == true){


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="event_styles.css">
    <title>Events</title>
    <style>
    .icon-github {
        transition: color 0.3s ease;
        /* Transition duration and easing */
    }

    .icon-linkedin {
        transition: color 0.3s ease;
        /* Transition duration and easing */
    }

    .icon-twitter {
        transition: color 0.3s ease;
        /* Transition duration and easing */
    }

    .icon-linkedin:hover {
        color: #0077B5;
        /* LinkedIn Blue */
    }

    .icon-github:hover {
        color: #000000;
        /* GitHub Black */
    }

    .icon-twitter:hover {
        color: #1DA1F2;
        /* Twitter Blue */
    }

    .overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.7);
        align-items: center;
        justify-content: center;
        z-index: 1;
    }

    .terms-popup {
        background-color: #fff;
        padding: 20px;
        max-width: 600px;
        width: 80%;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
        text-align: left;
    }

    .close-popup-btn {
        background-color: #007BFF;
        /* Button color */
        color: #fff;
        /* Text color */
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        margin-top: 10px;
    }

    .close-popup-btn:hover {
        background-color: #0056b3;
        /* Hover color */
    }

    .first {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    /* Style for the footer */
    .footer {
        background-color: #1b4353;
        color: white;
        padding: 20px 0 0 0;
    }

    .footer-content {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-around;
        margin-left: 250px;
    }

    .footer-section {
        flex: 1;
        min-width: 200px;

    }

    .footer-section h2 {
        font-size: 1.5em;
        margin-bottom: 10px;
    }

    .footer-section p {
        font-size: 1em;
    }

    .footer-section ul {
        list-style-type: none;
    }

    .footer-section a {
        color: #fff;
        text-decoration: none;
    }

    .footer-bottom {
        text-align: center;
        padding-top: 10px;
        background-color: #113442;
        margin: 0;
        padding: 1rem;
        margin-top: 15px;
    }

    .footer-bottom p {
        font-size: 0.8em;
    }

    iframe {
        height: 200px;
        width: 200px;
    }
    </style>
</head>

<body>
    <div class="header">
        <nav>
            <img width='150px' src="img/ensa1.png">
            <ul>
                <li><a href="home.php">Accueil</a></li>
                <li><a href="events.php">Événements</a></li>
                <li><a href="authentification_admin.php">Admin</a></li>
                <li><a href="deconnexion_etudiant.php">Déconnexion</a></li>
            </ul>
        </nav>
    </div>

    <main>
        <div class="first">
            <div class="slider"
                style="box-shadow: rgba(50, 50, 93, 0.25) 0px 50px 100px -20px, rgba(0, 0, 0, 0.3) 0px 30px 60px -30px;">
                <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img class="d-block w-100" src="images/ev3.jpeg" alt="First slide">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100" src="images/ev2.jpeg" alt="Second slide">
                        </div>
                        <div class="carousel-item">
                            <img class="d-block w-100" src="images/ev1.jpeg" alt="Third slide">
                        </div>
                    </div>
                    <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
        </div>

        <div class="sec">
            <h2 class="titre">
                Nos Événement</h2>
            <div class="cards">
                <?php
                $sql = "SELECT * FROM event";
                $result = mysqli_query($link, $sql);

                if (mysqli_num_rows($result) > 0) {
                  while ($row = mysqli_fetch_assoc($result)) {
                    echo "<div class='card'>";
                    echo "<a href='detail.php'>";
                    echo "<div class='card-body'>";
                    echo "<img class='card_image' src='photo/{$row['IMAGE']}' alt='Event Image' style='width: 250px;'>";
                    echo "<p class='card-text nom'>{$row['TITRE']}</p>";
                    echo "<p class='card-text date'>Date: {$row['DATE']}</p>";
                    echo "</div>";
                    echo "<div class='card-text card-map'>";
                    echo $row['LOCATION'];
                    echo "</div>";
                    echo "<button class='card-button'>More info</button>";
                    echo "</a></div>";
                  }
                }
                mysqli_close($link);
                ?>
            </div>

        </div>
        </div>




    </main>
    <footer>
        <div class="footer">
            <div class="footer-content">
                <div class="footer-section about">
                    <h2>A propos notre projet</h2>
                    <p>Projet pour le module de technologie web encadré par la professeure Ilham Oumaira.</p>
                </div>
                <div class="footer-section contact">
                    <h2>Contact Us</h2>
                    <p>Douaa Saddiqe</p>
                    <p><a href="mailto:douaa.saddiqe@uit.ac.ma">Envoyer un Email</a></p><br>
                    <p>Rihab Semmar</p>
                    <p><a href="mailto:rihab.semmar@uit.ac.ma">Envoyer un Email</a></p><br>
                    <p>Sara Foukhar</p>
                    <p><a href="mailto:sara.foukhar@uit.ac.ma">Envoyer un Email</a></p><br>
                    <p>Yasser Salhi</p>
                    <p><a href="mailto:yasser.salhi@uit.ac.ma">Envoyer un Email</a></p>
                </div>
                <div class="footer-section links">
                    <h2>Quick Links</h2>
                    <ul>
                        <li>
                            <a href="home.php">Home</a>
                        </li>
                        <li>
                            <a href="#">Services</a>
                        </li>
                        <li>
                            <a href="https://ensa.uit.ac.ma/">About</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2024 Projet Web | Module : Technology Web</p>
            </div>
        </div>
    </footer>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
    $(document).ready(function() {
        // Add smooth scrolling to all links with the 'scroll-to-top' class
        $(".scroll-to-top").on('click', function(event) {
            event.preventDefault();

            $('html, body').animate({
                scrollTop: 0
            }, 800); // Adjust the duration as needed (in milliseconds)
        });
    });

    function openTermsPopup() {
        document.getElementById('termsOverlay').style.display = 'flex';
    }

    function closeTermsPopup() {
        document.getElementById('termsOverlay').style.display = 'none';
    }
    </script>

</body>
<?php
}else{
    header("location: index.php");
}
?>
</html>
