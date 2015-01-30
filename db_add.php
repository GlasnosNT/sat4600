<?php
	
	// DB connection info
	
	mysql_connect('mysql3.000webhost.com','a3239416_admin','lolfaggot1') or die(mysql_error());
	mysql_select_db('a3239416_members') or die(mysql_error());
 
	// Applying form fields from add-member.html to fields to be inserted into the db
	
	$Alias = $_POST['username'];
 
	$SteamID = $_POST['SteamID'];
 
	$Location = $_POST['Location'];
 
	// Actual db query
	
	$query = "INSERT INTO mc_members(`Alias`, `SteamID`, `Location`) VALUES ('$Alias','$SteamID','$Location')";
	
	// Put result of query into "$result"
	$result = mysql_query($query);
	
	
	if ($result)
		{
			echo "Successfully added user information to database. Welcome aboard. Press the backspace button on your browser to leave this page.";
		}
	
	// If unsuccessful, give error
		else
		{
			die('Error: '.mysql_error($con));
		}
?>