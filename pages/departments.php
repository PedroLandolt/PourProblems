<?php
declare(strict_types=1);

require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

if (!$session->isLoggedIn()) {
  header('Location: ../pages/login.php');
}

require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../temp/common.tpl.php');
require_once(__DIR__ . '/../database/department.class.php');
require_once(__DIR__ . '/../database/user_department.class.php');
require_once(__DIR__ . '/../database/user.class.php');
require_once(__DIR__ . '/../database/ticket.class.php');

$db = getDatabaseConnection();

$departments = Department::getDepartments($db);

$all_user_departments = User_Department::getAllUserDepartments($db);

$all_tickets = Ticket::getAllTickets($db);

drawHeader($session);
?>

<div class="heading" style="background: url('../sources/heading_bg/departments.jpg');">
  <h1>Departments</h1>
</div>

<div class="top-of-table">
  <section class="filter-table">
    <input type="text" id="filterInput" placeholder="Search table..." title="Type in a name">
  </section>
  <section class="new-department">
    <form action="../actions/action_add_department.php" method="post" class="delete">
      <input type="text" name="name" placeholder="new department name">
      <button type="submit" name="add" value="add"><i class="fas fa-arrow-right"></i></button>
    </form>
  </section>

</div>

<div class="departments-table">

  <section class="departments-body">

    <table class="table-sortable" id="tableToFilter">
      <thead>
        <tr>
          <th> id </th>
          <th> Department </th>
          <th> Nº Tickets </th>
          <th> Nº Agents </th>
          <th> Delete </th>
          <th> Info </th>
        </tr>
      </thead>
      <tbody>

        <?php foreach ($departments as $department) { ?>

          <tr>
            <td>
              <div class="department-id">
                <p> #
                  <?= $department->id ?>
                </p>
              </div>
            </td>

            <td>
              <div class="department-name">
                <p>
                  <?= $department->name ?>
                </p>
              </div>
            </td>

            <td>
              <div class="number-of-tickets">
                <p>
                  <?php
                  echo Department::getAllTicketsFromDepartment($db, $department->name);
                  ?>
                </p>
              </div>
            </td>

            <td>
              <div class="number-of-agents">
                <p>
                  <?php

                  $number_of_agents = 0;

                  foreach ($all_user_departments as $user_department) {
                    if ($user_department->department_id == $department->id) {
                      $number_of_agents++;
                    }
                  }
                  echo $number_of_agents;
                  ?>
                </p>
              </div>
            </td>

            <td>
              <div class="delete">
                <form action="../actions/action_delete_department.php" method="post" class="delete">
                  <input type="hidden" name="id" value="<?= $department->id ?>">
                  <button type="submit" name="delete" value="delete"><i class="fas fa-trash-alt"></i></i></button>
                </form>
              </div>
            </td>

            <td>
              <div class="info">
                <form action="../pages/department.php?id=<?= base64_encode(strval($department->id)) ?>" method="post"
                  class="delete">
                  <input type="hidden" name="id" value="<?= $department->id ?>">
                  <input type="hidden" name="name" value="<?= $department->name ?>">
                  <button type="submit" name="info" value="info"><i class="fas fa-plus"></i></button>
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