<?php
declare(strict_types=1);



function getDatabaseConnection(): PDO
{
  $db = new PDO('sqlite:' . __DIR__ . '/database.db');
  $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  return $db;
}

/* Get user by username */
function getUserByUsername(string $username): ?User
{
  $db = getDatabaseConnection();

  $stmt = $db->prepare('SELECT * FROM User WHERE username = ?');
  $stmt->execute([$username]);
  $user = $stmt->fetch();

  if ($user === false) {
    return null;
  }

  return new User($user['id'], $user['fullname'], $user['username'], $user['email'], $user['password'], $user['role_id']);
}

/* Get user by email */
function getUserByEmail(string $email): ?User
{
  $db = getDatabaseConnection();

  $stmt = $db->prepare('SELECT * FROM User WHERE email = ?');
  $stmt->execute([$email]);
  $user = $stmt->fetch();

  if ($user === false) {
    return null;
  }

  return new User($user['id'], $user['fullname'], $user['username'], $user['email'], $user['password'], $user['role_id']);
}

?>