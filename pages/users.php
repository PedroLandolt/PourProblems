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
require_once(__DIR__ . '/../database/department.class.php');
require_once(__DIR__ . '/../database/user_department.class.php');


$db = getDatabaseConnection();

$users = User::getUsers($db);

$departments = Department::getDepartments($db);

drawHeader($session);

$users = User::getUsers($db);





?>


<div class="heading" style="background: url('../sources/heading_bg/users.png');">
  <h1>Users</h1>
</div>

<div class="tables">


  <div class="users-table">

    <div class="users-tables-titles">
      <h1> Admins </h1>
    </div>

    <section class="filter-table">
      <input type="text" id="filterInput1" placeholder="Search table..." title="Type in a name">
    </section>

    <section class="users">

      <table class="table-sortable" id="tableToFilter1">
        <thead>
          <tr>
            <th> id </th>
            <th> Admin </th>
            <th> Change Role </th>
            <th> Delete </th>
          </tr>
        </thead>
        <tbody>
          <?php
          foreach ($users as $user) {
            if ($user->role_id == 1) {
              ?>
              <tr>

                <td>
                  <div class="user-id">
                    <p>
                      <?= $user->id ?>
                    </p>
                  </div>
                </td>

                <td>
                  <div class="user-info">
                    <a href="../pages/profile.php?id=<?= base64_encode(strval($user->id)) ?>">
                      <img src="/uploads/profiles/<?= $user->image_path ?>" alt="profile_pic" class="profile-image">
                      <p>
                        <?= $user->username ?>
                      </p>
                    </a>
                  </div>
                </td>

                <td>
                  <div class="user-role">
                    <form action="../actions/action_change_role.php" method="post">
                      <input type="hidden" name="user_id" value="<?= $user->id ?>">
                      <select name="role_id" id="role_id">
                        <option value="2" <?php if ($user->role_id == 2)
                          echo 'selected'; ?>> Agent </option>
                        <option value="3" <?php if ($user->role_id == 3)
                          echo 'selected'; ?>> Client </option>
                      </select>
                      <button type="submit"> <i class="fa fa-child" aria-hidden="true"></i> </button>
                    </form>
                  </div>
                </td>

                <td>
                  <div class="delete">
                    <form action="../actions/action_delete_user.php" method="post" class="delete">
                      <input type="hidden" name="user_id" value="<?= $user->id ?>">
                      <button type="submit" value="Delete"><i class="fa fa-user-times" aria-hidden="true"></i></button>
                    </form>
                  </div>
                </td>

              </tr>
            <?php }
          } ?>
        </tbody>
      </table>

    </section>

  </div>



  <div class="users-table">

    <div class="users-tables-titles">
      <h1> Agents </h1>
    </div>

    <section class="filter-table">
      <input type="text" id="filterInput2" placeholder="Search table..." title="Type in a name">
    </section>

    <section class="users">

      <table class="table-sortable" id="tableToFilter2">
        <thead>
          <tr>
            <th> id </th>
            <th> Agent </th>
            <th> nº Tickets </th>
            <th> nº Tickets Closed </th>
            <th> nº Tickets Assigned </th>
            <th> Change Role </th>
            <th> Add Department </th>
            <th> Remove Department </th>
            <th> Delete </th>
          </tr>
        </thead>
        <tbody>
          <?php
          foreach ($users as $user) {
            if ($user->role_id == 2) {
              ?>
              <tr>

                <td>
                  <div class="user-id">
                    <p>
                      <?= $user->id ?>
                    </p>
                  </div>
                </td>

                <td>
                  <div class="user-info">
                    <a href="../pages/profile.php?id=<?= base64_encode(strval($user->id)) ?>">
                      <img src="/uploads/profiles/<?= $user->image_path ?>" alt="profile_pic" class="profile-image">
                      <p>
                        <?= $user->username ?>
                      </p>
                    </a>
                  </div>
                </td>

                <td>
                  <div class="user-tickets">
                    <p>
                      <?= $user->getNumberOfTickets($db, $user->id, $user->role_id) ?>
                    </p>
                  </div>
                </td>

                <td>
                  <div class="user-tickets-closed">
                    <p>
                      <?= $user->getNumberOfTicketsByStatus($db, $user->id, 'Closed', $user->role_id) ?>
                    </p>
                  </div>
                </td>

                <td>
                  <div class="user-tickets-assigned">
                    <p>
                      <?= $user->getNumberOfTicketsByStatus($db, $user->id, 'Assigned', $user->role_id) ?>
                    </p>
                  </div>
                </td>

                <td>
                  <div class="user-role">
                    <form action="../actions/action_change_role.php" method="post">
                      <input type="hidden" name="user_id" value="<?= $user->id ?>">
                      <select name="role_id" id="role_id">
                        <option value="1" <?php if ($user->role_id == 1)
                          echo 'selected'; ?>> Admin </option>
                        <option value="3" <?php if ($user->role_id == 3)
                          echo 'selected'; ?>> Client </option>
                      </select>
                      <button type="submit"> <i class="fa fa-child" aria-hidden="true"></i> </button>
                    </form>
                  </div>
                </td>

                <td>
                  <div class="change-department">
                    <?php $departments_not_assigned = User_Department::getDepartmentsNotFromUser($db, $user->id);
                    if (!empty($departments_not_assigned)) { ?>
                      <form action="../actions/action_assign_department.php" method="post" class="delete">

                        <input type="hidden" name="user_id" value="<?= $user->id ?>">

                        <select id="departments" name="department">

                          <?php
                          foreach ($departments_not_assigned as $department) { ?>
                            <option value="<?= $department->name ?>"><?= $department->name ?></option>
                          <?php } ?>
                        </select>

                        <button type="submit" value="Change Department"><i class="fa fa-check"
                            aria-hidden="true"></i></button>

                      </form>
                    <?php } else {
                      echo '<p> Agent in all departments </p>';
                    } ?>
                  </div>
                </td>

                <td>
                  <div class="delete-department">
                    <?php $departments_assigned = User_Department::getDepartmentsFromUser($db, $user->id);
                    if (!empty($departments_assigned)) { ?>
                      <form action="../actions/action_delete_department_from_user.php" method="post" class="delete">

                        <input type="hidden" name="user_id" value="<?= $user->id ?>">

                        <select id="departments" name="department_id">

                          <?php
                          foreach ($departments_assigned as $department_delete) {
                            foreach ($departments as $department_name) {
                              if ($department_delete->department_id == $department_name->id) { ?>
                                <option value="<?= $department_delete->department_id ?>"><?= $department_name->name ?></option>
                              <?php } ?>
                            <?php }
                          } ?>
                        </select>

                        <button type="submit" value="Change Department"><i class="fa fa-times"
                            aria-hidden="true"></i></button>

                      </form>

                    <?php } else {
                      echo '<p> Agent in no departments </p>';
                    } ?>
                  </div>
                </td>

                <td>
                  <div class="delete">
                    <form action="../actions/action_delete_user.php" method="post" class="delete">
                      <input type="hidden" name="user_id" value="<?= $user->id ?>">
                      <button type="submit" value="Delete"><i class="fa fa-user-times" aria-hidden="true"></i></button>
                    </form>
                  </div>
                </td>

              </tr>
            <?php }
          } ?>
        </tbody>
      </table>

    </section>

  </div>



  <div class="users-table">

    <div class="users-tables-titles">
      <h1> Clients </h1>
    </div>

    <section class="filter-table">
      <input type="text" id="filterInput3" placeholder="Search table..." title="Type in a name">
    </section>

    <section class="users">

      <table class="table-sortable" id="tableToFilter3">
        <thead>
          <tr>
            <th> id </th>
            <th> Client </th>
            <th> nº Tickets </th>
            <th> nº Tickets Open </th>
            <th> nº Tickets Closed </th>
            <th> nº Tickets Assigned </th>
            <th> Change Role </th>
            <th> Delete </th>
          </tr>
        </thead>
        <tbody>

          <?php foreach ($users as $user) {

            if ($user->role_id == 3) { ?>
              <tr>
                <td>
                  <div class="user-id">
                    <p>
                      <?= $user->id ?>
                    </p>
                  </div>
                </td>

                <td>
                  <div class="user-info">
                    <a href="../pages/profile.php?id=<?= base64_encode(strval($user->id)) ?>">
                      <img src="/uploads/profiles/<?= $user->image_path ?>" alt="profile_pic" class="profile-image">
                      <p>
                        <?= $user->username ?>
                      </p>
                    </a>
                  </div>
                </td>

                <td>
                  <div class="user-tickets">
                    <p>
                      <?= $user->getNumberOfTickets($db, $user->id, $user->role_id) ?>
                    </p>
                  </div>
                </td>

                <td>
                  <div class="user-tickets-open">
                    <p>
                      <?= $user->getNumberOfTicketsByStatus($db, $user->id, 'Open', $user->role_id) ?>
                    </p>
                  </div>
                </td>

                <td>
                  <div class="user-tickets-closed">
                    <p>
                      <?= $user->getNumberOfTicketsByStatus($db, $user->id, 'Closed', $user->role_id) ?>
                    </p>
                  </div>
                </td>

                <td>
                  <div class="user-tickets-assigned">
                    <p>
                      <?= $user->getNumberOfTicketsByStatus($db, $user->id, 'Assigned', $user->role_id) ?>
                    </p>
                  </div>
                </td>

                <td>
                  <div class="user-role">
                    <form action="../actions/action_change_role.php" method="post">
                      <input type="hidden" name="user_id" value="<?= $user->id ?>">
                      <select name="role_id" id="role_id">
                        <option value="1" <?php if ($user->role_id == 1)
                          echo 'selected'; ?>> Admin </option>
                        <option value="2" <?php if ($user->role_id == 2)
                          echo 'selected'; ?>> Agent </option>
                      </select>
                      <button type="submit"> <i class="fa fa-child" aria-hidden="true"></i> </button>
                    </form>
                  </div>
                </td>

                <td>
                  <div class="delete">
                    <form action="../actions/action_delete_user.php" method="post" class="delete">
                      <input type="hidden" name="user_id" value="<?= $user->id ?>">
                      <button type="submit" value="Delete"><i class="fa fa-user-times" aria-hidden="true"></i></button>
                    </form>
                  </div>
                </td>

              </tr>

            <?php }
          } ?>

        </tbody>
      </table>
    </section>
  </div>

</div>

<?php
drawFooter($session);
?>