<?php
$theme = '/sites/all/themes/newtheme/';

?>
<main class="wrapper">
    <section class="cruiseDetails">
        <?php echo blk_menu_left();?>
        <div class="homeRight">
            <div class="container-auto">
                <div class="homeRight__header">
                    <?php echo blk_header();?>
                </div>
                <div class="cruiseDetails__main">
                    <?php print render($page['content']); ?>
                </div>
            </div>
        </div>
    </section>
</main>
<?php echo blk_footer();?>