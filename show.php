<!DOCTYPE html>
<html>
    <head>
		<title>Pokémon Planner</title>
		<meta charset="utf-8" />
		<meta name="author" content="Harrison E. Wynn">
		<link rel='stylesheet' href='commonstyle.css'>
		<link rel='stylesheet' href='smallmovetable.css'>
		<style>
			.infotext
			{
				font-family: "Verdana", Sans-serif;
				font-size: 10px;
				padding: 4px;
			}
			.infotext span
			{
				font-family: "Verdana", Sans-serif;
				font-size: 10px;
				font-weight: bold;
			}
			.infohead
			{
				font-size: 14px;
				font-family: Serif;
				font-weight: bold;
				background-color: #f1f1f1;
			}		
			.infobox
			{
				outline-style: double;
				width: 90%;
				margin-left: 5%;
				margin-bottom: 3px;
			}

			.lowerhalf
			{
			position:relative;
			height:36px;
			width: 50%;
			margin: 0;
			padding: 10px;
			max-height: 600px;
			display: inline-block;
			text-align: center;
			background-color: #f1f1f1;
			}
		
			.bottombutton
			{
				height: 30px;
				width: 80px;
				font-size: 16px;
				text-align: center;
				background-color: lightseagreen;
				padding-top: 5px;
				border-radius: 10px;
			}

			.bottombutton:hover
			{
				cursor: pointer;
				background-color: darkturquoise;
			}

			#prevbutton
			{
				display: inline-block;
				float: left;
			}
			#nextbutton
			{
				display: inline-block;
				float: right;
			}

			.leftbottombutton
			{
				display: inline-block;
				float: left;
				margin-right: 20px;
			}
			


		</style>
		
    </head>
    <body>
		<header>
			<!--Not supported in internet explorer 8 or below-->
			<div class='topbuttonrow'>
				<nav>
					<a href='/~h701w409/eecs647/home.html'>Home</a>
					<a href='/~h701w409/eecs647/standardsearch.php'>Standard Search</a>
					<a href='/~h701w409/eecs647/specialsearch.php'>Special Search</a>
					<a href='/~h701w409/eecs647/credit.html'>Credit</a>
				</nav>
			</div>
		</header>
        <div class='centercolumn'>
		    <div class='half'>	
				<?php
					include 'secret.php';
					$mysqli = new mysqli($host, $user, $password, $database);
					/* check connection */
					if ($mysqli->connect_errno) {
						printf("Connect failed: %s\n", $mysqli->connect_error);
						exit();
					}
					mysqli_set_charset($con,"utf8");
					if (isset($_GET['pokeid']))
					{
						if (!filter_input(INPUT_GET, "pokeid", FILTER_VALIDATE_INT))
						{
						echo("No valid id in url");
						exit();
						}
						$c_abil2 = FALSE;//c_ is for conditional. This stores if the pokemon has a second ability
						
						$query1 = "SELECT abil_text FROM `abilities`, `pokemon` WHERE national_id=" . $_GET['pokeid'] . " AND abil_name2=abil_name;";
						$query2 = "SELECT poke_name, poke_type1, poke_type2, abil_name1, abil_name2, abil1.abil_text AS abil_text1, abil2.abil_text AS abil_text2, location, pokedexText 
						FROM `pokemon`,
						(SELECT abil_text FROM `abilities`, `pokemon` WHERE national_id=" . $_GET['pokeid'] . " AND abil_name1=abil_name)abil1,
						(SELECT abil_text FROM `abilities`, `pokemon` WHERE national_id=" . $_GET['pokeid'] . " AND abil_name2=abil_name)abil2 
						WHERE national_id =" . $_GET['pokeid'];
						$query3 = "SELECT poke_name, poke_type1, poke_type2, abil_name1, abil1.abil_text AS abil_text1, location, pokedexText 
						FROM `pokemon`,
						(SELECT abil_text FROM `abilities`, `pokemon` WHERE national_id=" . $_GET['pokeid'] . " AND abil_name1=abil_name)abil1
						WHERE national_id =" . $_GET['pokeid'];
						if($result1 = $mysqli->query($query1))
						{
							if ($trow = $result1->fetch_assoc()) 
							{$c_abil2 = TRUE;}
							/* free result set */
							$result1->free();
						}
						else
						{ echo "We don't know if it has a 2nd ability or not";}
						if($c_abil2)
						{	//if pokemon has second ability, use the query that includes abil2
							if ($result2 = $mysqli->query($query2)) 
							{
								/* fetch associative array */
								if ($row = $result2->fetch_assoc()) {
									printf ("<div><h1 style='margin: 0;'>");
									printf ($row["poke_name"]);
									echo "</h1></div><div><img src='diamond-pearl/" . $_GET['pokeid'] . ".png' width='160' height='160'></div><div style='background-color: #c1e4f7; padding-top: 10px; padding-bottom: 10px;'><div class='infobox'><div class='infohead'>Types</div>";
									printf ($row["poke_type1"]);
									if (!empty($row["poke_type2"])){printf("        " . $row["poke_type2"]);}
									echo "</div><div class='infobox'><div class='infohead'>Pokédex Entry</div><div class='infotext'>";
									$string = $row["pokedexText"];
									printf ($row["pokedexText"]);
									echo "</div></div>";
									echo "<div class='infobox'><div class='infohead'>Locations</div><div class='infotext'>" . $row["location"] . "</div></div>";
									
									echo "<div class='infobox'><div class='infohead'>Abilities</div><div class='infotext'>";
									echo "<span>" . $row["abil_name1"] . "</span>: ";
									echo $row["abil_text1"] . "</div>";
									printf("<div class='infotext'><span>" . $row["abil_name2"] . "</span>: " . $row["abil_text2"] . "</div>");
									echo "</div></div>";
								}
								else {echo "no row returned";}
								/* free result set */
								$result2->free();
							}
							else { echo "bad result2?";}
						}
						else
						{	//if pokemon has no second ability, don't check for abil2
							if ($result3 = $mysqli->query($query3)) 
							{
								/* fetch associative array */
								if ($row = $result3->fetch_assoc()) {
									printf ("<div><h1 style='margin: 0;'>");
									printf ($row["poke_name"]);
									echo "</h1></div><div><img src='diamond-pearl/" . $_GET['pokeid'] . ".png' width='160' height='160'></div><div style='background-color: #c1e4f7; padding-top: 10px; padding-bottom: 10px;'><div class='infobox'><div class='infohead'>Types</div>";
									printf ($row["poke_type1"]);
									if (!empty($row["poke_type2"])){printf("        " . $row["poke_type2"]);}
									echo "</div><div class='infobox'><div class='infohead'>Pokédex Entry</div><div class='infotext'>";
									printf ($row["pokedexText"]);
									echo "</div></div>";
									echo "<div class='infobox'><div class='infohead'>Locations</div><div class='infotext'>" . $row["location"] . "</div></div>";
									
									echo "<div class='infobox'><div class='infohead'>Abilities</div><div class='infotext'>";
									echo "<span>" . $row["abil_name1"] . "</span>: ";
									echo $row["abil_text1"] . "</div>";
									echo "</div></div>";
								}
								else {echo "no row returned";}
								/* free result set */
								$result3->free();
							}
							else { echo "bad result3?";}
						}
						
						
						/* close connection */
						$mysqli->close();	
					} else { echo "pokemon id not found.";}
				?>
			</div>
		    <div class='half'>
				<?php
					include 'secret.php';
					$mysqli = new mysqli($host, $user, $password, $database);
					/* check connection */
					if ($mysqli->connect_errno) {
						printf("Connect failed: %s\n", $mysqli->connect_error);
						exit();
					}
					if (isset($_GET['pokeid'])) 
					{
						if (!filter_input(INPUT_GET, "pokeid", FILTER_VALIDATE_INT))
						{
						echo("int is not valid");
						exit();
						}
						echo "<div id='table_shell'><table id='fixed_table'>
						<thead>
							<tr>
								<th>Move</th>
								<th>Power</th>
								<th>Description</th>
							</tr>
						</thead>
						</table><table id='scroll_table'><tbody>";
						
						$query = "SELECT poke_name, learn.move_name AS movenm, power, learn_method, move_text FROM `pokemon`, `learn`, `moves` WHERE learn.national_id=pokemon.national_id AND learn.move_name=moves.move_name AND pokemon.national_id=" . $_GET['pokeid'];
						if ($result = $mysqli->query($query)) {
							/* fetch associative array */
							while($row = $result->fetch_assoc()) {
								echo "<tr>";
								echo "<td>";
								echo "<a href='".$moveurl.$row['movenm']."'>";
								echo $row["movenm"];
								echo "</a>";
								echo "</td>";
								echo "<td>";
								echo $row["power"];
								echo "</td>";
								echo "<td>";
								echo $row["learn_method"];
								echo "</td>";
								echo "</tr>";
							}
							
							/*while ($row = $result->fetch_assoc()) {
								printf ("%s (%s)\n", $row["Name"], $row["CountryCode"]);
							}*/

							/* free result set */
							$result->free();
						}
						echo "</tbody></table></div>";
						/* close connection */
						$mysqli->close();
					} else { echo "pokemon id not found.";}
				?>
			</div>
		</div>
		<?php
			include 'secret.php';
			$mysqli = new mysqli($host, $user, $password, $database);
			/* check connection */
			if ($mysqli->connect_errno) {
				printf("Connect failed: %s\n", $mysqli->connect_error);
				exit();
			}
			if (isset($_GET['pokeid'])) 
			{
				//$thispokeid = var_dump($_GET['pokeid']);
				$thispokeid = strval($_GET['pokeid']);
				if (!filter_input(INPUT_GET, "pokeid", FILTER_VALIDATE_INT))
				{
				echo("int is not valid");
				exit();
				}
				//echo("int is valid");
								//previous
				//next
				//breeding compatibility link
				//
				$query1 = "SELECT abil_text FROM `abilities`, `pokemon` WHERE national_id=" . $thispokeid . " AND abil_name2=abil_name;";
				
				echo "<div class='centercolumn'>";
				echo "<div class='lowerhalf'>";
				if(($thispokeid - 1)>0){echo "<div class='bottombutton' id='prevbutton' onclick=\"location.href='".$pokeurl.($thispokeid - 1)."'\">#".strval($thispokeid - 1)."</div>";}
				if(($thispokeid + 1)<494){echo "<div class='bottombutton' id='nextbutton' onclick=\"location.href='".$pokeurl.($thispokeid + 1)."'\">#".strval($thispokeid + 1)."</div>";}
				echo "</div>";
				echo "<div class='lowerhalf'>";
				$query1 = "SELECT `poke_name`, `egg_group1`, `egg_group2` FROM `pokemon` WHERE `national_id`=" . $_GET['pokeid'];
				if($result1 = $mysqli->query($query1))
				{
					if ($row = $result1->fetch_assoc()) 
					{$f_egg1 = $row["egg_group1"];}
					$result1->free();
				}
				if(!is_null($f_egg1))
				{echo "<div class='bottombutton leftbottombutton' onclick=\"location.href='".$breedurl.$thispokeid."'\">Breeding</div>";}
			
				$query2 = "SELECT `move_name`, `learn_method` FROM `learn`
WHERE (learn_method='Egg Move' OR learn_method like 'Pre-Evolution Move: #% at ') AND national_id=" . $_GET['pokeid'];
				if($result2 = $mysqli->query($query2))
				{if ($row = $result2->fetch_assoc())//if this pokemon has any egg moves
				{echo "<div class='bottombutton leftbottombutton' onclick=\"location.href='".$eggmoveurl.$thispokeid."'\">Egg Moves</div>";}
				}
				
				echo "</div>";
				echo "</div>";
				
			}
			$mysqli->close();
		?>
    </body>
</html>
