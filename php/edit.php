<?php
session_start();
require("./include/config.php");

if ($_SESSION['login'] == false) {
    header("Location: ./planning.php");
}

$pre_date = date("Y-m-d");
$id_commentaire = $_GET['id'];
$requete_resa = $bdd->prepare("SELECT * FROM reservations INNER JOIN utilisateurs ON utilisateurs.id = reservations.id_utilisateur WHERE reservations.id = ?");
$requete_resa->execute([$id_commentaire]);
$resultat = $requete_resa->fetchALL(PDO::FETCH_ASSOC);
// var_dump($resultat);
// var_dump($resultat[0]['debut']);
// $a = strtotime($resultat[0]['debut']);
// var_dump($a);
// var_dump($id_commentaire);
// $resultat[0]['debut'] = mktime("Y-m-d");
// var_dump($resultat[0]['debut']);


?>

<!DOCTYPE html>
<html lang="fr" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/common.css">
    <link rel="stylesheet" href="../css/inscription.css">
    <!-- <link rel="stylesheet" href="../css/reservation-form.css"> -->
    <!-- FONT AWESOME -->
    <script src="https://kit.fontawesome.com/9a09d189de.js" crossorigin="anonymous"></script>
    <title>Nouvelle réservation</title>

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
                <h3>Demande de réservation</h3>

                <label for="titre">Titre</label>
                <input type="text" placeholder="Titre" name="titre" value="<?= $resultat[0]['titre'] ?>" required>
                <label for="description">Description</label>
                <textarea id="description" placeholder="Description" name="description"><?= $resultat[0]['description'] ?></textarea>
                <label for="debut">Date</label>
                <input type="date" name="date-debut" value="<?= $pre_date ?>" required>
                <label for="heure">Heure de démarrage</label>
                <select name="heure-debut" id="">
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
                <label for="heure">Heure de fin</label>
                <!-- <input type="time" name="heure-fin">   -->
                <select name="heure-fin" id="">
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
                    <option value="19">19h</option>
                </select>
                <?php

                function triche_entites($texte)
                {
                    return preg_replace('/&.*;/U', 'a', $texte);
                }

                if (isset($_POST['submit'])) {

                    //Variables
                    $titre = htmlspecialchars($_POST['titre']);
                    $description = htmlspecialchars($_POST['description']);
                    $debut = htmlspecialchars($_POST['date-debut']) . " " . $_POST['heure-debut'];
                    $fin = htmlspecialchars($_POST['date-debut']) . " " . $_POST['heure-fin'];
                    $dayStart = htmlspecialchars($_POST['date-debut']);
                    // $dimanche = date("N", strtotime('sunday'));
                    $date = date('Y-m-d H');
                    $dateInt = date('N', strtotime($dayStart));
                    $commentaire = $_POST['description'];

                    $id_utilisateur = $resultat[0]['id'];

                    $recupDate = $bdd->prepare("SELECT * FROM reservations WHERE debut = ?");
                    $recupDate->execute([$debut]);

                    if (empty($titre)) {
                        echo "<p><i class='fa-solid fa-triangle-exclamation'></i>&nbspRentrez un titre.</p>";
                    } elseif (empty($_POST['date-debut'])) {
                        echo "<p><i class='fa-solid fa-triangle-exclamation'></i>&nbspSélectionnez une date.</p>";
                    } elseif ($date > $debut) {
                        echo "<p><i class='fa-solid fa-triangle-exclamation'></i>&nbspDate déjà passée.</p>";
                    } elseif ($_POST['heure-fin'] < $_POST['heure-debut']) {
                        echo "<p><i class='fa-solid fa-triangle-exclamation'></i>&nbspHeure de FIN supérieure à celle du début.</p>";
                    } elseif ($_POST['heure-fin'] - $_POST['heure-debut'] > 1) {
                        echo "<p><i class='fa-solid fa-triangle-exclamation'></i>&nbspUne heure maximum.</p>";
                    } elseif ($dateInt == 6 || $dateInt == 7) {
                        echo "<p><i class='fa-solid fa-triangle-exclamation'></i>&nbspWeek-end non réservable.</p>";
                    } elseif ($_POST['heure-fin'] == $_POST['heure-debut']) {
                        echo "<p><i class='fa-solid fa-triangle-exclamation'></i>&nbspMême heure sélectionnée.</p>";
                    } elseif (strlen($titre) > 15) {
                        echo "<p><i class='fa-solid fa-triangle-exclamation'></i>&nbspTitre trop long (15 max).</p>";
                    } elseif (strlen($commentaire) > 1000) {
                        echo "<p><i class='fa-solid fa-triangle-exclamation'></i>&nbspCommentaire trop long (1000 max).</p>";
                    } elseif ($recupDate->rowCount() > 0) {
                        echo "<p><i class='fa-solid fa-triangle-exclamation'></i>&nbspCette date est déjà réservée.</p>";
                    } else {
                        $request2 = $bdd->prepare("UPDATE reservations SET titre=?, description=?, debut=?, fin=?, id_utilisateur=? WHERE id = $id_commentaire");
                        $request2->execute([$titre, $description, $debut, $fin, $id_utilisateur]);
                        // header('Location:planning.php');
                    }
                }
                ?>
                <input type="submit" name="submit" id="button" value="Réserver">
            </form>
    </main>

    <footer>
        <a href="https://github.com/Dylan-olivro"><i class="fa-brands fa-github"></i></a>
        <a href="https://github.com/Charles-Caltagirone"><i class="fa-brands fa-github"></i></a>
    </footer>
</body>

</html>