<?php
class DatabaseClass {
    private $host;
    private $username;
    private $password;
    private $database;
    private $pdo;

    public function __construct($dbhost = "localhost", $dbname = "phpprojet", $username = "root", $password = "")
    {
        try {
            $this->pdo= new PDO("mysql:host={$dbhost};dbname={$dbname};", $username, $password);
            //$this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }

   

    public function connect() {
        $dsn = "mysql:host={$this->host};dbname={$this->database};charset=utf8mb4";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];
        $this->pdo = new PDO($dsn, $this->username, $this->password, $options);
    }

    // CRUD operations for the "users" table

    public function createUser($email, $username, $password) {
        $stmt = $this->pdo->prepare("INSERT INTO `users` (`email`, `username`, `password`) VALUES (?, ?, ?)");
        $stmt->execute([$email, $username, $password]);
        return $this->pdo->lastInsertId();
    }

    public function readUser() {
        $stmt = $this->pdo->prepare("SELECT * FROM `users`");
        $stmt->execute();
        return $stmt->fetchAll();
    }
   

    public function updateUser($id, $email, $username, $password) {
        $stmt = $this->pdo->prepare("UPDATE `users` SET `email` = ?, `username` = ?, `password` = ? WHERE `id` = ?");
        $stmt->execute([$email, $username, $password, $id]);
    }
    public function getAllUsersById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM `users` WHERE `id` = ?");
        $stmt->execute([$id]);
        return $stmt->fetchAll();
    }
    public function getAllUsers() {
        $stmt = $this->pdo->prepare("SELECT * FROM `users`");
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function getUserById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM `users` WHERE `id` = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function deleteUser($id) {
        $stmt = $this->pdo->prepare("DELETE FROM `users` WHERE `id` = ?");
        $stmt->execute([$id]);
    }

    // CRUD operations for the "posts" table

    public function createPost($title, $description, $user_id,$photoPath = null) {
        $stmt = $this->pdo->prepare("INSERT INTO `posts` (`title`, `description`, `user_id`,`photo`) VALUES (?, ?, ?, ?)");
        $stmt->execute([$title, $description, $user_id,$photoPath]);
        return $this->pdo->lastInsertId();
    }

    // CREATE TABLE `posts` (
    //     `id` INT NOT NULL AUTO_INCREMENT,
    //     `title` VARCHAR(255) NOT NULL,
    //     `description` TEXT NOT NULL,
    //     `user_id` INT NOT NULL,
    //     `photo` VARCHAR(255),
    //     PRIMARY KEY (`id`)
    //   );

    public function readPost($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM `posts` WHERE `id` = ?");
        $stmt->execute([$id]);
        return $stmt->fetchAll();
    }
    
    

    public function updatePost($id, $title, $description, $user_id) {
        $stmt = $this->pdo->prepare("UPDATE `posts` SET `title` = ?, `description` = ?, `user_id` = ? WHERE `id` = ?");
        $stmt->execute([$title, $description, $user_id, $id]);
    }
    public function getAllPosts() {
        $stmt = $this->pdo->prepare("SELECT * FROM `posts`");
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    public function getPostById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM `posts` WHERE `id` = ?");
        $stmt->execute([$id]);
        $result = $stmt->fetch();
        if (!$result) {
            return null; // return null when no post is found
        }
    
        return $result;
    }
    
    public function deletePostById($id) {
        $stmt = $this->pdo->prepare("DELETE FROM `posts` WHERE `id` = ?");
        $stmt->execute([$id]);
        
    }

    // CRUD operations for the "likes" table
    public function createVote($post_id, $user_id, $vote_type) {
        $stmt = $this->pdo->prepare("INSERT INTO votes (post_id, user_id, vote_type) VALUES (?, ?, ?)");
        $stmt->execute([$post_id, $user_id, $vote_type]);
        return $this->pdo->lastInsertId();
    }

    public function readVote($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM votes WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function updateVote($id, $post_id, $user_id, $vote_type) {
        $stmt = $this->pdo->prepare("UPDATE votes SET post_id = ?, user_id = ?, vote_type = ? WHERE id = ?");
        $stmt->execute([$post_id, $user_id, $vote_type, $id]);
        return $stmt->rowCount();
    }

    public function deleteVote($id) {
        $stmt = $this->pdo->prepare("DELETE FROM votes WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->rowCount();
    }

    public function getVotesForPost($post_id) {
        $stmt = $this->pdo->prepare("SELECT * FROM votes WHERE post_id = ?");
        $stmt->execute([$post_id]);
        return $stmt->fetchAll();
    }



// CRUD operations for the "reports" table

public function createReport($post_id, $user_id) {
    $stmt = $this->pdo->prepare("INSERT INTO `reports` (`post_id`, `user_id`) VALUES (?, ?)");
    $stmt->execute([$post_id, $user_id]);
    return $this->pdo->lastInsertId();
}

public function readReport($id) {
    $stmt = $this->pdo->prepare("SELECT * FROM `reports` WHERE `id` = ?");
    $stmt->execute([$id]);
    return $stmt->fetch();
}

public function updateReport($id, $post_id, $user_id, $reason) {
    $stmt = $this->pdo->prepare("UPDATE `reports` SET `post_id` = ?, `user_id` = ?, `reason` = ? WHERE `id` = ?");
    $stmt->execute([$post_id, $user_id, $reason, $id]);
}

public function deleteReport($id) {
    $stmt = $this->pdo->prepare("DELETE FROM `reports` WHERE `id` = ?");
    $stmt->execute([$id]);
}

public function registerUser1($id, $email, $username, $password) {
    $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM users WHERE email = ? OR username = ?");
    $stmt->execute([$email, $username]);
    $count = $stmt->fetchColumn();
    if ($count > 0) {
        throw new Exception("The email or username is already taken.");
    }
    
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $this->pdo->prepare("INSERT INTO users (id, email, username, password) VALUES (?, ?, ?, ?)");
    $stmt->execute([$id, $email, $username, $hashedPassword]);
    return $this->pdo->lastInsertId();
}


public function registerUser($id, $email, $username, $password, $photoPath = null) {
    $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM users WHERE email = ? OR username = ?");
    $stmt->execute([$email, $username]);
    $count = $stmt->fetchColumn();
    if ($count > 0) {
        throw new Exception("The email or username is already taken.");
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    if ($photoPath) {
       
        $stmt = $this->pdo->prepare("INSERT INTO users (id, email, username, password, photo) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$id, $email, $username, $hashedPassword, $photoPath]);
    } else {
        $stmt = $this->pdo->prepare("INSERT INTO users (id, email, username, password) VALUES (?, ?, ?, ?)");
        $stmt->execute([$id, $email, $username, $hashedPassword]);
    }
    return $this->pdo->lastInsertId();
}




public function loginUser($emailOrUsername, $password) {
    $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = ? OR username = ?");
    $stmt->execute([$emailOrUsername, $emailOrUsername]);
    $user = $stmt->fetch();
    if (!$user) {
        throw new Exception("User not found.");
    }
    
    if (!password_verify($password, $user['password'])) {
        throw new Exception("Incorrect password.");
    }
    
    return $user;
}


public function getLikesCountByPostId($post_id)
{
    $stmt = $this->pdo->prepare("SELECT COUNT(*) AS count FROM post_likes WHERE post_id = ?");
    $stmt->execute([$post_id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['count'];
}

public function checkIfUserLikedPost($user_id, $post_id)
{
    $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM `post_likes` WHERE `user_id` = ? AND `post_id` = ?");
    $stmt->execute([$user_id, $post_id]);
    $result = $stmt->fetchColumn();
    return $result > 0;
}
public function likePost($user_id, $post_id) {
    // Check if the user has already liked the post
    $stmt = $this->pdo->prepare("SELECT * FROM post_likes WHERE user_id = ? AND post_id = ?");
    $stmt->execute([$user_id, $post_id]);

    if ($stmt->rowCount() === 0) {
        // User hasn't liked the post, insert a new row in post_likes table
        $stmt = $this->pdo->prepare("INSERT INTO post_likes (user_id, post_id) VALUES (?, ?)");
        $stmt->execute([$user_id, $post_id]);
    }
}

public function unlikePost($user_id, $post_id) {
    // Check if the user has already liked the post
    $stmt = $this->pdo->prepare("SELECT * FROM post_likes WHERE user_id = ? AND post_id = ?");
    $stmt->execute([$user_id, $post_id]);

    if ($stmt->rowCount() > 0) {
        // User has liked the post, delete the row from post_likes table
        $stmt = $this->pdo->prepare("DELETE FROM post_likes WHERE user_id = ? AND post_id = ?");
        $stmt->execute([$user_id, $post_id]);
    }
}

}
?>
