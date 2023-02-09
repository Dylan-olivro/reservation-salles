<?php
session_start();
require("./include/config.php");
// $bdd = mysqli_connect("localhost", "root", "", 'reservationsalles');

if (isset($_POST['submit'])) {

    //Variables
    $titre = htmlspecialchars($_POST['titre']);
    $description = htmlspecialchars($_POST['description']);
    $debut = htmlspecialchars($_POST['date-debut']) . " " . $_POST['heure-debut'];
    $fin = htmlspecialchars($_POST['date-debut']) . " " . $_POST['heure-fin'];

    //N'AUTORISER QU'UNE HEURE MAX DE RESERVATION

    //INSERER RESERVATION DANS BDD
    // $requete = "SELECT id FROM utilisateurs WHERE login ='" . $_SESSION['login'] . "'";
    // $query = mysqli_query($bdd, $requete);
    // $id = mysqli_fetch_all($query);
    // $id_utilisateur = $id[0][0];

    $request = $bdd->prepare("SELECT id FROM utilisateurs WHERE login ='" . $_SESSION['login'] . "'");
    $request->execute();
    $id = $request->fetchAll();
    $id_utilisateur = $id[0][0];

    $recupUser = $bdd->prepare("SELECT * FROM reservations WHERE debut = ?");
    $recupUser->execute([$debut]);

    if ($recupUser->rowCount() > 0) {
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

// var_dump($request3);
?>

<!DOCTYPE html>
<html lang="fr" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation-form</title>
    <link rel="stylesheet" href="css/index.css">
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
                <option value="8h">8h</option>
                <option value="9h">9h</option>
                <option value="10h">10h</option>
                <option value="11h">11h</option>
                <option value="12h">12h</option>
                <option value="13h">13h</option>
                <option value="14h">14h</option>
                <option value="15h">15h</option>
                <option value="16h">16h</option>
                <option value="17h">17h</option>
                <option value="18h">18h</option>
            </select>
            <label for="heure">Heure de fin :</label><br />
            <!-- <input type="time" name="heure-fin"><br /><br /> -->
            <select name="heure-fin" id="">
                <option value="9h">9h</option>
                <option value="10h">10h</option>
                <option value="11h">11h</option>
                <option value="12h">12h</option>
                <option value="13h">13h</option>
                <option value="14h">14h</option>
                <option value="15h">15h</option>
                <option value="16h">16h</option>
                <option value="17h">17h</option>
                <option value="18h">18h</option>
                <option value="19h">19h</option>
            </select>


            <input type="submit" name="submit" value="Réserver">
        </form>
    </div>

</body>

</html>