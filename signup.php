<?php
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';
require 'PHPMailer-master/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);

    
    try {
        $dsn = 'mysql:host=localhost;dbname=ICS_22;charset=utf8mb4';
        $pdo = new PDO($dsn, 'root', ''); 
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        
        $stmt = $pdo->prepare("INSERT INTO users (name, email) VALUES (:name, :email)");
        $stmt->execute(['name' => $name, 'email' => $email]);

        
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = getenv('GMAIL_USERNAME'); // environment variable
            $mail->Password = getenv('GMAIL_PASSWORD'); // environment variable
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom(getenv('GMAIL_USERNAME'), 'Ojuka');
            $mail->addAddress($email, $name);

            $mail->isHTML(true);
            $mail->Subject = "Welcome to ICS 2.2! Account Verification";
            $mail->Body = "
            <html>
            <head>
              <title>Welcome to ICS 2.2! Account Verification</title>
            </head>
            <body>
              <h1>Hello $name,</h1>
              <p>You requested an account on ICS 2.2.</p>
              <p>In order to use this account you need to <a href='#'>Click Here</a> to complete the registration process.</p>
              <br>
              <p>Regards,</p>
              <p>Systems Admin</p>
              <p>ICS 2.2</p>
            </body>
            </html>
            ";

            $mail->send();
            echo "Thank you for signing up, $name! A confirmation email has been sent to $email.";
        } catch (Exception $e) {
            echo "There was a problem sending the email. Mailer Error: {$mail->ErrorInfo}";
        }

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

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
