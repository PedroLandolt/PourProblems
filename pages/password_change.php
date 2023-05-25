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

$user = User::getUser($db, $session->getId());

drawHeader($session);
?>

<!-- get fields erros -->
<?php
$errorFields = $session->getFieldErrors();
?>

<div class="profile-edit-title">
    <h1>Change Password</h1>
</div>

<div class="password-edit">
    <form action="../actions/action_change_password.php" method="post">
        <div class="input-boxes">
            <div class="password-edit-input">
                <label for="old_password">Old Password</label>
                <input type="password" name="old_password" id="old_password"
                    data-state="<?php if (isset($errorFields['old_password'])) { ?>invalid<?php } ?>">
                <?php if (isset($errorFields['old_password'])) { ?>
                    <p class="text-danger">
                        <?= $errorFields['old_password'] ?>
                    </p>
                <?php } ?>
            </div>

            <div class="password-edit-input">
                <label for="new_password">New Password</label>
                <input type="password" name="new_password" id="new_password"
                    data-state="<?php if (isset($errorFields['new_password'])) { ?>invalid<?php } ?>">
                <?php if (isset($errorFields['new_password'])) { ?>
                    <p class="text-danger">
                        <?= $errorFields['new_password'] ?>
                    </p>
                <?php } ?>
            </div>

            <div class="password-edit-input">
                <label for="confirm_password">Confirm New Password</label>
                <input type="password" name="confirm_password" id="confirm_password"
                    data-state="<?php if (isset($errorFields['confirm_password'])) { ?>invalid<?php } ?>">
                <?php if (isset($errorFields['confirm_password'])) { ?>
                    <p class="text-danger">
                        <?= $errorFields['confirm_password'] ?>
                    </p>
                <?php } ?>
            </div>
        </div>

        <div class="profile-edit-input">
            <input type="submit" value="Change Password" class="btn">
        </div>
    </form>
</div>


<div class="final-links">
    <div class="go-back">
        <a href="/pages/profile_edit.php" class="back-profile"><i class="fas fa-arrow-left"></i> Back to Edit
            Profile</a>
    </div>

    <div class="back-profile">
        <a href="/pages/profile.php?id=<?= base64_encode(strval($session->getID())) ?>" class="back-profile">Back to
            Profile <i class="fas fa-arrow-right"></i></a>
    </div>
</div>

<?= drawFooter($session); ?>