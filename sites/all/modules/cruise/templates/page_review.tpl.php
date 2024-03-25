<?php
global $conf,$language;

$node_term = 1428;//2872
$lang = isset($_SESSION['lang'])?$_SESSION['lang']:'en';
if($lang == 'en') {
    $node_term = 1428;
} else {
    $node_term = 2872;
}
$theme = '/sites/all/themes/newtheme/';
$data_review = array();
$tran = isset($_REQUEST['t'])?$_REQUEST['t']:'';
if(isset($data['review']['data'])) {
    $data_review = json_decode($data['review']['data'],true);
}
if($tran == '') {
    $tran = array_keys($data_review)[0];

}
//print_r($data_review);die;

$data_review = $data_review[$tran];

if(isset($data_review['lang']) && $data_review['lang'] != '') {
    $lang = $data_review['lang'];

    $languages = language_list();
    $languages_key = array_keys($languages);
    if(in_array($lang,$languages_key)) {
        $_SESSION['lang'] = $lang;
        $language = $languages[$lang];
    }
}
$cruise_id = isset($data_review['cruise'])?$data_review['cruise']:0;
$itinerary_id = isset($data_review['arg2'])?$data_review['arg2']:0;
$cruise_obj =  detail_cruise($cruise_id);
$itinerary_title = isset($cruise_obj['itinerary'][$itinerary_id]['title'])?$cruise_obj['itinerary'][$itinerary_id]['title']:'';
$rooms = isset($cruise_obj['rooms'])?$cruise_obj['rooms']:array();

$cruise_img = isset($cruise_obj['info']['field_cruise_image']['und'][0]['uri'])?$cruise_obj['info']['field_cruise_image']['und'][0]['uri']:'';
$cruise_img = file_create_url($cruise_img);
$cruise_img = convert_img_url($cruise_img);

$room_seleted = isset($data_review['room_selected'])?$data_review['room_selected']:array();
$room_type_number = array_count_values($room_seleted);

$num_adult = 0;
$num_child = 0;
$num_infant = 0;



for($r = 0; $r < $data_review['no_room']; $r++) {
    $num_adult += $data_review['adult'][$r];


}

for($r = 0; $r < $data_review['no_room']; $r++) {

    $num_child += $data_review['child'][$r];


}

for($r = 0; $r < $data_review['no_room']; $r++) {

    $num_infant += $data_review['infant'][$r];

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

$num_day = substr($data_review['duration'],0,1);
$num_day = filter_var($num_day,FILTER_SANITIZE_NUMBER_INT) - 1;

$depart = strtotime($data_review['depart']);
$return = date('Y-m-d', strtotime($data_review['depart'] . ' +'.$num_day.' days'));
$return = strtotime($return);
//$tran = $data_review['trans'];
$bus_fee = 0;
if(isset($data_review['passenger']['hanoi_halong']) || isset($data_review['passenger']['halong_hanoi'])) {
    if($data_review['passenger']['hanoi_halong'] == 'on' && $data_review['passenger']['halong_hanoi'] == 'on') {
        $bus_fee = $data_review['passenger']['roundtrip'];
    } else if($data_review['passenger']['hanoi_halong'] == 'on' && $data_review['passenger']['halong_hanoi'] != 'on') {
        $bus_fee = $data_review['passenger']['oneway'];
    } else if($data_review['passenger']['hanoi_halong'] != 'on' && $data_review['passenger']['halong_hanoi'] == 'on') {
        $bus_fee = $data_review['passenger']['oneway'];
    }
}
//echo $bus_fee;die;

if(isset($data_review['passenger']['bed_extra']) && count($data_review['passenger']['bed_extra']) > 0) {
    for($i = 0; $i < count($data_review['passenger']['bed_extra']); $i++) {
        $bed_extra +=  $data_review['passenger']['bed_extra'][$i];
    }
}

$is_full_day = false;
if($data_review['duration'] == 'full_day') {
    $is_full_day = true;
    $num_day = 1;
    $return = $depart;
}

//khach tinh tien xe buyet > 24 thang
$total_passenger_bus_feee = $num_adult + $num_child;
if($num_infant > 0) {
    $total_passenger_bus_feee += get_total_passenger_bus_fee($data_review['passenger'],$data_review['depart']);

}


if(isset($data_review['passenger'])) {
    $search_param = $data_review;
    unset($search_param['passenger']);
}
//print_r($_SESSION['search_param']);die;
$is_continue = true;
//print_r($search_param);die;
$discount_obj = get_discount_for_booking($data_review['cruise'],$data_review['duration'],$search_param);


?>

<?php if($cruise_obj):?>
<div class="text24 blueDark medium mb15"><span><?php echo t('Review your booking');?></span></div>
<div class="flightReview__main">
    <div class="orderCode">
        <div class="orderCode__label"><?php echo t('Order code');?>: <?php echo $data['code']?></div>
        <p class="blueDark"><?php echo t('The order number is for your reference only, NOT for check-in and boarding!');?></p>
    </div>
    <div class="formBox">
        <div class="formBox__body">
            <div class="formBox__review__item">
                <div class="formBox__image">
                    <img src="<?php echo $cruise_img?>">
                </div>
                <div class="formBox__cont">
                    <div class="formBox__title">
                        <span class="text20 blueDark medium"><?php echo $cruise_obj['info']['title']?> <?php echo $itinerary_title?></span>
                        <?php
                        echo get_star_html($cruise_obj['info']['field_star']['und'][0]['value']);
                        ?>
                    </div>
                    <p class="blueDark45 text12 flexGroup mt5"><svg class="mr10" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                            <g clip-path="url(#clip0_2758_26057)">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M2 5.6C2 2.504 4.504 0 7.6 0C10.696 0 13.2 2.504 13.2 5.6C13.2 9.8 7.6 16 7.6 16C7.6 16 2 9.8 2 5.6ZM7.6002 9.59999C9.80933 9.59999 11.6002 7.80913 11.6002 5.59999C11.6002 3.39085 9.80933 1.59999 7.6002 1.59999C5.39106 1.59999 3.6002 3.39085 3.6002 5.59999C3.6002 7.80913 5.39106 9.59999 7.6002 9.59999Z" fill="#5C6AA1"/>
                                <path d="M10.5496 6.25926L10.2796 7.96295L9.73206 7.47078C9.35245 7.75996 9.01181 8.49668 7.5335 8.5312C6.35769 8.5312 5.86764 7.86223 5.43532 7.5388L4.93516 7.98737L4.65088 6.29928L6.52955 6.55549L6.01171 7.0204C6.01171 7.0204 6.4558 7.70441 7.22285 7.75218L7.21978 4.972C6.80542 4.83857 6.50682 4.48527 6.50682 4.06707C6.50682 3.53387 6.98735 3.10193 7.58088 3.10193C8.17383 3.10193 8.65519 3.5339 8.65519 4.06707C8.65519 4.49175 8.3468 4.84895 7.92347 4.97691C7.9257 5.51997 7.93552 7.76257 7.92235 7.76257C8.55734 7.7462 9.15199 6.95031 9.15199 6.95031L8.66724 6.51497L10.5496 6.25926ZM8.13544 4.05197C8.13544 3.77759 7.88677 3.55486 7.5809 3.55486C7.27559 3.55486 7.02775 3.77759 7.02775 4.05197C7.02775 4.32689 7.27559 4.55013 7.5809 4.55013C7.88705 4.54986 8.13544 4.32686 8.13544 4.05197Z" fill="#5C6AA1"/>
                            </g>
                            <defs>
                                <clipPath id="clip0_2758_26057">
                                    <rect width="16" height="16" fill="white"/>
                                </clipPath>
                            </defs>
                        </svg><?php echo t($cruise_obj['info']['field_itinerary']['und'][0]['value']);?></p>
                    <div class="formBox__type">
                        <ul>
                            <li class="flexGroup1 mb5" style="align-items: start">
                                <p class="blueDark45"><?php echo t('Type of room');?>:</p>
                                <p class="blueDark" style="text-align: end;position: relative">
                                    <?php if(count($room_type_number) > 0):?>
                                        <?php $i = 0; foreach($room_type_number as $room_id => $num):?>
                                            <?php echo $num ?>x <?php echo isset($rooms[$room_id]['title'])?$rooms[$room_id]['title']:''?>
                                            <br/>

                                            <?php for ($j = 0; $j < count($room_seleted); $j++):?>
                                                <?php if($room_seleted[$j] == $room_id):?>
                                                    <span class="small">
                                                    <?php echo $data_review['adult'][$j];?>
                                                        <?php
                                                        if($data_review['adult'][$j] > 1) {
                                                            echo t('adults');
                                                        } else {
                                                            echo t('adult');
                                                        }
                                                        ?>
                                                        <?php if ($data_review['child'][$j] > 0):?>
                                                            , <?php echo $data_review['child'][$j];?>
                                                            <?php
                                                            if($data_review['child'][$j] > 1) {
                                                                echo t('children');
                                                            } else {
                                                                echo t('child');
                                                            }
                                                            ?>
                                                        <?php endif;?>
                                                        <?php if ($data_review['infant'][$j] > 0):?>
                                                            , <?php echo $data_review['infant'][$j] ?>
                                                            <?php
                                                            if($data_review['infant'][$j] > 1) {
                                                                echo t('infants');
                                                            } else {
                                                                echo t('infant');
                                                            }
                                                            ?>
                                                        <?php endif;?>
                                                </span>

                                                <?php if($j < count($room_seleted) - 2):?>
                                                    /
                                                <?php endif;?>
                                                <?php endif;?>
                                            <?php endfor;?>
                                            <br/>


                                            <?php $i++;endforeach;?>
                                    <?php endif;?>

                                </p>

                            </li>
                            <li class="flexGroup1 mb5">
                                <p class="blueDark45"><?php echo t('Duration');?>:</p>
                                <p class="blueDark"><?php echo $itinerary_title?></p>
                            </li>
                            <li class="flexGroup1 mb5">
                                <p class="blueDark45"><?php echo t('Passengers');?>:</p>
                                <p class="blueDark">

                                    <?php echo $num_adult .' '.$adult_label;?>
                                    <?php if($num_child > 0):?>
                                        , <?php echo $num_child .' '.$child_label;?>
                                    <?php endif;?>
                                    <?php if($num_infant > 0):?>
                                        , <?php echo $num_infant .' '.$infant_label;?>
                                    <?php endif;?>
                                </p>
                            </li>
                            <li class="flexGroup1 mb5">
                                <p class="blueDark45"><?php echo t('Check-in');?>:</p>
                                <p class="blueDark"><?php echo date('d/m/Y',$depart)?></p>
                            </li>
                            <li class="flexGroup1 mb5">
                                <p class="blueDark45"><?php echo t('Check-out');?>:</p>
                                <p class="blueDark"><?php echo date('d/m/Y',$return)?></p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="formBox">
        <div class="formBox__body">
            <div class="formBox__price">
                <div class="review__title ml10"><p class="text16 medium blueDark"><?php echo t('Price');?></p></div>
                <div class="formBox__flex">
                    <div class="formBox__right"  >
                        <ul>
                            <?php $amount = 0; $total_discount = 0;  $don_vi_discount = ''; for($i = 0; $i < count($room_seleted); $i++):
                                $room_id = $room_seleted[$i];
                                $room_obj = $cruise_obj['rooms'][$room_id];
                                $calculator_fare = calculator_fare($room_obj,$i,$search_param,$discount_obj);
                                $total_of_room = $calculator_fare['total'];// + $calculator_fare['total_discount'];
                                if($total_of_room == 0) {
                                    $is_continue = false;
                                    break;
                                }

                                $don_vi_discount  = $calculator_fare['don_vi'];
                                if($calculator_fare['type'] == 'total') {
                                    if($i == 0) {
                                        $total_discount = $calculator_fare['total_discount'];

                                    }


                                } else {
                                    $total_discount += $calculator_fare['total_discount'];

                                }
                                $amount += $calculator_fare['total'];

                                //echo 'total of room:'.$total_of_room.'<br/>';
                                if($is_full_day) {
                                    $fare_adult = $room_obj['field_price_for_adult']['und'][0]['value'];
                                    $percent_of_child = isset($room_obj['field_percent_of_child']['und'][0]['value'])?$room_obj['field_percent_of_child']['und'][0]['value']:75;
                                    $fare_child = $fare_adult*  $percent_of_child /100;
                                    $fare_infant = $fare_adult * $percent_of_child /100;
                                    $amount = $fare_adult * $num_adult + $fare_child*$num_child + $fare_infant * ($num_infant - 1);
                                }


                                ?>

                                <li class="flexGroup1 blueDark">
                                    <p style="display: grid">
                                        <?php if(!$is_full_day):?>
                                            <?php echo t('Room').' '. ($i + 1);?>
                                        <?php else:?>
                                            <?php echo t('Adult');?>
                                        <?php endif;?>

                                    </p>
                                    <?php if($is_full_day):

                                        ?>
                                        <p><?php echo show_price($fare_adult);?> x <?php echo $num_adult?></p>
                                    <?php else:?>
                                    <p><?php echo show_price($total_of_room);?></p>
                                    <?php endif;?>
                                </li>

                                <?php if($is_full_day && $num_child > 0):?>
                                    <li class="flexGroup1 blueDark" style="position: relative">
                                        <p style="display: grid">
                                            <?php echo t('Child');?>
                                            <div class="percent_of_child question">
                                                <?php echo question_icon();?>
                                                <div class="percent_of_child_text"><?php echo t('From 5 to 10 years old: 75% of the price of an adult');?></div>
                                            </div>
                                        </p>
                                        <p>
                                            <?php  echo show_price($fare_child)?> x <?php echo $num_child?>


                                        </p>
                                    </li>
                                <?php endif;?>
                                <?php if($is_full_day && $num_infant > 1):?>
                                <li class="flexGroup1 blueDark"  style="position: relative">
                                    <p style="display: grid">
                                        <?php echo t('Infant');?>
                                        <div class="percent_of_infant question">
                                                <?php echo question_icon();?>
                                                <div class="percent_of_infant_text" ><?php echo t('Under 5 years old: Free for the first kid, the second one will be charged at 75%');?></div>
                                            </div>
                                    </p>
                                    <p><?php  echo show_price($fare_infant)?> x <?php echo ($num_infant - 1);?></p>
                                </li>
                            <?php endif;?>
                            <?php endfor;?>

                            <?php
                            //echo 'percent_tax:'.$conf['percent_tax'].',amount:'.$amount;
                            $tax = round($conf['percent_tax']* $amount*$num_day/100,1);

                            if($total_discount > 0) {
                                if($don_vi_discount == 'percent') {
                                    $total_discount = $amount * $total_discount/100;
                                    $total_discount = round($total_discount);
                                }
                            }


                          //  echo 'amount:'.$amount.', num day:'.$num_day.', tax:'.$tax.', bus:'.$bus_fee.', total passenger:'.$total_passenger_bus_feee.', bed extra:'.$bed_extra.', discount:'.$total_discount;
                            $total_charges = $amount * $num_day + $tax + $bus_fee*$total_passenger_bus_feee + $bed_extra - $total_discount;

                            ?>

                                <?php if(!$is_full_day):?>
                                    <li class="flexGroup1 blueDark">
                                        <p><?php echo t('Number of nights');?></p>
                                        <p>x<?php echo $num_day?></p>
                                    </li>
                                <?php endif;?>
                                <?php if($bus_fee > 0):?>
                                    <li class="flexGroup1 blueDark">
                                        <p><?php echo t('Shuttle bus fee');?></p>
                                        <p><?php echo show_price($bus_fee)?> x <?php echo $total_passenger_bus_feee?></p>
                                    </li>
                                <?php endif;?>
                                <?php if($bed_extra > 0):?>
                                    <li class="flexGroup1 blueDark">
                                        <p><?php echo t('Extra bed fee');?></p>
                                        <p><?php echo show_price($bed_extra)?></p>
                                    </li>
                                <?php endif;?>
                                <li class="flexGroup1 blueDark" tax="<?php echo $conf['percent_tax']?>">
                                    <p><?php echo t('Taxes and fees');?></p>
                                    <p><?php echo show_price($tax);?></p>
                                </li>
                                <?php if($total_discount > 0):?>
                                <li class="flexGroup1 blueDark">
                                    <p ><?php echo t('Discount');?></p>
                                    <p > - <?php echo show_price($total_discount)?></p>
                                </li>
                                <?php endif;?>
                                <li class="flexGroup1 mt10 total__charges" abcd="<?php var_dump($total_charges);?>">
                                    <p class="medium text16 blueDark mt5"><?php echo t('Total charges');?></p>
                                    <p class="medium green400 text16 text-right ml10 mt5 flex1"><?php echo show_price($total_charges)?><span class="d-block blueDark45 text12 regular"><?php echo t('Includes taxes & fees');?></span></p>
                                </li>

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="formBox">
        <div class="formBox__body">
            <div class="review__title ml10"><p class="text16 medium blueDark"><?php echo t('Passenger details');?></p></div>
            <div class="formBox__contact ml10">
                <div class="travelerTable__header showDesktop">

                    <div class="travelerTable__cell">
                        <p class="blueDark medium"><?php echo t('Full Name');?></p>
                    </div>
                    <div class="travelerTable__cell">
                        <p class="blueDark medium"><?php echo t('Date of Birth');?></p>
                    </div>
                    <div class="travelerTable__cell">
                        <p class="blueDark medium"><?php echo t('Passport');?></p>
                    </div>
                    <div class="travelerTable__cell">
                        <p class="blueDark medium"><?php echo t('Nationality');?></p>
                    </div>
                    <div class="travelerTable__cell">
                        <p class="blueDark medium"><?php echo t('Date of Issued');?></p>
                    </div>
                    <div class="travelerTable__cell">
                        <p class="blueDark medium"><?php echo t('Date of Expired');?></p>
                    </div>

                </div>
                <div class="travelerTable__body showDesktop">
                    <?php for($i = 0; $i < $num_adult; $i++):?>
                    <div class="travelerTable__row">
                        <div class="travelerTable__cell">
                            <p class="tex14 blueDark">
                                <?php echo $data_review['passenger']['title']['adult'][$i];?>
                                <?php echo $data_review['passenger']['fullname']['adult'][$i];?>
                            </p>
                        </div>
                        <div class="travelerTable__cell">
                            <p class="tex14 blueDark">
                                <?php echo $data_review['passenger']['day']['adult'][$i];?>/<?php echo $data_review['passenger']['month']['adult'][$i];?>/<?php echo $data_review['passenger']['year']['adult'][$i];?>
                            </p>
                        </div>
                        <div class="travelerTable__cell">
                            <p class="tex14 blueDark"><?php echo $data_review['passenger']['passport']['adult'][$i];?></p>
                        </div>
                        <div class="travelerTable__cell">
                            <p class="tex14 blueDark"><p class="tex14 blueDark"><?php echo $data_review['passenger']['nationality']['adult'][$i];?></p></p>
                        </div>
                        <div class="travelerTable__cell">
                            <p class="tex14 blueDark"><p class="tex14 blueDark"><p class="tex14 blueDark"><?php echo $data_review['passenger']['date_issued']['adult'][$i];?></p></p></p>
                        </div>
                        <div class="travelerTable__cell">
                            <p class="tex14 blueDark"><p class="tex14 blueDark"><p class="tex14 blueDark"><?php echo $data_review['passenger']['date_expired']['adult'][$i];?></p></p></p>
                        </div>

                    </div>
                    <?php endfor;?>
                    <?php if($num_child > 0):?>
                        <?php for($i = 0; $i < $num_child; $i++):?>
                            <div class="travelerTable__row">
                                <div class="travelerTable__cell">
                                    <p class="tex14 blueDark">
                                        <?php echo $data_review['passenger']['title']['child'][$i];?>
                                        <?php echo $data_review['passenger']['fullname']['child'][$i];?>
                                    </p>
                                </div>
                                <div class="travelerTable__cell">
                                    <p class="tex14 blueDark">
                                        <?php echo $data_review['passenger']['day']['child'][$i];?>/<?php echo $data_review['passenger']['month']['child'][$i];?>/<?php echo $data_review['passenger']['year']['child'][$i];?>
                                    </p>
                                </div>
                                <div class="travelerTable__cell">
                                    <p class="tex14 blueDark"><?php echo $data_review['passenger']['passport']['child'][$i];?></p>
                                </div>
                                <div class="travelerTable__cell">
                                    <p class="tex14 blueDark"><p class="tex14 blueDark"><?php echo $data_review['passenger']['nationality']['child'][$i];?></p></p>
                                </div>
                                <div class="travelerTable__cell">
                                    <p class="tex14 blueDark"><p class="tex14 blueDark"><p class="tex14 blueDark"><?php echo $data_review['passenger']['date_issued']['child'][$i];?></p></p></p>
                                </div>
                                <div class="travelerTable__cell">
                                    <p class="tex14 blueDark"><p class="tex14 blueDark"><p class="tex14 blueDark"><?php echo $data_review['passenger']['date_expired']['child'][$i];?></p></p></p>
                                </div>

                            </div>
                        <?php endfor;?>
                    <?php endif;?>

                    <?php if($num_infant > 0):?>
                        <?php for($i = 0; $i < $num_infant; $i++):?>
                            <div class="travelerTable__row">
                                <div class="travelerTable__cell">
                                    <p class="tex14 blueDark">
                                        <?php echo $data_review['passenger']['title']['infant'][$i];?>
                                        <?php echo $data_review['passenger']['fullname']['infant'][$i];?>
                                    </p>
                                </div>
                                <div class="travelerTable__cell">
                                    <p class="tex14 blueDark">
                                        <?php echo $data_review['passenger']['day']['infant'][$i];?>/<?php echo $data_review['passenger']['month']['infant'][$i];?>/<?php echo $data_review['passenger']['year']['infant'][$i];?>
                                    </p>
                                </div>
                                <div class="travelerTable__cell">
                                    <p class="tex14 blueDark"><?php echo $data_review['passenger']['passport']['infant'][$i];?></p>
                                </div>
                                <div class="travelerTable__cell">
                                    <p class="tex14 blueDark"><p class="tex14 blueDark"><?php echo $data_review['passenger']['nationality']['infant'][$i];?></p></p>
                                </div>
                                <div class="travelerTable__cell">
                                    <p class="tex14 blueDark"><p class="tex14 blueDark"><p class="tex14 blueDark"><?php echo $data_review['passenger']['date_issued']['infant'][$i];?></p></p></p>
                                </div>
                                <div class="travelerTable__cell">
                                    <p class="tex14 blueDark"><p class="tex14 blueDark"><p class="tex14 blueDark"><?php echo $data_review['passenger']['date_expired']['infant'][$i];?></p></p></p>
                                </div>

                            </div>
                        <?php endfor;?>
                    <?php endif;?>
                </div>

                <?php for($i = 0; $i < $num_adult; $i++):?>
                    <div class="travelerTable__header showMobile">
                        <div class="travelerTable__title showMobile">
                            <p class="text16 medium colorBluedark900"><?php echo t('Adult');?> <?php echo ($i + 1);?></p>
                        </div>
                        <div class="travelerTable__cell">
                            <p class="blueDark medium"><?php echo t('Full Name');?></p>
                            <p class="tex14 blueDark showMobile">
                                <?php echo $data_review['passenger']['title']['adult'][$i];?>
                                <?php echo $data_review['passenger']['fullname']['adult'][$i];?>
                            </p>
                        </div>
                        <div class="travelerTable__cell">
                            <p class="blueDark medium"><?php echo t('Date of Birth');?></p>
                            <p class="tex14 blueDark showMobile">
                                <?php echo $data_review['passenger']['day']['adult'][$i];?>/<?php echo $data_review['passenger']['month']['adult'][$i];?>/<?php echo $data_review['passenger']['year']['adult'][$i];?>
                            </p>
                        </div>
                        <div class="travelerTable__cell">
                            <p class="blueDark medium"><?php echo t('Passport');?></p>
                            <p class="tex14 blueDark showMobile"><?php echo $data_review['passenger']['passport']['adult'][$i];?></p>
                        </div>
                        <div class="travelerTable__cell">
                            <p class="blueDark medium"><?php echo t('Nationality');?></p>
                            <p class="tex14 blueDark showMobile"><?php echo $data_review['passenger']['nationality']['adult'][$i];?></p>
                        </div>
                        <div class="travelerTable__cell">
                            <p class="blueDark medium"><?php echo t('Date of Issued');?></p>
                            <p class="tex14 blueDark showMobile"><?php echo $data_review['passenger']['date_issued']['adult'][$i];?></p>
                        </div>
                        <div class="travelerTable__cell">
                            <p class="blueDark medium"><?php echo t('Date of Expired');?></p>
                            <p class="tex14 blueDark showMobile"><?php echo $data_review['passenger']['date_expired']['adult'][$i];?></p>
                        </div>

                    </div>
                <?php endfor;?>
                <?php if($num_child > 0):?>
                    <?php for($i = 0; $i < $num_child; $i++):?>
                            <div class="travelerTable__header showMobile">
                                <div class="travelerTable__title showMobile">
                                    <p class="text16 medium colorBluedark900"><?php echo t('Child');?> <?php echo ($i + 1);?></p>
                                </div>
                                <div class="travelerTable__cell">
                                    <p class="blueDark medium"><?php echo t('Full Name');?></p>
                                    <p class="tex14 blueDark showMobile">
                                        <?php echo $data_review['passenger']['title']['child'][$i];?>
                                        <?php echo $data_review['passenger']['fullname']['child'][$i];?>
                                    </p>
                                </div>
                                <div class="travelerTable__cell">
                                    <p class="blueDark medium"><?php echo t('Date of Birth');?></p>
                                    <p class="tex14 blueDark showMobile">
                                        <?php echo $data_review['passenger']['day']['child'][$i];?>/<?php echo $data_review['passenger']['month']['adult'][$i];?>/<?php echo $data_review['passenger']['year']['child'][$i];?>
                                    </p>
                                </div>
                                <div class="travelerTable__cell">
                                    <p class="blueDark medium"><?php echo t('Passport');?></p>
                                    <p class="tex14 blueDark showMobile"><?php echo $data_review['passenger']['passport']['child'][$i];?></p>
                                </div>
                                <div class="travelerTable__cell">
                                    <p class="blueDark medium"><?php echo t('Nationality');?></p>
                                    <p class="tex14 blueDark showMobile"><?php echo $data_review['passenger']['nationality']['child'][$i];?></p>
                                </div>
                                <div class="travelerTable__cell">
                                    <p class="blueDark medium"><?php echo t('Date of Issued');?></p>
                                    <p class="tex14 blueDark showMobile"><?php echo $data_review['passenger']['date_issued']['child'][$i];?></p>
                                </div>
                                <div class="travelerTable__cell">
                                    <p class="blueDark medium"><?php echo t('Date of Expired');?></p>
                                    <p class="tex14 blueDark showMobile"><?php echo $data_review['passenger']['date_expired']['child'][$i];?></p>
                                </div>

                            </div>
                    <?php endfor;?>
                <?php endif;?>

                <?php if($num_infant > 0):?>
                    <?php for($i = 0; $i < $num_child; $i++):?>
                        <div class="travelerTable__header showMobile">
                            <div class="travelerTable__title showMobile">
                                <p class="text16 medium colorBluedark900"><?php echo t('Infant');?> <?php echo ($i + 1);?></p>
                            </div>
                            <div class="travelerTable__cell">
                                <p class="blueDark medium"><?php echo t('Full Name');?></p>
                                <p class="tex14 blueDark showMobile">
                                    <?php echo $data_review['passenger']['title']['infant'][$i];?>
                                    <?php echo $data_review['passenger']['fullname']['infant'][$i];?>
                                </p>
                            </div>
                            <div class="travelerTable__cell">
                                <p class="blueDark medium"><?php echo t('Date of Birth');?></p>
                                <p class="tex14 blueDark showMobile">
                                    <?php echo $data_review['passenger']['day']['infant'][$i];?>/<?php echo $data_review['passenger']['month']['infant'][$i];?>/<?php echo $data_review['passenger']['year']['infant'][$i];?>
                                </p>
                            </div>
                            <div class="travelerTable__cell">
                                <p class="blueDark medium"><?php echo t('Passport');?></p>
                                <p class="tex14 blueDark showMobile"><?php echo $data_review['passenger']['passport']['infant'][$i];?></p>
                            </div>
                            <div class="travelerTable__cell">
                                <p class="blueDark medium"><?php echo t('Nationality');?></p>
                                <p class="tex14 blueDark showMobile"><?php echo $data_review['passenger']['nationality']['infant'][$i];?></p>
                            </div>
                            <div class="travelerTable__cell">
                                <p class="blueDark medium"><?php echo t('Date of Issued');?></p>
                                <p class="tex14 blueDark showMobile"><?php echo $data_review['passenger']['date_issued']['infant'][$i];?></p>
                            </div>
                            <div class="travelerTable__cell">
                                <p class="blueDark medium"><?php echo t('Date of Expired');?></p>
                                <p class="tex14 blueDark showMobile"><?php echo $data_review['passenger']['date_expired']['infant'][$i];?></p>
                            </div>

                        </div>
                    <?php endfor;?>
                <?php endif;?>

            </div>
        </div>
    </div>
    <div class="formBox">
        <div class="formBox__body">
            <div class="review__title ml10"><p class="text16 medium blueDark"><?php echo t('Contact information');?></p></div>
            <div class="formBox__contact ml10">
                <div class="formBox__flex">
                    <div class="formBox__contact__line">
                        <div class="d-block">
                            <div class="flexGroup2">
                                <p class="blueDark medium"><?php echo t('Phone');?></p>
                            </div>
                        </div>
                        <div class="d-block">
                            <p class="blueDark medium">Email</p>
                        </div>
                    </div>
                </div>
                <div class="formBox__flex">
                    <div class="formBox__contact__line">
                        <div class="d-block">
                            <div class="flexGroup2">
                                <p class="blueDark"><?php echo $data_review['passenger']['area_code']?> <?php echo $data_review['passenger']['phone']?></p>
                            </div>
                        </div>
                        <div class="d-block">
                            <p class="blueDark"><?php echo $data_review['passenger']['email']?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php


    ?>
    <?php if(
            (isset($data_review['passenger']['hotel_transfer_go']) && $data_review['passenger']['hotel_transfer_go'] != '') ||
            (isset($data_review['passenger']['hotel_transfer_return']) && $data_review['passenger']['hotel_transfer_return'] != '')
    )

    :
        if($lang == 'en') {
            $shuttle = 'Shuttle bus address';
        } else {
            $shuttle = 'Địa chỉ đưa/đón xe bus:';
        }


        ?>

        <div class="formBox">
            <div class="formBox__body">
                <div class="review__title ml10"><p class="text16 medium blueDark"><?php echo $shuttle;?></p></div>
                <div class="formBox__contact">
                    <div class="formBox__flex">
                        <div class="formBox__flex">
                            <div class="formBox__right">
                                <ul>
                                    <?php if (isset($data_review['passenger']['hotel_transfer_go']) && $data_review['passenger']['hotel_transfer_go'] != ''):?>
                                        <li class="flexGroup1 blueDark">
                                            <p style="display: grid">
                                                <?php echo t('Hanoi to Halong');?>
                                            </p>
                                            <p><?php echo $data_review['passenger']['hotel_transfer_go'];?></p>
                                        </li>
                                    <?php endif;?>
                                    <?php if (isset($data_review['passenger']['hotel_transfer_return']) && $data_review['passenger']['hotel_transfer_return'] != ''):?>
                                        <li class="flexGroup1 blueDark">
                                            <p style="display: grid">
                                                <?php echo t('Halong to Hanoi');?>
                                            </p>
                                            <p><?php echo $data_review['passenger']['hotel_transfer_return'];?></p>
                                        </li>
                                    <?php endif;?>





                                </ul>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    <?php endif;?>

    <?php if($data_review['passenger']['special_request'] != ''):?>
    <div class="formBox">
        <div class="formBox__body">
            <div class="review__title ml10"><p class="text16 medium blueDark"><?php echo t('Special request');?></p></div>
            <div class="formBox__contact ml10">
                <?php echo $data_review['passenger']['special_request']?>
            </div>
        </div>
    </div>
    <?php endif;?>


    <div class="formBox">
        <div class="formBox__body">
            <div class="review__title ml10"><p class="text16 medium blueDark"><?php echo t('Payment option');?></p></div>
            <div class="formBox__payment ml10">
                <div class="formBox__payment__item">
                    <div class="radio">
                        <input id="fl11" type="radio" name="fl" checked="">
                        <label for="fl11"><?php echo t('Pay by Credit/Debit Cards');?></label>
                    </div>
                    <ul class="formBox__payment__card">
                        <li><img src="<?php echo $theme?>images/jcb.png"></li>
                        <li><img src="<?php echo $theme?>images/visa.png"></li>
                        <li><img src="<?php echo $theme?>images/mastercard.png"></li>
                        <li><img src="<?php echo $theme?>images/card-dinner.png"></li>
                    </ul>
                </div>

            </div>
        </div>
    </div>
    <div class="formBox">
        <div class="formBox__body">
            <div class="review__title ml10"><p class="text16 medium blueDark"><?php echo t('Term of use');?></p></div>
            <div class="formBox__term ml10">
                <?php
                $term_of_use = _get_node($node_term);
                echo isset($term_of_use['body']['und'][0]['value'])?$term_of_use['body']['und'][0]['value']:'';

                ?>
            </div>
        </div>
    </div>
    <div class="flightReview__checkbox">
        <div class="checkbox">
            <input id="pp13" type="checkbox" checked="checked" disabled>
            <label class="blueDark" for="pp13"><?php echo t('I have read and agree to all the');?>&nbsp;<a target="_blank" href="<?php echo base_path().drupal_get_path_alias('detail/'.$node_term)?>" class="aLink" txt="<?php echo t('Term of Use specified');?>"><?php echo t('Term of Use specified');?></a>&nbsp;.</label>
        </div>
    </div>
    <?php if($is_continue):?>
    <div class="flightReview__btn"><a href="<?php echo  base_path().'payment/'.arg(1);?>" class="btn btn-orange btn-lg"><?php echo t('Continue');?></a></div>
    <?php endif;?>
</div>
<?php endif;?>
<?php
if($_SESSION['lang'] == 'vi') {
    $total_charges = round($total_charges/1000)*1000;
} else {
    $total_charges = round($total_charges);
}
//$total_charges = round($total_charges/1000)*1000;
$data_update = array('total' => $total_charges,'full_code' => arg(1));
$rs = post_api_data($data_update,'update_total');//print_r($rs);
?>
<?php if($_SESSION['send_email']):
    $full_code = arg(1);
    $body = email($full_code);
    $fullname = $data_review['passenger']['fullname']['adult'][0];
    $rs =  do_send_email($full_code,$body,$fullname);
    $_SESSION['send_email'] = null;



   /// var_dump($rs);
    ?>

<?php endif;?>

