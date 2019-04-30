<!DOCTYPE html>
<html>
    <head>
        <meta charset='utf-8'>
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
					if (isset($_GET['pokeid']))
					{
						
						$c_breed = FALSE;//c_ is for conditional. This stores if the pokemon can breed
						
						$f_egg1 = "xxxx";
						$f_egg2 = "yyyy";
						
						$query1 = "SELECT `egg_group1`, `egg_group2` FROM `pokemon` WHERE `national_id`=" . $_GET['pokeid'];
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
							}
						}
						
						
						/* close connection */
						$mysqli->close();	
					} else { echo "pokemon id not found.";}
				?>
			</div>
		    <div class='half' style='background-color: #3aa6dd;'>

			</div>
		</div>

    </body>
</html>
