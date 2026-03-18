<?php
include("../config/db.php");

$id = $_GET['id'];

$result = $conn->query("SELECT * FROM users WHERE id=$id");
$user = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST['name'];
    $email = $_POST['email'];

    $stmt = $conn->prepare("UPDATE users SET name=?, email=? WHERE id=?");
    $stmt->bind_param("ssi", $name, $email, $id);
    $stmt->execute();

    header("Location: view_users.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit User</title>

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

        .edit-container {
            background: white;
            padding: 30px;
            border-radius: 12px;
            width: 320px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.2);
            text-align: center;
        }

        .edit-container h2 {
            margin-bottom: 20px;
        }

        .edit-container input {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border-radius: 6px;
            border: 1px solid #ccc;
            outline: none;
        }

        .edit-container input:focus {
            border-color: #4e73df;
        }

        .edit-container button {
            width: 100%;
            padding: 10px;
            background: #1cc88a;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            margin-top: 10px;
        }

        .edit-container button:hover {
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

<div class="edit-container">

    <h2>Edit User</h2>

    <form method="POST">
        <input type="text" name="name" value="<?= $user['name'] ?>" required>

        <input type="email" name="email" value="<?= $user['email'] ?>" required>

        <button type="submit">Update</button>
    </form>

    <a class="back-link" href="view_users.php">← Back to Users</a>

</div>

</body>
</html>