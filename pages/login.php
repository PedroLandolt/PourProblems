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

<section class="login">
  <div class="logo">
    <img src="../sources/PourProblems_Logo_Gray.png" alt="logo">
  </div>


  <div class="login-input">
    <h2 class="title">Login</h2>
    <form action="/actions/action_login.php" method="post" class="login-container">

      <!-- Email and password -->
      <div class="input-box">
        <input type="email" name="email" placeholder="email"
          data-state="<?php if (isset($errorFields['email'])) { ?>invalid<?php } ?>">
        <?php if (isset($errorFields['email'])) { ?>
          <p class="text-danger">
            <?= $errorFields['email'] ?>
          </p>
        <?php } ?>
      </div>

      <div class="input-box">
        <input type="password" name="password" placeholder="password"
          data-state="<?php if (isset($errorFields['password'])) { ?>invalid<?php } ?>">
        <?php if (isset($errorFields['password'])) { ?>
          <p class="text-danger">
            <?= $errorFields['password'] ?>
          </p>
        <?php } ?>
      </div>

      <div class="login-options">
        <!-- Login button -->
        <button type="submit"><span class="login-btn"><i class="fas fa-arrow-right"></i></span></button>

        <!-- Stay logged in -->
        <div class="stay-logged-in">
          <input type="checkbox" id="stay_logged_in_check" value="true">
          <label for="stay_logged_in_check">Stay logged in</label>
        </div>
      </div>

      <!-- Links -->
      <div class="login-links">
        <a class="forgot-password-login" href="/pages/forgot_password.php">Forgot your password?</a>
        <a class="register-login" href="/pages/signup.php">Don't have an account?</a>
      </div>

      <section id="messages">
        <?php foreach ($session->getMessages() as $messsage) { ?>
          <p class="<?= $messsage['type'] ?>">
            <?= $messsage['text'] ?>
          </p>
        <?php } ?>
      </section>

    </form>
  </div>
</section>


<?php
drawFooter($session);
?>