<?php
$theme = '/sites/all/themes/newtheme/';
$cruises = list_cruise_by_ids();
//$percents = array(25,30,35);
//print_r($cruises);die;
$discount = _get_discount();

$cruise_exist = array();
?>
<div style="background-image: url(<?php echo $theme?>images/deals1.jpg);" class="dealBanner">
    <div class="dealTitle container-auto">
        <p class="medium"><?php echo t('THE BEST CRUISE DEALS');?></p>
        <p class="colorWhite text24"><?php echo t('Find the best cruise deals for your vacation');?></p>
    </div>
</div>
<div class="bestDeals">
    <div class="container-auto">
        <div class="bestDeals__slide">
            <div class="bestDeals__group">
                <div class="bestDeals__row">
                    <?php if(count($data['itinerary']) > 0):?>
                        <?php foreach ($data['itinerary'] as $ob):
                            $cruise_id = $ob['cruise_nid'];
                            $img = '';
                            ?>

                            <?php if(!in_array($cruise_id,$cruise_exist)):
                            $price = $ob['min_price'];

                            $chua_giam_gia = $price;//round($price/(1 - $percent/100));
                            $discount_value = '';
                            $did = '';
                            $discount_title = '';

                            $discount_body = '';
                            $percent_goc = 0;
                            if(count($discount) > 0) {
                                foreach ($discount as $dis_obj) {
                                   // print_r($dis_obj);
                                    $cruise_discount = isset($dis_obj['cruise'])?$dis_obj['cruise']:array();
                                    if(in_array($cruise_id,$cruise_discount) ) {
                                        if($dis_obj['doi_tuong_giam_adult'] == 1 && $dis_obj['don_vi'] != 'percent') {
                                            if($dis_obj['don_vi'] == 'percent') {
                                                $discount_value = $dis_obj['so_tien_giam'].'%';
                                                $display_fare = $price - round($dis_obj['so_tien_giam'] * $price/100);
                                            } else {
                                                $discount_value = show_price($dis_obj['so_tien_giam']);
                                                $display_fare = $chua_giam_gia - $dis_obj['so_tien_giam'];
                                            }
                                        }

                                        if($dis_obj['don_vi'] == 'percent') {
                                            $discount_value = $dis_obj['so_tien_giam'].'%';
                                        } else {
                                            $discount_value = show_price($dis_obj['so_tien_giam']);

                                        }

                                        $did = $dis_obj['nid'];
                                        $discount_title = $dis_obj['title'];
                                        $discount_body = $dis_obj['body'];

                                        if($dis_obj['image'] != '') {
                                            $img = $dis_obj['image'];
                                        } else {
                                            $img = '';
                                        }



                                    }



                                }
                            }



                            ?>
                            <div class="bestDeals__item">
                                <div class="deals">
                                    <div class="deals__img">
                                        <img src="<?php echo ($img != '')?$img:$ob['cruise_img'][0] ?>">
                                        <svg width="20" height="19" viewBox="0 0 20 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M9.44376 2.90005L9.99994 3.51506L10.5562 2.90013C12.4289 0.829975 15.6354 0.773233 17.5809 2.71882C18.4971 3.63494 19 4.84893 19 6.14474C19 7.4406 18.497 8.65447 17.5811 9.56972L17.5809 9.56993L10 17.1516L2.4191 9.57066L2.41891 9.57047C1.50309 8.6553 1.00002 7.44071 1.00002 6.14474L1.00002 6.14265C0.998243 5.5068 1.12262 4.87691 1.36596 4.28946C1.60929 3.70201 1.96674 3.16866 2.41761 2.7203L2.41762 2.72031L2.4191 2.71882C4.36418 0.773744 7.57055 0.828748 9.44376 2.90005Z" stroke="white" stroke-width="1.5"/>
                                        </svg>
                                        <?php if($discount_value != ''):?>
                                        <p>-<?php echo $discount_value?></p>
                                        <?php endif;?>
                                    </div>
                                    <div class="deals__cont">
                                        <div class="deals__top">
                                            <p class="text16 medium blueDark"><a href="<?php echo base_path().drupal_get_path_alias('cruise/'.$cruise_id.'/'.$ob['nid'])?>?did=<?php echo  $did?>" target="_blank"><?php echo $discount_title?> - <?php echo $cruises[$cruise_id]['title']?></a></p>
                                            <p class="deals__stars">
                                                <?php echo get_star_html($ob['star'])?>
                                            </p>

                                            <?php if($discount_body != ''):?>
                                                <div class="discount_body">
                                                    <div class="discount_text">
                                                        <?php echo strip_tags($discount_body);?>
                                                    </div>
                                                </div>
                                            <?php endif;?>

                                        </div>
                                        <div class="deals__bot">
                                            <p class="deals__address blueDark45 text12">
                                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#clip0_3514_2750)"><path fill-rule="evenodd" clip-rule="evenodd" d="M2 5.6C2 2.504 4.504 0 7.6 0C10.696 0 13.2 2.504 13.2 5.6C13.2 9.8 7.6 16 7.6 16C7.6 16 2 9.8 2 5.6ZM7.6002 9.59999C9.80933 9.59999 11.6002 7.80913 11.6002 5.59999C11.6002 3.39085 9.80933 1.59999 7.6002 1.59999C5.39106 1.59999 3.6002 3.39085 3.6002 5.59999C3.6002 7.80913 5.39106 9.59999 7.6002 9.59999Z" fill="#5C6AA1"/><path d="M10.5501 6.25926L10.2801 7.96295L9.73255 7.47078C9.35294 7.75996 9.0123 8.49668 7.53399 8.5312C6.35818 8.5312 5.86812 7.86223 5.4358 7.5388L4.93565 7.98737L4.65137 6.29928L6.53003 6.55549L6.0122 7.0204C6.0122 7.0204 6.45629 7.70441 7.22333 7.75218L7.22026 4.972C6.80591 4.83857 6.50731 4.48527 6.50731 4.06707C6.50731 3.53387 6.98784 3.10193 7.58136 3.10193C8.17432 3.10193 8.65568 3.5339 8.65568 4.06707C8.65568 4.49175 8.34729 4.84895 7.92395 4.97691C7.92619 5.51997 7.93601 7.76257 7.92283 7.76257C8.55783 7.7462 9.15248 6.95031 9.15248 6.95031L8.66773 6.51497L10.5501 6.25926ZM8.13592 4.05197C8.13592 3.77759 7.88725 3.55486 7.58139 3.55486C7.27608 3.55486 7.02824 3.77759 7.02824 4.05197C7.02824 4.32689 7.27608 4.55013 7.58139 4.55013C7.88754 4.54986 8.13592 4.32686 8.13592 4.05197Z" fill="#5C6AA1"/></g><defs><clipPath id="clip0_3514_2750"><rect width="16" height="16" fill="white"/></clipPath></defs>
                                                </svg>
                                                <?php echo $ob['itinerary_text']?>
                                            </p>

                                            <div class="deals__price">
                                                <div class="deals__reviews">
                                                    <p class="point__reviews"><?php echo isset($ob['point'])?$ob['point']:''?></p>
                                                    <p class="blueDark45"><?php echo isset($ob['review'])?$ob['review']:''?> reviews</p>
                                                </div>

                                                    <?php if($display_fare > 0):?>
                                                        <div class="dealsPrice__item">
                                                            <p class="blueDark45"><?php echo show_price($chua_giam_gia)?></p>
                                                            <p class="text16 colorGreen45 medium"><?php echo show_price($display_fare) ?></p>
                                                        </div>
                                                    <?php else:?>
                                                        <div class="dealsPrice__item"><span class="text16 colorGreen45 medium"><?php echo show_price($chua_giam_gia)?></span></div>
                                                    <?php endif;?>


                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>
                            <?php

                            array_push($cruise_exist,$cruise_id);
                            endif;?>
                        <?php endforeach;?>

                    <?php endif;?>

                </div>
            </div>

        </div>
        <div class="appendArrows"></div>
    </div>
</div>