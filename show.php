<!DOCTYPE html>
<html>
    <head>
		<meta charset="utf-8" />
		<link rel='stylesheet' href='showstyle.css'>
		<link rel='stylesheet' href='extrastyles1.css'>
    </head>
    <body>
		<header>
			<!--Not supported in internet explorer 8 or below-->
			<div class='topbuttonrow'>
				<nav>
					<a href='/html/'>Home</a>
					<a href='/css/'>Special Search</a>
					<a href='/js/'>Standard Search</a>
					<a href='/jquery/'>Your Team</a>
				</nav>
			</div>
		</header>
        <div class='centercolumn'>
		    <div class='half' style='background-color: #ffbbb1;'>	
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
									printf ("<div style='background-color: #ffeca9;'><h1 style='margin: 0;'>");
									printf ($row["poke_name"]);
									echo "</h1></div><div style='background-color: #c7e8ac;'><img src='diamond-pearl/" . $_GET['pokeid'] . ".png' width='160' height='160'></div><div style='background-color: #c1e4f7; padding-top: 10px; padding-bottom: 10px;'><div class='infobox'><div class='infohead'>Types</div>";
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
									printf ("<div style='background-color: #ffeca9;'><h1 style='margin: 0;'>");
									printf ($row["poke_name"]);
									echo "</h1></div><div style='background-color: #c7e8ac;'><img src='diamond-pearl/" . $_GET['pokeid'] . ".png' width='160' height='160'></div><div style='background-color: #c1e4f7; padding-top: 10px; padding-bottom: 10px;'><div class='infobox'><div class='infohead'>Types</div>";
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
		    <div class='half' style='background-color: #3aa6dd;'>
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
								printf ("<tr><td>%s</td><td>%s</td><td>%s</td></tr>", $row["movenm"], $row["power"], $row["learn_method"]);
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
				$pokeurl = "https://people.eecs.ku.edu/~h701w409/eecs647/show.php?pokeid=";
				$breedurl = "https://people.eecs.ku.edu/~h701w409/eecs647/breeding.php?pokeid=";
				echo "<div class='centercolumn'>";
				echo "<div class='lowerhalf'>";
				if(($thispokeid - 1)>0){echo "<div class='bottombutton' id='prevbutton' onclick=\"location.href='".$pokeurl.($thispokeid - 1)."'\">#".strval($thispokeid - 1)."</div>";}
				if(($thispokeid + 1)<494){echo "<div class='bottombutton' id='nextbutton' onclick=\"location.href='".$pokeurl.($thispokeid + 1)."'\">#".strval($thispokeid + 1)."</div>";}
				echo "</div>";
				echo "<div class='lowerhalf'>";
				$query1 = "SELECT `poke_name`, `egg_group1`, `egg_group2` FROM `pokemon` WHERE `national_id`=" . $_GET['pokeid'];
				if($result1 = $mysqli->query($query1))
				{
					if ($trow = $result1->fetch_assoc()) 
					{$f_egg1 = $trow["egg_group1"];}
					$result1->free();
				}
				if(!is_null($f_egg1))
				{echo "<div class='bottombutton' id='prevbutton' onclick=\"location.href='".$breedurl.$thispokeid."'\">Breeding</div>";}
				//echo "kajshfakjjhhgjhjhgj";
				echo "</div>";
				echo "</div>";
			}
		?>
    </body>
</html>
