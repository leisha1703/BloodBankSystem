<?php
session_start();
include 'db_config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blood Bank System</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
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
        .blood-sample {
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
        <h2 class="text-center mb-4">Welcome to Blood Bank System</h2>

        <?php
        if (isset($_SESSION['message'])) {
            echo '<div class="alert alert-' . $_SESSION['message_type'] . ' alert-dismissible fade show" role="alert">'
                . $_SESSION['message'] .
                '<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                 </button>
                 </div>';
            unset($_SESSION['message']);
            unset($_SESSION['message_type']);
        }
        ?>

        <hr>

        <h4 class="mb-4">Available Blood Samples</h4>
        
        <?php
        $sql = "SELECT blood_samples.id, blood_samples.blood_type, blood_samples.quantity, hospitals.hospitalName 
                FROM blood_samples 
                JOIN hospitals ON blood_samples.hospital_id = hospitals.id";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<div class="blood-sample">';
                echo '<h5>' . htmlspecialchars($row['blood_type']) . '</h5>';
                echo '<p>Quantity: ' . htmlspecialchars($row['quantity']) . ' units</p>';
                echo '<p>Hospital: ' . htmlspecialchars($row['hospitalName']) . '</p>';

                if (isset($_SESSION['user_id']) && $_SESSION['user_type'] == 'receiver') {
                    $receiver_id = $_SESSION['user_id'];
                    $receiver_sql = "SELECT bloodGroup FROM receivers WHERE id='$receiver_id'";
                    $receiver_result = mysqli_query($conn, $receiver_sql);
                    $receiver_row = mysqli_fetch_assoc($receiver_result);
                    $receiver_blood_type = $receiver_row['bloodGroup'];

                    if ($receiver_blood_type == $row['blood_type']) {
                        echo '<form action="request_sample.php" method="POST">';
                        echo '<input type="hidden" name="blood_sample_id" value="' . $row['id'] . '">';
                        echo '<button type="submit" class="btn btn-sm btn-primary">Request Sample</button>';
                        echo '</form>';
                    } else {
                        echo '<button class="btn btn-sm btn-secondary" disabled>Not Eligible</button>';
                    }
                } elseif (!isset($_SESSION['user_id'])) {
                    echo '<button class="btn btn-sm btn-primary" onclick="showLoginAlert()">Request Sample</button>';
                } else {
                    echo '<button class="btn btn-sm btn-secondary" disabled>Hospitals cannot request</button>';
                }

                echo '</div>';
            }
        } else {
            echo '<p>No blood samples available at the moment.</p>';
        }

        mysqli_close($conn);
        ?>

    </div>

    <?php include 'footer.php'; ?>
    <script>
        function showLoginAlert() {
            //alert("You need to login first to request a blood sample.");
            window.location.href = 'rlogin.php';
        }
    </script>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
