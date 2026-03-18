<?php
include("../config/db.php");

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role_id = $_POST['role_id'];

    // File upload
    $file = $_FILES['profile_pic'];
    $filename = time() . "_" . basename($file['name']);
    $tmp = $file['tmp_name'];
    $size = $file['size'];
    $type = $file['type'];

    $allowed = ['image/jpeg','image/png','image/jpg'];

    if(empty($name) || empty($email) || empty($password) || empty($role_id)){
        $message = "All fields required!";
    }
    elseif($file['error'] !== 0){
        $message = "Error uploading file";
    }
    elseif(!in_array($type, $allowed)){
        $message = "Only JPG, JPEG, PNG allowed!";
    }
    elseif($size > 2000000){
        $message = "File too large (max 2MB)";
    }
    elseif(!move_uploaded_file($tmp, "../uploads/".$filename)){
        $message = "Failed to upload image";
    }
    else {
        $stmt = $conn->prepare("INSERT INTO users (name,email,password,role_id,profile_pic) VALUES (?,?,?,?,?)");
        $stmt->bind_param("sssis", $name, $email, $password, $role_id, $filename);

        if($stmt->execute()){
            $message = "Registered Successfully 🎉";
        } else {
            $message = "Error: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>

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

        .register-container {
            background: white;
            padding: 30px;
            border-radius: 12px;
            width: 300px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.2);
            text-align: center;
        }

        .register-container h2 {
            margin-bottom: 20px;
        }

        .register-container input,
        .register-container select {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border-radius: 6px;
            border: 1px solid #ccc;
            outline: none;
        }

        .register-container button {
            width: 100%;
            padding: 10px;
            background: #4e73df;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            margin-top: 10px;
        }

        /* POPUP STYLE */
        .toast {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: #1cc88a;
            color: white;
            padding: 15px 20px;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            opacity: 0;
            transform: translateY(50px);
            transition: all 0.5s ease;
        }

        .toast.show {
            opacity: 1;
            transform: translateY(0);
        }
    </style>

</head>
<body>

<!-- POPUP -->
<?php if(!empty($message)) { ?>
    <div id="toast" class="toast">
        <?= $message ?>
    </div>
<?php } ?>

<div class="register-container">

    <h2>Register</h2>

    <form method="POST" enctype="multipart/form-data">

        <input type="text" name="name" placeholder="Name" required>

        <input type="email" name="email" placeholder="Email" required>

        <input type="password" name="password" placeholder="Password" required>

        <select name="role_id" required>
            <option value="">Select Role</option>
            <option value="1">Admin</option>
            <option value="2">User</option>
        </select>

        <input type="file" name="profile_pic" required>

        <button type="submit">Register</button>

    </form>

</div>

<script>
    const toast = document.getElementById("toast");
    if(toast){
        setTimeout(() => toast.classList.add("show"), 100);
        setTimeout(() => toast.classList.remove("show"), 3000);
    }
</script>

</body>
</html>