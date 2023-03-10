<?php
require_once 'database.php';

$db = new DatabaseClass();

if (isset($_GET['id'])) {
    $post_id = $_GET['id'];

    // Get the post details
    $post = $db->getPostById($post_id);

    // Get the user details for the post
    $user = $db->getUserById($post['user_id']);
} else {
    // Get all posts
    $posts = $db->getAllPosts();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Read Posts</title>
    <style type="text/css">
        .content{
            width: 50%;
            margin: 100px auto;
            border: 1px solid #cbcbcb;
        }
        .post{
            width: 80%;
            margin: 10px auto;
            border: 1px solid #cbcbcb;
            padding: 10px;
        }
    </style>
</head>

<body>
    <h1>Posts</h1>
    <?php if (isset($post)) : ?>
        <h2><?= $post['title'] ?></h2>
        <p><?= $post['description'] ?></p>
        <p>Posted by: <?= $user['username'] ?></p>
        <div><a href="readPost.php">Back to List</a></div>
    <?php else : ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Description </th>
                    <th>Posted By</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($posts as $post) {
                    echo '<tr>
                    <th>' . $post['id'] . '</th>
                    <td>' . $post['title'] . '</td>
                    <td>' . $post['description'] . '</td>
                    
                    <td>' . $post['user_id'] . '</td>
                        
                        <td>
                            <button class="btn btn-primary"><a href="updatePost.php?id=' . $post['id'] . '" class="text-light">Update</a></button>
                            <button class="btn btn-primary"><a href="deletePost.php?id=' . $post['id'] . '"  class="text-light">Delete</a></button>
                        </td>
                    </tr>';
                }
                ?>
            </tbody>
        </table>
    <?php endif; ?>
    <!-- Add Jquery -->
    <script type="text/javascript" src="jquery.min.js"></script>
    <script type="text/javascript" src="jquery.min.js"></script>
</body>

</html>