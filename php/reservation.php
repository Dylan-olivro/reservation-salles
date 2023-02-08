<?php
session_start();
require("./include/config.php");
$id= $_GET['id'];
$requete_resa = $bdd->prepare("SELECT * FROM utilisateurs INNER JOIN reservations ON utilisateurs.id = reservations.id_utilisateur WHERE reservations.id = ?");
$requete_resa->execute([$id]);
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
    <title>Réservation actuelle</title>
</head>

<body>
    <main>
        <div class="container">
        
            <table>
                <h2>Informations des users</h2>
        
                <thead>
                    <tr>
                        <th>Créateur</th>
                        <th>Titre</th>
                        <th>Descripton</th>
                        <th>Début</th>
                        <th>Fin</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($resultat as $value) {
                    ?>
                        <tr>
                            <?php echo "<td>" . ($value['login']) . "</td>" ?>
                            <?php echo "<td>" . $value['titre'] . "</td>" ?>
                            <?php echo "<td>" . $value['description'] . "</td>" ?>
                            <?php echo "<td>" . $value['debut'] . "</td>" ?>
                            <?php echo "<td>" . $value['fin'] . "</td>" ?>
                        <?php
                    }
                        ?>
                        </tr>
                </tbody>
            </table>
        </div>
        <?php
        var_dump($resultat);
        ?>
    </main>
</body>


    </html>