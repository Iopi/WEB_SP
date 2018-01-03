<!-- administrátor -->
<?php

include_once "../view/header-user.php";

?>
<!-- Vytvoření tabulky všech uživatelů, kterým může administrátor změnit roli, zablokovat je nebo je smazat. -->
<div id="uzivatele" class="container-fluid">
    <h2>Uživatelé</h2>
    <p>Zde jako administrátor vidíte všechny uživatele.</p>
    <p>Můžete jim měnit roli, zablokovat je nebo je smazat.</p><br><br>
    <?php
    $sql = "SELECT * FROM uzivatele";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        ?>
        <table>
            <tr>
                <th>Uživatel</th>
                <th>Role</th>
                <th>Změna role</th>
                <th>Zablokovat</th>
                <th>Smazat</th>
            </tr>
            <?php

            while ($row = mysqli_fetch_assoc($result)) {
                $userId = $row['uzivatel_id'];
                $blocked = $row['blokovan'];
                if ($row['uzivatel_id'] != 1) {
                    ?>
                    <tr>
                        <td><?php echo $row['uzivatel_jmeno'] . " " . $row['uzivatel_prijmeni'] ?></td>
                        <td><?php if ($row['recenzent'] == 1) {
                                echo "recenzent";
                            } else {
                                echo "autor";
                            } ?></td>
                        <td>
                            <form class="dropdown" action="/SP_WEB_Prucha_1.5/app/model/changeRole-mod.php"
                                  method="POST">
                                <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    Role
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                    <li <?php if ($row['recenzent'] == 1) { ?>
                                        class="active"
                                        <?php
                                    }
                                    ?>>
                                        <a name="autor"
                                           href="/SP_WEB_Prucha_1.5/app/model/changeRole-mod.php?userID=<?php echo $userId; ?>&number=1">Recenzent</a>
                                    </li>

                                    <li <?php if ($row['recenzent'] != 1) { ?>
                                        class="active"
                                        <?php
                                    }
                                    ?>>
                                        <a href="/SP_WEB_Prucha_1.5/app/model/changeRole-mod.php?userID=<?php echo $userId; ?>&number=0"">Autor</a>
                                    </li>
                                </ul>
                            </form>
                        </td>
                        <td>
                            <?php
                            if ($blocked == 1) {
                            ?>
                            <a href="/SP_WEB_Prucha_1.5/app/model/blockUser-mod.php?userID=<?php echo $userId; ?>&blocked=0">
                                <button type="button" class="btn btn-default btn-sm" style="font-size: 16px">
                                <span class=" 	glyphicon glyphicon-minus-sign"
                                      style="font-size:20px;color:green;"></span> Odblokovat
                                </button>
                                <?php
                                } else {
                                ?>
                                <a href="/SP_WEB_Prucha_1.5/app/model/blockUser-mod.php?userID=<?php echo $userId; ?>&blocked=1"
                                   onclick="return confirm('Určitě chcete uživatele zablokovat?');">
                                    <button type="button" class="btn btn-default btn-sm" style="font-size: 16px">
                                <span class=" 	glyphicon glyphicon-minus-sign"
                                      style="font-size:20px;color:red;"></span> Blokovat
                                    </button>
                                    <?php
                                    }
                                    ?>
                        </td>
                        <td>
                            <a href="/SP_WEB_Prucha_1.5/app/model/deleteUser-mod.php?userID=<?php echo $userId; ?>"
                               onclick="return confirm('Určitě chcete uživatele smazat?');">
                                <button type="button" class="btn btn-default btn-sm" style="font-size: 16px">
                                    <span class="glyphicon glyphicon-remove-circle"
                                          style="font-size:20px;color:red;"></span> Smazat
                                </button>
                            </a>
                        </td>
                    </tr>
                    <?php
                }
            }
            ?>
        </table>

        <?php
    }
    ?>
</div>
<!-- Vytvoření tabulky všech příspěvků, jejich recenzentů, pokud jsou, a jejich hodnocení, pokud je.
        Pokud recenzent není, administrátor ho může přidělit. -->
<div id="prirazeni" class="container-fluid">
    <h2>Příspěvky k přiřazení</h2>
    <p>Zde přiřazujete recenzenty k jednotlivým příspěvkům. U příspěvku vidíte i jeho hodnocení, pokud je.</p>
    <p>Ke stejnému příspěvku nemůžete dát stejného recenzenta vícekrát než-li jednou.</p><br><br>
    <table>
        <tr>
            <th rowspan="2">Název příspěvku</th>
            <th rowspan="2">Autor</th>
            <th rowspan="2">Přiřazení</th>
            <th colspan="4">Recenze</th>
        </tr>
        <tr>
            <th>Jazyk</th>
            <th>Technika</th>
            <th>Tema</th>
            <th>Doporučení</th>
        </tr>
        <tr>
            <th>1</th>
            <th>1</th>
            <th>1</th>
            <th>1</th>
            <th>1</th>
            <th>1</th>
            <th>1</th>
        </tr>

        <?php
        $sql = 'SELECT * FROM prispevek
            LEFT JOIN uzivatele ON prispevek.idRecenzenta1 = uzivatele.uzivatel_id
            LEFT JOIN hodnoceni ON prispevek.idPrispevku = hodnoceni.prispevek_id AND prispevek.idRecenzenta1 = hodnoceni.recenzent_id';
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                ?>
                <tr>
                    <td><?php echo $row['nazev'] ?></td>
                    <td><?php echo $row['autor'] ?></td>

                    <?php if ($row['idRecenzenta1'] != 0) { ?>
                        <td>
                            <?php echo $row['uzivatel_jmeno'] . " " . $row['uzivatel_prijmeni']; ?>
                        </td>
                        <?php if ($row['doporuceni'] != null) { ?>
                            <td><?php echo $row['jazyk_kvalita'] ?></td>
                            <td><?php echo $row['tech_kvalita'] ?></td>
                            <td><?php echo $row['tema'] ?></td>
                            <td><?php echo $row['doporuceni'] ?></td>
                        <?php } else {
                            ?>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <?php
                        }
                    } else {
                        ?>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    Přiřadit příspěvek
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                    <?php
                                    $sql_u = "SELECT * FROM uzivatele";
                                    $result_u = mysqli_query($conn, $sql_u);
                                    if (mysqli_num_rows($result_u) > 0) {
                                        foreach ($result_u as $one_user) {
                                            if ($one_user['recenzent'] == 1) {
                                                $commID = $row['idPrispevku'];
                                                $sql_p = "SELECT * FROM prispevek WHERE idPrispevku = '$commID'";
                                                $result_p = mysqli_query($conn, $sql_p);
                                                if (mysqli_num_rows($result_p) > 0) {
                                                    while ($row_p = mysqli_fetch_assoc($result_p)) {
                                                        if ($one_user['uzivatel_id'] != $row_p['idRecenzenta2'] && $one_user['uzivatel_id'] != $row_p['idRecenzenta3']) {
                                                            ?>
                                                            <li>
                                                                <a href="/SP_WEB_Prucha_1.5/app/model/assignComment-mod.php?userID=<?php echo $one_user['uzivatel_id']; ?>&assign=<?php echo $row['idPrispevku']; ?>&dbRev=idRecenzenta1">
                                                                    <?php echo $one_user['uzivatel_jmeno'] . " " . $one_user['uzivatel_prijmeni']; ?></a>
                                                            </li>
                                                            <?php
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    } else {
                                        ?>
                                        <li> <?php echo "Žádní recenzenti k dispozici."; ?></li>
                                        <?php
                                    }
                                    ?>

                                </ul>
                            </div>
                        </td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <?php
                    }
                    ?>
                </tr> <?php
            }
        }
        ?>
        <tr>
            <th>2</th>
            <th>2</th>
            <th>2</th>
            <th>2</th>
            <th>2</th>
            <th>2</th>
            <th>2</th>
        </tr>
        <?php
        $sql2 = 'SELECT * FROM prispevek
            LEFT JOIN uzivatele ON prispevek.idRecenzenta2 = uzivatele.uzivatel_id
            LEFT JOIN hodnoceni ON prispevek.idPrispevku = hodnoceni.prispevek_id AND prispevek.idRecenzenta2 = hodnoceni.recenzent_id';
        $result2 = mysqli_query($conn, $sql2);
        if (mysqli_num_rows($result2) > 0) {
            while ($row2 = mysqli_fetch_assoc($result2)) {
                ?>
                <tr>
                    <td><?php echo $row2['nazev'] ?></td>
                    <td><?php echo $row2['autor'] ?></td>

                    <?php if ($row2['idRecenzenta2'] != 0) { ?>
                        <td>
                            <?php echo $row2['uzivatel_jmeno'] . " " . $row2['uzivatel_prijmeni']; ?>
                        </td>
                        <?php if ($row2['doporuceni'] != null) { ?>
                            <td><?php echo $row2['jazyk_kvalita'] ?></td>
                            <td><?php echo $row2['tech_kvalita'] ?></td>
                            <td><?php echo $row2['tema'] ?></td>
                            <td><?php echo $row2['doporuceni'] ?></td>
                        <?php } else {
                            ?>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <?php
                        }
                    } else {
                        ?>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    Přiřadit příspěvek
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                    <?php
                                    $sql_u = "SELECT * FROM uzivatele";
                                    $result_u = mysqli_query($conn, $sql_u);
                                    if (mysqli_num_rows($result_u) > 0) {
                                        foreach ($result_u as $one_user) {
                                            if ($one_user['recenzent'] == 1) {
                                                $commID = $row2['idPrispevku'];
                                                $sql_p = "SELECT * FROM prispevek WHERE idPrispevku = '$commID'";
                                                $result_p = mysqli_query($conn, $sql_p);
                                                if (mysqli_num_rows($result_p) > 0) {
                                                    while ($row_p = mysqli_fetch_assoc($result_p)) {
                                                        if ($one_user['uzivatel_id'] != $row_p['idRecenzenta1'] && $one_user['uzivatel_id'] != $row_p['idRecenzenta3']) {
                                                            ?>
                                                            <li>
                                                                <a href="/SP_WEB_Prucha_1.5/app/model/assignComment-mod.php?userID=<?php echo $one_user['uzivatel_id']; ?>&assign=<?php echo $row2['idPrispevku']; ?>&dbRev=idRecenzenta2">
                                                                    <?php echo $one_user['uzivatel_jmeno'] . " " . $one_user['uzivatel_prijmeni']; ?></a>
                                                            </li>
                                                            <?php
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    } else {
                                        ?>
                                        <li> <?php echo "Žádní recenzenti k dispozici."; ?></li>
                                        <?php
                                    }
                                    ?>

                                </ul>
                            </div>
                        </td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <?php
                    }
                    ?>
                </tr> <?php
            }
        }
        ?>
        <tr>
            <th>3</th>
            <th>3</th>
            <th>3</th>
            <th>3</th>
            <th>3</th>
            <th>3</th>
            <th>3</th>
        </tr>
        <?php
        $sql3 = 'SELECT * FROM prispevek
            LEFT JOIN uzivatele ON prispevek.idRecenzenta3 = uzivatele.uzivatel_id
            LEFT JOIN hodnoceni ON prispevek.idPrispevku = hodnoceni.prispevek_id AND prispevek.idRecenzenta3 = hodnoceni.recenzent_id';
        $result3 = mysqli_query($conn, $sql3);
        if (mysqli_num_rows($result3) > 0) {
            while ($row3 = mysqli_fetch_assoc($result3)) {
                ?>
                <tr>
                    <td><?php echo $row3['nazev'] ?></td>
                    <td><?php echo $row3['autor'] ?></td>

                    <?php if ($row3['idRecenzenta3'] != 0) { ?>
                        <td>
                            <?php echo $row3['uzivatel_jmeno'] . " " . $row3['uzivatel_prijmeni']; ?>
                        </td>
                        <?php if ($row3['doporuceni'] != null) { ?>
                            <td><?php echo $row3['jazyk_kvalita'] ?></td>
                            <td><?php echo $row3['tech_kvalita'] ?></td>
                            <td><?php echo $row3['tema'] ?></td>
                            <td><?php echo $row3['doporuceni'] ?></td>
                        <?php } else {
                            ?>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <?php
                        }
                    } else {
                        ?>
                        <td>
                            <div class="dropdown">
                                <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                    Přiřadit příspěvek
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                    <?php


                                    $sql_u = "SELECT * FROM uzivatele";
                                    $result_u = mysqli_query($conn, $sql_u);
                                    if (mysqli_num_rows($result_u) > 0) {
                                        foreach ($result_u as $one_user) {
                                            if ($one_user['recenzent'] == 1) {
                                                $commID = $row3['idPrispevku'];
                                                $sql_p = "SELECT * FROM prispevek WHERE idPrispevku = '$commID'";
                                                $result_p = mysqli_query($conn, $sql_p);
                                                if (mysqli_num_rows($result_p) > 0) {
                                                    while ($row_p = mysqli_fetch_assoc($result_p)) {
                                                        if ($one_user['uzivatel_id'] != $row_p['idRecenzenta1'] && $one_user['uzivatel_id'] != $row_p['idRecenzenta2']) {
                                                            ?>
                                                            <li>
                                                                <a href="/SP_WEB_Prucha_1.5/app/model/assignComment-mod.php?userID=<?php echo $one_user['uzivatel_id']; ?>&assign=<?php echo $row3['idPrispevku']; ?>&dbRev=idRecenzenta3">
                                                                    <?php echo $one_user['uzivatel_jmeno'] . " " . $one_user['uzivatel_prijmeni']; ?></a>
                                                            </li>
                                                            <?php
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    } else {
                                        ?>
                                        <li> <?php echo "Žádní recenzenti k dispozici."; ?></li>
                                        <?php
                                    }
                                    ?>

                                </ul>
                            </div>
                        </td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <?php
                    }
                    ?>
                </tr> <?php
            }
        }
        ?>
    </table>
</div>
<!-- Vytvoření tabulky všech příspěvků zhodnocených třemi různými recnzenty.
        Administrátor je může schválit nebo zamítnout. Pokud je schválí, příspěvek se zobrazí na úvodní stránce. -->
<div id="schvaleni" class="container-fluid">
    <h2>Příspěvky ke schválení</h2>
    <p>Pokud je nějaký příspěvek třikrát zhodnocen, uvidíte ho zde i s jeho součtem zhodnocení.</p>
    <p>Příspěvek můžete schválit nebo zamítnout. Pokud jej schválíte, zobrazí se na úvodní stránce.</p><br><br>
    <table>
        <tr>
            <th>Název</th>
            <th>Jazyk</th>
            <th>Technika</th>
            <th>Tema</th>
            <th>Doporučení</th>
            <th>Schválení</th>
        </tr>
        <?php
        $sql = "SELECT * FROM prispevek WHERE idRecenzenta1 != 0 AND idRecenzenta2 != 0 AND idRecenzenta3 != 0";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                if ($row['schvaleni'] == 0) {
                    $commentID = $row['idPrispevku'];
                    $count = 0;
                    $sql_h = "SELECT * FROM hodnoceni WHERE prispevek_id = '$commentID'";
                    $result_h = mysqli_query($conn, $sql_h);
                    if (mysqli_num_rows($result_h) > 0) {
                        $lang = 0;
                        $tech = 0;
                        $topic = 0;
                        $recomm = 0;
                        while ($row_h = mysqli_fetch_assoc($result_h)) {
                            $lang += $row_h['jazyk_kvalita'];
                            $tech += $row_h['tech_kvalita'];
                            $topic += $row_h['tema'];
                            if ($row_h['doporuceni'] == "ano") {
                                $recomm++;
                            }
                            $count++;
                        }
                        if ($count > 2) {
                            $commID = $row['idPrispevku'];
                            ?>
                            <tr>
                                <td><?php echo $row['nazev'] ?></td>
                                <td><?php echo $lang; ?></td>
                                <td><?php echo $tech; ?></td>
                                <td><?php echo $topic; ?></td>
                                <td><?php if ($recomm > 1) {
                                        echo "doporučeno";
                                    } else {
                                        echo "nedoporučeno";
                                    } ?></td>
                                <td>
                                    <a href="/SP_WEB_Prucha_1.5/app/model/confirm-mod.php?commID=<?php echo $commID; ?>&conf=1">
                                        <button type="button" class="btn btn-default btn-sm"
                                                style="font-size: 16px">
                                <span class=" 	glyphicon glyphicon-ok"
                                      style="font-size:20px;color:green;"></span> Schválit
                                        </button>
                                        <a href="/SP_WEB_Prucha_1.5/app/model/confirm-mod.php?commID=<?php echo $commID; ?>&conf=2">
                                            <button type="button" class="btn btn-default btn-sm"
                                                    style="font-size: 16px">
                                <span class="glyphicon glyphicon-remove"
                                      style="font-size:20px;color:red;"></span> Zamítnout
                                            </button></td>
                            </tr>
                            <?php
                        }
                    }
                }
            }
        }
        ?>
    </table>
</div>

<?php

include_once "../view/footer.php";

?>