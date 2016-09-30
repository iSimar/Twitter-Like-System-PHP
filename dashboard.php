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
		<br>
		";
		include "connect.php";
		$tweets = mysql_query("SELECT username, tweet, timestamp
							   FROM tweets
							   WHERE user_id = $user_id OR (user_id IN (SELECT user2_id FROM following WHERE user1_id='$user_id'))
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
			$new_tweet = preg_replace('/@(\\w+)/','<a href=./$1>$0</a>',$tweet['tweet']);
			$new_tweet = preg_replace('/#(\\w+)/','<a href=./hashtag/$1>$0</a>',$new_tweet);
			echo "<div style='font-size:10px; margin-top:-3px;'>".$new_tweet."</div>";
			echo "</td>";
			echo "</tr>";
			echo "</table>";
			echo "</div>";
		}
		mysql_close($conn);
	}
?>
<div class="jumbotron" style="padding:3px;">
	<div class="container">
		<h5>Made by <a href="http://simarsingh.com">Simar</a></h5>
		<h5>This is Open Source - Fork it on <i class="fa fa-github"></i> <a href="https://github.com/iSimar/Twitter-Like-System-PHP">GitHub</a></h5>
	</div>
</div>
