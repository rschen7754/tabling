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
	error_reporting(E_ALL);
	ini_set('display_errors', '1');
	$db_server = mysql_connect($db_hostname, $db_username, $db_password);
	
	if (!db_server) die ("Unable to connect to MySQL: " . mysql_error());
	
	mysql_select_db($db_database, $db_server) or die ("Unable to select database: " . mysql_error());

	$id = get_post('date');
	$query = "SELECT DATE_FORMAT(date, '%a, %b %e, %Y') FROM days WHERE id='$id'";
	$result = mysql_query($query);
	
	if (!$result) die ("Database access failed: " . mysql_error());
	
	$row = mysql_fetch_row($result);
	echo $row[0] . ":<br />";
	

	$query2 = "SELECT DISTINCT leaders.id FROM leaders, signups, shifts, days WHERE days.id=$id AND days.id=shifts.day AND signups.leader = leaders.id AND signups.shift = shifts.id;";
	$result2 = mysql_query($query2);
	
	if (!$result2) die ("Database access failed: " . mysql_error());
	
	$rows2 = mysql_num_rows($result2);
	
	for ($j = 0; $j < $rows2; ++$j)
	{
		$row2 = mysql_fetch_row($result2);
		//get shifts and then send the text
		$query3 = "SELECT shifts.time, shifts.location, shifts.id FROM signups, days, shifts WHERE signups.leader='$row2[0]' AND days.id=$id AND days.id=shifts.day AND shifts.id = signups.shift ORDER BY shifts.id";
		$result3 = mysql_query($query3);
	
		if (!$result3) die ("Database access failed: " . mysql_error());
	
		$rows3 = mysql_num_rows($result3);
	
		$query5 = "SELECT leaders.cell, providers.address FROM leaders, providers WHERE leaders.id='$row2[0]' AND leaders.provider=providers.id";
		$result5 = mysql_query($query5);
	
		$row6 = mysql_fetch_row($result5);
		$to = $row6[0] . "@" . $row6[1];
		$message = "Tabling reminder:\n";
		if (!$result5) die ("Database access failed: " . mysql_error());
		$location = "hi";
		for ($j2 = 0; $j2 < $rows3; ++$j2)
		{
			$row7 = mysql_fetch_row($result3);
			if ($location != $row7[1]) {
				$message .= "$row7[1]:\n";
				$location = $row7[1];
			}
			$message .= "$row7[0]";
			$message .= "\n";
		}
		$subject = "";
		$message .= "Text 7602134595 if questions.";
		$from = "7602134595@vtext.com";
		$headers = "From:" . $from;
		while (strlen($message) > 140) {
			$message1 = substr($message, 0, 141);
			$message = substr($message, 141);
			mail ($to, $subject, $message1, $headers);
		}
		mail($to,$subject,$message,$headers);
		echo "A text has been sent to $to.";
	}
	?>
<br />
	Your texts have been sent.
	
	<?php

	function get_post($var) { return mysql_real_escape_string($_POST[$var]); }
	?>




<br />
<br />

</td></tr></table></body></html>