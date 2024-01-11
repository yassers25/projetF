<?php
if(isset($_POST['submit']))
{
    header("Location: https://ensa.uit.ac.ma/");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="home.css">
</head>
<body>
    <div class="header">
        <div class="line">
        <nav>
            <img width='150px' src="img/ensa1.png">
            <ul>
                <li><a href="">Accueil</a></li>
                <li><a href="detail.php">Nos Evenements</a></li>
                <li><a href="formulaire.php">Inscription</a></li>
            </ul><br>
           
        </div>
        </nav>
        <form action="#" method="post">
            <input type="submit" name="submit" value="Visiter notre site">
        </form>
    </div>
    <section class="section1">
        <br><br><br><br>
        <h1>À propos de nous:</h1>
        <p class="para1">L’Ecole Nationale des Sciences Appliquées de Kénitra (ENSAK) a été créée en 2008. Sa Majesté le Roi Mohammed VI a procédé le Lundi 13 0ctobre 2008 à la pose de la première pierre pour la construction des locaux de l’établissement. L’ENSAK a pour vocation de former des ingénieurs d’état dans des domaines scientifiques et techniques mais avec des compétences en management et en communication. L’ouverture de l’ENSAK vient conforter les efforts déployés tant au niveau national que régional visant à répondre au programme national de formation des 10 000 ingénieurs. quatre cycles ingénieurs sont ouverts dans des spécialités susceptibles de connaître d’importants développements. </p>

    </section>
    <section class="section2">
        <br><br><br><br>
        <h1>Nos événements:</h1><br><br>
        <img class="forum" src="img/forum.png">
        <img class="forum1" width ="1246px" height="870px" src="img/event11.jpg">
        <img class="march" src="img/march.png">
        <img class="march1" width ="1246px" height="870px" src="img/march1.jpg">
</section>
<section class="section3">
        <h1 class="text">Découvrez nos clubs: </h1>
        <div class="container">
            <div class="club">
                <img width ="80px" class="image" src="img/arsura (2).png" alt="Club arsura">
                <h3>Club Arsura</h3>
                <p>Le club Arsura de l'art embrasse la créativité sous toutes ses formes, unissant les passionnés de l'expression artistique au sein de notre communauté scolaire.</p>
                <a href="https://www.instagram.com/arsura.ensak/?hl=en">Visitez notre page instagram</a>
            </div>

            <div class="club">
                <img width ="80px" class="image" src="img/anaruz.png" alt="Club Anaruz">
                <h3>Club Anaruz</h3>
                <p>
                    Le club Anaruz : Une source d'espoir pour tous.</p>
                    <a href="https://www.instagram.com/anaruz.ensak/?hl=en">Visitez notre page instagram</a>
            </div>
            <div class="club">
                <img width ="80px" class="image" src="img/ches.png" alt="Club chess">
                <h3>Club De Chess</h3>
                <p>
                    
Le club d'échecs offre une passionnante exploration stratégique et intellectuelle du jeu royal.</p>
<a href="https://www.instagram.com/anaruz.ensak/?hl=en">Visitez notre page instagram</a>
            </div>
            <div class="club">
                <img width ="80px" class="image" src="img/eic (2).png" alt="Club eic">
                <h3>Club EIC</h3>
                <p>
                    Le Club EIC d'informatique offre une communauté dynamique et passionnée, propice à l'apprentissage et à l'exploration des domaines informatiques.</p>
                    <a href="https://www.instagram.com/ensak_informatics_club/?hl=en">Visitez notre page instagram</a>
            </div>
            <div class="club">
                <img width ="80px" class="image" src="img/google.png" alt="Club green invest">
                <h3>Club De Google</h3>
                <p>Le club Google d'informatique offre une communauté dynamique pour les passionnés de technologie, favorisant l'apprentissage, la collaboration et l'innovation.</p>
                <a href="https://www.instagram.com/anaruz.ensak/?hl=en">Visitez notre page instagram</a>
            </div>
            <div class="club">
                <img width ="80px" class="image" src="img/meca (2).png" alt="Club green invest">
                <h3>Club Mecatronique</h3>
                <p>Le club de mécatronique allie la mécanique et l'électronique pour explorer l'innovation technologique.</p>
                <a href="https://www.instagram.com/club_mecatronique_ensak/?hl=en">Visitez notre page instagram</a>
            </div>
            <div class="club">
                <img width ="80px" class="image" src="img/enactus (2).png" alt="Club enactus">
                <h3>Club Enactus</h3>
                <p>
                    Enactus : Le club dédié à l'entrepreneuriat social et à l'innovation pour un impact positif.</p>
                    <a href="https://www.instagram.com/enactusensakenitraa/?hl=en">Visitez notre page instagram</a>
            </div>
            <div class="club">
                <img width ="80px" class="image" src="img/gdk.png" alt="Club gdk">
                <h3>Club Great Debaters</h3>
                <p>Les Great Debaters : Maîtres de l'art de la persuasion et des débats percutants.</p>
                <a href="https://www.instagram.com/great.debaters_ensak/?hl=en">Visitez notre page instagram</a>
            </div>
            <div class="club">
                <img width ="80px" class="image" src="img/green.png" alt="Club green invest">
                <h3>Club Green Invest</h3>
                <p>Club Green Invest : Promouvoir la durabilité à travers des initiatives éco-responsables et des investissements respectueux de l'environnement</p>
                <a href="https://www.instagram.com/greeninvest.ensak/?hl=en">Visitez notre page instagram</a>
            </div>
            <div class="club">
                <img  width ="80px"class="image" src="img/Picsart_23-12-04_18-45-47-906 (1).png" alt="Club afaak">
                <h3>Afaaq</h3>
                <p>Le Club Affaq de Charité œuvre pour la solidarité et l'impact social.</p>
                <a href="https://www.instagram.com/club_afaaq/?hl=en">Visitez notre page instagram</a>
            </div>
        </div>
</section>
</body>
</html>