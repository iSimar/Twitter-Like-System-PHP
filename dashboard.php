<?php
	if($user_id){
		include "connect.php";
		$query = mysql_query("SELECT username, followers, following, tweets
                              FROM users 
                              WHERE id='$user_id'
                             ");
		mysql_close($conn);
		$row = mysql_fetch_assoc($query);
		$username = $row['username'];
		$tweets = $row['tweets'];
		$followers = $row['followers'];
		$following = $row['following'];
		echo "
		<h6><a href='logout.php' style='float:right;'>Logout</a></h6>
		<table>
			<tr>
				<td>
					<img src='./default.jpg' style='width:35px;'alt='display picture'/>
				</td>
				<td valign='top' style='padding-left:8px;'>
					<h6><a href='./$username'>@$username</a></h6>
					<h6 font=2 style='margin-top:-10px;'>Tweets: <a href='#'>$tweets</a> | Followers: <a href='#'>$followers</a> | Following: <a href='#'>$following</a></h6>
				</td>
			</tr>
		</table>
		<form action='tweet.php' method='POST'>
			<textarea class='form-control' placeholder='Type your tweet here' name='tweet'></textarea>
			<button type='submit' style='float:right;margin-top:3px;' class='btn btn-info btn-xs'>Tweet</button>
		</form>
		<br>
		<hr>
		";
		include "connect.php";
		$following_query = mysql_query("SELECT user2_id
                              			FROM following 
                              			WHERE user1_id='$user_id'
                             			");
		$tweets = mysql_query("SELECT user_id, tweet
							   FROM tweets
							   WHERE user_id = $user_id
							   ORDER BY timestamp
							   DESC LIMIT 5, 10
							  ");
		if($tweets === FALSE) {
   			die(mysql_error()); // TODO: better error handling
		}
		while($tweet = mysql_fetch_array($tweets)){
			echo $tweet['tweet']."<br>";
		}
	}
?>
<div class="jumbotron" style="padding:3px;">
	<div class="container">
		<h5>Made by <a href="http://simarsingh.ca">Simar</a></h5>  
		<h5>This is Open Source - Fork it on <i class="fa fa-github"></i> <a href="#">GitHub</a></h5>
	</div>
</div>