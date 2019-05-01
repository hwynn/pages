<!DOCTYPE html>
<html>
    <head>
        <meta charset='utf-8'>
		<link rel='stylesheet' href='showstyle.css'>
		<link rel='stylesheet' href='extrastyles2.css'>
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
						$f_egg1 = "xxxx";
						$f_egg2 = "yyyy";
						
						$query1 = "SELECT `egg_group1`, `egg_group2` FROM `pokemon` WHERE `national_id`=" . $_GET['pokeid'];
						$query2 = "";
						if($result1 = $mysqli->query($query1))
						{
							if ($trow = $result1->fetch_assoc()) 
							{
								$f_egg1 = $trow["egg_group1"];
								$f_egg2 = $trow["egg_group2"];
							}
							/* free result set */
							$result1->free();
						}
						else
						{ echo "We don't know what egg groups are";}
						echo $f_egg1 . '<br>';
						echo $f_egg2 . '<br>';
						
						if(is_null($f_egg1))
						{
							echo "sorry. This pokemon cannot breed";
						}
						else
						{
							if(is_null($f_egg2))
							{
								echo "this pokemon does not have a second egg group";
								$query2 = "SELECT `poke_name`, `national_id`, `egg_group1`, `egg_group2` FROM `pokemon` WHERE `national_id`<>" . $_GET['pokeid'] . 
								" AND (`egg_group2`= \"" . $f_egg1 . 
								"\" OR  `egg_group1` = \"" . $f_egg1 . "\")";
							}
							else
							{
								$query2 = "SELECT `poke_name`, `national_id`, `egg_group1`, `egg_group2` FROM `pokemon` WHERE `national_id`<>" . $_GET['pokeid'] . 
								" AND (`egg_group2`= \"" . $f_egg1 . 
								"\" OR  `egg_group1` = \"" . $f_egg1 . 
								"\" OR  `egg_group2` = \"" . $f_egg2 . 
								"\" OR  `egg_group1` = \"" . $f_egg2 . "\")";
							}
							echo '<br>' . $query2;
							
							
							
							
							if($result2 = $mysqli->query($query2))
							{
								while($row = $result2->fetch_assoc())
								{
									printf ("<br><tr><td>%s</td><td>%s</td><td>%s</td></tr>", $row["poke_name"], $row["national_id"], $row["national_id"]);
								}
								/* free result set */
								$result1->free();
							}
							

							
							
							
							
						}
						/* close connection */
						$mysqli->close();	
					} else { echo "pokemon id not found.";}
				?>
				<div class="pokebox">
					<img src="diamond-pearl/328.png" >
					<p>Trapinch</p>
				</div>
				<div class="romancebox">
					<span>Slash</span>
					<br>
					<div class="pokebox">
						<img src="diamond-pearl/328.png" >
						<p>Trapinch</p>
					</div>
					<div class="plusbox">+</div>
					<div class="pokebox">
						<img src="diamond-pearl/328.png" >
						<p>Trapinch</p>
					</div>
				</div>
				<div class='romancebox'>
					<span>Slash</span>
					<br>
					<div class='pokebox'>
						<a href='https://people.eecs.ku.edu/~h701w409/eecs647/show.php?pokeid=328'>
							<img src="diamond-pearl/328.png" >
						</a>
						<p>Trapinch</p>
					</div>
					<div class="plusbox">+</div>
					<div class="pokebox">
						<img src="diamond-pearl/328.png" >
						<p>Trapinch</p>
					</div>
				</div>
			</div>

		</div>

    </body>
</html>
