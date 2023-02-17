<?php
session_start();
require("./include/config.php");

$resa_request = $bdd->prepare("SELECT * FROM utilisateurs INNER JOIN reservations ON utilisateurs.id = reservations.id_utilisateur");
$resa_request->execute();
$result = $resa_request->fetchALL(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS -->
    <link rel="stylesheet" href="../css/common.css">
    <link rel="stylesheet" href="../css/planning.css">
    <!-- GOOGLE FONTS -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet">
    <!-- FONT AWESOME -->
    <script src="https://kit.fontawesome.com/9a09d189de.js" crossorigin="anonymous"></script>
    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>

    <title>Planning</title>
</head>

<body>
    <header>
        <nav>
            <?php require('./include/header-include.php') ?>
        </nav>
    </header>

    <main>
        <?php
        $dt = new DateTime();
        if (isset($_GET['year']) && isset($_GET['week'])) {
            $dt->setISODate($_GET['year'], $_GET['week']);
        } else {
            $dt->setISODate($dt->format('o'), $dt->format('W'));
        }
        $year = $dt->format('o');
        $week = $dt->format('W');
        $month = $dt->format('F');
        // $day = $dt->format('');        
        ?>


        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="planning">
                        <!-- METTRE UN AUTRE TITRE -->
                        <h2><?php ?></h2>
                        <a class="btn btn-primary btn-xs" href="<?php echo $_SERVER['PHP_SELF'] . '?week=' . ($week - 1) . '&year=' . $year; ?>">Pre Week</a> <!--Previous week-->
                        <a class="btn btn-primary btn-xs" href="planning.php">Current Week</a> <!--Current week-->
                        <a class="btn btn-primary btn-xs" href="<?php echo $_SERVER['PHP_SELF'] . '?week=' . ($week + 1) . '&year=' . $year; ?>">Next Week</a><!--Next week-->
                    </div>


                    <table class="table table-bordered">
                        <tr class="success">
                            <td></td>
                            <?php
                            do {
                                if ($dt->format('d M Y') == date("d M Y")) {
                                    echo "<td style='background:orange; font-weight:bold;'>" . $dt->format('l') . " " . $dt->format('d M Y') . "</td>\n";
                                } else {
                                    echo "<td style='font-weight:bold;'>" . $dt->format('l') . " " . $dt->format('d M Y') . "</td>\n";
                                }

                                $dt->modify('+1 day');
                            } while ($week == $dt->format('W'));
                            ?>
                        </tr>
                        <?php

                        // boucle pour la colonne des heures
                        for ($line = 8; $line <= 18; $line++) {
                            echo '<tr>';
                            echo "<td style='font-weight:bold;'>" . $line . "h</td>";
                            // boucle pour la ligne des jours de la semaine
                            for ($column = 1; $column <= 7; $column++) {
                                echo "<td style='text-align:center;'>";
                                $signal = 0;

                                foreach ($result as $value) {

                                    $id_comment = $value['id'];
                                    $day = date("N", strtotime($value['debut']));
                                    $resa_hour = date("H", strtotime($value['debut']));
                                    $resa_year = date("o", strtotime($value['debut']));
                                    $resa_week = date("W", strtotime($value['debut']));

                                    $timeSlot = $resa_hour == $line && $day == $column && $resa_year == $year  && $week == $resa_week;
                                    if ($timeSlot) {
                                        $signal = 1;
                                        break;
                                    }
                                }
                                if ($column == 6 || $column == 7) {
                                    echo '<button class="weekend" disabled></button>';
                                } else if ($signal == 1) {
                                    echo "<a href='reservation.php?id=" . $id_comment . "'><button class='reserver'>$value[login]<br>$value[titre]</button></a>";
                                } else if ($signal == 0)
                                    echo "<a href='reservation-form.php'><button class='case'>Disponible</button></a>";
                                echo '</td>';
                            }
                            echo '</tr>';
                        }
                        ?>
                    </table>
                </div>
            </div>
        </div>

    </main>

    <footer id="footerPlanning">
        <a href="https://github.com/Dylan-olivro"><i class="fa-brands fa-github"></i></a>
        <a href="https://github.com/Charles-Caltagirone"><i class="fa-brands fa-github"></i></a>
    </footer>
</body>

</html>