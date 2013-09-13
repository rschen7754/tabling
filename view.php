<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head><title>Rschen7754</title>
<meta name="keywords" content="freeway exit lists, Washington freeways, California freeways, Oregon freeways, exit lists, Rschen7754, road photos" />
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta name="description" content="Rschen7754's collection of freeway exit lists and his own web page." />
</head>
	<body>
<table border="0">
<tr><td id="top" colspan="2">
</td>
</tr>
<tr><td id="left">
<a href="index.htm">Home</a>
<br /><br />
<a href="signup.php">Sign up for tabling</a><br />
<a href="view.php">View tabling schedule</a><br />
</td>
<td id="body">
<div id="bodydiv">
	<?php
	require_once 'login.php';
	//error_reporting(E_ALL);
	//ini_set('display_errors', '1');
	$db_server = mysql_connect($db_hostname, $db_username, $db_password);
	
	if (!db_server) die ("Unable to connect to MySQL: " . mysql_error());
	
	mysql_select_db($db_database, $db_server) or die ("Unable to select database: " . mysql_error());
	
	$query = "SELECT id, DATE_FORMAT(date, '%a, %b %e, %Y') FROM days WHERE active=1 ORDER BY date;";
	$result = mysql_query($query);
	
	if (!$result) die ("Database access failed: " . mysql_error());
	$rows = mysql_num_rows($result);
	
	for ($j = 0; $j < $rows; ++$j)
	{
		
		$row = mysql_fetch_row($result);
		$id2 = $row[0];
		echo "<b><u>$row[1]</u></b><br />";
		$query2 = "SELECT * FROM shifts WHERE day = '$id2' ORDER BY id";
		$result2 = mysql_query($query2);
	
		if (!$result2) die ("Database access failed: " . mysql_error());
	
		$rows2 = mysql_num_rows($result2);
		
		for ($j2 = 0; $j2 < $rows2; ++$j2)
		{
			$counter = 0;
			$row2 = mysql_fetch_row($result2);
			echo "<b>" . $row2[1] . " at " . $row2[2] . "</b><br />";
			$query3 = "SELECT leaders.first, leaders.last FROM signups, leaders WHERE signups.shift = '$row2[0]' AND signups.leader=leaders.id";
			$result3 = mysql_query($query3);
	
			if (!$result3) die ("Database access failed: " . mysql_error());
	
			$rows3 = mysql_num_rows($result3);
			echo "<table border='1'>";
			echo "<tr>";
			for ($j3 = 0; $j3 < $rows3; ++$j3)
			{
				if (($counter%4 == 0) && ($counter >2)) {
					echo "</tr><tr>";
				}
				$row3 = mysql_fetch_row($result3);
				echo "<td>$row3[0] $row3[1]</td>\n";

				$counter++;
			}
			echo "</tr>";
			echo "</table>";
		}
		
	}

	$row = mysql_fetch_row($result);
	
	?>

	
	<?php
	function get_post($var) { return mysql_real_escape_string($_POST[$var]); }
	?>




<br />
<br />

</td></tr></table></body></html>