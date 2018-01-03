<!-- registrace -->
<?php

include_once "../view/header.php";

?>
<!-- Načtení údajů pro registraci -->
<section class="main-container">
    <div class="main-wrapper">
        <h2>Zaregistrovat</h2>
        <form class="signup-form" action="/SP_WEB_Prucha_1.5/app/model/signup-mod.php" method="POST">
            <input type="text" name="first" placeholder="jméno" required>
            <input type="text" name="last" placeholder="příjmení" required>
            <input type="email" name="email" placeholder="email" required>
            <input type="text" name="login" placeholder="nick" required>
            <input type="password" name="pwd" placeholder="heslo" required>
            <button type="submit" name="submit">Registrovat</button>
        </form>
    </div>
</section>

<?php

include_once "../view/footer.php";

?>

