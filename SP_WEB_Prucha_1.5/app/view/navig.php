<!-- navigace -->

<section class="main-container">

    <!-- Načtení příspěvků na úvodní stránku -->
    <?php
    $sql = "SELECT * FROM prispevek WHERE schvaleni = 1";
    $results = mysqli_query($conn, $sql);
    if (mysqli_num_rows($results) > 0) {
        while ($row = mysqli_fetch_assoc($results)) {

            ?>
            <div class="col-sm-4">
            <br>
            <h3><?php echo $row['nazev'] ?></h3>
            <p><?php echo "Autor: ".$row['autor'] ?></p>
            <p><?php echo $row['text'] ?></p>
            <button><a href="/SP_WEB_Prucha_1.5/uploads/<?php echo $row['jmenoSouboru'] ?>" download>Stahnout soubor</a>
            </button>
            <br>
            <?php echo $row['jmenoSouboru'] ?><br>
            </div><?php
        }
    } else {
        ?><h3>Žádné příspěvky</h3><?php
    }

    ?>
</section>