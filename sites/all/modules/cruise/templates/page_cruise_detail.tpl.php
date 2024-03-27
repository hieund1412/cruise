<?php
global $conf;
$lang = (isset($_SESSION['lang']) && $_SESSION['lang'] != '')?$_SESSION['lang']:'en';
$theme = '/sites/all/themes/newtheme/';
$cruise_img = isset($data['info']['field_cruise_image']['und'])?$data['info']['field_cruise_image']['und']:array();
$rooms = $data['rooms'];
$itinerary = null;
$itinerary_id = arg(2);
if(isset($data['itinerary'][$itinerary_id])) {
    $itinerary = $data['itinerary'][$itinerary_id];
}
//print_r($data['info']);

$list_amenities = list_amenities();

//print_r($_SESSION['search_param']);
$tran = isset($_REQUEST['t'])?$_REQUEST['t']:0;
$search_param = array();

if($tran > 0 && isset($_SESSION['search_param'][$tran])) {
    $search_param = $_SESSION['search_param'][$tran];
    //thông tin cruise
    $cruise_id = $search_param['cruise'];
    $cruise_obj =  detail_cruise($cruise_id);
    $itinerary_id = $search_param['arg2'];
    $itinerary = isset($cruise_obj['itinerary'][$itinerary_id])?$cruise_obj['itinerary'][$itinerary_id]:array();
    //số hành khách
    $num_adult = 0;
    $num_child = 0;
    $num_infant = 0;
    for($r = 0; $r < $search_param['no_room']; $r++) {
        $num_adult += $search_param['adult'][$r];
        $num_child += $search_param['child'][$r];
        $num_infant += $search_param['infant'][$r];

    }
    //hình ảnh cruise
    $cruise_img_detail = isset($cruise_obj['info']['field_cruise_image']['und'][0]['uri'])? $cruise_obj['info']['field_cruise_image']['und'][0]['uri']:'';
    $cruise_img_detail = file_create_url($cruise_img_detail);
    $cruise_img_detail = convert_img_url($cruise_img_detail);
    //hành trình
    $is_full_day = false;
    if(isset($search_param['duration']) && $search_param['duration'] == 'full_day') {
        $is_full_day = true;
    }
    $depart = strtotime($search_param['depart']);
    $num_day = substr($search_param['duration'],0,1);
    $num_day = filter_var($num_day,FILTER_SANITIZE_NUMBER_INT) - 1;
    if($num_day > 0) {
        $return = date('Y-m-d', strtotime($search_param['depart'] . ' +'.$num_day.' days'));
    } else {
        $return = $search_param['depart'];
    }
    $return = strtotime($return);
    if($is_full_day) {
        $return = $depart;
    }

    //discount
    $discount = get_discount_for_booking($cruise_id,$search_param['duration'],$search_param);
//    var_dump($discount);
} else {
   // $_SESSION['search_param'] = null;
}
$min = 9999999999999999999999;
$passenger_info_number = '';

$lang = isset($_SESSION['lang'])?$_SESSION['lang']:'en';


$web_info = web_info();
$site_email = $web_info['field_site_email']['und'][0]['value'];

$discount_content = '';
$discount = _get_discount();
if(isset($_REQUEST['did']) && $_REQUEST['did'] > 0) {
    $did = $_REQUEST['did'];

} else {
    for($d = 0; $d < count($discount); $d++) {
        //  print_r($discount[$d]);
        if( (in_array($data['info']['nid'],$discount[$d]['cruise'])) || count($discount[$d]['cruise']) == 0 ) {

            $did = $discount[$d]['nid'];
            break;

        }
        // $discount_nid = $discount[$d]['nid'];

    }
}

if($did > 0) {
    $discount_obj = _get_node($did);//print_r($discount_obj);
    $discount_content = isset($discount_obj['body']['und'][0]['value'])?$discount_obj['body']['und'][0]['value']:'';
    $discount_content = strip_tags($discount_content);
    $discount_content = trim($discount_content);
}


if($lang == 'en') {
    $passenger_info_number_single = 'The maximum occupancy in cabin is an (1) adult and one (1) child under 4 years old. The charged will applied if the maximum number of guests is exceeded.';
    $passenger_info_number_double = 'The maximum occupancy in cabin is two (2) adult and one (1) child under 4 years old. The charged will applied if the maximum number of guests is exceeded.';
    $passenger_info_number_family = 'The maximum occupancy in cabin is __MAX__ adult and one (1) child under 4 years old. The charged will applied if the maximum number of guests is exceeded.';
} else {
    $passenger_info_number_single = 'Sức chứa tối đa trong cabin là một (1) người lớn và một (1) trẻ em dưới 4 tuổi. Sẽ tính phí thêm nếu vượt quá số lượng khách tối đa.';
    $passenger_info_number_double = 'Sức chứa tối đa trong cabin là hai (2) người lớn và một (1) trẻ em dưới 4 tuổi.  Sẽ tính phí thêm nếu vượt quá số lượng khách tối đa.';
    $passenger_info_number_family = 'Sức chứa tối đa trong cabin là __MAX__ người lớn và một (1) trẻ em dưới 4 tuổi. Sẽ tính phí thêm nếu vượt quá số lượng khách tối đa.';
}
?>
<style>
    @media (min-width: 1200px){
        .button-more-detail {
            width: 364px;
        }
    }
    @media (max-width: 767px){
        .button-more-detail {
            width: 293px;
        }
    }
    @media (min-width: 768px) and (max-width: 1199px){
        .button-more-detail {
            width: 25vw;
        }
    }
</style>
<div class="tabLink showDesktop">
    <ul>
        <li>
            <a href="<?php echo base_path()?>" class="blueDark45"><?php echo t('Home');?></a>
            <svg xmlns="http://www.w3.org/2000/svg" width="8" height="10" viewBox="0 0 8 10" fill="none">
                <path d="M7.12512 4.9999C7.12529 5.13618 7.09639 5.27094 7.04035 5.39517C6.9843 5.5194 6.90241 5.63025 6.80012 5.72031L2.15346 9.80823C1.99948 9.93743 1.80106 10.0013 1.60063 9.98608C1.4002 9.97089 1.21366 9.87789 1.08091 9.72696C0.94816 9.57603 0.879728 9.37915 0.890248 9.17842C0.900768 8.97769 0.989406 8.78904 1.13721 8.65281L5.20054 5.07823C5.21169 5.06845 5.22063 5.05641 5.22675 5.0429C5.23288 5.02939 5.23604 5.01473 5.23604 4.9999C5.23604 4.98506 5.23288 4.9704 5.22675 4.95689C5.22063 4.94338 5.21169 4.93134 5.20054 4.92156L1.13721 1.34698C1.05863 1.28105 0.994033 1.20008 0.947202 1.10882C0.900371 1.01757 0.872254 0.917871 0.864504 0.815594C0.856754 0.713317 0.869528 0.610523 0.902074 0.513254C0.93462 0.415984 0.986282 0.326201 1.05402 0.249184C1.12176 0.172166 1.20422 0.109467 1.29654 0.0647716C1.38886 0.0200767 1.48918 -0.00571349 1.59161 -0.0110817C1.69404 -0.01645 1.79651 -0.00128845 1.89299 0.0335121C1.98948 0.0683116 2.07804 0.122048 2.15346 0.191563L6.79846 4.27823C6.90099 4.36846 6.98315 4.47947 7.03948 4.6039C7.0958 4.72833 7.12499 4.86331 7.12512 4.9999Z" fill="#94A3B8"/>
            </svg>
            <a href="#" class="blueDark45"><?php echo t('Cruise');?></a>
            <svg xmlns="http://www.w3.org/2000/svg" width="8" height="10" viewBox="0 0 8 10" fill="none">
                <path d="M7.12512 4.9999C7.12529 5.13618 7.09639 5.27094 7.04035 5.39517C6.9843 5.5194 6.90241 5.63025 6.80012 5.72031L2.15346 9.80823C1.99948 9.93743 1.80106 10.0013 1.60063 9.98608C1.4002 9.97089 1.21366 9.87789 1.08091 9.72696C0.94816 9.57603 0.879728 9.37915 0.890248 9.17842C0.900768 8.97769 0.989406 8.78904 1.13721 8.65281L5.20054 5.07823C5.21169 5.06845 5.22063 5.05641 5.22675 5.0429C5.23288 5.02939 5.23604 5.01473 5.23604 4.9999C5.23604 4.98506 5.23288 4.9704 5.22675 4.95689C5.22063 4.94338 5.21169 4.93134 5.20054 4.92156L1.13721 1.34698C1.05863 1.28105 0.994033 1.20008 0.947202 1.10882C0.900371 1.01757 0.872254 0.917871 0.864504 0.815594C0.856754 0.713317 0.869528 0.610523 0.902074 0.513254C0.93462 0.415984 0.986282 0.326201 1.05402 0.249184C1.12176 0.172166 1.20422 0.109467 1.29654 0.0647716C1.38886 0.0200767 1.48918 -0.00571349 1.59161 -0.0110817C1.69404 -0.01645 1.79651 -0.00128845 1.89299 0.0335121C1.98948 0.0683116 2.07804 0.122048 2.15346 0.191563L6.79846 4.27823C6.90099 4.36846 6.98315 4.47947 7.03948 4.6039C7.0958 4.72833 7.12499 4.86331 7.12512 4.9999Z" fill="#94A3B8"/>
            </svg>
            <a href="#" class="blue1"><?php echo $data['info']['title']?></a>
        </li>
    </ul>
</div>

<?php if(!empty($_SESSION['search_param'][$tran]['depart']) && !empty($_SESSION['search_param'][$tran]['cruise']) && !empty($_SESSION['search_param'][$tran]['duration'])): ?>
    <div style="float: right;position: fixed;top: auto;z-index: 10;right: 30px" class="position-status">
        <div style="text-align: right" class="button-more-detail">
            <button type="button" name="detail_price" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter" style="width: 100%">
                <span><?php echo t('Price Summary: '); ?></span>&nbsp; <span id="detail_price"> 0 </span> &nbsp;<?php echo($lang == 'en' ? 'USD' : 'VND') ?>
            </button>
        </div>

        <div class="flightPassenger__right display-none" style="margin-bottom: 20px;width: 100%;padding: 0;display: none">
            <div class="tripSummary">
                <div class="tripSummary__body" style="border: 1px solid #C3C9DE;border-radius: 10px;">
                    <div class="tripSummary__group">
                        <div class="tripSummary__item">
                            <div class="tripSummary__cont">
                                <ul class="count_room">
                                </ul>
                            </div>
                            <?php
                            $room_label = t('room');

                            if(count($search_param[$tran]['room_selected']) > 1) {
                                $room_label = t('rooms');
                            }

                            $adult_label = t('adult');
                            if($num_adult > 1) {
                                $adult_label = t('adults');
                            }

                            $child_label = t('child');
                            if($num_child > 1) {
                                $child_label = t('children');
                            }

                            $infant_label = t('infant');
                            if($num_infant > 1) {
                                $infant_label = t('infants');
                            }

                            ?>
                            <div class="tripSummary__cont">
                                <ul><li><img src="<?php echo $cruise_img_detail?>"></li></ul>
                                <ul>
                                    <li>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 12 12" fill="none">
                                            <path d="M3.33302 3.3335C3.33302 4.798 4.53552 6 5.99952 6C7.46452 6 8.66602 4.798 8.66602 3.3335C8.66602 1.868 7.46502 0.666504 5.99952 0.666504C4.53552 0.666504 3.33302 1.868 3.33302 3.3335ZM11.333 11.3335C11.333 9.3615 8.92902 7.3335 5.99952 7.3335C3.07102 7.3335 0.666016 9.3615 0.666016 11.3335V12H11.333V11.3335Z" fill="#5C6AA1"/>
                                        </svg>
                                        <?php if(!$is_full_day):?>
                                            <span class="numb_room">0</span>&nbsp;
                                        <?php endif;?>
                                        <?php echo $num_adult .' '.$adult_label;?>
                                        <?php if($num_child >= 1):?>
                                            , <?php echo $num_child .' '.$child_label;?>
                                        <?php endif;?>
                                        <?php if($num_infant >= 1):?>
                                            , <?php echo $num_infant .' '.$infant_label;?>
                                        <?php endif;?>
                                    </li>

                                    <li>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                            <path d="M12.0003 13.9997V11.333H6.66699V9.99967H12.0003V7.33301L16.0003 10.6663L12.0003 13.9997Z" fill="#5C6AA1"/>
                                            <path d="M15.3333 2H12V0.666667C12 0.489856 11.9298 0.320286 11.8047 0.195262C11.6797 0.0702379 11.5101 0 11.3333 0C11.1565 0 10.987 0.0702379 10.8619 0.195262C10.7369 0.320286 10.6667 0.489856 10.6667 0.666667V2H5.33333V0.666667C5.33333 0.489856 5.2631 0.320286 5.13807 0.195262C5.01305 0.0702379 4.84348 0 4.66667 0C4.48986 0 4.32029 0.0702379 4.19526 0.195262C4.07024 0.320286 4 0.489856 4 0.666667V2H0.666667C0.489856 2 0.320286 2.07024 0.195262 2.19526C0.0702379 2.32029 0 2.48986 0 2.66667L0 14.6667C0 14.8435 0.0702379 15.013 0.195262 15.1381C0.320286 15.2631 0.489856 15.3333 0.666667 15.3333H10.6667V14H1.33333V4.66667H14.6667V7.33333H16V2.66667C16 2.48986 15.9298 2.32029 15.8047 2.19526C15.6797 2.07024 15.5101 2 15.3333 2Z" fill="#5C6AA1"/>
                                        </svg><?php echo t('Check-in')?>: <?php echo date('d/m/Y',$depart)?>
                                    </li>
                                    <li>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                            <path d="M3.99967 13.9997V11.333H9.33301V9.99967H3.99967V7.33301L-0.000325203 10.6663L3.99967 13.9997Z" fill="#5C6AA1"/>
                                            <path d="M0.666666 2H4V0.666667C4 0.489856 4.07024 0.320286 4.19526 0.195262C4.32029 0.0702379 4.48986 0 4.66667 0C4.84348 0 5.01305 0.0702379 5.13807 0.195262C5.2631 0.320286 5.33333 0.489856 5.33333 0.666667V2H10.6667V0.666667C10.6667 0.489856 10.7369 0.320286 10.8619 0.195262C10.987 0.0702379 11.1565 0 11.3333 0C11.5101 0 11.6797 0.0702379 11.8047 0.195262C11.9298 0.320286 12 0.489856 12 0.666667V2H15.3333C15.5101 2 15.6797 2.07024 15.8047 2.19526C15.9298 2.32029 16 2.48986 16 2.66667V14.6667C16 14.8435 15.9298 15.013 15.8047 15.1381C15.6797 15.2631 15.5101 15.3333 15.3333 15.3333H5.33333V14H14.6667V4.66667H1.33333V7.33333H0V2.66667C0 2.48986 0.0702372 2.32029 0.195261 2.19526C0.320286 2.07024 0.489855 2 0.666666 2Z" fill="#5C6AA1"/>
                                        </svg><?php echo t('Check-out')?>: <?php echo date('d/m/Y',$return)?>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="tripSummary__item">
                            <div class="tripSummary__ul">
                                <?php if($num_day > 0):?>
                                    <ul>
                                        <li>
                                            <p class="blueDark"><?php echo t('Number of nights');?></p>
                                        </li>
                                        <li><p class="blueDark">x<?php echo $num_day?></p></li>
                                    </ul>
                                <?php endif;?>
                                <ul class="shutter_bus_blk d-none">
                                    <li>
                                        <p class="blueDark"><?php echo t('Shutter bus fee');?></p>
                                    </li>
                                    <li><p class="blueDark"><span id="shutter_bus">0</span></p></li>
                                </ul>
                                <?php if(!$is_full_day):?>
                                    <ul class="extra_bed_fee_blk d-none">
                                        <li>
                                            <p class="blueDark"><?php echo t('Extra bed fee');?></p>
                                        </li>
                                        <li><p class="blueDark"><span id="extra_bed_fee">0</span></p></li>
                                    </ul>
                                <?php endif;?>
                            </div>
                        </div>

                        <input type="hidden" name="total" value="">
                        <div class="tripSummary__item">
                            <div class="tripSummary__price">
                                <ul>
                                    <li>
                                        <p class="blueDark text20 medium"><?php echo t('Total ');?></p>
                                    </li>
                                    <li><p class="green400 medium text20"><span id="total_charge" total_charge="<?php echo $amount?>">0</span>&nbsp;<?php echo($lang == 'en' ? 'USD' : 'VND') ?></p>
                                        <p class="blueDark45"><?php echo t('Taxes and fees are not included');?></p>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif;?>

<?php echo blk_form_search(); ?>
<?php if($search_param['duration'] != 'full_day'):?>
    <div class="cruiseService__filter" >
        <div style="display: flex;align-items: center">
            <p class="blueDark medium"><?php echo t('Filter by');?></p>
            <div class="filterItem__group">
                <div class="button__filter__item">
                    <button class="active button__filter" filter="all_room"><span class="blueDark"><?php echo t('All rooms');?></span></button>
                </div>
                <div class="button__filter__item">
                    <button class="button__filter" filter="triple"><span class="blueDark"><?php echo t('Triple Rooms');?></span></button>
                </div>
                <div class="button__filter__item">
                    <button class="button__filter" filter="double"><span class="blueDark"><?php echo t('Double Rooms');?></span></button>
                </div>
                <div class="button__filter__item">
                    <button class="button__filter" filter="single"><span class="blueDark"><?php echo t('Single Rooms');?></span></button>
                </div>

                <div class="button__filter__item">
                    <button class="button__filter" filter="<?php echo t('free breakfast');?>"><span class="blueDark"><?php echo t('Free breakfast');?></span></button>
                </div>
                <div class="button__filter__item">
                    <button class="button__filter" filter="<?php echo t('cheapest')?>"><span class="blueDark"><?php echo t('Cheapest');?></span></button>
                </div>
                <div class="button__filter__item">
                    <button class="button__filter" filter="<?php echo t('free wifi');?>"><span class="blueDark"><?php echo t('Free Wifi');?></span></button>
                </div>
            </div>
        </div>
        <!-- Button trigger modal -->
<!--        --><?php //if(!empty($_SESSION['search_param'][$tran]['depart']) && !empty($_SESSION['search_param'][$tran]['cruise']) && !empty($_SESSION['search_param'][$tran]['duration'])): ?>
<!--        <button type="button" name="detail_price" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">-->
<!--            --><?php //echo t('Price Summary: '); ?><!--&nbsp; <span id="detail_price"> 0 </span> &nbsp;--><?php //echo($lang == 'en' ? 'USD' : 'VND') ?>
<!--        </button>-->
<!--        --><?php //endif;?>

        <!-- Modal -->
<!--        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">-->
<!--            <div class="modal-dialog modal-dialog-centered" role="document">-->
<!--                <div class="modal-content">-->
<!--                    <div class="modal-header">-->
<!--                        <h3 class="modal-title" id="exampleModalLongTitle">--><?php //echo t('Price summary');?><!--</h3>-->
<!--                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">-->
<!--                            <span aria-hidden="true">&times;</span>-->
<!--                        </button>-->
<!--                    </div>-->
<!--                    <div class="modal-body" style="padding: 0">-->
<!--                        <div class="flightPassenger__right" style="margin-bottom: 20px;width: 100%;padding: 0">-->
<!--                            <div class="tripSummary">-->
<!--                                <div class="tripSummary__body">-->
<!--                                    <div class="tripSummary__group">-->
<!--                                        <div class="tripSummary__item">-->
<!--                                            <div class="tripSummary__cont">-->
<!--                                                <ul class="count_room">-->
<!--                                                </ul>-->
<!--                                            </div>-->
<!--                                            --><?php
//                                            $room_label = t('room');
//
//                                            if(count($search_param[$tran]['room_selected']) > 1) {
//                                                $room_label = t('rooms');
//                                            }
//
//                                            $adult_label = t('adult');
//                                            if($num_adult > 1) {
//                                                $adult_label = t('adults');
//                                            }
//
//                                            $child_label = t('child');
//                                            if($num_child > 1) {
//                                                $child_label = t('children');
//                                            }
//
//                                            $infant_label = t('infant');
//                                            if($num_infant > 1) {
//                                                $infant_label = t('infants');
//                                            }
//
//                                            ?>
<!--                                            <div class="tripSummary__cont">-->
<!--                                                <ul><li><img src="--><?php //echo $cruise_img_detail?><!--"></li></ul>-->
<!--                                                <ul>-->
<!--                                                    <li>-->
<!--                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 12 12" fill="none">-->
<!--                                                            <path d="M3.33302 3.3335C3.33302 4.798 4.53552 6 5.99952 6C7.46452 6 8.66602 4.798 8.66602 3.3335C8.66602 1.868 7.46502 0.666504 5.99952 0.666504C4.53552 0.666504 3.33302 1.868 3.33302 3.3335ZM11.333 11.3335C11.333 9.3615 8.92902 7.3335 5.99952 7.3335C3.07102 7.3335 0.666016 9.3615 0.666016 11.3335V12H11.333V11.3335Z" fill="#5C6AA1"/>-->
<!--                                                        </svg>-->
<!--                                                        --><?php //if(!$is_full_day):?>
<!--                                                            <span class="numb_room">0</span>&nbsp;-->
<!--                                                        --><?php //endif;?>
<!--                                                        --><?php //echo $num_adult .' '.$adult_label;?>
<!--                                                        --><?php //if($num_child >= 1):?>
<!--                                                            , --><?php //echo $num_child .' '.$child_label;?>
<!--                                                        --><?php //endif;?>
<!--                                                        --><?php //if($num_infant >= 1):?>
<!--                                                            , --><?php //echo $num_infant .' '.$infant_label;?>
<!--                                                        --><?php //endif;?>
<!--                                                    </li>-->
<!---->
<!--                                                    <li>-->
<!--                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">-->
<!--                                                            <path d="M12.0003 13.9997V11.333H6.66699V9.99967H12.0003V7.33301L16.0003 10.6663L12.0003 13.9997Z" fill="#5C6AA1"/>-->
<!--                                                            <path d="M15.3333 2H12V0.666667C12 0.489856 11.9298 0.320286 11.8047 0.195262C11.6797 0.0702379 11.5101 0 11.3333 0C11.1565 0 10.987 0.0702379 10.8619 0.195262C10.7369 0.320286 10.6667 0.489856 10.6667 0.666667V2H5.33333V0.666667C5.33333 0.489856 5.2631 0.320286 5.13807 0.195262C5.01305 0.0702379 4.84348 0 4.66667 0C4.48986 0 4.32029 0.0702379 4.19526 0.195262C4.07024 0.320286 4 0.489856 4 0.666667V2H0.666667C0.489856 2 0.320286 2.07024 0.195262 2.19526C0.0702379 2.32029 0 2.48986 0 2.66667L0 14.6667C0 14.8435 0.0702379 15.013 0.195262 15.1381C0.320286 15.2631 0.489856 15.3333 0.666667 15.3333H10.6667V14H1.33333V4.66667H14.6667V7.33333H16V2.66667C16 2.48986 15.9298 2.32029 15.8047 2.19526C15.6797 2.07024 15.5101 2 15.3333 2Z" fill="#5C6AA1"/>-->
<!--                                                        </svg>--><?php //echo t('Check-in')?><!--: --><?php //echo date('d/m/Y',$depart)?>
<!--                                                    </li>-->
<!--                                                    <li>-->
<!--                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">-->
<!--                                                            <path d="M3.99967 13.9997V11.333H9.33301V9.99967H3.99967V7.33301L-0.000325203 10.6663L3.99967 13.9997Z" fill="#5C6AA1"/>-->
<!--                                                            <path d="M0.666666 2H4V0.666667C4 0.489856 4.07024 0.320286 4.19526 0.195262C4.32029 0.0702379 4.48986 0 4.66667 0C4.84348 0 5.01305 0.0702379 5.13807 0.195262C5.2631 0.320286 5.33333 0.489856 5.33333 0.666667V2H10.6667V0.666667C10.6667 0.489856 10.7369 0.320286 10.8619 0.195262C10.987 0.0702379 11.1565 0 11.3333 0C11.5101 0 11.6797 0.0702379 11.8047 0.195262C11.9298 0.320286 12 0.489856 12 0.666667V2H15.3333C15.5101 2 15.6797 2.07024 15.8047 2.19526C15.9298 2.32029 16 2.48986 16 2.66667V14.6667C16 14.8435 15.9298 15.013 15.8047 15.1381C15.6797 15.2631 15.5101 15.3333 15.3333 15.3333H5.33333V14H14.6667V4.66667H1.33333V7.33333H0V2.66667C0 2.48986 0.0702372 2.32029 0.195261 2.19526C0.320286 2.07024 0.489855 2 0.666666 2Z" fill="#5C6AA1"/>-->
<!--                                                        </svg>--><?php //echo t('Check-out')?><!--: --><?php //echo date('d/m/Y',$return)?>
<!--                                                    </li>-->
<!--                                                </ul>-->
<!--                                            </div>-->
<!--                                        </div>-->
<!---->
<!--                                        <div class="tripSummary__item">-->
<!--                                            <div class="tripSummary__ul">-->
<!--                                                --><?php //if($num_day > 0):?>
<!--                                                    <ul>-->
<!--                                                        <li>-->
<!--                                                            <p class="blueDark">--><?php //echo t('Number of nights');?><!--</p>-->
<!--                                                        </li>-->
<!--                                                        <li><p class="blueDark">x--><?php //echo $num_day?><!--</p></li>-->
<!--                                                    </ul>-->
<!--                                                --><?php //endif;?>
<!--                                                <ul class="shutter_bus_blk d-none">-->
<!--                                                    <li>-->
<!--                                                        <p class="blueDark">--><?php //echo t('Shutter bus fee');?><!--</p>-->
<!--                                                    </li>-->
<!--                                                    <li><p class="blueDark"><span id="shutter_bus">0</span></p></li>-->
<!--                                                </ul>-->
<!--                                                --><?php //if(!$is_full_day):?>
<!--                                                    <ul class="extra_bed_fee_blk d-none">-->
<!--                                                        <li>-->
<!--                                                            <p class="blueDark">--><?php //echo t('Extra bed fee');?><!--</p>-->
<!--                                                        </li>-->
<!--                                                        <li><p class="blueDark"><span id="extra_bed_fee">0</span></p></li>-->
<!--                                                    </ul>-->
<!--                                                --><?php //endif;?>
<!--                                            </div>-->
<!--                                        </div>-->
<!---->
<!--                                        <input type="hidden" name="total" value="">-->
<!--                                        <div class="tripSummary__item">-->
<!--                                            <div class="tripSummary__price">-->
<!--                                                <ul>-->
<!--                                                    <li>-->
<!--                                                        <p class="blueDark text20 medium">--><?php //echo t('Total ');?><!--</p>-->
<!--                                                    </li>-->
<!--                                                    <li><p class="green400 medium text20"><span id="total_charge" total_charge="--><?php //echo $amount?><!--">0</span>&nbsp;--><?php //echo($lang == 'en' ? 'USD' : 'VND') ?><!--</p>-->
<!--                                                        <p class="blueDark45">--><?php //echo t('Taxes and fees are not included');?><!--</p>-->
<!--                                                    </li>-->
<!--                                                </ul>-->
<!--                                            </div>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </div>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
    </div>
<?php endif;?>

<?php if($discount_content != ''):?>
    <div class="discount_content"><img src="<?php echo '/sites/all/themes/newtheme/images/discount.jpg'?>"  style="width: 50px !important;"><?php echo $discount_content?></div>
<?php endif;?>
<form method="post" action="<?php echo base_path().'passenger'?>" id="detail_room">

    <?php if(count($search_param) > 0):
        $no_room = $search_param['no_room'];
        $room_types = $search_param['room_type'];


        ?>
        <?php for($r = 0; $r < $no_room; $r++):

        if($search_param['duration'] == 'full_day') {
            $title = '';
        } else {
            $title = t('Room '). ($r + 1) .': ' .t($room_types[$r]) .' - ';
        }

        $child = '';
        $adult = '';
        if($search_param['adult'][$r] > 1) {
            $title .= $search_param['adult'][$r] .t(' adults');
        } else {
            $title .= $search_param['adult'][$r] .t(' adult');
        }
        if($search_param['child'][$r] > 0) {
            $title .= ' - ' . $search_param['child'][$r];
            if($search_param['child'][$r] > 1) {
                $title .= t(' children');
            } else {
                $title .= t(' child');
            }


        }

        if($search_param['infant'][$r] > 0) {
            $title .= ' - ' . $search_param['infant'][$r];
            if($search_param['infant'][$r] > 1) {
                $title .= t(' infants');
            } else {
                $title .= t(' infant');
            }


        }

        ?>
        <div class="cruiseService__table">
            <div class="cruiseService__table__body">
                <div class="cruiseService__table__main">
                    <div class="cruiseService__table__title">
                        <p class="blueP400 medium text20 mb15"><?php echo $title; ?></p>
                    </div>
                    <div class="cruiseService__table__header">
                        <div class="cruiseService__table__cell"><p class="medium"><?php echo t('Accommodation Type');?></p></div>
                        <div class="cruiseService__table__cell showDesktop"><p class="medium"><?php echo t('Maximum');?></p></div>
                        <div class="cruiseService__table__cell"><p class="medium"><?php echo t('Price');?></p></div>
                        <div class="cruiseService__table__cell showDesktop"><p class="medium"><?php echo t('Included');?></p></div>
                        <div class="cruiseService__table__cell"><p class="medium"><?php echo t('Select');?></p></div>
                    </div>
                    <?php if(count($rooms) > 0):

                        $THUMBNAIL_STYLE = '600x600';
                        ?>
                        <?php foreach ($rooms as $room):
                        $type_room = '';
                        $type_room_arr = array();

                        if($search_param['duration'] == 'full_day') {
                            $type_room = $room['field_type_room']['und'][0]['value'];
                        } else {
                            if(isset($room['field_type_room']['und'])) {
                                for($tr = 0; $tr < count($room['field_type_room']['und']); $tr++) {
                                    $type_room .= $room['field_type_room']['und'][$tr]['value'] . ',';
                                    array_push($type_room_arr,$room['field_type_room']['und'][$tr]['value']);
                                }
                            }
                        }

                        $room_img = isset($room['field_cruise_room_image']['und'][0]['uri'])?$room['field_cruise_room_image']['und'][0]['uri']:'';


                        $room_img = image_style_url($THUMBNAIL_STYLE, $room_img);

                        // $room_img = file_create_url($room_img);
                        $room_img = convert_img_url($room_img);
                        $max_of_adult = isset($room['field_max_of_adult']['und'][0]['value'])?$room['field_max_of_adult']['und'][0]['value']:0;
                        $all_img_of_room =  array();
                        if(isset($room['field_cruise_room_image']['und']) && count($room['field_cruise_room_image']['und']) > 0) {
                            for($im = 0; $im < count($room['field_cruise_room_image']['und']); $im++) {
                                $img = isset($room['field_cruise_room_image']['und'][$im]['uri'])?$room['field_cruise_room_image']['und'][$im]['uri']:'';
                                $img = file_create_url($img);
                                $img = convert_img_url($img);
                                $all_img_of_room[$im] = $img;
                            }
                        }
                        $rate = isset($room['field_single_rate']['und'][0]['value'])?$room['field_single_rate']['und'][0]['value']:0;//var_dump($rate);
                        $show_room = false;


                        if($search_param['duration'] == 'full_day') {
                            $show_room = false;
                            if($type_room == 'fullday') {
                                $show_room = true;
                            }
                            $type_room = '';
                        } else {
                            if(in_array($room_types[$r],$type_room_arr)) {
                                $show_room = true;
                            } else if($rate > 0) {
                                if($room_types[$r] == 'single') {
                                    $show_room = true;
                                }

                            }
                        }





                        // print_r($room);
                        $summary = $room['body']['und'][0]['value'];



                        ?>
                        <?php if($show_room):

                        if( isset($room['field_price_for_adult']['und'][0]['value']) && $room['field_price_for_adult']['und'][0]['value'] < $min) {
                            $min = $room['field_price_for_adult']['und'][0]['value'];
                        }



                        ?>
                        <div  class="cruiseService__table__row room"  price="<?php echo isset($room['field_price_for_adult']['und'][0]['value'])?$room['field_price_for_adult']['und'][0]['value']:0?>"  title="<?php echo $room['title']?>" summary="<?php echo $summary?>" type_room="<?php echo  $type_room?>" room="<?php echo $room['nid']?>" amenities='<?php echo json_encode($room['field_amenities']['und'])?>' room_img='<?php echo json_encode($all_img_of_room)?>'>
                            <div class="cruiseService__table__cell">
                                <div class="cruiseService__info__group">
                                    <div class="cruiseService__item__left">
                                        <img src="<?php echo $room_img?>" abcd>
                                    </div>
                                    <div class="cruiseService__item__right">
                                        <p class="text20 blueDark medium"><?php echo $room['title']?></p>
                                        <ul>
                                            <?php if(isset($room['field_square']['und'][0]['value']) && $room['field_square']['und'][0]['value'] > 0):?>
                                                <li>
                                                    <p><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                                            <path d="M12.64 0.5H3.36C2.60189 0.501322 1.8752 0.803067 1.33913 1.33913C0.803067 1.8752 0.501322 2.60189 0.5 3.36V12.64C0.501322 13.3981 0.803067 14.1248 1.33913 14.6609C1.8752 15.1969 2.60189 15.4987 3.36 15.5H12.64C13.3981 15.4987 14.1248 15.1969 14.6609 14.6609C15.1969 14.1248 15.4987 13.3981 15.5 12.64V3.36C15.4987 2.60189 15.1969 1.8752 14.6609 1.33913C14.1248 0.803067 13.3981 0.501322 12.64 0.5ZM14.5 12.64C14.4987 13.1329 14.3023 13.6052 13.9538 13.9538C13.6052 14.3023 13.1329 14.4987 12.64 14.5H3.36C2.8671 14.4987 2.39477 14.3023 2.04624 13.9538C1.69771 13.6052 1.50132 13.1329 1.5 12.64V3.36C1.50132 2.8671 1.69771 2.39477 2.04624 2.04624C2.39477 1.69771 2.8671 1.50132 3.36 1.5H12.64C13.1329 1.50132 13.6052 1.69771 13.9538 2.04624C14.3023 2.39477 14.4987 2.8671 14.5 3.36V12.64Z" fill="#5C6AA1"/>
                                                            <path d="M12.5 8.92C12.3674 8.92 12.2402 8.97268 12.1464 9.06645C12.0527 9.16021 12 9.28739 12 9.42V11.295L4.705 4H6.58C6.71261 4 6.83979 3.94732 6.93355 3.85355C7.02732 3.75979 7.08 3.63261 7.08 3.5C7.08 3.36739 7.02732 3.24021 6.93355 3.14645C6.83979 3.05268 6.71261 3 6.58 3H3.345C3.2535 3 3.16575 3.03635 3.10105 3.10105C3.03635 3.16575 3 3.2535 3 3.345V6.58C3 6.71261 3.05268 6.83979 3.14645 6.93355C3.24021 7.02732 3.36739 7.08 3.5 7.08C3.63261 7.08 3.75979 7.02732 3.85355 6.93355C3.94732 6.83979 4 6.71261 4 6.58V4.705L11.295 12H9.42C9.28739 12 9.16021 12.0527 9.06645 12.1464C8.97268 12.2402 8.92 12.3674 8.92 12.5C8.92 12.6326 8.97268 12.7598 9.06645 12.8536C9.16021 12.9473 9.28739 13 9.42 13H12.655C12.7465 13 12.8343 12.9637 12.899 12.899C12.9637 12.8343 13 12.7465 13 12.655V9.42C13 9.28739 12.9473 9.16021 12.8536 9.06645C12.7598 8.97268 12.6326 8.92 12.5 8.92Z" fill="#5C6AA1"/>
                                                        </svg><?php echo isset($room['field_square']['und'][0]['value'])?$room['field_square']['und'][0]['value']:''?></p>
                                                </li>
                                            <?php endif;?>
                                            <li>
                                                <p><svg xmlns="http://www.w3.org/2000/svg" width="16" height="13" viewBox="0 0 16 13" fill="none">
                                                        <path d="M3.33301 6.36667C4.65072 5.26912 6.31141 4.66809 8.02634 4.66809C9.74127 4.66809 11.402 5.26912 12.7197 6.36667" stroke="#5C6AA1" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                        <path d="M0.946289 3.99998C2.89457 2.28263 5.40249 1.33508 7.99962 1.33508C10.5968 1.33508 13.1047 2.28263 15.053 3.99998" stroke="#5C6AA1" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                        <path d="M5.68652 8.74002C6.36332 8.25918 7.17297 8.00085 8.00319 8.00085C8.83341 8.00085 9.64306 8.25918 10.3199 8.74002" stroke="#5C6AA1" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                        <path d="M8 11.3334H8.00667" stroke="#5C6AA1" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                    </svg><?php echo t('Free wifi');?></p>
                                                <p>
                                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="20" height="20" viewBox="0 0 48 48">
                                                        <defs>



                                                            <path fill="#5C6AA1" id="i-439" d="M37.895,31.553l4,8l-1.789,0.895l-4-8L37.895,31.553z M23,41h2v-8.992L23,32V41z M6.105,39.553l1.789,0.895l4-8 l-1.789-0.895L6.105,39.553z M48,8v18c0,1.607-1.065,4-4,4H4c-2.935,0-4-2.393-4-4V8H48z M42,24H6v4h36V24z M46,10H2v16 c0.008,0.463,0.174,2,2,2v-6h40v6c1.903,0,2-1.666,2-2V10z M41,17c1.105,0,2-0.896,2-2s-0.895-2-2-2s-2,0.896-2,2S39.895,17,41,17z M40.15,25H7.85v2H40.15V25z"/>
                                                        </defs>

                                                        <use x="0" y="0" xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#i-439"/>

                                                    </svg><?php echo t('Air Conditioning');?></p>
                                            </li>
                                            <?php
                                            $field_type_of_bed  =isset($room['field_type_of_bed']['und'][0]['value'])?$room['field_type_of_bed']['und'][0]['value']:''

                                            ?>

                                            <li>

                                                <?php if($field_type_of_bed != ''):?>
                                                    <p><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                                            <path d="M15 9V12.5C15 12.776 14.776 13 14.5 13C14.224 13 14 12.776 14 12.5V12H2V12.5C2 12.776 1.776 13 1.5 13C1.224 13 1 12.776 1 12.5V9C1 8.173 1.673 7.5 2.5 7.5H13.5C14.327 7.5 15 8.173 15 9Z" fill="#5C6AA1"/>
                                                            <path d="M2.5 6.5V3.5C2.5 3.224 2.724 3 3 3H13C13.276 3 13.5 3.224 13.5 3.5V6.5H12V6C12 5.4485 11.5515 5 11 5H9.5C8.9485 5 8.5 5.4485 8.5 6V6.5H7.5V6C7.5 5.4485 7.0515 5 6.5 5H5C4.4485 5 4 5.4485 4 6V6.5H2.5Z" fill="#5C6AA1"/>
                                                        </svg><?php echo isset($room['field_type_of_bed']['und'][0]['value'])?$room['field_type_of_bed']['und'][0]['value']:''?></p>
                                                <?php endif;?>

                                                <p><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                                        <path d="M11.3333 5.33337C10.9658 5.33337 10.6667 5.03422 10.6667 4.66672C10.6667 3.93137 10.0687 3.33337 9.33334 3.33337H8.33334C8.14909 3.33337 8 3.48247 8 3.66672C8 3.85097 8.14909 4.00006 8.33334 4.00006H9.33334C9.70084 4.00006 10 4.29922 10 4.66672C10 5.40206 10.598 6.00003 11.3333 6.00003C11.7008 6.00003 12 6.29919 12 6.66669V7.66669C12 7.85094 12.1491 8.00003 12.3333 8.00003C12.5176 8.00003 12.6667 7.85094 12.6667 7.66669V6.66669C12.6667 5.93134 12.0687 5.33337 11.3333 5.33337Z" fill="#5C6AA1"/>
                                                        <path d="M11 7.33331H10.3334C10.1495 7.33331 10 7.18391 10 6.99997C10 6.44853 9.55147 5.99997 9.00003 5.99997C8.81613 5.99997 8.66669 5.85056 8.66669 5.66663V4.99997C8.66669 4.81572 8.51759 4.66663 8.33334 4.66663C8.14909 4.66663 8 4.81572 8 4.99997V5.66663C8 6.21806 8.44856 6.66663 9 6.66663C9.18391 6.66663 9.33334 6.81603 9.33334 6.99997C9.33334 7.55141 9.78191 7.99997 10.3333 7.99997H11C11.1843 7.99997 11.3334 7.85088 11.3334 7.66663C11.3334 7.48241 11.1843 7.33331 11 7.33331Z" fill="#5C6AA1"/>
                                                        <path d="M8 0C3.58887 0 0 3.58887 0 8C0 12.4111 3.58887 16 8 16C12.4111 16 16 12.4111 16 8C16 3.58887 12.4111 0 8 0ZM8 14.6667C4.32391 14.6667 1.33334 11.6761 1.33334 8C1.33334 6.40153 1.89975 4.93356 2.84113 3.78381L7.72397 8.66666H3.66666C3.48241 8.66666 3.33331 8.81575 3.33331 9V10.3333C3.33331 10.5176 3.48241 10.6667 3.66666 10.6667H9.72394L12.2162 13.1589C11.0664 14.1002 9.59847 14.6667 8 14.6667ZM13.1589 12.2162L11.6094 10.6667H12.3333C12.5176 10.6667 12.6667 10.5176 12.6667 10.3333V9C12.6667 8.81575 12.5176 8.66666 12.3333 8.66666H9.60938L3.78381 2.84109C4.93356 1.89975 6.40153 1.33334 8 1.33334C11.6761 1.33334 14.6667 4.32391 14.6667 8C14.6667 9.59847 14.1002 11.0664 13.1589 12.2162ZM11.3333 10V9.33334H12V10H11.3333Z" fill="#5C6AA1"/>
                                                    </svg><?php echo t('No smoking');?></p>
                                            </li>
                                        </ul>
                                        <button type="button" data-toggle="modal" data-target="#roomDetailPopup" class="viewMore blue1"><span><?php echo t('Room Details and Photos');?></span></button>
                                    </div>
                                </div>
                            </div>
                            <?php if($search_param['duration'] != 'full_day'):?>
                                <div class="cruiseService__table__cell showDesktop" max_adult="<?php echo $max_of_adult?>">
                                    <div class="sleeps__number">
                                        <?php if($max_of_adult > 0):?>
                                            <div class="sleeps__number__icon" title="">

                                                <div class="sleeps__number__icon">
                                                    <?php for($i = 0; $i < $max_of_adult; $i++):?>
                                                        <?php echo adult_icon();?>
                                                    <?php endfor;?>
                                                    <?php if($max_of_adult >= 2):?>
                                                        <?php
                                                        echo child_icon();
                                                        ?>
                                                    <?php endif;?>
                                                    <div class="passenger_info_number <?php echo $max_of_adult?> <?php echo implode(',',$type_room_arr)?>" >

                                                        <?php if(in_array('single',$type_room_arr) && !in_array('double',$type_room_arr) && !in_array('family',$type_room_arr)):?>
                                                            <?php echo $passenger_info_number_single;?>
                                                        <?php elseif(in_array('double',$type_room_arr) && !in_array('family',$type_room_arr)):?>
                                                            <?php echo $passenger_info_number_double;?>
                                                        <?php else:?>
                                                            <?php

                                                            $passenger_info_number_family = str_replace('__MAX__',$max_of_adult,$passenger_info_number_family);
                                                            echo $passenger_info_number_family;
                                                            ?>
                                                        <?php endif;?>
                                                    </div>


                                                </div>



                                            </div>
                                        <?php endif;?>
                                        <div></div>

                                    </div>
                                </div>
                            <?php else:?>
                                <div class="cruiseService__table__cell showDesktop">
                                    <span class="text12 blueDark medium">10 <?php echo t('pax');?></span>

                                </div>
                            <?php endif;?>
                            <div class="cruiseService__table__cell">
                                <p><span class="green400 medium text16">
                                                   <?php
                                                   $price = isset($room['field_price_for_adult']['und'][0]['value'])?$room['field_price_for_adult']['und'][0]['value']:0;
                                                   echo show_price($price);
                                                   ?>&nbsp;
                                                </span>
                                    <?php //if($search_param['duration'] != 'full_day'):?>
                                    <span class="text12 blueDark medium">/<?php echo t('pax');?></span></p>
                                <?php //endif;?>

                            </div>
                            <div class="cruiseService__table__cell showDesktop included">

                                <div class="included__group">
                                    <?php $all_included = 'free wifi,'; if(isset($room['field_include']['und']) && count($room['field_include']['und']) > 0):?>
                                        <?php for($i = 0; $i < count($room['field_include']['und']); $i++):?>
                                            <p class="green500"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="9" viewBox="0 0 12 9" fill="none">
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M11.8047 0.528636C12.0651 0.788986 12.0651 1.2111 11.8047 1.47145L4.4714 8.80478C4.21106 9.06513 3.78894 9.06513 3.5286 8.80478L0.195262 5.47145C-0.0650874 5.2111 -0.0650874 4.78899 0.195262 4.52864C0.455612 4.26829 0.877722 4.26829 1.13807 4.52864L4 7.39057L10.8619 0.528636C11.1223 0.268287 11.5444 0.268287 11.8047 0.528636Z" fill="#00AA74"/>
                                                </svg><?php echo $room['field_include']['und'][$i]['value']?></p>

                                            <?php
                                            $all_included .= trim(strtolower($room['field_include']['und'][$i]['value'])).',';
                                        endfor;?>
                                    <?php endif;?>
                                </div>
                            </div>
                            <div class="cruiseService__table__cell">
                                <?php if($room['field_price_for_adult']['und'][0]['value'] > 0 ): ?>
                                    <div class="reserve__room"><a  class="btn btn-orange <?php echo ($lang == 'vi')?'w100':'w80'?>"><?php echo t('Book ');?></a></div>
                                <?php else:?>
                                    <a class="btn btn-outline-orange   " href="mailto:<?php echo $site_email?>"><?php echo t('Contact us');?></a>
                                <?php endif;?>

                            </div>
                            <input type="hidden" class="included" value="<?php echo strtolower($all_included);?>">
                            <input type="hidden" class="choose" r_id="" tt="" pr="">
                        </div>
                    <?php else:?>

                    <?php endif;?>

                    <?php endforeach;?>
                    <?php endif;?>
                    <input type="hidden" class="room_selected" name="room_selected[<?php echo $r?>]" value="" />
                    <input type="hidden" class="price_selected" name="price_selected[<?php echo $r?>]" value="" price_room="" title_room=""/>
                </div>
            </div>
        </div>

    <?php endfor;?>


    <?php else:?>
        <div class="cruiseService__table">
            <div class="cruiseService__table__body">
                <div class="cruiseService__table__main">
                    <div class="cruiseService__table__header">
                        <div class="cruiseService__table__cell"><p class="medium"><?php echo t('Accommodation Type');?></p></div>
                        <div class="cruiseService__table__cell showDesktop"><p class="medium text-center"><?php echo t('Maximum');?></p></div>
                        <div class="cruiseService__table__cell"><p class="medium text-center"><?php echo t('Price');?></p></div>
                        <div class="cruiseService__table__cell showDesktop"><p class="medium"><?php echo t('Included');?></p></div>
                        <?php if(!empty($_SESSION['search_param'][$tran]['depart']) && !empty($_SESSION['search_param'][$tran]['cruise']) && !empty($_SESSION['search_param'][$tran]['duration'])): ?>
                            <div class="cruiseService__table__cell"><p class="medium"><?php echo t('Select');?></p></div>
                        <?php endif;?>
                    </div>
                    <?php if(count($rooms) > 0):?>
                        <?php

                        $min = 9999999999999999999999;
                        $THUMBNAIL_STYLE = '600x600';
                        foreach ($rooms as $room):


                            $room_img = isset($room['field_cruise_room_image']['und'][0]['uri'])?$room['field_cruise_room_image']['und'][0]['uri']:'';
                            $room_img = image_style_url($THUMBNAIL_STYLE, $room_img);


                            //$room_img = file_create_url($room_img);
                            $room_img = convert_img_url($room_img);
                            $max_of_adult = isset($room['field_max_of_adult']['und'][0]['value'])?$room['field_max_of_adult']['und'][0]['value']:0;
                            $all_img_of_room =  array();
                            if(isset($room['field_cruise_room_image']['und']) && count($room['field_cruise_room_image']['und']) > 0) {
                                for($im = 0; $im < count($room['field_cruise_room_image']['und']); $im++) {
                                    $img = isset($room['field_cruise_room_image']['und'][$im]['uri'])?$room['field_cruise_room_image']['und'][$im]['uri']:'';
                                    $img = file_create_url($img);
                                    $img = convert_img_url($img);
                                    $all_img_of_room[$im] = $img;
                                }
                            }
                            $type_room = '';

                            $type_room_arr = array();

                            if(isset($room['field_type_room']['und'])) {
                                for($tr = 0; $tr < count($room['field_type_room']['und']); $tr++) {
                                    $type_room .= $room['field_type_room']['und'][$tr]['value'] . ',';
                                    array_push($type_room_arr,$room['field_type_room']['und'][$tr]['value']);
                                }
                            }



                            if( isset($room['field_price_for_adult']['und'][0]['value']) && $room['field_price_for_adult']['und'][0]['value'] < $min) {
                                $min = $room['field_price_for_adult']['und'][0]['value'];
                            }
                            $summary = $room['body']['und'][0]['value'];

                            ?>
                            <div  class="cruiseService__table__row room" title="<?php echo $room['title']?>" summary="<?php echo strip_tags($summary)?>" price="<?php echo isset($room['field_price_for_adult']['und'][0]['value'])?$room['field_price_for_adult']['und'][0]['value']:0?>" type_room="<?php echo  $type_room?>" amenities='<?php echo json_encode($room['field_amenities']['und'])?>' room_id="<?php echo $room['nid']?>" room_img='<?php echo json_encode($all_img_of_room)?>'>
                                <div class="cruiseService__table__cell">
                                    <div class="cruiseService__info__group">
                                        <div class="cruiseService__item__left">
                                            <img src="<?php echo $room_img?>">
                                        </div>
                                        <div class="cruiseService__item__right">
                                            <p class="text20 blueDark medium"><?php echo $room['title']?></p>
                                            <ul>
                                                <li>
                                                    <p><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                                            <path d="M12.64 0.5H3.36C2.60189 0.501322 1.8752 0.803067 1.33913 1.33913C0.803067 1.8752 0.501322 2.60189 0.5 3.36V12.64C0.501322 13.3981 0.803067 14.1248 1.33913 14.6609C1.8752 15.1969 2.60189 15.4987 3.36 15.5H12.64C13.3981 15.4987 14.1248 15.1969 14.6609 14.6609C15.1969 14.1248 15.4987 13.3981 15.5 12.64V3.36C15.4987 2.60189 15.1969 1.8752 14.6609 1.33913C14.1248 0.803067 13.3981 0.501322 12.64 0.5ZM14.5 12.64C14.4987 13.1329 14.3023 13.6052 13.9538 13.9538C13.6052 14.3023 13.1329 14.4987 12.64 14.5H3.36C2.8671 14.4987 2.39477 14.3023 2.04624 13.9538C1.69771 13.6052 1.50132 13.1329 1.5 12.64V3.36C1.50132 2.8671 1.69771 2.39477 2.04624 2.04624C2.39477 1.69771 2.8671 1.50132 3.36 1.5H12.64C13.1329 1.50132 13.6052 1.69771 13.9538 2.04624C14.3023 2.39477 14.4987 2.8671 14.5 3.36V12.64Z" fill="#5C6AA1"/>
                                                            <path d="M12.5 8.92C12.3674 8.92 12.2402 8.97268 12.1464 9.06645C12.0527 9.16021 12 9.28739 12 9.42V11.295L4.705 4H6.58C6.71261 4 6.83979 3.94732 6.93355 3.85355C7.02732 3.75979 7.08 3.63261 7.08 3.5C7.08 3.36739 7.02732 3.24021 6.93355 3.14645C6.83979 3.05268 6.71261 3 6.58 3H3.345C3.2535 3 3.16575 3.03635 3.10105 3.10105C3.03635 3.16575 3 3.2535 3 3.345V6.58C3 6.71261 3.05268 6.83979 3.14645 6.93355C3.24021 7.02732 3.36739 7.08 3.5 7.08C3.63261 7.08 3.75979 7.02732 3.85355 6.93355C3.94732 6.83979 4 6.71261 4 6.58V4.705L11.295 12H9.42C9.28739 12 9.16021 12.0527 9.06645 12.1464C8.97268 12.2402 8.92 12.3674 8.92 12.5C8.92 12.6326 8.97268 12.7598 9.06645 12.8536C9.16021 12.9473 9.28739 13 9.42 13H12.655C12.7465 13 12.8343 12.9637 12.899 12.899C12.9637 12.8343 13 12.7465 13 12.655V9.42C13 9.28739 12.9473 9.16021 12.8536 9.06645C12.7598 8.97268 12.6326 8.92 12.5 8.92Z" fill="#5C6AA1"/>
                                                        </svg><?php echo isset($room['field_square']['und'][0]['value'])?$room['field_square']['und'][0]['value']:''?></p>
                                                </li>
                                                <li>
                                                    <p><svg xmlns="http://www.w3.org/2000/svg" width="16" height="13" viewBox="0 0 16 13" fill="none">
                                                            <path d="M3.33301 6.36667C4.65072 5.26912 6.31141 4.66809 8.02634 4.66809C9.74127 4.66809 11.402 5.26912 12.7197 6.36667" stroke="#5C6AA1" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                            <path d="M0.946289 3.99998C2.89457 2.28263 5.40249 1.33508 7.99962 1.33508C10.5968 1.33508 13.1047 2.28263 15.053 3.99998" stroke="#5C6AA1" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                            <path d="M5.68652 8.74002C6.36332 8.25918 7.17297 8.00085 8.00319 8.00085C8.83341 8.00085 9.64306 8.25918 10.3199 8.74002" stroke="#5C6AA1" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                            <path d="M8 11.3334H8.00667" stroke="#5C6AA1" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                        </svg><?php echo t('Free wifi');?></p>
                                                    <p>
                                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="20" height="20" viewBox="0 0 48 48">
                                                            <defs>



                                                                <path fill="#5C6AA1" id="i-439" d="M37.895,31.553l4,8l-1.789,0.895l-4-8L37.895,31.553z M23,41h2v-8.992L23,32V41z M6.105,39.553l1.789,0.895l4-8 l-1.789-0.895L6.105,39.553z M48,8v18c0,1.607-1.065,4-4,4H4c-2.935,0-4-2.393-4-4V8H48z M42,24H6v4h36V24z M46,10H2v16 c0.008,0.463,0.174,2,2,2v-6h40v6c1.903,0,2-1.666,2-2V10z M41,17c1.105,0,2-0.896,2-2s-0.895-2-2-2s-2,0.896-2,2S39.895,17,41,17z M40.15,25H7.85v2H40.15V25z"/>
                                                            </defs>

                                                            <use x="0" y="0" xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#i-439"/>

                                                        </svg>
                                                        <?php echo t('Air Conditioning');?></p>
                                                </li>
                                                <?php
                                                $field_type_of_bed  =isset($room['field_type_of_bed']['und'][0]['value'])?$room['field_type_of_bed']['und'][0]['value']:''

                                                ?>
                                                <li>
                                                    <?php if($field_type_of_bed != ''):?>
                                                        <p><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                                                <path d="M15 9V12.5C15 12.776 14.776 13 14.5 13C14.224 13 14 12.776 14 12.5V12H2V12.5C2 12.776 1.776 13 1.5 13C1.224 13 1 12.776 1 12.5V9C1 8.173 1.673 7.5 2.5 7.5H13.5C14.327 7.5 15 8.173 15 9Z" fill="#5C6AA1"/>
                                                                <path d="M2.5 6.5V3.5C2.5 3.224 2.724 3 3 3H13C13.276 3 13.5 3.224 13.5 3.5V6.5H12V6C12 5.4485 11.5515 5 11 5H9.5C8.9485 5 8.5 5.4485 8.5 6V6.5H7.5V6C7.5 5.4485 7.0515 5 6.5 5H5C4.4485 5 4 5.4485 4 6V6.5H2.5Z" fill="#5C6AA1"/>
                                                            </svg><?php echo isset($room['field_type_of_bed']['und'][0]['value'])?$room['field_type_of_bed']['und'][0]['value']:''?></p>
                                                    <?php endif;?>
                                                    <p><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                                            <path d="M11.3333 5.33337C10.9658 5.33337 10.6667 5.03422 10.6667 4.66672C10.6667 3.93137 10.0687 3.33337 9.33334 3.33337H8.33334C8.14909 3.33337 8 3.48247 8 3.66672C8 3.85097 8.14909 4.00006 8.33334 4.00006H9.33334C9.70084 4.00006 10 4.29922 10 4.66672C10 5.40206 10.598 6.00003 11.3333 6.00003C11.7008 6.00003 12 6.29919 12 6.66669V7.66669C12 7.85094 12.1491 8.00003 12.3333 8.00003C12.5176 8.00003 12.6667 7.85094 12.6667 7.66669V6.66669C12.6667 5.93134 12.0687 5.33337 11.3333 5.33337Z" fill="#5C6AA1"/>
                                                            <path d="M11 7.33331H10.3334C10.1495 7.33331 10 7.18391 10 6.99997C10 6.44853 9.55147 5.99997 9.00003 5.99997C8.81613 5.99997 8.66669 5.85056 8.66669 5.66663V4.99997C8.66669 4.81572 8.51759 4.66663 8.33334 4.66663C8.14909 4.66663 8 4.81572 8 4.99997V5.66663C8 6.21806 8.44856 6.66663 9 6.66663C9.18391 6.66663 9.33334 6.81603 9.33334 6.99997C9.33334 7.55141 9.78191 7.99997 10.3333 7.99997H11C11.1843 7.99997 11.3334 7.85088 11.3334 7.66663C11.3334 7.48241 11.1843 7.33331 11 7.33331Z" fill="#5C6AA1"/>
                                                            <path d="M8 0C3.58887 0 0 3.58887 0 8C0 12.4111 3.58887 16 8 16C12.4111 16 16 12.4111 16 8C16 3.58887 12.4111 0 8 0ZM8 14.6667C4.32391 14.6667 1.33334 11.6761 1.33334 8C1.33334 6.40153 1.89975 4.93356 2.84113 3.78381L7.72397 8.66666H3.66666C3.48241 8.66666 3.33331 8.81575 3.33331 9V10.3333C3.33331 10.5176 3.48241 10.6667 3.66666 10.6667H9.72394L12.2162 13.1589C11.0664 14.1002 9.59847 14.6667 8 14.6667ZM13.1589 12.2162L11.6094 10.6667H12.3333C12.5176 10.6667 12.6667 10.5176 12.6667 10.3333V9C12.6667 8.81575 12.5176 8.66666 12.3333 8.66666H9.60938L3.78381 2.84109C4.93356 1.89975 6.40153 1.33334 8 1.33334C11.6761 1.33334 14.6667 4.32391 14.6667 8C14.6667 9.59847 14.1002 11.0664 13.1589 12.2162ZM11.3333 10V9.33334H12V10H11.3333Z" fill="#5C6AA1"/>
                                                        </svg><?php echo t('No smoking');?></p>
                                                </li>
                                            </ul>
                                            <button type="button" data-toggle="modal" data-target="#roomDetailPopup" class="viewMore blue1 showDesktop"><span><?php echo t('Room Details and Photos');?></span></button>
                                        </div>

                                    </div>
                                    <div class="cruiseService__item__bottom">
                                        <button type="button" data-toggle="modal" data-target="#roomDetailPopup" class="viewMore blue1 showMobile"><span><?php echo t('Room Details and Photos');?></span></button>
                                    </div>
                                    <div class="cruiseService__item__bottom showMobile">
                                        <?php if(isset($room['field_include']['und']) && count($room['field_include']['und']) > 0):?>
                                            <?php for($i = 0; $i < count($room['field_include']['und']); $i++):?>
                                                <p class="green500"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="9" viewBox="0 0 12 9" fill="none">
                                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M11.8047 0.528636C12.0651 0.788986 12.0651 1.2111 11.8047 1.47145L4.4714 8.80478C4.21106 9.06513 3.78894 9.06513 3.5286 8.80478L0.195262 5.47145C-0.0650874 5.2111 -0.0650874 4.78899 0.195262 4.52864C0.455612 4.26829 0.877722 4.26829 1.13807 4.52864L4 7.39057L10.8619 0.528636C11.1223 0.268287 11.5444 0.268287 11.8047 0.528636Z" fill="#00AA74"/>
                                                    </svg><?php echo $room['field_include']['und'][$i]['value']?></p>
                                            <?php endfor;?>
                                        <?php endif;?>


                                    </div>
                                </div>
                                <div class="cruiseService__table__cell showDesktop">

                                    <?php if(count($max_of_adult) > 0 && $max_of_adult <= 6):?>
                                        <div class="sleeps__number__icon">
                                            <?php for($i = 0; $i < $max_of_adult; $i++):?>
                                                <?php echo adult_icon();?>
                                            <?php endfor;?>
                                            <?php if($max_of_adult >= 2):?>
                                                <?php
                                                echo child_icon();
                                                ?>
                                            <?php endif;?>
                                            <div class="passenger_info_number">
                                                <?php if(in_array('single',$type_room_arr) && !in_array('double',$type_room_arr) && !in_array('family',$type_room_arr)):?>
                                                    <?php echo $passenger_info_number_single;?>
                                                <?php elseif(in_array('double',$type_room_arr) && !in_array('family',$type_room_arr)):?>
                                                    <?php echo $passenger_info_number_double;?>
                                                <?php else:?>
                                                    <?php
                                                    $passenger_info_number_family = str_replace('__MAX__',$max_of_adult,$passenger_info_number_family);
                                                    echo $passenger_info_number_family;?>
                                                <?php endif;?>
                                            </div>



                                        </div>
                                    <?php else:?>

                                        <span class="text12 blueDark medium">10 <?php echo t('pax');?></span>

                                    <?php endif;?>

                                </div>
                                <div class="cruiseService__table__cell">
                                    <div class="reserve__room"><p><span class="green400 medium text16">
                                    <?php
                                    $price = isset($room['field_price_for_adult']['und'][0]['value'])?$room['field_price_for_adult']['und'][0]['value']:0;
                                    echo show_price($price);
                                    ?>&nbsp;

                                </span><span class="text12 blueDark medium">/<?php echo t('pax');?></span></p></div>
                                </div>
                                <div class="cruiseService__table__cell showDesktop ">
                                    <div class="included__group">
                                        <?php $all_included = 'free wifi,'; if(isset($room['field_include']['und']) && count($room['field_include']['und']) > 0):?>
                                            <?php for($i = 0; $i < count($room['field_include']['und']); $i++):?>
                                                <p class="green500"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="9" viewBox="0 0 12 9" fill="none">
                                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M11.8047 0.528636C12.0651 0.788986 12.0651 1.2111 11.8047 1.47145L4.4714 8.80478C4.21106 9.06513 3.78894 9.06513 3.5286 8.80478L0.195262 5.47145C-0.0650874 5.2111 -0.0650874 4.78899 0.195262 4.52864C0.455612 4.26829 0.877722 4.26829 1.13807 4.52864L4 7.39057L10.8619 0.528636C11.1223 0.268287 11.5444 0.268287 11.8047 0.528636Z" fill="#00AA74"/>
                                                    </svg><?php echo $room['field_include']['und'][$i]['value']?></p>

                                                <?php
                                                $all_included .= trim(strtolower($room['field_include']['und'][$i]['value'])).',';
                                            endfor;?>
                                        <?php endif;?>
                                    </div>
                                </div>
                                <?php if(!empty($_SESSION['search_param'][$tran]['depart']) && !empty($_SESSION['search_param'][$tran]['cruise']) && !empty($_SESSION['search_param'][$tran]['duration'])): ?>
                                    <div class="cruiseService__table__cell">
                                        <?php if($room['field_price_for_adult']['und'][0]['value'] > 0 ): ?>
                                            <div class="reserve__room"><a  class="btn btn-orange <?php echo ($lang == 'vi')?'w100':'w80'?>"><?php echo t('Book ');?></a></div>
                                        <?php endif;?>
                                    </div>
                                    <input type="hidden" class="included" value="<?php echo strtolower($all_included);?>">
                                <?php endif;?>
                            </div>
                        <?php endforeach;?>
                    <?php endif;?>
                </div>
            </div>
        </div>
    <?php endif;?>

    <div class="flightPassenger__btn" style="display: flex;align-items: center;  justify-content: center;"><input type="submit" name="passenger" class="btn btn-orange btn-lg w-25 disabled" value="<?php echo t('Next step: Passenger');?>"></div>
    <input type="hidden" name="tran" value="<?php echo $tran?>" />
    <input type="hidden" name="min_price" value="<?php echo $min?>" />
</form>

<!--<div class="cruiseService__title showDesktop">-->
<!--    <p class="medium blueDark text20">--><?php //echo $data['info']['title']?><!--</p>-->
<!--    --><?php //echo get_star_html($data['info']['field_star']['und'][0]['value']);?>
<!--</div>-->
<!--<div class="cruiseService__image__group showDesktop">-->
<!--    <div class="row">-->
<!--        --><?php //if(count($cruise_img) > 0):
//            $THUMBNAIL_STYLE = '600x600';
//            $first_img = image_style_url($THUMBNAIL_STYLE, $cruise_img[0]['uri']);
//            $first_img = file_create_url($cruise_img[0]['uri']);
//            $first_img = convert_img_url($first_img);
//
//            ?>
<!--        <div class="col-4">-->
<!--            <div class="cruiseService__item">-->
<!---->
<!--                <img src="--><?php //echo $first_img?><!--" />-->
<!--            </div>-->
<!--        </div>-->
<!--        <div class="col-8">-->
<!--            <div class="cruiseService__group">-->
<!--                --><?php //for($i = 1; $i < count($cruise_img); $i++):
//                    $THUMBNAIL_STYLE = 'large';
//                    $img = image_style_url($THUMBNAIL_STYLE, $cruise_img[$i]['uri']);
//
//                    $img = file_create_url($cruise_img[$i]['uri']);
//                    $img = convert_img_url($img);
//                    ?>
<!--                <div class="cruiseService__col">-->
<!--                    <img src="--><?php //echo $img?><!--" />-->
<!--                </div>-->
<!--                --><?php //endfor;?>
<!---->
<!--            </div>-->
<!--        </div>-->
<!--        --><?php //endif;?>
<!--    </div>-->
<!--</div>-->
<!---->
<!--<div class="cruiseService__image__group showMobile">-->
<!--    <div class="cruiseService__slide">-->
<!--        --><?php //if(count($cruise_img) > 0):
//            $first_img = file_create_url($cruise_img[0]['uri']);
//            $first_img = convert_img_url($first_img);
//
//            ?>
<!---->
<!---->
<!---->
<!--                    --><?php //for($i = 0; $i < count($cruise_img); $i++):
//                        $img = file_create_url($cruise_img[$i]['uri']);
//                        $img = convert_img_url($img);
//                        ?>
<!--                        <div class="cruiseImage__item">-->
<!--                            <img src="--><?php //echo $img?><!--" />-->
<!--                        </div>-->
<!---->
<!--                    --><?php //endfor;?>
<!---->
<!---->
<!---->
<!--        --><?php //endif;?>
<!--    </div>-->
<!---->
<!--</div>-->
<!---->
<!--<div class="cruiseService__title showMobile">-->
<!--    <p class="medium blueDark text20">--><?php //echo $data['info']['title']?><!--</p>-->
<!--    --><?php //echo get_star_html($data['info']['field_star']['und'][0]['value']);?>
<!--</div>-->

<div class="cruiseService__inf">
    <div class="cruiseInf__group">
        <div class="cruiseInf__header showDesktop">
            <p class="medium blueDark overview"><?php echo t('Overview');?></p>
            <p class="medium blueDark room"><?php echo t('Room');?></p>
            <p class="medium blueDark itinerary"><?php echo t('Itinerary');?></p>
            <p class="medium blueDark amenities"><?php echo t('Amenities');?></p>
            <p class="medium blueDark inclusions"><?php echo t('Inclusions & Options');?></p>
            <p class="medium blueDark reviews"><?php echo t('Reviews');?></p>
            <a value="" name="home_search" class="btn btn-orange w120 d-none"><?php echo t('Select room');?></a>
        </div>
        <div class="cruiseInf__tab showMobile">
            <button type="button" class="active button__detail__tab"><p class="colorBluedark900 medium"><?php echo t('Details');?></p></button>
            <button type="button" class="button__review__tab"><p class="colorBluedark900 medium"><?php  echo t('Review');?></p></button>
        </div>
        <div class="cruiseInf__cont">

            <div class="cruiseInf__left" id="detail_overview">
                <p class="text24 blueDark medium"><?php echo t('Overview');?></p>
                <p class="blueDark">
                   <?php echo isset($data['info']['body']['und'][0]['value'])?$data['info']['body']['und'][0]['value']:''?>
                </p>

            </div>
            <div class="cruiseInf__right">
                <img src="<?php echo $theme?>/images/details8.jpg">
                <p class="blue1"><?php echo t('Tuan Chau Island, Ha Long, Vietnam');?></p>
            </div>
        </div>
        <div class="cruiseService__title showDesktop">
            <p class="medium blueDark text20"><?php echo $data['info']['title']?></p>
            <?php echo get_star_html($data['info']['field_star']['und'][0]['value']);?>
        </div>
        <div class="cruiseService__image__group showDesktop">
            <div class="row">
                <?php if(count($cruise_img) > 0):
                    $THUMBNAIL_STYLE = '600x600';
                    $first_img = image_style_url($THUMBNAIL_STYLE, $cruise_img[0]['uri']);
                    $first_img = file_create_url($cruise_img[0]['uri']);
                    $first_img = convert_img_url($first_img);

                    ?>
                    <div class="col-4">
                        <div class="cruiseService__item">

                            <img src="<?php echo $first_img?>" />
                        </div>
                    </div>
                    <div class="col-8">
                        <div class="cruiseService__group">
                            <?php for($i = 1; $i < count($cruise_img); $i++):
                                $THUMBNAIL_STYLE = 'large';
                                $img = image_style_url($THUMBNAIL_STYLE, $cruise_img[$i]['uri']);

                                $img = file_create_url($cruise_img[$i]['uri']);
                                $img = convert_img_url($img);
                                ?>
                                <div class="cruiseService__col">
                                    <img src="<?php echo $img?>" />
                                </div>
                            <?php endfor;?>

                        </div>
                    </div>
                <?php endif;?>
            </div>
        </div>

        <div class="cruiseService__image__group showMobile">
            <div class="cruiseService__slide">
                <?php if(count($cruise_img) > 0):
                    $first_img = file_create_url($cruise_img[0]['uri']);
                    $first_img = convert_img_url($first_img);

                    ?>



                    <?php for($i = 0; $i < count($cruise_img); $i++):
                    $img = file_create_url($cruise_img[$i]['uri']);
                    $img = convert_img_url($img);
                    ?>
                    <div class="cruiseImage__item">
                        <img src="<?php echo $img?>" />
                    </div>

                <?php endfor;?>



                <?php endif;?>
            </div>

        </div>

        <div class="cruiseService__title showMobile">
            <p class="medium blueDark text20"><?php echo $data['info']['title']?></p>
            <?php echo get_star_html($data['info']['field_star']['und'][0]['value']);?>
        </div>
    </div>
</div>
<?php if($itinerary):?>
<div class="cruiseItinerary__cont" id="detail_itinerary">
    <div class="cruiseItinerary__title flexIcon__between cursorPointer titleShow">
        <p class="text24 blueDark medium"><?php echo t('Itinerary')?></p>
        <svg width="14" height="8" viewBox="0 0 14 8" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M0.292893 0.292893C0.683417 -0.0976315 1.31658 -0.0976315 1.70711 0.292893L7 5.58579L12.2929 0.292893C12.6834 -0.097632 13.3166 -0.097632 13.7071 0.292893C14.0976 0.683417 14.0976 1.31658 13.7071 1.70711L7.70711 7.70711C7.31658 8.09763 6.68342 8.09763 6.29289 7.70711L0.292893 1.70711C-0.0976314 1.31658 -0.0976314 0.683417 0.292893 0.292893Z" fill="#5C6AA1"/>
        </svg>
    </div>
    <?php if($itinerary):?>
    <div class="cruiseItinerary__main" style="display: none">
        <?php if(count($itinerary['field_content']['und']) > 0):?>

            <?php for($t = 0; $t < count($itinerary['field_content']['und']); $t++):
                $content = trim($itinerary['field_content']['und'][$t]['value']);
                $title = '';
                if(substr($content,0,4) == '<h2>') {
                    $pos = strpos($content, '</h2>');
                    $title = ': '. substr($content,4,$pos);
                    $title = strip_tags($title);
                    $content = substr($content,$pos );
                }

                ?>
                <div class="tripRow">
                    <div class="tripTitle">
                        <svg class="minus" xmlns="http://www.w3.org/2000/svg" width="18" height="24" viewBox="0 0 18 24" fill="none">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M9 2C5.55148 2 2 4.54797 2 9C2 9.98482 2.41279 11.238 3.13802 12.6386C3.852 14.0175 4.81545 15.4391 5.79682 16.7333C6.77554 18.024 7.7567 19.1679 8.49433 19.99C8.67994 20.1969 8.84982 20.383 9 20.5457C9.15018 20.383 9.32006 20.1969 9.50567 19.99C10.2433 19.1679 11.2245 18.024 12.2032 16.7333C13.1845 15.4391 14.148 14.0175 14.862 12.6386C15.5872 11.238 16 9.98482 16 9C16 4.54797 12.4485 2 9 2ZM9 22C8.28852 22.7027 8.28838 22.7026 8.28822 22.7024L8.28104 22.6951L8.26216 22.6759C8.24586 22.6592 8.22221 22.6349 8.19169 22.6034C8.13066 22.5404 8.04215 22.4483 7.93007 22.3299C7.70597 22.0932 7.38735 21.751 7.00567 21.3256C6.2433 20.4759 5.22446 19.2885 4.20318 17.9417C3.18455 16.5984 2.148 15.0762 1.36198 13.5583C0.587213 12.062 0 10.4652 0 9C0 3.25203 4.64852 0 9 0C13.3515 0 18 3.25203 18 9C18 10.4652 17.4128 12.062 16.638 13.5583C15.852 15.0762 14.8155 16.5984 13.7968 17.9417C12.7755 19.2885 11.7567 20.4759 10.9943 21.3256C10.6126 21.751 10.294 22.0932 10.0699 22.3299C9.95785 22.4483 9.86934 22.5404 9.80831 22.6034C9.77779 22.6349 9.75414 22.6592 9.73784 22.6759L9.71896 22.6951L9.71227 22.7019C9.7121 22.7021 9.71148 22.7027 9 22ZM9 22L9.71148 22.7027L9 23.4231L8.28822 22.7024L9 22Z" fill="#5C6AA1"/>
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M5 8H13V10H5V8Z" fill="#5C6AA1"/>
                        </svg>
                        <svg class="d-none plus" xmlns="http://www.w3.org/2000/svg" width="18" height="24" viewBox="0 0 18 24" fill="none">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M9 2C5.55148 2 2 4.54797 2 9C2 9.98482 2.41279 11.238 3.13802 12.6386C3.852 14.0175 4.81545 15.4391 5.79682 16.7333C6.77554 18.024 7.7567 19.1679 8.49433 19.99C8.67994 20.1969 8.84982 20.383 9 20.5457C9.15018 20.383 9.32006 20.1969 9.50567 19.99C10.2433 19.1679 11.2245 18.024 12.2032 16.7333C13.1845 15.4391 14.148 14.0175 14.862 12.6386C15.5872 11.238 16 9.98482 16 9C16 4.54797 12.4485 2 9 2ZM9 22C8.28852 22.7027 8.28838 22.7026 8.28822 22.7024L8.28104 22.6951L8.26216 22.6759C8.24586 22.6592 8.22221 22.6349 8.19169 22.6034C8.13066 22.5404 8.04215 22.4483 7.93007 22.3299C7.70597 22.0932 7.38735 21.751 7.00567 21.3256C6.2433 20.4759 5.22446 19.2885 4.20318 17.9417C3.18455 16.5984 2.148 15.0762 1.36198 13.5583C0.587213 12.062 0 10.4652 0 9C0 3.25203 4.64852 0 9 0C13.3515 0 18 3.25203 18 9C18 10.4652 17.4128 12.062 16.638 13.5583C15.852 15.0762 14.8155 16.5984 13.7968 17.9417C12.7755 19.2885 11.7567 20.4759 10.9943 21.3256C10.6126 21.751 10.294 22.0932 10.0699 22.3299C9.95785 22.4483 9.86934 22.5404 9.80831 22.6034C9.77779 22.6349 9.75414 22.6592 9.73784 22.6759L9.71896 22.6951L9.71227 22.7019C9.7121 22.7021 9.71148 22.7027 9 22ZM9 22L9.71148 22.7027L9 23.4231L8.28822 22.7024L9 22Z" fill="#5C6AA1"></path>
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M10 5V13H8V5H10Z" fill="#5C6AA1"></path>
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M5 8H13V10H5V8Z" fill="#5C6AA1"></path>
                        </svg>
                        <p class="medium text16 blueDark"><?php echo t('Day')?> <?php echo ($t + 1).$title?></p>
                    </div>
                    <div class="cruiseItinerary__trip">
                        <div class="tripContent" style="display: block">
                            <?php echo $content?>
                        </div>

                    </div>
                </div>
            <?php endfor;?>
        <?php else:?>
            <div><?php echo t('Please select itinerary');?></div>
        <?php endif;?>

    </div>
    <?php else:?>


    <?php endif;?>


</div>
<?php endif;?>
<div class="cruiseAmenities" id="detail_cruiseAmenities">
    <div class="flexIcon__between cursorPointer titleShow">
        <p class="medium text24 blueDark"><?php echo t('Amenities');?></p>
        <svg width="14" height="8" viewBox="0 0 14 8" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M0.292893 0.292893C0.683417 -0.0976315 1.31658 -0.0976315 1.70711 0.292893L7 5.58579L12.2929 0.292893C12.6834 -0.097632 13.3166 -0.097632 13.7071 0.292893C14.0976 0.683417 14.0976 1.31658 13.7071 1.70711L7.70711 7.70711C7.31658 8.09763 6.68342 8.09763 6.29289 7.70711L0.292893 1.70711C-0.0976314 1.31658 -0.0976314 0.683417 0.292893 0.292893Z" fill="#5C6AA1"/>
        </svg>
    </div>
    <div class="cruiseAmenities__group" style="display: none">
        <ul>
            <li>
                <p class="blueDark medium text20"><?php echo t('Things to do, ways to relax')?></p>
            </li>
            <?php if(isset($data['info']['field_thing_to_do_relax']['und']) && count($data['info']['field_thing_to_do_relax']['und']) > 0):?>
                <?php for($i = 0; $i < count($data['info']['field_thing_to_do_relax']['und']); $i++):
                    $tid = $data['info']['field_thing_to_do_relax']['und'][$i]['tid'];
                    $item = isset($list_amenities[$tid])?$list_amenities[$tid]:'';
                    ?>
                    <?php if($item != ''):?>
                    <li>
                        <p class="blueDark"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="9" viewBox="0 0 12 9" fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M11.8047 0.528636C12.0651 0.788986 12.0651 1.2111 11.8047 1.47145L4.4714 8.80478C4.21106 9.06513 3.78894 9.06513 3.5286 8.80478L0.195262 5.47145C-0.0650874 5.2111 -0.0650874 4.78899 0.195262 4.52864C0.455612 4.26829 0.877722 4.26829 1.13807 4.52864L4 7.39057L10.8619 0.528636C11.1223 0.268287 11.5444 0.268287 11.8047 0.528636Z" fill="#5C6AA1"></path>
                            </svg><?php echo $item?></p>
                    </li>
                <?php endif;?>
                <?php endfor;?>
            <?php endif;?>

        </ul>
        <ul>
            <li>
                <p class="blueDark medium text20"><?php echo t('Dining, drinking, and snacking')?></p>
            </li>
            <?php if(isset($data['info']['field_drink_and_snacking']['und']) && count($data['info']['field_drink_and_snacking']['und']) > 0):?>
                <?php for($i = 0; $i < count($data['info']['field_drink_and_snacking']['und']); $i++):
                    $tid = $data['info']['field_drink_and_snacking']['und'][$i]['tid'];
                    $item = isset($list_amenities[$tid])?$list_amenities[$tid]:'';
                    ?>
                    <?php if($item != ''):?>
                    <li>
                        <p class="blueDark"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="9" viewBox="0 0 12 9" fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M11.8047 0.528636C12.0651 0.788986 12.0651 1.2111 11.8047 1.47145L4.4714 8.80478C4.21106 9.06513 3.78894 9.06513 3.5286 8.80478L0.195262 5.47145C-0.0650874 5.2111 -0.0650874 4.78899 0.195262 4.52864C0.455612 4.26829 0.877722 4.26829 1.13807 4.52864L4 7.39057L10.8619 0.528636C11.1223 0.268287 11.5444 0.268287 11.8047 0.528636Z" fill="#5C6AA1"></path>
                            </svg><?php echo $item?></p>
                    </li>
                <?php endif;?>
                <?php endfor;?>
            <?php endif;?>
        </ul>
        <ul>
            <li>
                <p class="blueDark medium text20"><?php echo t('Services and conveniences')?></p>
            </li>
            <?php if(isset($data['info']['field_service_and_convenience']['und']) && count($data['info']['field_service_and_convenience']['und']) > 0):?>
                <?php for($i = 0; $i < count($data['info']['field_service_and_convenience']['und']); $i++):
                    $tid = $data['info']['field_service_and_convenience']['und'][$i]['tid'];
                    $item = isset($list_amenities[$tid])?$list_amenities[$tid]:'';
                    ?>
                    <?php if($item != ''):?>
                    <li>
                        <p class="blueDark"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="9" viewBox="0 0 12 9" fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M11.8047 0.528636C12.0651 0.788986 12.0651 1.2111 11.8047 1.47145L4.4714 8.80478C4.21106 9.06513 3.78894 9.06513 3.5286 8.80478L0.195262 5.47145C-0.0650874 5.2111 -0.0650874 4.78899 0.195262 4.52864C0.455612 4.26829 0.877722 4.26829 1.13807 4.52864L4 7.39057L10.8619 0.528636C11.1223 0.268287 11.5444 0.268287 11.8047 0.528636Z" fill="#5C6AA1"></path>
                            </svg><?php echo $item?></p>
                    </li>
                <?php endif;?>
                <?php endfor;?>
            <?php endif;?>
        </ul>
    </div>
</div>
<div class="inclusions__options" id="detail_inclusions__options">
    <div class="flexIcon__between cursorPointer titleShow">
        <p class="medium text24 blueDark"><?php echo t('Inclusions & Options');?></p>
        <svg width="14" height="8" viewBox="0 0 14 8" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M0.292893 0.292893C0.683417 -0.0976315 1.31658 -0.0976315 1.70711 0.292893L7 5.58579L12.2929 0.292893C12.6834 -0.097632 13.3166 -0.097632 13.7071 0.292893C14.0976 0.683417 14.0976 1.31658 13.7071 1.70711L7.70711 7.70711C7.31658 8.09763 6.68342 8.09763 6.29289 7.70711L0.292893 1.70711C-0.0976314 1.31658 -0.0976314 0.683417 0.292893 0.292893Z" fill="#5C6AA1"/>
        </svg>
    </div>

    <div class="inclusions__options__main" style="display: none">
        <?php if(isset($data['info']['field_inclusions_options']['und'])):?>
            <?php foreach ($data['info']['field_inclusions_options']['und'] as $inclusions):?>
                <div class="inclusions__options__cont">
                    <div class="inclusions__left">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <path d="M17 12H7" stroke="#5C6AA1" stroke-width="2" stroke-miterlimit="10" stroke-linecap="square"/>
                            <path d="M12 23C18.0751 23 23 18.0751 23 12C23 5.92487 18.0751 1 12 1C5.92487 1 1 5.92487 1 12C1 18.0751 5.92487 23 12 23Z" stroke="#5C6AA1" stroke-width="2" stroke-miterlimit="10" stroke-linecap="square"/>
                        </svg>
                    </div>
                    <div class="inclusions__right blueDark">
                        <?php echo $inclusions['value'];?>
                    </div>
                </div>
            <?php endforeach;?>
        <?php endif;?>
    </div>

</div>

<div class="searchBox__header showMobile" abc><p class="medium text28 blueDark"><?php echo t('Choose your room')?></p></div>
<div class="cruiseEdit__search showMobile">
    <div class="editSearch__date">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 21 22" fill="none">
            <path d="M18.7103 0.411865H16.7477V2.52951C16.7477 2.95304 16.4206 3.23539 16.0935 3.23539C15.7664 3.23539 15.4393 2.95304 15.4393 2.52951V0.411865H4.97196V2.52951C4.97196 2.95304 4.64486 3.23539 4.31776 3.23539C3.99065 3.23539 3.66355 2.95304 3.66355 2.52951V0.411865H1.70093C0.719626 0.411865 0 1.32951 0 2.52951V5.07069H20.9346V2.52951C20.9346 1.32951 19.757 0.411865 18.7103 0.411865ZM0 6.55304V19.4707C0 20.7413 0.719626 21.5883 1.76636 21.5883H18.7757C19.8224 21.5883 21 20.6707 21 19.4707V6.55304H0ZM5.82243 18.4119H4.25234C3.99065 18.4119 3.72897 18.2001 3.72897 17.8472V16.0825C3.72897 15.8001 3.92523 15.5177 4.25234 15.5177H5.88785C6.14953 15.5177 6.41122 15.7295 6.41122 16.0825V17.8472C6.34579 18.2001 6.14953 18.4119 5.82243 18.4119ZM5.82243 12.0589H4.25234C3.99065 12.0589 3.72897 11.8472 3.72897 11.4942V9.72951C3.72897 9.44716 3.92523 9.16481 4.25234 9.16481H5.88785C6.14953 9.16481 6.41122 9.37657 6.41122 9.72951V11.4942C6.34579 11.8472 6.14953 12.0589 5.82243 12.0589ZM11.0561 18.4119H9.42056C9.15888 18.4119 8.8972 18.2001 8.8972 17.8472V16.0825C8.8972 15.8001 9.09346 15.5177 9.42056 15.5177H11.0561C11.3178 15.5177 11.5794 15.7295 11.5794 16.0825V17.8472C11.5794 18.2001 11.3832 18.4119 11.0561 18.4119ZM11.0561 12.0589H9.42056C9.15888 12.0589 8.8972 11.8472 8.8972 11.4942V9.72951C8.8972 9.44716 9.09346 9.16481 9.42056 9.16481H11.0561C11.3178 9.16481 11.5794 9.37657 11.5794 9.72951V11.4942C11.5794 11.8472 11.3832 12.0589 11.0561 12.0589ZM16.2897 18.4119H14.6542C14.3925 18.4119 14.1308 18.2001 14.1308 17.8472V16.0825C14.1308 15.8001 14.3271 15.5177 14.6542 15.5177H16.2897C16.5514 15.5177 16.8131 15.7295 16.8131 16.0825V17.8472C16.8131 18.2001 16.6168 18.4119 16.2897 18.4119ZM16.2897 12.0589H14.6542C14.3925 12.0589 14.1308 11.8472 14.1308 11.4942V9.72951C14.1308 9.44716 14.3271 9.16481 14.6542 9.16481H16.2897C16.5514 9.16481 16.8131 9.37657 16.8131 9.72951V11.4942C16.8131 11.8472 16.6168 12.0589 16.2897 12.0589Z" fill="#5C6AA1"></path>
        </svg>
        <p class="text12 colorBluedark900">26 Jun 2022</p>
    </div>
    <div class="editSearch__time">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 22 22" fill="none">
            <path d="M11 0C8.82441 0 6.69767 0.645139 4.88873 1.85383C3.07979 3.06253 1.66989 4.78049 0.83733 6.79048C0.00476617 8.80047 -0.213071 11.0122 0.211367 13.146C0.635804 15.2798 1.68345 17.2398 3.22183 18.7782C4.76021 20.3166 6.72022 21.3642 8.85401 21.7886C10.9878 22.2131 13.1995 21.9952 15.2095 21.1627C17.2195 20.3301 18.9375 18.9202 20.1462 17.1113C21.3549 15.3023 22 13.1756 22 11C21.9966 8.08367 20.8365 5.28778 18.7744 3.22563C16.7122 1.16347 13.9163 0.00344047 11 0ZM14.707 14.707C14.5195 14.8945 14.2652 14.9998 14 14.9998C13.7348 14.9998 13.4805 14.8945 13.293 14.707L10.293 11.707C10.1055 11.5195 10.0001 11.2652 10 11V5C10 4.73478 10.1054 4.48043 10.2929 4.29289C10.4804 4.10536 10.7348 4 11 4C11.2652 4 11.5196 4.10536 11.7071 4.29289C11.8946 4.48043 12 4.73478 12 5V10.586L14.707 13.293C14.8945 13.4805 14.9998 13.7348 14.9998 14C14.9998 14.2652 14.8945 14.5195 14.707 14.707Z" fill="#5C6AA1"></path>
        </svg>
        <p class="text12 colorBluedark900">2 days/ 1 night</p>
        <button type="button">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 22 22" fill="none">
                <path d="M21.707 4.29303L17.707 0.293031C17.5195 0.10556 17.2652 0.000244141 17 0.000244141C16.7348 0.000244141 16.4805 0.10556 16.293 0.293031L13.5 3.08603L18.914 8.50003L21.707 5.70703C21.8945 5.5195 21.9998 5.26519 21.9998 5.00003C21.9998 4.73487 21.8945 4.48056 21.707 4.29303Z" fill="#5C6AA1"/>
                <path d="M12.086 4.5L2.29297 14.293C2.18339 14.4029 2.10088 14.5367 2.05197 14.684L0.0519735 20.684C0.00192931 20.8343 -0.0117136 20.9942 0.0121681 21.1508C0.0360497 21.3074 0.0967728 21.456 0.189339 21.5845C0.281904 21.713 0.403665 21.8177 0.544598 21.8899C0.685531 21.9621 0.841606 21.9999 0.999973 22C1.10744 22 1.21417 21.9824 1.31597 21.948L7.31597 19.948C7.46324 19.8991 7.5971 19.8166 7.70697 19.707L17.5 9.914L12.086 4.5Z" fill="#5C6AA1"/>
            </svg>
        </button>

    </div>
    <div class="editSearch__filter">
        <p class="text12 colorBluedark900">3 rooms...</p>
    </div>
</div>



<?php
$star = isset($data['info']['field_star']['und'][0]['value'])?$data['info']['field_star']['und'][0]['value']:'';
$field_excellent = isset($data['info']['field_excellent']['und'][0]['value'])?$data['info']['field_excellent']['und'][0]['value']:'';
$field_good = isset($data['info']['field_good']['und'][0]['value'])?$data['info']['field_good']['und'][0]['value']:'';
$field_okay = isset($data['info']['field_okay']['und'][0]['value'])?$data['info']['field_okay']['und'][0]['value']:'';
$field_poor = isset($data['info']['field_poor']['und'][0]['value'])?$data['info']['field_poor']['und'][0]['value']:'';
$field_terrible = isset($data['info']['field_poor']['und'][0]['value'])?$data['info']['field_poor']['und'][0]['value']:'';

$field_cleanliness = isset($data['info']['field_cleanliness']['und'][0]['value'])?$data['info']['field_cleanliness']['und'][0]['value']:'';
$field_review_amenities = isset($data['info']['field_review_amenities']['und'][0]['value'])?$data['info']['field_review_amenities']['und'][0]['value']:'';
$field_staff_and_service = isset($data['info']['field_staff_and_service']['und'][0]['value'])?$data['info']['field_staff_and_service']['und'][0]['value']:'';
$field_property_condition_facilit = isset($data['info']['field_property_condition_facilit']['und'][0]['value'])?$data['info']['field_property_condition_facilit']['und'][0]['value']:'';
$total = $field_excellent + $field_good + $field_okay + $field_poor + $field_terrible;
$field_excellent = round($field_excellent/$total,1)*100;
$field_good = round($field_good/$total,1)*100;
$field_okay = round($field_okay/$total,1)*100;
$field_poor = round($field_poor/$total,1)*100;
$field_terrible = round($field_terrible/$total,1)*100;
?>
<div id="detail_customer__rating__score" class="customer__rating__score">
    <div class="customer__rating__score__main">
        <div class="rating__header showMobile">
            <button type="button"><svg xmlns="http://www.w3.org/2000/svg" width="8" height="14" viewBox="0 0 8 14" fill="none">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M7.70711 0.292893C8.09763 0.683417 8.09763 1.31658 7.70711 1.70711L2.41421 7L7.70711 12.2929C8.09763 12.6834 8.09763 13.3166 7.70711 13.7071C7.31658 14.0976 6.68342 14.0976 6.29289 13.7071L0.292893 7.70711C-0.0976311 7.31658 -0.0976311 6.68342 0.292893 6.29289L6.29289 0.292893C6.68342 -0.0976311 7.31658 -0.0976311 7.70711 0.292893Z" fill="#5C6AA1"/>
                </svg></button>
        </div>
        <div class="rating__top">
            <div class="rating__cont">
                <span class="medium blueDark"><?php echo $star?></span>
                <div class="rating__all__reviews">
                    <p class="text24 medium blueDark"><?php echo t('Wonderful');?></p>
                    <a href="#"><p class="blue1"><?php echo t('Verified review');?></p></a>
                </div>
            </div>
            <div class="rating__line">
                <div class="rating__line__item">
                    <div class="ratingItem__top blueDark">
                        <p>5 - <?php echo t('Excellent');?></p>
                        <p><?php echo $field_excellent?>%</p>
                    </div>
                    <div class="ratingItem__Bottom">
                        <div class="middle">
                            <div class="bar-container">
                                <div class="bar-<?php echo substr($field_excellent,0,1)?>"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="rating__line__item">
                    <div class="ratingItem__top blueDark">
                        <p>4 - <?php echo t('Good');?></p>
                        <p><?php echo $field_good?>%</p>
                    </div>
                    <div class="ratingItem__Bottom">
                        <div class="middle">
                            <div class="bar-container">
                                <div class="bar-<?php echo substr($field_good,0,1)?>"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="rating__line__item">
                    <div class="ratingItem__top blueDark">
                        <p>3 - <?php echo t('Okay');?></p>
                        <p><?php echo $field_okay?>%</p>
                    </div>
                    <div class="ratingItem__Bottom">
                        <div class="middle">
                            <div class="bar-container">
                                <div class="bar-<?php echo substr($field_okay,0,1)?>"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="rating__line__item">
                    <div class="ratingItem__top blueDark">
                        <p>2 - <?php echo t('Poor');?></p>
                        <p><?php echo $field_poor?>%</p>
                    </div>
                    <div class="ratingItem__Bottom">
                        <div class="middle">
                            <div class="bar-container">
                                <div class="bar-<?php echo substr($field_poor,0,1)?>"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="rating__line__item">
                    <div class="ratingItem__top blueDark">
                        <p>1 - <?php echo t('Terrible');?></p>
                        <p><?php echo $field_terrible?>%</p>
                    </div>
                    <div class="ratingItem__Bottom">
                        <div class="middle">
                            <div class="bar-container">
                                <div class="bar-<?php echo substr($field_terrible,0,1)?>"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="rating__number">
                <ul>
                    <li>
                        <p class="text24 medium blueDark"><?php echo $field_cleanliness?></p>
                        <p class="blueDark"><?php echo t('Cleanliness');?></p>
                    </li>
                    <li>
                        <p class="text24 medium blueDark"><?php echo $field_staff_and_service?></p>
                        <p class="blueDark"><?php echo t("Staff &amp; service");?></p>
                    </li>
                </ul>
                <ul>
                    <li>
                        <p class="text24 medium blueDark"><?php echo $field_review_amenities?></p>
                        <p class="blueDark"><?php echo t('Amenities');?></p>
                    </li>
                    <li>
                        <p class="text24 medium blueDark"><?php echo $field_property_condition_facilit?></p>
                        <p class="blueDark"><?php echo t('Property condition &amp; facilities');?></p>
                    </li>
                </ul>
            </div>
        </div>
        <div class="rating__bottom">
            <?php

            $client_review = array();
            if(isset($data['review']) && count($data['review']) > 0):?>
                <?php
                $k = 0;
                foreach ($data['review'] as $ob) {
                    $created = $ob['field_date']['und'][0]['value'];
                    $created = DateTime::createFromFormat("d/m/Y", $created);
                    $created = $created->getTimestamp() + 1;
                    $client_review[$created] = $ob;
                }
                krsort($client_review);
                //print_r($client_review);
                ?>
                <?php $i = 0; foreach ($client_review as $ob):

                    if(isset($ob['avatar'])) {
                        $avatar = $ob['avatar'];
                    } else {
                        $avatar = $theme.'images/avatar.jpg';
                    }
                    $country = isset($ob['field_country']['und'][0]['value'])?$ob['field_country']['und'][0]['value']:'United States';
                    ?>
                    <div nid="<?php echo $ob['nid']?>" class="rating__bottom__group <?php  echo ($i > 4)?'d-none':''?>" >
                        <div class="ratingBottom__point">
                            <p class="colorWhite text24 medium"><?php echo $ob['field_point']['und'][0]['value']?></p>
                            <p class="text16 medium blueDark"><?php echo $ob['title']?></p>
                        </div>
                        <div class="ratingBottom__user">
                            <img width="50px" height="50px" src="<?php echo $avatar?>">
                            <p>
                                <span class="medium blueDark"><?php echo $ob['field_author']['und'][0]['value']?></span>
                                <span class="blueDark"><?php echo $ob['field_date']['und'][0]['value']?></span>
                            </p>
                        </div>
                        <div class="ratingBottom__cont">
                            <p class="blueDark"><?php echo strip_tags($ob['body']['und'][0]['value'])?></p>
                        </div>
                    </div>
                <?php $i++; endforeach;?>
            <?php endif;?>
            <div class="" style="text-align: center">
            <a class="btn btn-outline-orange btn-lg mt10 more_review d-none" >
                <div class="flexIcon">
                    <p><?php echo t('View more');?></p>
                    <svg class="ml5" xmlns="http://www.w3.org/2000/svg" width="16" height="8" viewBox="0 0 16 8" fill="none">
                        <path d="M15.8047 3.52731L12.6193 0.341981C12.5261 0.248775 12.4073 0.185304 12.278 0.159592C12.1487 0.13388 12.0147 0.147082 11.8929 0.197529C11.7711 0.247975 11.667 0.333402 11.5937 0.443009C11.5205 0.552615 11.4814 0.681481 11.4813 0.813314V2.83198C11.4813 2.87618 11.4638 2.91858 11.4325 2.94983C11.4013 2.98109 11.3589 2.99865 11.3147 2.99865H1C0.734784 2.99865 0.48043 3.104 0.292893 3.29154C0.105357 3.47908 0 3.73343 0 3.99865C0 4.26386 0.105357 4.51822 0.292893 4.70575C0.48043 4.89329 0.734784 4.99865 1 4.99865H11.3147C11.3589 4.99865 11.4013 5.01621 11.4325 5.04746C11.4638 5.07872 11.4813 5.12111 11.4813 5.16531V7.18398C11.4814 7.31581 11.5205 7.44468 11.5937 7.55429C11.667 7.66389 11.7711 7.74932 11.8929 7.79977C12.0147 7.85021 12.1487 7.86342 12.278 7.8377C12.4073 7.81199 12.5261 7.74852 12.6193 7.65531L15.8047 4.46998C15.9296 4.34496 15.9999 4.17542 15.9999 3.99865C15.9999 3.82187 15.9296 3.65233 15.8047 3.52731Z" fill="#FD6431"></path>
                    </svg>
                </div>
            </a>
            </div>

        </div>
    </div>
</div>

<?php

echo blk_room_detail_popup($data);
?>
<input type="hidden" id="all_amenities" value="<?php echo htmlentities(json_encode($list_amenities))?>" />

<script>
$('document').ready(function () {
    filter();
    var flag = false;
    ///mobi
    $(".cruiseService__slide").slick({
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
                    arrows: false
                }
            }
        ]
    });

    $('.tripTitle').click(function () {
        $(this).parents('.tripRow').find('div.tripContent').toggle();
        if($(this).find('svg.minus').hasClass('d-none')) {
            $(this).find('svg.minus').removeClass('d-none');
        } else {
            $(this).find('svg.minus').addClass('d-none');
        }
        if($(this).find('svg.plus').hasClass('d-none')) {
            $(this).find('svg.plus').removeClass('d-none');
        } else {
            $(this).find('svg.plus').addClass('d-none');
        }
    });

    var lang = '<?php echo $lang?>';
    console.log(lang);
    $('.reserve__room a').click(function () {
        $('.tripSummary__cont').find('.count_room').empty();
        var date_val = $('.searchBox__form .datepicker input').val();
        if(date_val == ''){
            scroll_top('searchBox__date', 100);
            $(this).parents('.cruiseDetails__main').find('.searchBox__form #datepickerReturn').datepicker('show').focus();
        }else {
            var search_param = JSON.parse($('input[name=search_param]').val());
            if(search_param.depart){
                if(search_param == '') {

                    if( screen.width <= 480 ) {
                        $('.editSearch__time button').click();
                    } else {
                        $('#datepickerReturn').focus().click();

                    }



                    return false;
                }

                //show price modal
                var ar_price = new Array();
                var ar_count = new Array();
                var title = "<?php echo $itinerary['title']?>";
                var total = 0;
                var txt = '';
                var data_passenger = [];
                if($(this).hasClass('change')) {
                    var room_id = $(this).parents('.cruiseService__table__row').attr('room');
                    var price = $(this).parents('.cruiseService__table__row').attr('price');
                    var title = $(this).parents('.cruiseService__table__row').attr('title');

                    $(this).text('<?php echo t("Book ");?>').removeClass('change').addClass('btn-orange').removeClass('btn-blue');
                    $(this).parents('.cruiseService__table').find('div.cruiseService__table__row').removeClass('d-none');
                    $(this).parents('.cruiseService__table__row').find('input.choose').removeClass('choosen');
                    $(this).parents('.cruiseService__table').find('input.room_selected').val('');
                    $(this).parents('.cruiseService__table').find('input.price_selected').val('');
                    $('span#detail_price').html(0);

                    $(this).parents('.cruiseService__table').find('input.price_selected').attr('price_room',room_id);

                    $(this).parents('.cruiseService__table__row').find('input.choose').attr('r_id',room_id);
                    $(this).parents('.cruiseService__table__row').find('input.choose').attr('pr',price);
                    $(this).parents('.cruiseService__table__row').find('input.choose').attr('tt',title);

                    $('input.price_selected').each(function () {
                        var obj = {};
                        var cnt = {};
                        var tt   =  $(this).attr('tt');
                        var r_id   =  $(this).attr('r_id');
                        var pr   =   $(this).val();
                        // console.log(tt, r_id, pr);

                        if(pr!='undefined' && pr!='' && pr!=null){
                            obj['price_room'] = pr;
                            obj['room_id'] = r_id;
                            ar_price.push(obj);

                        }
                    });



                } else {
                    var room_id = $(this).parents('.cruiseService__table__row').attr('room');
                    var price = $(this).parents('.cruiseService__table__row').attr('price');
                    var title = $(this).parents('.cruiseService__table__row').attr('title');
                    // console.log(room_id, price);
                    $(this).text('<?php echo t("Change ");?>').addClass('change').addClass('btn-blue').removeClass('btn-orange');
                    $(this).parents('.cruiseService__table').find('div.cruiseService__table__row').addClass('d-none');
                    $(this).parents('.cruiseService__table__row').removeClass('d-none');
                    $(this).parents('.cruiseService__table__row').find('input.choose').addClass('choosen');
                    $(this).parents('.cruiseService__table').find('input.room_selected').val(room_id);
                    $(this).parents('.cruiseService__table').find('input.price_selected').val(price);

                    $(this).parents('.cruiseService__table').find('input.price_selected').attr('price_room',room_id);

                    $(this).parents('.cruiseService__table__row').find('input.choose').attr('r_id',room_id);
                    $(this).parents('.cruiseService__table__row').find('input.choose').attr('pr',price);
                    $(this).parents('.cruiseService__table__row').find('input.choose').attr('tt',title);
                    // console.log($('input.choosen'));
                    $('input.price_selected').each(function () {
                        var obj = {};
                        var cnt = {};
                        var tt   =  $(this).attr('tt');
                        var r_id   =  $(this).attr('r_id');
                        var pr   =  $(this).val();
                        // console.log(tt, r_id, pr);

                        if(pr!='undefined' && pr!='' && pr!=null){
                            obj['price_room'] = pr;
                            obj['room_id'] = r_id;
                            ar_price.push(obj);
                        }
                    });

                }

                //total summary
                for (var j = 0; j < ar_price.length; j++){
                    total+=parseFloat(ar_price[j]['price_room']) || 0;
                }
                var total_final = format1(total);

                $('span#detail_price').html(total_final);

                $('#total_charge').html(total_final);
                $('#total_charge').attr('total_charge',total);

                var is_continue = _is_continue();
                if(is_continue) {
                    $('input[name=passenger]').removeClass('disabled');
                } else {
                    $('input[name=passenger]').addClass('disabled');
                }
            }else {
                scroll_top('searchBox__btn', 200);
                $('.searchBox__btn').addClass('zoom-in-zoom-out').focus();
            }

        }

    });

    $(document).mouseup(function (e) {
        if ($(e.target).closest(".display-none").length=== 0) {
            $(".display-none").hide();
        }
    });

    var int = 0;
    $('button[name=detail_price]').click(function () {
        flag = true;

        if  (int%2==0) {
            $('.display-none').css('display','');
            int++;
        } else {
            $('.display-none').css('display','none');
            int++;
        }
        if (flag) {
            $('.tripSummary__cont').find('.count_room').empty();
            $('.tripSummary__ul').find('.tripSummary__ul__total').remove();
            flag = false;

            // $('.display-none').css('display','none');
        }
        var sampleArray = new Array();
        var ar_price = new Array();
        const counts = {};
        const pri = {};
        var ary = new Array();
        var ar_p = new Array();
        var c = '';
        var t = '';
        $('.choosen').each(function () {
            var title = $(this).attr('tt');
            var price = $(this).attr('pr');
            sampleArray.push(title);
            ar_price.push(price);
        });
        //count room
        sampleArray.forEach(function (x) {
            counts[x] = (counts[x] || 0) + 1;
        });
        ar_price.forEach(function (x) {
            pri[x] = (pri[x] || 0) + 1;
        });
        for (const [key, value] of Object.entries(counts)) {
            var  i = `${key}: ${value}`.split(': ');
            ary.push(i);
        }
        for (const [key, value] of Object.entries(pri)) {
            var  j = `${key}: ${value}`.split(': ');
            ar_p.push(j);
        }
        //append title duration
        ary.forEach(function (key) {
            c +='<li class="medium blueDark ">'+ key[1] + ' x '+ key[0]+'</li>';
        })
        c +='<li class="medium blueDark">'+ "<?php echo $itinerary['title']?>" +'</li>';
        let m = '';
        if (lang == 'vi'){
            m = ' VND';
        } else {
            m = ' USD';
        }
        ar_p.forEach(function (key) {
            t +='<ul class="tripSummary__ul__total"><li ><p class=" blueDark ">Room Price</p></li>';
            if (key[0] != 1){
                t +='<li><p  class=" blueDark ">'+ format1(parseFloat(key[0])*parseFloat(key[1])) + m +' </p></li></ul>';
            } else {
                t +='<li><p  class=" blueDark ">'+ format1(parseFloat(key[0])) + m +'</p></li></ul>';
            }

        })
        console.log(sampleArray.length);
        $('.numb_room').html(sampleArray.length + " room, ");
        $('.tripSummary__cont').find('.count_room').append(c);
        $('.tripSummary__ul').append(t);
    })

    $('#roomDetailPopup').on('show.bs.modal', function (e) {
        var room_img_str =$(e.relatedTarget).parents('.room').attr('room_img');
        var summary = $(e.relatedTarget).parents('.room').attr('summary');
        var title = $(e.relatedTarget).parents('.room').attr('title');
        $('#roomDetailPopup .room_title').text(title);
        $('#roomDetailPopup .room_summary').text(summary);
        var total_overview = parseInt($('#total_overview').text());
        var total = 0;
        var all_img = '';
        var overview_img = $('#roomDetailPopup .roomType__image').html();
        if(room_img_str != '') {
            var room_img = JSON.parse(room_img_str);
            if(room_img && room_img.length > 0) {
                total += room_img.length + total_overview;
                $('#total_img').text(total);
                $('#total_img_room').text(room_img.length);
                for(var i = 0; i < room_img.length; i++) {
                    if(i == 0) {
                        $('#roomDetailPopup .roomPopup__image img').attr('src',room_img[i]);
                    }
                    all_img += '<div class="roomType__item__img"><img src="' + room_img[i] + '" /></div>';
                }
                all_img += overview_img;
               $('#roomDetailPopup .roomType__image').html(all_img);

            }
        }

        //show amenities__item
        var amenities__item = $(e.relatedTarget).parents('.room').attr('amenities');
        amenities__item = JSON.parse(amenities__item);
        var amenities_html = '';

        var all_amenities = $('#all_amenities').val();
        all_amenities = JSON.parse(all_amenities);
        if(amenities__item && amenities__item.length > 0) {
            for(var i = 0; i < amenities__item.length; i++) {
                var tid = amenities__item[i]['tid'];
                if(all_amenities[tid]) {
                    amenities_html += '<li class="blueDark"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="9" viewBox="0 0 12 9" fill="none"><path fill-rule="evenodd" clip-rule="evenodd" d="M11.8047 0.528636C12.0651 0.788986 12.0651 1.2111 11.8047 1.47145L4.4714 8.80478C4.21106 9.06513 3.78894 9.06513 3.5286 8.80478L0.195262 5.47145C-0.0650874 5.2111 -0.0650874 4.78899 0.195262 4.52864C0.455612 4.26829 0.877722 4.26829 1.13807 4.52864L4 7.39057L10.8619 0.528636C11.1223 0.268287 11.5444 0.268287 11.8047 0.528636Z" fill="#5C6AA1"></path></svg>' +all_amenities[tid]+ '</li>';
                }
            }
        }
        $('#roomDetailPopup .amenities__item ul').html(amenities_html);

        $('#roomDetailPopup .roomType__image img').click(function () {
            var src = $(this).attr('src');
            src = src.replace(/large/g, "600x600");
            $('#roomDetailPopup .roomPopup__image img').attr('src',src);
        });
    });

    show_review();


});
window.onscroll = function() {scrollFunction()};

function format1(n) {
    return  n.toFixed(0).replace(/./g, function(c, i, a) {
        return i > 0 && c !== "." && (a.length - i) % 3 === 0 ? "," + c : c;
    });
}

function scrollFunction() {
    if (document.body.scrollTop > 50 || document.documentElement.scrollTop > 50) {
        $('.position-status').css({'position':'fixed', 'top':0});
    } else {
        $('.position-status').css({'position':'fixed', 'top':'auto'});
    }
}


function getUniqueDataCount(objArr, propName) {
    var data = [];
    if (Array.isArray(propName)) {
        propName.forEach(prop => {
            objArr.forEach(function(d, index) {
                if (d[prop]) {
                    data.push(d[prop]);
                }
            });
        });
    } else {
        objArr.forEach(function(d, index) {
            if (d[propName]) {
                data.push(d[propName]);
            }
        });
    }

    var uniqueList = [...new Set(data)];

    var dataSet = new Array();
    for (var i = 0; i < uniqueList.length; i++) {
        var ds = {};
        ds['room'] = uniqueList[i];
        ds['numb'] = data.filter(x => x == uniqueList[i]).length;
        dataSet.push(ds);
    }

    return dataSet;
}

//js show price summary
function _detail_show_price_summary() {
    var room = '';
    var price = '';
}

function _is_continue() {
    var rooms = $('.cruiseService__table .room_selected');
    var is_ok  = true;
    if(rooms.length > 0) {
        for(var i = 0; i < rooms.length ; i++) {
            if($(rooms[i]).val() == '') {
                is_ok = false;
                break;
            }
        }
    }
    return is_ok;
}
function show_review() {
    $('.more_review').click(function () {
        var review_hidden = $('.customer__rating__score__main .rating__bottom__group.d-none');
        if(review_hidden.length > 0) {
            if(review_hidden.length  > 5) {
                var l = 5;
            } else {
                var l = review_hidden.length;
            }
            for(var i = 0; i < l; i++) {
                $(review_hidden[i]).removeClass('d-none');
            }
        }

        var total_hidden = $('.customer__rating__score__main .rating__bottom__group.d-none').length;

        if(total_hidden > 0 ) {
            $('.more_review').removeClass('d-none');
        } else {
            $('.more_review').addClass('d-none');
        }

    });
    var total_hidden = $('.customer__rating__score__main .rating__bottom__group.d-none').length;

    if(total_hidden > 0 ) {
        $('.more_review').removeClass('d-none');
    } else {
        $('.more_review').addClass('d-none');
    }





}

function filter() {
    $('.button__filter').click(function () {
        $('.button__filter').removeClass('active');
        $(this).addClass('active');
        var filter = $(this).attr('filter');
        if(filter == 'all_room') {
            $('.cruiseService__table__row').removeClass('d-none');
        } else {
            $('.cruiseService__table__row').addClass('d-none');
            var list_room = $('.cruiseService__table__row');
            if(filter == 'triple' || filter == 'double' || filter == 'single') {

                if(filter == 'triple') {
                    filter = 'family';
                }
                if(list_room.length > 0) {
                    for (var i = 0; i < list_room.length; i++) {
                        var type_room = $(list_room[i]).attr('type_room');
                        if(type_room != '') {
                            var type_room_arr = type_room.split(',');
                            if(type_room_arr.indexOf(filter) >= 0) {
                                $(list_room[i]).removeClass('d-none');
                            }
                        }
                    }
                }

            } else if(filter == 'free kayaking' || filter == 'free breakfast' || filter == 'free wifi' || filter == 'chèo thuyền kayak miễn phí' || filter == 'miễn phí bữa sáng') {
                if(list_room.length > 0) {
                    for (var i = 0; i < list_room.length; i++) {
                        var included = $(list_room[i]).find('input.included').val();
                        console.log(included);
                        if(included != '' && included != undefined) {
                            var included_arr = included.split(',');
                            if(included_arr.indexOf(filter) >= 0) {
                                $(list_room[i]).removeClass('d-none');
                            }
                        }
                    }
                }
            } else if(filter == 'cheapest') {
                var min_price = $('input[name=min_price]').val();
                if(list_room.length > 0) {
                    for (var i = 0; i < list_room.length; i++) {
                        var price = $(list_room[i]).attr('price');
                        if(parseInt(price) == parseInt(min_price) ) {
                            $(list_room[i]).removeClass('d-none');
                        }

                    }
                }
            }
        }

        return false;
    });
}
</script>
<script>

    $('input[name=passenger]').click(function () {
        var rooms = $('.cruiseService__table .room_selected');
        var is_ok  = true;
        if(rooms.length > 0) {
            for(var i = 0; i < rooms.length ; i++) {
                if($(rooms[i]).val() == '') {
                    is_ok = false;
                    break;
                }
            }
        }

        return is_ok;
    });



    $('.titleShow').click(function () {
        $(this).next().slideToggle(300);
        $(this).toggleClass('rotate');
    });


    $('.homeLeft__button').click(function () {
        var acb = $('.homeOffers__group').width();
        $(this).parents('.homeLeft').toggleClass('MvE2');
        if($('.homeLeft').hasClass('MvE2')){
            $('.homeRight').addClass('MvE1');
            $('.footer').addClass('MvE1');

        }else {
            $('.homeRight').removeClass('MvE1');
            $('.footer').removeClass('MvE1');
        }
    });

    $('.t-datepicker').tDatePicker({
        autoClose: true,
        titleCheckIn: 'Check in',
        titleCheckOut: 'Return',
        titleDateRange: 'day',
        titleDateRanges: 'days',
        iconDate: '',
        iconArrowTop: false
    });
</script>
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

    $(".inputPlace").click(function () {
        $(this).next('.suggestion').addClass('open');
    });
    $(document).mouseup(function (e) {
        var suggestion = $('.suggestion');
        if (!suggestion.is(e.target) && suggestion.has(e.target).length === 0) {
            $('.suggestion').removeClass('open');
        }
        ;
    });

    $('.button__review__tab').click(function () {
        $(this).parents('.cruiseDetails__main').find('.customer__rating__score').addClass('open');
    });
    $('.rating__header button').click(function () {
        $(this).parents('.cruiseDetails__main').find('.customer__rating__score').removeClass('open');
    });
    $('.cruiseInf__header .overview').click(function () {
        $('html, body').animate({
            scrollTop: $("#detail_overview").offset().top
        }, 2000);
    });
    $('.cruiseInf__header .room').click(function () {

        $('html, body').animate({
            scrollTop: $("#detail_room").offset().top
        }, 2000);
    });
    $('.cruiseInf__header .itinerary').click(function () {
        $('.cruiseItinerary__title').click();
        $('html, body').animate({
            scrollTop: $("#detail_itinerary").offset().top
        }, 2000);
    });
    $('.cruiseInf__header .amenities').click(function () {
        $('#detail_cruiseAmenities .titleShow').click();
        $('html, body').animate({
            scrollTop: $("#detail_cruiseAmenities").offset().top
        }, 2000);
    });
    $('.cruiseInf__header .inclusions').click(function () {
        $('#detail_inclusions__options .titleShow').click();
        $('html, body').animate({
            scrollTop: $("#detail_inclusions__options").offset().top
        }, 2000);
    });
    $('.cruiseInf__header .reviews').click(function () {

        $('html, body').animate({
            scrollTop: $("#detail_customer__rating__score").offset().top
        }, 2000);
    });

    $('.editSearch__time button').click(function () {
        console.log('xxxx');
        $(this).parents('.homeRight').find('.searchBox').addClass('open');
    });
    $('.closeSearch__cruise').click(function () {
        $(this).parents('.searchBox').removeClass('open');
    });

</script>