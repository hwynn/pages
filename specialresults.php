<!DOCTYPE html>
<html>
    <head>
		<title>Pokémon Planner</title>
		<meta charset="utf-8" />
		<meta name="author" content="Harrison E. Wynn">
		<link rel='stylesheet' href='commonstyle.css'>
		<link rel='stylesheet' href='bigresulttable.css'>
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
			<?php
				//https://people.eecs.ku.edu/~h701w409/eecs647/standardsearch.php?
				
				$nameclause = "";
				$typeclause = "";
				//check if name variable exists and is valid.
				//It must be
				//1. Present in URL
				//2. non empty
				//3. name must filter to a valid result
				if (isset($_GET['name']))
				{
					if(!empty($_GET['name']))
					{
						if(strlen($_GET['name'])<12)
						{
							$nameclause = "(poke_name like '%".$_GET['name']."%')";
						}
						//else{echo "name variable is invalid<br>";}
					}
					//else{echo "the name variable is empty<br>";}
				}
				//else{echo "the name variable is missing from URL";}

				//check if type variables both exist and are valid.
				//both must be
				//1. present in URL
				//2. non empty
				//3. filter to valid string. No further checking required.
				$tarr1 = array('na', 'bug', 'dark', 'dragon', 'electric', 'fight', 'fire', 'flying', 'ghost', 'grass', 'ground', 'ice', 'normal', 'poison', 'psychic', 'rock', 'steel', 'water');
				$tarr2 = array('na', 'none', 'bug', 'dark', 'dragon', 'electric', 'fight', 'fire', 'flying', 'ghost', 'grass', 'ground', 'ice', 'normal', 'poison', 'psychic', 'rock', 'steel', 'water');
				if (isset($_GET['stype1']) and isset($_GET['stype2']))
				{
					if(!empty($_GET['stype1']) and !empty($_GET['stype2']))
					{
						if(in_array($_GET['stype1'], $tarr1) and in_array($_GET['stype2'], $tarr2))
						{
							//is a first type even given? if not, we won't worry about types at all.
							if($_GET['stype1']!=='na')
							{
								//is second type na? if so, we can be lenient with this search
								if($_GET['stype2']=='na')
								{$typeclause = "(poke_type1='".$_GET['stype1']."' OR poke_type2='".$_GET['stype1']."')";}
								//is second type none? if so, we must be strict
								elseif($_GET['stype2']=='none')
								{$typeclause = "(poke_type1='".$_GET['stype1']."' AND poke_type2 IS NULL)";}
								//we must be searching for two types
								else
								{$typeclause = "((poke_type1='".$_GET['stype1']."' OR poke_type1='".$_GET['stype2']."') AND (poke_type2='".$_GET['stype1']."' OR poke_type2='".$_GET['stype2']."'))";}
							}
						}
						//else{echo "type variables are invalid<br>";}
					}
					//else{echo "one of the type variables is empty<br>";}
				}
				//else{echo "a type variable is missing from URL";}
				
				include 'secret.php';
				$mysqli = new mysqli($host, $user, $password, $database);
				/* check connection */
				if ($mysqli->connect_errno) 
				{
					printf("Connect failed: %s\n", $mysqli->connect_error);
					exit();
				}
				
				
				if( isset($_GET['specialsearchtype']))
				{
				if ($_GET['specialsearchtype']=='rareabil' or $_GET['specialsearchtype']=='powmoves' or $_GET['specialsearchtype']=='onehit')
				{
					if($_GET['specialsearchtype']=='rareabil')
					{
						//$fullquery = "SELECT `national_id`, `poke_name`, `poke_type1`, `poke_type2`, `abil_name1`, `abil_name2` FROM `pokemon`";
						$fullquery = "SELECT p.national_id, p.poke_name, a.abil_name AS ability, abcount, poke_type1, poke_type2
						FROM (pokemon p
						INNER JOIN abilities a ON p.abil_name1 = a.abil_name
						OR p.abil_name2 = a.abil_name),
						(SELECT abil_name, COUNT(*) AS abcount
						FROM pokemon p
						INNER JOIN abilities x ON p.abil_name1 = abil_name
						OR p.abil_name2 = abil_name
						GROUP BY abil_name) r
						WHERE r.abil_name = a.abil_name ";
						if (!empty($nameclause) and !empty($typeclause))
						{$fullquery = $fullquery . " AND " . $nameclause . " AND " . $typeclause;}
						elseif(empty($nameclause) and empty($typeclause))
						{;}
						else//one clause should be empty, so we concat both together
						{$fullquery = $fullquery . " AND " . $nameclause . $typeclause;}
						$fullquery = $fullquery . " ORDER BY abcount ASC, national_id ASC;";
						echo $fullquery;
						
						
						echo "<div id='table_shell'><table id='fixed_table'>
						<thead>
							<tr>
								<th>ID</th>
								<th>Name</th>
								<th>Type1</th>
								<th>Type2</th>
								<th>Ability</th>
								<th>Rarity</th>
							</tr>
						</thead>
						</table><table id='scroll_table'><tbody>";
						
						//$fullquery = "SELECT `national_id`, `poke_name`, `poke_type1`, `poke_type2`, `abil_name1`, `abil_name2` FROM `pokemon`";
						if ($result = $mysqli->query($fullquery)) {
							/* fetch associative array */
							while($row = $result->fetch_assoc()) 
							{
								echo "<tr>";
								echo "<td>".$row["national_id"]."</td>";
								echo "<td>";
								echo "<a href='".$pokeurl.$row['national_id']."'>";
								echo $row["poke_name"];
								echo "</a>";
								echo "</td>";
								echo "<td>".$row["poke_type1"]."</td>";
								echo "<td>".$row["poke_type2"]."</td>";
								echo "<td>".$row["ability"]."</td>";
								echo "<td>".$row["abcount"]."</td>";
								echo "</tr>";
							}
							/* free result set */
							$result->free();
						}
						echo "</tbody></table></div>";
					}
					elseif($_GET['specialsearchtype']=='powmoves')
					{
						$fullquery = "SELECT p.national_id, COUNT(*) as movecount, p.poke_name, `poke_type1`, `poke_type2`, `abil_name1`, `abil_name2`
						FROM allmoves a
						INNER JOIN moves m ON m.move_name = a.move_name
						INNER JOIN pokemon p ON a.national_id = p.national_id
						WHERE (power >=100) ";
						if (!empty($nameclause) and !empty($typeclause))
						{$fullquery = $fullquery . " AND " . $nameclause . " AND " . $typeclause;}
						elseif(empty($nameclause) and empty($typeclause))
						{;}
						else//one clause should be empty, so we concat both together
						{$fullquery = $fullquery . " AND " . $nameclause . $typeclause;}
						echo $nameclause . '<br>';
						echo $typeclause . '<br>';
						$fullquery = $fullquery . " GROUP BY p.national_id";
						
						echo "<div id='table_shell'><table id='fixed_table'>
						<thead>
							<tr>
								<th>Powerful Moves</th>
								<th>Name</th>
								<th>Type1</th>
								<th>Type2</th>
								<th>Ability1</th>
								<th>Ability2</th>
							</tr>
						</thead>
						</table><table id='scroll_table'><tbody>";
						
						//$fullquery = "SELECT `movecount`, `poke_name`, `poke_type1`, `poke_type2`, `abil_name1`, `abil_name2` FROM `pokemon`";
						if ($result = $mysqli->query($fullquery)) {
							/* fetch associative array */
							while($row = $result->fetch_assoc()) 
							{
								echo "<tr>";
								echo "<td>".$row["movecount"]."</td>";
								echo "<td>";
								echo "<a href='".$pokeurl.$row['national_id']."'>";
								echo $row["poke_name"];
								echo "</a>";
								echo "</td>";
								echo "<td>".$row["poke_type1"]."</td>";
								echo "<td>".$row["poke_type2"]."</td>";
								echo "<td>".$row["abil_name1"]."</td>";
								echo "<td>".$row["abil_name2"]."</td>";
								echo "</tr>";
							}
							/* free result set */
							$result->free();
						}
						echo "</tbody></table></div>";
					}
					else
					{
						$fullquery = "SELECT DISTINCT p.national_id, p.poke_name, poke_type1, poke_type2, abil_name1, abil_name2
						FROM pokemon p
						INNER JOIN allmoves a ON a.national_id = p.national_id
						WHERE (a.move_name='Fissure' OR a.move_name='Guillotine' OR a.move_name='Horn Drill' OR a.move_name='Sheer Cold')";
									
						
						if (!empty($nameclause) and !empty($typeclause))
						{$fullquery = $fullquery . " AND " . $nameclause . " AND " . $typeclause . ";";}
						elseif(empty($nameclause) and empty($typeclause))
						{$fullquery = $fullquery . ";";}
						else//one clause should be empty, so we concat both together
						{$fullquery = $fullquery . " AND " . $nameclause . $typeclause . ";";}
						
						echo "<div id='table_shell'><table id='fixed_table'>
						<thead>
							<tr>
								<th>ID</th>
								<th>Name</th>
								<th>Type1</th>
								<th>Type2</th>
								<th>Ability1</th>
								<th>Ability2</th>
							</tr>
						</thead>
						</table><table id='scroll_table'><tbody>";
						
						//$fullquery = "SELECT `national_id`, `poke_name`, `poke_type1`, `poke_type2`, `abil_name1`, `abil_name2` FROM `pokemon`";
						if ($result = $mysqli->query($fullquery)) {
							/* fetch associative array */
							while($row = $result->fetch_assoc()) 
							{
								echo "<tr>";
								echo "<td>".$row["national_id"]."</td>";
								echo "<td>";
								echo "<a href='".$pokeurl.$row['national_id']."'>";
								echo $row["poke_name"];
								echo "</a>";
								echo "</td>";
								echo "<td>".$row["poke_type1"]."</td>";
								echo "<td>".$row["poke_type2"]."</td>";
								echo "<td>".$row["abil_name1"]."</td>";
								echo "<td>".$row["abil_name2"]."</td>";
								echo "</tr>";
							}
							/* free result set */
							$result->free();
						}
						echo "</tbody></table></div>";
					}
				}
				}
				
				
				/* close connection */
				$mysqli->close();
			?>
		</div>
    </body>
</html>
