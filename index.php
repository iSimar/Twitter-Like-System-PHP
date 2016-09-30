<?php
session_start();
$user_id = $_SESSION['user_id'];
?>
<?php
if($_POST['login-btn']=="login-submit"){
  if($_POST['username']!="" && $_POST['password']!=""){
    $username = strtolower($_POST['username']);
    include "connect.php";
    $query = mysql_query("SELECT id, password
                          FROM users
                          WHERE username='$username'
                          ");
    mysql_close($conn);
    if(mysql_num_rows($query)>=1){
      $password = md5($_POST['password']);
      $row = mysql_fetch_assoc($query);
      if($password==$row['password']){
        $_SESSION['user_id']=$row['id'];
        header('Location: .');
        exit;
      }
      else{
        $error_msg = "Incorrect username or password";
      }
    }
    else{
      $error_msg = "Incorrect username or password";
    }
  }
  else{
    $error_msg = "All fields must be filled out";
  }
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=425px, user-scalable=no">

  <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap-theme.min.css">
  <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
  <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js"></script>

  <title>Twitter-like-system-PHP</title>
</head>
<body style="margin-left:20px;width:300px;zoom:125%;">
  <h3>Twitter-Like-System-PHP</h3>
  <?php
  if($user_id){
    include "dashboard.php";
    exit;
  }
  ?>
  <form role="form" action="index.php" method="POST" style="width:300px;">
    <div class="input-group" style="margin-bottom:10px;">
      <span class="input-group-addon">@</span>
      <input type="text" class="form-control" placeholder="Username" name="username">
    </div>
    <input type="password" style="margin-bottom:10px;" class="form-control" placeholder="Password" name="password">
    <?php
    if($error_msg){
        echo "<div class='alert alert-danger'>".$error_msg."</div>";
    }
    ?>
    <div class="btn-group">
      <a href="register.php" style="width:150px;" class="btn btn-success">Register</a>
      <button type="submit" style="width:150px;" class="btn btn-info" name="login-btn" value="login-submit">Log In</button>
    </div>
  </form>
  <br>
  <div class="jumbotron" style="padding:3px;">
    <div class="container">
      <h5>Made by <a href="http://simarsingh.com">Simar</a></h5>
      <h5>This is Open Source - Fork it on <i class="fa fa-github"></i> <a href="https://github.com/iSimar/Twitter-Like-System-PHP">GitHub</a></h5>
    </div>
  </div>
</body>
</html>
