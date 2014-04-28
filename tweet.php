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
		mysql_query("INSERT INTO tweets(user_id, tweet, timestamp) 
				     VALUES ('$user_id', '$tweet', $timestamp)
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