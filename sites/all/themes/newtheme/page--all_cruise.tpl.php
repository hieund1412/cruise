<?php
$theme = base_path() . 'sites/all/themes/newtheme/';

?>


<main class="wrapper">
    <section class="cruiseResult">
        <div class="homeLeft">
            <?php echo blk_menu_left();?>
        </div>
        <div class="homeRight">
            <div class="container-auto">
                <div class="homeRight__header">
                    <?php echo blk_header();?>
                </div>
                <?php print render($page['content']); ?>
            </div>

        </div>
    </section>
</main>
<?php echo blk_footer();?>