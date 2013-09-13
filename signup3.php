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
	$leaderid = get_post('leader');
	$query = "SELECT first,last FROM leaders WHERE id='$leaderid'";
	$result = mysql_query($query);
	
	if (!$result) die ("Database access failed: " . mysql_error());
	

	$row = mysql_fetch_row($result);
	
	
	$leadername = $row[0] . " " . $row[1];
	
	$query = "SELECT shift FROM signups WHERE leader='$leaderid'";
	$result2 = mysql_query($query);
	
	if (!$result2) die ("Database access failed: " . mysql_error());
	
	$rows2 = mysql_num_rows($result2);
	
	for ($j = 0; $j < $rows2; ++$j)
	{
		$oldsignups[] = mysql_fetch_row($result2);
	}
	
	$newsignups = $_POST['signup'];
	
	if ($newsignups) {
		foreach ($newsignups as $newsignup) {
			$flag = 0;
		
			if ($oldsignups) {
				reset($oldsignups);
				foreach ($oldsignups as $oldsignup) {
					if ($oldsignup[0] == $newsignup) {
						$flag = 1;
						break;
					}
				}
			}
			if (!$flag) {
				// go ahead and add it to the database
				$query3 = "INSERT INTO signups (leader, shift) VALUES ('$leaderid', '$newsignup');";
				$result = mysql_query($query3);
	
				if (!$result) die ("Database access failed: " . mysql_error());
	
				// and then add it to oldsignups
				//$oldsignups[] = array(0,0,$newsignup);
		}
	}
	
	
		reset($newsignups);
	}
	
	foreach ($oldsignups as $oldsignup) {
		$flag = 0;
		reset($newsignups);
		if ($newsignups) {
			foreach ($newsignups as $newsignup) {
				if ($oldsignup[0] == $newsignup) {
					$flag = 1;
					break;
				}
			}
		}
		if (!$flag) {
			// go ahead and remove it from the database
			$query4 = "DELETE FROM signups WHERE leader='$leaderid' AND shift='$oldsignup[0]';";
			$result = mysql_query($query4);
	
			if (!$result) die ("Database access failed: " . mysql_error());
	
		}
	}
	
					$query5 = "SELECT first, last, email FROM leaders WHERE id='$leaderid'";
				$result6 = mysql_query($query5);
	
				if (!$result6) die ("Database access failed: " . mysql_error());
				$row = mysql_fetch_row($result6);
	$to = $row[2];
	$subject = "Upper Room Tabling Signups Confirmation";
	$message = "Hello $row[0] $row[1]. You are signed up to table:\n";
	$query6 = "SELECT DATE_FORMAT(days.date, '%a, %b %e, %Y'), shifts.time, shifts.location, shifts.id FROM days, shifts, signups WHERE days.active='1' AND signups.shift = shifts.id AND signups.leader='$leaderid' AND shifts.day = days.id ORDER BY days.date, shifts.id;";
				$result7 = mysql_query($query6);
	
				if (!$result7) die ("Database access failed: " . mysql_error());
				$rows = mysql_num_rows($result7);
					for ($j = 0; $j < $rows; ++$j)
					{
				$row = mysql_fetch_row($result7);
				$message .= "$row[0] $row[1] $row[2] \n";
			}
	
	$from = "rschen7754@gmail.com";
	$headers = "From:" . $from;
	mail($to,$subject,wordwrap($message),$headers);
	echo "An email has been sent to $to.";
	?>

	
	Thank you.
	<br /><br />

	
	<?php
	function get_post($var) { return mysql_real_escape_string($_POST[$var]); }
	?>




<br />
<br />

</td></tr></table></body></html>