?php
session_start();
require_once 'db.php';

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstname = trim($_POST['firstname']);
    $lastname = trim($_POST['lastname']);
    $username = trim($_POST['username']);
    $birthdate = $_POST['birthdate'];
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $pdo->prepare('SELECT COUNT(*) FROM users WHERE email = :email');
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $exists = $stmt->fetchColumn();
    
        if ($exists > 0) {
            header('Location: /register?error=failed');
            exit;
        }
    
    $stmt = $pdo->prepare('INSERT INTO users (user_id, first_name, last_name, email, password, birthdate) VALUES (:user_id, :first_name, :last_name, :email, :password, :birthdate)');
    $stmt->bindParam(':first_name', $firstname);
    $stmt->bindParam(':last_name', $lastname);
    $stmt->bindParam(':user_id', $username);
    $stmt->bindParam(':birthdate', $birthdate);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':password', $password);
    $succes = $stmt->execute();
    
    header('Location: /login');
    exit;
}

?>
