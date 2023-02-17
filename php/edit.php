<?php
session_start();
require("./include/config.php");

if ($_SESSION['login'] == false) {
    header("Location: ./planning.php");
}

$id_comment = $_GET['id'];
$id = $_SESSION['id'];
$resa_request = $bdd->prepare("SELECT * FROM reservations INNER JOIN utilisateurs ON utilisateurs.id = reservations.id_utilisateur WHERE reservations.id = ?");
$resa_request->execute([$id_comment]);
$result = $resa_request->fetchALL(PDO::FETCH_ASSOC);
$defined_date = substr($result[0]['debut'], 0, -9);
$defined_hour =  substr($result[0]['debut'], 11, -6);
?>

<!DOCTYPE html>
<html lang="fr" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/common.css">
    <link rel="stylesheet" href="../css/inscription.css">
    <!-- FONT AWESOME -->
    <script src="https://kit.fontawesome.com/9a09d189de.js" crossorigin="anonymous"></script>
    <title>Editer réservation</title>

</head>

<body id="bc_reservation-form">

    <!--Header-->
    <header>
        <nav>
            <?php require('./include/header-include.php') ?>
        </nav>
    </header>

    <!--Main-->
    <main>
        <div class="body_form">
            <form action="#" method="post">
                <h3>Editer la réservation</h3>

                <label for="titre">Titre</label>
                <input type="text" placeholder="Titre" name="titre" value="<?= $result[0]['titre'] ?>" required>
                <label for="description">Description</label>
                <textarea id="description" placeholder="Description" name="description"><?= $result[0]['description'] ?></textarea>
                <label for="debut">Date</label>
                <input type="date" name="date-debut" value="<?= $defined_date ?>" required>
                <label for="heure">Heure de démarrage (créneaux d'une heure)</label>
                <select name="heure-debut" id="">
                    <option selected="<?= $defined_hour ?>" value="<?= $defined_hour ?>"><?= $defined_hour . 'h' ?></option>
                    <option value="08">8h</option>
                    <option value="09">9h</option>
                    <option value="10">10h</option>
                    <option value="11">11h</option>
                    <option value="12">12h</option>
                    <option value="13">13h</option>
                    <option value="14">14h</option>
                    <option value="15">15h</option>
                    <option value="16">16h</option>
                    <option value="17">17h</option>
                    <option value="18">18h</option>
                </select>

                <button name="heure-fin" id=""></button>
                <?php

                function cheat_entities($texte)
                {
                    return preg_replace('/&.*;/U', 'a', $texte);
                }

                if (isset($_POST['submit'])) {
                    //Variables
                    $_POST['heure-fin'] = $_POST['heure-debut'] + 1;
                    $title = htmlspecialchars($_POST['titre']);
                    $description = htmlspecialchars($_POST['description']);
                    $start = htmlspecialchars($_POST['date-debut']) . " " . $_POST['heure-debut'];
                    $end = htmlspecialchars($_POST['date-debut']) . " " . $_POST['heure-fin'];
                    $dayStart = htmlspecialchars($_POST['date-debut']);
                    // $dimanche = date("N", strtotime('sunday'));
                    $date = date('Y-m-d H');
                    $dateInt = date('N', strtotime($dayStart));
                    $comment = $_POST['description'];

                    $id_user = $result[0]['id'];

                    $recupDate = $bdd->prepare("SELECT * FROM reservations WHERE debut = ? AND id != ?");
                    $recupDate->execute([$start, $id_comment]);

                    if (empty($title)) {
                        echo "<p><i class='fa-solid fa-triangle-exclamation'></i>&nbspRentrez un titre.</p>";
                    } elseif (empty($_POST['date-debut'])) {
                        echo "<p><i class='fa-solid fa-triangle-exclamation'></i>&nbspSélectionnez une date.</p>";
                    } elseif ($date > $start) {
                        echo "<p><i class='fa-solid fa-triangle-exclamation'></i>&nbspDate déjà passée.</p>";
                    } elseif ($_POST['heure-fin'] < $_POST['heure-debut']) {
                        echo "<p><i class='fa-solid fa-triangle-exclamation'></i>&nbspHeure de FIN supérieure à celle du début.</p>";
                    } elseif ($_POST['heure-fin'] - $_POST['heure-debut'] > 1) {
                        echo "<p><i class='fa-solid fa-triangle-exclamation'></i>&nbspUne heure maximum.</p>";
                    } elseif ($_POST['heure-debut'] > 18 || $_POST['heure-debut'] < 8) {
                        echo "<p><i class='fa-solid fa-triangle-exclamation'></i>&nbspRéserver entre 8h et 18h.</p>";
                    } elseif ($dateInt == 6 || $dateInt == 7) {
                        echo "<p><i class='fa-solid fa-triangle-exclamation'></i>&nbspWeek-end non réservable.</p>";
                    } elseif ($_POST['heure-fin'] == $_POST['heure-debut']) {
                        echo "<p><i class='fa-solid fa-triangle-exclamation'></i>&nbspMême heure sélectionnée.</p>";
                    } elseif (strlen(cheat_entities($title)) > 15) {
                        echo "<p><i class='fa-solid fa-triangle-exclamation'></i>&nbspTitre trop long (15 max).</p>";
                    } elseif (strlen(cheat_entities($comment)) > 1000) {
                        echo "<p><i class='fa-solid fa-triangle-exclamation'></i>&nbspCommentaire trop long (1000 max).</p>";
                    } elseif ($recupDate->rowCount() > 0) {
                        echo "<p><i class='fa-solid fa-triangle-exclamation'></i>&nbspCette date est déjà réservée.</p>";
                    } else {
                        $updateRequest = $bdd->prepare("UPDATE reservations SET titre=?, description=?, debut=?, fin=?, id_utilisateur=? WHERE id = $id_comment");
                        $updateRequest->execute([$title, $description, $start, $end, $id_user]);
                        header('Location:planning.php');
                    }
                }
                ?>
                <input type="submit" name="submit" class="button" value="Réserver">
            </form>
    </main>

    <footer>
        <a href="https://github.com/Dylan-olivro"><i class="fa-brands fa-github"></i></a>
        <a href="https://github.com/Charles-Caltagirone"><i class="fa-brands fa-github"></i></a>
    </footer>
</body>

</html>