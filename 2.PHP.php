<?php
include 'dbconnect.php';

if ($_SERVER['xREQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $username = $_POST['uname'];
    $password = $_POST['pass'];

    $stmt = $pdo->prepare("SELECT COUNT(*) FROM pick WHERE email = ?");
    $stmt->execute([$email]);
    $emailExists = $stmt->fetchColumn() > 0;

    if ($emailExists) {
        echo "<p>Email already registered. Please use a different email.</p>";
    } else {
        // Hash the password
        $passwordHash = password_hash(password: $password, algo: PASSWORD_DEFAULT);
        
        // Prepare and execute the statement
        $stmt = $pdo->prepare(query: "INSERT INTO users (name, email, uname, passs) VALUES (?, ?, ?, ?)");
        $stmt->execute(params: [$name, $email, $username, $passwordHash]);
        echo "<p>Registration successful!</p>";
    }
}

?>


<link rel="stylesheet" type="text/css" href="stylesheet.css">

<p>already Have an Account <a href="login.html">Login Here</a></p>


<form method="POST">



