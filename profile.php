<?php 
session_start();
$user_id = $_SESSION['user_id'];
?>
<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=340px, user-scalable=no">

	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
	<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap-theme.min.css">
	<link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
	<script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>

	<title>Twitter-like-system-PHP</title>
</head>
<body style="margin-left:20px;width:300px;">
	<h3>Twitter-Like-System-PHP</h3>
	<a href='.'>Go Home</a>
	<?php
	if($_GET['username']){
		include 'connect.php';
		$username = strtolower($_GET['username']);
		$query = mysql_query("SELECT id, username, followers, following, tweets 
			FROM users 
			WHERE username='$username'
			");
		mysql_close($conn);
		if(mysql_num_rows($query)>=1){
			$row = mysql_fetch_assoc($query);
			$id = $row['id'];
			$username = $row['username'];
			$tweets = $row['tweets'];
			$followers = $row['followers'];
			$following = $row['following'];
			if($user_id){
				if($user_id!=$id){
					include 'connect.php';
					$query2 = mysql_query("SELECT id
										   FROM following 
										   WHERE user1_id='$user_id' AND user2_id='$id'
										  ");
					mysql_close($conn);
					if(mysql_num_rows($query2)>=1){
						echo "<a href='unfollow.php?userid=$id&username=$username' class='btn btn-default btn-xs' style='float:right;'>Unfollow</a>";
					}
					else{
						echo "<a href='follow.php?userid=$id&username=$username' class='btn btn-info btn-xs' style='float:right;'>Follow</a>";
					}
				}
			}
			else{
				echo "<a class='btn btn-info btn-xs' style='float:right;'>Signup</a>";
			}
			echo "
			<table>
				<tr>
					<td>
						<img src='./default.jpg' style='width:35px;'alt='display picture'/>
					</td>
					<td valign='top' style='padding-left:8px;'>
						<h6><a href='./$username'>@$username</a>";
			include 'connect.php';
			$query3 = mysql_query("SELECT id
								   FROM following 
								   WHERE user1_id='$id' AND user2_id='$user_id'
								  ");
			mysql_close($conn);
			if(mysql_num_rows($query3)>=1){
				echo " - <i>Follows You</i>";
			}
			echo												"</h6>
						<h6 style='width:300px;margin-top:-10px;'>Tweets: <a href='#'>$tweets</a> | Followers: <a href='#'>$followers</a> | Following: <a href='#'>$following</a></h6>
					</td>
				</tr>
			</table>
			";
		}
		else{
			echo "<div class='alert alert-danger'>Sorry, this profile doesn't exist.</div>";
			echo "<a href='.' style='width:300px;' class='btn btn-info'>Go Home</a>";
		}
	}
	?>
	<br>
	<div class="jumbotron" style="padding:3px;">
		<div class="container">
			<h5>Made by <a href="http://simarsingh.ca">Simar</a></h5>  
			<h5>This is Open Source - Fork it on <i class="fa fa-github"></i> <a href="#">GitHub</a></h5>
		</div>
	</div>
</body>
</html>