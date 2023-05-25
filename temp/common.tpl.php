<?php
declare(strict_types=1);

require_once(__DIR__ . '/../utils/session.php');
?>

<?php function drawHeader(Session $session)
{ ?>
  <!DOCTYPE html>
  <html lang="en-US">

  <head>
    <title>PourProblems</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="shortcut icon" href="../sources/PourProblems_icon.png" type="image/x-icon">

    <!-- Swipper css link -->
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />

    <!-- Font Awesome cdnjs link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
      integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
      crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Custom CSS link -->
    <link rel="stylesheet" href="../css/style.css">

    <!-- Swipper js link -->
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

    <!-- custom js file link -->
    <script src="../javascript/script.js" defer></script>

  </head>

  <body>

    <header>

      <?php
      if ($session->isLoggedIn()) {
        if ($session->isAdmin()) {
          drawAdminHeader($session);
        } else if ($session->isAgent()) {
          drawAgentHeader($session);
        } else {
          drawLogoutHeader($session);
        }
      } else
        drawLoginHeader($session);
      ?>

    </header>

  <?php } ?>

  <?php function drawFooter(Session $session)
  { ?>
    <footer>
      <section class="footer">

        <div class="box-conteiner">

          <div class="box">
            <h3>Quick Links</h3>
            <?php
            if ($session->isLoggedIn()) {
              if ($session->isAdmin()) { ?>

                <a href="/pages/about.php"> <i class="fas fa-angle-right"></i> About</a>
                <a href="/pages/users.php"> <i class="fas fa-angle-right"></i> Users</a>
                <a href="/pages/all_tickets.php"> <i class="fas fa-angle-right"></i> Tickets</a>
                <a href="/pages/departments.php"> <i class="fas fa-angle-right"></i> Departments</a>
                <a href="/pages/profile.php?id=<?= base64_encode(strval($session->getID()))?>"> <i class="fas fa-angle-right"></i> Profile</a>
                <a href="/actions/action_logout.php"> <i class="fas fa-angle-right"></i> Logout</a>

              <?php } else if ($session->isAgent()) { ?>

                  <a href="/pages/about.php"> <i class="fas fa-angle-right"></i> About</a>
                  <a href="/pages/assigned_tickets.php"> <i class="fas fa-angle-right"></i> Assigned Tickets</a>
                  <a href="/pages/all_tickets.php"> <i class="fas fa-angle-right"></i> Tickets</a>
                  <a href="/pages/profile.php?id=<?= base64_encode(strval($session->getID()))?>"> <i class="fas fa-angle-right"></i> Profile</a>
                  <a href="/actions/action_logout.php"> <i class="fas fa-angle-right"></i> Logout</a>

              <?php } else { ?>

                  <a href="/pages/about.php"> <i class="fas fa-angle-right"></i> About</a>
                  <a href="/pages/mytickets.php"> <i class="fas fa-angle-right"></i> My Tickets</a>
                  <a href="/pages/submit_ticket.php"> <i class="fas fa-angle-right"></i> Submit a Ticket</a>
                  <a href="/pages/profile.php?id=<?= base64_encode(strval($session->getID()))?>"> <i class="fas fa-angle-right"></i> Profile</a>
                  <a href="/actions/action_logout.php"> <i class="fas fa-angle-right"></i> Logout</a>


              <?php }
            } else { ?>
              <a href="/pages/about.php"> <i class="fas fa-angle-right"></i> About</a>
              <a href="/pages/signup.php"> <i class="fas fa-angle-right"></i> Sign Up</a>
              <a href="/pages/login.php"> <i class="fas fa-angle-right"></i> Login</a>


            <?php }
            ?>
          </div>

          <div class="box">
            <h3>Extra Links</h3>
            <a href="/pages/faq.php"> <i class="fas fa-angle-right"></i> FAQ</a>
            <a href="/pages/pp.php"> <i class="fas fa-angle-right"></i> Privacy Policy</a>
            <a href="/pages/tos.php"> <i class="fas fa-angle-right"></i> Terms of Service</a>
          </div>

          <div class="box">
            <h3>Contact Info</h3>
            <a href="#"> <i class="fas fa-phone"></i> +351 220 000 000</a>
            <a href="#"> <i class="fas fa-envelope"></i> support@pourproblems.com </a>
            <a href="#"> <i class="fas fa-map"></i> Porto, Portugal - 4200-465</a>
          </div>

          <div class="box">
            <h3>Social</h3>
            <a href="#"> <i class="fab fa-facebook-f"></i> PourProblems</a>
            <a href="#"> <i class="fab fa-twitter"></i> @PourProblems</a>
            <a href="#"> <i class="fab fa-instagram"></i> @PourProblems</a>
            <a href="#"> <i class="fab fa-youtube"></i> PourProblems</a>
            <a href="#"> <i class="fab fa-linkedin"></i> PourProblems</a>
          </div>

          <div class="box">
            <img src="../sources/PourProblems_Logo_White.png" alt="PourProblems" width="150">
          </div>

        </div>
      </section>

    </footer>

  </body>

  </html>
<?php } ?>

<?php function drawLoginHeader(Session $session)
{ ?>
  <section class="header">

    <a href="index.php" class="logo">
      <img src="../sources/PourProblems_Logo_Gray.png" alt="PourProblems" width="140">
    </a>

    <nav class="navbar">
      <a href="/pages/about.php">About</a>
      <a href="/pages/signup.php">Sign Up</a>
      <a href="/pages/login.php">Login</a>
    </nav>

    <div id="menu-bars" class="fas fa-bars"></div>

  </section>
<?php } ?>

<?php function drawLogoutHeader(Session $session)
{ ?>
  <section class="header">

    <a href="index.php" class="logo">
      <img src="../sources/PourProblems_Logo_Gray.png" alt="PourProblems" width="140">
    </a>

    <nav class="navbar">
      <form action="../actions/action_logout.php" method="post" class="logout">
        <a href="/pages/about.php">About</a>
        <a href="/pages/faq.php">FAQ's</a>
        <a href="/pages/mytickets.php">My Tickets</a>
        <a href="/pages/submit_ticket.php">Submit a Ticket</a>
        <a href="/pages/profile.php?id=<?= base64_encode(strval($session->getID()))?>">Profile</a>
        <input type="submit" value="Logout">
      </form>
    </nav>

    <div id="menu-bars" class="fas fa-bars"></div>

  </section>
<?php } ?>

<?php function drawAdminHeader(Session $session)
{ ?>
  <section class="header">

    <a href="index.php" class="logo">
      <img src="../sources/PourProblems_Logo_Gray.png" alt="PourProblems" width="140">
    </a>

    <nav class="navbar">
      <form action="../actions/action_logout.php" method="post" class="logout">
        <a href="/pages/about.php">About</a>
        <a href="/pages/faq.php">FAQ's</a>
        <a href="/pages/users.php">Users</a>
        <a href="/pages/all_tickets.php">Tickets</a>
        <a href="/pages/departments.php">Departments</a>
        <a href="/pages/profile.php?id=<?= base64_encode(strval($session->getID()))?>">Profile</a>
        <input type="submit" value="Logout">
      </form>
    </nav>

    <div id="menu-bars" class="fas fa-bars"></div>

  </section>
<?php } ?>

<?php function drawAgentHeader(Session $session)
{ ?>
  <section class="header">

    <a href="index.php" class="logo">
      <img src="../sources/PourProblems_Logo_Gray.png" alt="PourProblems" width="140">
    </a>

    <nav class="navbar">
      <form action="../actions/action_logout.php" method="post" class="logout">
        <a href="/pages/about.php">About</a>
        <a href="/pages/faq.php">FAQ's</a>
        <a href="/pages/assigned_tickets.php">Assigned Tickets</a>
        <a href="/pages/all_tickets.php">Tickets</a>
        <a href="/pages/profile.php?id=<?= base64_encode(strval($session->getID()))?>">Profile</a>
        <input type="submit" value="Logout">
      </form>
    </nav>

    <div id="menu-bars" class="fas fa-bars"></div>

  </section>
<?php } ?>