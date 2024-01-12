<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="login.css">
</head>

<body>
    <main>
        <img width='250px' src="img/ensa1.png">
        <form action="#" method="post">
            <label>Email</label><br><br>
            <input class="text" type="text" name="email"><br><br><br>
            <label>Mot de passe</label><br><br>
            <input class="text" type="password" name="pass"><br><br><br>
            <input class="submit" type="submit" name="submit" value="connexion">
            <div class="action_container">
                <a href="formulaire.php">Créer un compte?</a>
            </div>
            <div class="message_container">
                <?php
                session_start();
                include("connexion.php");
                if($_SERVER["REQUEST_METHOD"] == "POST")
                {
                    $email = $_POST["email"];
                    $password = $_POST["pass"];
                    $query = "SELECT * FROM user WHERE EMAIL = '$email'";
                    $execute = mysqli_query($link,$query);
                    if(mysqli_num_rows($execute)>0)
                    {
                        $fetch = mysqli_fetch_assoc($execute);
                        if($password == $fetch['PASSWORD'])
                        {
                            $_SESSION['ID_USER']=$fetch["ID_USER"];
                            $_SESSION['loggedin'] = true;
                            $_SESSION['email'] = $fetch['EMAIL'];
                            header("Location: home.php");
                            exit();
                        }
                        else
                        {
                            echo "<p class='message'>Le mot de passe est incorrecte</p>";
                        }
                    }
                    else{
                        echo "<p class='message'>L'email n'existe pas</p>";
                    }
                    mysqli_close($link);
                }
                ?>
            </div>
        </form>
    </main>
</body>

</html>
