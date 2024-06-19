<?php
session_start();
include 'db_config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $sql = "SELECT * FROM hospitals WHERE email='$email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_type'] = 'hospital';
            $_SESSION['user_name'] = $row['hospitalName'];
            header("Location: add_blood_info.php");
            exit();
        } else {
            echo "Invalid password";
        }
    } else {
        $sql = "SELECT * FROM receivers WHERE email='$email'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);
            if (password_verify($password, $row['password'])) {
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['user_type'] = 'receiver';
                $_SESSION['user_name'] = $row['name'];
                header("Location: index.php");
                exit();
            } else {
                echo "Invalid password";
            }
        } else {
            echo "User not found";
        }
    }
}

mysqli_close($conn);
?>
