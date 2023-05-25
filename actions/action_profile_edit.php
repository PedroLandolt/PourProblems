<?php

declare(strict_types=1);

require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

if (!$session->isLoggedIn()) {
    die(header('Location: /'));
}

require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/department.class.php');

require_once(__DIR__ . '/../database/user.class.php');

$db = getDatabaseConnection();

$user_id = $session->getId();

$encryptedId = base64_encode(strval($session->getID()));

$user = User::getUser($db, $user_id);

$update_profile_success = true;


//Check for user inputs
if (empty($_POST['username'])) {
    $session->addFieldError('username', 'Username is required!');
    $update_profile_success = false;
}

if (empty($_POST['fullname'])) {
    $session->addFieldError('fullname', 'Full name is required!');
    $update_profile_success = false;
}

if (empty($_POST['email'])) {
    $session->addFieldError('email', 'Email is required!');
    $update_profile_success = false;
}

if (empty($_POST['password'])) {
    $session->addFieldError('password', 'Password is required!');
    $update_profile_success = false;
}

if (empty($_POST['confirm_password'])) {
    $session->addFieldError('confirm_password', 'Confirm password is required!');
    $update_profile_success = false;
}

if ($_POST['password'] != $_POST['confirm_password']) {
    $session->addFieldError('password', 'Passwords do not match!');
    $session->addFieldError('confirm_password', 'Passwords do not match!');
    $update_profile_success = false;
}

if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
    $session->addFieldError('email', 'Invalid email!');
    $update_profile_success = false;
}

if ($user->email != $_POST['email']) {
    if (getUserByEmail($_POST['email']) != NULL) {
        $session->addFieldError('email', 'Email already exists!');
        $update_profile_success = false;
    }
}


//Check for image
function save_in_uploads_profile($temp_name, $name)
{
    $uploads_dir = __DIR__ . '/../uploads/profiles/';
    $extension = explode('.', $name);
    $image_name = uniqid() . '.' . $extension[count($extension) - 1];
    move_uploaded_file($temp_name, $uploads_dir . $image_name);

    return $image_name;
}



if ($update_profile_success) {

    $fullname = $_POST['fullname'];
    $username = $_POST['username'];
    $email = $_POST['email'];

    $image_path = $user->image_path;

    if ($_FILES['file'] != NULL) {
        $file_name = $_FILES['file']['name'];
        $file_size = $_FILES['file']['size'];
        $temp_name = $_FILES['file']['tmp_name'];

        if (isset($file_name) && $file_size > 0 && $file_size < 1000000) {
            $image_path = save_in_uploads_profile($temp_name, $file_name);
        }
    }

    try {
        $user->updateUserProfile($db, $fullname, $username, $email, $image_path);
        $session->addMessage('success', 'Profile updated successfully!');
        header('Location: /pages/profile.php?id=' . $encryptedId);
    } catch (Exception $e) {
        $session->addMessage('error', $e->getMessage());
        header('Location: /pages/profile.php?id=' . $encryptedId);
    }
} else {
    $session->addMessage('error', 'Profile update failed!');
    header('Location: /pages/profile_edit.php');
}




?>