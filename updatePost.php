<?php
session_start();
require_once 'database.php';
$db = new DatabaseClass();
$user_id = $_SESSION['user_id'];
echo($user_id);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $post_id = $_POST['post_id'];
    $title = $_POST['title'];
    $description = $_POST['description'];

    if (empty($post_id) || empty($title) || empty($description) || empty($user_id)) {
        echo "Please fill all required fields.";
        exit;
    }

    try {
        if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
            $tempName = $_FILES['photo']['tmp_name'];
            $originalName = $_FILES['photo']['name'];
            $uploadPath = __DIR__ . '/uploads/' .'/posts/'. uniqid() . '_' . $originalName;

            if (!move_uploaded_file($tempName, $uploadPath)) {
                throw new Exception('Failed to move uploaded file!');
            }

            $post = $db->getPostById($post_id);
            if ($post && file_exists($post['image_url'])) {
                unlink($post['image_url']);
            }

            $db->updatePost($post_id, $title, $description,$user_id, $uploadPath);
        } else {
            $db->updatePost($post_id, $title, $description,$user_id);
        }
    } catch (Exception $e) {
        var_dump($e->getMessage());
        die();
        $error = $e->getMessage();
    }

    if ($error) {
        echo "Error updating post.";
    } else {
        echo "Post updated successfully with ID: " . $post_id;
        header('Location: dashboard.php');
    }
}

$post_id = $_GET['post_id'];
if (empty($post_id)) {
    echo "Please provide a post ID.";
    exit;
}

$post = $db->getPostById($post_id);
if (!$post) {
    echo "No post found with ID: " . $post_id;
    exit;
}

?>
<!doctype html>
<html lang="en">

<head>
	<title>Create Post </title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link href='https://fonts.googleapis.com/css?family=Roboto:400,100,300,700' rel='stylesheet' type='text/css'>

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

	<link rel="stylesheet" href="css/style.css">

</head>

<body style="background-color: #f1f1f1;">
	<section class="ftco-section">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-6 text-center mb-5">
					<h2 class="heading-section">What's New ?</h2>
				</div>
			</div>
			<div class="row justify-content-center">
				<div class="col-md-12">
					<div class="wrapper">
						<div class="row no-gutters">
							<div class="col-md-7">
								<div class="contact-wrap w-100 p-md-5 p-4">
									<h3 class="mb-4">Share a new story with our community</h3>
									<div id="form-message-warning" class="mb-4"></div>
									<div id="form-message-success" class="mb-4">
										Your message was sent, thank you!
									</div>
                                    <form method="post" action="updatePost.php" name="updatePostForm" class="contactForm" enctype="multipart/form-data">
    <input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label class="label" for="title">
                    Title
                </label>
                <input type="text" class="form-control" name="title" id="title" value="<?php echo $post['title']; ?>">
            </div>
        </div>
        <div class="col-md-6">
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label class="label" for="image">Image</label>
                <input type="file" class="form-control" name="photo" id="photo">
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label class="label" for="#">Description</label>
                <textarea name="description" class="form-control" id="description" cols="30" rows="4"><?php echo $post['description']; ?></textarea>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <input class="btn btn-dark" type="submit" name="Update" value="Update">
                <div class="submitting"></div>
            </div>
        </div>
    </div>
</form>
								</div>
							</div>
							<div class="col-md-5 d-flex align-items-stretch">
								<div class="info-wrap w-100 p-5 img" style="background-image: url(images/img.jpg);">
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<footer class="w3-container w3-dark-grey w3-padding-32 w3-margin-top">
  <button class="w3-button w3-black w3-disabled w3-padding-large w3-margin-bottom"><a href="dashboard.php">Previous</a></button>
</footer>
	<script src="js/jquery.min.js"></script>
	<script src="js/popper.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/jquery.validate.min.js"></script>
	<script src="js/main.js"></script>
</body>
</html>