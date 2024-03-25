<?php $lang = isset($_SESSION['lang'])?$_SESSION['lang']:'en';?>
<div class="homeOffers">
    <div class="container__hide">
        <div class="title__cont">
            <div class="title1">
                <p><?php echo t('Explore Our Top Cruise Line')?></p>
            </div>
            <p><?php echo t('Offering a variety of cruise lines to meet all your budget and travel needs')?></p>
        </div>

        <div class="showDesktop">
            <div class="homeOffers__slide">
                <?php $i=0; if(count($data['cruise']) > 0): ?>
                    <?php foreach ($data['cruise'] as $ob): ?>
                        <?php if($i % 8 == 0 || $i == 0): ?>
                            <div class="homeOffers__group">
                                <div class="homeOffers__row">
                        <?php endif; ?>
                                     <div class="homeOffers__item">
                                        <div class="offers">
                                            <div class="offers__img"><img nid="<?php echo $ob['cruise_nid']?>" src="<?php echo isset($ob['cruise_img'][0])?$ob['cruise_img'][0]:''?>"></div>
                                            <div class="offers__cont">
                                                <div class="offers__top">
                                                    <p class="text16 medium blueDark cruise_name">
                                                        <a class="blueDark" href="<?php echo base_path().drupal_get_path_alias('cruise/'.$ob['cruise_nid'].'/'.$ob['nid'])?>"><?php echo $ob['cruise_name'].' - '.$ob['title']?></a>
                                                    </p>
                                                    <p class="offers__stars">
                                                        <?php if(isset($ob['star'])):
                                                            echo html_star($ob['star']);
                                                            ?>

                                                        <?php endif;?>

                                                    </p>
                                                </div>
                                                <div class="offers__bot">
                                                    <p class="offers__address blueDark45 text12"><svg xmlns="http://www.w3.org/2000/svg" width="10" height="14" viewBox="0 0 10 14" fill="none">
                                                            <path d="M4.99967 0.333374C2.41967 0.333374 0.333008 2.42004 0.333008 5.00004C0.333008 8.50004 4.99967 13.6667 4.99967 13.6667C4.99967 13.6667 9.66634 8.50004 9.66634 5.00004C9.66634 2.42004 7.57967 0.333374 4.99967 0.333374ZM4.99967 6.66671C4.07967 6.66671 3.33301 5.92004 3.33301 5.00004C3.33301 4.08004 4.07967 3.33337 4.99967 3.33337C5.91967 3.33337 6.66634 4.08004 6.66634 5.00004C6.66634 5.92004 5.91967 6.66671 4.99967 6.66671Z" fill="#5562DA"/>
                                                        </svg><?php echo isset($ob['itinerary_text'])?$ob['itinerary_text']:'' ?></p>
                                                    <div class="offers__price">
                                                        <div class="offers__reviews">
                                                            <p class="point__reviews"><?php echo isset($ob['point'])?$ob['point']:'' ?></p>
                                                            <p class="blueDark45"><?php echo isset($ob['review'])?$ob['review']:'' ?> <?php echo t('reviews');?></p>
                                                        </div>
                                                        <p class="text16 colorGreen45 medium"><?php $price = isset($ob['min_price'])?$ob['min_price']:0 ?><span class="text12"><?php echo $lang == 'vi'?'Từ ':'From ' ?></span><?php echo show_price($price) ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                 </div>

                        <?php if($i % 8 == 7 || $i == (count($data['cruise']) - 1)): ?>
                                </div>
                            </div>
                        <? endif; ?>
                    <?php $i++; endforeach; ?>
                <?php endif; ?>
            </div>


        </div>

        <div class="showMobile">
            <div class="homeOffers__slide">
                <?php if(count($data['cruise']) > 0):?>
                <?php $i = 1; foreach ($data['cruise'] as $ob):?>
                    <?php if($i < 9):?>
                        <div class="homeOffers__group" nid="<?php echo $ob['nid']?>">
                            <div class="homeOffers__row">
                                <div class="homeOffers__item">
                                    <div class="offers">
                                        <div class="offers__img"><img src="<?php echo isset($ob['cruise_img'][0])?$ob['cruise_img'][0]:''?>"></div>
                                        <div class="offers__cont">
                                            <div class="offers__top">
                                                <p class="text16 medium blueDark"><a class="blueDark" href="<?php echo base_path().drupal_get_path_alias('cruise/'.$ob['cruise_nid'].'/'.$ob['nid'])?>"><?php echo $ob['cruise_name'].' '.$ob['title']?></a></p>
                                                <p class="offers__stars">
                                                    <?php if(isset($ob['star'])):
                                                        echo html_star($ob['star']);
                                                        ?>

                                                    <?php endif;?>
                                                </p>
                                            </div>
                                            <div class="offers__bot">
                                                <p class="offers__address blueDark45 text12"><svg xmlns="http://www.w3.org/2000/svg" width="10" height="14" viewBox="0 0 10 14" fill="none">
                                                        <path d="M4.99967 0.333374C2.41967 0.333374 0.333008 2.42004 0.333008 5.00004C0.333008 8.50004 4.99967 13.6667 4.99967 13.6667C4.99967 13.6667 9.66634 8.50004 9.66634 5.00004C9.66634 2.42004 7.57967 0.333374 4.99967 0.333374ZM4.99967 6.66671C4.07967 6.66671 3.33301 5.92004 3.33301 5.00004C3.33301 4.08004 4.07967 3.33337 4.99967 3.33337C5.91967 3.33337 6.66634 4.08004 6.66634 5.00004C6.66634 5.92004 5.91967 6.66671 4.99967 6.66671Z" fill="#5562DA"/>
                                                    </svg><?php echo isset($ob['itinerary_text'])?$ob['itinerary_text']:''?></p>
                                                <div class="offers__price">
                                                    <div class="offers__reviews">
                                                        <p class="point__reviews"><?php echo isset($ob['point'])?$ob['point']:''?></p>
                                                        <p class="blueDark45"><?php echo isset($ob['review'])?$ob['review']:''?> <?php echo t('reviews');?></p>
                                                    </div>
                                                    <p class="text16 colorGreen45 medium"><?php $price = isset($ob['min_price'])?$ob['min_price']:0; echo show_price($price)?></p>
                                                </div>
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

