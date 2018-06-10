<?php
	require_once("lib/connection.php");
	if ( isset($_SESSION["is_logged"]))
	{
		session_destroy();
		header("Location: login.php");
	}
	else
	{
		header("Locaion: index.php");
	}
?>