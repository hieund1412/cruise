<?php
global $conf;
//print_r($_REQUEST);

//print_r($_SESSION);die;
$lang = isset($_SESSION['lang'])?$_SESSION['lang']:'en';
$tran = isset($_REQUEST['t'])?$_REQUEST['t']:'';
$search_param = isset($_SESSION['search_param'])?$_SESSION['search_param']:null;

if($tran == '' || !$search_param) {
    drupal_goto('');die;
}
$cruise_obj = null;
$room_type_number = array_count_values($search_param[$tran]['room_selected']);
$cruise_id = null;

if(isset($search_param[$tran]['cruise']) && $search_param[$tran]['cruise'] > 0) {
    $cruise_id = $search_param[$tran]['cruise'];
    $itinerary_id = $search_param[$tran]['arg2'];
    $cruise_obj =  detail_cruise($cruise_id);
    $itinerary = isset($cruise_obj['itinerary'][$itinerary_id])?$cruise_obj['itinerary'][$itinerary_id]:array();
    //print_r($itinerary);die;
}

$is_full_day = false;
if(isset($search_param[$tran]['duration']) && $search_param[$tran]['duration'] == 'full_day') {
    $is_full_day = true;
}
$discount = get_discount_for_booking($cruise_id,$search_param[$tran]['duration'],$search_param[$tran]);
//print_r($discount);
$depart = strtotime($search_param[$tran]['depart']);

$cruise_img = isset($cruise_obj['info']['field_cruise_image']['und'][0]['uri'])?$cruise_obj['info']['field_cruise_image']['und'][0]['uri']:'';
$cruise_img = file_create_url($cruise_img);
$cruise_img = convert_img_url($cruise_img);
$num_day = substr($search_param[$tran]['duration'],0,1);
$num_day = filter_var($num_day,FILTER_SANITIZE_NUMBER_INT) - 1;
if($num_day > 0) {
    $return = date('Y-m-d', strtotime($search_param[$tran]['depart'] . ' +'.$num_day.' days'));
} else {
    $return = $search_param[$tran]['depart'];
}


$return = strtotime($return);
if($is_full_day) {
    $return = $depart;
}

$num_adult = 0;
$num_child = 0;
$num_infant = 0;

for($r = 0; $r < $search_param[$tran]['no_room']; $r++) {
    $num_adult += $search_param[$tran]['adult'][$r];
    $num_child += $search_param[$tran]['child'][$r];
    $num_infant += $search_param[$tran]['infant'][$r];

}


?>

<?php if($itinerary && $cruise_obj && isset($search_param[$tran]['room_selected']) && count($search_param[$tran]['room_selected']) > 0):?>
<div class="flightPassenger__row">
    <div class="flightPassenger__left">
        <form method="post" action="<?php echo base_path().'review?t='.$tran?>" id="frmReview">

        <div class="formBox">
            <div class="formBox__body">
                <div class="formBox__title">
                    <span class="text20 blueDark medium"><?php echo $cruise_obj['info']['title'] . ' - '. $itinerary['title']?></span>
                    <p class="tableIcon__star">
                        <?php echo isset($cruise_obj['info']['field_star']['und'][0]['value'])?html_star($cruise_obj['info']['field_star']['und'][0]['value']):'';?>
                    </p>
                </div>
                <?php for($r = 0; $r < count($search_param[$tran]['room_selected']); $r++):
                    $room_id = $search_param[$tran]['room_selected'][$r];
                    $room_obj = isset($cruise_obj['rooms'][$room_id])?$cruise_obj['rooms'][$room_id]:array();
                    $field_include = isset($room_obj['field_include']['und'])?$room_obj['field_include']['und']:array();
                    ?>
                    <div class="room-item <?php echo ($r == 0)?'first':''?> <?php echo ($r == (count($search_param[$tran]['room_selected']) - 1))?'last':''?>">
                        <p class="text16 medium blueDark"><?php echo $room_obj['title']?></p>
                        <div class="formBox__group">
                            <div class="formBox__service">
                                <?php if(!$is_full_day):?>
                                    <p class="d-flex"><?php echo get_icon_by_name('field_square');?><?php echo $room_obj['field_square']['und'][0]['value']?></p>
                                <?php endif;?>
                                <p class="d-flex"><?php echo get_icon_by_name('wifi');?><?php echo t('Free wifi');?></p>
                                <p class="d-flex"><?php echo get_icon_by_name('air_conditional');?><?php echo t('Air Conditioning');?></p>
                                <?php if(!$is_full_day):?>
                                    <p class="d-flex"><?php echo get_icon_by_name('bed_type');?><?php echo $room_obj['field_type_of_bed']['und'][0]['value']?></p>
                                <?php endif;?>
                                <p class="d-flex"><?php echo get_icon_by_name('no_smoking');?><?php echo t('No smoking');?></p>
                            </div>

                            <div class="formBox__free">
                                <?php for($inc = 0; $inc < count($field_include); $inc++):?>
                                    <p class="d-flex"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="9" viewBox="0 0 12 9" fill="none">
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M11.8047 0.528636C12.0651 0.788986 12.0651 1.2111 11.8047 1.47145L4.4714 8.80478C4.21106 9.06513 3.78894 9.06513 3.5286 8.80478L0.195262 5.47145C-0.0650874 5.2111 -0.0650874 4.78899 0.195262 4.52864C0.455612 4.26829 0.877722 4.26829 1.13807 4.52864L4 7.39057L10.8619 0.528636C11.1223 0.268287 11.5444 0.268287 11.8047 0.528636Z" fill="#00AA74"/>
                                        </svg><?php echo $field_include[$inc]['value']?></p>
                                <?php endfor;?>

                            </div>
                        </div>

                    </div>
                <?php endfor;?>
            </div>
        </div>




        <?php
        echo blk_passenger('adult',$tran);
        if($num_child > 0) {
            echo blk_passenger('child',$tran);
        }
        if($num_infant > 0) {
            echo blk_passenger('infant',$tran);
        }
        $area_code = $data['area_code'] ;

        ?>



        <div class="formBox">
            <div class="formBox__body">
                <div class="formBox__item">
                    <div class="formBox__text">
                        <p class="text20 medium blueDark mt5"><?php echo t('Contact information');?></p>
                    </div>
                    <div class="formBox__row">
                        <div class="form-group w-50">
                            <label class="labelStar"><?php echo t('Country Code');?></label>
                            <select class="form-control" name="area_code">
                                <?php if(count($area_code) > 0): ?>
                                    <?php foreach (array_reverse($area_code) as $code):?>
                                        <option value="<?php echo $code['description']?> (<?php echo $code['name']?>)"><?php echo $code['description']?> (<?php echo $code['name']?>)</option>
                                    <?php endforeach;?>
                                <?php endif;?>

                            </select>
                        </div>
                        <div class="form-group w-50">
                            <label class="labelStar"><?php echo t('Phone Number');?></label>
                            <input type="number" placeholder="Phone Number" name="phone" class="form-control required">
                        </div>
                        <div class="form-group w-50">
                            <label class="labelStar"><?php echo t('Your Email');?></label>
                            <input type="email" placeholder="Your Email" name="email" class="form-control required">
                        </div>
                        <div class="form-group w-50">
                            <label class="labelStar"><?php echo t('Comfirm Email Address');?></label>
                            <input type="email" placeholder="Comfirm Email Address" name="confirm" class="form-control required">
                        </div>
                    </div>
                    <div class="formBox__frequent">
                        <p class="text16 medium blueDark"><?php echo t('Special request');?></p>
                        <div class="frequentBox">
                            <div class="frequentBox__cont">
                                <div class="d-block w-100">
                                    <textarea placeholder="<?php echo t('Your Special Request');?>" name="special_request" class="form-control"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <div class="formBox">
            <div class="formBox__body">
                <div class="formBox__item">
                    <div class="formBox__text extra_service_all" style="position: relative">
                        <p class="text20 medium blueDark mt5"><?php echo t('Extra service');?></p>
                        <div class="checkbox" style="position: absolute;right: 0;top: 0px;" >
                            <input name="extra_service_all" id="ck_extra_service_all" class="extra_service_all" type="checkbox" >
                            <label for="ck_extra_service_all" >&nbsp;</label>
                        </div>
                    </div>
                    <div id="extra_service_all" class="d-none">
                    <div  id="extra_bed" class="text16 medium blueDark mb15 mt15">
                    <p class="blueDark text16 mb15"><?php echo t('Extra bed');?></p>

                    <?php if(count($room_type_number) > 0):?>
                        <?php $r = 1; foreach ($room_type_number as $room_id => $num):

                            $fee = isset($cruise_obj['rooms'][$room_id]['field_extra_bed']['und'][0]['value'])?$cruise_obj['rooms'][$room_id]['field_extra_bed']['und'][0]['value']:0;
                            ?>
                            <?php if($fee > 0):?>
                            <div class="checkbox">
                                <input id="<?php echo $room_id?>" name="bed_extra[]" class="bus_transfer" type="checkbox" value="<?php echo $fee?>">
                                <label for="<?php echo $room_id?>"><?php echo t('Room')?><?php echo $r?>:  <?php echo $cruise_obj['rooms'][$room_id]['title'];?> - <?php echo show_price($fee)?></label>
                            </div>
                            <?php $r++; endif;?>

                        <?php endforeach;?>
                    <?php endif;?>
                    </div>

                    <p class="blueDark text16 mb15 medium question bus_transfer_service" data-toggle="modal" data-target="#popup_bus_transfer_service">
                        <?php echo t("Bus transfer service");?>
                        <?php echo question_icon();?>
                    </p>
                    <div class="checkbox" style="display: inline">
                        <input id="pp135" name="hanoi_halong" class="bus_transfer" type="checkbox" >
                        <label for="pp135" ><?php echo t('Hanoi to Halong');?></label>
                    </div>
                    <label class="lbl_hanoi_halong"></label>
                    <div style="clear: both"></div>
                    <input type="text" name="hotel_transfer_go" placeholder="<?php echo t('Please provide your hotel name and address in Hanoi');?>" class="form-control mt15 mb15 d-none">
                    <div class="checkbox" style="display: inline">
                        <input id="pp136" type="checkbox" class="bus_transfer" name="halong_hanoi">
                        <label for="pp136"  ><?php echo t('Halong to Hanoi');?></label>
                    </div>
                        <label class="lbl_halong_hanoi"></label>
                        <div style="clear: both"></div>

                        <input type="text" name="hotel_transfer_return" placeholder="<?php echo t('Please provide your hotel name and address in Halong');?>" class="form-control mt15 mb15 d-none">
                    <input type="hidden" name="oneway" value="<?php echo isset($cruise_obj['info']['field_shutter_bus_oneway']['und'][0]['value'])?$cruise_obj['info']['field_shutter_bus_oneway']['und'][0]['value']:0?>" />
                    <input type="hidden" name="roundtrip" value="<?php echo isset($cruise_obj['info']['field_shutter_bus_roundtrip']['und'][0]['value'])?$cruise_obj['info']['field_shutter_bus_roundtrip']['und'][0]['value']:0?>" />
                    </div>

                </div>
            </div>
        </div>
            <input name="tran" type="hidden" value="<?php echo $tran?>" />
        <div class="flightPassenger__btn"><button type="submit" name="review" class="btn btn-orange disabled btn-lg w-100"><?php echo t('Next step: Final Confirmation');?></button></div>
        </form>
    </div>
    <div class="flightPassenger__right">
        <div class="tripSummary">
            <div class="tripSummary__body">
                <div class="tripSummary__text mb15">
                    <span class="text20 blueDark medium"><?php echo t('Price summary');?></span>
                </div>
                <div class="tripSummary__group">
                    <div class="tripSummary__item">
                        <div class="tripSummary__cont">
                            <ul>

                                <?php if(count($room_type_number) > 0):?>
                                    <?php foreach ($room_type_number as $room_id => $num):?>
                                        <li class="medium blueDark"><?php echo $num?> x <?php echo isset($cruise_obj['rooms'][$room_id]['title'])?$cruise_obj['rooms'][$room_id]['title']:'';?></li>
                                    <?php endforeach;?>
                                <?php endif;?>
                                <li class="medium blueDark"><?php echo $itinerary['title']?></li>


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
                            <ul><li><img src="<?php echo $cruise_img?>"></li></ul>
                            <ul>
                                <li>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 12 12" fill="none">
                                        <path d="M3.33302 3.3335C3.33302 4.798 4.53552 6 5.99952 6C7.46452 6 8.66602 4.798 8.66602 3.3335C8.66602 1.868 7.46502 0.666504 5.99952 0.666504C4.53552 0.666504 3.33302 1.868 3.33302 3.3335ZM11.333 11.3335C11.333 9.3615 8.92902 7.3335 5.99952 7.3335C3.07102 7.3335 0.666016 9.3615 0.666016 11.3335V12H11.333V11.3335Z" fill="#5C6AA1"/>
                                    </svg>
                                    <?php if(!$is_full_day):?>
                                    <?php echo count($search_param[$tran]['room_selected'])?> <?php echo $room_label?>,
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
                            <?php $amount = 0;$total_discount = 0; $don_vi_discount = ''; $did = '';$percent_more = '';for($i = 0; $i < count($search_param[$tran]['room_selected']); $i++):
                                $room_id = $search_param[$tran]['room_selected'][$i];
                                $room_obj = $cruise_obj['rooms'][$room_id];
                                $calculator_fare = calculator_fare($room_obj,$i,$search_param[$tran],$discount);//print_r($calculator_fare);
                                $don_vi_discount  = $calculator_fare['don_vi'];
                                $total_of_room = $calculator_fare['total'];//calculator_fare($room_obj,$i,$search_param[$tran],$discount);
                                if($calculator_fare['type'] == 'total') {
                                    if($i == 0) {
                                        $total_discount = $calculator_fare['total_discount'];

                                    }
                                    $did = $calculator_fare['did'];


                                } else {
                                    $did = $calculator_fare['did'];
                                    $total_discount += $calculator_fare['total_discount'];

                                }


                                $amount += $calculator_fare['total'];


                                ?>
                                    <ul>
                                        <li>
                                            <p class="blueDark">
                                                <?php if(!$is_full_day):?>
                                                    <?php echo t('Room').' '. ($i + 1);?>
                                                <?php else:?>
                                                    <?php echo t('Base fare');?>
                                                <?php endif;?>
                                            </p>
                                        </li>
                                        <li><p class="blueDark"><?php echo show_price($total_of_room);?></p></li>
                                    </ul>
                            <?php endfor;?>
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

                            <ul>
                                <li class="blueDark">
                                    <?php
                                    if($num_day > 0) {
                                        $amount = $amount * $num_day;
                                    }
                                    $tax = round($conf['percent_tax']* $amount/100);
                                    ?>
                                    <p><?php echo t('Taxes and fees');?></p>
                                </li>
                                <li class="blueDark" >

                                    <p><?php echo show_price($tax);?></p>
                                </li>
                            </ul>


                            <?php if($total_discount > 0):

                                if($don_vi_discount == 'percent') {
                                    $total_discount = $amount * $total_discount/100;
                                    $total_discount = round($total_discount);
                                    //$percent_more = $total_discount.'%';
                                }
                                ?>
                                <ul>
                                    <li did="<?php echo $did?>">
                                        <p class="blueDark"><?php echo t('Discount');?></p>
                                    </li>
                                    <p> - <?php echo show_price($total_discount);?>
                                        <?php if($percent_more != ''):?>
                                        <div style="text-align: right" class="small"> (<?php echo $percent_more?>)</div>
                                        <?php endif?>
                                    </p>

                                </ul>

                            <?php endif;?>

                        </div>
                    </div>
                    <?php

                    $amount += $tax;
                    $amount -= $total_discount;

                    ?>
                    <input type="hidden" name="total" value="<?php echo $amount?>">
                    <div class="tripSummary__item">
                        <div class="tripSummary__price">
                            <ul>
                                <li>
                                    <p class="blueDark text20 medium"><?php echo t('Total charges');?></p>
                                </li>
                                <li><p class="green400 medium text20"><span id="total_charge" total_charge="<?php echo $amount?>"><?php echo show_price($amount)?></span></p>
                                    <p class="blueDark45"><?php echo t('Includes taxes & fees');?></p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="flexGroup2 mt15">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <path d="M12 0C5.373 0 0 5.373 0 12C0 18.627 5.373 24 12 24C18.627 24 24 18.627 24 12C24 5.373 18.627 0 12 0ZM12 5C14.393 5 16 6.607 16 9H14.75C14.75 7.481 13.519 6.25 12 6.25C10.481 6.25 9.25 7.481 9.25 9H8C8 6.607 9.607 5 12 5ZM17 16.5C17 17.328 16.328 18 15.5 18H8.5C7.672 18 7 17.328 7 16.5V11.5C7 10.672 7.672 10 8.5 10H15.5C16.328 10 17 10.672 17 11.5V16.5Z" fill="#00CA9B"/>
            </svg><span class="blueDark ml15 text12"><?php echo t('We are committed to protecting your information');?></span>
        </div>
    </div>
</div>
<?php endif;?>

<input id="adult_num" type="hidden" value="<?php echo $num_adult?>" />
<input id="child_num" type="hidden" value="<?php echo $num_child?>" />
<input id="infant_num" type="hidden" value="<?php echo $num_infant?>" />

<script>
    function validate_email(email){
        var testEmail = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
        if(testEmail.test(email)){
            return true
        }else {
            return false;
        }
    }
    $('document').ready(function () {

        function show_text_validate_passenger(){
            var list_required = $('.flightPassenger__left .required');
            for(var i = 0; i < list_required.length; i++){
                if($(list_required[i]).is('input')){
                    if($(list_required[i]).val() == null || $(list_required[i]).val() == ''){
                        $(list_required[i]).after('<p class="noti_validate_form" style="color:red;margin-top: 2px;margin-left: 2px;">Please fill out this field.</p>').focus().css({'border' : '1px solid red'});
                        $('#ui-datepicker-div').removeAttr('style');
                    }else {
                        if($(list_required[i]).attr('type') == 'email'){
                            if (!validate_email($(list_required[i]).val())){
                                $(list_required[i]).after('<p class="noti_validate_form" style="color:red;margin-top: 2px;margin-left: 2px;">Please fill in the correct email format.</p>').focus().css({'border' : '1px solid red'});
                            }
                        }
                    }

                } else if($(list_required[i]).is('select')){
                    if($(list_required[i]).find(":selected").val() == null || $(list_required[i]).find(":selected").val() == ''){
                        $(list_required[i]).after('<p class="noti_validate_form" style="color:red;margin-top: 2px;margin-left: 2px;">Please fill out this field.</p>').focus().css({'border' : '1px solid red'});
                    }
                } else {
                    return null;
                }
            }
            $('.input-validation-error').removeClass('input-validation-error');
            setTimeout(function() {
                $('.noti_validate_form').remove();
                $('.flightPassenger__left .required').removeAttr('style');
            }, 2000);
        }

        $('#popup_itinerary').on('shown.bs.modal', function (e) {
            // do something...
            var content = $(e.relatedTarget).parents('.cruiseResult__table__row').find('div.full_itinerary').html();
            console.log(content);
            $('#popup_itinerary .flTable__detail').html(content);

        });

        $('.extra_service_all').click(function () {

            if($('.extra_service_all input[type=checkbox]').is(':checked')) {

               $('#extra_service_all').removeClass('d-none');
            } else {
                $('#extra_service_all').addClass('d-none');

            }

        });
        $('button[name=review]').click(function () {
            show_text_validate_passenger();
            if($(this).hasClass('disabled')) {
                return false;
            }
        });

        $('#frmReview input').keyup(function () {
            check_form();
        });


        if($('#extra_bed input[type=checkbox]').html() != null) {
            $('#extra_bed').removeClass('d-none');
        }
        $('.bus_transfer').click(function () {

            total_fee();
        });
        $('#extra_bed input[type=checkbox]').click(function () {
            total_fee();
        });



        $('.general_date').datepicker(
            {
                changeMonth: true,
                changeYear: true,
            }
        );
        $('.day').change(function () {
            var day = $(this).find('option:selected').val();
            var month =  $(this).parents('.formBox__date').find('select.month option:selected').val();
            month = parseInt(month);
            var year =  $(this).parents('.formBox__date').find('select.year option:selected').val();

            if(day == 31) {

                $(this).parents('.formBox__date').find('select.month option[value=2]').addClass('d-none');
                $(this).parents('.formBox__date').find('select.month option[value=4]').addClass('d-none');
                $(this).parents('.formBox__date').find('select.month option[value=6]').addClass('d-none');
                $(this).parents('.formBox__date').find('select.month option[value=9]').addClass('d-none');
                $(this).parents('.formBox__date').find('select.month option[value=11]').addClass('d-none');
            } else if(day == 30) {
                $(this).parents('.formBox__date').find('select.month option').removeClass('d-none');
                $(this).parents('.formBox__date').find('select.month option[value=2]').addClass('d-none');
            } else  if(day == 29) {
                if(month == 2) {
                    var years = $(this).parents('.formBox__date').find('select.year option');
                    if(years.length > 0) {
                        for(var i = 0; i < years.length; i++) {
                            if($(years[i]).val() % 4 != 0) {
                                $(years[i]).addClass('d-none');
                            }
                        }
                        $(this).parents('.formBox__date').find('select.year').change();
                    }
                }



            } else {
                $(this).parents('.formBox__date').find('select.month option').removeClass('d-none');
                $(this).parents('.formBox__date').find('select.year option').removeClass('d-none');
            }
            get_num_infant_more_24_month();
            //$(this).parents('.formBox__date').find('select.month').change();
        });

        $('.month').change(function () {
            var month = $(this).find('option:selected').val();
            month = parseInt(month);
            console.log(month);
            var year =  $(this).parents('.formBox__date').find('select.year option:selected').val();

            if(month == 2 || month == 4 || month == 6 || month == 9 || month == 11) {
                $(this).parents('.formBox__date').find('select.day option[value=31]').addClass('d-none');
                if( $(this).parents('.formBox__date').find('select.day option:selected').val() == 31) {
                    $(this).parents('.formBox__date').find('select.day option[value=""]').prop('selected',true);
                }
                if(month == 2) {

                    $(this).parents('.formBox__date').find('select.day option[value=30]').addClass('d-none');
                    if( $(this).parents('.formBox__date').find('select.day option:selected').val() == 30) {
                        $(this).parents('.formBox__date').find('select.day option[value=""]').prop('selected',true);
                    }
                    if(year % 4 != 0) {
                        $(this).parents('.formBox__date').find('select.day option[value=29]').addClass('d-none');
                        if( $(this).parents('.formBox__date').find('select.day option:selected').val() == 29) {
                            $(this).parents('.formBox__date').find('select.day option[value=""]').prop('selected',true);
                        }
                    }
                    

                }


            } else  {
                $(this).parents('.formBox__date').find('select.day option').removeClass('d-none');

            }
            get_num_infant_more_24_month();
            $(this).parents('.formBox__date').find('select.day').change();
        });

        $('.year').change(function () {
            var year = $(this).find('option:selected').val();

            var month =  $(this).parents('.formBox__date').find('select.month option:selected').val();
            month = parseInt(month);
            var day =  $(this).parents('.formBox__date').find('select.day option:selected').val();
            $(this).parents('.formBox__date').find('select.day option').removeClass('d-none');
            if(year % 4 != 0) {
                if(month == 2) {
                    $(this).parents('.formBox__date').find('select.day option[value=29]').addClass('d-none');
                    $(this).parents('.formBox__date').find('select.day option[value=30]').addClass('d-none');
                    $(this).parents('.formBox__date').find('select.day option[value=31]').addClass('d-none');
                }


            } else {
                if(month == 2) {
                    $(this).parents('.formBox__date').find('select.day option[value=29]').removeClass('d-none');
                }

            }
            get_num_infant_more_24_month();
        });

        $('.general_date').datepicker();
        

    });

    function get_num_infant_more_24_month() {
        var days = $('.formBox.infant select.day');
        var months = $('.formBox.infant select.month');console.log(months);
        var years = $('.formBox.infant select.year');
        var depart = "<?php echo $depart?>";
        var total = 0;
        console.log(days);
        if(days.length > 0 && months.length > 0 && years.length > 0) {

            for(var i = 0; i < days.length; i++) {
                var d = $(days[i]).find('option:selected').val();
                var m = $(months[i]).find('option:selected').val();
                var y = $(years[i]).find('option:selected').val();
                if(d != '' && d != undefined && m  != '' && m  != undefined && y != '' && y != undefined) {
                    var date = y + '-' + m + '-' + d;

                    date = new Date(date);
                    depart =  new Date(depart * 1000);
                    console.log('ngay sinh em be');
                    console.log(date);
                    console.log(depart);
                    var num_months =  monthDiff(date,depart);
                    if(num_months > 24) {
                        total++;
                    }

                }

            }
        }
        $('#shutter_bus').attr('infant_more_24_month',total);
        total_fee();

    }

    function monthDiff(d1, d2) {
        var months;
        months = (d2.getFullYear() - d1.getFullYear()) * 12;
        months -= d1.getMonth();
        months += d2.getMonth();
        return months <= 0 ? 0 : months;
    }

    function  check_form() {
        var inp =  $('#frmReview .required');
        var is_ok = true;
        if(inp.length > 0) {
            for(var i = 0; i < inp.length; i++) {
                if($(inp[i]).is('select')) {
                    if($(inp[i]).find(":selected").val() == '') {
                        console.log('aa' + $(inp[i]).attr('name'));
                        is_ok = false;
                        break;
                    }
                }else if($(inp[i]).is('input')){
                    if($(inp[i]).val() == '') {
                        console.log('bbb' + $(inp[i]).attr('name'));
                        is_ok = false;
                        break;
                    }

                }

            }
        }
        if($('input[name=email]').val() != $('input[name=confirm]').val() ) {
            is_ok = false;
        }else {
            if(!validate_email($('input[name=email]').val())){
                is_ok= false;
            }
        }
        if(is_ok) {
            $('#frmReview button[name=review]').removeClass('disabled');
        } else {
            $('#frmReview button[name=review]').addClass('disabled');
        }
    }

    function total_fee() {
        var oneway = $('input[name=oneway]').val();
        var roundtrip = $('input[name=roundtrip]').val();
        var total = 0;

        var adult_num = $('#adult_num').val();
        var child_num = $('#child_num').val();
        var infant_num = $('#child_num').val();

        var total_charge = $('#total_charge').attr('total_charge');
        $('input[name=hotel_transfer_return]').addClass('d-none');
        $('input[name=hotel_transfer_go]').addClass('d-none');
        $('input[name=hotel_transfer_go]').removeAttr('required');
        $('input[name=hotel_transfer_return]').removeAttr('required');
        $('.extra_bed_fee_blk').addClass('d-none');
        $('.shutter_bus_blk').addClass('d-none');

        $('.lbl_halong_hanoi').removeClass('labelStar');
        $('.lbl_hanoi_halong').removeClass('labelStar');
        if($('input[name=hanoi_halong]').is(':checked') && $('input[name=halong_hanoi]').is(':checked')) {
            total = roundtrip;
            $('input[name=hotel_transfer_go]').removeClass('d-none');
            $('input[name=hotel_transfer_go]').attr('required','required');
            $('input[name=hotel_transfer_return]').removeClass('d-none');
            $('input[name=hotel_transfer_return]').attr('required','required');
            $('.shutter_bus_blk').removeClass('d-none');
            $('.lbl_hanoi_halong').addClass('labelStar');
            $('.lbl_halong_hanoi').addClass('labelStar');
        } else if($('input[name=hanoi_halong]').is(':checked') && $('input[name=halong_hanoi]').is(':checked') == false) {
            total = oneway;
            $('input[name=hotel_transfer_go]').removeClass('d-none');
            $('input[name=hotel_transfer_return]').addClass('d-none');
            $('.shutter_bus_blk').removeClass('d-none');
            $('input[name=hotel_transfer_go]').attr('required','required');
            $('.lbl_hanoi_halong').addClass('labelStar');
        } else if($('input[name=hanoi_halong]').is(':checked') == false && $('input[name=halong_hanoi]').is(':checked')) {
            total = oneway;
            $('input[name=hotel_transfer_return]').removeClass('d-none');
            $('input[name=hotel_transfer_go]').addClass('d-none');
            $('.shutter_bus_blk').removeClass('d-none');
            $('input[name=hotel_transfer_return]').attr('required','required');
            $('.lbl_halong_hanoi').addClass('labelStar');
        }

        var total_passenger_bus_feee = parseInt(adult_num) + parseInt(child_num);
        var infant_more_24_month =  infant_num;
        if($('#shutter_bus').attr('infant_more_24_month') != undefined && $('#shutter_bus').attr('infant_more_24_month') != '' ) {
            infant_more_24_month = $('#shutter_bus').attr('infant_more_24_month');
        }
        total_passenger_bus_feee += parseInt(infant_more_24_month);
        console.log(total_passenger_bus_feee);
        console.log(total);
        total = total * total_passenger_bus_feee;
        var lang = $('input[name=currency]').val();
        if(lang == 'vi') {
            $('#shutter_bus').text(total.toString().replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",") + ' VNĐ');
        } else {
            $('#shutter_bus').text('USD ' + total.toString().replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ","));
        }

        $('#shutter_bus').attr('total',total);
        var num_day = '<?php echo $num_day?>';
        //extra bed
        var extra_bed = $('#extra_bed input[type=checkbox]');
        var extra_bed_total = 0;
        if(extra_bed.length > 0) {
            for(var i = 0; i < extra_bed.length; i++) {
                if($(extra_bed[i]).is(':checked')) {
                    extra_bed_total += parseInt($(extra_bed[i]).val());
                }
            }
            extra_bed_total = parseInt(num_day) * extra_bed_total;
            if(lang == 'vi') {
                $('#extra_bed_fee').text(extra_bed_total.toString().replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",") + ' VNĐ');
            } else {
                $('#extra_bed_fee').text('USD ' + extra_bed_total.toString().replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ","));
            }
            if(extra_bed_total > 0) {
                $('.extra_bed_fee_blk').removeClass('d-none');
            }


        }



        total_charge = parseInt(total_charge) + parseInt(total) + parseInt(extra_bed_total);
        if(lang == 'vi') {
            $('#total_charge').text(total_charge.toString().replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",") + ' VNĐ');
        } else {
            $('#total_charge').text('USD ' + total_charge.toString().replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ","));
        }

    }

</script>

<input type="hidden" name="currency" value="<?php echo $lang?>">

<?php
if($lang == 'vi') {
    $bus_transfer_service = 3416;
} else {
    $bus_transfer_service = 3415;
}
$bus_transfer_service_node = _get_node($bus_transfer_service);//print_r($bus_transfer_service_node);
?>

<div id="popup_bus_transfer_service" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" data-dismiss="modal" class="close">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="svg1point5">
                        <path d="M14.3001 12.1788C14.2768 12.1556 14.2584 12.128 14.2458 12.0976C14.2332 12.0672 14.2267 12.0347 14.2267 12.0018C14.2267 11.9689 14.2332 11.9364 14.2458 11.906C14.2584 11.8756 14.2768 11.848 14.3001 11.8248L23.5631 2.5628C23.8444 2.28114 24.0022 1.89928 24.002 1.50124C24.0017 1.10319 23.8433 0.721561 23.5616 0.440299C23.28 0.159037 22.8981 0.00118392 22.5001 0.00146522C22.102 0.00174652 21.7204 0.160139 21.4391 0.441799L12.1771 9.6998C12.1539 9.72308 12.1263 9.74155 12.0959 9.75416C12.0656 9.76676 12.033 9.77325 12.0001 9.77325C11.9672 9.77325 11.9347 9.76676 11.9043 9.75416C11.8739 9.74155 11.8463 9.72308 11.8231 9.6998L2.56113 0.441799C2.42186 0.302467 2.25651 0.191929 2.07453 0.116498C1.89254 0.0410666 1.69748 0.00221873 1.50048 0.0021723C1.10262 0.00207854 0.721022 0.160037 0.439627 0.441299C0.158232 0.722561 9.38099e-05 1.10409 4.17235e-08 1.50195C-9.37265e-05 1.8998 0.157865 2.2814 0.439127 2.5628L9.70013 11.8248C9.72341 11.848 9.74188 11.8756 9.75448 11.906C9.76709 11.9364 9.77357 11.9689 9.77357 12.0018C9.77357 12.0347 9.76709 12.0672 9.75448 12.0976C9.74188 12.128 9.72341 12.1556 9.70013 12.1788L0.439127 21.4418C0.29986 21.5811 0.189401 21.7465 0.114055 21.9286C0.0387096 22.1106 -4.63876e-05 22.3057 4.17235e-08 22.5027C9.38099e-05 22.9005 0.158232 23.282 0.439627 23.5633C0.57896 23.7026 0.744358 23.813 0.92638 23.8884C1.1084 23.9637 1.30348 24.0025 1.50048 24.0024C1.89834 24.0023 2.27987 23.8442 2.56113 23.5628L11.8231 14.2998C11.8463 14.2765 11.8739 14.258 11.9043 14.2454C11.9347 14.2328 11.9672 14.2264 12.0001 14.2264C12.033 14.2264 12.0656 14.2328 12.0959 14.2454C12.1263 14.258 12.1539 14.2765 12.1771 14.2998L21.4391 23.5628C21.7204 23.8442 22.1019 24.0023 22.4998 24.0024C22.8976 24.0025 23.2792 23.8446 23.5606 23.5633C23.842 23.282 24.0002 22.9005 24.0003 22.5027C24.0003 22.1048 23.8424 21.7232 23.5611 21.4418L14.3001 12.1788Z" fill="black" fill-opacity="0.25"></path>
                    </svg>
                </button>
                <h2><?php echo $bus_transfer_service_node['title'];?></h2>
                <div class="flTable__detail" style="margin-top: 10px">
                    <p><?php echo $bus_transfer_service_node['body']['und'][0]['value'];?></p>
                </div>
            </div>
        </div>
    </div>
</div>

<input type="hidden" name="discount" value="<?php echo htmlentities(json_encode($discount))?>" />