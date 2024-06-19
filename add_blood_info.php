<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] != 'hospital') {
    header("Location: hlogin.php");
    exit();
}

include 'db_config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $blood_type = mysqli_real_escape_string($conn, $_POST['blood_type']);
    $quantity = mysqli_real_escape_string($conn, $_POST['quantity']);
    $hospital_id = $_SESSION['user_id'];

    $sql = "INSERT INTO blood_samples (blood_type, quantity, hospital_id) VALUES ('$blood_type', '$quantity', '$hospital_id')";

    if (mysqli_query($conn, $sql)) {
        $_SESSION['message'] = "Blood sample added successfully!";
        $_SESSION['message_type'] = "success";
    } else {
        $_SESSION['message'] = "Error: " . mysqli_error($conn);
        $_SESSION['message_type'] = "danger";
    }

    mysqli_close($conn);
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Blood Info - Blood Bank System</title>
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
            flex: 1;
            max-width: 600px;
            margin: 50px auto;
            background-color: #ffffff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1);
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
        <h2 class="text-center mb-4">Add Blood Info</h2>
        <form action="add_blood_info.php" method="POST">
            <div class="form-group">
                <label for="blood_type">Blood Type</label>
                <input type="text" id="blood_type" class="form-control" name="blood_type" required>
            </div>
            <div class="form-group">
                <label for="quantity">Quantity (in units)</label>
                <input type="number" id="quantity" class="form-control" name="quantity" required>
            </div>
            <button class="btn btn-lg btn-primary btn-block" type="submit">Add Blood Info</button>
        </form>
        <a href="view_requests.php" class="btn btn-secondary btn-block mt-3">View Requests</a>

    </div>

    <?php include 'footer.php'; ?>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
