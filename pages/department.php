<?php
declare(strict_types=1);

require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

if (!$session->isLoggedIn()) {
  header('Location: ../pages/login.php');
}

if (strpos($_SERVER['REQUEST_URI'], 'id=') === false) {
  header('Location: ../pages/departments.php');
}


require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../temp/common.tpl.php');
require_once(__DIR__ . '/../database/user_department.class.php');
require_once(__DIR__ . '/../database/user.class.php');
require_once(__DIR__ . '/../database/department.class.php');
require_once(__DIR__ . '/../database/ticket_user.class.php');
require_once(__DIR__ . '/../database/ticket.class.php');
require_once(__DIR__ . '/../database/status.class.php');


$db = getDatabaseConnection();

drawHeader($session);

$encryptedId = str_replace("/pages/department.php?id=", "", $_SERVER['REQUEST_URI']);

$id = base64_decode(($encryptedId));

$id_int = (int) $id;

$department = Department::getDepartment($db, $id_int);

$department_name = $department->name;

$agents = User_Department::getAgents_from_department($db, $id_int);
$departments = Department::getDepartments($db);


//Get all tickets that are assigned to this department
$tickets_user = Ticket_User::getTickets_from_department($db, $department_name);


?>
<div class="heading" style="background: url('../sources/heading_bg/department.jpg');">
  <h1>
    <?= $department_name ?> Department
  </h1>
</div>


<div class="tickets-table">

  <div class="department-table-title">
    <div class="top">
      <h1> Tickets from this department </h1>
    </div>
  </div>

  <section class="filter-table">
    <input type="text" id="filterInput1" placeholder="Search table..." title="Type in a name">
  </section>

  <section class="tickets-body">

    <table class="table-sortable" id="tableToFilter1">
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
        <?php foreach ($tickets_user as $ticket_user) {

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



<div class="department-agents">

  <div class="department-table-title">
    <h1> Agents from the Department </h1>
  </div>

  <section class="filter-table">
    <input type="text" id="filterInput1" placeholder="Search table..." title="Type in a name">
  </section>

  <section class="agents">
    <table class="table-sortable" id="tableToFilter1">
      <thead>
        <tr>
          <th> id </th>
          <th> Agent </th>
          <th> nº Tickets </th>
          <th> Add Department </th>
          <th> Remove Department </th>
        </tr>
      </thead>
      <tbody>

        <?php foreach ($agents as $agent_department) {

          $agent = User::getUser($db, $agent_department->user_id);
          ?>

          <tr>
            <td>
              <div class="user-id">
                <p> #
                  <?= $agent->id ?>
                </p>
              </div>
            </td>

            <td>
              <div class="agent">
                <?php
                $profile_image = $agent->image_path;
                ?>
                <a href="../pages/profile.php?id=<?= base64_encode(strval($agent->id)) ?>">
                  <img src="/uploads/profiles/<?= $profile_image ?>" alt="Profile Image" class="profile-image">

                  <p>
                    <?= $agent->username ?>
                  </p>
                </a>

              </div>
            </td>

            <td>
              <div class="n_tickets">
                <p>
                  <?php $number_of_tickets = Ticket_User::getTickets_from_Agent($db, $agent_department->user_id);
                  echo count($number_of_tickets);
                  ?>
                </p>
              </div>
            </td>

            <td>
              <div class="change-department">
                <?php $departments_not_assigned = User_Department::getDepartmentsNotFromUser($db, $agent->id);
                if (!empty($departments_not_assigned)) { ?>
                  <form action="../actions/action_assign_department.php" method="post" class="delete">

                    <input type="hidden" name="user_id" value="<?= $agent->id ?>">

                    <select id="departments" name="department">

                      <?php
                      foreach ($departments_not_assigned as $department) { ?>
                        <option value="<?= $department->name ?>"><?= $department->name ?></option>
                      <?php } ?>
                    </select>

                    <button type="submit" value="Change Department"><i class="fa fa-check"
                        aria-hidden="true"></i></i></button>


                  </form>
                <?php } else {
                  echo '<p> Agent in all departments </p>';
                } ?>
              </div>
            </td>

            <td>
              <div class="remove-department">
                <form action="../actions/action_delete_department_from_user.php" method="post" class="delete">
                  <input type="hidden" name="user_id" value="<?= $agent->id ?>">
                  <input type="hidden" name="department_id" value="<?= $department->id ?>">

                  <button type="submit" value="Delete"><i class="fa fa-user-times" aria-hidden="true"></i></i></button>

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