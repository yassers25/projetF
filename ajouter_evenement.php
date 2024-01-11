<?php 
include('connexion.php');
session_start();
if(isset($_POST['sub'])){
	$titre=$_POST['titre'];
	$description=$_POST['description'];
	$date=$_POST['date'];
    $location=$_POST['location'];
    $id_categorie=$_POST['id_categorie'];
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
	$requette="INSERT INTO event (TITRE, DESCRIPTION,DATE,LOCATION,ID_CATEGORIE,ID_ADMIN,IMAGE) VALUES('$titre','$description','$date','$location','$id_categorie',$id_admin,'$ph_name')";
	$resultat=mysqli_query($link,$requette);
	header('location: index.php');
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
            background-color: #f0f0f0;
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
            text-align: center;
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
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
	</head>
    <body>
		<h1>ajouter un évenement</h1>
		<form action="" method="post" id="monform" enctype="multipart/form-data">
            <label for="titre">Titre:</label>
            <input type="text" name="titre" required>

			<label for="description">Description:</label>
            <textarea name="description" rows="6" cols="95" required></textarea>

			<label for="date">Date:</label>
            <input type="date" name="date" required>

            <label for="location">Location:</label>
            <input type="text" name="location" required>

            <label for="id_categorie">Catégorie:</label>
            <select name="id_categorie" required>
                <?php
            $result= mysqli_query($link, "SELECT* FROM categorie");
            while ($row = mysqli_fetch_assoc($result)) {
                echo"<option value='". $row['ID_CATEGORIE']. "'>" . $row['LABEL']."</option>";
            }
            ?>
            
			<label for="fichier">Image:</label>
			<input type="file" name="fichier"/>
			<input type="submit" name="sub" value="Valider" style="width: 200px;text-align: center;"/>
		</form>
	</body>
</html>
<?php mysqli_close($link); ?>