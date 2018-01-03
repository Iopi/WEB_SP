<!-- recenzent -->
<?php

include_once "../view/header-user.php";

?>
<!-- Hodnocení příspěvku recenzentem. Pokud poslané hodnocení daného příspěvku již existuje,
       hodnocení se změní. -->
<div id="hodnoceni" class="row-fluid">
    <h2>Příspěvky k hodnocení</h2>
    <p>Zde jako recenzent můžete hodnotit Vám přidělené příspěvky.</p>

    <br>
    <?php
    $userID = $_SESSION['u_id'];
    $sql = "SELECT * FROM prispevek WHERE idRecenzenta1 = '$userID' OR idRecenzenta2 = '$userID' OR idRecenzenta3 = '$userID'";
    $results = mysqli_query($conn, $sql);
    if (mysqli_num_rows($results) > 0) {
        while ($row = mysqli_fetch_assoc($results)) {
            if ($row['schvaleni'] == 0) {
                $commID = $row['idPrispevku'];
                ?>
                <div class="col-sm-6">
                    <br>
                    <h3>Název příspěvku: <?php echo $row['nazev'] ?></h3>
                    <br>
                    <button><a href="/SP_WEB_Prucha_1.5/uploads/<?php echo $row['jmenoSouboru'] ?>" download>Stahnout
                            soubor</a></button>
                    <?php echo $row['jmenoSouboru'] ?><br>
                    <br>
                    <form class="form-horizontal" action="../model/ranking-mod.php?commID=<?php echo $commID ?>
            &userID=<?php echo $userID ?>" method="POST" enctype="multipart/form-data">

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Jazyková kvalita:</label>
                            <div class="col-sm-2">
                                <select class=form-control" name="jazyk" required>
                                    <option value="0">0 bodů</option>
                                    <option value="1">1 bod</option>
                                    <option value="2">2 body</option>
                                    <option value="3">3 body</option>
                                    <option value="4">4 body</option>
                                    <option value="5">5 bodů</option>
                                    <option value="6">6 bodů</option>
                                    <option value="7">7 bodů</option>
                                    <option value="8">8 bodů</option>
                                    <option value="9">9 bodů</option>
                                    <option value="10">10 bodů</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Technická kvalita:</label>
                            <div class="col-sm-2">
                                <select class=form-control" name="technika" required>
                                    <option value="0">0 bodů</option>
                                    <option value="1">1 bod</option>
                                    <option value="2">2 body</option>
                                    <option value="3">3 body</option>
                                    <option value="4">4 body</option>
                                    <option value="5">5 bodů</option>
                                    <option value="6">6 bodů</option>
                                    <option value="7">7 bodů</option>
                                    <option value="8">8 bodů</option>
                                    <option value="9">9 bodů</option>
                                    <option value="10">10 bodů</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Téma:</label>
                            <div class="col-sm-2">
                                <select class=form-control" name="tema" required>
                                    <option value="0">0 bodů</option>
                                    <option value="1">1 bod</option>
                                    <option value="2">2 body</option>
                                    <option value="3">3 body</option>
                                    <option value="4">4 body</option>
                                    <option value="5">5 bodů</option>
                                    <option value="6">6 bodů</option>
                                    <option value="7">7 bodů</option>
                                    <option value="8">8 bodů</option>
                                    <option value="9">9 bodů</option>
                                    <option value="10">10 bodů</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Doporučení:</label>
                            <div class="col-sm-2">
                                <select class=form-control" name="doporuceni" required>
                                    <option value="ne">Nedoporučuji</option>
                                    <option value="ano">Doporučiji</option>
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="form-group">
                            <div class="col-sm-2">
                                <button type="submit" name="submit">Potvrdit</button>
                            </div>
                        </div>
                    </form>
                </div>
                <?php
            }
        }
    }
    ?>
</div>
<?php

include_once "../view/footer.php";

?>
