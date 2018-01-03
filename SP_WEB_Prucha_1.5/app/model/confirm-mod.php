<!-- schválení nebo zamítnutí příspěvku -->

<?php

include_once '../model/dbh.php';

// Kontrola, jestli proběhlo potvrzení
if (isset($_GET['commID'])) {

    $commID = mysqli_real_escape_string($conn, $_GET['commID']);
    $conf = mysqli_real_escape_string($conn, $_GET['conf']);

// Upravení příspěvku v databázi
    $sql = "UPDATE prispevek SET schvaleni='$conf' WHERE idPrispevku='$commID'";
    mysqli_query($conn, $sql);
    echo $commID . "\n";
    echo $conf . "\n";;
    header("Location: /SP_WEB_Prucha_1.5/app/control/administrator.php?conf=success");
    exit();

// Pokud proběhla chyba, vypíšem error
} else {
    header("Location: /SP_WEB_Prucha_1.5/app/control/administrator.php?conf=failed");
    exit();
}


