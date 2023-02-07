<?php

session_start();
require("./include/config.php");

//Conditions pour vérifier le post
if (isset($_POST['Valider'])) {

    //  Connexion à la BDD
$bdd = mysqli_connect('localhost', 'root', '', 'reservationsalles') or die("Impossible de se connecter : " . mysqli_connect_error());



    if (!empty($_POST['titre']) && !empty($_POST['description']) && !empty($_POST['datedebut']) && !empty($_POST['datedefin'])) {

        //  Conditions pour vérifier les Post


        //      Stockage des variable Post
        $titre = htmlspecialchars($_POST['titre']);
        $description = htmlspecialchars($_POST['description']);
        $datedebut = htmlspecialchars($_POST['datedebut']);
        $datedefin = htmlspecialchars($_POST['datedefin']);
        //      Requête d'insertion de donné dans la table reservations
        $addevent = "INSERT INTO reservations (titre , description , debut , fin , id_utilisateur) VALUES ('$titre','$description','$datedebut','$datedefin','$id_user')";

        if (mysqli_query($bdd, $addevent)) {

            header('Location: planning.php');
            exit;
        }
    } else {

        $erreur = "<p>Veuillez verifier tous les champs</p>";
    }
}
ob_start();
?>

<div class="calendrier ">
	<div class="planning" style="padding-top:5%;">
<h1 style=" text-align:center;">Formulaire de réservation</h1>
<div class="main2_reservation-form">
                <article>
                    <p style="text-align:center !important;color:white;" ><b>Durée maximum de 1H par réservervation</b></p>
                    <p style="text-align:center !important;color:white;"><b>Veuillez préciser les informations de votre évènement :</b></p>

                </article>
                    
                
                <div class="condition1 big_box_reservation-form">
                    <div class="reservation-form">
                        <div class="box2_reservation-form">

                            <form method="POST" action="" >

                                <div>
                                    <label for="Login : "></label>
                                    <input type="text" name="titre" placeholder="Titre de l'évènement" size="25" />
                                </div><br>

                                <div>
                                    <textarea name="description" cols="50" rows="5" placeholder="Description"></textarea>
                                </div>

                                <div>
                                    <label for="Date de début : "></label>
                                    <p style="text-align:center;">Date et Heure de début</p>
                                    <input style="text-align:center;" type="datetime" name="datedebut" placeholder=" ex : 2022-01-21 08:00" size="25" />
                                </div>

                                <div>
                                    <label for="Date de fin : "></label>
                                    <p style="text-align:center;">Date et Heure de fin</p>
                                    <input type="datetime" name="datedefin" placeholder=" ex : 2022-01-21 09:00" size="25" />
                                </div>


                                <input type="submit" name="Valider" value="Reserver" class="btn btn-success mt-3" />

                            </form>

                        </div>
                    </div>
                </div>
</div>