
<div class="homeDestinations">
    <div class="container__hide">
        <div class="title__cont">
            <div class="title1">
                <p><?php echo t("Today's top Destinations in Vietnam")?></p>
            </div>
            <p><?php echo t("See what is trending now!")?></p>
        </div>
        <div class="showDesktop">
            <div class="homeDestinations__group">
                <div class="homeDestinations__row">
                    <?php if(isset($data['destination']) && count($data['destination']) > 0):?>
                        <?php $i=1; foreach ($data['destination'] as $ob):?>
                            <?php if($i<5):?>
                                <div class="homeDestinations__item">
                                    <div class="destinations">
                                        <div class="destinations__img">
                                            <img src="<?php echo isset($ob['thumbnail'])?$ob['thumbnail']:''?>">
                                        </div>
                                        <div class="destinations__cont">
                                            <div class="offers__top">
                                                <p class="text16 medium blueDark">
                                                    <a target="_blank" href="<?php echo  base_path().drupal_get_path_alias('detail/'.$ob['nid'])?>"><?php echo $ob['title']?></a></p>
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
        <div class="showMobile">
            <div class="homeDestinations__slide">
                <?php if(isset($data['destination']) && count($data['destination']) > 0):?>
                    <?php foreach ($data['destination'] as $ob):?>

                        <div class="homeDestinations__item">
                            <div class="destinations">
                                <div class="destinations__img">
                                    <img src="<?php echo isset($ob['thumbnail'])?$ob['thumbnail']:''?>">
                                </div>
                                <div class="destinations__cont">
                                    <div class="offers__top">
                                        <p class="text16 medium blueDark">
                                            <a href="<?php echo  base_path().drupal_get_path_alias('detail/'.$ob['nid'])?>"><?php echo $ob['title']?></a></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <?php endforeach;?>
                <?php endif;?>


            </div>

        </div>

    </div>
</div>