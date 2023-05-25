<?php
declare(strict_types=1);

require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/faq.class.php');

$db = getDatabaseConnection();

$id = $_POST['faq_id'];

$stmt = $db->prepare('DELETE FROM FAQ WHERE id = ?');
$stmt->execute(array($id));


header('Location: ' . $_SERVER['HTTP_REFERER']);
?>