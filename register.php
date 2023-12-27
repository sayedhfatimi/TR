<?php
	session_start();
	include("connect.php");
	mysql_select_db($mysql_database, $connect);
	if(isset($_COOKIE['ID_my_site'])) { mysql_close($connect); header("Location: index.php"); } else {
?> 
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>HomePage</title>
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
	if (isset($_POST['submit'])) { 
		if (!$_POST['forename'] | !$_POST['surname'] | !$_POST['username'] | !$_POST['password'] | !$_POST['cpassword'] | !$_POST['email'] ) { die('You did not complete all of the required fields'); }
		if (!get_magic_quotes_gpc()) { $_POST['username'] = addslashes($_POST['username']); }
		$usercheck = $_POST['username'];
		$check = mysql_query("SELECT username FROM members WHERE username = '$usercheck'") or die(mysql_error());
		$check2 = mysql_num_rows($check);
		if ($check2 != 0) { die('Sorry, the username '.$_POST['username'].' is already in use.'); }
		if ($_POST['password'] != $_POST['cpassword']) { die('Your passwords did not match. '); }
		$_POST['password'] = md5($_POST['password']);
		if (!get_magic_quotes_gpc()) { $_POST['password'] = addslashes($_POST['password']); $_POST['username'] = addslashes($_POST['username']); $_POST['email'] = addslashes($_POST['email']); $_POST['forename'] = addslashes($_POST['forename']); $_POST['surname'] = addslashes($_POST['surname']); }
		$userID = md5(uniqid(rand()));
		$pimage = "./images/dpi.gif";
		$insert = "INSERT INTO members (userID, username, password, pimage, email, forename, surname) VALUES ('$userID','".$_POST['username']."', '".$_POST['password']."','$pimage','".$_POST['email']."','".$_POST['forename']."','".$_POST['surname']."')";
		$add_member = mysql_query($insert);
?>
<h1>Registered</h1>
<p>Thank you, you have registered - you may now login.</p>
<?php } else { ?>
<div id="loginform">
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="login">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="left" valign="middle">Forename:</td>
    <td colspan="2" align="right" valign="middle"><input class="loginfield" name="forename" type="text" maxlength="30" /></td>
  </tr>
  <tr>
    <td align="left" valign="middle">Surname:</td>
    <td colspan="2" align="right" valign="middle"><input class="loginfield" name="surname" type="text" maxlength="30" /></td>
  </tr>
  <tr>
    <td align="left" valign="middle">Username:</td>
    <td colspan="2" align="right" valign="middle"><input class="loginfield" name="username" type="text" maxlength="65" /></td>
    </tr>
  <tr>
    <td align="left" valign="middle">Password:</td>
    <td colspan="2" align="right" valign="middle"><input class="loginfield" name="password" type="password" maxlength="65" /></td>
    </tr>
  <tr>
    <td align="left" valign="middle">Again:</td>
    <td colspan="2" align="right" valign="middle"><input class="loginfield" name="cpassword" type="password" maxlength="65" /></td>
  </tr>
  <tr>
    <td align="left" valign="middle">Email:</td>
    <td colspan="2" align="right" valign="middle"><input class="loginfield" name="email" type="text" maxlength="120" /></td>
  </tr>
    <tr>
    <td colspan="3"><input class="submitbutton" name="submit" type="submit" value="Submit!" /></td>
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
<?php } mysql_close($connect); ?>