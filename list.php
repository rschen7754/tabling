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
<a href="admin.htm">Admin Home</a>
<br /><br />
<a href="carrier.php">Add carrier</a><br />
<a href="day.php">Add day</a><br />
<a href="shift.php">Add shift</a><br />
<a href="unshift.php">Cancel shift</a><br />
<a href="leader.php">Add leader</a><br />
<br /><a href="text.php">Send texts</a><br />
<a href="archive.php">Archive day</a><br />
<a href="unarchive.php">Unarchive day</a><br />
<a href="credit.php">Credit leader</a><br />
<br /><a href="list.php">Who is tabling?</a><br />
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

	?>


	
	<?php
	$query = "SELECT * FROM leaders ORDER BY last, first";
	$result = mysql_query($query);
	
	if (!$result) die ("Database access failed: " . mysql_error());
	
	$rows = mysql_num_rows($result);
	
	for ($j = 0; $j < $rows; ++$j)
	{
		$row = mysql_fetch_row($result);
		echo "<b><u>" . $row[1] . " " . $row[2] . "</u></b><br />\n<ul>";
		$query2 = "select shifts.time, shifts.location, DATE_FORMAT(days.date, '%a, %b %e, %Y'), shifts.id from signups, shifts, days where signups.leader=$row[0] and signups.shift = shifts.id and shifts.day=days.id and days.active=1 ORDER BY days.date, shifts.id;";
		$result2 = mysql_query($query2);
	
		if (!$result2) die ("Database access failed: " . mysql_error());
	
		$rows2 = mysql_num_rows($result2);
	
		for ($j2 = 0; $j2 < $rows2; ++$j2)
		{
			$row2 = mysql_fetch_row($result2);
			echo "<li>$row2[2]: $row2[0] at $row2[1]</li>";
		}
		echo "</ul>";
	}
	
	function get_post($var) { return mysql_real_escape_string($_POST[$var]); }
	?>




<br />
<br />

</td></tr></table></body></html>