<?php
$theme = '/sites/all/themes/newtheme/';
?>
<div class="homeClients">
    <div class="container__hide">
        <div class="title1"><span><?php echo t('Review from our clients');?></span></div>
        <div class="showDesktop">
            <div class="homeClients__group">
            <div class="homeClients__row">
                <?php if(isset($data['review']) && count($data['review']) > 0):?>
                    <?php foreach ($data['review'] as $ob):
                        if(isset($ob['avatar'])) {
                            $avatar = $ob['avatar'];
                        } else {
                            $avatar = $theme.'images/avatar.jpg';
                        }
                        $country = isset($ob['field_country']['und'][0]['value'])?$ob['field_country']['und'][0]['value']:'United States';
                        ?>
                         <div class="homeClients__item">
                        <div class="clients">
                            <div class="homeClients__user">
                                <div class="homeClients__img">
                                    <img  src="<?php echo $avatar?>" nid="<?php echo $ob['nid']?>">
                                    <div class="nameClients">
                                        <p class="text16 medium blueDark"><?php echo $ob['field_author']['und'][0]['value']?></p>
                                        <p class="clientAdd text12 blueDark45"><svg xmlns="http://www.w3.org/2000/svg" width="10" height="14" viewBox="0 0 10 14" fill="none">
                                                <path d="M4.99967 0.333374C2.41967 0.333374 0.333008 2.42004 0.333008 5.00004C0.333008 8.50004 4.99967 13.6667 4.99967 13.6667C4.99967 13.6667 9.66634 8.50004 9.66634 5.00004C9.66634 2.42004 7.57967 0.333374 4.99967 0.333374ZM4.99967 6.66671C4.07967 6.66671 3.33301 5.92004 3.33301 5.00004C3.33301 4.08004 4.07967 3.33337 4.99967 3.33337C5.91967 3.33337 6.66634 4.08004 6.66634 5.00004C6.66634 5.92004 5.91967 6.66671 4.99967 6.66671Z" fill="#5562DA"/>
                                            </svg><?php echo $country?></p>
                                    </div>
                                </div>
                                <div class="homeClients__point">
                                    <p class="medium blueP400"><?php echo $ob['title']?></p>
                                    <p class="points"><?php echo $ob['field_point']['und'][0]['value']?></p>
                                </div>
                            </div>
                            <p class="blueDark"><?php echo strip_tags($ob['body']['und'][0]['value'])?></p>
                            <p class="blueDark45 text12 date"><?php echo isset($ob['field_date'][0]['value'])?$ob['field_date'][0]['value']:'-'?></p>
                        </div>
                    </div>
                    <?php endforeach;?>
                <?php endif;?>

            </div>
        </div>
        </div>
        <div class="showMobile">
            <div class="homeClients__slide">
                <?php if(isset($data['review']) && count($data['review']) > 0):?>
                    <?php foreach ($data['review'] as $ob):
                        if(isset($ob['avatar'])) {
                            $avatar = $ob['avatar'];
                        } else {
                            $avatar = $theme.'images/avatar.jpg';
                        }
                        $country = isset($ob['field_country']['und'][0]['value'])?$ob['field_country']['und'][0]['value']:'United States';
                        ?>
                        <div class="homeClients__item">
                            <div class="clients">
                                <div class="homeClients__user">
                                    <div class="homeClients__img">
                                        <img  src="<?php echo $avatar?>">
                                        <div class="nameClients">
                                            <p class="text16 medium blueDark"><?php echo $ob['field_author']['und'][0]['value']?></p>
                                            <p class="clientAdd text12 blueDark45"><svg xmlns="http://www.w3.org/2000/svg" width="10" height="14" viewBox="0 0 10 14" fill="none">
                                                    <path d="M4.99967 0.333374C2.41967 0.333374 0.333008 2.42004 0.333008 5.00004C0.333008 8.50004 4.99967 13.6667 4.99967 13.6667C4.99967 13.6667 9.66634 8.50004 9.66634 5.00004C9.66634 2.42004 7.57967 0.333374 4.99967 0.333374ZM4.99967 6.66671C4.07967 6.66671 3.33301 5.92004 3.33301 5.00004C3.33301 4.08004 4.07967 3.33337 4.99967 3.33337C5.91967 3.33337 6.66634 4.08004 6.66634 5.00004C6.66634 5.92004 5.91967 6.66671 4.99967 6.66671Z" fill="#5562DA"/>
                                                </svg><?php echo $country?></p>
                                        </div>
                                    </div>
                                    <div class="homeClients__point">
                                        <p class="medium blueP400"><?php echo $ob['title']?></p>
                                        <p class="points"><?php echo $ob['field_point']['und'][0]['value']?></p>
                                    </div>
                                </div>
                                <p class="blueDark"><?php echo strip_tags($ob['body']['und'][0]['value'])?></p>
                                <p class="blueDark45 text12 date"><?php echo $ob['field_date'][0]['value']?></p>
                            </div>
                        </div>
                    <?php endforeach;?>
                <?php endif;?>



            </div>

        </div>
    </div>
</div>