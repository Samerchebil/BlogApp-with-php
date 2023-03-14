<?php
require_once('database.php');

// Créer une nouvelle instance de la classe DatabaseClass
$db = new DatabaseClass('localhost', 'phpprojet', 'root', '');

// Vérifier si des données ont été envoyées via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $id = $_POST['id'];
    $photo = $_POST['photo'];


    try {
        $db->createUser($id,$email, $username, $password);
        header('location:register.php?success=1');
    } catch (Exception $e) {
        header('location:register.php?error=' . $e->getMessage());
    }
} else {
    die("Aucune donnée n'a été envoyée.");
}
if (!$db) {
    die("La connexion à la base de données a échoué.");
}
?>