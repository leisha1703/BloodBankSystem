<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'hospital') {
    header("Location: hlogin.php");
    exit();
}

include 'db_config.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Requests - Blood Bank System</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        html, body {
            height: 100%;
            margin: 0;
            display: flex;
            flex-direction: column;
        }
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .container {
            max-width: 800px;
            margin: 50px auto;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1);
        }
        .request-item {
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #f1f1f1;
        }
        footer {
            background-color: #343a40;
            color: white;
            text-align: center;
            padding: 10px 0;
            margin-top: auto;
        }
    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>

    <div class="container">
        <h2 class="text-center mb-4">View Requests</h2>

        <?php
        $hospital_id = $_SESSION['user_id'];
        $sql = "SELECT requests.request_id, receivers.name AS receiver_name, blood_samples.blood_type, requests.request_date 
                FROM requests 
                JOIN receivers ON requests.receiver_id = receivers.id 
                JOIN blood_samples ON requests.blood_sample_id = blood_samples.id 
                WHERE blood_samples.hospital_id = '$hospital_id'";

        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<div class="request-item">';
                echo '<h5>Receiver: ' . ($row['receiver_name']) . '</h5>';
                echo '<p>Blood Type: ' . ($row['blood_type']) . '</p>';
                echo '<p>Request Date: ' . ($row['request_date']) . '</p>';
                echo '</div>';
            }
        } else {
            echo '<p>No requests found.</p>';
        }

        mysqli_close($conn);
        ?>

    </div>

    <?php include 'footer.php'; ?>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
