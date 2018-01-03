<!-- autor -->
<?php

include_once "../view/header-user.php";

?>
<!-- Zobrazení příspěvků v recenzním řízení. Mezi příspěvky se dá
        pohybovat tlačítky Zpět a další. -->
<div id="moje" class="container-fluid">

    <h2>Příspěvky v recenzním řízení</h2>
    <p>Zde jako autor vidíte své příspěvky, které jsou stále v recenzním řízení.</p>
    <p>Příspěvky můžete stále měnit dle libosti.</p>

    <br><br>
    <div id="comment">
        <?php
        $sql = "SELECT * FROM prispevek";
        $result = mysqli_query($conn, $sql);
        $count = 1;
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {

                if ($row['idAutora'] == $_SESSION['u_id']) {
                    if ($row['schvaleni'] == 0) {
                        $_SESSION['nameOfFile'] = $row['jmenoSouboru'];
                        $_SESSION['nameOfTitle'] = $row['nazev'];
                        if ($count == 1) {
                            ?>
                            <h3>Příspěvek <?php echo $count ?></h3>

                            <form class="form-horizontal" action="../model/update-mod.php" method="POST"
                                  enctype="multipart/form-data">

                                <div class="form-group">
                                    <div class="col-sm-2">
                                        <button>
                                            <a href="/SP_WEB_Prucha_1.5/app/model/deleteComm.php?commID=<?php echo $row['idPrispevku'] ?>"
                                               style="color: orangered"
                                               onclick="return confirm('Určitě chcete smazat příspěvek?');">
                                                Smazat příspěvek</a></button>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Název příspěvku:</label>
                                    <div class="col-sm-2">
                                        <input class="form-control" type="text" name="nazev"
                                               value="<?php echo $row['nazev'] ?>" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Autor:</label>
                                    <div class="col-sm-2">
                                        <input class="form-control" type="text" name="autor"
                                               value="<?php echo $row['autor'] ?>" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">Popis:(max.2000)</label>
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
                                                   download>Stahnout soubor</a></button>

                                    </div>
                                </div>
                            </form>

                            <?php
                        }
                        $count++;
                    }
                }
            }
        }
        ?>
    </div>
    <button class="col-sm-2" type="button" id="but2">Zpět</button>
    <button class="col-sm-2" type="button" id="but1">Další</button>


</div>
<!-- Zobrazení již zhodnocených příspěvků a jejich hodnocení. -->
<div id="zhodnocene" class="container-fluid">

    <h2>Schválené/zamítnuté příspěvky</h2>
    <p>Zde jsou Vaše schválené i zamítnuté příspěvky a jejich hodnocení.</p>
    <br>
    <?php
    $userID = $_SESSION['u_id'];
    $sql = "SELECT * FROM prispevek WHERE schvaleni != 0 AND idAutora = '$userID'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $commID = $row['idPrispevku'];
            ?><br><h3><?php echo $row['nazev'] ?></h3><?php

            if ($row['schvaleni'] == 1) {
                ?><p style="font-size: 18px; color: green">-Schváleno-</p><?php
            } else {
                ?><p style="font-size: 18px; color: red">-Zamítnuto-</p><?php
            }
            $sql_h = "SELECT * FROM hodnoceni WHERE prispevek_id = '$commID'";
            $result_h = mysqli_query($conn, $sql_h);
            if (mysqli_num_rows($result_h) > 0) {
                ?>
                <table>
                <tr>
                    <th>Jazyková kvalita</th>
                    <th>Technická kvalita</th>
                    <th>Téma</th>
                    <th>Doporučeno</th>
                </tr>
                <?php
                while ($row_h = mysqli_fetch_assoc($result_h)) {
                    ?>
                    <tr>
                    <td><?php echo $row_h['jazyk_kvalita'] ?></td>
                    <td><?php echo $row_h['tech_kvalita'] ?></td>
                    <td><?php echo $row_h['tema'] ?></td>
                    <td><?php echo $row_h['doporuceni'] ?></td></tr><?php
                }
                ?></table><?php
            } else {
                echo "Hodnocení smazáno.";
            }
        }
    } else {
        echo "Žádné zhodnocené příspěvky.";
    }
    ?>
</div>
<!-- Vytvoření nového příspěvku. -->
<div id="pridat" class="container-fluid">
    <h2>Přidat nový příspěvek</h2>
    <p>Zde můžete přidat nový příspěvek a soubor ve formátu pdf.</p>

    <br><br><br><br><br>
    <form class="form-horizontal" action="../model/upload-mod.php" method="POST" enctype="multipart/form-data">

        <div class="form-group">
            <label class="col-sm-2 control-label">Název příspěvku:</label>
            <div class="col-sm-2">
                <input class="form-control" type="text" name="nazev" required>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label">Autor:</label>
            <div class="col-sm-2">
                <input class="form-control" type="text" name="autor" required>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-2 control-label">Popis:(max.2000)</label>
            <div class="col-sm-2">
                <textarea class="form-control" name="popis" rows="10"></textarea>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">PDF soubor:</label>
            <div class="col-sm-2">
                <input type="file" name="file">
                <button type="submit" name="submit">Nahrát</button>
            </div>
        </div>
    </form>
</div>

<?php

include_once "../view/footer.php";

?>
