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
<body style="margin-left:20px;width:300px;zoom:125%;">
	<h3>Twitter-Like-System-PHP</h3>
	<a href='.'>Go Home</a>
	<?php
	function getTime($t_time){
		$pt = time() - $t_time;
		if ($pt>=86400)
			$p = date("F j, Y",$t_time);
		elseif ($pt>=3600)
			$p = (floor($pt/3600))."h";
		elseif ($pt>=60)
			$p = (floor($pt/60))."m";
		else 
			$p = $pt."s";
		return $p;
	}
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
				echo "<a href='./register.php' class='btn btn-info btn-xs' style='float:right;'>Signup</a>";
			}
			echo "
			<table style='margin-bottom:5px;'>
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
			include "connect.php";
			$tweets = mysql_query("SELECT username, tweet, timestamp
				FROM tweets
				WHERE user_id = $id
				ORDER BY timestamp DESC
				LIMIT 0, 10
				");
			while($tweet = mysql_fetch_array($tweets)){
				echo "<div class='well well-sm' style='padding-top:4px;padding-bottom:8px; margin-bottom:8px; overflow:hidden;'>";
				echo "<div style='font-size:10px;float:right;'>".getTime($tweet['timestamp'])."</div>";
				echo "<table>";
				echo "<tr>";
				echo "<td valign=top style='padding-top:4px;'>";
				echo "<img src='./default.jpg' style='width:35px;'alt='display picture'/>";
				echo "</td>";;
				echo "<td style='padding-left:5px;word-wrap: break-word;' valign=top>";
				echo "<a style='font-size:12px;' href='./".$tweet['username']."'>@".$tweet['username']."</a>";
				echo "<div style='font-size:10px; margin-top:-3px;'>".$tweet['tweet']."</div>";
				echo "</td>";
				echo "</tr>";
				echo "</table>";
				echo "</div>";
			}
			mysql_close($conn);
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
			<h5>This is Open Source - Fork it on <i class="fa fa-github"></i> <a href="https://github.com/iSimar/Twitter-Like-System-PHP">GitHub</a></h5>
		</div>
	</div>
</body>
</html>
