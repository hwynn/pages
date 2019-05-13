<!DOCTYPE html>
<html>
    <head>
        <meta charset='utf-8'>
		<link rel='stylesheet' href='navbarstyle.css'>
		<link rel='stylesheet' href='showstyle.css'>
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

			.topinfo
			{
				font-size: 20px;
				width: 100%;
				text-align: center;
			}

			.pokebox
			{
				background-color: #ffeca9;
				margin-left: auto;
				margin-right: auto;
				width: 200px;
				text-align: center;
				font-size: 12px;
			}

			.pokebox img
			{
				height: 160px;
				width: 160px;
			}

			.pokebox img, p
			{
				margin-left: auto;
				margin-right: auto;
				margin-top: 0px;
				margin-bottom: 0px;
			}

			.romancebox
			{
				margin: 10px;
				padding: 0;
				height: 230px;
				width: 430px;
			}
			.plusbox 
			{padding-top: 75px;
			font-weight: bold;
			font-size: 40px;}

			.romancebox .pokebox, .plusbox
			{
				float: left;
				margin: 0;
			}
			.romancebox span
			{margin-left:40px;
			font-weight: bold;}

			.topinfo span
			{
				margin-left: auto;
				margin-right: auto;
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
					<a href='/~h701w409/eecs647/team.php'>Your Team</a>
				</nav>
			</div>
		</header>
        <div class='centercolumn'>
		    <div class='topinfo' style='background-color: #ffbbb1;'>	
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
						$f_egg1 = "xxxx";
						$f_egg2 = "yyyy";
						$f_pokemon = "missingno";
						
						
						$f_breedquery = "";
						$f_eggmovequery = "";
						$f_fullquery="";
						
						
						$query1 = "SELECT `poke_name`, `egg_group1`, `egg_group2` FROM `pokemon` WHERE `national_id`=" . $_GET['pokeid'];
						$query2 = "";
						if($result1 = $mysqli->query($query1))
						{
							if ($trow = $result1->fetch_assoc())
							{
								$f_egg1 = $trow["egg_group1"];
								$f_egg2 = $trow["egg_group2"];
								$f_pokemon = $trow["poke_name"];	
								echo "<div class='pokebox'>";
								echo "<img src='diamond-pearl/" . $_GET['pokeid'] . ".png'>";
								echo "<p>" . $f_pokemon . "</p>";
								echo "</div>";
							}
							/* free result set */
							$result1->free();
						}
						else
						{ 
							echo "We don't know what the egg groups are";
							exit();
						}
						if(is_null($f_egg1))
						{
							echo "<span>sorry. This pokemon cannot breed</span>";
							exit();
						}
						else
						{
							if(is_null($f_egg2))
							{
								$f_breedquery = "(SELECT `poke_name`, `national_id`, `egg_group1`, `egg_group2` FROM `pokemon` WHERE `national_id`<>" . $_GET['pokeid'] . 
								" AND (`egg_group2`= \"" . $f_egg1 . 
								"\" OR  `egg_group1` = \"" . $f_egg1 . "\"))breedable, ";
							}
							else
							{
								$f_breedquery = "(SELECT `poke_name`, `national_id`, `egg_group1`, `egg_group2` FROM `pokemon` WHERE `national_id`<>" . $_GET['pokeid'] . 
								" AND (`egg_group2`= \"" . $f_egg1 . 
								"\" OR  `egg_group1` = \"" . $f_egg1 . 
								"\" OR  `egg_group2` = \"" . $f_egg2 . 
								"\" OR  `egg_group1` = \"" . $f_egg2 . "\"))breedable, ";
							}
							
							$f_eggmovequery = "(SELECT `move_name`, `learn_method` FROM `learn` WHERE (learn_method='Egg Move' OR learn_method like 'Pre-Evolution Move: #% at ') AND national_id=". $_GET['pokeid'] .")eggmoves, ";
							
							$f_fullquery = "SELECT eggmoves.move_name, breedable.national_id, breedable.poke_name FROM " . $f_breedquery . $f_eggmovequery . "`allmoves` WHERE eggmoves.move_name=allmoves.move_name AND breedable.national_id=allmoves.national_id ORDER BY move_name";
							
							//echo $f_fullquery;
							if($result2 = $mysqli->query($f_fullquery))
							{
								while($row = $result2->fetch_assoc())
								{
									echo "<div class='romancebox'>";
									echo "<span>".$row['move_name']."</span>";
									echo "<br>";
									echo "<div class='pokebox'>";
									echo "<a href='".$pokeurl. $_GET['pokeid'] . "'>";
									echo "<img src='diamond-pearl/" . $_GET['pokeid'] . ".png'>";
									echo "</a>";
									echo "<p>" . $f_pokemon . "</p>";
									echo "</div>";
									echo "<div class='plusbox'>+</div>";
									echo "<div class='pokebox'>";
									echo "<a href='".$pokeurl. $row["national_id"] . "'>";
									echo "<img src='diamond-pearl/" . $row["national_id"] . ".png'>";
									echo "</a>";
									echo "<p>" . $row["poke_name"] . "</p>";
									echo "</div>";
									echo "</div>";
								}
								/* free result set */
								$result1->free();
							}
						}
						/* close connection */
						$mysqli->close();	
					} else { echo "pokemon id not found.";}
				?>
			</div>
		</div>
    </body>
</html>
