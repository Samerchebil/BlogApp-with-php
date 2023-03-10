<?php
session_start(); // start session to store user data

require_once 'database.php'; // include the database class file



// check if the user submitted the login form
if (isset($_POST['login'])) {
    // create a new database object
    $db = new DatabaseClass();

    // retrieve the email or username and password from the form
    $emailOrUsername = $_POST['email_or_username'];
    $password = $_POST['password'];

    try {
        // try to log in the user
        $user = $db->loginUser($emailOrUsername, $password);

        // store the user data in the session
        
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_username'] = $user['username'];
        $_SESSION['photo'] = $user['phto'];
        echo($user['username']);
            // redirect the user to the dashboard page
        header('Location: dashboard.php');
    
        //   exit();
    } catch (Exception $e) {
        // if an error occurred, display it to the user
        $error = $e->getMessage();
    }
}

?><!DOCTYPE html>
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
              <h1 class="card-title text-center mb-5 fs-5">Login</h1>
              <?php if (isset($error)) { ?>
            <p style="color: red;"><?php echo $error; ?></p>
                <?php } ?>
              <form method="POST">
                <div class="form-floating mb-3">
                    <input type="text" name="email_or_username" class="form-control"  id="email_or_username" placeholder="email_or_username">
                    <label for="username">Username or Email</label>
                  </div>
                  <div class="form-floating mb-3">
                    <input type="password" class="form-control" name="password" placeholder="Password" id="password" required>
                    <label for="floatingPassword">Password</label>
                  </div>
                  
                <div class="d-grid">
				<input class="btn btn-primary btn-login text-uppercase fw-bold" type="submit" name="login" value="Login">
                </div>
                <hr class="my-4">
                <div class="d-grid mb-2">
                  <button class="btn btn-google btn-login text-uppercase fw-bold" style="background-color:#1DA1F2 ;" type="submit" >
                    <i class="fab fa-twitter me-2"></i> Login in using Twitter
                  </button>
                </div>
                <div class="d-grid">
                  <button class="btn btn-facebook btn-login text-uppercase fw-bold" type="submit">
                    <i class="fab fa-facebook-f me-2"></i>Login in using Facebook
                  </button>
                </div>
              </form>
              <p class="box-register">Dont have an account ? 
                <a href="register.php">S'inscrire</a>
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


<!-- 
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Login</title>
    <link href="style.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
</head>
<body>
    <div class="login">
        <h1>Login</h1>
        <?php if (isset($error)) { ?>
            <p style="color: red;"><?php echo $error; ?></p>
        <?php } ?>
        <form action="login.php" method="post">
            <label for="email_or_username">
                <i class="fas fa-user"></i>
            </label>
            <input type="text" name="email_or_username" placeholder="email_or_username" id="email_or_username" required>
            <label for="password">
                <i class="fas fa-lock"></i>
				</label>
				<input type="password" name="password" placeholder="Password" id="password" required>
				<input type="submit" name="login" value="Login">
			</form>
            
            <p class="box-register">Vous êtes nouveau ici? 
                <a href="register.php">S'inscrire</a>
            </p>
            
		</div>
	</body>
</html>
    
    -->