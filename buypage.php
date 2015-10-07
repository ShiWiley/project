<!DOCTYPE html>
<html>
<body>
	<head>
		<h1>This is a table from the db</h1>
		<style>
			table{
    			border: 1px solid black;
    			border-collapse: collapse;
    			width:100%;
			}
			td{
				border: 1px solid black;
			}
		</style>
	</head>
	<div>
	<span>
	<h2>General Supplies</h2>
	<table>
			<?php
			error_reporting(0);
			require_once("db_connect.php");
			
			$sql = "SELECT * FROM item";
			$result = mysql_query($sql) or die(mysql_error());
			echo("<table>");

			$row = mysql_fetch_array($result) or die(mysql_error());
			while($row = mysql_fetch_array($result)){ 
				if ($row['type'] == 0){ ?>
				<tr>
					<td align="center"> <?=$row['name']; ?> </td>
					<td align="center"> <?=$row['description']; ?> </td> 
					<td align="center"> <?=$row['qty']; ?> </td> 
					<td align="center"> <?=$row['price']; ?> </td>
					<td align="center"><input type="text" name=<?=$row['name'];?> placeholder="Enter Amount"></td>
				</tr>
			<?php }};
				mysql_free_result($result);
			?>
	</table>

	<h2>Craft Supplies</h2>
	<table>
		<?php
			error_reporting(0);
			require_once("db_connect.php");
			$sql = "SELECT * FROM item";
			$result = mysql_query($sql) or die(mysql_error());
			echo("<table>");

			$row = mysql_fetch_array($result) or die(mysql_error());
			while($row = mysql_fetch_array($result)){ 
				if ($row['type'] == 1){ ?>
				<tr>
					<td align="center"> <?=$row['name']; ?> </td>
					<td align="center"> <?=$row['description']; ?> </td> 
					<td align="center"> <?=$row['qty']; ?> </td> 
					<td align="center"> <?=$row['price']; ?> </td>
					<td align="center"><input type="text" name=<?=$row['name'];?> placeholder="Enter Amount"></td>
				</tr>
			<?php }};
				mysql_free_result($result);
			?>
	</table>
	</span>
	</div>
</body>
</html>