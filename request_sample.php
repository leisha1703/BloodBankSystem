<?php
session_start();
include 'db_config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['user_id']) && $_SESSION['user_type'] == 'receiver') {
    $receiver_id = $_SESSION['user_id'];
    $blood_sample_id = mysqli_real_escape_string($conn, $_POST['blood_sample_id']);

    $verify_sql = "SELECT * FROM blood_samples WHERE id='$blood_sample_id'";
    $verify_result = mysqli_query($conn, $verify_sql);

    if (mysqli_num_rows($verify_result) == 1) {
        $insert_sql = "INSERT INTO requests (receiver_id, blood_sample_id, request_date) VALUES ('$receiver_id', '$blood_sample_id', NOW())";

        if (mysqli_query($conn, $insert_sql)) {
            $_SESSION['message'] = "Blood sample request submitted successfully!";
            $_SESSION['message_type'] = "success";
            header("Location: index.php");
            exit();
        } else {
            $_SESSION['message'] = "Error requesting blood sample: " . mysqli_error($conn);
            $_SESSION['message_type'] = "danger";
            header("Location: index.php");
            exit();
        }
    } else {
        $_SESSION['message'] = "Blood sample not found or not eligible.";
        $_SESSION['message_type'] = "warning";
        header("Location: index.php");
        exit();
    }
} else {
    $_SESSION['message'] = "Unauthorized access.";
    $_SESSION['message_type'] = "danger";
    header("Location: index.php");
    exit();
}

mysqli_close($conn);
?>
