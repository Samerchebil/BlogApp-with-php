<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();
require_once 'database.php';
if (isset($_SESSION["user_username"])) {
	$user['username'] = $_SESSION["user_username"];
	session_write_close();
} else {
	// since the username is not set in session, the user is not-logged-in
	// he is trying to access this page unauthorized
	// so let's clear all session variables and redirect him to index
	session_unset();
	session_write_close();
	header('Location: login.php');
	exit;
	echo 'Welcome ' . $_SESSION['user_username'] . '!';
	header('Location: home.php');
}


?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title>Home Page</title>
	<link href="style.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer">
</head>

<body class="loggedin">
	<nav class="navtop">
		<div>
			<h1>Website Title</h1>
			<a href="profile.php"><i class="fas fa-user-circle"></i>Profile</a>
			<a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a>
		</div>
	</nav>
	<div class="content">
		<h2>Home Page</h2>
		<p>Welcome back, <?= $_SESSION['user_username'] ?>!</p>
		<p>C'est votre espace admin.</p>
		<a href="createUser.php">Add user</a> |
		<a href="#">Update user</a> |
		<a href="#">Delete user</a> |
		<a href="logout.php">Déconnexion</a>
		</ul>
	</div>
</body>

</html>