<?php
session_start();

require_once 'database.php';
$db = new DatabaseClass();

if (isset($_POST['submit'])) {
  $user_id = $_SESSION['user_id'];
  $post_id = $_POST['post_id'];
  $reason = $_POST['reason'];

  $db->reportPost($user_id, $post_id, $reason);
  $db->deletePostIfReported($post_id);
  header('Location: dashboard.php');
  exit();
}

if (!isset($_GET['post_id'])) {
    header('Location: dashboard.php');
    exit();
}

$post_id = $_GET['post_id'];
$post = $db->getPostById($post_id);

if (!$post) {
  header('Location: dashboard.php');
  exit();
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Report Post</title>
  <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
</head>
<body>
  <div class="w3-container w3-margin">
    <h2>Report Post: "<?php echo $post['title']; ?>"</h2>
    <form method="post">
      <input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
      <p>
        <label for="reason">Reason:</label>
        <textarea name="reason" rows="5" cols="40"></textarea>
      </p>
      <p>
        <button type="submit" name="submit" class="w3-button w3-red">Submit Report</button>
      </p>
    </form>
  </div>
</body>
</html>