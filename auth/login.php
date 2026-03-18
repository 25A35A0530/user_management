<?php
session_start();
include("../config/db.php");

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST['email'];
    $password = $_POST['password'];

    if(empty($email) || empty($password)){
        $error = "All fields are required!";
    } else {

        $stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
        $stmt->bind_param("s", $email);
        $stmt->execute();

        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user && password_verify($password, $user['password'])) {

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role_id'];

            if ($user['role_id'] == 1) {
                header("Location: ../crud/view_users.php");
            } else {
                header("Location: ../profile/profile.php");
            }

            exit();

        } else {
            $error = "Invalid Email or Password!";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, #4e73df, #1cc88a);
        }

        .login-container {
            background: white;
            padding: 30px;
            border-radius: 12px;
            width: 300px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.2);
            text-align: center;
        }

        .login-container h2 {
            margin-bottom: 20px;
        }

        .login-container input {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border-radius: 6px;
            border: 1px solid #ccc;
            outline: none;
        }

        .login-container input:focus {
            border-color: #4e73df;
        }

        .login-container button {
            width: 100%;
            padding: 10px;
            background: #4e73df;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            margin-top: 10px;
        }

        .login-container button:hover {
            background: #2e59d9;
        }

        .error {
            color: red;
            font-size: 14px;
            margin-bottom: 10px;
        }

        .link {
            margin-top: 10px;
            display: block;
            font-size: 14px;
        }
    </style>

</head>
<body>

<div class="login-container">

    <h2>Login</h2>

    <?php if($error) { ?>
        <div class="error"><?= $error ?></div>
    <?php } ?>

    <form method="POST">

        <input type="email" name="email" placeholder="Email" required>

        <input type="password" name="password" placeholder="Password" required>

        <button type="submit">Login</button>

    </form>

    <a class="link" href="register.php">Don't have an account? Register</a>

</div>

</body>
</html>