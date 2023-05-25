<?php
declare(strict_types=1);

require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/department.class.php');

$db = getDatabaseConnection();

$name = strval($_POST['name']);

if ($name == "") {
  header('Location: ' . $_SERVER['HTTP_REFERER']);
  echo "Insert a department name, please";
} else {
  $stmt = $db->prepare('INSERT INTO Department (name) VALUES (?)');

  $stmt->execute(array($name));
}


header('Location: ' . $_SERVER['HTTP_REFERER']);
?>