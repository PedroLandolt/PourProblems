<?php

declare(strict_types=1);

require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/ticket.class.php');
require_once(__DIR__ . '/../database/ticket_user.class.php');

$db = getDatabaseConnection();

$add_ticket = true;

if(empty($_POST['department'])) {
  $session->addFieldError('department', 'Department is required!');
  $add_ticket = false;
}

if (empty($_POST['subject'])) {
  $session->addFieldError('subject', 'Subject is required!');
  $add_ticket = false;
}

if (empty($_POST['hashtag'])) {
  $session->addFieldError('hashtag', 'Hashtag is required!');
  $add_ticket = false;
}

if (empty($_POST['description'])) {
  $session->addFieldError('description', 'Description is required!');
  $add_ticket = false;
}

function save_in_uploads($temp_name, $name)
{
  $UPLOADS_DIR = __DIR__ . '/../uploads/tickets/';

  // get file extension
  $ext = explode('.', $name);

  // save in uploads folder
  $filename = uniqid() . '.' . $ext[count($ext) - 1];

  // move file to uploads folder
  move_uploaded_file($temp_name, $UPLOADS_DIR . $filename);

  return $filename;
}

$filenames = array();

$files = array_filter($_FILES['file']['name']);

// check if form has a files attached and save all files in uploads folder
if (!empty($files)) {
  // iterate over all files
  for ($i = 0; $i < count($files); $i++) {
    $file_name = $_FILES['file']['name'][$i];
    $file_size = $_FILES['file']['size'][$i];
    $temp_name = $_FILES['file']['tmp_name'][$i];

    // check if file was uploaded and if it's size is less than 1MB
    if (isset($file_name) && $file_size > 0 && $file_size < 1000000) {
      // save the file in uploads folder and push the filename to the array of filenames
      $new_filename = save_in_uploads($temp_name, $file_name);
      array_push($filenames, $new_filename);
    }
  }
}

if ($add_ticket) {

  $subject = strval($_POST['subject']);
  $description = strval($_POST['description']);
  $department = strval($_POST['department']);
  $status_id = 1;
  $hashtag = strval($_POST['hashtag']);
  
  $datetime = new DateTime();
  $datetime = $datetime->format('d-m-Y H:i');
  $datetime = strval($datetime);


  $update = strval($datetime) . ' - Ticket was created';

  $new_ticket_id = null;

  try {
    $stmt = $db->prepare('INSERT INTO Ticket (subject, description, datetime, department, status_id) VALUES (?, ?, ?, ?, ?)');
    $stmt->execute(array($subject, $description, $datetime, $department, $status_id));
    $new_ticket_id = $db->lastInsertId();
  } catch (PDOException $e) {
    $session->addMessage('RIP', 'No ticket!');
  }

  $client_id = $session->getID();
  $agent_id = 0;

  try {
    $stmt = $db->prepare('INSERT INTO Ticket_User (client_id, agent_id) VALUES (?, ?)');
    $stmt->execute(array($client_id, $agent_id));
  } catch (PDOException $e) {
    $session->addMessage('RIP', 'No ticket_user!');
  }

  try {
    foreach ($filenames as $filename) {
      $stmt = $db->prepare('INSERT INTO Ticket_Files (file_path, user_id, ticket_id) VALUES (?, ?, ?)');
      $stmt->execute(array($filename, $client_id, $new_ticket_id));
    }
  } catch (PDOException $e) {
    $session->addMessage('RIP', 'Cannot save files!');
  }

  try {
    $stmt = $db->prepare('INSERT INTO Ticket_History (updates, ticket_id) VALUES (?, ?)');
    $stmt->execute(array($update, $new_ticket_id));
  } catch (PDOException $e) {
    $session->addMessage('RIP', 'No ticket_history!');
  }

  try {
    $stmt = $db->prepare('INSERT INTO Hashtag (name, ticket_id) VALUES (?, ?)');
    $stmt->execute(array($hashtag, $new_ticket_id));
  } catch (PDOException $e) {
    $session->addMessage('RIP', 'No ticket!');
  }

  $session->addMessage('success', 'Ticket Submited!');
  header('Location: ' . $_SERVER['HTTP_REFERER']);
} else {
  $session->addMessage('error', 'The form was not filled correctly!');
  header('Location: ' . $_SERVER['HTTP_REFERER']);
}