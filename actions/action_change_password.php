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
if (empty($_POST['old_password'])) {
    $session->addFieldError('password', 'Password is required!');
    $update_profile_success = false;
}

if (empty($_POST['new_password'])) {
    $session->addFieldError('new_password', 'New password is required!');
    $update_profile_success = false;
}

if (empty($_POST['confirm_password'])) {
    $session->addFieldError('confirm_password', 'Confirm password is required!');
    $update_profile_success = false;
}

if (!password_verify($_POST['old_password'], $user->getPassword())) {
    $session->addFieldError('old_password', 'Old password is incorrect!');
    $update_profile_success = false;
}

if ($_POST['new_password'] != $_POST['confirm_password']) {
    $session->addFieldError('password', 'Passwords do not match!');
    $session->addFieldError('confirm_password', 'Passwords do not match!');
    $update_profile_success = false;
}

if($_POST['new_password'] == $_POST['old_password']) {
    $session->addFieldError('new_password', 'New password cannot be the same as old password!');
    $session->addFieldError('confirm_password', 'New password cannot be the same as old password!');
    $update_profile_success = false;
}




if ($update_profile_success) {

    $password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);

    try {
        $user->updateUserPassword($db, $password);
        $session->addMessage('success', 'Password updated successfully!');
        header('Location: /pages/profile.php?id=' . $encryptedId);
    } catch (Exception $e) {
        $session->addMessage('error', $e->getMessage());
        header('Location: /pages/profile.php?id=' . $encryptedId);
    }
} else {
    $session->addMessage('error', 'Password update failed!');
    header('Location: /pages/password_change.php');
}




?>