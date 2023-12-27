<?php
	session_start();
	include("connect.php");
	mysql_select_db($mysql_database, $connect);
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
	$result = mysql_query("SELECT * FROM posts,members WHERE posts.postuser=members.username ORDER BY postID DESC");
	if(isset($_COOKIE['ID_my_site'])) {
?>
<div id="contentpostformcontainer">
<form action="post.php" method="post">
<input class="postcontentfield" name="postcontent" type="text" />
<input class="submitbutton" name="submit" type="submit" value="Post!" />
</form>
</div>
<?php while($row = mysql_fetch_array($result)) { if($_COOKIE['ID_my_site']==$row['postuser']) { $postIDget = $row['postID']; ?>
<div class="post">
<form action="deletepost.php" method="post"><input name="postID" type="hidden" value="<?=$postIDget;?>" /><input name="deletepost" type="submit" class="delete" value="" /></form>
<a href="user.php?user=<?=$row['postuser'];?>"><img src="<?=$row['pimage'];?>" width="50" height="50" border="0" align="middle" /></a>
<div class="postcontent"><?=$row['postcontent'];?></div>
<div class="clear"></div>
<div class="posttimestamp">by&nbsp;<a href="user.php?user=<?=$row['postuser'];?>"><b><?=$row['postuser'];?></b></a>&nbsp;@&nbsp;<?=$row['posttimestamp'];?> </div>
</div>
<?php } else { ?>
<div class="post">
<a href="user.php?user=<?=$row['postuser'];?>"><img src="<?=$row['pimage'];?>" width="50" height="50" border="0" align="middle" /></a>
<div class="postcontent"><?=$row['postcontent'];?></div>
<div class="clear"></div>
<div class="posttimestamp">by&nbsp;<a href="user.php?user=<?=$row['postuser'];?>"><b><?=$row['postuser'];?></b></a>&nbsp;@&nbsp;<?=$row['posttimestamp'];?></div>
</div>
<?php } } } else { while($row = mysql_fetch_array($result)) { ?>
<div class="post">
<a href="user.php?user=<?=$row['postuser'];?>"><img src="<?=$row['pimage'];?>" width="50" height="50" border="0" align="middle" /></a>
<div class="postcontent"><?=$row['postcontent'];?></div>
<div class="clear"></div>
<div class="posttimestamp">by&nbsp;<a href="user.php?user=<?=$row['postuser'];?>"><b><?=$row['postuser'];?></b></a>&nbsp;@&nbsp;<?=$row['posttimestamp'];?></div>
</div>
<?php } } ?>
</div>
<div class="clear"></div>
</div>
<div id="footercontainer"><div id="footer">Copyright &copy; 2009 - 2010 Limited4. All Rights Reserved.</div></div>
</body>
</html>
<?php mysql_close($connect); ?>