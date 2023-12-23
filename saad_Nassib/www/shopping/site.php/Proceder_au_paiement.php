<?php

include("config.php");
session_start();
$userId = $_SESSION['user_id'];

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the credit card details from the form
    $cardNumber = $_POST['card_number'];
    $cardHolder = $_POST['card_holder'];
    $expiryMonth = $_POST['expiry_month'];
    $expiryYear = $_POST['expiry_year'];
    $cvv = $_POST['cvv'];

    // Process the payment (In a real-world scenario, you would use a payment gateway API)

    // For simplicity, let's assume the payment is successful
    $paymentSuccess = true;

    // Calculate total (you may have this value from your existing logic)
    $totalCartPrice = 100; // Replace with your actual logic

    if ($paymentSuccess) {
        // Insert order details into the database
        $orderRef = uniqid(); // Generating a unique reference (you may need a better approach)
        $orderDate = date('Y-m-d H:i:s'); // Current date and time

        // Connection to the database using mysqli
        $dbConnection = mysqli_connect("localhost", "root", "", "ecom1_project");

        // Check if the connection is successful
        if (!$dbConnection) {
            die("Connection failed: " . mysqli_connect_error());
        }

        // Insert order into the database using mysqli
        $insertOrderSql = "INSERT INTO user_order (ref, date, total, user_id) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($dbConnection, $insertOrderSql);
        mysqli_stmt_bind_param($stmt, 'ssdi', $orderRef, $orderDate, $totalCartPrice, $userId);
        mysqli_stmt_execute($stmt);

        // Close the connection
        mysqli_close($dbConnection);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Credit Card Payment</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2>Détails de paiement (teste)</h2>

        <?php if(isset($paymentSuccess) && $paymentSuccess) { ?>
            <div class="alert alert-success">
                Payment successful!
            </div>
        <?php } ?>

        <form action="Soumission_Commande.php" method="post">
            <div class="form-group">
                <label for="card_number">Card Number</label>
                <input type="text" name="card_number" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="card_holder">Card Holder Name</label>
                <input type="text" name="card_holder" class="form-control" required>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="expiry_month">Expiry Month</label>
                    <input type="text" name="expiry_month" class="form-control" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="expiry_year">Expiry Year</label>
                    <input type="text" name="expiry_year" class="form-control" required>
                </div>
            </div>
            <div class="form-group">
                <label for="cvv">CVV</label>
                <input type="text" name="cvv" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Pay Now</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
