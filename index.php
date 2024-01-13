<!DOCTYPE html>
<html lang="en">
<style>
    @font-face {
    font-family: font;
    src: url(fonts/LibreBaskerville-Regular.ttf);
}
body{
    width : 100%;
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items : center;
    margin:0;
    background-color: #1b4353;
}
main{
    display : flex;
    justify-content: center;
    align-items: center;
    gap : 1rem;
    flex-direction: column;
}
form{
    box-shadow: rgba(0, 0, 0, 0.3) 0px 19px 38px, rgba(0, 0, 0, 0.22) 0px 15px 12px;
    background-color: #ebebeb;
    border-radius: 20px;
    padding : 3rem 2.5rem;
}

input[type="text"], input[type="password"]{
    padding: 0.4rem 0.8rem;
    width : 250px;
    border-radius: 5px;
    background-color: #ebebeb;
    border : groove 2px #1b4353;
    outline : none;
    transition : 0.1s ease border-color;
}
input[type="text"]:focus, input[type="password"]:focus{
    border-color : #08a5e3;
}


.submit{
    cursor : pointer;
    border-radius: 20px;
    background-color: #0f749c;
    color : white;
    font-weight: 600;
    text-transform :capitalize;
    width: 100%;
    padding : 0.5rem;
    transition : 0.1s ease background-color, 0.1s ease color;
}
.submit:hover{
    background-color: #139bd1;
    border-color: white;
}

.action_container{
    display : flex;
    justify-content: center;
}
a{
    text-decoration: none;
    color : #0f749c;
    width : fit-content;
}
.message{
    color : rgb(97, 9, 9);
}
    </style>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    
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
                <a href="authentification.php">admin</a>
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
