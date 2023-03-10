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
        // Appeler la méthode pour créer un utilisateur
        $db->createUser($id,$email, $username, $password);
        
        // Rediriger l'utilisateur vers la page d'insertion avec un message de succès
        header('location:register.php?success=1');
    } catch (Exception $e) {
        // Rediriger l'utilisateur vers la page d'insertion avec un message d'erreur
        header('location:register.php?error=' . $e->getMessage());
    }
} else {
    // Si aucune donnée n'a été envoyée, afficher un message d'erreur
    die("Aucune donnée n'a été envoyée.");
}

// Vérifier si la connexion a réussi
if (!$db) {
    die("La connexion à la base de données a échoué.");
}
?>