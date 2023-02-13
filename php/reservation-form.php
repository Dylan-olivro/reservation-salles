<?php
session_start();
require("./include/config.php");

if (isset($_POST['submit'])) {

    //Variables
    $titre = htmlspecialchars($_POST['titre']);
    $description = htmlspecialchars($_POST['description']);
    $debut = htmlspecialchars($_POST['date-debut']) . " " . $_POST['heure-debut'];
    $fin = htmlspecialchars($_POST['date-debut']) . " " . $_POST['heure-fin'];
    $date = date('Y-m-d H');
    echo '<br>';
    var_dump($date);
    echo '<br>';
    var_dump($debut);
    echo '<br>';
    var_dump($_POST['date-debut']);
    echo '<br>';
    var_dump($weekend);
    echo '<br>';

    // var_dump($_POST['date-debut']);
    // FAIRE UNE CONDITION POUR DIMANCHE ET SAMEDI


    $request = $bdd->prepare("SELECT id FROM utilisateurs WHERE login ='" . $_SESSION['login'] . "'");
    $request->execute();
    $id = $request->fetchAll();
    $id_utilisateur = $id[0][0];

    $recupUser = $bdd->prepare("SELECT * FROM reservations WHERE debut = ?");
    $recupUser->execute([$debut]);
    if (empty($titre)) {
        echo 'champ vide';
    } elseif (empty($_POST['date-debut'])) {
        echo 'veuillez rentrez une date';
    } elseif ($date > $debut) {
        echo 'date passé';
    } elseif ($_POST['heure-fin'] < $_POST['heure-debut']) {
        echo 'Heure fin superieur au heure debut';
    } elseif ($_POST['heure-fin'] - $_POST['heure-debut'] > 1) {
        echo 'reserver une heure';
    } elseif ($_POST['heure-fin'] == $_POST['heure-debut']) {
        echo 'meme heure selectionner';
    } elseif ($_POST['date-debut'] > 5) {
        echo 'dimanche';
    } elseif ($recupUser->rowCount() > 0) {
        echo "<p><i class='fa-solid fa-triangle-exclamation'></i>&nbspCe login est déjà utilisé.</p>";
    } else {
        $request2 = $bdd->prepare("INSERT INTO reservations (titre, description, debut, fin, id_utilisateur) VALUES ('$titre', '$description', '$debut', '$fin', $id_utilisateur)");
        $request2->execute();
    }
    //     //VERIFIER SI LA PLAGE HORAIRE EST DISPONIBLE
    // $request3 = $bdd->prepare("SELECT * FROM reservations WHERE reservations.debut = 1  reservations.fin = 1");
    // $request3->execute();
    // $request3->rowCount();

    //     if ($id_utilisateur1 == 1) {
    //         header('location:reservation-form.php');
    //         echo   "La plage horaire selectionnée n'est pas disponible.";
    //     }
}
?>

<!DOCTYPE html>
<html lang="fr" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation-form</title>
    <link rel="stylesheet" href="../css/common.css">
    <link rel="stylesheet" href="../css/reservation-form.css">
</head>

<body>

    <!--Header-->
    <header>
        <nav>
            <?php require('./include/header-include.php') ?>
        </nav>
    </header>

    <!--Main-->
    <div class="body_form">
        <form action="#" method="post">

            <label for="titre">Titre :</label><br />
            <input type="text" name="titre"><br />
            <label for="description">Description :</label><br />
            <textarea id="description" name="description"></textarea><br />
            <!-- <input type="text" name="description"><br /> -->
            <label for="debut">Date :</label><br />
            <input type="date" name="date-debut"><br />
            <!-- <label for="fin">Fin :</label><br />
        <input type="date" name="date-fin"><br /><br /> -->
            <label for="heure">Heure de démarrage :</label><br />
            <!-- <input type="time" min="09:00" max="18:00" name="heure-debut"><br /><br /> -->
            <select name="heure-debut" id="">
                <option value="8">8h</option>
                <option value="9">9h</option>
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
            <label for="heure">Heure de fin :</label><br />
            <!-- <input type="time" name="heure-fin"><br /><br /> -->
            <select name="heure-fin" id="">
                <option value="9">9h</option>
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


            <input type="submit" name="submit" value="Réserver">
        </form>
    </div>

</body>

</html>