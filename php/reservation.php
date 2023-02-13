<?php
session_start();
require("./include/config.php");
// var_dump($_SESSION);
$id = $_GET['id'];
$requete_resa = $bdd->prepare("SELECT * FROM reservations INNER JOIN utilisateurs ON utilisateurs.id = reservations.id_utilisateur WHERE reservations.id = ?");
$requete_resa->execute([$id]);
$resultat = $requete_resa->fetchALL(PDO::FETCH_ASSOC);
// var_dump($resultat);
if ($_SESSION['login'] == false) {
    header("Location: ../index.php");
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
    <link rel="stylesheet" href="../css/reservation.css">

    <!-- GOOGLE FONTS -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet">
    <!-- FONT AWESOME -->
    <script src="https://kit.fontawesome.com/9a09d189de.js" crossorigin="anonymous"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <title>Réservation actuelle</title>
</head>

<body>
    <header>
        <nav>
            <?php require('./include/header-include.php') ?>
        </nav>
    </header>

    <main>
        <?php
        // var_dump($_SESSION);
        ?>

        <?php
        foreach ($resultat as $reservation) {
        ?>

            <div class="body_form">
                <form action="#" method="post">

                    <h2>Login</h2><br />
                    <p><?php echo $reservation['login'] ?></p><br />
                    <h2>Titre</h2><br />
                    <p><?php echo $reservation['titre'] ?></p><br />
                    <h2>Description</h2><br />
                    <p><?php echo $reservation['description'] ?></p><br />
                    <h2>Date/heure de début</h2><br />
                    <p><?php echo $reservation['debut'] ?></p><br />
                    <h2>Date/heure de fin</h2><br />
                    <p><?php echo $reservation['fin'] ?></p><br />
                    <a href="planning.php">Retour au planning</a>
                </form>
            </div>
        <?php
        }
        ?>


    </main>

    <footer><a href="https://github.com/Dylan-olivro"><i class="fa-brands fa-github"></i></a></footer>

</body>

</html>