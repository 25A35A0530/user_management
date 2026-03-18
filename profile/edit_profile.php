<?php
session_start();
include("../config/db.php");

$id = $_SESSION['user_id'];

// Fetch existing user data
$result = $conn->query("SELECT * FROM users WHERE id=$id");
$user = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST['name'];

    $filename = $user['profile_pic']; // default old image

    // If new image uploaded
    if (!empty($_FILES['image']['name'])) {
        $file = $_FILES['image'];
        $filename = time() . "_" . $file['name'];
        $tmp = $file['tmp_name'];

        move_uploaded_file($tmp, "../uploads/" . $filename);
    }

    $stmt = $conn->prepare("UPDATE users SET name=?, profile_pic=? WHERE id=?");
    $stmt->bind_param("ssi", $name, $filename, $id);
    $stmt->execute();

    header("Location: profile.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Profile</title>

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

        .edit-profile-container {
            background: white;
            padding: 30px;
            border-radius: 15px;
            width: 350px;
            text-align: center;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        }

        .edit-profile-container h2 {
            margin-bottom: 15px;
        }

        .profile-preview {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #4e73df;
            margin-bottom: 15px;
        }

        .edit-profile-container input {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border-radius: 6px;
            border: 1px solid #ccc;
            outline: none;
        }

        .edit-profile-container input:focus {
            border-color: #4e73df;
        }

        .edit-profile-container button {
            width: 100%;
            padding: 10px;
            background: #1cc88a;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            margin-top: 10px;
        }

        .edit-profile-container button:hover {
            background: #17a673;
        }

        .back-link {
            display: block;
            margin-top: 10px;
            text-decoration: none;
            font-size: 14px;
        }
    </style>

</head>
<body>

<div class="edit-profile-container">

    <h2>Edit Profile</h2>

    <img src="../uploads/<?= $user['profile_pic'] ?>" class="profile-preview">

    <form method="POST" enctype="multipart/form-data">
        <input type="text" name="name" value="<?= $user['name'] ?>" required>

        <input type="file" name="image">

        <button type="submit">Update Profile</button>
    </form>

    <a class="back-link" href="profile.php">← Back to Profile</a>

</div>

</body>
</html>