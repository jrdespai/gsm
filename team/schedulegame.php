<!DOCTYPE html>

<?php

	//Verify session, get DB info, add HTML page header, and add navbar
	include('../validate_session_sub.php');
	include('../connect.php');
	include('../header_sub.php');
	include('../navbar_sub.php');
	include('../functions/functions.php');
	
	//Add teams to confirmQueue
	$sqlResult = runQuery("INSERT INTO confirmQueue (team1, team2, time, location) VALUES ('" . $_GET['tid'] . "', " . $_SESSION['teamId'] . ", '" . $_POST['time'] . "', '" . $_POST['location'] . "');", $conn);

	//Send an update Email
	
	//Delete the team to be played from the gameQueue table
	$sqlResult = runQuery("DELETE FROM gameQueue WHERE teamID = '" . $_GET['tid'] . "';", $conn);
		
	//Insert a record into the message table
	$sqlResult = runQuery("INSERT INTO message (body, teamId) VALUES ('<tr><td>" . mysqli_real_escape_string($conn, getTeamName($_SESSION['teamId'], $conn)) . " Has challenged you to play!</td><td><button class=\"btn msgbtn\"><a href=\"schedule.php?t1=" . $_GET['tid'] . "&t2=" . $_SESSION['teamId'] . "&msid=%msid%\">Accept Challenge</a></button></td></tr>', '" . $_GET['tid'] . "')", $conn);
	mysqli_close($conn);
	
?>
	
	<body>
		<p>Your request has been sent to play Team #: 
			<?php
				echo $_GET['tid'];
			?>
		</p>
	</body>

</html>