<!-- Paiement.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informations de Paiement</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2>Informations de Paiement</h2>

        <!-- PayPal payment information form -->
        <form method="post" action="Confirmation_paiement.php">
            <div class="form-group">
                <label for="paypal_email">Adresse Email PayPal :</label>
                <input type="email" name="paypal_email" id="paypal_email" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="paypal_password">Mot de passe PayPal :</label>
                <input type="password" name="paypal_password" id="paypal_password" class="form-control" required>
            </div>
            <!-- You can add more PayPal-related fields as needed -->

            <button type="submit" name="confirm_payment" class="btn btn-success">Confirmer le Paiement</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
