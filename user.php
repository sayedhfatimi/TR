<?php
	session_start();
	include("connect.php");
	mysql_select_db($mysql_database, $connect);
		if(isset($_COOKIE['ID_my_site'])) {
		$ID = $_GET['ID'];
		$user = $_GET['user'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $user ?></title>
<link href="css/stylesheet.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery.js"></script>
</head>
<body>
<div id="maincontainer">
<div id="navbarcontainer">
<img src="images/logo.png" alt="logo" border="0" />
<div id="navbar">
<?php if(isset($_COOKIE['ID_my_site'])) { ?>
<a href="index.php"><div class="button">Home</div></a>
<a href="logout.php"><div class="button">Logout</div></a>
<a href="user.php?user=<?php echo $_COOKIE['ID_my_site'];?>"><div class="button">Profile</div></a>
<div class="button">Report an Issue</div>
<?php } else { ?>
<a href="index.php"><div class="button">Home</div></a>
<a href="login.php"><div class="button">Login</div></a>
<a href="register.php"><div class="button">Register</div></a>
<div class="button">Report an Issue</div>
<?php } ?>
</div>
</div>
<div id="contentcontainer">
<?php
	$result = mysql_query("SELECT * FROM members WHERE userID='$ID' OR username='$user'");
	while($row = mysql_fetch_array($result)) {
?>
<table width="100%" border="0" cellspacing="5" cellpadding="0">
<tr>
<td colspan="2" align="center">
<?php if($_COOKIE['ID_my_site']==$row['username']) { ?>
<a href="pimage.php"><img class="userimage" src="<?=$row['pimage'];?>" /></a>
<?php } else { ?>
<img class="userimage" src="<?=$row['pimage'];?>" />
<?php } ?>
</td>
</tr>
<td>Username:</td>
<td align="right"><?=$row['username'];?></td>
</tr>
<tr>
<td>Forename:</td>
<td align="right"><?=$row['forename'];?></td>
</tr>
<td>Surname:</td>
<td align="right"><?=$row['surname'];?></td>
</tr>
<tr>
<td>Email Address:</td>
<td align="right"><?=$row['email'];?></td>
</tr>
<tr>
</table>
<?php } ?>
</div>
<div class="clear"></div>
</div>
<div id="footercontainer"><div id="footer">Copyright &copy; 2009 - 2010 Limited4. All Rights Reserved.</div></div>
</body>
</html>
<?php
	mysql_close($connect);
	} else {
		mysql_close($connect);
		header("Location: login.php");
	}
?>