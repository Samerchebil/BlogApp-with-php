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

    //users
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

    function updateUser($id,$username,$email,$password, $photo = null) {
        $sql = "UPDATE users SET email = :email, username = :username, password = :password";
        $params = [
            ':email' => $email,
            ':username' => $username,
            ':password' => password_hash($password, PASSWORD_DEFAULT),
            ':id' => $id
        ];
            if ($photo !== null) {
            $sql .= ", photo = :photo";
            $params[':photo'] = $photo;
        }
        $sql .= " WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->rowCount();
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


    // "posts"

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

    public function updatePost($id, $title, $description, $user_id,$uploadPath) {
        $stmt = $this->pdo->prepare("UPDATE `posts` SET `title` = ?, `description` = ?, `user_id` = ?, `photo` = ? WHERE `id` = ?");
        $stmt->execute([$title, $description, $user_id,$uploadPath, $id]);
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
            return null;
        }
        return $result;
    }
    
    public function deletePostById($id) {
        $stmt = $this->pdo->prepare("DELETE FROM `posts` WHERE `id` = ?");
        $stmt->execute([$id]);
        
    }

    // Likes

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
    $stmt = $this->pdo->prepare("SELECT * FROM post_likes WHERE user_id = ? AND post_id = ?");
    $stmt->execute([$user_id, $post_id]);

    if ($stmt->rowCount() === 0) {
        $stmt = $this->pdo->prepare("INSERT INTO post_likes (user_id, post_id) VALUES (?, ?)");
        $stmt->execute([$user_id, $post_id]);
    }
}

public function unlikePost($user_id, $post_id) {
    $stmt = $this->pdo->prepare("SELECT * FROM post_likes WHERE user_id = ? AND post_id = ?");
    $stmt->execute([$user_id, $post_id]);
    if ($stmt->rowCount() > 0) {
        $stmt = $this->pdo->prepare("DELETE FROM post_likes WHERE user_id = ? AND post_id = ?");
        $stmt->execute([$user_id, $post_id]);
    }
}

    // reports

public function check_reports($post_id) {
    $stmt = $this->pdo->prepare("SELECT COUNT(*) AS num_reports FROM reports WHERE post_id = ?");
    $stmt->execute([$post_id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row['num_reports'] >= 3;
}


public function checkIfPostReported($user_id, $post_id) {
    $stmt = $this->pdo->prepare("SELECT * FROM reports WHERE user_id = ? AND post_id = ?");
    $stmt->execute([$user_id, $post_id]);
    return $stmt->rowCount() > 0;
}


public function deletePostIfReported($post_id) {
    $stmt = $this->pdo->prepare("SELECT COUNT(*) AS count FROM reports WHERE post_id = ?");
    $stmt->execute([$post_id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $count = $row['count'];
    if ($count >= 3) {
        $stmt = $this->pdo->prepare("DELETE FROM posts WHERE id = ?");
        $stmt->execute([$post_id]);
        return true;
    }
    return false;
}

public function reportPost($user_id, $post_id, $reason) {
    $stmt = $this->pdo->prepare("SELECT * FROM reports WHERE user_id = ? AND post_id = ?");
    $stmt->execute([$user_id, $post_id]);

    if ($stmt->rowCount() > 0) {
        $stmt = $this->pdo->prepare("UPDATE reports SET reason = ? WHERE user_id = ? AND post_id = ?");
        $stmt->execute([$reason, $user_id, $post_id]);
    } else {
        $stmt = $this->pdo->prepare("INSERT INTO reports (user_id, post_id, reason) VALUES (?, ?, ?)");
        $stmt->execute([$user_id, $post_id, $reason]);
    }
}


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

}
?>
