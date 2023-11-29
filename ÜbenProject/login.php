<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300&display=swap" rel="stylesheet">

</head>
<style>
        body {
            font-family: 'Open Sans', sans-serif;
            background-color: #E9EDF7;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .Block {
            text-align: center;
            background-color: white;
            padding: 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
            border-radius: 8px;
        }

        .EingabeForm {
            margin-bottom: 20px;
        }

        .Eingabe {
            width: 100%;
            height: 40px;
            padding: 8px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }

        .Einloggen {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            border-radius: 4px;
            cursor: pointer;
        }

        .Einloggen:hover {
            background-color: #45a049;
        }
</style>
<body>
    <div class="Block">
        <?php
        session_start();

        if(isset($_POST['login'])){
            $email = $_POST['email'];
            $passwort = $_POST['Passwort'];
            require_once "database.php";
            $sql = "SELECT * FROM benutzer WHERE email = ?";
            $stmt = mysqli_stmt_init($conn);
        
            if ($stmt && mysqli_stmt_prepare($stmt, $sql)) {
                mysqli_stmt_bind_param($stmt, "s", $email);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                $user = mysqli_fetch_assoc($result); }
            
            if($user) {
                if(password_verify($passwort, $user["passwort"])){
                    $_SESSION['benutzer'] = $user['benutzernamen'];
                    header("Location: index.php?page=start");
                    die();
                } else {
                    echo "<p class ='Fehlermeldung'>Es wurde kein Account mit dieser Email gefunden!</p>";
                }
            }

        }
        ?>
            <form action="login.php" method="POST">

                <div class="EingabeForm">
                    <input class="Eingabe" name="email" placeholder="E-Mail-Adresse eingeben" required>
                </div>

                <div class="EingabeForm">
                    <input class="Eingabe" name="Passwort" placeholder="Passwort eingeben" required>
                </div>

                <div class="EingabeForm">
                    <button class="Einloggen" type="login" name="login">Einloggen</button>
                </div>

                <div class="links">
                    <p>Hast du schon ein Account? <a href="registration.php">Registriere dich jetzt!</a></p>
                </div>
            </form>

    </div>
</body>
</html>