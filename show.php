<!DOCTYPE html>
<html>
    <head>
        <meta charset='utf-8'>
		<link rel='stylesheet' href='showstyle.css'>
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
				<div style='background-color: #ffeca9;'>
						<?php
							include 'secret.php';
							$mysqli = new mysqli($host, $user, $password, $database);
							/* check connection */
							if ($mysqli->connect_errno) {
								printf("Connect failed: %s\n", $mysqli->connect_error);
								exit();
							}
							
							if (isset($_GET['pokeid'])) {
								echo $_GET['pokeid'];
							} else { echo "pokemon id not found.";}

							$pokeid = 405;
							$query1 = "SELECT poke_name, poke_type1, poke_type2, abil_name1, abil_name2, abil1.abil_text AS abil_text1, abil2.abil_text AS abil_text2, location, pokedexText FROM `pokemon`,(SELECT abil_text FROM `abilities`, `pokemon` WHERE national_id=" . $pokeid . " AND abil_name1=abil_name)abil1, 
(SELECT abil_text FROM `abilities`, `pokemon` WHERE national_id=" . $pokeid . " AND abil_name2=abil_name)abil2 WHERE national_id =" . $pokeid;
							if ($result1 = $mysqli->query($query1)) {
								/* fetch associative array */
								if ($row = $result1->fetch_assoc()) {
									printf ("<h1 style='margin: 0;'>");
									printf ($row["poke_name"]);
									echo "</h1></div><div style='background-color: #c7e8ac;'><img src='diamond-pearl/405.png' width='160' height='160'></div><div style='background-color: #c1e4f7; padding-top: 10px; padding-bottom: 10px;'><div class='infobox'><div class='infohead'>Types</div>";
									printf ($row["poke_type1"]);
									if (!empty($row["poke_type2"])){printf("        " . $row["poke_type2"]);}
									echo "</div><div class='infobox'><div class='infohead'>Pokedex Entry</div><div class='infotext'>";
									printf ($row["pokedexText"]);
									echo "</div></div>";
									echo "<div class='infobox'><div class='infohead'>Locations</div><div class='infotext'>" . $row["location"] . "</div></div>";
									
									echo "<div class='infobox'><div class='infohead'>Abilities</div><div class='infotext'>";
									echo "<span>" . $row["abil_name1"] . "</span>: ";
									echo $row["abil_text1"] . "</div>";
									if (!empty($row["abil_name2"])){
										printf("<div class='infotext'><span>" . $row["abil_name2"] . "</span>: " . $row["abil_text2"] . "</div>");}
									
									
									
									
								}
								/* free result set */
								$result1->free();
							}
							/* close connection */
							$mysqli->close();
						?>
					</div>
				</div>

				
				
			</div>
		    <div class='half' style='background-color: #3aa6dd;'>
				<div id='table_shell'>
					<table id='fixed_table'>
						<thead>
							<tr>
								<th>Move</th>
								<th>Power</th>
								<th>Description</th>
							</tr>
						</thead>
					</table>
					<table id='scroll_table'>
						<tbody>
							<tr>
								<td>Tackle</td><td>35</td><td>Level:—</td>
							</tr>
							<tr>
								<td>Leer</td><td>0</td><td>Level:—</td>
							</tr>
							<tr>
								<td>Charge</td><td>0</td><td>Level:—</td>
							</tr>
							<tr>
								<td>Leer</td><td>0</td><td>Level:5</td>
							</tr>
							<tr>
								<td>Charge</td><td>0</td><td>Level:9</td>
							</tr>
							<tr>
								<td>Bite</td><td>60</td><td>Level:60</td>
							</tr>
							<tr>
								<td>Spark</td><td>65</td><td>Level:65</td>
							</tr>
							<tr>
								<td>Roar</td><td>0</td><td>Level:0</td>
							</tr>
							<tr>
								<td>Swagger</td><td>0</td><td>Level:28</td>
							</tr>
							<tr>
								<td>Crunch</td><td>80</td><td>Level:80</td>
							</tr>
							<tr>
								<td>Thunder Fang</td><td>65</td><td>Level:42</td>
							</tr>
							<tr>
								<td>Scary Face</td><td>0</td><td>Level:49</td>
							</tr>
							<tr>
								<td>Discharge</td><td>80</td><td>Level:56</td>
							</tr>
							<tr>
								<td>Roar</td><td>0</td><td>TM05</td>
							</tr>
							<tr>
								<td>Ice Fang</td><td>65</td><td>Egg Move</td>
							</tr>
							<tr>
								<td>Fire Fang</td><td>65</td><td>Egg Move</td>
							</tr>
							<tr>
								<td>Thunder Fang</td><td>65</td><td>Egg Move</td>
							</tr>
							<tr>
								<td>Quick Attack</td><td>35</td><td>Egg Move</td>
							</tr>
							<tr>
								<td>Howl</td><td>35</td><td>Egg Move</td>
							</tr>
							<tr>
								<td>Take Down</td><td>90</td><td>Egg Move</td>
							</tr>
						</tbody>
					</table>
				</div>
				
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
    </body>
</html>
