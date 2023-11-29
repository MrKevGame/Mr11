<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrierung</title>
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

        .ButtonRegister {
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

        .ButtonRegister:hover {
            background-color: #45a049;
        }

        .Fehlermeldung {
        color: #D9534F; 
        background-color: #F2DEDE; 
        padding: 10px;
        border: 1px solid #D9534F;
        border-radius: 4px;
        margin-bottom: 10px;
    }
    .Geschaffft{
        color: green;
    }
</style>
<body>
    <div class="Block">
    <?php
$errors = [];

if (isset($_POST['submit'])) {
    $Benutzername = $_POST['benutzername'];
    $email = $_POST['email'];
    $passwort = $_POST['Passwort'];
    $passwortwiederholen = $_POST['PasswortWiederholen'];

    $passwort_verbergen = password_hash($passwort, PASSWORD_DEFAULT);

    if (empty($Benutzername) || empty($email) || empty($passwort) || empty($passwortwiederholen)) {
        array_push($errors, '<p class ="Fehlermeldung">Du musst alle Felder ausfüllen!</p>');
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        array_push($errors, '<p class ="Fehlermeldung">Die E-Mail-Adresse ist ungültig!</p>');
    }
    if (strlen($passwort) < 8) {
        array_push($errors, '<p class ="Fehlermeldung">Das Passwort muss mindestens 8 Zeichen lang sein!</p>');
    }
    if ($passwort !== $passwortwiederholen) {
        array_push($errors, '<p class ="Fehlermeldung">Die beiden Passwörter stimmen nicht überein!</p>');
    }

    require_once "database.php";

    $sql_select = "SELECT * FROM benutzer WHERE email = ?";
    $stmt_select = mysqli_stmt_init($conn);
    if ($stmt_select && mysqli_stmt_prepare($stmt_select, $sql_select)) {
        mysqli_stmt_bind_param($stmt_select, "s", $email);
        mysqli_stmt_execute($stmt_select);
        $result_select = mysqli_stmt_get_result($stmt_select);
        $rowCount = mysqli_num_rows($result_select);
        if ($rowCount > 0) {
            array_push($errors, "<p class ='Fehlermeldung'>Email wird bereits verwendet!</p>");
        }
        mysqli_stmt_close($stmt_select);
    } else {
        die("Etwas ist schiefgelaufen!");
    }

    if (count($errors) > 0) {
        foreach ($errors as $error) {
            echo "<div class='alert alert-danger'>$error</div>";
        }
    } else {
        $sql_insert = "INSERT INTO benutzer (benutzernamen, email, passwort) VALUES (?, ?, ?)";
        $stmt_insert = mysqli_stmt_init($conn);
        if ($stmt_insert && mysqli_stmt_prepare($stmt_insert, $sql_insert)) {
            mysqli_stmt_bind_param($stmt_insert, "sss", $Benutzername, $email, $passwort_verbergen);
            mysqli_stmt_execute($stmt_insert);
            echo '<p class ="Geschaffft">Der Account wurde erfolgreich erstellt!</p>';
            mysqli_stmt_close($stmt_insert);
        } else {
            die("Etwas ist schiefgelaufen!");
        }
    }
}
?>

            <form action="registration.php" method="POST">
                <div class="EingabeForm">
                    <input class="Eingabe" name="benutzername" placeholder="Benutzername eingeben" required>
                </div>

                <div class="EingabeForm">
                    <input class="Eingabe" name="email" placeholder="E-Mail-Adresse eingeben" required>
                </div>

                <div class="EingabeForm">
                    <input class="Eingabe" name="Passwort" placeholder="Passwort eingeben" required>
                </div>

                <div class="EingabeForm">
                    <input class="Eingabe" name="PasswortWiederholen" placeholder="Passwort wiederholen" required>
                </div>

                <div class="EingabeForm">
                    <button class="ButtonRegister" type="submit" name="submit">Registrieren</button>
                </div>

                <div class="links">
                    <p>Schon registriert? <a href="login.php">Logge dich ein!</a></p>
                </div>
            </form>

    </div>
</body>
</html>