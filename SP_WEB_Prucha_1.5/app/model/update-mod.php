<!-- změna příspěvku -->

<?php

session_start();

include_once '../model/dbh.php';

// Kontrola, jestli proběhlo potvrzení
if (isset($_POST["submit"])) {
    $uploadOk = 1;
    $change = 1;
    $uplFile = mysqli_real_escape_string($conn, $_FILES["file"]["name"]);

// Kontrola, jestli je změněn soubor
    if ($uplFile == null) {
        $uplFile = $_SESSION['nameOfFile'];
        $change = 0;
        echo "jedeme pres if";

// Pokud ano nahrajeme nový soubor
    } else {
        $target_dir = 'G:\SP_WEB_Prucha_1.5\uploads/';
        $target_file = $target_dir . basename($_FILES["file"]["name"]);
        $fileSize = $_FILES['file']['size'];
        $fileTmpName = $_FILES['file']['tmp_name'];
        $fileName = strtolower($_FILES["file"]["name"]);
        $fileExt = explode('.', $fileName);
        $fileActualExt = strtolower(end($fileExt));
        $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
        echo "jedeme pres else";


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
            $earlierName = mysqli_real_escape_string($conn, $_SESSION['nameOfTitle']);

// Nahrání souboru
            if ($change == 1) {
                move_uploaded_file($fileTmpName, $target_file);
            }

// Upravení příspěvku v databázi
            $sql = "UPDATE prispevek SET autor='$author', text='$descr' , nazev='$name', jmenoSouboru='$uplFile' WHERE nazev='$earlierName'";
            mysqli_query($conn, $sql);
            header("Location: /SP_WEB_Prucha_1.5/app/control/author.php?upload=success");
            exit();
        } else {
            echo " Nahrání souboru selhalo.";
        }
    }
}
