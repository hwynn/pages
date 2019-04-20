<?php
	include 'secret.php';
	$mysqli = new mysqli($host, $user, $password, $database);
	/* check connection */
	if ($mysqli->connect_errno) {
		printf("Connect failed: %s\n", $mysqli->connect_error);
		exit();
	}

	$pokeid = 405;
	
	$query = "SELECT poke_name, poke_type1, poke_type2, abil_name1, abil_name2, location, pokedexText FROM  `pokemon` WHERE national_id =405";
	if ($result = $mysqli->query($query)) {
		/* fetch associative array */
		if ($row = $result->fetch_assoc()) {
			printf ("pokemon name: %s   type1: %s	type2: %s abil_name1:	%s  abil_name2: %s   location: %s	pokedex:  %s", $row["poke_name"], $row["poke_type1"], $row["poke_type2"], $row["abil_name1"], $row["abil_name2"], $row["location"], $row["pokedexText"]);
		}
		
		/*while ($row = $result->fetch_assoc()) {
			printf ("%s (%s)\n", $row["Name"], $row["CountryCode"]);
		}*/

		/* free result set */
		$result->free();
	}
	/* close connection */
	$mysqli->close();
?>





pokename

id
picturefile

type1 type2


pokedex entry

locations

ability1	abilitytext

ability2	abilitytext





learnmoves
move	power	description








