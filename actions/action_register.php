<?php
declare(strict_types=1);

require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/user.class.php');

$db = getDatabaseConnection();

// flag to check if register was successful
$registerSuccess = true;

// validate fullname field
if (empty($_POST['full_name'])) {
  $session->addFieldError('full_name', 'Full Name is required!');
  $registerSuccess = false;
}

// validate email field
if (empty($_POST['email'])) {
  $session->addFieldError('email', 'Email is required!');
  $registerSuccess = false;
}

// validate username field
if (empty($_POST['username'])) {
  $session->addFieldError('username', 'Username is required!');
  $registerSuccess = false;
}

// validate password field
if (empty($_POST['password'])) {
  $session->addFieldError('password', 'Password is required!');
  $registerSuccess = false;
}

// validate confirm_password field
if (empty($_POST['confirm_password'])) {
  $session->addFieldError('confirm_password', 'Confirm password is required!');
  $registerSuccess = false;
}

// validate password and confirm_password fields
if ($_POST['password'] != $_POST['confirm_password']) {
  $session->addFieldError('password', 'Passwords do not match!');
  $session->addFieldError('confirm_password', 'Passwords do not match!');
  $registerSuccess = false;
}

// validate email field
if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
  $session->addFieldError('email', 'Invalid email!');
  $registerSuccess = false;
}

// validate password field
if (strlen($_POST['password']) < 8) {
  $session->addFieldError('password', 'Password must be at least 8 characters long!');
  $registerSuccess = false;
}

// check if password contains at least one letter and one number
if (!preg_match('/[A-Za-z].*[0-9]|[0-9].*[A-Za-z]/', $_POST['password'])) {
  $session->addFieldError('password', 'Password must contain at least one letter and one number!');
  $registerSuccess = false;
}

// check if username already exists
if (getUserByUsername($_POST['username']) != null) {
  $session->addFieldError('username', 'Username already exists!');
  $registerSuccess = false;
}

// check if email already exists
if (getUserByEmail($_POST['email']) != null) {
  $session->addFieldError('email', 'Email already exists!');
  $registerSuccess = false;
}



if ($registerSuccess) {
  $fullname = $_POST['full_name'];
  $username = $_POST['username'];
  $email = $_POST['email'];
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
  $role_id = 3;

  $db = getDatabaseConnection();

  $image_path = User::DEFAULT_IMAGE_PATH;

  try {
    $stmt = $db->prepare('INSERT INTO User (fullname, username, email, password, role_id, image_path) VALUES (?, ?, ?, ?, ?, ?)');
    $stmt->execute(array($fullname, $username, $email, $password, $role_id, $image_path));
    $session->addMessage('success', 'Register successful!');
    header('Location: ../pages/login.php');
  } catch (PDOException $e) {
    $session->addMessage('error', 'Register fds!');
    header('Location: ' . $_SERVER['HTTP_REFERER']);
  }
} else {

  $session->addMessage('error', 'The form was not filled correctly!');
  header('Location: ' . $_SERVER['HTTP_REFERER']);
}
?>