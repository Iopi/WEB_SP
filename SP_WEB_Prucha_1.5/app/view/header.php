<!-- header -->

<?php

include 'G:\SP_WEB_Prucha_1.5\app\model\dbh.php';

session_start();

?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <title>Konference klubu Filmařů</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="/SP_WEB_Prucha_1.5/css/style.css">
</head>
<body>

<header>
    <!-- základní nadpis -->
    <div class="jumbotron text-center">
        <h1>Konference klubu Filmařů</h1>
        <p>Toto je konference klubu Filmařů. Na této stránce můžete vidět všechny schválené příspěvky o filmech.</p>
        <p>Pokud jste v poslední době viděli nějký film a chtěli byste se s námi o něj podělit, zaregistrujte se a získáte status autora.</p>
    </div>

    <!-- hlavní nabídka -->
    <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container-fluid">

            <ul class="nav navbar-nav">
                <li class="active"><a href="/SP_WEB_Prucha_1.5/index.php">Domů</a></li>
                <?php
                if (isset($_SESSION['u_id'])) {
                    if ($_SESSION['u_id'] == 1) {
                        ?>
                        <li><a href="/SP_WEB_Prucha_1.5/app/control/administrator.php">Administrator</a></li>
                        <?php
                    } elseif ($_SESSION['u_rev'] == 1) {
                        ?>
                        <li><a href="/SP_WEB_Prucha_1.5/app/control/reviewer.php">Recenzent</a></li>
                        <?php
                    } else {
                        ?>
                        <li><a href="/SP_WEB_Prucha_1.5/app/control/author.php">Autor</a></li>
                        <?php
                    }
                }
                ?>
            </ul>

            <ul class="nav-r navbar-nav navbar-right">
                <?php
                if (isset($_SESSION['u_id'])) {
                    ?>
                    <form action="/SP_WEB_Prucha_1.5/app/model/logout-mod.php" method="POST">
                        <button type="submit" name="submit">Odhlásit</button>
                    </form>
                    <?php
                } else {
                    ?>

                    <form action="/SP_WEB_Prucha_1.5/app/model/login-mod.php" method="POST">
                        <input type="text" name="login" placeholder="login/email" required>

                        <input type="password" name="pwd" placeholder="heslo" required>
                        <button type="submit" name="submit">Přihlásit</button>
                        <button type="button" name="signup"><a href="/SP_WEB_Prucha_1.5/app/control/signup.php">Zaregistrovat</a>
                        </button>
                    </form>

                    <?php
                }
                ?>
            </ul>
        </div>
    </nav>
</header>

