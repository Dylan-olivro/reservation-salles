<?php
session_start();
require "./php/include/config.php"
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS -->
    <link rel="stylesheet" href="./css/common.css">
    <!-- <link rel="stylesheet" href="./css/index.css"> -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet">
    <!-- FONT AWESOME -->
    <script src="https://kit.fontawesome.com/9a09d189de.js" crossorigin="anonymous"></script>

    <title>Index</title>
</head>

<body>
    <header>
        <nav>
            <?php require './php/include/header-index.php' ?>
        </nav>
    </header>

    <main>
        <h1 class="titreIndex">Bienvenue sur votre site de réservation de salles !</h1>
        <style>
            body {
                background-image: url(./assets/salle.jpg);
                background-attachment: fixed;
                background-size: cover;
            }
        </style>
        <?php
        // if (isset($_SESSION['login'])) {
        //     echo strtoupper($_SESSION['login']);
        // }
        ?>
        <!-- <style>
            h1 {
                text-align: center;
                font-size: 5rem;
                margin: 5% 0 0;
            }

            @media screen and (max-width: 425px) {
                h1 {
                    font-size: 3rem;
                }
            }
        </style> -->
    </main>
    <footer>
        <a href="https://github.com/Dylan-olivro"><i class="fa-brands fa-github"></i></a>
        <a href="https://github.com/Charles-Caltagirone"><i class="fa-brands fa-github"></i></a>
    </footer>
</body>

</html>