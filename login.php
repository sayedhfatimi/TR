<?php
	session_start();
	include("connect.php");
	mysql_select_db($mysql_database, $connect);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
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
	if(isset($_COOKIE['ID_my_site'])) { 
		$username = $_COOKIE['ID_my_site']; 
		$pass = $_COOKIE['Key_my_site'];
		$check = mysql_query("SELECT * FROM members WHERE username = '$username'")or die(mysql_error());
		while($info = mysql_fetch_array($check)) {
			if ($pass != $info['password']) {} else { header("Location: index.php"); }
			}
		}
	if (isset($_POST['submit'])) {
		if(!$_POST['username'] | !$_POST['password']) { die('You did not fill in a required field.'); }
		if (!get_magic_quotes_gpc()) { $_POST['email'] = addslashes($_POST['email']); }
		$check = mysql_query("SELECT * FROM members WHERE username = '".$_POST['username']."'")or die(mysql_error());
		$check2 = mysql_num_rows($check);
		if ($check2 == 0) { die('That user does not exist in our database. <a href=register.php>Click Here to Register</a>'); }
		while($info = mysql_fetch_array( $check )) {
			$_POST['password'] = stripslashes($_POST['password']);
			$info['password'] = stripslashes($info['password']);
			$_POST['password'] = md5($_POST['password']);
			if ($_POST['password'] != $info['password']) { die('Incorrect password, please try again.'); }
			else {
				$_POST['username'] = stripslashes($_POST['username']);
				$hour = time() + 3600;
				setcookie(ID_my_site, $_POST['username'], $hour);
				setcookie(Key_my_site, $_POST['password'], $hour);
				header("Location: index.php");
				}
			}
		} else {	 
?> 
<div id="loginform">
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="login">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left" valign="middle">Username:</td>
    <td colspan="2" align="right" valign="middle"><input class="loginfield" name="username" type="text" maxlength="65" /></td>
    </tr>
  <tr>
    <td align="left" valign="middle">Password:</td>
    <td colspan="2" align="right" valign="middle"><input class="loginfield" name="password" type="password" maxlength="65" /></td>
    </tr>
    <tr>
    <td colspan="3"><input class="submitbutton" name="submit" type="submit" value="Login!" /></td>
    </tr>
</table>
</form>
</div>
<?php } ?>
</div>
<div class="clear"></div>
</div>
<div id="footercontainer"><div id="footer">Copyright &copy; 2009 - 2010 Limited4. All Rights Reserved.</div></div>
</body>
</html>
<?php mysql_close($connect); ?>