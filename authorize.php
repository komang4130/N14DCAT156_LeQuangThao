<?php
include("header.php");
include("lib/permission.php");
require_once("functions.php");


header('Content-Type: text/html; charset=utf-8');

$authUrl = getAuthorizationUrl("", "");
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Google Drive Login and Upload</title>
	<meta charset="UTF-8">
</head>
<body>

<center>Sign in and choose you drive to upload. <a href=<?php echo "'" . $authUrl . "'" ?>>Authorize</a></center>

</body>
</html>