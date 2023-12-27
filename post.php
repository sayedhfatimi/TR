<?php
	include ("connect.php");
	$postcontent = $_POST['postcontent'];
	$posttimestamp = date("g:i a");
	$username = $_COOKIE['ID_my_site'];
	mysql_select_db($mysql_database, $connect);
	$sql = "INSERT INTO posts (postuser, postcontent, posttimestamp) VALUES ('$username', '$postcontent', '$posttimestamp')";
	mysql_query($sql,$connect);
	mysql_close($connect);
	header('Location: index.php');
?>