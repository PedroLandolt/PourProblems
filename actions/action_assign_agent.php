<?php
declare(strict_types=1);

require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/user.class.php');

$db = getDatabaseConnection();

$ticket_id = $_POST['ticket_id'];
$agent_username = $_POST['agent'];
$datetime = new DateTime();
$datetime = $datetime->format('d-m-Y H:i');
$datetime = strval($datetime);
$update = $datetime . ' - Assigned to ' . $agent_username;

$agent = User::getUser_from_username($db, $agent_username);

$stmt = $db->prepare('UPDATE Ticket_User SET agent_id = ? WHERE ticket_id = ?');
$stmt->execute(array($agent->id, $ticket_id));


$stmt = $db->prepare('UPDATE Ticket SET status_id = ? WHERE id = ?');
$stmt->execute(array(2, $ticket_id));


$stmt = $db->prepare('INSERT INTO Ticket_History (updates, ticket_id) VALUES (?, ?)');
$stmt->execute(array($update, $ticket_id));

header('Location: ' . $_SERVER['HTTP_REFERER']);
?>