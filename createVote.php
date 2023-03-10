<?php

require_once 'database.php';

$db = new DatabaseClass();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $post_id = $_POST['post_id'];
    $user_id = $_POST['user_id'];
    $vote_type = $_POST['vote_type'];
    
    $vote_id = $db->createVote($post_id, $user_id, $vote_type);
    
    if ($vote_id !== false) {
        // Vote created successfully
        echo "Vote created with ID: $vote_id";
    } else {
        // Error creating vote
        echo "Error creating vote";
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Create Vote</title>
</head>
<body>
    <h1>Create Vote</h1>
    <form method="post" action="createVote.php">
        <label for="post_id">Post ID:</label>
        <input type="text" name="post_id" id="post_id"><br><br>
        
        <label for="user_id">User ID:</label>
        <input type="text" name="user_id" id="user_id"><br><br>
        
        <label for="vote_type">Vote Type:</label>
        <select name="vote_type" id="vote_type">
            <option value="like">Like</option>
            <option value="dislike">Dislike</option>
        </select><br><br>
        
        <input type="submit" value="Create Vote">
    </form>
</body>
</html>