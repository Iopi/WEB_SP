<!-- načtení dalšího nebo předchozího příspěvku pro autora -->

<?php

session_start();

include '../model/dbh.php';

$commentNewCount = $_POST['commentNewCount'];

$sql = "SELECT * FROM prispevek";
$result = mysqli_query($conn, $sql);
$count = 1;
if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {

        if ((int)$row['idAutora'] == (int)$_SESSION['u_id']) {
            if ($row['schvaleni'] == 0) {
                if ($count == $commentNewCount) {
                    $_SESSION['nameOfFile'] = $row['jmenoSouboru'];
                    $_SESSION['nameOfTitle'] = $row['nazev'];
                    ?>
                    <h3>Příspěvek <?php echo $count ?></h3>

                    <form class="form-horizontal" action="../model/update-mod.php" method="POST"
                          enctype="multipart/form-data">
                        <div class="form-group">
                            <div class="col-sm-2">
                                <button>
                                    <a href="/SP_WEB_Prucha_1.5/app/model/deleteComm-mod.php?commID=<?php echo $row['idPrispevku'] ?>"
                                       style="color: orangered"
                                       onclick="return confirm('Určitě chcete smazat příspěvek?');">Smazat příspěvek</a>
                                </button>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Název příspěvku:</label>
                            <div class="col-sm-2">
                                <input class="form-control" type="text" name="nazev" value="<?php echo $row['nazev'] ?>"
                                       required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Autor:</label>
                            <div class="col-sm-2">
                                <input class="form-control" type="text" name="autor" value="<?php echo $row['autor'] ?>"
                                       required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Popis:</label>
                            <div class="col-sm-2">
                                <textarea class="form-control" name="popis"
                                          rows="10"><?php echo $row['text'] ?></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">PDF soubor:</label>
                            <div class="col-sm-2">
                                <input type="file" name="file">
                                <br>
                                <button type="submit" name="submit">Provést změnu</button>
                                <br><br>
                                <?php echo $row['jmenoSouboru'] ?><br>
                                <button><a href="/SP_WEB_Prucha_1.5/uploads/<?php echo $row['jmenoSouboru'] ?>"
                                           download>Stahnout
                                        soubor</a></button>
                            </div>
                        </div>
                    </form>
                    <?php
                }
                $count++;
            }
        }
    }
} else {
    echo "Žádné příspěvky.";
}
?>