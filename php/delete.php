<?php
require("./include/config.php");

var_dump($_GET['id']);
$delete_user = $bdd->prepare("DELETE FROM utilisateurs WHERE id = ?");
$delete_user->execute([$_GET['id']]);
