<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Authentification</title>
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
        h1 {
            text-align: center;
            color: white;
        }
        form {
            max-width: 500px;
            margin: auto;
            padding: 50px;
            background-color: #fff;
            border-radius: 20px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            height: auto; 
        }
        label {
            display: block;
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        input {
            display: block;
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            font-size: 16px;
            color: #555;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        button {
            background-color: #1b4353;
            color: white;
            padding: 14px 24px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 20px;
        }
        .compte {
            text-align: center;
            margin-top: 20px;
            font-size: 18px;
        }
        .compte a {
            color: #2196F3;
            text-decoration: none;
            font-weight: bold;
        }
        .compte a:hover {
            color: #1565C0;
            text-decoration: underline;
        }

    </style>
</head>
<body>
<nav>
    <img width='250px' src="img/ensa1.png">
</nav>
    <h1> Authentification Admin </h1>

    <form action="login_admin.php" method="post">
        <label for="login">Login:</label>
        <input type="text" id="login" name="nom" required>

        <label for="password">Mot de passe:</label>
        <input type="password" id="password" name="password" required>

        <button type="submit">Connexion</button>
    </form>
</body>
</html>
