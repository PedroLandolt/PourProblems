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
require_once(__DIR__ . '/../database/hashtag.class.php');


$db = getDatabaseConnection();

$tickets_from_user = Ticket_User::getTickets_from_User($db, $session->getId());

drawHeader($session);
?>


<div class="heading" style="background: url('../sources/heading_bg/mytickets.jpg');">
  <h1>My Tickets</h1>
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
          <th> Subject </th>
          <th> Department </th>
          <th> Date </th>
          <th> Status </th>
          <th> Agent </th>
          <th> Anexos </th>
          <th> Hashtag </th>
          <th> Info </th>
        </tr>
      </thead>

      <tbody>

        <?php foreach ($tickets_from_user as $ticket_user) {

          $ticket = Ticket::getTicket($db, $ticket_user->ticket_id);

          if ($ticket_user->agent_id == NULL) {
            $agent_username = 'No Agent Assigned';
          } else {
            $agent = User::getUser($db, $ticket_user->agent_id);
            $client = User::getUser($db, $ticket_user->client_id);

            $agent_username = $agent->username;
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
              <div class="ticket-subject">
                <p>
                  <?= $ticket->subject ?>
                </p>
              </div>
            </td>

            <td>
              <div class="ticket-department">
                <p>
                  <?= $ticket->department ?>
                </p>
              </div>
            </td>

            <td>
              <div class="ticket-date">
                <p>
                  <?= $ticket->datetime ?>
                </p>
              </div>
            </td>

            <td>
              <div class="status">
                <?php $status = Status::getStatus($db, $ticket->status_id);

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
              <div class="ticket-agent">
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
              <div class="hashtag">
                <?php

                $hashtags = Hashtag::getHashtags_from_Ticket($db, $ticket->id);

                if (count($hashtags) == 0) {
                  echo '<p class="hashtag">No Hashtags</p>';
                } else {
                  foreach ($hashtags as $hashtag) {
                    echo '<p class="hashtag">' . $hashtag->name . '</p>';
                  }
                }

                ?>
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