<?php
// We need to use sessions, so you should always start sessions using the below code.
session_start();
require_once 'database.php';
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// retrieve the user data from the database
$db = new DatabaseClass();
$user = $db->getUserById($_SESSION['user_id']);
$username = $user['username'];
$password = $user['password'];
$email = $user['email'];
?>


<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Profile Page</title>
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
			<h2>Profile Page</h2>
			<div>
				<p>Your account details are below:</p>
				<table>
					<tr>
						<td>Username:</td>
						<td><?= $username ?></td>
					</tr>
					<tr>
						<td>Password:</td>
						<td><?= $password ?></td>
					</tr>
					<tr>
						<td>Email:</td>
						<td><?= $email ?></td>
					</tr>
				</table>
			</div>
		</div>
	</body>
</html>