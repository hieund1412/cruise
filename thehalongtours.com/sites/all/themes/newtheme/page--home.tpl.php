

<?php
$theme = '/sites/all/themes/newtheme/';
?>
<main class="wrapper">
    <section class="home">
        <?php print render($page['content']); ?>
        <?php echo blk_menu_left();?>
        <div class="homeRight">
            <div class="container-auto">
                <div class="homeRight__header">
                 <?php echo blk_header();?>
                </div>
                <div class="lineHeader__mobile showMobile"></div>
                <?php echo blk_form_search();?>
                <?php echo blk_cruise_line();?>
                <?php echo blk_thing_to_do();?>

                <div class="homeChoose__cruise">
                    <div class="container1">
                        <div class="title__cont">
                            <div class="title1">
                                <p><?php echo t('Vacation your way')?></p>
                            </div>
                            <p><?php echo t('Easily search for travel packages that suit your needs')?></p>
                        </div>
                        <div class="showDesktop">
                            <div class="homeChoose__main">
                                <div class="homeChoose__group">
                                    <div class="homeIntern__col"><a href="<?php echo base_path().drupal_get_path_alias('cruises/8825')?>" class="homeIntern__item"><img src="<?php echo $theme?>images/8.jpg">
                                            <div class="homeIntern__text">
                                                <p class="text20 medium"><?php echo t('Best cruise');?></p>
                                            </div></a></div>
                                    <div class="homeIntern__col"><a href="<?php echo base_path().drupal_get_path_alias('cruises/8826')?>" class="homeIntern__item"><img src="<?php echo $theme?>images/9.jpg">
                                            <div class="homeIntern__text">
                                                <p class="text20 medium"><?php echo t('Luxury');?></p>
                                            </div></a></div>
                                    <div class="homeIntern__col"><a href="<?php echo base_path().drupal_get_path_alias('cruises/8827')?>" class="homeIntern__item"><img src="<?php echo $theme?>images/10.jpg">
                                            <div class="homeIntern__text">
                                                <p class="text20 medium"><?php echo t('Families');?></p>
                                            </div></a></div>
                                    <div class="homeIntern__col"><a href="<?php echo base_path().drupal_get_path_alias('cruises/8828')?>" class="homeIntern__item"><img src="<?php echo $theme?>images/11.jpg">
                                            <div class="homeIntern__text">
                                                <p class="text20 medium"><?php echo t('Honey moon');?></p>
                                            </div></a></div>
                                </div>
                            </div>
                        </div>

                        <div class="showMobile">
                            <div class="chooseCruise__slide">
                                <div class="homeIntern__col"><a href="<?php echo base_path().drupal_get_path_alias('cruises/8825')?>" class="homeIntern__item"><img src="<?php echo $theme?>images/8.jpg">
                                        <div class="homeIntern__text">
                                            <p class="text20 medium"><?php echo t('Best cruise');?></p>
                                        </div></a></div>
                                <div class="homeIntern__col"><a href="<?php echo base_path().drupal_get_path_alias('cruises/8826')?>" class="homeIntern__item"><img src="<?php echo $theme?>images/9.jpg">
                                        <div class="homeIntern__text">
                                            <p class="text20 medium"><?php echo t('Luxury');?></p>
                                        </div></a></div>
                                <div class="homeIntern__col"><a href="<?php echo base_path().drupal_get_path_alias('cruises/8827')?>" class="homeIntern__item"><img src="<?php echo $theme?>images/10.jpg">
                                        <div class="homeIntern__text">
                                            <p class="text20 medium"><?php echo t('Families');?></p>
                                        </div></a></div>
                                <div class="homeIntern__col"><a href="<?php echo base_path().drupal_get_path_alias('cruises/8828')?>" class="homeIntern__item"><img src="<?php echo $theme?>images/11.jpg">
                                        <div class="homeIntern__text">
                                            <p class="text20 medium"><?php echo t('Honey moon');?></p>
                                        </div></a></div>
                            </div>

                        </div>
                    </div>
                </div>
                <?php echo blk_popular_destinations();?>
                <?php echo blk_review();?>
                <?php $list_cruise = list_cruise(); ?>

                <div class="homeTop__cruise">
                    <div class="container1">
                        <div class="title1"><span><?php echo t('Top Cruise')?></span></div>
                        <div class="homeCheap__row">
                            <div class="homeCheap__group">
                                <ul class="homeCheap__list">
                                    <?php $i = 0;foreach ($list_cruise as $cruise):?>
                                        <li><a href="<?php echo base_path().drupal_get_path_alias('cruise/'.$cruise['nid'])?>"><span><?php echo $cruise['title'];?></span></a></li>
                                    <?php endforeach;?>

                                </ul>
                            </div>
                        </div>
                        <div class="homeEmail__from">
                            <div class="pd4 w50">
                                <p class="text28 medium blueDark"><?php echo t('Sign up for Exclusive Email-only Coupons');?></p>
                            </div>
                            <div class="pd4 col1">
                                <div class="searchBox__input">
                                    <svg width="24" height="16" viewBox="0 0 24 16" fill="none" xmlns="http://www.w3.org/2000/svg" class="svg1">
                                        <path d="M23.888 1.83199C23.8546 1.8178 23.8177 1.81393 23.782 1.82088C23.7464 1.82783 23.7136 1.84528 23.688 1.87099L13.941 11.616C13.4253 12.1314 12.7261 12.4209 11.997 12.4209C11.2679 12.4209 10.5687 12.1314 10.053 11.616L0.310002 1.87099C0.28451 1.84504 0.251754 1.82743 0.216052 1.82047C0.180349 1.8135 0.143375 1.81752 0.110002 1.83199C0.0772087 1.84612 0.0492947 1.86958 0.0297354 1.89945C0.0101762 1.92932 -0.000164108 1.96429 1.96956e-06 1.99999V14C1.96956e-06 14.5304 0.210716 15.0391 0.585788 15.4142C0.960861 15.7893 1.46957 16 2 16H22C22.5304 16 23.0391 15.7893 23.4142 15.4142C23.7893 15.0391 24 14.5304 24 14V1.99999C24.0001 1.96403 23.9896 1.92885 23.9696 1.89892C23.9497 1.869 23.9212 1.8457 23.888 1.83199Z" fill="#7884B0"></path>
                                        <path d="M11.1146 10.556C11.3493 10.79 11.6672 10.9214 11.9986 10.9214C12.3301 10.9214 12.648 10.79 12.8826 10.556L22.5686 0.87C22.6342 0.804424 22.6803 0.721904 22.7016 0.631664C22.723 0.541423 22.7188 0.447018 22.6896 0.359C22.5796 0.0300002 22.2736 0 21.9996 0H1.99964C1.72464 0 1.41664 0.0300002 1.30864 0.359C1.27944 0.447018 1.27529 0.541423 1.29666 0.631664C1.31803 0.721904 1.36407 0.804424 1.42964 0.87L11.1146 10.556Z" fill="#7884B0"></path>
                                    </svg>
                                    <input type="text" placeholder="example@example.com" id="content_subscribe" class="form-control form-control-lg inputPlace text16">
                                </div>
                            </div>
                            <div class="searchBox__btn pd4 w180"><a class="btn btn-orange btn-lg w-100"><span class="text16" id="btn_subscribe"><?php echo t('Subscribe');?></span></a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<?php echo blk_footer();?>

<script>
    // header
    $(".header__toggle").click(function () {
        $('.navbarBox').addClass('open');
    });
    $(".navbarBox__close, .navbarBox__backdrop").click(function () {
        $('.navbarBox').removeClass('open');
    });
    if (screen.width < 768) {
        $('.navbarBox__list ul').slideUp(300);
        $(".navbarBox__title").click(function () {
            $(this).toggleClass('active');
            $(this).next('.navbarBox__list ul').slideToggle(300);
        });
    };
</script>

<script>
    $(".homeOffers__slide").slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        //autoplay: true,
        speed: 500,
        autoplaySpeed: 5000,
        arrows: true,
        dots: true,
        responsive: [
            {
                breakpoint: 767,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                }
            }
        ]
    });
</script>
<script>
    $(".homeIntern__slide").slick({
        slidesToShow: 3,
        slidesToScroll: 1,
        //autoplay: true,
        speed: 500,
        autoplaySpeed: 5000,
        arrows: true,
        dots: false,
        responsive: [
            {
                breakpoint: 767,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                }
            }
        ]
    });

    $(".homePackages__slide").slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        //autoplay: true,
        speed: 500,
        autoplaySpeed: 5000,
        arrows: true,
        dots: true,
        responsive: [
            {
                breakpoint: 767,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                }
            }
        ]
    });

    $(".homeDestinations__slide").slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        //autoplay: true,
        speed: 500,
        autoplaySpeed: 5000,
        arrows: true,
        dots: true,
        responsive: [
            {
                breakpoint: 767,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                }
            }
        ]
    });

    $(".chooseCruise__slide").slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        //autoplay: true,
        speed: 500,
        autoplaySpeed: 5000,
        arrows: true,
        dots: true,
        responsive: [
            {
                breakpoint: 767,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                }
            }
        ]
    });
    $(".homeClients__slide").slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        //autoplay: true,
        speed: 500,
        autoplaySpeed: 5000,
        arrows: true,
        dots: true,
        responsive: [
            {
                breakpoint: 767,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                }
            }
        ]
    });




</script>

