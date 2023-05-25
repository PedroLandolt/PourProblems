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

<section class="forgot-password">
  <div class="logo">
    <img src="../sources/PourProblems_Logo_Gray.png" alt="logo">
  </div>

  <div class="forgot-password-input">
    <h2 class="title">Forgot Password</h2>
    <form action="/actions/action_forgot_password.php" method="post" class="forgot-password-form">

      <!-- Forgot password text -->
      <p>We understand that sometimes it's easy to forget your password, and we're here to assist you in recovering it.
        If you're having trouble accessing your account, simply enter your registered email address in the provided
        field. We'll send you an email with instructions on how to reset your password securely. Please ensure that the
        email address you enter is the same one associated with your PourProblems account. If you
        don't receive the password reset email within a few minutes, please check your spam folder or try again. At
        PourProblems, we prioritize the security of your account information. Rest assured that your personal details
        will be handled with utmost confidentiality during the password recovery process.
      </p>
      <!-- Email -->
      <div class="input-box">
        <input type="email" name="email" placeholder="email"
          data-state="<?php if (isset($errorFields['email'])) { ?>invalid<?php } ?>">
        <?php if (isset($errorFields['email'])) { ?>
          <p class="text-danger">
            <?= $errorFields['email'] ?>
          </p>
        <?php } ?>
      </div>

      <!-- Forgot password button -->
      <div class="forgot-password-options">
        <button type="submit"><span class="forgot-password-btn"><i class="fas fa-arrow-right"></i></span></button>
        <div class="forgot-password-links">
          <a class="go-back" href="/pages/login.php">Back To Login <i class="fas fa-arrow-right"></i></a>
        </div>
      </div>

    </form>
  </div>
</section>




<?php
drawFooter($session);
?>