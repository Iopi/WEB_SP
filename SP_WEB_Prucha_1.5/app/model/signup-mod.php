<!-- registrace uživatele -->

<?php

// Kontrola, jestli proběhlo potvrzení
if (isset($_POST['submit'])) {

    include_once '../model/dbh.php';

    $first = mysqli_real_escape_string($conn, $_POST['first']);
    $last = mysqli_real_escape_string($conn, $_POST['last']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $login = mysqli_real_escape_string($conn, $_POST['login']);
    $pwd = mysqli_real_escape_string($conn, $_POST['pwd']);
    $reviewer = "0";
    $isBlocked = "0";

    // Kontrola, jestli je vstup validní
    if (!preg_match("/^[a-zA-ZěščřžýáíéůúďňóťĚŠČŘŽÝÁÍÉŮĎÚŇÓŤ]+$/", $first) || !preg_match("/^[a-zA-ZěščřžýáíéůúďňóťĚŠČŘŽÝÁÍÉŮĎÚŇÓŤ]+$/", $last)) {
        header("Location: /SP_WEB_Prucha_1.5/app/control/signup.php?signup=invalid");
        exit();

        // Kontrola, jestli už login neexistuje
    } else {
        $sql = "SELECT * FROM uzivatele WHERE uzivatel_login='$login'";
        $result = mysqli_query($conn, $sql);
        $resultsCheck = mysqli_num_rows($result);

        if ($resultsCheck > 0) {
            header("Location: /SP_WEB_Prucha_1.5/app/control/signup.php?signup=usertaken");
            exit();

        } else {
            // Zakódování hesla
            $hashedPwd = password_hash($pwd, PASSWORD_DEFAULT);
            // Vložení údajů do databáze
            $sql = "INSERT INTO uzivatele (uzivatel_jmeno, uzivatel_prijmeni, uzivatel_email, uzivatel_login, uzivatel_heslo, recenzent, blokovan)
                    VALUES ('$first', '$last', '$email', '$login', '$hashedPwd', '$reviewer', '$isBlocked');";
            mysqli_query($conn, $sql);
            header("Location: /SP_WEB_Prucha_1.5/app/control/successfulReg.php?signup=success");
            exit();
        }
    }

    // V případě chyby, vypsání erroru
} else {
    header("Location: /SP_WEB_Prucha_1.5/app/model/signup-mod.php?signup=error");
    exit();
}