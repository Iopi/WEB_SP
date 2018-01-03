<!-- změna role uživatele -->

<?php

include_once '../model/dbh.php';

// Kontrola, jestli proběhlo potvrzení
if (isset($_GET['userID'])) {

    $userID = mysqli_real_escape_string($conn, $_GET['userID']);
    $number = mysqli_real_escape_string($conn, $_GET['number']);

// Upravení příspěvku v databázi
    $sql = "UPDATE uzivatele SET recenzent='$number' WHERE uzivatel_id='$userID'";
    mysqli_query($conn, $sql);
    header("Location: /SP_WEB_Prucha_1.5/app/control/administrator.php?change=success");
    exit();

// Pokud proběhla chyba, vypíšem error
} else {
    header("Location: /SP_WEB_Prucha_1.5/app/control/administrator.php?change=failed");
    exit();
}


