<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Authentification</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        h1 {
            text-align: center;
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
            background-color: #FF9800;
            color: white;
            padding: 14px 24px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 20px;
        }
        button:hover {
            background-color: #e66300;
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
    <h1> Authentification </h1>

    <form action="login_admin.php" method="post">
        <label for="login">Login:</label>
        <input type="text" id="login" name="nom" required>

        <label for="password">Mot de passe:</label>
        <input type="password" id="password" name="password" required>

        <button type="submit">Connexion</button>
    </form>
</body>
</html>
