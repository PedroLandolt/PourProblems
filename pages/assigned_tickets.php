<?php
declare(strict_types=1);

require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

if (!$session->isLoggedIn()) {
  header('Location: ../pages/login.php');
}

if (!$session->isAgent()) {
  header('Location: ../pages/index.php');
}

require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../temp/common.tpl.php');
require_once(__DIR__ . '/../database/ticket_user.class.php');
require_once(__DIR__ . '/../database/ticket.class.php');
require_once(__DIR__ . '/../database/status.class.php');
require_once(__DIR__ . '/../database/user.class.php');
require_once(__DIR__ . '/../database/department.class.php');
require_once(__DIR__ . '/../database/hashtag.class.php');


$db = getDatabaseConnection();

$assigned_tickets = Ticket_User::getAssigned_tickets($db, $session->getId());

$all_status = Status::getAll_Status($db);

$agents = User::getAgents($db, 2);

$departments = Department::getDepartments($db);

drawHeader($session);
?>


<div class="heading" style="background: url('../sources/heading_bg/assigned.jpg');">
  <h1>Assigned Tickets</h1>
</div>

<div class="custom-space"></div>

<section class="filter-table">
    <input type="text" id="filterInput" placeholder="Search table..." title="Type in a name">
  </section>


<div class="tickets-table">

  <section class="tickets-body">

    <table class="table-sortable" id="tableToFilter">
      <thead>
        <tr>
          <th> Ticket </th>
          <th> Client </th>
          <th> Subject </th>
          <th> Department </th>
          <th> Date </th>
          <th> Status </th>
          <th> Agent </th>
          <th> Anexos </th>
          <th> Info </th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($assigned_tickets as $ticket_user) {

          $ticket = Ticket::getTicket($db, $ticket_user->ticket_id);

          if ($ticket_user->agent_id == NULL) {
            $agent_username = 'No Agent Assigned';
          } else {
            $user = User::getUser($db, $ticket_user->agent_id);

            $agent_username = $user->username;
          } ?>


          <tr>
            <td>
              <div class="ticket-id">
                <p> #
                  <?= $ticket->id ?>
                </p>
              </div>
            </td>

            <td>
              <div class="client">
                <?php
                // Get profile image from the user that created the ticket
                $user = User::getUser($db, $ticket_user->client_id);
                $profile_image = $user->image_path;
                ?>
                <a href="../pages/profile.php?id=<?= base64_encode(strval($user->id)) ?>">
                  <img src="/uploads/profiles/<?= $profile_image ?>" alt="Profile Image" class="profile-image">

                  <p>
                    <?= $user->username ?>
                  </p>
                </a>
              </div>
            </td>

            <td>
              <div class="subject">
                <p>
                  <?= $ticket->subject ?>
                </p>
              </div>
            </td>

            <td>
              <div class="department">
                <p>
                  <?= $ticket->department ?>
                </p>
            </td>

            <td>
              <div class="date">
                <p>
                  <?= $ticket->datetime ?>
                </p>
              </div>
            </td>

            <td>
              <div class="status">
                <?php $status = Status::getStatus($db, $ticket->status_id); ?>

                <?php
                if ($status->stat == 'Open') {
                  echo '<span class="open">' . $status->stat . '</span>';
                } else if ($status->stat == 'Closed') {
                  echo '<span class="closed">' . $status->stat . '</span>';
                } else {
                  echo '<span class="assigned">' . $status->stat . '</span>';
                }

                ?>

              </div>
            </td>

            <td>
              <div class="agent">
                <p>
                  <?= $agent_username ?>
                </p>
              </div>
            </td>

            <td>
              <div class="anexos">
                <p>
                  <?= count($ticket->files) ?>
                </p>
              </div>
            </td>

            <td>
              <div class="more-info">
                <form action="../pages/ticket.php?id=<?= base64_encode(strval($ticket->id)) ?>" method="post"
                  class="info-form">
                  <input type="hidden" name="ticket_id" value="<?= $ticket_user->ticket_id ?>">
                  <input type="hidden" name="id" value="<?= $ticket->id ?>">
                  <input type="submit" value="+">
                </form>
              </div>
            </td>
          </tr>
          
        <?php } ?>
      </tbody>
    </table>
  </section>

</div>

<?php
drawFooter($session);
?>