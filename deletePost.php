<?php
require_once 'database.php';

session_start(); // start session to retrieve user data

if (isset($_GET['post_id'])) {
    $post_id = $_GET['post_id'];
    $user_id = $_SESSION['user_id']; // Get the current user id from the session

    $db = new DatabaseClass();

    // Check if the current user is the author of the post
    $post = $db->getPostById($post_id);
    if ($post['user_id'] == $user_id) {
        // Delete the post
        $db->deletePostById($post_id);
    
        // Redirect to the list of posts
        header("Location: readPost.php");
        exit();
    } else {
        // If the current user is not the author, show an error message
        echo "You are not authorized to delete this post.";
    }
}
    // Redirect to the list of posts
    header("Location: dashboard.php");
    exit();
?>
