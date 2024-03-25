<?php
$theme = '/sites/all/themes/newtheme/';

?>



<main class="wrapper">
    <section class="<?php echo (arg(0) == 'all_cruise')?'cruiseResult':'home'?>">
        <?php echo blk_menu_left();?>
        <div class="homeRight">
            <div class="container-auto">
                <div class="homeRight__header">
                    <?php echo blk_header();?>
                </div>

            </div>
            <?php print render($page['content']); ?>
        </div>
    </section>
</main>
<?php echo blk_footer();?>
