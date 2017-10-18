<?php
require 'phpmailer/PHPMailerAutoload.php';
    // Only process POST reqeusts.
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get the form fields and remove whitespace.
        $name = strip_tags(trim($_POST["name"]));
		$name = str_replace(array("\r","\n"),array(" "," "),$name);
        $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
        $subject = trim($_POST["subject"]);
        $phone = trim($_POST["phone"]);
        $message = trim($_POST["message"]);

        // Check that data was sent to the mailer.
        if ( empty($name) OR empty($message) OR !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            // Set a 400 (bad request) response code and exit.
          //  http_response_code(400);
            echo "Please complete the form and try again.";
            exit;
        }

        // Set the recipient email address.
        // FIXME: Update this to your desired email address.
        $recipient = "info@devnetti.com";

        // Set the email subject.
        $subject = "New contact from $name";

        // Build the email content.
        $email_content = "Name: $name\n";
        $email_content .= "Email: $email\n\n";
        $email_content .= "Phone: $phone\n\n";
        $email_content .= "Subject: $subject\n\n";
        $email_content .= "Message:\n$message\n";

        // Build the email headers.
        $email_headers = "From: $name <$email>";

        $mail             = new PHPMailer();

        $mail->IsSMTP(); // telling the class to use SMTP
        $mail->Host       = "mail.gmail.com"; // SMTP server
        $mail->SMTPDebug  = 0;                     // enables SMTP debug information (for testing)
                                                   // 1 = errors and messages
                                                   // 2 = messages only
        $mail->SMTPAuth   = true;                  // enable SMTP authentication
        $mail->SMTPSecure = "tls";
        $mail->Host       = "smtp.gmail.com";      // SMTP server
        $mail->Port       = 587;                   // SMTP port
        $mail->Username   = "tiagols1@gmail.com";  // username
        $mail->Password   = "Tls070782";            // password

        $mail->SetFrom('tiagols1@gmail.com', 'Test');

        $mail->Subject    = $subject;

        $mail->MsgHTML($email_content);

        $address = "info@devnetti.com";
        $mail->AddAddress($address, "Info");
        $mail->AddAddress("tiago@devnetti.com", "Tiago Santos");

        if(!$mail->Send()) {
          echo "Mailer Error: " . $mail->ErrorInfo;
        } else {
          echo "Message sent!<br/>";
          echo "<a href='http://www.devnetti.com'>devnetti.com</a>";
        }


    } else {
        // Not a POST request, set a 403 (forbidden) response code.
      //  http_response_code(403);
        echo "There was a problem with your submission, please try again.";
    }

?>
