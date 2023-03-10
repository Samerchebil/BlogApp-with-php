<?php
session_start();
require_once 'database.php';
$db = new DatabaseClass();

if (isset($_SESSION['user_id']) && isset($_GET['post_id'])) {
    $user_id = $_SESSION['user_id'];
    $post_id = $_GET['post_id'];

    $db->unlikePost($user_id, $post_id);

    header("Location: dashboard.php");
} else {
    header("Location: login.php");
}
?>