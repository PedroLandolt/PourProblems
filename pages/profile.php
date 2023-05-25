<?php
declare(strict_types=1);

require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

if (!$session->isLoggedIn()) {
  header('Location: ../pages/login.php');
}

require_once(__DIR__ . '/../database/connection.db.php');

require_once(__DIR__ . '/../temp/common.tpl.php');

require_once(__DIR__ . '/../database/user.class.php');

$db = getDatabaseConnection();

drawHeader($session);

$encryptedId = str_replace("/pages/profile.php?id=", "", $_SERVER['REQUEST_URI']);

$id = base64_decode(($encryptedId));

$id_int = (int) $id;

$user_array = User::getUser($db, $id_int);

$role_num = $user_array->role_id;


if ($role_num == 1) {
  $role = "Admin";

} else if ($role_num == 2) {
  $role = "Agent";
} else {
  $role = "Client";
}

?>

<div class="custom-space"></div>

<div class="profile">

  <div class="profile_pic">
    <img src="../uploads/profiles/<?= $user_array->image_path ?>" alt="Profile Picture">
  </div>


  <div class="profile_info">
    <div class="title">
      <h1> Information </h1>
    </div>
    <table class="info">
      <tr>
        <th>Username:</th>
        <td>
          <?php echo $user_array->username; ?>
        </td>
      </tr>

      <tr>
        <th>Full Name:</th>
        <td>
          <?php echo $user_array->fullname; ?>
        </td>
      </tr>

      <tr>
        <th>Email:</th>
        <td>
          <?php echo $user_array->email; ?>
        </td>
      </tr>

      <tr>
        <th>Role:</th>
        <td>
          <?php echo $role; ?>
        </td>
      </tr>
    </table>

    <?php if ($user_array->id == $session->getID()) { ?>
    </div>
    <div class="edit_profile">
      <a href="/pages/profile_edit.php"><i class="fas fa-user-pen"></i></a>
    </div>
  <?php } else { ?>
  </div>
<?php } ?>

</div>
<section id="messages">
  <?php foreach ($session->getMessages() as $messsage) { ?>
    <p class="<?= $messsage['type'] ?>">
      <?= $messsage['text'] ?>
    </p>
  <?php } ?>
</section>

<div class="custom-space"></div>



<?php
drawFooter($session);
?>