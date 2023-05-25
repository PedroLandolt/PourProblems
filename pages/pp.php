<?php
declare(strict_types=1);

require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

require_once(__DIR__ . '/../database/connection.db.php');


require_once(__DIR__ . '/../temp/common.tpl.php');


$db = getDatabaseConnection();

drawHeader($session);
?>


<div class="heading" style="background: url('../sources/heading_bg/Privacy-policy-01.png');">
  <h1>Privacy Policy</h1>
</div>


<section class="pp">

  <div class="pp-container">

    <h2>-- Privacy Policy --</h2>
    <p>PourProblems respects your privacy and is committed to protecting your personal information. This Privacy Policy
      outlines how we collect, use, and disclose information that is collected through our website, products, and
      services.</p>

    <h2>-- Information Collection --</h2>
    <p>We may collect personal information such as your name, email address, phone number, and location when you
      interact with our website, products, and services. We may also collect non-personal information such as your IP
      address, browser type, and device information.</p>

    <h2>-- Information Use --</h2>
    <p>We use the information we collect to provide and improve our products and services, to communicate with you, to
      personalize your experience, and to comply with legal obligations. We may also use your information to send you
      marketing communications if you have provided your consent to receive them.</p>

    <h2>-- Information Sharing --</h2>
    <p>We may share your personal information with our service providers, partners, and other third parties who assist
      us in providing and improving our products and services. We may also share your information to comply with legal
      obligations or to protect our rights or property.</p>

    <h2>-- Data Security --</h2>
    <p>We take reasonable measures to protect your personal information from unauthorized access, disclosure, or misuse.
      However, no data transmission over the internet or storage system can be guaranteed to be 100% secure. Therefore,
      we cannot guarantee the security of your information.</p>

    <h2>-- Data Retention --</h2>
    <p>We will retain your personal information for as long as necessary to fulfill the purposes for which it was
      collected, to comply with legal obligations, or to protect our rights or property.</p>

    <h2>-- Your Rights --</h2>
    <p>You have the right to access, correct, or delete your personal information. You also have the right to object to
      or restrict the processing of your personal information. To exercise these rights, please contact us using the
      information provided below.</p>

    <h2>-- Changes to this Privacy Policy --</h2>
    <p>We may update this Privacy Policy from time to time. We will notify you of any changes by posting the new Privacy
      Policy on our website. We encourage you to review this Privacy Policy periodically to stay informed about how we
      collect, use, and disclose your information.</p>

    <h2>-- Contact Us --</h2>
    <p>If you have any questions or concerns about this Privacy Policy, please contact us at
      <b>support@pourproblems.com</b>.</p>

  </div>
</section>


<?php
drawFooter($session);
?>