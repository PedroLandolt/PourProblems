<?php
declare(strict_types=1);

require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

require_once(__DIR__ . '/../database/connection.db.php');


require_once(__DIR__ . '/../temp/common.tpl.php');

require_once(__DIR__ . '/../database/user.class.php');


$db = getDatabaseConnection();
require_once(__DIR__ . '/../utils/create_users.php');
$creates = create_users::create($db);



drawHeader($session);
?>

<section class="home">
    <div class="swiper home-slider">
        <div class="swiper-wrapper">

            <div class="swiper-slide slide" style="background: url(/sources/heading_bg/about-slide-bg.jpg) no-repeat;">
                <div class="content">
                    <span>Wine Cellar</span>
                    <h3>Porto</h3>
                    <p>One of the best wine producers globally!</p>
                    <a href="/pages/about.php" class="btn">More Info</a>
                </div>
            </div>

            <div class="swiper-slide slide"
                style="background: url(/sources/heading_bg/tickets-slide-bg.jpg) no-repeat;">
                <div class="content">
                    <span>Support</span>
                    <h3>Pour</h3>
                    <h3>Problems</h3>
                    <p>We answer every question you may have!</p>
                    <a href="/pages/mytickets.php" class="btn">Tickets!</a>
                </div>
            </div>

            <div class="swiper-slide slide" style="background: url(/sources/heading_bg/signup-slide-bg.jpg) no-repeat;">
                <div class="content">
                    <h3>Join us!</h3>
                    <a href="/pages/signup.php" class="btn">Sign Up!</a>
                </div>
            </div>


        </div>

        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>

    </div>
</section>

<section class="home-faq">
    <h2 class="title">FAQ's</h2>
    <div class="faq">
        <div class="question">
            <h3>How do I know if my wine is corked?</h3>
            <span class="icon"><i class="fas fa-sort-down"></i></span>
        </div>
        <div class="answer">
            <p>
                If you notice a musty smell or a damp cardboard taste, your wine is probably corked.
                This is caused by a chemical compound called TCA, which can be found in cork.
                If you suspect that your wine is corked, you can send it to us for testing.
                We will determine whether or not it is corked and provide you with a replacement bottle if necessary.
            </p>
        </div>
    </div>
    <div class="faq">
        <div class="question">
            <h3>What is the best way to store wine?</h3>
            <span class="icon"><i class="fas fa-sort-down"></i></span>
        </div>
        <div class="answer">
            <p>
                The best way to store wine is in a cool, dark place.
                This will help preserve the flavor and prevent it from spoiling.
                If you don't have a cellar or basement, you can store your wine in the refrigerator.
                Just make sure that it's not too cold or too hot!
            </p>
        </div>
    </div>
    <div class="faq">
        <div class="question">
            <h3>What is the best way to open a bottle of wine?</h3>
            <span class="icon"><i class="fas fa-sort-down"></i></span>
        </div>
        <div class="answer">
            <p>
                The best way to open a bottle of wine is by using a corkscrew.
                This will ensure that the cork doesn't break and that you don't spill any wine.
                If you don't have a corkscrew, you can use a knife or scissors to cut the foil off the top of the
                bottle.
                Then, insert the tip of the knife into the cork and twist it until it comes out.
                Finally, pour yourself a glass and enjoy!
            </p>
        </div>
    </div>
    <div class="faq">
        <div class="question">
            <h3>What is the best cork for wine?</h3>
            <span class="icon"><i class="fas fa-sort-down"></i></span>
        </div>
        <div class="answer">
            <p>
                The best cork for wine is a natural cork.
                This type of cork is made from the bark of the cork oak tree and has been used for centuries.
                It's also biodegradable, which means that it can be recycled or composted after use.
                Natural corks are more expensive than synthetic corks, but they're worth it because they don't affect
                the taste of your wine!
            </p>
        </div>
    </div>
</section>

<section class="home-about">
    <div class="image">
        <img src="../sources/heading_bg/home-about-us.jpg" alt="">
    </div>

    <div class="content">
        <h3>About Us</h3>
        <p>
            PourProblems is your solution to all wine-related issues.
            With our own wine cellar in Porto and years of experience in the industry, our team of experts is dedicated
            to resolving any wine problem you may encounter.
            Whether it's a stubborn cork or a wine pairing conundrum, we provide personalized solutions to ensure that
            you can enjoy your wine without any hassle.
            At PourProblems, we pride ourselves on our attention to detail and commitment to customer satisfaction, so
            you can trust us to deliver exceptional service every time.
        </p>
        <a href="/pages/about.php" class="btn">read more!</a>
    </div>
</section>

<?php
drawFooter($session);
?>