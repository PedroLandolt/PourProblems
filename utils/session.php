<?php
require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../database/user.class.php');
class Session
{
  private array $messages;
  private array $fieldErrors;

  public function __construct()
  {
    session_start();

    $this->messages = isset($_SESSION['messages']) ? $_SESSION['messages'] : array();
    unset($_SESSION['messages']);
    $this->fieldErrors = isset($_SESSION['fieldErrors']) ? $_SESSION['fieldErrors'] : array();
    unset($_SESSION['fieldErrors']);
  }

  public function isLoggedIn(): bool
  {
    return isset($_SESSION['id']);
  }


  public function isAdmin() : bool {
    $db = getDatabaseConnection();
    $user = User::getUser($db, $_SESSION['id']);
    return $user->role_id == 1;     
    }

  public function isAgent() : bool {
    $db = getDatabaseConnection();
    $user = User::getUser($db, $_SESSION['id']);
    return $user->role_id == 2;
  }

  public function logout()
  {
    session_destroy();
  }

  public function getId(): ?int
  {
    return isset($_SESSION['id']) ? $_SESSION['id'] : null;
  }

  public function getName(): ?string
  {
    return isset($_SESSION['fullname']) ? $_SESSION['fullname'] : null;
  }

  public function setId(int $id)
  {
    $_SESSION['id'] = $id;
  }

  public function setName(string $fullname)
  {
    $_SESSION['fullname'] = $fullname;
  }

  public function getUsername(): ?string
  {
    return isset($_SESSION['username']) ? $_SESSION['username'] : null;
  }

  public function setUsername(string $username)
  {
    $_SESSION['username'] = $username;
  }

  public function addMessage(string $type, string $text)
  {
    $_SESSION['messages'][] = array('type' => $type, 'text' => $text);
  }

  public function addFieldError(string $fieldName, string $errorMessage)
  {
    $_SESSION['fieldErrors'][$fieldName] = $errorMessage;
  }

  public function hasFieldErrors(): bool
  {
    return isset($_SESSION['fieldErrors']);
  }

  public function getFieldErrors(): ?array
  {
    return $this->fieldErrors;
  }

  public function getMessages()
  {
    return $this->messages;
  }
}
?>