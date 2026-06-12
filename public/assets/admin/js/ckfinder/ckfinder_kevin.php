<?php
	session_start();
	if(!isset($_SESSION['loggedin']) || !$_SESSION['loggedin']){
		echo "<META HTTP-EQUIV='refresh' CONTENT='0; URL=/'>";
		exit();
	}
?>

<!DOCTYPE html>
<!--
Copyright (c) 2007-2019, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or https://ckeditor.com/sales/license/ckfinder
-->
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no">
	<title>File Browser - kevin109</title>
</head>
<body>

<script src="ckfinder.js"></script>
<script>
	CKFinder.start();
</script>

</body>
</html>

