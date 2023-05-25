<?php
declare(strict_types=1);

require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/user.class.php');

$db = getDatabaseConnection();

// flag to check if send email was successful
$sendEmailSuccess = true;

// validate email field
if (empty($_POST['email'])) {
    $session->addFieldError('email', 'Email is required!');
    $sendEmailSuccess = false;
}

// validate email field for valid email
if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    $session->addFieldError('email', 'Invalid email!');
    $sendEmailSuccess = false;
}

if ($sendEmailSuccess) {
    try {
        $user = getUserByEmail($_POST['email']);
        //$user->sendPasswordResetEmail();
        $session->addMessage('success', 'Email sent!');
        header('Location: ../pages/login.php');
    } catch (Exception $e) {
        $session->addMessage('error', 'Email not sent!');
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }
} else {
    $session->addMessage('error', 'The form was not filled correctly!');
    header('Location: ' . $_SERVER['HTTP_REFERER']);
}


?>