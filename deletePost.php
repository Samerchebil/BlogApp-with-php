<?php
require_once 'database.php';

if (isset($_GET['id'])) {
    $post_id = $_GET['id'];

    $db = new DatabaseClass();

    // Delete the post
    $db->deletePostById($post_id);

    // Redirect to the list of posts
    header("Location: readPost.php");
    exit();
}
?>
