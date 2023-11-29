<?php
session_start();
if(!isset($_SESSION['benutzer'])){
    header("Location: login.php");
    die();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Open Sans', sans-serif;
            background-color: #E9EDF7;
            margin: 0;
        }
        .footer {
            text-align: center;
            color: white;
            padding: 20px;
            background-color: lightgrey;
            box-shadow: 1px 42px 1px rgba(0.1, 0.1, 0.1);
        }

        .TestTEXT{
            display: flex;
        }
        
        .TestMenu{
            background-color: lightgrey;
            width: 10%;
            margin-right: 40px;
            padding-top: 300px;
            height: 72vh;
            box-shadow: 2px 0px 0px rgba(0, 0, 0.1);
        }

        .TestMenu a{
            display: block;
            margin-top: 10px;
            text-decoration: none;
            color: Black;
            padding: 8px;
            display: flex;
            align-items: center;
        }

        .TestMenu img{
            margin-right: 10px;
        }

        .TestMenu a:hover{
            background-color: gray;
            color: white;
        }

        .pages{
            width: 90%;
            background-color: white;

        }

        .pages h1{
            margin-left: 120px;
        }

        .pages a{
            margin-left: 140px;
        }

        .Name{
            margin-left: 140px;
            margin-top: 5px;
        }

        .Email{
            margin-left: 140px;
            margin-top: 5px;
        }

        .Absenden{
            margin-left: 140px;
            margin-top: 10px;
            padding: 3px;
            background-color: grey;
            color:white;
        }

        .Absenden:hover{
            background-color: white;
            color: black;
        }

        .abstandt{
            margin-bottom: 30px;
            background-color: #E9EDF7;
        }
        
        .abstandn{
            margin-top: 6px;
            background-color: #E9EDF7;
        }

        .KontakteZ{

        }
    </style>
</head>
<body>
    <?php
        $name = $_SESSION['benutzer'];
        $headline = 'Willkommen ' . $name;
        $kontakte = [];

        if(file_exists('test.txt')){
            $text = file_get_contents('test.txt', true);
            $kontakte = json_decode($text, true);
        }

        if(isset($_POST['name']) && isset($_POST['emails']))
        {
            echo 'Der Kontakt <b>' . $_POST['name'] . '</b> wurde erfolgreich hinzugefügt!';
            $neuerkontakt = [
                'name' => $_POST['name'],
                'emails' => $_POST['emails']
            ];
            array_push($kontakte, $neuerkontakt);
            file_put_contents('test.txt', json_encode($kontakte, JSON_PRETTY_PRINT));

        }

        if($name == $_SESSION['benutzer']):
            ?>

            <div class="TestTEXT">
                <div class="TestMenu">
                    <a href="index.php?page=start"><img src="img/startseite.svg">Startseite</a>
                    <a href="index.php?page=kauf"><img src="img/kaufen.svg">Kaufen</a>
                    <a href="index.php?page=warenkorb"><img src="img/warenkorb.svg">Korb</a>
                    <a href="index.php?page=kontaktehinzu"><img src="img/personenhinzu.svg">Kontakt Hinzufügen</a>
                    <a href="index.php?page=kontakte"><img src="img/kontakte.svg">Kontakte</a>
                </div>

                <div class="pages">
                    <?php
                            if($_GET['page'] == 'start'):
                                echo '<h1>' . $headline . '</h1>';
                                echo '<a>Du befindest dich gerade auf der Startseite <b>' . $name . '</b>!</a>';

                            endif;

                            if($_GET['page'] == 'kauf'):
                                $headline = 'Kauf schön ein!';
                                echo '<h1>' . $headline . '</h1>';
                                echo '<a>Du befindest dich gerade auf der Kauf-Seite <b>' . $name . '</b>!</a>';

                            endif;

                            if($_GET['page'] == 'warenkorb'):
                                $headline = 'Dein Warenkorb';
                                echo '<h1>' . $headline . '</h1>';
                                echo '<a>Du befindest dich gerade in dekinem Warenkorb <b>' . $name . '</b>!</a>';

                            endif;

                            if($_GET['page'] == 'kontakte'):
                                $headline = 'Deine Kontakte';
                                echo '<h1>' . $headline . '</h1>';
                                echo '<a>Du kannst hier alle deine Kontakte sehen <b>' . $name . '</b> !</a>';
                                ?>
                                <div class="KontakteZ">
                                <?php
                                    foreach($kontakte as $zeile):
                                        echo '<div class="abstandn"><a><b> Name</b>: ' . $zeile['name'] . '</a></div>';
                                        echo '<div class="abstandt"><a><b> Email</b>: ' . $zeile['emails'] . '</a></div>';
                                    endforeach;
                                ?>
                                </div>
                                <?php


                            endif;

                            if($_GET['page'] == 'kontaktehinzu'):
                                $headline = 'Neuen Kontakte hinzufügen!';
                                echo '<h1>' . $headline . '</h1>';
                                echo '<a>Du kannst neue Kontakte hinzufügen <b>' . $name . '</b> !</a>';

                                ?>
                                <form action='?page=kontakte' method='POST'>
                                    <div class="Name">
                                        <input placeholder="Name eingeben" name='name'> 
                                    </div>

                                    <div class="Email">
                                        <input placeholder="Email eingeben" name='emails'> 
                                    </div>

                                    <button class="Absenden" type='submit'>Hinzufügen</button>

                            </form>

                                <?php
                            endif;
                            ?>
                            <a href="logout.php" class="btn btn-warning">Ausloggen</a>
                </div>
                
            </div>

            <?php
        endif;
        ?>
        

    <div class= "footer">

        (C) 2023 Developer Kevin Popovic non GMBH

    </div>
</body>
</html>