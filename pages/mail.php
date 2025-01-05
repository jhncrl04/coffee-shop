<?php
require '../database/connection.php';
$first_name;
$email;
$emailExist;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = $_POST['firstName'];
    $last_name = $_POST['lastName'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirmPassword'];
    $is_verified = 'false';

    if ($first_name != null || $last_name != null || $email != null || ($password != null && $password == $confirm_password)) {
        // check if email exist in the database
        $query = "SELECT * FROM user_table WHERE email = '$email'";
        $queryResult = mysqli_query($db_conn, $query);
        if ($queryResult && mysqli_num_rows($queryResult) > 0) {
            $emailExist = true;
        } else {
            $signupQuery = "INSERT INTO user_table (fname, lname, email, user_password, is_verified)
                            VALUES ('$first_name', '$last_name', '$email', '$password', '$is_verified')";

            $emailExist = false;

            if (mysqli_query($db_conn, $signupQuery)) {
                echo '
                    <script>
                        const goToLoginModal = document.getElementById("formContainer");
                        goToLoginModal.showModal()
                    </script>';
            } else {
                echo "<script> console.log('Error: $signupQuery <br> mysqli_error($db_conn)') </script>";
            }
        }
    }
}

// maybe remove the member's previlege in the email

$email_body = "<!DOCTYPE html>
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
                padding: 20px;
                border: 1px solid #ddd;
                border-radius: 10px;
                background-color: #f9f9f9;
            }
            .header {
                text-align: center;
                margin-bottom: 20px;
            }
            .header h1 {
                color: #6B4226;
            }
            .content {
                text-align: left;
            }
            .footer {
                text-align: center;
                margin-top: 20px;
                font-size: 0.9em;
                color: #555;
            }
            .cta {
                text-align: center;
                margin: 20px 0;
            }
            .cta a {
                display: inline-block;
                padding: 10px 20px;
                text-decoration: none;
                background-color: #6B4226;
                color: white;
                border-radius: 5px;
                font-weight: bold;
            }
        </style>
    </head>
    <body>
        <div class='email-container'>
            <div class='header'>
                <h1>Welcome to Cool Beans Coffee, <b>$first_name</b>!</h1>
                <p>Your journey to a world of exquisite coffee starts here.</p>
            </div>
            <div class='content'>
                <p>Dear <b>$first_name</b>,</p>
                <p>
                    Thank you for joining the Cool Beans Coffee family! We are beyond excited to welcome you to our community of coffee lovers who share a passion for great flavors and unforgettable experiences.
                </p>
                <p>
                    At Cool Beans Coffee, we believe that every cup tells a story. From the meticulous selection of the finest coffee beans to the perfect brewing techniques, our mission is to deliver a premium experience that brightens your day.
                </p>
                <p>
                    As a valued member, you'll enjoy:
                    <ul>
                        <li>Exclusive access to seasonal blends and special brews.</li>
                        <li>Personalized recommendations tailored to your preferences.</li>
                        <li>Invitations to our upcoming events and promotions.</li>
                    </ul>
                </p>
                <p>
                    We’d love to hear your feedback or answer any questions you might have. Feel free to reply to this email or reach out to us at <a href='mailto:info@coolbeanscoffee.com'>info@coolbeanscoffee.com</a>.
                </p>
            </div>
            <div class='cta'>
                <a href='coffeeshop/pages/accountVerification.php?email=$email''>Verify Your Account</a>
            </div>
            <div class='footer'>
                <p>Brewing happiness, one cup at a time,</p>
                <p><b>The Cool Beans Coffee Team</b></p>
            </div>
        </div>
    </body>
    </html>";
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/PHPMailer/src/Exception.php';
require 'PHPMailer/PHPMailer/src/PHPMailer.php';
require 'PHPMailer/PHPMailer/src/SMTP.php';
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
    $mail->SMTPSecure =  'ssl';
    //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom($email, 'COOL BEANS COFFEE');
    $mail->addAddress($email);     //Add a recipient
    //$mail->addAddress('ellen@example.com');               //Name is optional
    //$mail->addReplyTo('info@example.com', 'Information');
    //$mail->addCC('cc@example.com');
    //$mail->addBCC('bcc@example.com');

    //Attachments
    // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Welcome to Cool Beans Coffee!';
    $mail->Body = $email_body;

    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    if (!$emailExist) {
        $mail->send();
        // open a modal on send
        $referer = $_SERVER['HTTP_REFERER'];
        echo "<script> alert('Verification Mail has been sent');window.location.href = '$referer'</script>";
    } else {
        $referer = $_SERVER['HTTP_REFERER'];
        echo "<script> alert('Already registered!Mail did not send')
        window.location.href = '$referer'</script>";
    }
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
