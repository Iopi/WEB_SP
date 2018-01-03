<!-- smazání příspěvku -->

<?php

include_once '../model/dbh.php';

// Kontrola, jestli proběhlo potvrzení
if (isset($_GET['commID'])) {

    mysqli_real_escape_string($conn, $commID = $_GET['commID']);

// Upravení příspěvku v databázi
    $sql = "DELETE FROM prispevek WHERE idPrispevku='$commID'";
    mysqli_query($conn, $sql);
    header("Location: /SP_WEB_Prucha_1.5/app/control/author.php?delete=success");
    exit();

// Pokud proběhla chyba, vypíšem error
} else {
    header("Location: /SP_WEB_Prucha_1.5/app/control/author.php?delete=failed");
    exit();
}