<?php
session_start();
require("./include/config.php");
?>


<?php

$mois = date('m');
$annee = date('Y');
$jour = date('D/d');


?>


<html>
<!DOCTYPE html>

<head>
    <link rel="stylesheet" type="text/css" href="../css/style.css" />
    <!-- <script type="text/javascript" src="http://code.jquery.com/jquery-2.1.4.min.js"></script> -->
    <title>Calendrier</title>
</head>


<body>
<header>
        <img src="../assets/mysql-logo.png" alt="logo">
        <nav>
            <?php require('./include/header-include.php') ?>
        </nav>
    </header>

    <div>
        <img id="prev" src="../img/fleche_gauche.png" height="40px" width="40px" style="float:left;" />
        <img id="next" src="../img/fleche_droite.png" height="40px" width="40px" style="float:right;" />
    </div>

    <div id="content">
    </div>

    <table>
        <tr>
            <th>
                Horaires
            </th>
            <th>Lundi
                <?= $jour ?>
            </th>
            <th>
                Mardi
                <?= $jour ?>
            </th>
            <th>
                Mercredi
                <?= $jour ?>
            </th>
            <th>
                Jeudi
                <?= $jour ?>
            </th>
            <th>
                Vendredi
                <?= $jour ?>
            </th>
            <th>
                Samedi
                <?= $jour ?>
            </th>
            <th>
                Dimanche
                <?= $jour ?>
            </th>

        </tr>

        <tr>
            <th>créneau horaire</th>
        </tr>
        <tr>
            <th>créneau horaire</th>
        </tr>
        <tr>
            <th>créneau horaire</th>
        </tr>
        <tr>
            <th>créneau horaire</th>
        </tr>
    </table>

    <?php
    $nombre_de_jour = cal_days_in_month(CAL_GREGORIAN, $mois, $annee);

    echo "<table>";

    echo "<tr><th>Lun</th><th>Mar</th><th>Mer</th><th>Jeu</th><th>Ven</th><th>Sam</th><th>Dim</th></tr>";

    for ($i = 1; $i <= $nombre_de_jour; $i++) {

        $jour = cal_to_jd(CAL_GREGORIAN, $mois, $i, $annee);
        $jour_semaine = JDDayOfWeek($jour);

        if ($i == $nombre_de_jour) {

            if ($jour_semaine == 1) {
                echo "<tr>";
            }

            echo "<td class='case'>" . $i . "</td></tr>";
        } elseif ($i == 1) {

            echo "<tr>";

            if ($jour_semaine == 0) {
                $jour_semaine = 7;
            }

            for ($k = 1; $k != $jour_semaine; $k++) {
                echo "<td></td>";
            }

            echo "<td class='case'>" . $i . "</td>";

            if ($jour_semaine == 7) {
                echo "</tr>";
            }
        } else {

            if ($jour_semaine == 1) {
                echo "<tr>";
            }

            echo "<td class='case'>" . $i . "</td>";

            if ($jour_semaine == 0) {
                echo "</tr>";
            }
        }
    }

    echo "</table>";
    ?>




</body>

</html>