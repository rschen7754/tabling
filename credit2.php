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
	$id = get_post('leader');
	$query = "SELECT first,last FROM leaders WHERE id='$id'";
	$result = mysql_query($query);
	
	if (!$result) die ("Database access failed: " . mysql_error());
	

	$row = mysql_fetch_row($result);
	echo "Welcome $row[0] $row[1]<br />";
	
	?>

<form action="credit3.php" method="post">
Check the box for each time you want to sign up for. <br />
	<?php
	echo "<input type='hidden' name='leader' value='$id' />";
	
	$query5 = "SELECT shifts.id FROM days, shifts, signups WHERE days.active=1 AND signups.shift = shifts.id AND signups.leader=$id AND shifts.day = days.id;";
	$result3 = mysql_query($query5);
	if (!$result3) die ("Database access failed: " . mysql_error());
	$rows = mysql_num_rows($result3);
	
	for ($j = 0; $j < $rows; ++$j)
	{
		$row = mysql_fetch_row($result3);
		$oldsignups[] = $row[0];
	}
	
	$query = "SELECT id, DATE_FORMAT(date, '%a, %b %e, %Y') FROM days WHERE active=1";
	$result = mysql_query($query);
	
	if (!$result) die ("Database access failed: " . mysql_error());
	
	$rows = mysql_num_rows($result);
	
	for ($j = 0; $j < $rows; ++$j)
	{
		echo "<table>";
		$row = mysql_fetch_row($result);
		$id2 = $row[0];
		echo "<b><u>$row[1]</u></b><br />";
		$query2 = "SELECT * FROM shifts WHERE day = '$id2'";
		$result2 = mysql_query($query2);
	
		if (!$result2) die ("Database access failed: " . mysql_error());
	
		$rows2 = mysql_num_rows($result2);
	
		for ($j2 = 0; $j2 < $rows2; ++$j2)
		{
			
			$row2 = mysql_fetch_row($result2);
			$flag = 0;
			if ($oldsignups) {
				foreach ($oldsignups as $oldsignup) {
					if ($oldsignup == $row2[0])
						$flag = 1;
				}
				reset($oldsignups);
			}
			$querya = "SELECT COUNT(*) FROM signups WHERE shift=$row2[0]";
			$resulta = mysql_query($querya);
			if (!$resulta) die ("Database access failed: " . mysql_error());
			$rowa = mysql_fetch_row($resulta);
			$count = $rowa[0];
			$bgcolor = "";
			if ($count < 4)
				$bgcolor = " bgcolor='orange'";
			//if checked
			if ($flag == 1)
			echo "<tr><td$bgcolor><label><input type='checkbox' name='signup[]' value='$row2[0]' checked='checked' />" . $row2[1] . " at " . $row2[2] . " ($count)</label></td></tr>";
			else
			echo "<tr><td$bgcolor><label><input type='checkbox' name='signup[]' value='$row2[0]' />" . $row2[1] . " at " . $row2[2] . " ($count)</label></td></tr>";
		}
		echo "</table>";
	}
	?>
	<br /><br />
	<input type="submit" />
	</form>
	<br /><br />

	
	<?php
	function get_post($var) { return mysql_real_escape_string($_POST[$var]); }
	?>




<br />
<br />

</td></tr></table></body></html>