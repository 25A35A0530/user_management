<?php
session_start();
include("../config/db.php");

if ($_SESSION['role'] != 1) {
    die("Access Denied");
}

$result = $conn->query("SELECT * FROM users");
?>

<!DOCTYPE html>
<html>
<head>
    <title>All Users</title>

    <style>
        body {
           margin: 0;
           font-family: Arial, sans-serif;
           min-height: 100vh;
           background: linear-gradient(135deg, #4e73df, #1cc88a);
           display: flex;
           justify-content: center;
           align-items: center;
        }

        .container {
            width: 80%;
            max-width: 900px;
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.2);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .logout {
            float: right;
            margin-bottom: 10px;
            text-decoration: none;
            background: #e74a3b;
            color: white;
            padding: 6px 12px;
            border-radius: 6px;
        }

        .logout:hover {
            background: #c0392b;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th {
            background: #4e73df;
            color: white;
            padding: 10px;
        }

        table td {
            padding: 10px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        tr:hover {
            background: #f5f5f5;
        }

        .edit-btn {
            background: #1cc88a;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            text-decoration: none;
        }

        .edit-btn:hover {
            background: #17a673;
        }

        .delete-btn {
            background: #e74a3b;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            text-decoration: none;
        }

        .delete-btn:hover {
            background: #c0392b;
        }
    </style>

</head>
<body>

<div class="container">

    <a class="logout" href="../auth/logout.php">Logout</a>

    <h2>All Users</h2>

    <table>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Action</th>
        </tr>

        <?php while($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?= $row['name'] ?></td>
            <td><?= $row['email'] ?></td>
            <td>
                <a class="edit-btn" href="edit_user.php?id=<?= $row['id'] ?>">Edit</a>
                <a class="delete-btn" href="delete_user.php?id=<?= $row['id'] ?>" onclick="return confirm('Delete this user?')">Delete</a>
            </td>
        </tr>
        <?php } ?>

    </table>

</div>

</body>
</html>