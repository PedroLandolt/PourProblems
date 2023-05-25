<?php
declare(strict_types=1);

require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/user.class.php');

$db = getDatabaseConnection();

// flag to check if login was successful
$loginSuccess = true;

// validate email field for empty email
if (empty($_POST['email'])) {
  $session->addFieldError('email', 'Email is required!');
  $loginSuccess = false;
}

// validate password field for empty password
if (empty($_POST['password'])) {
  $session->addFieldError('password', 'Password is required!');
  $loginSuccess = false;
}

// validate email field for valid email
if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
  $session->addFieldError('email', 'Invalid email!');
  $loginSuccess = false;
}

// validate email field for existing email
if (getUserByEmail($_POST['email']) == null) {
  $session->addFieldError('email', 'Email does not exist!');
  $loginSuccess = false;
}

// validate password field for correct password

$user = User::getUserWithPassword($db, $_POST['email'], $_POST['password']);
if ($user == null) {
  $session->addFieldError('password', 'Wrong password!');
  $loginSuccess = false;
}



if ($loginSuccess) {
  try {
    $session->setId($user->id);
    $encryptedId = base64_encode(strval($session->getID()));
    $session->setName($user->fullname);
    $session->addMessage('success', 'Login successful!');
    header('Location: ../pages/profile.php?id=' . $encryptedId);
  } catch (Exception $e) {
    $session->addMessage('error', 'Login failed!');
    header('Location: ' . $_SERVER['HTTP_REFERER']);
  }
} else {
  $session->addMessage('error', 'The form was not filled correctly!');
  header('Location: ' . $_SERVER['HTTP_REFERER']);
}

?>