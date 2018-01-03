<!-- příhlášení uživatele -->

<?php

session_start();

include '../model/dbh.php';

// Kontrola, jestli proběhlo potvrzení
if (isset($_POST['submit'])) {

    $login = mysqli_real_escape_string($conn, $_POST['login']);
    $pwd = mysqli_real_escape_string($conn, $_POST['pwd']);

// Kontrola jestli není vstup prázdný
    if (empty($login) || empty($pwd)) {
        header("Location: /SP_WEB_Prucha_1.5/index.php?login=empty");
        exit();
    } else {
        $sql = "SELECT * FROM uzivatele WHERE uzivatel_login='$login' OR uzivatel_email='$login'";
        $result = mysqli_query($conn, $sql);
        $resultCheck = mysqli_num_rows($result);
        if ($resultCheck < 1) {
            header("Location: /SP_WEB_Prucha_1.5/index.php?login=error");
            exit();
        } else {
            if ($row = mysqli_fetch_assoc($result)) {
                // Odkódovnání hesla
                $hashedPwdCheck = password_verify($pwd, $row['uzivatel_heslo']);
                if ($hashedPwdCheck == false) {
                    header("Location: /SP_WEB_Prucha_1.5/index.php?login=error");
                    exit();
                } elseif ($hashedPwdCheck == true) {

                    if ($row['blokovan'] == 1) {
                        header("Location: /SP_WEB_Prucha_1.5/app/control/userIsBlocked.php?login=blocked");
                        exit();
                    }

                    // Načtení údajů uživatele do session
                    $_SESSION['u_id'] = $row['uzivatel_id'];
                    $_SESSION['u_first'] = $row['uzivatel_jmeno'];
                    $_SESSION['u_last'] = $row['uzivatel_prijmeni'];
                    $_SESSION['u_email'] = $row['uzivatel_email'];
                    $_SESSION['u_login'] = $row['uzivatel_login'];
                    $_SESSION['u_rev'] = $row['recenzent'];

                    // Rozdělení přihlášení administrátora, recenzenta a autora
                    if ($_SESSION['u_id'] == 1) {
                        header("Location: /SP_WEB_Prucha_1.5/app/control/administrator.php?loginAsAdmin=success");
                        exit();
                    } elseif ($_SESSION['u_rev'] == 1) {
                        header("Location: /SP_WEB_Prucha_1.5/app/control/reviewer.php?loginAsReviewer=success");
                        exit();
                    } else {
                        header("Location: /SP_WEB_Prucha_1.5/app/control/author.php?loginAsAuthor=success");
                        exit();
                    }
                }
            }
        }
    }
// Vypsání erroru v případě chyby
} else {
    header("Location: /SP_WEB_Prucha_1.5/index.php?login=error");
    exit();
}
