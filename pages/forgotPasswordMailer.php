<?php
require '../database/connection.php';
include_once '../includes/encryptDecrypt.php';
require '../database/site-setting.php';

$recover_email = $_POST['forgotPassEmail'];
$recover_email_exist;

$ciphertext = encryptData($recover_email);

// use code in the account recovery
// validate if email exist
$query = "SELECT * FROM user_table WHERE email = '$recover_email'";
$queryResult = mysqli_query($db_conn, $query);

// set email exist to true if query return a result
$recover_email_exist = $queryResult && mysqli_num_rows($queryResult) > 0;

$email_body = "
<!DOCTYPE html>
<html>
<head>
    <style>
    body {
        font-family: Arial, sans-serif;
        line-height: 1.6;
        color: #333;
    }
    .email-container {
        max-width: 600px;
        margin: auto;
        padding: 40px;
        border: 1px solid #ddd;
        border-radius: 10px;
        background-color: #f9f9f9;
    }
    .header {
        text-align: center;
        margin-bottom: 30px;
    }
    .header h1 {
        color: #6b4226;
        margin-bottom: 0;
    }
    .header p {
        color: #5b5b5b;
        margin-top: 0;
    }
    .content {
        text-align: center;
    }
    .content .text-left {
        text-align: left;
    }
    .content p {
        color: #333;
        font-size: 16px;
        letter-spacing: 2px;
    }
    .content .small-text {
        font-size: 14px;
    }
    .footer {
        text-align: center;
        margin-top: 30px;
        font-size: 1em;
        color: #555;
    }
    .footer p {
        text-align: center;
        color: #5b5b5b;
        margin: 0;
    }
    .footer .trademark {
        margin-bottom: 10px;
    }
    .footer p.warning {
        font-size: 14px;
        padding: 0 50px;
        color: rgb(139, 139, 139);
    }
    .cta {
        text-align: center;
        margin: 35px 0;
    }
    .cta a {
        display: inline-block;
        padding: 10px 20px;
        font-size: 16px;
        letter-spacing: 2px;
        text-decoration: none;
        background-color: #6b4226;
        color: white;
        border-radius: 5px;
        font-weight: 600;
    }
    </style>
</head>
<body>
    <div class='email-container'>
        <div class='header'>
            <h1>Password Reset Request</h1>
            <p>We're here to help you get back on track.</p>
        </div>
        <div class='content'>
            <p class='text-left'>Dear <b>Customer</b>,</p>
            <p>
                We received a request to reset the password for your Cool Beans Coffee
                account. If you made this request, you can reset your password by
                clicking the button below:
            </p>
            <div class='cta'>
                <a
                    href='coffeeshop/pages/index.php?action=reset-password&email=$ciphertext'
                    target='_self'
                >
                    Reset Your Password
                </a>
            </div>
            <p class='small-text'>
                If you did not request a password reset, you can safely ignore this
                email. Your account information is still secure, and no changes have
                been made.
            </p>
            <p class='small-text'>
                If you have any questions or need assistance, feel free to reach out
                to our team at
            <a href='mailto:info.coolbeanscoffee@gmail.com'>
                info.coolbeanscoffee@gmail.com
            </a>
            </p>
        </div>
        <div class='footer'>
            <p>Warm regards,</p>
            <p class='trademark'><b>The Cool Beans Coffee Team</b></p>
            <p style='font-size: 12px; color: gray'>
                Please do not reply to this email. If you need assistance, contact our support team.
            </p>
        </div>
    </div>
</body>
</html>";
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require './PHPMailer/PHPMailer/src/Exception.php';
require './PHPMailer/PHPMailer/src/PHPMailer.php';
require './PHPMailer/PHPMailer/src/SMTP.php';
//Load Composer's autoloader
//require 'vendor/autoload.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    // $mail->SMTPDebug = 5;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'info.coolbeanscoffee@gmail.com';                     //SMTP username
    $mail->Password   = 'gpvdqobgcsevocvv';                               //SMTP password
    $mail->SMTPSecure = 'ssl';
    //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom($recover_email, 'COOL BEANS COFFEE');
    $mail->addAddress($recover_email);     //Add a recipient
    //$mail->addAddress('ellen@example.com');               //Name is optional
    //$mail->addReplyTo('info@example.com', 'Information');
    //$mail->addCC('cc@example.com');
    //$mail->addBCC('bcc@example.com');

    //Attachments
    // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Password Reset';
    $mail->Body = $email_body;

    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    if ($recover_email_exist) {
        $mail->send();
        echo '<script> alert("Recovery Link Sent")
                window.location.href = "index.php"
        </script>';
        // open a modal on send
    } else {
        echo `<script> alert("Can't find your email\nPlease check your email")
                window.location.href = "index.php"
        </script>`;
    }
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
