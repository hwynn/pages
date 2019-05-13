<!DOCTYPE html>
<html>
    <head>
		<meta charset="utf-8" />
		<link rel='stylesheet' href='commonstyle.css'>
		<link rel='stylesheet' href='searchform.css'>
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
		
			<form action="/~h701w409/eecs647/standardresults.php">
			
			<div class='middlebox'>
				<div class='rowbox'>
				<h2>Pokemon Search</h2>
				</div>
				<div class='rowbox'>
				<h4>Name</h4>
				</div>
				<div class='rowbox'>
				<input type="text" name="name">
				</div>
				<div class='rowbox'>
				<input type="radio" name="namesearchtype" value="full" checked> This is the full name
				<input type="radio" name="namesearchtype" value="partial"> Name contains this
				</div>
				<div class='rowbox'>
				<h4>Type(s)</h4>
				</div>
				<div class='rowbox'>
				<!--type colors found from: http://www.epidemicjohto.com/t882-type-colors-hex-colors-->
				</div>
				<div class='rowbox'>
				<span style='font-size: x-small;'>right dropdown box only works if left box has a type selected</span>
				</div>
				<div class='rowbox'>
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
				</div>
				<div class='rowbox'>
				<input type="submit" value='Search'/>
				</div>
			</div>
			
			</form>
    </body>
</html>