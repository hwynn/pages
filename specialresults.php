<!DOCTYPE html>
<html>
    <head>
		<meta charset="utf-8" />
		<link rel='stylesheet' href='navbarstyle.css'>
		<link rel='stylesheet' href='showstyle.css'>
		<link rel='stylesheet' href='extrastyles1.css'>
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
						/* free result set */
						$result->free();
					}
					echo "</tbody></table></div>";
					/* close connection */
					$mysqli->close();
				} else { echo "pokemon id not found.";}
			?>
		</div>
    </body>
</html>
