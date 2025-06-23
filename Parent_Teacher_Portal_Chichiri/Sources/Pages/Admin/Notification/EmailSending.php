<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require('PHPMailer/src/Exception.php');
    require('PHPMailer/src/PHPMailer.php');
    require('PHPMailer/src/SMTP.php');
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'secondaryschoolchichiri@gmail.com';
    $mail->Password = 'oonmmqcsofpqdlsb';
    $mail->Port=465;
    $mail->SMTPSecure = 'ssl';

    $mail->setFrom('secondaryschoolchichiri@gmail.com');
    $mail->addAddress($email);
    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body = $message;
    $mail->send();


?>