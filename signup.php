<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 50%;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            color: #333;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
            margin-top: 5px;
        }

        .btn {
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            border: none;
            width: 100%;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Sign Up</h2>
        <form action="signup.php" method="post">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <button type="submit" class="btn">Sign Up</button>
        </form>
    </div>
</body>
</html>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);

    // The email subject and message (with mail merge)
    $subject = "Thank you for signing up!";
    $message = "Dear $name,\n\nThank you for signing up to our platform!\nWe are excited to have you on board. Stay tuned for updates and announcements.\n\nBest regards,\nThe Team";

    // Email headers
    $headers = "From: noreply@yourdomain.com";

    // Send the email
    if (mail($email, $subject, $message, $headers)) {
        echo "Thank you for signing up, $name! A confirmation email has been sent to $email.";
    } else {
        echo "There was a problem sending the email.";
    }
}
?>
