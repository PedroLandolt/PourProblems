<?php
declare(strict_types=1);

require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/user.class.php');


$db = getDatabaseConnection();

$id = $_POST['user_id'];


//pass id to int
$id = (int) $id;

//get role of user
$user = User::getUser($db, $id);
$role = $user->role_id;

// logs out
if ($id == $session->getId()) {
    $session->logout();
    $stmt = $db->prepare('DELETE FROM User WHERE id = ?');
    $stmt->execute(array($id));

    if($role == 2){
        $stmt = $db->prepare('DELETE FROM Ticket_User WHERE agent_id = ?');
        $stmt->execute(array($id));
    }
    else if ($role == 3){
        $stmt = $db->prepare('DELETE FROM Ticket_User WHERE client_id = ?');
        $stmt->execute(array($id));
    }

    $stmt = $db->prepare('DELETE FROM User_Department WHERE user_id = ?');
    $stmt->execute(array($id));

    $stmt = $db->prepare('DELETE FROM Ticket_Files WHERE user_id = ?');
    $stmt->execute(array($id));

    $stmt = $db->prepare('DELETE FROM FAQ WHERE user_id = ?');
    $stmt->execute(array($id));

    $stmt = $db->prepare('DELETE FROM Message WHERE user_id = ?');
    $stmt->execute(array($id));


    header('Location: ../pages/index.php');

} else {
    $stmt = $db->prepare('DELETE FROM User WHERE id = ?');
    $stmt->execute(array($id));

    if($role == 2){
        $stmt = $db->prepare('DELETE FROM Ticket_User WHERE agent_id = ?');
        $stmt->execute(array($id));
    }
    else if ($role == 3){
        $stmt = $db->prepare('DELETE FROM Ticket_User WHERE client_id = ?');
        $stmt->execute(array($id));
    }

    $stmt = $db->prepare('DELETE FROM User_Department WHERE user_id = ?');
    $stmt->execute(array($id));

    $stmt = $db->prepare('DELETE FROM Ticket_Files WHERE user_id = ?');
    $stmt->execute(array($id));

    $stmt = $db->prepare('DELETE FROM FAQ WHERE user_id = ?');
    $stmt->execute(array($id));

    $stmt = $db->prepare('DELETE FROM Message WHERE user_id = ?');
    $stmt->execute(array($id));

    header('Location: ' . $_SERVER['HTTP_REFERER']);
}



?>