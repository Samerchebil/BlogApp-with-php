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

 <!doctype html>
<html lang="en">

<head>
	<title>Report Post: <?php echo $post['title']; ?></title>
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
					<h2 class="heading-section">Report Post: "<?php echo $post['title']; ?>"</h2>
				</div>
			</div>
			<div class="row justify-content-center">
				<div class="col-md-12">
					<div class="wrapper">
						<div class="row no-gutters">
							<div class="col-md-7">
								<div class="contact-wrap w-100 p-md-5 p-4">
									<h3 class="mb-4">What is the reason for you to flag this post ?</h3>
									<div id="form-message-warning" class="mb-4"></div>
									<div id="form-message-success" class="mb-4">
										Your message was sent, thank you!
									</div>
                                    <form method="post">
										<div class="row">
											<div class="col-md-6">
											<input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
											</div>
											<div class="col-md-12">
												<div class="form-group">
													<label class="label" for="#">Reason</label>
													<textarea name="reason" class="form-control" id="reason" cols="30"
														rows="4" placeholder="Description"></textarea>					
												</div>
											</div>
											<div class="col-md-12">
												<div class="form-group">
												<button type="submit" name="submit" class="btn btn-dark">Submit Report</button>
													<div class="submitting"></div>
												</div>
											</div>
										</div>
									</form>
								</div>
							</div>
							<div class="col-md-5 d-flex align-items-stretch">
								<div class="info-wrap w-100 p-5 img" style="background-image: url(images/report.jpg);">
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