<!DOCTYPE html>
<html>
    <head>
		<meta charset="utf-8" />
		<link rel='stylesheet' href='showstyle.css'>
		<link rel='stylesheet' href='movetable.css'>
    </head>
	<body>
		<header>
			<!--Not supported in internet explorer 8 or below-->
			<div class='topbuttonrow'>
				<nav>
					<a href='/~h701w409/eecs647/home.html'>Home</a>
					<a href='/~h701w409/eecs647/specialsearch.php'>Special Search</a>
					<a href='/~h701w409/eecs647/standardsearch.php'>Standard Search</a>
					<a href='/~h701w409/eecs647/team.php'>Your Team</a>
				</nav>
			</div>
		</header>
		<table>
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
		
		
		
		
    </body>
</html>