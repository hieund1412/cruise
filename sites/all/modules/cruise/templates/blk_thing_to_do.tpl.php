
<div class="homePackages">
    <div class="container__hide">
        <div class="title__cont">
            <div class="title1">
                <p><?php echo t('Things To Do')?></p>
            </div>
            <p><?php echo t('Start Unmissable Activities at Ha Long Bay')?></p>
        </div>
        <div class="showDesktop">
            <div class="homePackages__group">
                <div class="homePackages__row thing_to_do">
                    <?php if(isset($data['thing_to_do']) && count($data['thing_to_do']) > 0):?>
                        <?php foreach ($data['thing_to_do'] as $ob):?>
                            <div class="homePackages__item">
                                <div class="offers">
                                    <div class="packages__img">
                                        <img src="<?php echo $ob['thumbnail']?>">
                                    </div>
                                    <div class="packages__cont">
                                        <div class="offers__top">
                                            <p class="text16 medium blueDark"><?php echo $ob['title']?></p>
                                            <p class="text14 blueDark"><?php echo truncate_utf8( strip_tags($ob['body_value']),80,true)?></p>
                                            <a href="<?php echo base_path().drupal_get_path_alias('detail/'.$ob['nid'])?>">
                                            <button class="medium orgColor packages__more"><?php echo t('View more');?><svg xmlns="http://www.w3.org/2000/svg" width="16" height="8" viewBox="0 0 16 8" fill="none">
                                                    <path d="M15.8047 3.52731L12.6193 0.341981C12.5261 0.248775 12.4073 0.185304 12.278 0.159592C12.1487 0.13388 12.0147 0.147082 11.8929 0.197529C11.7711 0.247975 11.667 0.333402 11.5937 0.443009C11.5205 0.552615 11.4814 0.681481 11.4813 0.813314V2.83198C11.4813 2.87618 11.4638 2.91858 11.4325 2.94983C11.4013 2.98109 11.3589 2.99865 11.3147 2.99865H1C0.734784 2.99865 0.48043 3.104 0.292893 3.29154C0.105357 3.47908 0 3.73343 0 3.99865C0 4.26386 0.105357 4.51822 0.292893 4.70575C0.48043 4.89329 0.734784 4.99865 1 4.99865H11.3147C11.3589 4.99865 11.4013 5.01621 11.4325 5.04746C11.4638 5.07872 11.4813 5.12111 11.4813 5.16531V7.18398C11.4814 7.31581 11.5205 7.44468 11.5937 7.55429C11.667 7.66389 11.7711 7.74932 11.8929 7.79977C12.0147 7.85021 12.1487 7.86342 12.278 7.8377C12.4073 7.81199 12.5261 7.74852 12.6193 7.65531L15.8047 4.46998C15.9296 4.34496 15.9999 4.17542 15.9999 3.99865C15.9999 3.82187 15.9296 3.65233 15.8047 3.52731Z" fill="#FD6431"/>
                                                </svg></button>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach;?>
                    <?php endif;?>

                </div>

            </div>
        </div>

        <div class="showMobile">
            <div class="homePackages__slide ">
                <?php if(isset($data['thing_to_do']) && count($data['thing_to_do']) > 0):?>
                <?php $i = 1; foreach ($data['thing_to_do'] as $ob):?>
                     <?php if($i < 9):?>
                        <div class="homePackages__group">
                            <div class="homePackages__row">
                                <div class="homePackages__item">
                                    <div class="offers">
                                        <div class="packages__img">
                                            <img src="<?php echo $ob['thumbnail']?>">
                                            <div class="packages__name"><p><?php echo $ob['title']?></p></div>
                                        </div>
                                        <div class="packages__cont">
                                            <div class="offers__top">
                                                <p class="text16 medium blueDark"><?php echo $ob['title']?></p>
                                                <p class="text14 blueDark"><?php echo truncate_utf8( strip_tags($ob['body_value']),80,true)?></p>
                                                <a href="<?php echo base_path().drupal_get_path_alias('detail/'.$ob['nid'])?>">
                                                <button class="medium orgColor packages__more"><?php echo t('View more');?><svg xmlns="http://www.w3.org/2000/svg" width="16" height="8" viewBox="0 0 16 8" fill="none">
                                                        <path d="M15.8047 3.52731L12.6193 0.341981C12.5261 0.248775 12.4073 0.185304 12.278 0.159592C12.1487 0.13388 12.0147 0.147082 11.8929 0.197529C11.7711 0.247975 11.667 0.333402 11.5937 0.443009C11.5205 0.552615 11.4814 0.681481 11.4813 0.813314V2.83198C11.4813 2.87618 11.4638 2.91858 11.4325 2.94983C11.4013 2.98109 11.3589 2.99865 11.3147 2.99865H1C0.734784 2.99865 0.48043 3.104 0.292893 3.29154C0.105357 3.47908 0 3.73343 0 3.99865C0 4.26386 0.105357 4.51822 0.292893 4.70575C0.48043 4.89329 0.734784 4.99865 1 4.99865H11.3147C11.3589 4.99865 11.4013 5.01621 11.4325 5.04746C11.4638 5.07872 11.4813 5.12111 11.4813 5.16531V7.18398C11.4814 7.31581 11.5205 7.44468 11.5937 7.55429C11.667 7.66389 11.7711 7.74932 11.8929 7.79977C12.0147 7.85021 12.1487 7.86342 12.278 7.8377C12.4073 7.81199 12.5261 7.74852 12.6193 7.65531L15.8047 4.46998C15.9296 4.34496 15.9999 4.17542 15.9999 3.99865C15.9999 3.82187 15.9296 3.65233 15.8047 3.52731Z" fill="#FD6431"/>
                                                    </svg></button>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endif;?>
                <?php $i++; endforeach;?>
                <?php endif;?>


            </div>

        </div>

    </div>
</div>

<script>
    $(".thing_to_do").slick({
        slidesToShow: 3,
        slidesToScroll: 3,
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