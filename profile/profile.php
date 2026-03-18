<?php
session_start();
include("../config/db.php");

$id = $_SESSION['user_id'];

$result = $conn->query("SELECT * FROM users WHERE id=$id");
$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Profile</title>

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

        .profile-container {
            background: white;
            padding: 30px;
            border-radius: 15px;
            width: 350px;
            text-align: center;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        }

        .profile-container h2 {
            margin-bottom: 20px;
        }

        .profile-img {
            width: 110px;
            height: 110px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #4e73df;
            margin-bottom: 15px;
        }

        .info {
            margin: 10px 0;
            font-size: 16px;
        }

        .btn {
            display: inline-block;
            margin-top: 10px;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 6px;
            color: white;
        }

        .edit-btn {
            background: #1cc88a;
        }

        .edit-btn:hover {
            background: #17a673;
        }

        .logout-btn {
            background: #e74a3b;
        }

        .logout-btn:hover {
            background: #c0392b;
        }
    </style>

</head>
<body>

<div class="profile-container">

    <h2>My Profile</h2>

    <img src="../uploads/<?= $user['profile_pic'] ?>" class="profile-img">

    <div class="info"><strong>Name:</strong> <?= $user['name'] ?></div>
    <div class="info"><strong>Email:</strong> <?= $user['email'] ?></div>

    <a class="btn edit-btn" href="edit_profile.php">Edit Profile</a><br>
    <a class="btn logout-btn" href="../auth/logout.php">Logout</a>

</div>

</body>
</html>