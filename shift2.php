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

	$id = get_post('date');
	$query = "SELECT DATE_FORMAT(date, '%a, %b %e, %Y') FROM days WHERE id='$id'";
	$result = mysql_query($query);
	
	if (!$result) die ("Database access failed: " . mysql_error());
	
	$row = mysql_fetch_row($result);
	echo $row[0] . ":<br />";
	
	if (isset($_POST['time']) && (isset($_POST['location']))) {
		$time = get_post('time');
		$location = get_post('location');
		echo ("Inserted $time at $location<br />");
		$query = "INSERT INTO shifts(time, location, day) VALUES('$time', '$location', '$id');";
		
		if (!mysql_query ($query, $db_server))
			echo "INSERT failed: $query <br />" . mysql_error() . "<br />";
	}
	?>
<br />
<form action="shift2.php" method="post">
	Start and end time: <input type="text" name="time" /><br />
	Location: <input type="text" name="location" /><br />
	<?php
	echo "<input type='hidden' name='date' value='$id' />";
	?>
	<input type="submit" />
	</form>
	<br /><br />
	<b><u>Current shifts:</u></b><br /><br />
	
	<?php
	$query = "SELECT * FROM shifts WHERE day = '$id'";
	$result = mysql_query($query);
	
	if (!$result) die ("Database access failed: " . mysql_error());
	
	$rows = mysql_num_rows($result);
	
	for ($j = 0; $j < $rows; ++$j)
	{
		$row = mysql_fetch_row($result);
		echo $row[1] . " at " . $row[2] . "<br />";
	}
	
	function get_post($var) { return mysql_real_escape_string($_POST[$var]); }
	?>




<br />
<br />

</td></tr></table></body></html>