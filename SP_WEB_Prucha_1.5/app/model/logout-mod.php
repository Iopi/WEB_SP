<!-- odhlášení uživatele -->

<?php
// Kontrola, jestli proběhlo potvrzení
if (isset($_POST['submit'])) {
    session_start();

    // Kontrola, jestli proběhlo potvrzení
    session_unset();
    session_destroy();
    header("Location: /SP_WEB_Prucha_1.5/index.php");
    exit();
}