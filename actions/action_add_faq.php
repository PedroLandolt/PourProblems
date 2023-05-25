<?php
declare(strict_types=1);

require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/faq.class.php');

$db = getDatabaseConnection();

$question = strval($_POST['question']);
$answer = strval($_POST['answer']);
$agent_id = intval($_POST['agent_id']);


$stmt = $db->prepare('INSERT INTO FAQ (question, answer, user_id) VALUES (?, ?, ?)');

$stmt->execute(array($question, $answer, $agent_id));


header('Location: ' . $_SERVER['HTTP_REFERER']);
?>