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

<form action="unarchive2.php" method="post">
	Select the date: <br />
	
	
	<?php
	$query = "SELECT id, DATE_FORMAT(date, '%a, %b %e, %Y') FROM days WHERE active=0;";
	$result = mysql_query($query);
	
	if (!$result) die ("Database access failed: " . mysql_error());
	
	$rows = mysql_num_rows($result);
	
	for ($j = 0; $j < $rows; ++$j)
	{
		$row = mysql_fetch_row($result);
		echo "<label><input type='radio' name='date' value='$row[0]' />" . $row[1] . "</label><br />";
	}
	
	function get_post($var) { return mysql_real_escape_string($_POST[$var]); }
	?>
<input type="submit" />
	</form>
<br /><br />


<br />
<br />

</td></tr></table></body></html>