<?php
$theme = '/sites/all/themes/newtheme/';
$cruises = $data['cruises'];
$tid = arg(1);
$tran = isset($_REQUEST['t'])?$_REQUEST['t']:'';
$group = array(
        8825 => t('Best Cruise'),
        8827 => t('Family   '),
        8828 => t('Honey moon'),
        8826 => t('Luxury'),
);
$percents = array(25,30,35);//print_r($group);
?>
<div style="background-image: url(<?php echo $theme?>images/best-cruise.jpg);" class="yourCruise__banner">
    <div class="yourCruise__title container-auto">
        <p class="medium"><?php echo t($group[$tid])?></p>

    </div>
</div>
<div class="yourCruise__main">
    <div class="container-auto">
        <div class="yourCruise__group">
            <div class="showDesktop">
                <div class="yourCruise__row">
                <?php if(count($cruises) > 0):?>
                    <?php foreach ($cruises as $ob):

                        if(isset($ob['field_group_cruise']['und']) && count($ob['field_group_cruise']['und']) > 0) {
                            for($t = 0; $t < count($ob['field_group_cruise']['und']); $t++) {

                            }
                        }
                        $show = false;
                        if(isset($ob['field_group_cruise']['und']) && count($ob['field_group_cruise']['und']) > 0) {
                            for($t = 0; $t < count($ob['field_group_cruise']['und']); $t++) {
                                if($tid == $ob['field_group_cruise']['und'][$t]['tid']) {
                                    $show = true;
                                    break;
                                }
                            }
                        }

                        ?>
                        <?php if($show):
                        $price = $ob['min_price'];
                        $idx = rand(0,2);
                        $p = $percents[$idx];
                        $percent = $percents[$idx];

                        $con_lai = $price;
                        $chua_giam_gia = $tien_giam + $con_lai;
                        $display_fare = round($price * 100/$percent);
                        $chua_giam_gia = round($price/(1 - $percent/100));

                        //print_r($ob);
                        //$itinerary_id = array_keys($cruise['itinerary'])[0];

                        ?>
                        <div class="yourCruise__item">
                            <div class="yourCruise">
                                <div class="yourCruise__img">
                                    <img src="<?php echo isset($ob['cruise_img'][0])?$ob['cruise_img'][0]:''?>">
                                    <svg width="20" height="19" viewBox="0 0 20 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M9.44376 2.90005L9.99994 3.51506L10.5562 2.90013C12.4289 0.829975 15.6354 0.773233 17.5809 2.71882C18.4971 3.63494 19 4.84893 19 6.14474C19 7.4406 18.497 8.65447 17.5811 9.56972L17.5809 9.56993L10 17.1516L2.4191 9.57066L2.41891 9.57047C1.50309 8.6553 1.00002 7.44071 1.00002 6.14474L1.00002 6.14265C0.998243 5.5068 1.12262 4.87691 1.36596 4.28946C1.60929 3.70201 1.96674 3.16866 2.41761 2.7203L2.41762 2.72031L2.4191 2.71882C4.36418 0.773744 7.57055 0.828748 9.44376 2.90005Z" stroke="white" stroke-width="1.5"></path>
                                    </svg>
                                </div>
                                <div class="yourCruise__cont">
                                    <div class="yourCruise__top">
                                        <p class="text16 medium blueDark">
                                            <a href="<?php echo base_path().drupal_get_path_alias('cruise/'.$ob['nid'])?>"><?php echo $ob['title']?></a>

                                        </p>
                                        <p class="deals__stars">
                                            <?php if(isset($ob['star'])):
                                                echo html_star($ob['star']);
                                                ?>

                                            <?php endif;?>
                                        </p>
                                    </div>
                                    <div class="yourCruise__bot">
                                        <div class="yourCruise__icon">
                                            <p class="blueDark45"><svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M7.99935 2.00002C4.68564 2.00002 1.99935 4.68631 1.99935 8.00002C1.99935 11.3137 4.68564 14 7.99935 14C11.3131 14 13.9993 11.3137 13.9993 8.00002C13.9993 4.68631 11.3131 2.00002 7.99935 2.00002ZM0.666016 8.00002C0.666016 3.94993 3.94926 0.666687 7.99935 0.666687C12.0494 0.666687 15.3327 3.94993 15.3327 8.00002C15.3327 12.0501 12.0494 15.3334 7.99935 15.3334C3.94926 15.3334 0.666016 12.0501 0.666016 8.00002Z" fill="#5C6AA1"/>
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M7.9987 3.33337C8.36689 3.33337 8.66536 3.63185 8.66536 4.00004V7.58802L10.9635 8.73709C11.2928 8.90175 11.4263 9.3022 11.2616 9.63152C11.097 9.96084 10.6965 10.0943 10.3672 9.92966L7.70056 8.59633C7.4747 8.4834 7.33203 8.25256 7.33203 8.00004V4.00004C7.33203 3.63185 7.63051 3.33337 7.9987 3.33337Z" fill="#5C6AA1"/>
                                                </svg><?php echo t('Launched');?>: <?php echo isset($ob['field_launched']['und'][0]['value'])?$ob['field_launched']['und'][0]['value']:''?>
                                            </p>
                                            <p class="blueDark45"><svg width="15" height="9" viewBox="0 0 15 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M3 5C3.55228 5 4 4.55228 4 4C4 3.44772 3.55228 3 3 3C2.44772 3 2 3.44772 2 4C2 4.55228 2.44772 5 3 5Z" fill="#5C6AA1"/>
                                                    <path d="M5.33333 5H12.4446C12.5517 5 12.6564 4.97217 12.7463 4.91984C12.8362 4.86752 12.9073 4.79293 12.9512 4.70506C12.9951 4.61719 13.0098 4.51977 12.9936 4.42454C12.9774 4.32931 12.931 4.24031 12.86 4.16826C11.4886 2.77964 8.73332 1.9227 5.53933 2.00551C5.39495 2.00925 5.25788 2.06349 5.15719 2.1567C5.0565 2.24992 5.00011 2.37478 5 2.50479V4.69995C5 4.77953 5.03512 4.85585 5.09763 4.91212C5.16014 4.96839 5.24493 5 5.33333 5Z" fill="#5C6AA1"/>
                                                    <path d="M14.375 1.86207C14.2092 1.86207 14.0503 1.92746 13.9331 2.04386C13.8158 2.16027 13.75 2.31814 13.75 2.48276V5.89655C13.75 5.97886 13.7171 6.0578 13.6585 6.116C13.5999 6.1742 13.5204 6.2069 13.4375 6.2069H1.5625C1.47962 6.2069 1.40013 6.1742 1.34153 6.116C1.28292 6.0578 1.25 5.97886 1.25 5.89655V0.62069C1.25 0.456073 1.18415 0.298198 1.06694 0.181796C0.949732 0.065394 0.79076 0 0.625 0C0.45924 0 0.300269 0.065394 0.183058 0.181796C0.065848 0.298198 0 0.456073 0 0.62069L0 8.37931C0 8.54393 0.065848 8.7018 0.183058 8.8182C0.300269 8.93461 0.45924 9 0.625 9C0.79076 9 0.949732 8.93461 1.06694 8.8182C1.18415 8.7018 1.25 8.54393 1.25 8.37931V7.75862C1.25 7.67631 1.28292 7.59737 1.34153 7.53917C1.40013 7.48097 1.47962 7.44828 1.5625 7.44828H13.4375C13.5204 7.44828 13.5999 7.48097 13.6585 7.53917C13.7171 7.59737 13.75 7.67631 13.75 7.75862V8.37931C13.75 8.54393 13.8158 8.7018 13.9331 8.8182C14.0503 8.93461 14.2092 9 14.375 9C14.5408 9 14.6997 8.93461 14.8169 8.8182C14.9342 8.7018 15 8.54393 15 8.37931V2.48276C15 2.31814 14.9342 2.16027 14.8169 2.04386C14.6997 1.92746 14.5408 1.86207 14.375 1.86207Z" fill="#5C6AA1"/>
                                                </svg><?php echo t('Rooms');?>: <?php echo isset($ob['field_total_room']['und'][0]['value'])?$ob['field_total_room']['und'][0]['value']:''?>
                                            </p>
                                            <p class="blueDark45"><svg width="12" height="9" viewBox="0 0 12 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M11.8047 0.528575C12.0651 0.788925 12.0651 1.21103 11.8047 1.47138L4.4714 8.80472C4.21106 9.06507 3.78894 9.06507 3.5286 8.80472L0.195262 5.47138C-0.0650874 5.21103 -0.0650874 4.78892 0.195262 4.52858C0.455612 4.26823 0.877722 4.26823 1.13807 4.52858L4 7.3905L10.8619 0.528575C11.1223 0.268226 11.5444 0.268226 11.8047 0.528575Z" fill="#5C6AA1"/>
                                                </svg><?php echo isset($group[$tid])?t($group[$tid]):''?>
                                            </p>
                                        </div>
                                        <div class="yourCruise__price">
                                            <div class="yourCruise__reviews">
                                                <p class="point__reviews"><?php echo isset($ob['field_point']['und'][0]['value'])?$ob['field_point']['und'][0]['value']:''?></p>
                                                <p class="blueDark45"><?php echo isset($ob['field_review']['und'][0]['value'])?$ob['field_review']['und'][0]['value']:''?> <?php echo t('reviews');?></p>
                                            </div>
                                            <div class="cruisePrice__item">
                                                <p class="blueDark45"><?php echo show_price($chua_giam_gia,0,true)?></p>
                                                <p class="text16 colorGreen45 medium"><?php echo show_price($price,0,true)?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endif;?>
                    <?php endforeach;?>
                <?php endif;?>

                </div>
            </div>
            <div class="showMobile">
                <div class="yourCruise__slide">
                    <?php if(count($cruises) > 0):?>
                        <?php foreach ($cruises as $ob):

                            if(isset($ob['field_group_cruise']['und']) && count($ob['field_group_cruise']['und']) > 0) {
                                for($t = 0; $t < count($ob['field_group_cruise']['und']); $t++) {

                                }
                            }
                            $show = false;
                            if(isset($ob['field_group_cruise']['und']) && count($ob['field_group_cruise']['und']) > 0) {
                                for($t = 0; $t < count($ob['field_group_cruise']['und']); $t++) {
                                    if($tid == $ob['field_group_cruise']['und'][$t]['tid']) {
                                        $show = true;
                                        break;
                                    }
                                }
                            }

                            ?>
                            <?php if($show):
                            $price = $ob['min_price'];
                            $idx = rand(0,2);
                            $p = $percents[$idx];
                            $percent = $percents[$idx];

                            $con_lai = $price;
                            $chua_giam_gia = $tien_giam + $con_lai;
                            $display_fare = round($price * 100/$percent);
                            $chua_giam_gia = round($price/(1 - $percent/100));

                            ?>
                            <div class="yourCruise__item">
                                <div class="yourCruise">
                                    <div class="yourCruise__img">
                                        <img src="<?php echo isset($ob['cruise_img'][0])?$ob['cruise_img'][0]:''?>">
                                        <svg width="20" height="19" viewBox="0 0 20 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M9.44376 2.90005L9.99994 3.51506L10.5562 2.90013C12.4289 0.829975 15.6354 0.773233 17.5809 2.71882C18.4971 3.63494 19 4.84893 19 6.14474C19 7.4406 18.497 8.65447 17.5811 9.56972L17.5809 9.56993L10 17.1516L2.4191 9.57066L2.41891 9.57047C1.50309 8.6553 1.00002 7.44071 1.00002 6.14474L1.00002 6.14265C0.998243 5.5068 1.12262 4.87691 1.36596 4.28946C1.60929 3.70201 1.96674 3.16866 2.41761 2.7203L2.41762 2.72031L2.4191 2.71882C4.36418 0.773744 7.57055 0.828748 9.44376 2.90005Z" stroke="white" stroke-width="1.5"></path>
                                        </svg>
                                    </div>
                                    <div class="yourCruise__cont">
                                        <div class="yourCruise__top">
                                            <p class="text16 medium blueDark">
                                                <a href="<?php echo base_path().drupal_get_path_alias('cruise/'.$ob['nid'])?>"><?php echo $ob['title']?></a>

                                            </p>
                                            <p class="deals__stars">
                                                <?php if(isset($ob['star'])):
                                                    echo html_star($ob['star']);
                                                    ?>

                                                <?php endif;?>
                                            </p>
                                        </div>
                                        <div class="yourCruise__bot">
                                            <div class="yourCruise__icon">
                                                <p class="blueDark45"><svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M7.99935 2.00002C4.68564 2.00002 1.99935 4.68631 1.99935 8.00002C1.99935 11.3137 4.68564 14 7.99935 14C11.3131 14 13.9993 11.3137 13.9993 8.00002C13.9993 4.68631 11.3131 2.00002 7.99935 2.00002ZM0.666016 8.00002C0.666016 3.94993 3.94926 0.666687 7.99935 0.666687C12.0494 0.666687 15.3327 3.94993 15.3327 8.00002C15.3327 12.0501 12.0494 15.3334 7.99935 15.3334C3.94926 15.3334 0.666016 12.0501 0.666016 8.00002Z" fill="#5C6AA1"/>
                                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M7.9987 3.33337C8.36689 3.33337 8.66536 3.63185 8.66536 4.00004V7.58802L10.9635 8.73709C11.2928 8.90175 11.4263 9.3022 11.2616 9.63152C11.097 9.96084 10.6965 10.0943 10.3672 9.92966L7.70056 8.59633C7.4747 8.4834 7.33203 8.25256 7.33203 8.00004V4.00004C7.33203 3.63185 7.63051 3.33337 7.9987 3.33337Z" fill="#5C6AA1"/>
                                                    </svg><?php echo t('Launched');?>: <?php echo isset($ob['field_launched']['und'][0]['value'])?$ob['field_launched']['und'][0]['value']:''?>
                                                </p>
                                                <p class="blueDark45"><svg width="15" height="9" viewBox="0 0 15 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M3 5C3.55228 5 4 4.55228 4 4C4 3.44772 3.55228 3 3 3C2.44772 3 2 3.44772 2 4C2 4.55228 2.44772 5 3 5Z" fill="#5C6AA1"/>
                                                        <path d="M5.33333 5H12.4446C12.5517 5 12.6564 4.97217 12.7463 4.91984C12.8362 4.86752 12.9073 4.79293 12.9512 4.70506C12.9951 4.61719 13.0098 4.51977 12.9936 4.42454C12.9774 4.32931 12.931 4.24031 12.86 4.16826C11.4886 2.77964 8.73332 1.9227 5.53933 2.00551C5.39495 2.00925 5.25788 2.06349 5.15719 2.1567C5.0565 2.24992 5.00011 2.37478 5 2.50479V4.69995C5 4.77953 5.03512 4.85585 5.09763 4.91212C5.16014 4.96839 5.24493 5 5.33333 5Z" fill="#5C6AA1"/>
                                                        <path d="M14.375 1.86207C14.2092 1.86207 14.0503 1.92746 13.9331 2.04386C13.8158 2.16027 13.75 2.31814 13.75 2.48276V5.89655C13.75 5.97886 13.7171 6.0578 13.6585 6.116C13.5999 6.1742 13.5204 6.2069 13.4375 6.2069H1.5625C1.47962 6.2069 1.40013 6.1742 1.34153 6.116C1.28292 6.0578 1.25 5.97886 1.25 5.89655V0.62069C1.25 0.456073 1.18415 0.298198 1.06694 0.181796C0.949732 0.065394 0.79076 0 0.625 0C0.45924 0 0.300269 0.065394 0.183058 0.181796C0.065848 0.298198 0 0.456073 0 0.62069L0 8.37931C0 8.54393 0.065848 8.7018 0.183058 8.8182C0.300269 8.93461 0.45924 9 0.625 9C0.79076 9 0.949732 8.93461 1.06694 8.8182C1.18415 8.7018 1.25 8.54393 1.25 8.37931V7.75862C1.25 7.67631 1.28292 7.59737 1.34153 7.53917C1.40013 7.48097 1.47962 7.44828 1.5625 7.44828H13.4375C13.5204 7.44828 13.5999 7.48097 13.6585 7.53917C13.7171 7.59737 13.75 7.67631 13.75 7.75862V8.37931C13.75 8.54393 13.8158 8.7018 13.9331 8.8182C14.0503 8.93461 14.2092 9 14.375 9C14.5408 9 14.6997 8.93461 14.8169 8.8182C14.9342 8.7018 15 8.54393 15 8.37931V2.48276C15 2.31814 14.9342 2.16027 14.8169 2.04386C14.6997 1.92746 14.5408 1.86207 14.375 1.86207Z" fill="#5C6AA1"/>
                                                    </svg><?php echo t('Rooms');?>: <?php echo isset($ob['field_total_room']['und'][0]['value'])?$ob['field_total_room']['und'][0]['value']:''?>
                                                </p>
                                                <p class="blueDark45"><svg width="12" height="9" viewBox="0 0 12 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M11.8047 0.528575C12.0651 0.788925 12.0651 1.21103 11.8047 1.47138L4.4714 8.80472C4.21106 9.06507 3.78894 9.06507 3.5286 8.80472L0.195262 5.47138C-0.0650874 5.21103 -0.0650874 4.78892 0.195262 4.52858C0.455612 4.26823 0.877722 4.26823 1.13807 4.52858L4 7.3905L10.8619 0.528575C11.1223 0.268226 11.5444 0.268226 11.8047 0.528575Z" fill="#5C6AA1"/>
                                                    </svg><?php echo isset($group[$tid])?t($group[$tid]):''?>
                                                </p>
                                            </div>
                                            <div class="yourCruise__price">
                                                <div class="yourCruise__reviews">
                                                    <p class="point__reviews"><?php echo isset($ob['field_point']['und'][0]['value'])?$ob['field_point']['und'][0]['value']:''?></p>
                                                    <p class="blueDark45"><?php echo isset($ob['field_review']['und'][0]['value'])?$ob['field_review']['und'][0]['value']:''?> <?php echo t('reviews');?></p>
                                                </div>
                                                <div class="cruisePrice__item">
                                                    <p class="blueDark45"><?php echo show_price($chua_giam_gia,0,true)?></p>
                                                    <p class="text16 colorGreen45 medium"><?php echo show_price($price,0,true) ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif;?>
                        <?php endforeach;?>
                    <?php endif;?>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
    $(".yourCruise__slide").slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        //autoplay: true,
        speed: 800,
        autoplaySpeed: 5000,
        arrows: true,
        dots: true,
        appendArrows: '.appendArrows',
        responsive: [
            {
                breakpoint: 767,
                settings: {
                    arrows: true
                }
            }
        ]
    });
</script>