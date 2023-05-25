<?php
declare(strict_types=1);

require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

require_once(__DIR__ . '/../database/connection.db.php');

$db = getDatabaseConnection();

$ticket_id = $_POST['ticket_id'];
$department_name = $_POST['department'];
$datetime = new DateTime();
$datetime = $datetime->format('d-m-Y H:i');
$datetime = strval($datetime);
$update = $datetime . ' - Changed to ' . $department_name . ' department';

$stmt = $db->prepare('UPDATE Ticket SET department = ? WHERE id = ?');
$stmt->execute(array($department_name, $ticket_id));

$stmt = $db->prepare('INSERT INTO Ticket_History (updates, ticket_id) VALUES (?, ?)');
$stmt->execute(array($update, $ticket_id));

header('Location: ' . $_SERVER['HTTP_REFERER']);
?>