<?php
declare(strict_types=1);

require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

require_once(__DIR__ . '/../database/connection.db.php');


require_once(__DIR__ . '/../temp/common.tpl.php');


$db = getDatabaseConnection();

drawHeader($session);
?>

<div class="heading" style="background: url('../sources/heading_bg/terms-of-service.png');">
  <h1>Terms of Service</h1>
</div>


<section class="tos">

  <div class="tos-container">

    <h2>-- Terms of Service --</h2>
    <p>These Terms of Service govern your use of the PourProblems website, products, and services. By using our website,
      products, and services, you agree to be bound by these Terms of Service.</p>

    <h2>-- Intellectual Property --</h2>
    <p>All content on the PourProblems website, including but not limited to text, graphics, logos, images, and
      software, is the property of PourProblems and is protected by intellectual property laws. You may not use, copy,
      reproduce, distribute, or modify any content on the PourProblems website without our prior written consent.</p>

    <h2>-- User Conduct --</h2>
    <p>You may not use our website, products, or services for any unlawful purpose or in any way that could damage,
      disable, overburden, or impair our website or interfere with any other user's use of our website. You may not use
      our website to harass, threaten, or intimidate any person or to solicit personal information from any person.</p>

    <h2>-- User Content --</h2>
    <p>Any content that you submit to our website, products, or services, including but not limited to comments,
      reviews, and feedback, is considered user content. You retain all ownership rights in your user content, but by
      submitting it to our website, you grant us a non-exclusive, royalty-free, perpetual, irrevocable, and
      sublicensable right to use, copy, modify, create derivative works based on, distribute, and display your user
      content.</p>

    <h2>-- Limitation of Liability --</h2>
    <p>PourProblems shall not be liable for any direct, indirect, incidental, special, or consequential damages arising
      out of or in connection with your use of our website, products, or services, including but not limited to damages
      for loss of profits, goodwill, use, data, or other intangible losses, even if we have been advised of the
      possibility of such damages.</p>

    <h2>-- Indemnification --</h2>
    <p>You agree to indemnify and hold harmless PourProblems, its affiliates, and their respective directors, officers,
      employees, and agents from any claim or demand, including reasonable attorneys' fees, made by any third party due
      to or arising out of your use of our website, products, or services, your violation of these Terms of Service, or
      your violation of any rights of another.</p>

    <h2>-- Termination --</h2>
    <p>PourProblems may terminate your access to our website, products, or services at any time and for any reason
      without notice.</p>

    <h2>-- Governing Law --</h2>
    <p>These Terms of Service shall be governed by and construed in accordance with the laws of the state of California,
      without regard to its conflict of laws principles.</p>

    <h2>-- Changes to these Terms of Service --</h2>
    <p>We may update these Terms of Service from time to time. We will notify you of any changes by posting the new
      Terms of Service on our website. We encourage you to review these Terms of Service periodically to stay informed
      about any changes.</p>

    <h2>-- Contact Us --</h2>
    <p>If you have any questions or concerns about this Terms of Service, please contact us at
      <b>support@pourproblems.com</b>.</p>

  </div>
</section>

<?php
drawFooter($session);
?>