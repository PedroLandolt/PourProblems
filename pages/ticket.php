<?php
declare(strict_types=1);

require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

if (!$session->isLoggedIn()) {
  header('Location: ../pages/login.php');
}

if (strpos($_SERVER['REQUEST_URI'], 'id=') === false) {
  if ($session->isAgent()) {
    header('Location: ../pages/assigned_tickets.php');
  } else if ($session->isAdmin()) {
    header('Location: ../pages/tickets.php');
  } else {
    header('Location: ../pages/mytickets.php');
  }
}

require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../temp/common.tpl.php');
require_once(__DIR__ . '/../database/ticket.class.php');
require_once(__DIR__ . '/../database/status.class.php');
require_once(__DIR__ . '/../database/ticket_user.class.php');
require_once(__DIR__ . '/../database/message.class.php');
require_once(__DIR__ . '/../database/user.class.php');
require_once(__DIR__ . '/../database/hashtag.class.php');
require_once(__DIR__ . '/../database/department.class.php');
require_once(__DIR__ . '/../database/faq.class.php');


$db = getDatabaseConnection();

drawHeader($session);

$encryptedId = str_replace("/pages/ticket.php?id=", "", $_SERVER['REQUEST_URI']);

$id = base64_decode(($encryptedId));

$id_int = (int) $id;

$ticket = Ticket::getTicket($db, $id_int);

$status = Status::getStatus($db, $ticket->status_id);

$ticket_user = Ticket_User::getTicket_User($db, $ticket->id);

$hashtags = Hashtag::getHashtags_from_ticket($db, $ticket->id);

$all_status = Status::getAll_Status($db);

$agents = User::getAgents($db, 2);

$departments = Department::getDepartments($db);

$faqs = FAQ::getFAQs($db);

$messages = Message::getMessages_from_ticket($db, $ticket->id);

if ($ticket_user->agent_id == NULL) {
  $agent_username = 'No Agent Assigned';
} else {
  $agent = User::getUser($db, $ticket_user->agent_id);

  $agent_username = $agent->username;
}


?>


<div class="ticket-conteiner">

  <div class="ticket-content">

    <div class="ticket-structure">

      <div class="ticket-top-bar">
        <div class="see-all-tickets">
          <?php
          if ($session->isAgent()) {
            ?>
            <a href="../pages/assigned_tickets.php"><i class="fas fa-arrow-left"></i> Assigned tickets</a>
            <?php
          } else if ($session->isAdmin()) {
            ?>
              <a href="../pages/tickets.php"><i class="fas fa-arrow-left"></i> All tickets</a>
            <?php
          } else {
            ?>
              <a href="../pages/mytickets.php"><i class="fas fa-arrow-left"></i> My tickets</a>
            <?php
          }
          ?>
        </div>
      </div>

      <div class="ticket-side-bar">
        <ul class="ticket-info">
          <li>
            <div class="ticket-info-title">Ticket ID</div>
            <div class="ticket-info-content">#
              <?= $ticket->id ?>
            </div>
          </li>
          <li>
            <div class="ticket-info-title">Created</div>
            <div class="ticket-info-content">
              <?= $ticket->datetime ?>
            </div>
          </li>
          <li>
            <div class="ticket-info-title">Last Update</div>
            <!-- Calculate time since last update to ticket -->
            <?php
            $time_since_last_update = Ticket::getDiffFromLastUpdateAndNow($db, $ticket->id);
            ?>
            <div class="ticket-info-content">
              <?= $time_since_last_update ?>
            </div>
          </li>
          <li>
            <div class="ticket-info-title">Department</div>
            <div class="ticket-info-content">
              <?= $ticket->department ?>
            </div>
          </li>
          <li>
            <div class="ticket-info-title">Status</div>
            <div class="ticket-info-content">
              <?= $status->stat ?>
            </div>
          </li>
          <li>
            <div class="ticket-info-title">Hashtag</div>
            <div class="ticket-info-content">
              <?php foreach ($hashtags as $hashtag) { ?>
                <p>
                  <?= $hashtag->name ?>
                </p>
              <?php } ?>
          </li>
        </ul>
      </div>

      <div class="ticket-main">
        <div class="ticket-main-header">

          <h1>
            <?= $ticket->subject ?>
          </h1>

          <div class="ticket-main-description">
            <p>
              <?= $ticket->description ?>
            </p>

            <div>
              <p>
                <?php if (count($ticket->files) == 0) {
                  echo "No files attached";
                } else {
                  echo "Files attached: " . count($ticket->files);
                } ?>
              </p>
            </div>
            <div class="ticket-main-files">
              <?php foreach ($ticket->files as $file) { ?>

                <a class="file" href="/uploads/tickets/<?= $file['file_path'] ?>" target="_blank"
                  rel="noopener noreferrer">
                  <?php
                  // check if file is an image from the file extension
                  $file_extension = pathinfo($file['file_path'], PATHINFO_EXTENSION);
                  if (in_array($file_extension, ['jpg', 'jpeg', 'png', 'gif'])) { ?>
                    <img src="/uploads/tickets/<?= $file['file_path'] ?>" alt="" width="auto" height="100px">
                  <?php } else { ?>
                    <div class="file-icon">
                      <i class="fas fa-file"></i>
                    </div>
                  <?php } ?>
                </a>
              <?php } ?>
            </div>
          </div>
        </div>



        <div class="ticket-main-messages">
          <?php
          if ($messages == NULL) { ?>
            <h2>No messages yet</h2>
          <?php } else {

            foreach ($messages as $message) {
              $user = User::getUser($db, $message->user_id);
              ?>
              <div class="ticket-message-conteiner">
                <div class="ticket-message-header">
                  <div class="ticket-message-author">
                    <div class="ticket-message-author-img">
                      <img src="../uploads/profiles/<?= $user->image_path ?>" alt="">
                    </div>
                    <div class="ticket-message-info">
                      <div class="ticket-message-author-name">
                        <?= $user->username ?>
                      </div>
                      <div class="ticket-message-date">
                        <?= $message->datetime ?>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="ticket-message-body">
                  <p>
                    <?= $message->text ?>
                  </p>
                </div>
              </div>
            <?php }
          } ?>
        </div>

        <div class="ticket-main-footer">
          <form action="/actions/action_add_message.php" method="post" enctype="multipart/form-data">
            <div class="ticket-main-footer-input">
              <label>New Message</label>
              <textarea name="message" placeholder="Enter your message"></textarea>
              <input type="hidden" name="ticket_id" value="<?= $ticket->id ?>">
              <input type="hidden" name="user_id" value="<?= $session->getID() ?>">
              <input type="hidden" name="datetime" value="
                <?php
                $datetime = new DateTime();
                $datetime = $datetime->format('d-m-Y H:i');
                $datetime = strval($datetime);
                echo $datetime ?>">
              <input type="hidden" name="id" value="<?= $encryptedId ?>">
              <?php if (isset($errorFields['description'])) { ?>
                <p class="text-danger">
                  <?= $errorFields['description'] ?>
                </p>
              <?php } ?>
            </div>

            <div class="ticket-main-footer-submit">
              <button type="submit" class="btn">Submit</button>
            </div>
          </form>
        </div>

        <?php
        // only agents and admins can see the change info
        if ($session->isAdmin() || $session->isAgent()) { ?>
          <div class="ticket-main-change">
            <div class="ticket-main-change-info">
              <div class="ticket-main-change-info-property">

                <div class="ticket-main-change-status">
                  <form action="/actions/action_change_status.php" method="post">
                    <input type="hidden" name="ticket_id" value="<?= $ticket->id ?>">
                    <select id="status" name="status">
                      <?php foreach ($all_status as $status) { ?>
                        <option value="<?= $status->stat ?>"> <?= $status->stat ?> </option>
                      <?php } ?>
                    </select>
                    <button type="submit" value="Change Status"><i class="fa fa-check"
                        aria-hidden="true"></i></i></button>

                  </form>
                </div>



                <div class="ticket-main-change-agent">
                  <form action="/actions/action_assign_agent.php" method="post">
                    <input type="hidden" name="ticket_id" value="<?= $ticket->id ?>">
                    <select id="agent" name="agent">
                      <?php foreach ($agents as $agent) { ?>
                        <option value="<?= $agent->username ?>"> <?= $agent->username ?> </option>
                      <?php } ?>
                    </select>
                    <button type="submit" value="Change Agent"><i class="fa fa-check" aria-hidden="true"></i></i></button>

                  </form>
                </div>


                <div class="ticket-main-change-department">
                  <form action="/actions/action_change_department.php" method="post">
                    <input type="hidden" name="ticket_id" value="<?= $ticket->id ?>">
                    <select id="department" name="department">
                      <?php foreach ($departments as $department) { ?>
                        <option value="<?= $department->name ?>"> <?= $department->name ?> </option>
                      <?php } ?>
                    </select>
                    <button type="submit" value="Change Department"><i class="fa fa-check"
                        aria-hidden="true"></i></i></button>

                  </form>
                </div>
              </div>
            </div>
            <div class="ticket-main-change-log">
              <div class="ticket-main-history">
                <h3>Ticket Updates</h3>
                <?php foreach ($ticket->history as $update) { ?>
                  <p>
                    <?= $update['updates'] ?>
                  </p>
                <?php } ?>
              </div>
              <div class="ticket-main-delete">
                <form action="/actions/action_delete_ticket.php" method="post">
                  <input type="hidden" name="ticket_id" value="<?= $ticket->id ?>">
                  <button type="submit" name="delete" value="delete"><i class="fas fa-trash-alt"></i></i></button>
                </form>
              </div>
            </div>
          </div>
        <?php } ?>
      </div>
    </div>
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

<?php
drawFooter($session);
?>