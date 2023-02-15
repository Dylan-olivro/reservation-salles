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
    header("Location: ./planning.php");
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

            <div class="infos">
                <h3>Détails</h3>


                <p class="titre">Login </p>
                <p class="valeur"><?php echo $reservation['login'] ?></p>
                <p class="titre">Titre </p>
                <p class="valeur"><?php echo $reservation['titre'] ?></p>
                <p class="titre">Description </p>
                <p class="valeur text"><?php echo $reservation['description'] ?></p>
                <p class="titre">Date/heure de début </p>
                <p class="valeur"><?php echo $reservation['debut'] ?></p>
                <p class="titre">Date/heure de fin </p>
                <p class="valeur"><?php echo $reservation['fin'] ?></p>
                <form action="" method="post">
                    <?php
                    // var_dump($resultat);
                    if ($_SESSION['login'] == $reservation['login'] || $_SESSION['login'] == 'admin') {
                        echo '<button type="submit "name="delete" value="Supprimer" id="button">Supprimer</button>';
                        if (isset($_POST['delete'])) {
                            $suppr_resa = $bdd->prepare("DELETE FROM reservations WHERE id = ?");
                            $suppr_resa->execute([$id]);
                            header('Location: planning.php');
                        }
                    } else {
                        echo '<a href="planning.php"><input id="button" value="Planning"></input></a>';
                    }
                    if ($_SESSION['login'] == $reservation['login'] || $_SESSION['login'] == 'admin') {
                        echo "<a href='edit.php?id=" . $id . "'><input id='button' value='Editer'></input></a>";
                    }
                    ?>
                </form>

                <!-- <input type="submit" name="envoi" id="button" value="Retour au planning"> -->

            </div>
        <?php
        }
        ?>


    </main>

    <footer>
        <a href="https://github.com/Dylan-olivro"><i class="fa-brands fa-github"></i></a>
        <a href="https://github.com/Charles-Caltagirone"><i class="fa-brands fa-github"></i></a>
    </footer>
</body>

</html>