<?php
// inclure le fichier de la classe DatabaseClass
require_once 'database.php';

// créer une nouvelle instance de la classe DatabaseClass
$db = new DatabaseClass();

// Vérifier si l'utilisateur a soumis un formulaire de mise à jour
if (isset($_POST['update'])) {
    // récupérer les valeurs du formulaire
    $id = $_POST['id'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // appeler la méthode "updateUser" de la classe DatabaseClass pour mettre à jour l'utilisateur dans la base de données
    $db->updateUser($id, $email, $username, $password);

    // rediriger l'utilisateur vers la page d'accueil après la mise à jour
    header('Location: readUser.php');
}

// récupérer l'ID de l'utilisateur à partir de la requête GET
$id = $_GET['updateid'];

// appeler la méthode "getAllUsers" de la classe DatabaseClass pour récupérer les informations de l'utilisateur
$user = $db->getAllUsers($id);

// afficher le formulaire de mise à jour avec les informations de l'utilisateur récupérées
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <title>Update User</title>
</head>
<body>
    <div class="container">
        <h1 class="my-5">Update User</h1>
        <form method="POST">
            <input type="hidden" name="id" value="<?php echo $user[0]['id']; ?>">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control" id="email" value="<?php echo $user[0]['email']; ?>">
            </div>
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" name="username" class="form-control" id="username" value="<?php echo $user[0]['username']; ?>">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" class="form-control" id="password" value="<?php echo $user[0]['password']; ?>">
            </div>
            <button type="submit" name="update" class="btn btn-primary">Update User</button>
        </form>
    </div>
</body>
</html>