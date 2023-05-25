<?php
declare(strict_types=1);

require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

// Can't access login page if already logged in
if ($session->isLoggedIn()) {
  header('Location: ../pages/home.php');
}

require_once(__DIR__ . '/../database/connection.db.php');

require_once(__DIR__ . '/../temp/common.tpl.php');

$db = getDatabaseConnection();

drawHeader($session);
?>

<!-- get fields erros -->
<?php
$errorFields = $session->getFieldErrors();
?>



<section class="signup">

  <div class="logo">
    <img src="../sources/PourProblems_Logo_Gray.png" alt="logo">
  </div>

  <div class="signup-input">
    <h2 class="title">SignUp</h2>
    <form action="/actions/action_register.php" method="post" class="signup-form">

      <div class="input-box">
        <input type="text" name="full_name" placeholder="enter your full name"
          data-state="<?php if (isset($errorFields['full_name'])) { ?>invalid<?php } ?>">
        <?php if (isset($errorFields['full_name'])) { ?>
          <p class="text-danger">
            <?= $errorFields['full_name'] ?>
          </p>
        <?php } ?>
      </div>

      <div class="input-box">
        <input type="text" name="username" placeholder="enter your username"
          data-state="<?php if (isset($errorFields['username'])) { ?>invalid<?php } ?>">
        <?php if (isset($errorFields['username'])) { ?>
          <p class="text-danger">
            <?= $errorFields['username'] ?>
          </p>
        <?php } ?>
      </div>

      <div class="input-box">
        <input type="email" name="email" placeholder="enter your email"
          data-state="<?php if (isset($errorFields['email'])) { ?>invalid<?php } ?>">
        <?php if (isset($errorFields['email'])) { ?>
          <p class="text-danger">
            <?= $errorFields['email'] ?>
          </p>
        <?php } ?>
      </div>

      <div class="input-box">
        <input type="password" name="password" placeholder="enter your password"
          data-state="<?php if (isset($errorFields['password'])) { ?>invalid<?php } ?>">
        <?php if (isset($errorFields['password'])) { ?>
          <p class="text-danger">
            <?= $errorFields['password'] ?>
          </p>
        <?php } ?>
      </div>

      <div class="input-box">
        <input type="password" name="confirm_password" placeholder="confirm your password"
          data-state="<?php if (isset($errorFields['confirm_password'])) { ?>invalid<?php } ?>">
        <?php if (isset($errorFields['confirm_password'])) { ?>
          <p class="text-danger">
            <?= $errorFields['confirm_password'] ?>
          </p>
        <?php } ?>
      </div>

      <div class="signup-options">
        <button type="submit"><span class="signup-btn"><i class="fas fa-arrow-right"></i></span></button>
        <div class="signup-links">
          <a class="alredy-signup" href="/pages/login.php">Already have an Acount?</a>
        </div>
      </div>

      <section id="messages">
        <?php foreach ($session->getMessages() as $messsage) { ?>
          <article class="<?= $messsage['type'] ?>">
            <?= $messsage['text'] ?>
          </article>
        <?php } ?>
      </section>
    </form>
  </div>

</section>


<?php
drawFooter($session);
?>