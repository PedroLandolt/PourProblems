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
    <h1>Edit your profile</h1>
</div>


<div class="profile-edit-form">
    <form action="/actions/action_profile_edit.php" method="post" enctype="multipart/form-data" class="pform-edit">

        <div class="changes">
            <div class="profile-edit-img">
                <img src="/uploads/profiles/<?= $user->image_path ?>" alt="Profile Image">
                <div class="files-box">
                    <label for="file-image">Edit Profile Image<br />
                        <i class="fa fa-2x fa-camera"></i>
                        <input type="file" name="file" id="file-image" class="inputfile" multiple
                            pattern=".*\.(jpe?g|png)$" accept=".jpg,.jpeg,.png">
                        <br />
                        <span class="file-name" id="file-image-name"></span>
                    </label>
                </div>
            </div>

            <div class="profile-edit-info">

                <div class="title">
                    <h1> Information </h1>
                </div>

                <div class="info">
                    <div class="input-box">
                        <label for="username">Username</label>
                        <input type="text" name="username" id="username" placeholder="Username"
                            value="<?= $user->username ?>"
                            data-state="<?php if (isset($errorFields['username'])) { ?>invalid<?php } ?>">
                        <?php if (isset($errorFields['username'])) { ?>
                            <p class="text-danger">
                                <?= $errorFields['username'] ?>
                            </p>
                        <?php } ?>
                    </div>

                    <div class="input-box">
                        <label for="fullname">Name</label>
                        <input type="text" name="fullname" id="fullname" placeholder="Full Name"
                            value="<?= $user->fullname ?>"
                            data-state="<?php if (isset($errorFields['fullname'])) { ?>invalid<?php } ?>">
                        <?php if (isset($errorFields['fullname'])) { ?>
                            <p class="text-danger">
                                <?= $errorFields['fullname'] ?>
                            </p>
                        <?php } ?>
                    </div>


                    <div class="input-box">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" placeholder="Email" value="<?= $user->email ?>"
                            data-state="<?php if (isset($errorFields['email'])) { ?>invalid<?php } ?>">
                        <?php if (isset($errorFields['email'])) { ?>
                            <p class="text-danger">
                                <?= $errorFields['email'] ?>
                            </p>
                        <?php } ?>
                    </div>

                </div>
            </div>
        </div>

        <div class="confirm">
            <div class="confirm-passwords">
                <div class="input-box">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" placeholder="Password"
                        data-state="<?php if (isset($errorFields['password'])) { ?>invalid<?php } ?>">
                    <?php if (isset($errorFields['password'])) { ?>
                        <p class="text-danger">
                            <?= $errorFields['password'] ?>
                        </p>
                    <?php } ?>
                </div>
                <div class="input-box">
                    <label for="confirm_password">Confirm Password</label>
                    <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm Password"
                        data-state="<?php if (isset($errorFields['confirm_password'])) { ?>invalid<?php } ?>">
                    <?php if (isset($errorFields['confirm_password'])) { ?>
                        <p class="text-danger">
                            <?= $errorFields['confirm_password'] ?>
                        </p>
                    <?php } ?>
                </div>
            </div>
            <div class="confirm-button">
                <input type="submit" value="Save Changes" class="btn" name="Save">
            </div>
        </div>
    </form>



</div>

<div class="final-links">
    <div class="delete">
        <form action="../actions/action_delete_user.php" method="post" class="delete">
            <input type="hidden" name="user_id" value="<?= $user->id ?>">
            <button type="submit" value="Delete User"><i class="fas fa-trash-alt"></i> Delete Account</button>
        </form>
    </div>
    <div class="password-change">
        <a href="/pages/password_change.php" class="change-password">Change Password</a>
    </div>
    <div class="back">
        <a href="/pages/profile.php?id=<?= base64_encode(strval($session->getID())) ?>" class="back-profile">Back to
            Profile <i class="fas fa-arrow-right"></i></a>
    </div>
</div>

<?= drawFooter($session); ?>