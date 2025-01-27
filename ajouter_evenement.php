<?php 
include('connexion.php');
require 'PHPMailer-master/lib/Exception.php';
require 'PHPMailer-master/lib/PHPMailer.php';
require 'PHPMailer-master/lib/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


session_start();
if(isset($_POST['sub'])){
$titre = mysqli_real_escape_string($link, $_POST['titre']);
$description = mysqli_real_escape_string($link, $_POST['description']);
$date = mysqli_real_escape_string($link, $_POST['date']);
$location = mysqli_real_escape_string($link, $_POST['location']);
$id_categorie = mysqli_real_escape_string($link, $_POST['id_categorie']);
    $id_admin=$_SESSION['ID_ADMIN'];
	
	if(isset($_FILES['fichier']) and $_FILES['fichier']['error']==0)
	{
		$dossier= 'photo/';
		$temp_name=$_FILES['fichier']['tmp_name'];
		if(!is_uploaded_file($temp_name))
		{
		exit("le fichier est untrouvable");
		}
		if ($_FILES['fichier']['size'] >= 1000000){
			exit("Erreur, le fichier est volumineux");
		}
		$infosfichier = pathinfo($_FILES['fichier']['name']);
		$extension_upload = $infosfichier['extension'];
		
		$extension_upload = strtolower($extension_upload);
		$extensions_autorisees = array('png','jpeg','jpg');
		if (!in_array($extension_upload, $extensions_autorisees))
		{
		exit("Erreur, Veuillez inserer une image svp (extensions autorisées: png)");
		}
		$nom_photo=$titre.".".$extension_upload;
		if(!move_uploaded_file($temp_name,$dossier.$nom_photo)){
		exit("Problem dans le telechargement de l'image, Ressayez");
		}
		$ph_name=$nom_photo;
	}
	else{
		$ph_name="inconnu.jpg";
	}
	$requette="INSERT INTO event (TITRE,DESCRIPTION,DATE,LOCATION,ID_CATEGORIE,ID_ADMIN,IMAGE) VALUES('$titre','$description','$date','$location','$id_categorie',$id_admin,'$ph_name')";
	$resultat=mysqli_query($link,$requette);



 // Récupérez les e-mails des utilisateurs depuis la base de données
 $result = mysqli_query($link, "SELECT EMAIL FROM user");
 $liste_emails = array();
 while ($row = mysqli_fetch_assoc($result)) {
     $liste_emails[] = $row['EMAIL'];
 }

 // Envoyer un e-mail à chaque utilisateur
 foreach ($liste_emails as $email) {
     $mail = new PHPMailer(true);

     try {
         // Paramètres du serveur SMTP
         $mail->isSMTP();
         $mail->Host = 'smtp.gmail.com'; // Remplacez par le serveur SMTP approprié
         $mail->SMTPAuth = true;
         $mail->Username = 'saddiqedouaa00@gmail.com'; // Remplacez par votre adresse e-mail SMTP
         $mail->Password = 'osuq smvw euvf bvkm'; // Remplacez par votre mot de passe SMTP
         $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
         $mail->Port = 587;

         // Destinataire
         
         $mail->setFrom('saddiqedoua00@gmail.com', 'Douaa');
         $mail->addAddress($email);

         // Contenu de l'e-mail
         $mail->isHTML(true);
         $mail->Subject = "Nouvel evenement : $titre";
         $mail->Body = "Bonjour,<br><br>Nous avons ajouté un nouvel événement \"$titre\" le $date à $location.Consultez-le sur notre site : <a href='http://localhost/projetensa/events.php'>events</a> !<br><br>Cordialement,<br>Votre équipe organisatrice.";

         // Envoyer l'e-mail
         $mail->send();
     } catch (Exception $e) {
         // Gérer les erreurs
         echo "Erreur lors de l'envoi de l'e-mail : {$mail->ErrorInfo}";
     }
 }

	header('location:dashboard.php');
}

?>

<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8" />
    <title>Ajouter un évenement</title>
    <style>
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-image: url('images/ensa2.jpeg'); /* Remplacez 'votre_image.jpg' par le nom de votre image */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            margin: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        #monform {
            width: 50%;
            margin-top: 20px;
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color:white;
            padding: 8px;
            font-size: 40x;
            text-align: center;
            text-transform: capitalize;
            background-color: #1b4353;
        }

        label {
            display: block;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        input, select {
            display: block;
            width: 90%;
            height: 40px;
            margin: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            padding: 5px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            width: 100%;
            padding: 9px;
            background-color: #1b4353;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        input[type="submit"]:hover {
            background-color: #1565C0;
        }
        textarea {
    width: 90%;
    height: 90px;
    margin: 10px;
    border-radius: 5px;
    border: 1px solid #ccc;
    padding: 5px;
    box-sizing: border-box;
    resize: vertical; /* Allow vertical resizing */
        }
input::placeholder,
textarea::placeholder {
    color: #1b4353; /* Placeholder text color */
    font-size: 14px; /* Placeholder font size */
        }
        #buttons-container {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
        }

        #buttons-container button {
            width: calc(50% - 5px);
            padding: 12px; /* Increased padding for a larger size */
            background-color: #1b4353;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        #dashboard-link {
            width: calc(50% - 5px);
            text-align: center;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        #dashboard-link a {
            width: 100%;
            padding: 12px;
            background-color: #1b4353;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            text-decoration: none;
        }


    </style>
	</head>
    <body>
		<h1>ajouter un évenement</h1>
		<form action="" method="post" id="monform" enctype="multipart/form-data">
            <label for="titre">Titre</label>
            <input type="text" name="titre" placeholder="Saisissez le titre" required>

			<label for="description">Description</label>
            <textarea name="description" placeholder="Saisissez la description" required></textarea>

			<label for="date">Date</label>
            <input type="date" name="date" required>

            <label for="location">Location</label>
            <input type="text" name="location" placeholder="Saisissez la location" required>

            <label for="id_categorie">Catégorie</label>
            <select name="id_categorie" required>
                <?php
            $result= mysqli_query($link, "SELECT* FROM categorie");
            while ($row = mysqli_fetch_assoc($result)) {
                echo"<option value='". $row['ID_CATEGORIE']. "'>" . $row['LABEL']."</option>";
            }
            ?>
            
			<label for="fichier">Image</label>
			<input type="file" name="fichier"/>
            <div id="buttons-container">
            <input type="submit" name="sub" value="Valider" style="width: 200px;text-align: center;">
            <div id="dashboard-link">
                <a href="dashboard.php">
                    Retourner au tableau de bord
                </a>
            </div>
            </div>

		</form>
    
	</body>
</html>
<?php mysqli_close($link); ?>
