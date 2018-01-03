<!-- zablokovaný uživatel -->
<?php

include_once "../view/header.php";

?>

<!-- Oznámení zablokovanému uživateli po přihlášení -->
<section class="main-container">
    <div class="blockedUser">
        <p>Váš účet je zablokován.</p>
        <a href="/SP_WEB_Prucha_1.5/index.php">
            <button type="button" name="submit">Ok</button>
        </a>
    </div>
</section>

<?php

include_once "../view/footer.php";

?>

