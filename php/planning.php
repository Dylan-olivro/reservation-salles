<?php
session_start();
require("./include/config.php");

$requete_resa = $bdd->prepare("SELECT * FROM utilisateurs INNER JOIN reservations ON utilisateurs.id = reservations.id_utilisateur");
$requete_resa->execute();
$resultat = $requete_resa->fetchALL(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS -->
    <link rel="stylesheet" href="../css/common.css">
    <link rel="stylesheet" href="../css/signup.css">
    <!-- GOOGLE FONTS -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet">
    <!-- FONT AWESOME -->
    <script src="https://kit.fontawesome.com/9a09d189de.js" crossorigin="anonymous"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <title>Planning</title>
</head>

<body>
    <header>
        <img src="../assets/mysql-logo.png" alt="logo">
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
                    <center>
                        <!-- METTRE UN AUTRE TITRE -->
                        <h2><?php ?></h2>
                        <a class="btn btn-primary btn-xs" href="<?php echo $_SERVER['PHP_SELF'] . '?week=' . ($week - 1) . '&year=' . $year; ?>">Pre Week</a> <!--Previous week-->
                        <a class="btn btn-primary btn-xs" href="planning.php">Current Week</a> <!--Current week-->
                        <a class="btn btn-primary btn-xs" href="<?php echo $_SERVER['PHP_SELF'] . '?week=' . ($week + 1) . '&year=' . $year; ?>">Next Week</a><!--Next week-->
                    </center>


                    <table class="table table-bordered">
                        <tr class="success">
                            <td></td>
                            <?php
                            do {
                                if ($dt->format('d M Y') == date("d M Y")) {
                                    echo "<td style='background:yellow;'>" . $dt->format('l') . " " . $dt->format('d M Y') . "</td>\n";
                                } else {
                                    echo "<td>" . $dt->format('l') . " " . $dt->format('d M Y') . "</td>\n";
                                }

                                $dt->modify('+1 day');
                            } while ($week == $dt->format('W'));
                            ?>
                        </tr>
                        <?php
                        // boucle pour la colonne des heures
                        for ($ligne = 8; $ligne <= 19; $ligne++) {
                            echo '<tr>';
                            echo "<td>" . $ligne . "h</td>";
                            // boucle pour la ligne des jours de la semaine
                            for ($colonne = 1; $colonne <= 7; $colonne++) {
                                echo "<td>";
                                foreach ($resultat as $value) {

                                    $id = $value['id'];
                                    $jour = date("N", strtotime($value['debut']));
                                    $heure = date("H", strtotime($value['debut']));
                                    $annee = date("o", strtotime($value['debut']));
                                    $semaine = date("W", strtotime($value['debut']));
                                    // var_dump($colonne);
                                    // var_dump($semaine);
                                    // var_dump($mois)
                                    // var_dump($annee);
                                    // if($semaine == $week){
                                    //     var_dump($_GET['week']);

                                    //     var_dump('OK');
                                    // }
                                    // var_dump($day);
                                    // var_dump($week);
                                    // var_dump($month);
                                    // var_dump($year);

                                    // var_dump($value['debut']);
                                    if ($heure == $ligne && $jour == $colonne && $annee == $year  && $week == $semaine) {

                                        // if ($heure == $ligne || $jour == $colonne || $annee == $year || $mois == $month || $day == $nbJour || $week == $semaine) {
                                        echo "<a href=\"reservation.php?id=" . $id . "\">$value[login] : $value[titre]<br></a>";
                                    }
                                    if (($heure == $ligne) == NULL && ($jour == $colonne) == NULL && ($annee == $year) == NULL && ($semaine == $week) == NULL) {
                                        echo "vide";
                                    }
                                    if ($colonne == 6 || $colonne == 7) {
                                        echo 'Pas Disponible';
                                        break;
                                    }
                                }
                                echo '</td>';
                            }
                            echo '</tr>';
                        }

                        var_dump($jour);

                        ?>
                    </table>
                </div>
            </div>
        </div>



    </main>

    <footer><a href="https://github.com/Dylan-olivro"><i class="fa-brands fa-github"></i></a></footer>
</body>

</html>