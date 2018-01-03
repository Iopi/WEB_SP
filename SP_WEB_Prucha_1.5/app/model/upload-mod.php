<!-- nahrání příspěcku a uložení pdf souboru do složky uploads -->

<?php

session_start();

include_once '../model/dbh.php';

$target_dir = 'G:\SP_WEB_Prucha_1.5\uploads/';
$target_file = $target_dir . basename($_FILES["file"]["name"]);
$fileSize = $_FILES['file']['size'];
$fileTmpName = $_FILES['file']['tmp_name'];
$fileName = strtolower($_FILES["file"]["name"]);
$fileExt = explode('.', $fileName);
$fileActualExt = strtolower(end($fileExt));
$uploadOk = 1;
$imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);

// Kontrola, jestli proběhlo potvrzení
if (isset($_POST["submit"])) {

// Kontrola, jestli soubor už existuje
    if (file_exists($target_file)) {
        echo " Soubor už zde existuje.";
        $uploadOk = 0;
    }
// Kontrola, jestli neni soubor příliš velký
    if ($fileSize > 2000000) {
        echo " Soubor je příliš velký.";
        $uploadOk = 0;
    }
// Kontrola, jestli je soubor v pdf
    if ($fileActualExt != "pdf") {
        echo " Soubor neni v pdf.";
        $uploadOk = 0;
    }

// Kontrola, jestli $uploadOk je 0 - error
    if ($uploadOk == 0) {
        echo " Soubor nebyl nahrán.";

// Když je vše v pořádku, nahrajeme informace do datábaze
    } else {
        if ($uploadOk == 1) {

            $name = mysqli_real_escape_string($conn, $_POST['nazev']);
            $author = mysqli_real_escape_string($conn, $_POST['autor']);
            $descr = mysqli_real_escape_string($conn, $_POST['popis']);
            $idAuthor = mysqli_real_escape_string($conn, $_SESSION['u_id']);
            $idRev1 = 0;
            $idRev2 = 0;
            $idRev3 = 0;
            $conf = 0;
            $uplFile = mysqli_real_escape_string($conn, $_FILES["file"]["name"]);

// Kontrola, jestli už název souboru neexistuje
            $sql = "SELECT * FROM prispevek WHERE nazev='$name'";
            $result = mysqli_query($conn, $sql);
            $resultsCheck = mysqli_num_rows($result);

            if ($resultsCheck > 0) {
                echo " Název " . $name . " už existuje. Zvolte prosím jiný.";

            } else {

// Nahrání souboru
                move_uploaded_file($fileTmpName, $target_file);

// Vlozeni prispevku do databaze
                $sql = "INSERT INTO prispevek (autor, text, nazev, jmenoSouboru, idAutora, idRecenzenta1, idRecenzenta2, idRecenzenta3, schvaleni)
                    VALUES ('$author', '$descr', '$name', '$uplFile', '$idAuthor', '$idRev1', '$idRev2', '$idRev3', '$conf');";
                mysqli_query($conn, $sql);
                header("Location: /SP_WEB_Prucha_1.5/app/control/author.php?upload=success");
                exit();
            }
        } else {
            echo " Nahrání souboru selhalo.";
        }
    }
}







































