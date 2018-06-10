<?php
	if ( !isset($_SESSION["is_logged"]))
	{
		header("Location: index.php");
	}
	else
	{
		if ( !$_SESSION["admin"])
		{
			header("Location: index.php");
		}
	}
?>