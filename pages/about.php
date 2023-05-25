<?php
declare(strict_types=1);

require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

require_once(__DIR__ . '/../database/connection.db.php');


require_once(__DIR__ . '/../temp/common.tpl.php');


$db = getDatabaseConnection();

drawHeader($session);
?>


<div class="heading" style="background: url(/sources/heading_bg/about-slide-bg.jpg) no-repeat;">
    <h1>about us</h1>
</div>


<section class="about">

    <div class="image">
        <img src="../sources/heading_bg/home-about-us-2.jpg" alt="">
    </div>

    <div class="content">
        <h3>Who are we?</h3>

        <p>Welcome to PourProblems, your go-to solution for any wine-related issues you may encounter. Our company is
            based in the picturesque city of Porto, where we have our very own wine cellar.</p>
        <p>At PourProblems, we understand the frustration that comes with wine problems. Whether it's a cork that won't
            budge, a bottle that's gone bad, or a wine pairing conundrum, we've got you covered. Our team of experts is
            dedicated to resolving any issue, big or small, to ensure that you can enjoy your wine to the fullest.</p>
        <p>We believe that wine should be a pleasure, not a hassle. That's why we're passionate about providing
            top-notch solutions that meet your specific needs. With years of experience in the industry, we have the
            knowledge and expertise to handle any wine-related challenge.</p>
        <p>At PourProblems, we're committed to providing exceptional service to our customers. We pride ourselves on our
            attention to detail, personalized approach, and dedication to customer satisfaction. When you choose
            PourProblems, you can rest assured that your wine problems will be resolved promptly and professionally.</p>
        <p>Thank you for choosing PourProblems as your wine problem-solving partner. We look forward to serving you!</p>

        <div class="icons-container">
            <div class="icons">
                <i class="fas fa-check"></i>
                <span>100% Satisfaction</span>
            </div>
            <div class="icons">
                <i class="fas fa-clock"></i>
                <span>24/7 Customer Support</span>
            </div>
            <div class="icons">
                <i class="fas fa-running"></i>
                <span>Fast & Reliable Service</span>
            </div>
        </div>
    </div>

</section>

<?php
drawFooter($session);
?>