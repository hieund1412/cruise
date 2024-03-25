<?php
$theme = '/sites/all/themes/newtheme/';

?>
<main class="wrapper">
    <section class="flightReview">
        <div class="container">
            <div class="homeRight__header">
                <?php echo blk_header();?>
            </div>
            <div class="passenger__step">
                <ul class="progressbar">
                    <li class="complete"><?php echo t('Choose Room');?></li>
                    <li class="complete"><?php echo t('Guest Info');?></li>
                    <li class="active"><?php echo t('Review  ');?></li>
                    <li><?php echo t('Payment');?></li>
                </ul>
            </div>
        </div>
        <div class="review__body">
            <div class="container">
                <?php print render($page['content']); ?>

            </div>
        </div>

    </section>

</main>
<?php echo blk_footer();?>
