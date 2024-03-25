<?php //print_r($data);
global $conf;
$sever = (($_SERVER['SERVER_PROTOCOL'] == 'HTTP/1.1')?'http://':'https://').$_SERVER['SERVER_NAME'];
if(isset($data['review']['data'])) {
    $data_review = json_decode($data['review']['data'],true);
}
$tran = isset($_REQUEST['t'])?$_REQUEST['t']:'';
$data_review = isset($data_review[$tran])?$data_review[$tran]:end($data_review);

$room_seleted = isset($data_review['room_selected'])?$data_review['room_selected']:array();
$cruise_id = isset($data_review['cruise'])?$data_review['cruise']:0;
$cruise_obj =  detail_cruise($cruise_id);

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

$total_passenger  = $num_adult + $num_child + $num_infant;

if($total_passenger > 1) {
    $passenger_label = t('passengers');
} else {
    $passenger_label = t('passenger');
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

$room_type_number = array_count_values($room_seleted);
$rooms = isset($cruise_obj['rooms'])?$cruise_obj['rooms']:array();
//print_r($data_review);die('abcd');
$itinerary_id = isset($data_review['arg2'])?$data_review['arg2']:0;

$itinerary_title = isset($cruise_obj['itinerary'][$itinerary_id]['title'])?$cruise_obj['itinerary'][$itinerary_id]['title']:'';

$num_day = substr($data_review['duration'],0,1);
$num_day = filter_var($num_day,FILTER_SANITIZE_NUMBER_INT) - 1;

$depart = strtotime($data_review['depart']);
$return = date('Y-m-d', strtotime($data_review['depart'] . ' +'.$num_day.' days'));
$return = strtotime($return);
$is_full_day = false;
if($data_review['duration'] == 'full_day') {
    $is_full_day = true;
    $num_day = 1;
}

$total_passenger_bus_feee = $num_adult + $num_child;
if($num_infant > 0) {
    $total_passenger_bus_feee += get_total_passenger_bus_fee($data_review['passenger'],$data_review['depart']);

}

$bus_fee = 0;
if(isset($data_review['passenger']['hanoi_halong']) || isset($data_review['passenger']['halong_hanoi'])) {
    if($data_review['passenger']['hanoi_halong'] == 'on' && $data_review['passenger']['halong_hanoi'] == 'on') {
        $bus_fee = $data_review['passenger']['roundtrip'];
    } else if($data_review['passenger']['hanoi_halong'] == 'on' && $data_review['passenger']['halong_hanoi'] != 'on') {
        $bus_fee = $data_review['passenger']['oneway'];
    }
}
if(isset($data_review['passenger']['bed_extra']) && count($data_review['passenger']['bed_extra']) > 0) {
    for($i = 0; $i < count($data_review['passenger']['bed_extra']); $i++) {
        $bed_extra +=  $data_review['passenger']['bed_extra'][$i];
    }
}

if(isset($data_review['passenger'])) {
    $search_param = $data_review;
    unset($search_param['passenger']);
}

$discount_obj = get_discount_for_booking($data_review['cruise'],$data_review['duration'],$search_param);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <title>Mail</title>
    <style>
        * {
            margin: 0;
            padding: 0;
        }

        table {
            border-collapse: collapse;
        }
        table.destkop {
            display: inline-table !important;
        }
        table.mobi {
            display: none !important;
        }
        .mobi {
            display: none !important;
        }
        .destkop {
            display: inline-table !important;
        }
        th, td {
            padding: 5px 0;
        }
        @media (max-width: 767px) {
            tr.email_cruise {
                display: flex;
                flex-wrap: wrap;
            }

           .email_cruise > td {
                width: 100%;

            }
            .img {
                padding:10px  0 !important;

            }
            .email_cruise .img {
               text-align: center;
                width: 100% !important;
            }
            .email_cruise .img img {
                width: 100% !important;
            }
            .cruise_info {
                padding: 15px 0px !important;
            }
            table.destkop {
                display: none !important;
            }
            table.mobi {
                display: inline-table !important;
            }
            table.mobi td {
                padding: 10px 0;
            }
            table.mobi tr:last-child {
                display: none;
            }

            .mobi {
                display: inline-table !important;
            }
            .destkop {
                display: none !important;
            }
        }
        .tableIcon__star {
            display: inline;
        }
    </style>
</head>
<body style="margin: 0; padding: 0; background-color:#efefef; font-family: Arial, Helvetica, sans-serif;font-size: 14px; line-height: 1.5; color: #262626;">
<table align="center" cellpadding="0" cellspacing="0" width="100%"
       style="margin: 30px auto;;max-width: 900px;background: #ffffff;">
    <tbody>
    <tr>
        <td colspan="6"
            style="padding: 30px 0 0;">
            <table style="width: 100%;">
                <tr>
                    <td style="width: 100%;text-align: center;">
                        <img href="<?php echo $sever?>" width="300px" src="<?php echo $sever.'/sites/all/themes/newtheme/'?>images/mail/mail-logo.png" alt="" style="padding-left: 16px;">
                        <br>
                        <p style="color: #3e3d3d; text-align: center;margin-right: 15px;font-size: 16px;font-weight: 600;">Order code: <?php echo $data['code']?></p>
                    </td>
                </tr>
            </table>
        </td>
    </tr>


    <?php if($cruise_obj):

        $cruise_img = isset($cruise_obj['info']['field_cruise_image']['und'][0]['uri'])?$cruise_obj['info']['field_cruise_image']['und'][0]['uri']:'';
        $cruise_img = file_create_url($cruise_img);
        $cruise_img = convert_img_url($cruise_img);
        $itinerary_title = isset($cruise_obj['itinerary'][$itinerary_id]['title'])?$cruise_obj['itinerary'][$itinerary_id]['title']:'';

        ?>
    <tr class="">
        <td colspan="6" class="cruise_info" style="padding: 15px 30px;">
            <img class="mobi" style="width: 100%" src="<?php echo $cruise_img?>" />

            <table style="width: 100%;">
                <thead></thead>
                <tbody>
                <tr class="email_cruise">
<!--                    <td class="img destkop" style="margin-top:25px;width: 260px" valign="top">-->
<!--                        <img style="width: 260px" src="--><?php //echo $cruise_img?><!--">-->
<!---->
<!--                    </td>-->
                    <td style="width: 100%;padding: 15px 30px 30px;" valign="top">
                        <table style="width: 100%;padding: 15px 30px;" >
                            <tr>
                            <td colspan="2" style="color: #20265A;"><b><?php echo $cruise_obj['info']['title']?> <?php echo $itinerary_title?></b>  <?php
                                echo get_star_html($cruise_obj['info']['field_star']['und'][0]['value']);
                                ?>
                                <p class="blueDark45 text12 flexGroup mt5">
                                    <svg style="margin-right: 10px" class="mr10" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
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
                            </td>
                            </tr>
                            <tr>
                                <td style="color: #20265A;"  ><?php echo t('Type of room:');?></td>
                                <td>
                                    <?php if(count($room_type_number) > 0):?>
                                        <?php $i = 0; foreach($room_type_number as $room_id => $num):?>
                                            <?php echo $num ?>x <?php echo isset($rooms[$room_id]['title'])?$rooms[$room_id]['title']:''?><br/>

                                            <?php for ($j = 0; $j < count($room_seleted); $j++):?>
                                                <?php if($room_seleted[$j] == $room_id):?>
                                                    <span style="font-size: 11px">
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

                                                    <?php if($j < count($room_seleted) - 1):?>
                                                        /
                                                    <?php endif;?>
                                                <?php endif;?>
                                            <?php endfor;?>


                                                <br/>
                                        <?php $i++; endforeach;?>
                                    <?php endif;?>
                                </td>
                            </tr>

                            <tr>
                                <td style="color: #20265A;"  ><?php echo t('Duration');?></td>
                                <td>
                                    <?php echo $itinerary_title?>
                                </td>
                            </tr>

                            <tr>
                                <td style="color: #20265A;"  ><?php echo t('Passengers');?></td>
                                <td>
                                    <?php echo $num_adult .' '.$adult_label;?>
                                    <?php if($num_child > 0):?>
                                        , <?php echo $num_child .' '.$child_label;?>
                                    <?php endif;?>
                                    <?php if($num_infant > 0):?>
                                        , <?php echo $num_infant .' '.$infant_label;?>
                                    <?php endif;?>
                                </td>
                            </tr>
                            <tr>
                                <td style="color: #20265A;"  ><?php echo t('Check-in:');?></td>
                                <td>
                                    <?php echo date('d/m/Y',$depart)?>
                                </td>
                            </tr>
                            <tr>
                                <td style="color: #20265A;"  ><?php echo t('Check-out:');?></td>
                                <td>
                                    <?php echo date('d/m/Y',$return)?>
                                </td>
                            </tr>
                        </table>

                    </td>
                </tr>


                </tbody>
            </table>
        </td>
    </tr>
    <?php endif;?>

    <tr>
        <td colspan="6" style="padding: 15px 30px;">
            <table style="width: 100%;">
                <tr>
                    <td colspan="6" style="padding-bottom: 10px;border-bottom: 2px solid #e3e3e3;">
                        <table style="width: 100%;">
                            <thead>
                            <tr>
                                <th colspan="2"
                                    style="text-align: left;padding-bottom: 10px;">
                                    <p>
                                        <span style="font-size: 16px;"><?php echo t('Price');?></span>
                                    </p>
                                </th>
                            </tr>
                            </thead>

                            <?php //echo email_price($room_seleted);?>
                        </table>
                    </td>
                </tr>

                <?php $amount = 0;$total_discount = 0;$don_vi_discount = ''; for($i = 0; $i < count($room_seleted); $i++):
                    $room_id = $room_seleted[$i];
                    $room_obj = $cruise_obj['rooms'][$room_id];

                    $calculator_fare = calculator_fare($room_obj,$i,$search_param,$discount_obj);//print_r($calculator_fare);
                    $total_of_room = $calculator_fare['total'];

                    $don_vi_discount  = $calculator_fare['don_vi'];
                    if($calculator_fare['type'] == 'total') {
                        if($i == 0) {
                            $total_discount = $calculator_fare['total_discount'];

                        }


                    } else {
                        $total_discount += $calculator_fare['total_discount'];

                    }
                    $amount += $calculator_fare['total'];


                    if($is_full_day) {
                        $fare_adult = $room_obj['field_price_for_adult']['und'][0]['value'];
                        $percent_of_child = isset($room_obj['field_percent_of_child']['und'][0]['value'])?$room_obj['field_percent_of_child']['und'][0]['value']:75;
                        $fare_child = $fare_adult*  $percent_of_child /100;
                        $fare_infant = $fare_adult * $percent_of_child /100;
                        $amount = $fare_adult * $num_adult + $fare_child*$num_child + $fare_infant * ($num_infant - 1);
                    }
                    ?>


                    <tr>
                        <td style="padding: 15px 0 0" valign="top">

                            <?php if(!$is_full_day):?>
                                <?php echo t('Room').' '. ($i + 1);?>
                            <?php else:?>
                                <?php echo t('Adult');?>
                            <?php endif;?>
                        </td>
                        <td style="padding: 15px 0 0" valign="top">

                            <?php if($is_full_day):?>
                                <p><?php echo show_price($fare_adult);?> x <?php echo $num_adult?></p>
                            <?php else:?>
                                <p><?php echo show_price($total_of_room);?></p>
                            <?php endif;?>

                        </td>

                    </tr>
                    <?php if($is_full_day && $num_child > 0):?>
                        <tr>
                            <td style="padding: 15px 0 0" valign="top">

                                <?php echo t('Child');?>
                            </td>
                            <td style="padding: 15px 0 0" valign="top">

                                <p><?php  echo show_price($fare_child)?> x <?php echo $num_child?></p>

                            </td>

                        </tr>
                    <?php endif;?>
                    <?php if($is_full_day && $num_infant > 1):?>
                    <tr>
                        <td style="padding: 15px 0 0" valign="top">

                            <?php echo t('Child');?>
                        </td>
                        <td style="padding: 15px 0 0" valign="top">

                            <p><?php  echo show_price($fare_infant)?> x <?php echo ($fare_infant - 1)?></p>

                        </td>

                    </tr>
                <?php endif;?>
                <?php endfor;?>
                <?php

                $tax = round($conf['percent_tax']* $amount*$num_day/100,1);
                if($don_vi_discount == 'percent') {
                    $total_discount = $amount * $total_discount/100;
                    $total_discount = round($total_discount);
                }
                $total_charges = $amount * $num_day + $tax + $bus_fee*$total_passenger_bus_feee + $bed_extra - $total_discount;
                ?>

                <?php if(!$is_full_day):?>
                    <tr >
                        <td style="padding: 15px 0 0" ><?php echo t('Number of nights');?></td>
                        <td style="padding: 15px 0 0" >x<?php echo $num_day?></td>
                    </tr>
                <?php else:?>

                <?php endif;?>

                <?php if($bus_fee > 0):?>
                <tr >
                    <td style="padding: 15px 0 0" ><?php echo t('Shutter bus fee');?></td>
                    <td style="padding: 15px 0 0" ><?php echo show_price($bus_fee) ?> x <?php echo $total_passenger_bus_feee?></td>
                </tr>
                <?php endif;?>
                <?php if($bed_extra > 0):?>
                    <tr >
                        <td style="padding: 15px 0 0" ><?php echo t('Extra bed fee');?></td>
                        <td style="padding: 15px 0 0" ><?php echo show_price($bed_extra)?></td>
                    </tr>
                <?php endif;?>
                <tr >
                    <td style="padding: 15px 0 0" ><?php echo t('Taxes and fees');?></td>
                    <td style="padding: 15px 0 0" ><?php echo show_price($tax);?></td>
                </tr>
                <?php if($total_discount > 0):


                    ?>
                    <tr >
                        <td style="padding: 15px 0 0"  ><?php echo t('Discount');?></td>
                        <td style="padding: 15px 0 0" >-<?php echo show_price($total_discount)?></td>
                    </tr>
                <?php endif;?>
                <tr >
                    <td style="padding: 15px 0 0"  ><?php echo t('Total charges');?></td>
                    <td style="padding: 15px 0 0" ><?php echo show_price($total_charges)?></td>
                </tr>




                <tr>
                    <td colspan="6" style="padding-bottom: 20px; border-bottom: 2px solid #e3e3e3;">
                        <table style="width: 100%;" >
                            <thead>
                            <tr>
                                <th colspan="2"
                                    style="text-align: left; padding-top: 15px;padding-bottom: 10px;border-bottom: 2px solid #e3e3e3;">
                                    <p>
                                            <span style="font-size: 16px;"><?php echo t('Passenger details');?> (<?php echo $total_passenger;?> <?php echo $passenger_label?>)</span>
                                    </p>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td colspan="6" style="padding-top: 15px;">
                                    <table style="width: 100%;" class="destkop">
                                        <thead>
                                        <tr>
                                            <th style="color: #a7a7a7; text-align: left;font-size: 14px;"><?php echo t('Full Name');?></th>
                                            <th style="color: #a7a7a7; text-align: left;font-size: 14px;"><?php echo t('Date of Birth');?></th>
                                            <th style="color: #a7a7a7; text-align: left;font-size: 14px;"><?php echo t('Passport');?></th>
                                            <th style="color: #a7a7a7; text-align: left;font-size: 14px;"><?php echo t('Nationality');?></th>
                                            <th style="color: #a7a7a7; text-align: left;font-size: 14px;"><?php echo t('Date of Issued');?></th>
                                            <th style="color: #a7a7a7; text-align: left;font-size: 14px;"><?php echo t('Date of Expired')?></th>

                                        </tr>
                                        </thead>

                                        <tbody>
                                        <?php for($i = 0; $i < $num_adult; $i++): ?>
                                        <tr>
                                            <td style="padding-top: 20px; vertical-align: middle;font-size: 14px;">

                                                <?php echo $data_review['passenger']['title']['adult'][$i];?>
                                                <?php echo $data_review['passenger']['fullname']['adult'][$i];?>
                                            </td>
                                            <td style="padding-top: 20px; vertical-align: middle;font-size: 14px;">
                                                <?php echo $data_review['passenger']['day']['adult'][$i];?>/<?php echo $data_review['passenger']['month']['adult'][$i];?>/<?php echo $data_review['passenger']['year']['adult'][$i];?>
                                            </td>

                                            <td style="padding-top: 20px; vertical-align: middle;font-size: 14px;">
                                                <?php echo $data_review['passenger']['passport']['adult'][$i];?>
                                            </td>
                                            <td style="padding-top: 20px; vertical-align: middle;font-size: 14px;">
                                                <?php echo $data_review['passenger']['nationality']['adult'][$i];?>
                                            </td>


                                            <td style="padding-top: 20px; vertical-align: middle;font-size: 14px;">
                                                <?php echo $data_review['passenger']['date_issued']['adult'][$i];?>
                                            </td>


                                                <td style="padding-top: 20px; vertical-align: middle;font-size: 14px;"><?php echo $data_review['passenger']['date_expired']['adult'][$i];?></td>

                                        </tr>
                                        <?php endfor;?>
                                        <?php if($num_child > 0):?>
                                        <?php for($i = 0; $i < $num_child; $i++):?>
                                            <tr>
                                                <td style="padding-top: 20px; vertical-align: middle;font-size: 14px;">

                                                    <?php echo $data_review['passenger']['title']['child'][$i];?>
                                                    <?php echo $data_review['passenger']['fullname']['child'][$i];?>
                                                </td>
                                                <td style="padding-top: 20px; vertical-align: middle;font-size: 14px;">
                                                    <?php echo $data_review['passenger']['day']['child'][$i];?>/<?php echo $data_review['passenger']['month']['child'][$i];?>/<?php echo $data_review['passenger']['year']['child'][$i];?>
                                                </td>

                                                <td style="padding-top: 20px; vertical-align: middle;font-size: 14px;">
                                                    <?php echo $data_review['passenger']['passport']['child'][$i];?>
                                                </td>
                                                <td style="padding-top: 20px; vertical-align: middle;font-size: 14px;">
                                                    <?php echo $data_review['passenger']['nationality']['child'][$i];?>
                                                </td>


                                                <td style="padding-top: 20px; vertical-align: middle;font-size: 14px;">
                                                    <?php echo $data_review['passenger']['date_issued']['child'][$i];?>
                                                </td>


                                                <td style="padding-top: 20px; vertical-align: middle;font-size: 14px;"><?php echo $data_review['passenger']['date_expired']['child'][$i];?></td>

                                            </tr>
                                        <?php endfor;?>
                                        <?php endif;?>

                                        <?php if($num_infant > 0):?>
                                            <?php for($i = 0; $i < $num_infant; $i++):?>
                                                <tr>
                                                    <td style="padding-top: 20px; vertical-align: middle;font-size: 14px;">

                                                        <?php echo $data_review['passenger']['title']['infant'][$i];?>
                                                        <?php echo $data_review['passenger']['fullname']['infant'][$i];?>
                                                    </td>
                                                    <td style="padding-top: 20px; vertical-align: middle;font-size: 14px;">
                                                        <?php echo $data_review['passenger']['day']['infant'][$i];?>/<?php echo $data_review['passenger']['month']['infant'][$i];?>/<?php echo $data_review['passenger']['year']['infant'][$i];?>
                                                    </td>

                                                    <td style="padding-top: 20px; vertical-align: middle;font-size: 14px;">
                                                        <?php echo $data_review['passenger']['passport']['infant'][$i];?>
                                                    </td>
                                                    <td style="padding-top: 20px; vertical-align: middle;font-size: 14px;">
                                                        <?php echo $data_review['passenger']['nationality']['infant'][$i];?>
                                                    </td>


                                                    <td style="padding-top: 20px; vertical-align: middle;font-size: 14px;">
                                                        <?php echo $data_review['passenger']['date_issued']['infant'][$i];?>
                                                    </td>


                                                    <td style="padding-top: 20px; vertical-align: middle;font-size: 14px;"><?php echo $data_review['passenger']['date_expired']['infant'][$i];?></td>

                                                </tr>
                                            <?php endfor;?>
                                        <?php endif;?>

                                        </tbody>
                                    </table>

                                    <table style="width: 100%;" class="mobi" cellpadding="10">


                                        <tbody>
                                        <?php for($i = 0; $i < $num_adult; $i++): ?>
                                            <tr>
                                                <th style="color: #a7a7a7; text-align: left;font-size: 14px;"><?php echo t('Full Name');?></th>
                                                <td style="font-size: 14px;">

                                                    <?php echo $data_review['passenger']['title']['adult'][$i];?>
                                                    <?php echo $data_review['passenger']['fullname']['adult'][$i];?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th style="color: #a7a7a7; text-align: left;font-size: 14px;"><?php echo t('Date of Birth');?></th>
                                                <td style="font-size: 14px;">
                                                    <?php echo $data_review['passenger']['day']['adult'][$i];?>/<?php echo $data_review['passenger']['month']['adult'][$i];?>/<?php echo $data_review['passenger']['year']['adult'][$i];?>
                                                </td>
                                            </tr>
                                            <tr>

                                                <th style="color: #a7a7a7; text-align: left;font-size: 14px;"><?php echo t('Passport');?></th>
                                                <td style="font-size: 14px;">
                                                    <?php echo $data_review['passenger']['passport']['adult'][$i];?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th style="color: #a7a7a7; text-align: left;font-size: 14px;"><?php echo t('Nationality');?></th>
                                                <td style="font-size: 14px;">
                                                    <?php echo $data_review['passenger']['nationality']['adult'][$i];?>
                                                </td>

                                            </tr>
                                            <tr>
                                                <th style="color: #a7a7a7; text-align: left;font-size: 14px;"><?php echo t('Date of Issued');?></th>
                                                <td style="font-size: 14px;">
                                                    <?php echo $data_review['passenger']['date_issued']['adult'][$i];?>
                                                </td>

                                            </tr>
                                            <tr>
                                                <th style="color: #a7a7a7; text-align: left;font-size: 14px;"><?php echo t('Date of Expired')?></th>
                                                <td style="font-size: 14px;"><?php echo $data_review['passenger']['date_expired']['adult'][$i];?></td>
                                            </tr>

                                            <tr><td colspan="2" style="border-bottom: 1px solid #ccc"></td></tr>

                                        <?php endfor;?>
                                        <?php if($num_child > 0):?>
                                            <?php for($i = 0; $i < $num_child; $i++):?>

                                                <tr>
                                                    <th style="color: #a7a7a7; text-align: left;font-size: 14px;"><?php echo t('Full Name');?></th>
                                                    <td style="font-size: 14px;">

                                                        <?php echo $data_review['passenger']['title']['child'][$i];?>
                                                        <?php echo $data_review['passenger']['fullname']['child'][$i];?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th style="color: #a7a7a7; text-align: left;font-size: 14px;"><?php echo t('Date of Birth');?></th>
                                                    <td style="font-size: 14px;">
                                                        <?php echo $data_review['passenger']['day']['child'][$i];?>/<?php echo $data_review['passenger']['month']['child'][$i];?>/<?php echo $data_review['passenger']['year']['child'][$i];?>
                                                    </td>
                                                </tr>
                                                <tr>

                                                    <th style="color: #a7a7a7; text-align: left;font-size: 14px;"><?php echo t('Passport');?></th>
                                                    <td style="font-size: 14px;">
                                                        <?php echo $data_review['passenger']['passport']['child'][$i];?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th style="color: #a7a7a7; text-align: left;font-size: 14px;"><?php echo t('Nationality');?></th>
                                                    <td style="font-size: 14px;">
                                                        <?php echo $data_review['passenger']['nationality']['child'][$i];?>
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <th style="color: #a7a7a7; text-align: left;font-size: 14px;"><?php echo t('Date of Issued');?></th>
                                                    <td style="font-size: 14px;">
                                                        <?php echo $data_review['passenger']['date_issued']['child'][$i];?>
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <th style="color: #a7a7a7; text-align: left;font-size: 14px;"><?php echo t('Date of Expired')?></th>
                                                    <td style="font-size: 14px;"><?php echo $data_review['passenger']['date_expired']['child'][$i];?></td>
                                                </tr>
                                                <tr><td colspan="2" style="border-bottom: 1px solid #ccc"></td></tr>
                                            <?php endfor;?>
                                        <?php endif;?>

                                        <?php if($num_infant > 0):?>
                                            <?php for($i = 0; $i < $num_infant; $i++):?>

                                                <tr>
                                                    <th style="color: #a7a7a7; text-align: left;font-size: 14px;"><?php echo t('Full Name');?></th>
                                                    <td style="font-size: 14px;">

                                                        <?php echo $data_review['passenger']['title']['infant'][$i];?>
                                                        <?php echo $data_review['passenger']['fullname']['infant'][$i];?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th style="color: #a7a7a7; text-align: left;font-size: 14px;"><?php echo t('Date of Birth');?></th>
                                                    <td style="font-size: 14px;">
                                                        <?php echo $data_review['passenger']['day']['infant'][$i];?>/<?php echo $data_review['passenger']['month']['infant'][$i];?>/<?php echo $data_review['passenger']['year']['infant'][$i];?>
                                                    </td>
                                                </tr>
                                                <tr>

                                                    <th style="color: #a7a7a7; text-align: left;font-size: 14px;"><?php echo t('Passport');?></th>
                                                    <td style="font-size: 14px;">
                                                        <?php echo $data_review['passenger']['passport']['infant'][$i];?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th style="color: #a7a7a7; text-align: left;font-size: 14px;"><?php echo t('Nationality');?></th>
                                                    <td style="font-size: 14px;">
                                                        <?php echo $data_review['passenger']['nationality']['infant'][$i];?>
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <th style="color: #a7a7a7; text-align: left;font-size: 14px;"><?php echo t('Date of Issued');?></th>
                                                    <td style="font-size: 14px;">
                                                        <?php echo $data_review['passenger']['date_issued']['infant'][$i];?>
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <th style="color: #a7a7a7; text-align: left;font-size: 14px;"><?php echo t('Date of Expired')?></th>
                                                    <td style="font-size: 14px;"><?php echo $data_review['passenger']['date_expired']['infant'][$i];?></td>
                                                </tr>

                                                <tr><td colspan="2" style="border-bottom: 1px solid #ccc"></td></tr>



                                            <?php endfor;?>
                                        <?php endif;?>

                                        </tbody>
                                    </table>
                                </td>
                            </tr>

                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td colspan="6" style="padding-bottom: 20px; border-bottom: 2px solid #e3e3e3;">
                        <table style="width: 100%;">
                            <thead>
                            <tr>
                                <th colspan="2"style="text-align: left; padding-top: 15px;">
                                    <p>
                                        <span style="font-size: 16px;">Contact details</span>
                                    </p>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td colspan="6">
                                    <table style="width: 100%;">
                                        <thead>
                                        <tr>
                                            <th style="color: #a7a7a7; text-align: left; padding-top: 15px;font-size: 14px;">Phone</th>
                                            <th style="color: #a7a7a7; text-align: left; padding-top: 15px;font-size: 14px;">Email</th>
                                        </tr>
                                        </thead>

                                        <tbody>
                                        <tr>
                                            <td style="vertical-align: middle;font-size: 14px;"><?php echo $data_review['passenger']['area_code']?> <?php echo $data_review['passenger']['phone']?>
                                            </td>
                                            <td style="vertical-align: middle;font-size: 14px;">
                                                <?php echo $data_review['passenger']['email']?>
                                            </td>
                                        </tr>

                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <?php if($data_review['passenger']['special_request'] != ''):?>
                    <tr>
                        <td colspan="6" style="padding-bottom: 20px; border-bottom: 2px solid #e3e3e3;">
                            <table style="width: 100%;">
                                <thead>
                                <tr>
                                    <th colspan="2"style="text-align: left; padding-top: 15px;">
                                        <p>
                                            <span style="font-size: 16px;"><?php echo t('Special request');?></span>
                                        </p>
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td colspan="6">
                                        <table style="width: 100%;">


                                            <tbody>
                                            <tr>
                                                <td style="vertical-align: middle;font-size: 14px;"><?php echo $data_review['passenger']['special_request']?></td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                <?php endif;?>

                <?php if(
                (isset($data_review['passenger']['hotel_transfer_go']) && $data_review['passenger']['hotel_transfer_go'] != '') ||
                (isset($data_review['passenger']['hotel_transfer_return']) && $data_review['passenger']['hotel_transfer_return'] != '')
                )

                :?>

                    <?php if (isset($data_review['passenger']['hotel_transfer_go']) && $data_review['passenger']['hotel_transfer_go'] != ''):?>
                        <tr>
                            <td colspan="6" style="padding-bottom: 20px; border-bottom: 2px solid #e3e3e3;">
                                <table style="width: 100%;">
                                    <thead>
                                    <tr>
                                        <th colspan="2"style="text-align: left; padding-top: 15px;">
                                            <p>
                                                <span style="font-size: 16px;"><?php echo t('Hanoi to Halong');?></span>
                                            </p>
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td colspan="6">
                                            <table style="width: 100%;">


                                                <tbody>
                                                <tr>
                                                    <td style="padding-top: 15px; vertical-align: middle;font-size: 14px;"><?php echo $data_review['passenger']['hotel_transfer_go'];?></td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    <?php endif;?>


                    <?php if (isset($data_review['passenger']['hotel_transfer_return']) && $data_review['passenger']['hotel_transfer_return'] != ''):?>
                        <tr>
                            <td colspan="6" style="padding-bottom: 20px; border-bottom: 2px solid #e3e3e3;">
                                <table style="width: 100%;">
                                    <thead>
                                    <tr>
                                        <th colspan="2"style="text-align: left; padding-top: 15px;">
                                            <p>
                                                <span style="font-size: 16px;"><?php echo t('Halong to Hanoi');?></span>
                                            </p>
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td colspan="6">
                                            <table style="width: 100%;">


                                                <tbody>
                                                <tr>
                                                    <td style="padding-top: 15px; vertical-align: middle;font-size: 14px;"><?php echo $data_review['passenger']['hotel_transfer_return'];?></td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    <?php endif;?>


                <?php endif;?>
            </table>
        </td>
    </tr>
    </tbody>
</table>
</body>
</html>