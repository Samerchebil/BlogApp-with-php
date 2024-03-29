<?php
session_start(); 

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

require_once 'database.php';

$user_id = $_SESSION['user_id'];
$user_email = $_SESSION['user_email'];
$user_username = $_SESSION['user_username'];
$db = new DatabaseClass();
$user = $db->getUserById($_SESSION['user_id']);
$baseuser_photo = $user['photo'];
$user_photo = preg_replace('/C:\\\\xampp\\\\htdocs\\\\BlogPhp/', '.', $baseuser_photo);
$posts = $db->getAllPosts();
$allUsers = $db->getAllUsers();

if (isset($_POST['like'])) {
  $post_id = $_POST['post_id'];
  $user_id = $_SESSION['user_id'];

  $sql = "INSERT INTO post_likes (user_id, post_id) VALUES ($user_id, $post_id)";
  mysqli_query($conn, $sql);

  header('Location: dashboard.php?post_id=' . $post_id);
  exit();
}
 ?>
<!DOCTYPE html>
<html>
<head>
<title>W3.CSS Template</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<style>
body,h1,h2,h3,h4,h5 {font-family: "Raleway", sans-serif}
</style>
</head>
<body class="w3-light-grey">

<div class="w3-content" style="max-width:1400px">

<header class="w3-container w3-center w3-padding-32"> 
  <h1><b>MY BLOG</b></h1>
  <p>Welcome to the blog of <span class="w3-tag"><?= $user_username ?></span></p>
</header>

<div class="w3-row">
<div class="w3-col l8 s12"> 
  <?php

foreach ($posts as $post) {
    $title = $post['title'];
    $description = $post['description'];
    $post_photo = $post['photo'];
    $photo = preg_replace('/C:\\\\xampp\\\\htdocs\\\\BlogPhp/', '.', $post_photo);
    $username_post = $db->getUserById($post['user_id'])['username'];
    $post_id = $post['id'];
    $like_count = $db->getLikesCountByPostId($post_id);
    $user_id = $_SESSION['user_id'];
    ?>
    <div class="w3-card-4 w3-margin w3-white">
        <?php if (!empty($photo)) { ?>
        <img src="<?php echo $photo; ?>" alt="Post photo" style="width:100%">
        <?php } ?>
        <div class="w3-container">
            <h3><b><?php echo $title; ?></b></h3>
            <h5>Written By <?php echo $username_post; ?></h5>
        </div>
        <div class="w3-container">
            <p><?php echo $description; ?></p>
            <div class="w3-row">
                <div class="w3-col m8 s12">
                <?php
                $is_post_reported = $db->checkIfPostReported($user_id, $post_id);
                $report_button_text = $is_post_reported ? 'Reported' : 'Report';
                $report_button_color = $is_post_reported ? 'w3-red' : 'w3-white';
                ?>
                    <?php
                    $user_liked_post = $db->checkIfUserLikedPost($user_id, $post_id);
                    if ($user_liked_post) {
                    ?>
                        <a href="unlike_post.php?post_id=<?php echo $post_id; ?>" class="w3-button w3-padding-large w3-red w3-border"><b>Unlike</b></a>
                    <?php
                    } else {
                    ?>
                        <a href="like_post.php?post_id=<?php echo $post_id; ?>" class="w3-button w3-padding-large w3-white w3-border"><b>Like</b></a>
                    <?php
                    }
                    if ($user_id == $post['user_id']) {
                      ?>
                      <a href="deletePost.php?post_id=<?php echo $post_id; ?>" class="w3-button w3-padding-large w3-white w3-border"><b>Delete</b></a>
                      <a href="updatePost.php?post_id=<?php echo $post_id; ?>" class="w3-button w3-padding-large w3-white w3-border"><b>Update</b></a>
                     <?php
                    }
                    ?>
                     <?php
                    if ($user_id != $post['user_id']) {
                      ?>
                    <a href="report_post.php?post_id=<?php echo $post_id; ?>" class="w3-button w3-padding-large <?php echo $report_button_color; ?> w3-border"><b><?php echo $report_button_text; ?></b></a>
                    <?php
                    }
                    ?>
                  </div>
                <div class="w3-col m4 w3-hide-small">
                    <p><span class="w3-padding-large w3-right"><b>Likes</b> <span class="w3-tag"><?php echo $like_count; ?></span></span></p>
                </div>
            </div>
        </div>
    </div>
<?php
}
?>
  <hr>


</div>

<!-- Introduction menu -->
<div class="w3-col l4">
  <!-- About Card -->
  <div class="w3-card w3-margin w3-margin-top">
  <img src="<?=$user_photo?>"style="width:100%">
  
    <div class="w3-container w3-white">
      <h4><a href="updateProfile.php" style="text-decoration: none;"><b><?= $user_username ?></b></a></h4>
      <p> <?= $user_email ?></p>
      <p class="box-register">Upload a new <a href="UploadPost.php">post</a> </p>
    </div>
  </div><hr>
  
  <!-- Users -->
  <div class="w3-card w3-margin">
    <div class="w3-container w3-padding">
      <h4>Other users</h4>
    </div>
    <ul class="w3-ul w3-hoverable w3-white">
      
<?php
ob_start();
foreach ($allUsers as $suser) {
  $name = $suser['username'];
  $semail = $suser['email'];
  $suser_photo = preg_replace('/C:\\\\xampp\\\\htdocs\\\\BlogPhp/', '.', $suser['photo']);
  ?>
  <li class="w3-padding-16">
    <img src="<?php echo $suser_photo; ?>" alt="Image" class="w3-left w3-margin-right" style="width:50px">
    <span class="w3-large"><?php echo $name; ?></span><br>
    <span><?php echo $semail; ?></span>
  </li>
<?php }
$output = ob_get_clean();
echo $output;
?>
    </ul>
  </div>

    <!-- Logout form -->
    <div class="w3-card w3-margin">
    <div class="w3-container w3-padding">
      <h4>Logout</h4>
    </div>
    <div class="w3-container w3-white">
      <form action="logout.php" method="post">
      <input type="submit" name="logout" value="Logout" class="w3-button w3-round-large w3-hover-white" style="font-family: 'Raleway', sans-serif; background-color: #ccc; padding: 8px 16px; font-size: 14px;   margin-top: 5px;margin-bottom: 5px;">
      </form>
    </div>
  </div>
  
</div> <!-- close w3-col l4 div -->
  <hr> 
 

<!-- END Introduction Menu -->
</div>

<!-- END GRID -->
</div><br>

<!-- END w3-content -->
</div>

<!-- Footer -->
<footer class="w3-container w3-dark-grey w3-padding-32 w3-margin-top">
  <button class="w3-button w3-black w3-disabled w3-padding-large w3-margin-bottom">Previous</button>
  <button class="w3-button w3-black w3-padding-large w3-margin-bottom">Next »</button>
</footer>

</body>
</html>
