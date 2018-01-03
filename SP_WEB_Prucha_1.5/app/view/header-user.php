<!-- header pro uživatele -->

<?php

session_start();

include '../model/dbh.php';

?>

<!DOCTYPE html>
<html lang="cs">
<head>
    <title>Filmaři</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="/SP_WEB_Prucha_1.5/css/user-style.css">
    <script>
        $(document).ready(function () {
            var commentCount = 1;
            $("#but1").click(function () {
                commentCount = commentCount + 1;
                $("#comment").load("../model/load-comments-mod.php", {
                    commentNewCount: commentCount
                });
            });
            $("#but2").click(function () {
                commentCount = commentCount - 1;
                $("#comment").load("../model/load-comments-mod.php", {
                    commentNewCount: commentCount
                });
            });
        });
    </script>
</head>
<body>

<!-- nadpis -->
<div class="jumbotron text-center">
    <h1>Konference klubu Filmařů</h1>
    <?php
    if (isset($_SESSION['u_id'])) {
        ?>
        <p>Vítejte uživateli <?php echo $_SESSION['u_last'] ?></p>
        <?php
    }
    ?>
</div>

<!-- nabídka -->
<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">

        <ul class="nav navbar-nav">
            <?php
            if (isset($_SESSION['u_id'])) {
                if (($_SESSION['u_id']) == 1) {
                    ?>
                    <li><a href="/SP_WEB_Prucha_1.5/index.php">Konference</a></li>
                    <li class="active"><a href="../control/administrator.php">Domů</a></li>
                    <li><a href="#uzivatele">Uživatelé</a></li>
                    <li><a href="#prirazeni">Příspěvky k přiřazení</a></li>
                    <li><a href="#schvaleni">Příspěvky k schválení</a></li>
                    <?php
                } elseif (($_SESSION['u_rev']) == 1) {
                    ?>
                    <li><a href="/SP_WEB_Prucha_1.5/index.php">Konference</a></li>
                    <li class="active"><a href="../control/reviewer.php">Domů</a></li>
                    <li><a href="#hodnoceni">Hodnoceni</a></li>

                    <?php
                } else {
                    ?>
                    <li><a href="/SP_WEB_Prucha_1.5/index.php">Konference</a></li>
                    <li class="active"><a href="../control/author.php">Domů</a></li>
                    <li><a href="#moje">Příspěvky v recenzním řízení</a></li>
                    <li><a href="#zhodnocene">Zhodnocené příspěvky</a></li>
                    <li><a href="#pridat">Přidat příspěvek</a></li>
                    <?php
                }
            }
            ?>
        </ul>

        <ul class="nav-r navbar-nav navbar-right">
            <div class="navbar-header">
                <a class="navbar-brand" href="" data-toggle="modal" data-target="#uzivatel">Uživatel</a>
            </div>
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
                    <input type="text" name="login" placeholder="nick/email" required>

                    <input type="password" name="pwd" placeholder="heslo" required>
                    <button type="submit" name="submit">Přihlásit</button>
                    <button type="button" name="signup"><a href="../control/signup.php">Zaregistrovat</a></button>
                </form>

                <?php
            }
            ?>
        </ul>
    </div>
</nav>

<!-- informace o uživateli -->
<div class="modal fade" id="uzivatel" role="dialog">
    <div class="modal-dialog">

        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Uživatel</h4>
            </div>
            <div class="modal-body">
                <?php
                if (isset($_SESSION['u_id'])) {
                    ?>
                    <p>Jméno:
                        <?php
                        echo $_SESSION['u_first'];
                        ?>
                    </p>
                    <p>Příjmení:
                        <?php
                        echo $_SESSION['u_last'];
                        ?>
                    </p>
                    <p>Email:
                        <?php
                        echo $_SESSION['u_email'];
                        ?>
                    </p>
                    <?php
                }
                ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Zavřít</button>
            </div>
        </div>
    </div>
</div>