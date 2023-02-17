<?php
require("./include/config.php");
$recupUser = $bdd->prepare("SELECT * FROM utilisateurs");


var_dump($_GET['id']);
$delete_user = $bdd->prepare("DELETE FROM utilisateurs WHERE id = ?");
$delete_user->execute([$_GET['id']]);
