<!-- hodnocení příspěvku -->

<?php

include '../model/dbh.php';

// Kontrola, jestli proběhlo potvrzení
if (isset($_POST['submit'])) {

    $rewID = mysqli_real_escape_string($conn, $_GET['userID']);
    $lang = mysqli_real_escape_string($conn, $_POST['jazyk']);
    $tech = mysqli_real_escape_string($conn, $_POST['technika']);
    $topic = mysqli_real_escape_string($conn, $_POST['tema']);
    $recom = mysqli_real_escape_string($conn, $_POST['doporuceni']);
    $commID = mysqli_real_escape_string($conn, $_GET['commID']);


    $sql_s = "SELECT * FROM hodnoceni WHERE recenzent_id='$rewID' AND prispevek_id='$commID'";
    $results = mysqli_query($conn, $sql_s);

    // Pokud hodnocení už existuje, nahradí se novým
    if (mysqli_num_rows($results) > 0) {
        $sql_u = "UPDATE hodnoceni SET jazyk_kvalita = '$lang', tech_kvalita = '$tech', tema = '$topic', doporuceni = '$recom' 
                    WHERE recenzent_id = '$rewID' AND prispevek_id = '$commID'";
        mysqli_query($conn, $sql_u);
        header("Location: /SP_WEB_Prucha_1.5/app/control/reviewer.php?updateRanking=success");
        exit();

        // Pokud hodnocení ještě neexistuje, vytvoří se nové
    } else {
        $sql_i = "INSERT INTO hodnoceni (recenzent_id, jazyk_kvalita, tech_kvalita, tema, doporuceni, prispevek_id)
                        VALUES ('$rewID', '$lang', '$tech', '$topic', '$recom', '$commID')";
        mysqli_query($conn, $sql_i);
        header("Location: /SP_WEB_Prucha_1.5/app/control/reviewer.php?insertRanking=success");
        exit();
    }

    // V případě chyby se vypíše error
    header("Location: /SP_WEB_Prucha_1.5/app/control/reviewer.php?ranking=error");
    exit();
}
