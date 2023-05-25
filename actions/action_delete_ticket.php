<?php
declare(strict_types=1);

require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/ticket.class.php');
require_once(__DIR__ . '/../database/ticket_user.class.php');

$db = getDatabaseConnection();

$ticket_id = $_POST['ticket_id'];
$id = $_POST['id'];

$stmt = $db->prepare('DELETE FROM Ticket_User WHERE ticket_id = ?');
$stmt->execute(array($ticket_id));

$stmt = $db->prepare('DELETE FROM Ticket WHERE id = ?');
$stmt->execute(array($id));


header('Location: ' . $_SERVER['HTTP_REFERER']);
?>