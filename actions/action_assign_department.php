<?php
  declare(strict_types = 1);

  require_once(__DIR__ . '/../utils/session.php');
  $session = new Session();

  require_once(__DIR__ . '/../database/connection.db.php');
  require_once(__DIR__ . '/../database/department.class.php');

  $db = getDatabaseConnection();

  $user_id = $_POST['user_id'];
  $department_name = $_POST['department'];

  $department = Department::getDepartment_from_name($db, $department_name);

  $stmt = $db->prepare('INSERT INTO User_Department (user_id, department_id) VALUES (?, ?)');
  $stmt->execute(array($user_id, $department->id));



  header('Location: ' . $_SERVER['HTTP_REFERER']);
?>