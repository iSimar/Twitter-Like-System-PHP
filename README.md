Twitter-Like-System-PHP
=======================

A simple twitter clone using PHP and a MySQL database.

<b>Try out the <a href="http://simarsingh.com/twitter-php">Demo</a> for Twitter-Like-System-PHP</b>

<img src="http://i62.tinypic.com/2lu8gsl.png"/>


Setup 
-----------
1) Create a new database in MySQL - recommended <br>
2) Run the following SQL code to create the tables in the database

```
CREATE TABLE users(
    id int NOT NULL AUTO_INCREMENT,
    username varchar(15) NOT NULL,
    password varchar(32) NOT NULL,
    followers int DEFAULT 0,
    following int DEFAULT 0,
    tweets int DEFAULT 0,
    PRIMARY KEY (id)
);

CREATE TABLE following(
    id int NOT NULL AUTO_INCREMENT,
    user1_id int REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    user2_id int REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    PRIMARY KEY (id)
);

CREATE TABLE tweets(
    id int NOT NULL AUTO_INCREMENT,
    username varchar(15) NOT NULL,
    user_id int REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
    tweet varchar(140) NOT NULL,
    timestamp bigint(20) NOT NULL,
    PRIMARY KEY (id)
);
```
3) Open `connect.php` and edit the database information. The following three setting variables are required in order to establish a connection with the database.

```
$dbuser	= "USERNAME"; //Username that is allowed to access the database
$dbpass	= "PASSWORD"; //Password
$dbname	= "NAME-OF-THE-DATABASE"; //Name of the database
```


