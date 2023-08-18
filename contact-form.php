<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Sanitize and validate form data
    $name = htmlspecialchars($_POST["name"], ENT_QUOTES, 'UTF-8');
    $subject = htmlspecialchars($_POST["subject"], ENT_QUOTES, 'UTF-8');
    $phone = htmlspecialchars($_POST["phone"], ENT_QUOTES, 'UTF-8');
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    $message = htmlspecialchars($_POST["message"], ENT_QUOTES, 'UTF-8');

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format.";
        exit();
    }

    // Create email content
    $subject = "New Contact Form Submission";
    $to = "info@deuselconsult.com";
    $headers = "From: $email\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
    
    $emailContent = "
        <html>
        <head>
            <title>$subject</title>
        </head>
        <body>
            <p><b>This mail is coming from the contact page</b></p><br><br>
            <p><strong>Name:</strong> $name</p>
            <p><strong>Email:</strong> $email</p>
            <p><strong>Phone:</strong> $phone</p>
            <p><strong>Subject:</strong> $subject</p>
            <p><strong>Message:</strong> $message</p>
        </body>
        </html>
    ";

    // Send email
    if (mail($to, $subject, $emailContent, $headers)) {
        echo "Message sent successfully!";
    } else {
        echo "Error sending email.";
    }
}

?>