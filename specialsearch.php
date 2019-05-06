<!DOCTYPE html>
<html>
    <head>
		<meta charset="utf-8" />
		<link rel='stylesheet' href='showstyle.css'>
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
		<form>
			<input type="text" name="name">
			
			<input type="radio" name="namesearchtype" value="full" checked> This is the full name
			<input type="radio" name="namesearchtype" value="partial"> Name contains this
			<br>
			<!--type colors found from: http://www.epidemicjohto.com/t882-type-colors-hex-colors-->
			<select name='stype1'>
				<option value='na' selected>n/a</option>
				<option value='bug' style='background-color: #A6B91A;'>bug</option>
				<option value='dark' style='background-color: #705746;'>dark</option>
				<option value='dragon' style='background-color: #6F35FC;'>dragon</option>
				<option value='electric' style='background-color: #F7D02C;'>electric</option>
				<option value='fight' style='background-color: #C22E28;'>fight</option>
				<option value='fire' style='background-color: #EE8130;'>fire</option>
				<option value='flying' style='background-color: #A98FF3;'>flying</option>
				<option value='ghost' style='background-color: #735797;'>ghost</option>
				<option value='grass' style='background-color: #7AC74C;'>grass</option>
				<option value='ground' style='background-color: #E2BF65;'>ground</option>
				<option value='ice' style='background-color: #96D9D6;'>ice</option>
				<option value='normal' style='background-color: #A8A77A;'>normal</option>
				<option value='poison' style='background-color: #A33EA1;'>poison</option>
				<option value='psychic' style='background-color: #F95587;'>psychic</option>
				<option value='rock' style='background-color: #B6A136;'>rock</option>
				<option value='steel' style='background-color: #B7B7CE;'>steel</option>
				<option value='water' style='background-color: #6390F0;'>water</option>
			</select>
			<select name='stype2'>
				<option value='na' selected>n/a</option>
				<option value='none'>no second type</option>
				<option value='bug' style='background-color: #A6B91A;'>bug</option>
				<option value='dark' style='background-color: #705746;'>dark</option>
				<option value='dragon' style='background-color: #6F35FC;'>dragon</option>
				<option value='electric' style='background-color: #F7D02C;'>electric</option>
				<option value='fight' style='background-color: #C22E28;'>fight</option>
				<option value='fire' style='background-color: #EE8130;'>fire</option>
				<option value='flying' style='background-color: #A98FF3;'>flying</option>
				<option value='ghost' style='background-color: #735797;'>ghost</option>
				<option value='grass' style='background-color: #7AC74C;'>grass</option>
				<option value='ground' style='background-color: #E2BF65;'>ground</option>
				<option value='ice' style='background-color: #96D9D6;'>ice</option>
				<option value='normal' style='background-color: #A8A77A;'>normal</option>
				<option value='poison' style='background-color: #A33EA1;'>poison</option>
				<option value='psychic' style='background-color: #F95587;'>psychic</option>
				<option value='rock' style='background-color: #B6A136;'>rock</option>
				<option value='steel' style='background-color: #B7B7CE;'>steel</option>
				<option value='water' style='background-color: #6390F0;'>water</option>
			</select>
			
			
			<br>
			<input type="submit" value='Search'/>
		</form>
		<br>
		<br>
		<?php
		//https://people.eecs.ku.edu/~h701w409/eecs647/standardsearch.php?
			if (isset($_GET['name'])) 
			{
				echo "name:<br>";
				var_dump($_GET['name']);
				echo "<br>";
			} else{echo "No Name found<br>";}
			if (isset($_GET['namesearchtype'])) 
			{
				echo "namesearchtype:<br>";
				var_dump($_GET['namesearchtype']);
				echo "<br>";
			} else{echo "No namesearchtype found<br>";}
			if (isset($_GET['stype1'])) 
			{
				echo "stype1:<br>";
				var_dump($_GET['stype1']);
				echo "<br>";
			} else{echo "No stype1 found<br>";}
			if (isset($_GET['stype2'])) 
			{
				echo "stype2:<br>";
				var_dump($_GET['stype2']);
				echo "<br>";
			} else{echo "No stype2 found<br>";}
			echo "<br><br><br>";
			$fullquery = "SELECT `national_id`, `poke_name`, `poke_type1`, `poke_type2`, `abil_name1`, `abil_name2` FROM `pokemon`";
			$nameclause = "";
			$typeclause = "";
			//check if name variables both exist and are valid.
			//They must both be
			//1. Present in URL
			//2. non empty
			//3. name must filter to a valid result and namesearchtype must be 'full' or 'partial'
			if (isset($_GET['name']) and isset($_GET['namesearchtype']))
			{
				echo "both name variables exist<br>";
				if(!empty($_GET['name']) and !empty($_GET['namesearchtype']))
				{
					echo "both name variables are nonempty<br>";
					if(strlen($_GET['name'])<12 and ($_GET['namesearchtype']=='full' or $_GET['namesearchtype']=='partial'))
					{
						echo "name variables are valid. Yay!<br>";
						if($_GET['namesearchtype']=='full')
						{$nameclause = "(poke_name= '".$_GET['name']."')";}
						else
						{$nameclause = "(poke_name like '%".$_GET['name']."%')";}
						echo "Name Query:" . $nameclause;
						
					}
					else{echo "name variables are invalid<br>";}
				}
				else{echo "one of the name variables is empty<br>";}
			}
			else{echo "a name variable is missing from URL";}
			echo "<br><br>";
			//check if type variables both exist and are valid.
			//both must be
			//1. present in URL
			//2. non empty
			//3. filter to valid string. No further checking required.
			$tarr1 = array('na', 'bug', 'dark', 'dragon', 'electric', 'fight', 'fire', 'flying', 'ghost', 'grass', 'ground', 'ice', 'normal', 'poison', 'psychic', 'rock', 'steel', 'water');
			$tarr2 = array('na', 'none', 'bug', 'dark', 'dragon', 'electric', 'fight', 'fire', 'flying', 'ghost', 'grass', 'ground', 'ice', 'normal', 'poison', 'psychic', 'rock', 'steel', 'water');
			if (isset($_GET['stype1']) and isset($_GET['stype2']))
			{
				echo "both type variables exist<br>";
				if(!empty($_GET['stype1']) and !empty($_GET['stype2']))
				{
					echo "both type variables are nonempty<br>";
					if(in_array($_GET['stype1'], $tarr1) and in_array($_GET['stype2'], $tarr2))
					{
						echo "type variables are valid. Yay!<br>";
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
						echo "Type Query:" . $typeclause;
					}
					else{echo "type variables are invalid<br>";}
				}
				else{echo "one of the type variables is empty<br>";}
			}
			else{echo "a type variable is missing from URL";}
			echo "<br><br>";
			if (!empty($nameclause) and !empty($typeclause))
			{$fullquery = $fullquery . " WHERE " . $nameclause . " AND " . $typeclause . ";";}
			elseif(empty($nameclause) and empty($typeclause))
			{$fullquery = $fullquery . ";";}
			else//one clause should be empty, so we concat both together
			{$fullquery = $fullquery . " WHERE " . $nameclause . $typeclause . ";";}
			echo "Full Query:" . $fullquery;
		?>
		

    </body>
</html>