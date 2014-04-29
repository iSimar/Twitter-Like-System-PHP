<?php 
session_start();
$user_id = $_SESSION['user_id'];
?>
<?php
if($user_id){
	if($_POST['tweet']!=""){
		$tweet = htmlentities($_POST['tweet']);
		$timestamp = time();
		include 'connect.php';
		$query = mysql_query("SELECT username
					 		  FROM users 
				     		  WHERE id ='$user_id'
				    		");
		$row = mysql_fetch_assoc($query);
		$username = $row['username'];
		mysql_query("INSERT INTO tweets(username, user_id, tweet, timestamp) 
				     VALUES ('$username', '$user_id', '$tweet', $timestamp)
				    ");
		mysql_query("UPDATE users
					 SET tweets = tweets + 1
					 WHERE id='$user_id'
					");
		mysql_close($conn);
		header("Location: .");
	}
}
?>
