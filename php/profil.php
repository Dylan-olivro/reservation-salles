<?php
session_start();
require "./include/config.php";

if ($_SESSION['login'] == false) {
    header("Location: ./planning.php");
}
?>
<!DOCTYPE html>
<html lang="fr" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS -->
    <link rel="stylesheet" href="../css/common.css">
    <link rel="stylesheet" href="../css/inscription.css">
    <!-- GOOGLE FONTS -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet">
    <!-- FONT AWESOME -->
    <script src="https://kit.fontawesome.com/9a09d189de.js" crossorigin="anonymous"></script>

    <title>Profil</title>
</head>

<body id="bc_profil">
    <header>
        <nav>
            <?php require './include/header-include.php' ?>
        </nav>
    </header>

    <main>
        <form method="post" action="profil.php">
            <h3>Modifier Profil</h3>

            <label for="login">Login</label>
            <input type="text" name="login" id="login" value="<?= $_SESSION['login']  ?>" required />
            <label for="password">Password</label>
            <input type="password" name="password" id="password" required />
            <label for="newpassword">Nouveau Password</label>
            <input type="password" name="newpassword" id="newpassword" />
            <label for="cnewpassword">Confirmation</label>
            <input type="password" name="cnewpassword" id="cnewpassword" />
            <?php
            if (isset($_POST['submit'])) {
                $login = htmlspecialchars($_POST['login']);
                $password = $_POST['password'];
                $newPassword = $_POST['newpassword'];
                $newPasswordHash = password_hash($newPassword, PASSWORD_DEFAULT);
                $confirmNewPassword = $_POST['cnewpassword'];
                $id = $_SESSION['id'];

                $recupUser = $bdd->prepare("SELECT * FROM utilisateurs WHERE login = ? AND id != ?");
                $recupUser->execute([$login, $id]);

                $insertUser = $bdd->prepare("UPDATE utilisateurs SET login = ? , password=  ? WHERE id = ?");


                if (empty($login) || empty($password)) {
                    echo "<p><i class='fa-solid fa-triangle-exclamation'></i>&nbspVeuillez complétez tous les champs.</p>";
                } elseif (!preg_match("#^[a-z0-9]+$#", $login)) {
                    echo "<p><i class='fa-solid fa-triangle-exclamation'></i>&nbspLe login doit être renseigné en lettres minuscules sans accents, sans caractères spéciaux.</p>";
                } elseif ($recupUser->rowCount() > 0) {
                    echo "<p><i class='fa-solid fa-triangle-exclamation'></i>&nbspCe login est déjà utilisé.</p>";
                } else {
                    $recupPassword = $bdd->prepare("SELECT password FROM utilisateurs WHERE login = ?");
                    $recupPassword->execute([$_SESSION['login']]);
                    $result = $recupPassword->fetchAll();
                    $passwordHash = $result[0]['password'];

                    if ($password != password_verify($password, $passwordHash)) {
                        echo  "<p><i class='fa-solid fa-triangle-exclamation'></i>&nbspCe n'est pas le bon mot de passe</p>";
                    } else {

                        if ($newPassword == password_verify($newPassword, $passwordHash) && $newPassword == $password) {
                            echo "<p><i class='fa-solid fa-triangle-exclamation'></i>&nbspMot de passe similaire</p>";
                        } elseif ($newPassword == $confirmNewPassword && $newPassword != null && $confirmNewPassword != null) {
                            $insertUser->execute([$login, $newPasswordHash, $id]);
                            $_SESSION['login'] = $login;
                            $_SESSION['password'] = $newPasswordHash;
                            header("Location: profil.php");
                        } else {
                            if ($result) {

                                if (password_verify($password, $passwordHash)) {
                                    $insertUser->execute([$login, $passwordHash, $id]);
                                    $_SESSION['login'] = $login;
                                    $_SESSION['password'] = $password;
                                    header("Location: profil.php");
                                }
                            }
                        }
                    }
                }
            }
            if ($_SESSION['login'] == 'admin') {
                echo "<p><i class='fa-solid fa-triangle-exclamation'></i>&nbspIMPOSSIBLE de supprimer ce compte.</p>";
            } else {
                if (isset($_POST['delete_user'])) {
                    if ($_SESSION['login']) {
                        if ($_POST['delete_user']) {
                            $delete_user = $bdd->prepare("DELETE FROM utilisateurs WHERE id = ?");
                            $delete_user->execute([$_SESSION['id']]);
                            session_destroy();
                            header('Location: planning.php');
                        }
                    }
                }
            }

            ?>
            <input type="submit" name="submit" class="button" value="Edit">
            <button type="submit " name="delete_user" value="Delete" class="button delete" onclick="return confirm(`Voulez vous vraiment supprimer votre compte ?`)">Supprimer le compte</button>
        </form>

    </main>

    <footer id="footerProfil">
        <a href="https://github.com/Dylan-olivro"><i class="fa-brands fa-github"></i></a>
        <a href="https://github.com/Charles-Caltagirone"><i class="fa-brands fa-github"></i></a>
    </footer>
</body>

</html>