<?php
session_start();
require("./include/config.php");
$recupUser = $bdd->prepare("SELECT * FROM utilisateurs");
$recupUser->execute();
$result = $recupUser->fetchAll(PDO::FETCH_ASSOC);


if ($_GET['id']) {
    $delete_user = $bdd->prepare("DELETE FROM utilisateurs WHERE id = ?");
    $delete_user->execute([$_GET['id']]);
    header('Location:admin.php');
}
