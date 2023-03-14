<?php
require_once 'database.php';

session_start();
$db = new DatabaseClass();
$user = $db->getUserById($_SESSION['user_id']);
$baseuser_photo = $user['photo'];
$user_photo = preg_replace('/C:\\\\xampp\\\\htdocs\\\\BlogPhp/', '.', $baseuser_photo);



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = new DatabaseClass();
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $photo = $_FILES['photo'];
    if (!empty($password)) {
        $password = $password;
    } else {
        $password = $_SESSION['password'];
    }
    if (isset($photo) && $photo['error'] === UPLOAD_ERR_OK) {
        $tempName = $photo['tmp_name'];
        $originalName = $photo['name'];
        $uploadPath = __DIR__ . '/uploads/' . uniqid() . '_' . $originalName;

        if (!move_uploaded_file($tempName, $uploadPath)) {
            throw new Exception('Failed to move uploaded file!');
        }

        $photo = $uploadPath;
    } else {
        $photo = $_SESSION['photo'];
    }
    $db->updateUser($_SESSION['user_id'], $username, $email, $password, $photo);
    $_SESSION['user_username'] = $username;
    $_SESSION['user_email'] = $email;
    $_SESSION['user_password'] = $password;
    $_SESSION['user_photo'] = $photo;
    header('Location: dashboard.php');
    exit;
} else {
    $error = 'Invalid request method';
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/profile.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN"
        crossorigin="anonymous"></script>
    <title>Document</title>
</head>

<body>

    <div class="container rounded bg-white mt-5">
        <div class="row">
            <div class="col-md-4 border-right">
                <div class="d-flex flex-column align-items-center text-center p-3 py-5"><img class="rounded-circle mt-5"
                src="<?=$user_photo?>"  width="90"><span class="font-weight-bold"><?php echo $_SESSION['user_username']; ?></span><span class="text-black-50"><?php echo $_SESSION['user_email'];?></span></div>
            </div>
            <div class="col-md-8">
                <div class="p-3 py-5">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="d-flex flex-row align-items-center back"><i
                                class="fa fa-long-arrow-left mr-1 mb-1"></i>
                            <a href="dashboard.php" style="text-decoration: none;"><h6>Back to home</h6></a>
                        </div>
                        <h6 class="text-right">Edit Profile</h6>
                    </div>
                    <form method="POST" action="updateprofile.php" enctype="multipart/form-data">
    <div class="row mt-2">
        <div class="col-md-6"><input type="text" name="username" id="username" class="form-control" placeholder="Username" value="<?php echo $_SESSION['user_username']; ?>"></div>
        <div class="col-md-6"><input type="email" name="email" id="email" class="form-control" placeholder="Email" value="<?php echo $_SESSION['user_email']; ?>"></div>
    </div>
    <div class="row mt-3">
        <div class="col-md-6"><input type="password" name="password" class="form-control" placeholder="New Password"></div>
        <div class="col-md-6"><input type="file" name="photo" class="form-control" placeholder="Photo"></div>
    </div>
    <div class="mt-5 text-right"><button class="btn btn-primary profile-button" type="submit">Save Profile</button></div>
</form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>