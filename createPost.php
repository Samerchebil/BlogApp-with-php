<?php
session_start(); 
require_once 'database.php';
$db = new DatabaseClass();
$user_id = $_SESSION['user_id'];
echo($user_id);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    

    // Validate inputs
    if (empty($title) || empty($description) || empty($user_id)) {
        echo "Please fill all required fields.";
        exit;
    }
    
    if (!ctype_digit($user_id)) {
        echo "User ID must be a number.";
        exit;
    }

    // Create the post
    $post_id = $db->createPost($title, $description, $user_id);

    if ($post_id) {
        echo "Post created successfully with ID: " . $post_id;
    } else {
        echo "Error creating post.";
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Create Post</title>
</head>

<body>
    <h1>Create a New Post</h1>
    <div style="margin:20px 0px;text-align:right;"><a href="readPost.php" class="button_link">Back to List</a></div>
    <div class="frm-add">
        <h1 class="form-heading">Add New Record</h1>
        <form method="post" action="">
            <div class="form-row">
                <label for="title">Title:</label><br>
                <input type="text" id="title" name="title" required />
            </div>
            <div class="form-row">
                <label for="description">Description:</label>
                <textarea id="description" name="description" rows="5" required></textarea><br><br>
            </div>
            <div class="form-row">
                <label for="user_id">User ID:</label><br>
                <input type="number" id="user_id" name="user_id" required /><br><br>
            </div>
            <div class="form-row">
                <input type="submit" name="add_record" value="Create Post">
            </div>
        </form>
    </div> 
</body>
</html>