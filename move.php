<!DOCTYPE html>
<html>
    <head>
		<meta charset="utf-8" />
		<link rel='stylesheet' href='commonstyle.css'>
		<link rel='stylesheet' href='movetable.css'>
		<link rel='stylesheet' href='smallmovetable.css'>
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
		<div class='half' style='background-color: #ffbbb1;'>	
		<table id='summarybox'>
			<tbody>
				<?php
					include 'secret.php';
					$mysqli = new mysqli($host, $user, $password, $database);
					/* check connection */
					if ($mysqli->connect_errno) {
						printf("Connect failed: %s\n", $mysqli->connect_error);
						exit();
					}
					if (isset($_GET['movename']))
					{

						$query1 = "SELECT * FROM `moves` WHERE move_name='". $_GET['movename']."'";
						if($result1 = $mysqli->query($query1))
						{
							if ($row = $result1->fetch_assoc())
							{
								echo"<tr>";
								echo"<th>Name</th>";
								echo"<td>".$row["move_name"]."</td>";
								echo"</tr>";
								echo"<tr>";
								echo"<th>Type</th>";
								echo"<td>".$row["move_type"]."</td>";
								echo"</tr>";
								echo"<tr>";
								echo"<th>Category</th>";
								echo"<td>".$row["category"]."</td>";
								echo"</tr>";
								echo"<tr>";
								echo"<th>Power</th>";
								echo"<td>".$row["power"]."</td>";
								echo"</tr>";
								echo"<tr>";
								echo"<th>Description</th>";
								echo"<td>".$row["move_text"]."</td>";
								echo"</tr>";
							}
							/* free result set */
							$result1->free();
						}
						else
						{ 
							echo "query error. Nothing found.";
							exit();
						}
					} else { echo "No move name found.";}
				?>
			</tbody>
		</table>
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
					if (isset($_GET['movename'])) 
					{
						//no filter added
						echo "<div id='table_shell'><table id='fixed_table'>
						<thead>
							<tr>
								<th>Pokemon</th>
								<th>ID</th>
								<th>Learn Method</th>
							</tr>
						</thead>
						</table><table id='scroll_table'><tbody>";
						
						$query = "SELECT poke_name, learn.national_id, learn_method 
						FROM pokemon p INNER JOIN learn ON learn.national_id = p.national_id 
						WHERE move_name ='". $_GET['movename']."'";
						if ($result = $mysqli->query($query)) {
							/* fetch associative array */
							while($row = $result->fetch_assoc()) {
								echo "<tr>";
								echo "<td>";
								echo "<a href='".$moveurl.$row['national_id']."'>";
								echo $row["poke_name"];
								echo "</a>";
								echo "</td>";
								echo "<td>";
								echo $row["national_id"];
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
					} else { echo "move name not found.";}
				?>
			</div>
		
		
		
		
    </body>
</html>