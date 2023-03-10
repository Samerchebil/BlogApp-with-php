<?php
require_once 'database.php';

$db = new DatabaseClass();

if (isset($_POST['submit'])) {
    $post_id = $_POST['post_id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $user_id = $_POST['user_id'];

    // Update the post
    $db->updatePost($post_id, $title, $description, $user_id);

    // Redirect to the post details page
    header("Location: readPost.php?id=$post_id");
    exit;
} else if (isset($_GET['id'])) {
    // Get the post details
    $post_id = $_GET['id'];
    $post = $db->getPostById($post_id);
    $user_id = $post['user_id'];
    $users = $db->getAllUsers($post_id);

} else {
    header('Location: readPost.php');
    exit;
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Modifier le Post</title>
</head>

<body>
    <h1>Modifier le Post</h1>
    <form method="POST">
        <input type="hidden" name="post_id" value="<?= $post_id ?>">
        <div>
            <label for="title">Titre</label>
            <input type="text" name="title" id="title" value="<?= isset($post) ? $post['title'] : '' ?>">
        </div>
        <div>
            <label for="description">Description</label>
            <textarea name="description" id="description"><?= $post['description'] ?></textarea>
        </div>
        <div>
            <label for="user_id">Posté par</label>
            <select name="user_id" id="user_id">
                <?php if (!empty($users)) : ?>
                    <?php foreach ($users as $user_option) : ?>
                        <option value="<?= $user_option['id'] ?>" <?php if ($user_option['id'] == $user_id) echo 'selected' ?>>
                            <?= $user_option['username'] ?>
                        </option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
        </div>
        <div>
            <input type="submit" name="submit" value="Modifier le Post">
            <a href="readPost.php?id=<?= $post_id ?>">Annuler</a>
        </div>
    </form>
</body>

</html>
