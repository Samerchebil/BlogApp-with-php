<?php
require_once 'database.php';

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form data
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Generate a unique ID
    $id = hash('sha256', time() . mt_rand());

    // Create a new instance of the database class
    $db = new DatabaseClass();


    try {
        if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
            $tempName = $_FILES['photo']['tmp_name'];
            $originalName = $_FILES['photo']['name'];
            $uploadPath = __DIR__ . '/uploads/' . uniqid() . '_' . $originalName;
          
            if (!move_uploaded_file($tempName, $uploadPath)) {
                throw new Exception('Failed to move uploaded file!');
            }
        
            $user_id = $db->registerUser($id, $email, $username, $password, $uploadPath);
           
        } else {
            $user_id = $db->registerUser($id, $email, $username, $password);
        }
        
        // Redirect to the login page
        header('Location: login.php');
        exit;
    } catch (Exception $e) {
        // Display an error message
        $error = $e->getMessage();
    }

    // Now we check if the data was submitted, isset() function will check if the data exists.
    if (!isset($_POST['username'], $_POST['password'], $_POST['email'])) {
        // Could not get the data that should have been sent.
        exit('Please complete the registration form!');
    }

    // Make sure the submitted registration values are not empty.
    if (empty($_POST['username']) || empty($_POST['password']) || empty($_POST['email'])) {
        // One or more values are empty.
        exit('Please complete the registration form');
    }

    if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        exit('Email is not valid!');
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer">
    <link href="style.css" rel="stylesheet" type="text/css">
    <title>Register</title>
</head>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="./css/login.css">
    <script src="https://kit.fontawesome.com/aa78da5867.js" crossorigin="anonymous"></script>

    <title>Document</title>
</head>

<body>  
    <div class="container">
      <div class="row">
        <div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
          <div class="card border-0 shadow rounded-3 my-5">
            <div class="card-body p-4 p-sm-5">
              <h1 class="card-title text-center mb-5 fs-5">Register</h1>
              <?php if (isset($error)) { ?>
            <p><?php echo $error; ?></p>
        <?php } ?>
              <form action="register.php" method="POST" enctype="multipart/form-data">
                <div class="form-floating mb-3">
                    <input type="text" name="username" class="form-control" placeholder="Username" id="username" required>
                    <label for="username">Username</label>
                  </div>
                  <div class="form-floating mb-3">
                    <input type="password" class="form-control" name="password" placeholder="Password" id="password" required>
                    <label for="floatingPassword">Password</label>
                  </div>

                  <div class="form-floating mb-3">
                    <input type="email" name="email" class="form-control"  placeholder="Email" id="email" required>
                    <label for="email">Email</label>
                  </div>

                  <div class="form-floating mb-3">
                    <input type="file" class="form-control" name="photo" id="photo">
                  </div>

                  <div class="d-grid">
				<input class="btn btn-primary btn-login text-uppercase fw-bold" type="submit" value="Register">
                </div>
                <hr class="my-4">
                <div class="d-grid mb-2">
                  <button class="btn btn-google btn-login text-uppercase fw-bold" style="background-color:#1DA1F2 ;" type="submit" >
                    <i class="fab fa-twitter me-2"></i> Register using Twitter
                  </button>
                </div>
                <div class="d-grid">
                  <button class="btn btn-facebook btn-login text-uppercase fw-bold" type="submit">
                    <i class="fab fa-facebook-f me-2"></i>Register using Facebook
                  </button>
                </div>
              </form>
              <p class="box-register">already have an account
                <a href="login.php">Login</a>
            </p>
            </div>
          </div>
        </div>
      </div>

    </div>
  </body>
  
<br><br><br><br> <br>
  <footer class="text-center text-white bg-white mt-5">
    <!-- Grid container -->
    <div class="container pt-4">
      <!-- Section: Social media -->
      <section class="mb-4">
        <!-- Facebook -->
        <a
          class="btn btn-link btn-floating btn-lg text-dark m-1"
          href="#!"
          role="button"
          data-mdb-ripple-color="dark"
          ><i class="fab fa-facebook-f"></i
        ></a>

        <!-- Twitter -->
        <a
          class="btn btn-link btn-floating btn-lg text-dark m-1"
          href="#!"
          role="button"
          data-mdb-ripple-color="dark"
          ><i class="fab fa-twitter"></i
        ></a>
  
        <!-- Google -->
        <a
          class="btn btn-link btn-floating btn-lg text-dark m-1"
          href="#!"
          role="button"
          data-mdb-ripple-color="dark"
          ><i class="fab fa-google"></i
        ></a>
  
        <!-- Instagram -->
        <a
          class="btn btn-link btn-floating btn-lg text-dark m-1"
          href="#!"
          role="button"
          data-mdb-ripple-color="dark"
          ><i class="fab fa-instagram"></i
        ></a>
      <!-- Section: Social media -->
    </div>
    <section class="text-dark card-title text-center mb-5 fs-5">
    Explore the World of Blogging with Us
      </section>
    <!-- Grid container -->
    <!-- Copyright -->
    <div class="text-center text-dark p-3" style="background-color: rgba(0, 0, 0, 0.2);">
      © 2020 Copyright:
      <a class="text-dark" href="https://mdbootstrap.com/">SamerBlog.com</a>
    </div>
    <!-- Copyright -->
  </footer>
</html>
</html>