<?php
session_start();
require("./include/config.php");

$requete_resa = $bdd->prepare("SELECT * FROM utilisateurs INNER JOIN reservations ON utilisateurs.id = reservations.id_utilisateur");
$requete_resa->execute();
$resultat = $requete_resa->fetchALL(PDO::FETCH_ASSOC);


$duration = 60;
$cleanup = 0;
$start = "08:00";
$end = "19:00";

function timeslots($duration, $cleanup, $start, $end)
{
    $start = new DateTime($start);
    $end = new DateTime($end);
    $interval = new DateInterval("PT" . $duration . "M");
    $cleanupInterval = new DateInterval("PT" . $cleanup . "M");
    $slots = array();

    for ($intStart = $start; $intStart < $end; $intStart->add($interval)->add($cleanupInterval)) {
        $endPeriod = clone $intStart;
        $endPeriod->add($interval);
        if ($endPeriod > $end) {
            break;
        }
        $slots[] = $intStart->format("H:i") . "-" . $endPeriod->format("H:i");
    }
    return $slots;
}
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
        $dt = new DateTime;
        if (isset($_GET['year']) && isset($_GET['week'])) {
            $dt->setISODate($_GET['year'], $_GET['week']);
        } else {
            $dt->setISODate($dt->format('o'), $dt->format('W'));
        }
        $year = $dt->format('o');
        $week = $dt->format('W');
        $month = $dt->format('F');
        $year = $dt->format('Y');
        ?>


        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <center>
                        <!-- METTRE UN AUTRE TITRE -->
                        <h2><?php ?></h2>
                        <a class="btn btn-primary btn-xs" href="<?php echo $_SERVER['PHP_SELF'] . '?week=' . ($week - 1) . '&year=' . $year; ?>">Pre Week</a> <!--Previous week-->
                        <a class="btn btn-primary btn-xs" href="planning.php">Current Week</a> <!--Current week-->
                        <a class="btn btn-primary btn-xs" href="<?php echo $_SERVER['PHP_SELF'] . '?week=' . ($week + 1) . '&year=' . $year; ?>">Next Week</a> Next week
                    </center>


                    <table class="table table-bordered">
                        <tr class="success">
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
for($ligne =8; $ligne <= 19; $ligne++ )
{
		echo '<tr>';
		echo "<td>".$ligne."h</td>";
// boucle pour la ligne des jours de la semaine
  	for($colonne = 1; $colonne <= 7; $colonne++)
  	{
    				echo "<td>";
				foreach($resultat as $value){

	$id=$value['id'];
					$jour=date("w", strtotime($value['debut']));
					$heure=date("H", strtotime($value['debut']));
				
					if($heure==$ligne && $jour== $colonne)
						{
                        // echo"$value[login]<br>$value[titre]";
						echo"<a href=\"reservation.php?id=".$id."\">$value[login]<br>$value[titre]</a>";
											
						}
						else{
							// echo "vide";
                            // break;
						}
												
		}
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

    <footer><a href="https://github.com/Dylan-olivro"><i class="fa-brands fa-github"></i></a></footer>
</body>

</html>