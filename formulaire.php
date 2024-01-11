<?php 
include('connexion.php');
session_start();
if(isset($_POST['sub'])){
	$NOM=$_POST['NOM'];
	$PRENOM=$_POST['PRENOM'];
	$TEL=$_POST['TEL'];
	$DATE_NAISSANCE=$_POST['DATE_NAISSANCE'];
    $PASSWORD=$_POST['PASSWORD'];
    $EMAIL=$_POST['EMAIL'];
    $GENDER=$_POST['GENDER'];
    $ADRESSE=$_POST['ADRESSE'];

    if (strpos($EMAIL, '@uit.ac.ma') === false) {
        $alertMessage = "Erreur, l'email doit se terminer par '@uit.ac.ma'";
    } else {

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
		$nom_photo=$NOM.".".$extension_upload;
		if(!move_uploaded_file($temp_name,$dossier.$nom_photo)){
		exit("Problem dans le telechargement de l'image, Ressayez");
		}
		$ph_name=$nom_photo;
	}
	else{
		$ph_name="inconnu.jpg";
	}
	$requette="INSERT INTO user (PASSWORD, EMAIL,NOM,PRENOM,GENDER,ADRESSE,TEL,DATE_NAISSANCE,photo) VALUES('$PASSWORD','$EMAIL','$NOM','$PRENOM','$GENDER','$ADRESSE','$TEL','$DATE_NAISSANCE','$ph_name')";
	$resultat=mysqli_query($link,$requette);
    header('location: login.php');
}
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>formulaire</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <header>
    <div class="background-container">
      <div class="overlay-container">  
        <img src="img/cropped-ensak-logo.png" alt="Overlay Image">
      </div>
  </div>
  </header>
  <section class="container">
    <h1>Registration Form</h1>
    <?php
    if (!empty($alertMessage)) {
        echo '<script>alert("' . $alertMessage . '");</script>';
    }
    ?>

    <form action="" method="post" class="form"  id="monform" enctype="multipart/form-data">
      <div class="input-box">
        <label for="NOM">Nom:</label>
        <input type="text" placeholder="Entrer le nom" name="NOM" required/>
      </div>

      <div class="input-box">
        <label for="PRENOM">Prenom:</label>
        <input type="text" placeholder="Entrer prenom" name="PRENOM" required/>
      </div>

      <div class="column">
        <div class="input-box">
          <label for="TEL">Numero de telephone:</label>
          <input type="number" placeholder="Entrer numero de telephone" name="TEL" required />
        </div>
        <div class="input-box">
          <label for="DATE_NAISSANCE">Date de naissance</label>
          <input type="date" placeholder="Entrer la date de naissance" name="DATE_NAISSANCE" required/>
        </div>
        <div class="input-box">
          <label for="PASSWORD">Password:</label>
          <input type="password" name="PASSWORD" placeholder="Entrer le mot de passe" required/>
        </div>
        <div class="input-box">
          <label for="EMAIL">Email:</label>
          <input type="email" name="EMAIL" placeholder="Entrer l'email" required/>
        </div>
      </div>
      <div class="gender-box">
        <h3>Sexe: </h3>
        <div class="gender-option">
          <div class="gender">
            <input type="radio" id="check-male" name="GENDER" value="male" checked />
            <label for="check-male">male</label>
          </div>
          <div class="gender">
            <input type="radio" id="check-female" name="GENDER" value="Female" />
            <label for="check-female">Female</label>
          </div>
        </div>
      </div>
      <div class="input-box address">
        <label for="ADRESSE">Address: </label>
        <input type="text" placeholder="Entrer votre address" name="ADRESSE" required/>
      </div>
      <div class="input-box">
            <label for="fichier">Photo:</label>
            <input type="file" name="fichier" />
        </div>
      <div class="register">
        <input type="submit" value="Register" name="sub">
      </div>
    </form>
  </section>
</body>
</html>
