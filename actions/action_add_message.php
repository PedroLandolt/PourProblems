<?php
declare(strict_types=1);

require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/message.class.php');

$db = getDatabaseConnection();

$add_message = true;

if (empty($_POST['message'])) {
  $session->addFieldError('message', 'Message is required!');
  $add_message = false;
}


if ($add_message) {

  $text = strval($_POST['message']);
  $ticket_id = strval($_POST['ticket_id']);
  $user_id = strval($_POST['user_id']);
  $datetime = $_POST['datetime'];
  $url_id = strval($_POST['id']);

  
  if (isset($_POST['faq_answer'])) {
    $faqAnswer = strval($_POST['faq_answer']);
    if (!empty($faqAnswer)) {
      $text = $faqAnswer;
    }
  }
  


  $update = strval($datetime) . ' - Message was added to ticket';
  $new_message_id = null;

  try {
    $stmt = $db->prepare('INSERT INTO Message (text, datetime, user_id, ticket_id) VALUES (?, ?, ?, ?)');
    $stmt->execute(array($text, $datetime, $user_id, $ticket_id));
    $new_message_id = $db->lastInsertId();
    $session->addMessage('success', 'Message created successfully!');
  } catch (PDOException $e) {
    $session->addMessage('error', 'Error creating message!');
  }

  try {
    $stmt = $db->prepare('INSERT INTO Ticket_History (updates, ticket_id) VALUES (?, ?)');
    $stmt->execute(array($update, $ticket_id));
    $session->addMessage('success', 'Ticket_history updated successfully!');
  } catch (PDOException $e) {
    $session->addMessage('error', 'Error updating ticket!');
  }


  header('Location: ../pages/ticket.php?id=' . $url_id);
} else {
  header('Location: ../pages/ticket.php?id=' . $url_id);
}
?>