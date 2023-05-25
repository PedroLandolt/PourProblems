<?php
declare(strict_types=1);

require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

if (!$session->isLoggedIn()) {
  header('Location: ../pages/login.php');
}

require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../temp/common.tpl.php');
require_once(__DIR__ . '/../database/ticket_user.class.php');
require_once(__DIR__ . '/../database/ticket.class.php');
require_once(__DIR__ . '/../database/status.class.php');
require_once(__DIR__ . '/../database/department.class.php');
require_once(__DIR__ . '/../database/hashtag.class.php');


$db = getDatabaseConnection();

drawHeader($session);

$departments = Department::getDepartments($db);

$hashtags = Hashtag::getHashtags($db);

$errorFields = $session->getFieldErrors();

?>


<div class="heading" style="background: url('../sources/heading_bg/submit-ticket.jpg');">
  <h1> Create a Ticket </h1>
</div>

<div class="submit-ticket">
  <div class="title">
    <h1 class="submit-ticket-title">Submit a Ticket</h1>
    <p class="submit-ticket-description">
      Greetings, wine enthusiasts! <br> If you're grappling with wine-related conundrums, Pour Problems is here to offer
      a
      helping hand. <br> Submit your ticket to receive professional advice and solutions tailored to your wine woes.
      <br> Let's
      uncork the expertise and raise a glass to resolving those challenges with finesse.
    </p>
  </div>

  <div class="submit-ticket-body">
    <div class="submit-ticket-body-title">
      <span>DETAILS</span>
    </div>
    <div class="submit-ticket-form">
      <form action="/actions/action_add_ticket.php" method="post" class="submit-ticket-form"
        enctype="multipart/form-data">

        <div class="submit-ticket-form-input">
          <label>Department</label>
          <select class="departments" name="department">
            <option value="" disabled selected>-</option>
            <?php foreach ($departments as $department) { ?>
              <option value="<?= $department->name ?>"> <?= $department->name ?> </option>
            <?php } ?>
          </select>
          <?php if (isset($errorFields['department'])) { ?>
            <p class="text-danger">
              <?= $errorFields['department'] ?>
            </p>
          <?php } ?>
        </div>

        <div class="submit-ticket-form-input">
          <label>Subject</label>
          <input type="text" name="subject" placeholder="Enter the subject">
          <?php if (isset($errorFields['subject'])) { ?>
            <p class="text-danger">
              <?= $errorFields['subject'] ?>
            </p>
          <?php } ?>
        </div>

        <div class="submit-ticket-form-input">
          <label>Hashtag</label>
          <input name="hashtag" list="hashtags" placeholder="Enter some hashtags">
          <datalist id="hashtags">
            <?php foreach ($hashtags as $hashtag) { ?>
              <option value="<?= $hashtag->name ?>"> <?= $hashtag->name ?> </option>
            <?php } ?>
          </datalist>
          <?php if (isset($errorFields['hashtag'])) { ?>
            <p class="text-danger">
              <?= $errorFields['hashtag'] ?>
            </p>
          <?php } ?>
        </div>


        <div class="submit-ticket-form-input">
          <label>Description</label>
          <textarea name="description" placeholder="Enter your message"></textarea>
          <?php if (isset($errorFields['description'])) { ?>
            <p class="text-danger">
              <?= $errorFields['description'] ?>
            </p>
          <?php } ?>
        </div>

        <div class="submit-ticket-form-input">
          <label class="upload-files" for="up_files">Upload files
            <i class="far fa-file-alt"></i>
            <input type="file" name="file[]" id="up_files" class="files" multiple pattern=".*\.(jpe?g|png|pdf)$"
              accept=".jpg,.jpeg,.png,.pdf">
            <br>
          </label>
          <ul id="file-list"></ul>
        </div>

        <div class="submit-ticket-form-input">
          <div class="air-button">
            <button type="submit" class="btn">Submit</button>
          </div>
        </div>

      </form>
    </div>
  </div>
  <section id="messages">
    <?php foreach ($session->getMessages() as $messsage) { ?>
      <p class="<?= $messsage['type'] ?>">
        <?= $messsage['text'] ?>
      </p>
    <?php } ?>
  </section>
</div>

<div class="final-links">
  <div class="mytickets-back">
    <a href="/pages/mytickets.php" class="my-tickets-back"><i class="fas fa-arrow-left"></i> My Tickets</a>
  </div>
  <div class="back">
    <a href="/pages/profile.php?id=<?= base64_encode(strval($session->getID())) ?>" class="back-profile">Profile <i
        class="fas fa-arrow-right"></i></a>
  </div>
</div>


<?php
drawFooter($session);
?>