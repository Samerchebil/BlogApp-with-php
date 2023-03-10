<?php
// include the DatabaseClass file
require_once 'database.php';

// create a new instance of the DatabaseClass
$db = new DatabaseClass();

// call the readUser method to retrieve data for all users
$users = $db->readUser();


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <title>Document</title>
</head>
<body>
    <div class="container">
        <button class="btn btn-primary my-5"><a href="createUser.php" class="text-light">Add user</a></button>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    
                    <th scope="col">Password</th>
                    <th scope="col">Operation</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    foreach ($users as $user) {
                            echo '<tr>
                                    <th scope="row">' . $user['id'] . '</th>
                                    <td>' .  $user['username'] . '</td>
                                    <td>' .  $user['email'] . '</td>
                                    
                                    <td>' . $user['password'] . '</td>
                                    <td>
                                        <button class="btn btn-primary"><a href="updateUser.php?updateid='.$user['id'].'" class="text-light">Update</a></button>
                                        <button class="btn btn-primary"><a href="deleteUser.php?deleteid='.$user['id'].'" class="text-light">Delete</a></button>
                                    </td>
                                </tr>';
                        }   
                    
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>