<?php
require_once 'database.php';

// create a new instance of the DatabaseClass
$db = new DatabaseClass();

// get the vote id from the URL parameter
if (isset($_GET['id'])) {
    $id = $_GET['id'];
} else {
    // redirect to error page if vote id is not provided
    header('Location: createVote.php');
    exit();
}

// call the readVote method of the DatabaseClass to retrieve the vote from the database
$vote = $db->readVote($id);

// check if the vote exists
if (!$vote) {
    // redirect to error page if vote is not found
    header('Location: createVote.php');
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Vote Information</title>
</head>
<body>
	<h1>Vote Information</h1>
	<p>Vote ID: <?php echo $vote['id']; ?></p>
	<p>Post ID: <?php echo $vote['post_id']; ?></p>
	<p>User ID: <?php echo $vote['user_id']; ?></p>
	<p>Vote Type: <?php echo $vote['vote_type']; ?></p>
</body>
</html>
