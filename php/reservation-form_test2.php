<?php
session_start();
require("./include/config.php");


$requete_resa = $bdd->prepare("SELECT * FROM utilisateurs INNER JOIN reservations ON utilisateurs.id = reservations.id_utilisateur");
$requete_resa->execute();
$resultat = $requete_resa->fetchALL(PDO::FETCH_ASSOC);

// $reser = "SELECT * FROM reservations";
// $users = "SELECT * FROM utilisateurs";
// $connexion = mysqli_connect("localhost", "root", "", "reservationsalles");
// $reponse = "SELECT * FROM utilisateurs INNER JOIN reservations ON utilisateurs.id = reservations.id_utilisateur";

// $query = mysqli_query($connexion, $reponse);
// $resultat=mysqli_fetch_all($query);

?>          

<html>
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" href="index.css"/>
		<title>planning test</title>
	</head>

<body class="fondgrey">

<header class="menu">

<nav>
 <?php 
 require('./include/header-include.php') ?>
 </nav>

</header>
		
		<main>
<section>
<table border="1">
	<thead>
		<tr>
			<td></td>
			<td>Lundi</td>
			<td>Mardi</td>
			<td>Mercredi</td>
			<td>Jeudi</td>
			<td>Vendredi</td>
			<td>Samedi</td>
			<td>Dimanche</td>
        </tr>

<?php	
						
$ligne = 11;
$colonne = 7;
$jour = array('Lundi','Mardi','Mercredi','Jeudi','Vendredi',
'Samedi','Dimanche');
$heure=array('08h00','09h00','10h00','11h00','12h00','13h00',
'14h00','15h00','16h00','17h00','18h00','19h00')	;

?>
   <tbody>
    <tr>

<?php
// boucle pour la colonne des heures
for($ligne =8; $ligne <= 19; $ligne++ )
{
		echo '<tr>';
		echo "<td>".$ligne."h</td>";
// boucle pour la ligne des jours de la semaine
  	for($colonne = 1; $colonne <= 7; $colonne++)
  	{
    				echo "<td>";
				foreach($resultat as $value){

	// $id=$value[0];
					$jour=date("w", strtotime($value['debut']));
					$heure=date("H", strtotime($value['debut']));
				
					if($heure==$ligne && $jour== $colonne)
						{
                        echo"$value[login]<br>$value[titre]";
						// echo"<a href=\"reservation.php?id=".$id."\">$value[0]<br>$value[2]</a>";
											
						}
						else{
							//echo "non";
						}
												
		}
		echo '</td>';
	}
		echo '</tr>';			
}
var_dump($resultat);
?>



</tr>
   </tbody>

</table>


</section>

</main>
<footer>
				<section>
		</section>
	</footer>	
</body>
</html>