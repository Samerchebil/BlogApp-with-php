<?php
require_once 'database.php';

session_start(); 

if (isset($_GET['post_id'])) {
    $post_id = $_GET['post_id'];
    $user_id = $_SESSION['user_id']; 

    $db = new DatabaseClass();

    $post = $db->getPostById($post_id);
    if ($post['user_id'] == $user_id) {
        $db->deletePostById($post_id);
        header("Location: readPost.php");
        exit();
    } else {
        echo "You are not authorized to delete this post.";
    }
}
    header("Location: dashboard.php");
    exit();
?>
