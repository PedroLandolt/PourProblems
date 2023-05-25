<?php
declare(strict_types=1);

require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/role.class.php');
require_once(__DIR__ . '/../database/user.class.php');

$db = getDatabaseConnection();

$user_id = (int) $_POST['user_id'];
$role_id = (int) $_POST['role_id'];

if($role_id == 3) {
    $stmt = $db->prepare('DELETE FROM User_Department WHERE user_id = ?');
    $stmt->execute(array($user_id));
}

$user = User::getUser($db, $user_id);

$user->role_id = $role_id;

$user->save($db);

header('Location: ' . $_SERVER['HTTP_REFERER']);
?>