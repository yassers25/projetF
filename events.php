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
</head>

<body>
  <nav>
    <div class="logo">
      <img src="images/cropped-ensak-logo.png">
    </div>
    <ul>
      <li><a href="home.php">Home</a></li>
      <li><a href="login.php">Login</a></li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
          aria-haspopup="true" aria-expanded="false">
          Catégories
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item dropd" href="#">
            <?php
            session_start();
            include("connexion.php");

            $sql = "SELECT LABEL FROM categorie";
            $res = mysqli_query($link, $sql);

            if ($res && mysqli_num_rows($res) > 0) {
              while ($row = mysqli_fetch_assoc($res)) {
                echo '<a class="dropdown-item dropd" href="' . $row["LABEL"] . '">' . $row["LABEL"] . '</a>';
              }
            } else {
              echo "No categories found.";
            }
            ?>
          </a>

        </div>
      </li>
    </ul>
  </nav>

  <main>
    <div class="first">
      <div class="slider">
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
    <main>
        <div class="sec">
            <h2 class="titre"
                style="font-size:40px;padding-top:4rem;font-family:Montserrat;margin-bottom:4rem;display:flex;justify-content:center;color:white;font-weight:aliceblue;">
                Nos Événement</h2>
            <div class="cards">
                <?php
                $sql = "SELECT * FROM event";
                $result = mysqli_query($link, $sql);

                if (mysqli_num_rows($result) > 0) {
                  while ($row = mysqli_fetch_assoc($result)) {
                    echo "<div class='card' style='width: 18rem;'>";
                    echo "<a href='detail.php'>";
                    echo "<div class='card-body'>";
                    echo "<img src='images/{$row['IMAGE']}' alt='Event Image' style='width: 250px;'>";
                    echo "<p class='card-text nom'>{$row['TITRE']}</p>";
                    echo "<p class='card-text descr'>{$row['DESCRIPTION']}</p>";
                    echo "<p class='card-text date'>Date: {$row['DATE']}</p>";
                    echo "</div>";
                
                    // Intégration de la carte statique
                    echo "<a href='https://www.google.com/maps/place/{$row['LOCATION']}' target='_blank'>";
                    echo "<img class='static-map' src='https://maps.googleapis.com/maps/api/staticmap";
                    echo "?center=" . urlencode($row['LOCATION']);
                    echo "&zoom=14&size=400x300&markers=" . urlencode($row['LOCATION']);
                    echo "&key=AIzaSyBoOHltGZJotjevTOgiapTzimAi_LGdA2k' alt='Carte Statique' />";
                    echo "</a>";
                
                    echo "<button class='card-button'>More info</button>";
                    echo "</a></div>";
                }
                }
                mysqli_close($link);
                ?>
            </div>
        </div>
    </main>
  </main>




  <div class="footer-basic">
    <footer>
      <div class="social" style="display: flex;
    justify-content: center;
    align-items: center;
    margin-top: 4rem;">
        <details class="dropdown">
          <summary role="button">
            <a class="button"><i class="icon ion-social-linkedin"
                style="font-size: 50px;margin-right:2rem;margin-left:2rem;"></i></a>

            </a>
          </summary>
          <ul>
            <li><a href="https://www.linkedin.com/in/sara-foukhar-65431b237/">Foukhar Sara</a></li>
            <li><a href="#">Salhi Yasser</a></li>
            <li><a href="#">Semmar Rihab</a></li>
            <li><a href="#">Saddiqe Douaa</a></li>
          </ul>

        </details>


        <details class="dropdown">
          <summary role="button">
            <a class="button"><i class="icon ion-social-twitter"
                style="font-size: 50px;margin-right:2rem;margin-left:2rem;"></i></a>

            </a>
          </summary>
          <ul>
            <li><a href="#">Foukhar Sara</a></li>
            <li><a href="#">Salhi Yasser</a></li>
            <li><a href="#">Semmar Rihab</a></li>
            <li><a href="#">Saddiqe Douaa</a></li>
          </ul>

        </details>

        <details class="dropdown">
          <summary role="button">
            <a class="button"><i class="icon ion-social-github"
                style="font-size: 50px;margin-right:2rem;margin-left:2rem;"></i></a>

            </a>
          </summary>

          <ul>
            
            <li><a href="https://github.com/FoukharSara">Foukhar Sara</a></li>
            <li><a href="#">Salhi Yasser</a></li>
            <li><a href="#">Semmar Rihab</a></li>
            <li><a href="#">Saddiqe Douaa</a></li>
          </ul>

        </details>
      </div>



      <ul class="list-inline">
        <li class="list-inline-item"><a href="#">Home</a></li>
        <li class="list-inline-item"><a href="#">Services</a></li>
        <li class="list-inline-item"><a href="#">About</a></li>
        <li class="list-inline-item"><a href="#">Terms</a></li>
        <li class="list-inline-item"><a href="#">Privacy Policy</a></li>
      </ul>
      <p class="copyright">ENSAK © 2024</p>
    </footer>


  </div>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/js/bootstrap.bundle.min.js"></script>
</body>

</html>
