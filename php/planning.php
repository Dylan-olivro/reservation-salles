<?php
session_start();
require("./include/config.php");
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

    <title>Planning</title>
</head>

<body>
    <header>
        <img src="../assets/mysql-logo.png" alt="logo">
        <nav>
            <?php require('./include/header-include.php') ?>
        </nav>
    </header>

    <main>
        <table></table>
    </main>

    <footer><a href="https://github.com/Dylan-olivro"><i class="fa-brands fa-github"></i></a></footer>
</body>

</html>