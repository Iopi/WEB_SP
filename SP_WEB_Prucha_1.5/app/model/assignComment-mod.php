<!-- přiřazení příspěvku -->

<?php

include_once '../model/dbh.php';

// Kontrola, jestli proběhlo potvrzení
if (isset($_GET['userID'])) {

    $userID = mysqli_real_escape_string($conn, $_GET['userID']);
    $assign = mysqli_real_escape_string($conn, $_GET['assign']);
    $rev = mysqli_real_escape_string($conn, $_GET['dbRev']);

// Upravení příspěvku v databázi
    $sql = "UPDATE prispevek SET $rev='$userID' WHERE idPrispevku='$assign'";
    mysqli_query($conn, $sql);
    header("Location: /SP_WEB_Prucha_1.5/app/control/administrator.php?assign=success");
    exit();

// Pokud proběhla chyba, vypíšem error
} else {
    header("Location: /SP_WEB_Prucha_1.5/app/control/administrator.php?assign=failed");
    exit();
}


