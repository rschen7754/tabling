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
<a href="leader2.php">Add leader</a><br />
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

	if (isset($_POST['first']) && isset($_POST['last']) && (isset($_POST['email'])) && (isset($_POST['cell'])) && (isset($_POST['provider'])) && (isset($_POST['team']))) {
		$first = get_post('first');
		$last = get_post('last');
		$email = get_post('email');
		$cell = get_post('cell');
		$provider = get_post('provider');
		$team = get_post('team');
		echo ("Inserted $first $last<br />");
		$query = "INSERT INTO leaders(first, last, email, cell, provider, team)" . 
			" VALUES('$first', '$last', '$email', '$cell', '$provider', '$team');";
		
		if (!mysql_query ($query, $db_server))
			echo "INSERT failed: $query <br />" . mysql_error() . "<br />";
	}
	?>

<form action="leader.php" method="post">
	First Name: <input type="text" name="first" /><br />
	Last Name: <input type="text" name="last" /><br />
	Email: <input type="text" name="email" /><br />
	Cell (do not add punctuation): <input type="text" name="cell" /><br />
	Carrier: <select name="provider">
	<?php
	$query = "SELECT * FROM providers";
	$result = mysql_query($query);
	
	if (!$result) die ("Database access failed: " . mysql_error());
	
	$rows = mysql_num_rows($result);
	
	for ($j = 0; $j < $rows; ++$j)
	{
		$row = mysql_fetch_row($result);
		echo "<option value='$row[0]'>" . $row[1] . "</option><br />";
	}
	?>
	</select><br />
	Teams: <select name="team">
	<?php
	$query = "SELECT * FROM teams";
	$result = mysql_query($query);
	
	if (!$result) die ("Database access failed: " . mysql_error());
	
	$rows = mysql_num_rows($result);
	
	for ($j = 0; $j < $rows; ++$j)
	{
		$row = mysql_fetch_row($result);
		echo "<option value='$row[0]'>" . $row[1] . "</option><br />";
	}
	?>
	</select><br />
	<input type="submit" />
	</form>
	<br /><br />
	<b><u>Current leaders:</u></b><br /><br />
	
	<?php
	$query = "SELECT * FROM leaders ORDER BY last";
	$result = mysql_query($query);
	
	if (!$result) die ("Database access failed: " . mysql_error());
	
	$rows = mysql_num_rows($result);
	
	for ($j = 0; $j < $rows; ++$j)
	{
		$row = mysql_fetch_row($result);
		echo $row[1] . " " . $row[2] . "<br />";
	}
	
	function get_post($var) { return mysql_real_escape_string($_POST[$var]); }
	?>




<br />
<br />

</td></tr></table></body></html>