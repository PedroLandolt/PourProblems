<?php
declare(strict_types=1);

require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

require_once(__DIR__ . '/../database/connection.db.php');
require_once(__DIR__ . '/../temp/common.tpl.php');
require_once(__DIR__ . '/../database/faq.class.php');


$db = getDatabaseConnection();

drawHeader($session);

$faqs = FAQ::getFAQs($db);
?>

<div class="heading" style="background: url('../sources/heading_bg/faq.jpg');">
  <h1>FAQ's</h1>
</div>

<section class="home-faq">
    <h2 class="title">Frequently Asked Questions</h2>

    <?php if ($session->isAgent() || $session->isAdmin()) { ?>
        <section class="new-department">
            <form action="../actions/action_add_faq.php" method="post" class="delete">
                <input type="text" name="question" placeholder="insert new question">
                <input type="text" name="answer" placeholder="insert new answer">
                <input type="hidden" name="agent_id" value="<?= $session->getID() ?>">
                <button type="submit" name="add" value="add"><i class="fas fa-arrow-right"></i></button>
            </form>
        </section>
    <?php } ?>

    <?php foreach ($faqs as $faq) { ?>
        <div class="faq">
            <div class="question">
                <h3><?= $faq->question ?></h3>

                <span class="icon"><i class="fas fa-sort-down"></i></span>

            </div>

            <div class="things">
                <div class="answer">
                    <p><?= $faq->answer ?></p>
                </div>

                <div class="delete">
                    <?php if ($session->isAgent() || $session->isAdmin()) { ?>
                        <form action="../actions/action_delete_faq.php" method="post" class="delete">
                            <input type="hidden" name="faq_id" value="<?= $faq->id ?>">
                            <button type="submit" name="delete" value="delete"><i class="fas fa-trash-alt"></i></button>
                        </form>

                    <?php } ?>
                </div>
            </div>

        </div>

    <?php } ?>

</section>


<?php
drawFooter($session);
?>