<?php
if (isset($_SESSION['login'])) {
    echo '<a href="./index.php">Accueil-</a>';
    echo '<a href="./php/profil.php">-Profil-</a>';
    echo '<a href="./php/reservation-form.php">-Nouvelle réservation-</a>';
    echo '<a href="./php/reservation-form_test.php">-test réser-</a>';
    echo '<a href="./php/planning_test.php">-tests planning-</a>';
    echo '<a href="./php/reservation.php">-Réservation en cours-</a>';
    echo '<a href="./php/planning.php">-Planning</a>';
    if ($_SESSION["login"] == "admin") {
        echo '<a href="./php/admin.php">Admin</a>';
    }
    echo '<a href="./php/logout.php"><i class="fa-solid fa-right-from-bracket"></i></a>';
} else {
    echo '<a href="./index.php">Accueil</a>';
    echo '<a href="./php/connexion.php">Se connecter</a>';
    echo "<a href='./php/inscription.php'>S'inscrire</a>";
}
