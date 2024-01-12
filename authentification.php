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
            $_SESSION['loggedin'] = true;
            $_SESSION['email'] = $fetch['EMAIL'];
            $_SESSION['ID_USER']=$fetch['ID_USER'];
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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        @font-face {
    font-family: font;
    src: url(fonts/LibreBaskerville-Regular.ttf);
}
nav {
    margin-right: auto; /* Adjust this value as needed to move the image to the left */
}

body {
    font-family: 'font', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f0f0f0;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    background-color: #1b4353;
}
form{
    border-width: 2px;
    border-color: #bab8b8;
    background-color: #ebebeb;
    border-style: solid;
    border-radius: 20px;
    width : 300px;
    height: 300px;
    position : relative;
    top : 150px;
    margin-left: -80px;
    box-shadow: rgba(0, 0, 0, 0.3) 0px 19px 38px, rgba(0, 0, 0, 0.22) 0px 15px 12px;
}
label{
    text-align: center;
    margin-left: 25px;
}
.text{
    margin-left: 20px;
    height : 25px;
    border-radius: 20px;
    width : 0250px;
    border-style: solid;
    background-color: #ebebeb;
    border-color: #1b4353;
}
.container{
    margin-top: 40px;
}

.submit{
    margin-left: 110px;
    height : 30px;
    width : 85px;
    border-radius: 20px;
    border-style: solid;
    border-width: 0;
    background-color: #1b4353;
    color : #ebebeb;
}
.submit:hover{
    background-color: #ebebeb;
    border-color: #1b4353;
    border-width: 2px;
    border-style: solid;
    color : #1b4353
}
input{
    padding-left: 5px;
}
a{
    text-decoration: none;
    color : #1b4353;
    margin-left : 10px;
}
.message{
    color : white;
}
    </style>
</head>
<body>
    <nav>
    <img width='250px' src="img/ensa1.png">
</nav>
    <form action="#" method="post">
        <div class="container">
        <label>Email:</label><br><br>
        <input class="text" type="text" name="email"><br><br><br>
        <label>Mot de pass:</label><br><br>
        <input class="text" type="password" name="pass"><br><br><br>
        <input class="submit" type="submit" name="submit" value="connexion">
        <div>
</form>
<a href="formulaire.php">Créer un compte?</a>
</body>
</html>
