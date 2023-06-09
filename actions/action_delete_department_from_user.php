<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../utils/session.php');
  $session = new Session();

  require_once(__DIR__ . '/../database/connection.db.php');

  $db = getDatabaseConnection();

  $user_id = $_POST['user_id'];
  $department_id = $_POST['department_id'];


  $stmt = $db->prepare('DELETE FROM User_Department WHERE user_id = ? and department_id = ?');
  $stmt->execute(array($user_id, $department_id));


  header('Location: ' . $_SERVER['HTTP_REFERER']);
?>