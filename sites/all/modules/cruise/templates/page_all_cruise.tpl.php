<?php
global $conf;
$list_amenities = list_amenities();
$lang = (isset($_SESSION['lang']) && $_SESSION['lang'] != '')?$_SESSION['lang']:'en';
$percents = array(25,30,35);
$text_from_money = $lang == 'vi' ? 'Từ' : 'From';
$activities = array(
        'Swimming',
        'Tai Chi Class',
        'Squid Fishing',
        'Kayaking',
        'Cycling',
       // 'Floating Slide',
        'Jacuzzi',
        'Cooking Class'
);
if($lang == 'vi') {
    $activities = array(
            'Bơi lội',
            'Lớp thái cực quyền',
            'Câu mực',
            'Chèo thuyền Kayak',
            'Đạp xe',
          //  'Lướt ván',
            'Bể sục',
            'Lớp học nấu ăn'
    );
}


$tran = isset($_REQUEST['t'])?$_REQUEST['t']:'';
$max_all = 0;
$min_all = 99999999999999999999999999;
$price_max_fix  = 99999999999999999999999999999999;

$web_info = web_info_basic();//print_r($web_info);die;
$ty_gia = isset($web_info['field_ty_gia']['ud'][0]['value'])?$web_info['field_ty_gia']['ud'][0]['value']:23500;
$discount = _get_discount();//print_r($discount);
$discount_value_default = 0;

$duration = isset($_SESSION['search_param'][$tran]['duration'])?$_SESSION['search_param'][$tran]['duration']:'';

$list_room = array();
$so_phong = $_SESSION['search_param'][$tran]['no_room'];
for($i = 0; $i < $so_phong; $i++) {
    $p = $_SESSION['search_param'][$tran]['room_type'][$i];
    if(!in_array($p,$list_room)) {
        array_push($list_room,$p);
    }
}

//print_r($list_room);
$depart = $_SESSION['search_param'][$tran]['depart'];
?>
<?php //echo blk_form_search();?>
<div class="cruiseEdit__search showMobile">
    <div class="editSearch__date">
        <svg xmlns="http://www.w3.org/2000/svg" width="21" height="22" viewBox="0 0 21 22" fill="none">
            <path d="M18.7103 0.411865H16.7477V2.52951C16.7477 2.95304 16.4206 3.23539 16.0935 3.23539C15.7664 3.23539 15.4393 2.95304 15.4393 2.52951V0.411865H4.97196V2.52951C4.97196 2.95304 4.64486 3.23539 4.31776 3.23539C3.99065 3.23539 3.66355 2.95304 3.66355 2.52951V0.411865H1.70093C0.719626 0.411865 0 1.32951 0 2.52951V5.07069H20.9346V2.52951C20.9346 1.32951 19.757 0.411865 18.7103 0.411865ZM0 6.55304V19.4707C0 20.7413 0.719626 21.5883 1.76636 21.5883H18.7757C19.8224 21.5883 21 20.6707 21 19.4707V6.55304H0ZM5.82243 18.4119H4.25234C3.99065 18.4119 3.72897 18.2001 3.72897 17.8472V16.0825C3.72897 15.8001 3.92523 15.5177 4.25234 15.5177H5.88785C6.14953 15.5177 6.41122 15.7295 6.41122 16.0825V17.8472C6.34579 18.2001 6.14953 18.4119 5.82243 18.4119ZM5.82243 12.0589H4.25234C3.99065 12.0589 3.72897 11.8472 3.72897 11.4942V9.72951C3.72897 9.44716 3.92523 9.16481 4.25234 9.16481H5.88785C6.14953 9.16481 6.41122 9.37657 6.41122 9.72951V11.4942C6.34579 11.8472 6.14953 12.0589 5.82243 12.0589ZM11.0561 18.4119H9.42056C9.15888 18.4119 8.8972 18.2001 8.8972 17.8472V16.0825C8.8972 15.8001 9.09346 15.5177 9.42056 15.5177H11.0561C11.3178 15.5177 11.5794 15.7295 11.5794 16.0825V17.8472C11.5794 18.2001 11.3832 18.4119 11.0561 18.4119ZM11.0561 12.0589H9.42056C9.15888 12.0589 8.8972 11.8472 8.8972 11.4942V9.72951C8.8972 9.44716 9.09346 9.16481 9.42056 9.16481H11.0561C11.3178 9.16481 11.5794 9.37657 11.5794 9.72951V11.4942C11.5794 11.8472 11.3832 12.0589 11.0561 12.0589ZM16.2897 18.4119H14.6542C14.3925 18.4119 14.1308 18.2001 14.1308 17.8472V16.0825C14.1308 15.8001 14.3271 15.5177 14.6542 15.5177H16.2897C16.5514 15.5177 16.8131 15.7295 16.8131 16.0825V17.8472C16.8131 18.2001 16.6168 18.4119 16.2897 18.4119ZM16.2897 12.0589H14.6542C14.3925 12.0589 14.1308 11.8472 14.1308 11.4942V9.72951C14.1308 9.44716 14.3271 9.16481 14.6542 9.16481H16.2897C16.5514 9.16481 16.8131 9.37657 16.8131 9.72951V11.4942C16.8131 11.8472 16.6168 12.0589 16.2897 12.0589Z" fill="#5C6AA1"></path>
        </svg>
        <p class="text14 colorBluedark900"><?php echo $depart?></p>
    </div>
    <div class="editSearch__time">
        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22" fill="none">
            <path d="M11 0C8.82441 0 6.69767 0.645139 4.88873 1.85383C3.07979 3.06253 1.66989 4.78049 0.83733 6.79048C0.00476617 8.80047 -0.213071 11.0122 0.211367 13.146C0.635804 15.2798 1.68345 17.2398 3.22183 18.7782C4.76021 20.3166 6.72022 21.3642 8.85401 21.7886C10.9878 22.2131 13.1995 21.9952 15.2095 21.1627C17.2195 20.3301 18.9375 18.9202 20.1462 17.1113C21.3549 15.3023 22 13.1756 22 11C21.9966 8.08367 20.8365 5.28778 18.7744 3.22563C16.7122 1.16347 13.9163 0.00344047 11 0ZM14.707 14.707C14.5195 14.8945 14.2652 14.9998 14 14.9998C13.7348 14.9998 13.4805 14.8945 13.293 14.707L10.293 11.707C10.1055 11.5195 10.0001 11.2652 10 11V5C10 4.73478 10.1054 4.48043 10.2929 4.29289C10.4804 4.10536 10.7348 4 11 4C11.2652 4 11.5196 4.10536 11.7071 4.29289C11.8946 4.48043 12 4.73478 12 5V10.586L14.707 13.293C14.8945 13.4805 14.9998 13.7348 14.9998 14C14.9998 14.2652 14.8945 14.5195 14.707 14.707Z" fill="#5C6AA1"></path>
        </svg>
        <p class="text14 colorBluedark900"><?php echo $conf['CRUISE_DURATION'][$duration]?></p>
        <button type="button">
            <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22" fill="none">
                <path d="M21.707 4.29303L17.707 0.293031C17.5195 0.10556 17.2652 0.000244141 17 0.000244141C16.7348 0.000244141 16.4805 0.10556 16.293 0.293031L13.5 3.08603L18.914 8.50003L21.707 5.70703C21.8945 5.5195 21.9998 5.26519 21.9998 5.00003C21.9998 4.73487 21.8945 4.48056 21.707 4.29303Z" fill="#5C6AA1"/>
                <path d="M12.086 4.5L2.29297 14.293C2.18339 14.4029 2.10088 14.5367 2.05197 14.684L0.0519735 20.684C0.00192931 20.8343 -0.0117136 20.9942 0.0121681 21.1508C0.0360497 21.3074 0.0967728 21.456 0.189339 21.5845C0.281904 21.713 0.403665 21.8177 0.544598 21.8899C0.685531 21.9621 0.841606 21.9999 0.999973 22C1.10744 22 1.21417 21.9824 1.31597 21.948L7.31597 19.948C7.46324 19.8991 7.5971 19.8166 7.70697 19.707L17.5 9.914L12.086 4.5Z" fill="#5C6AA1"/>
            </svg>
        </button>

    </div>
    <div class="editSearch__filter">
        <button type="button">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 20 23" fill="none">
                <path d="M19 0H1C0.55 0 0.25 0.3 0.25 0.75V3C0.25 3.15 0.325 3.375 0.475 3.525L7.75 11.55V21.75C7.75 22.05 7.9 22.275 8.2 22.425C8.275 22.5 8.35 22.5 8.5 22.5C8.65 22.5 8.8 22.425 8.95 22.35L11.95 20.1C12.175 19.95 12.25 19.725 12.25 19.5V11.55L19.525 3.525C19.675 3.375 19.75 3.15 19.75 3V0.75C19.75 0.3 19.45 0 19 0Z" fill="#5C6AA1"></path>
            </svg>
        </button>
    </div>
</div>
<p class="mt15"></p>
<div class="cruiseResult__item">
    <div class="cruiseResult__left col-3">
        <div class="cruiseResult__filter">
            <div class="cruiseResult__title mb15">
                <button class="showMobile onTab"><svg xmlns="http://www.w3.org/2000/svg" width="8" height="14" viewBox="0 0 8 14" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M7.70711 0.292893C8.09763 0.683417 8.09763 1.31658 7.70711 1.70711L2.41421 7L7.70711 12.2929C8.09763 12.6834 8.09763 13.3166 7.70711 13.7071C7.31658 14.0976 6.68342 14.0976 6.29289 13.7071L0.292893 7.70711C-0.0976311 7.31658 -0.0976311 6.68342 0.292893 6.29289L6.29289 0.292893C6.68342 -0.0976311 7.31658 -0.0976311 7.70711 0.292893Z" fill="#5C6AA1"/>
                    </svg></button>
                <span class="medium text16 blueDark"><?php echo t('Filter by');?></span>
                <button class="showMobile"><span class="blueP400 clear_fitler"><?php echo t('Clear all');?></span></button>
            </div>
            <div class="cruiseResult___cont">
                <div class="cruiseLeft__title">
                    <p class="medium blueDark mb15"><?php echo t('Your Budget (per night)');?></p>
                </div>
                <div class="cruiseLeft__checkbox">
                    <div class="checkbox" type="price" min="" max="">
                        <input id="pp0" type="radio" name="price" checked="checked">

                        <label for="pp0" class="text13 blueDark"><?php echo t('All');?></label>
                    </div>
                    <?php echo show_option_price('pp1',0,100,$ty_gia);?>
                    <?php echo show_option_price('pp2',100,200,$ty_gia);?>
                    <?php echo show_option_price('pp3',200,300,$ty_gia);?>
                    <?php echo show_option_price('pp4',300,400,$ty_gia);?>
                    <?php echo show_option_price('pp5',400,$price_max_fix,$ty_gia);?>

                </div>
            </div>
            <div class="cruiseResult___cont">
                <div class="cruiseLeft__title">
                    <p class="medium blueDark mb15"><?php echo t('Star rating');?></p>
                </div>
                <div class="cruiseLeft__rating">

                    <div class="cruiseLeft__star" star="3">
                        <p class="medium blueDark45">3</p>
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="11" viewBox="0 0 12 11" fill="none">
                            <path d="M6 0L7.34708 4.1459H11.7063L8.17963 6.7082L9.52671 10.8541L6 8.2918L2.47329 10.8541L3.82037 6.7082L0.293661 4.1459H4.65292L6 0Z" fill="#FD6431"></path>
                        </svg>
                    </div>
                    <div class="cruiseLeft__star" star="4">
                        <p class="medium blueDark45">4</p>
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="11" viewBox="0 0 12 11" fill="none">
                            <path d="M6 0L7.34708 4.1459H11.7063L8.17963 6.7082L9.52671 10.8541L6 8.2918L2.47329 10.8541L3.82037 6.7082L0.293661 4.1459H4.65292L6 0Z" fill="#FD6431"></path>
                        </svg>
                    </div>
                    <div class="cruiseLeft__star" star="5">
                        <p class="medium blueDark45">5</p>
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="11" viewBox="0 0 12 11" fill="none">
                            <path d="M6 0L7.34708 4.1459H11.7063L8.17963 6.7082L9.52671 10.8541L6 8.2918L2.47329 10.8541L3.82037 6.7082L0.293661 4.1459H4.65292L6 0Z" fill="#FD6431"></path>
                        </svg>
                    </div>
                    <div class="cruiseLeft__star" star="6">
                        <p class="medium blueDark45">6</p>
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="11" viewBox="0 0 12 11" fill="none">
                            <path d="M6 0L7.34708 4.1459H11.7063L8.17963 6.7082L9.52671 10.8541L6 8.2918L2.47329 10.8541L3.82037 6.7082L0.293661 4.1459H4.65292L6 0Z" fill="#FD6431"></path>
                        </svg>
                    </div>

                </div>
            </div>
            <div class="cruiseResult___cont">
                <div class="cruiseLeft__title">
                    <p class="medium blueDark mb15"><?php echo t('Guest point');?></p>
                </div>
                <div class="cruiseLeft__radio">
                    <div class="radio">
                        <input type="radio" id="all" name="fl" value="" checked>
                        <label for="all"><?php echo t('All');?></label>
                    </div>
                    <div class="radio">
                        <input type="radio" id="rating3" name="fl" value="7">
                        <label for="rating3">7+</label>
                    </div>
                    <div class="radio">
                        <input type="radio" id="rating4" name="fl" value="8">
                        <label for="rating4">8+</label>
                    </div>
                    <div class="radio">
                        <input type="radio" id="rating5" name="fl" value="9">
                        <label for="rating5">9+</label>
                    </div>
                    <div class="radio">
                        <input type="radio" id="rating6" name="fl" value="10">
                        <label for="rating6">10+</label>
                    </div>

                </div>
            </div>
            <div class="cruiseResult___cont">
                <div class="cruiseLeft__title">
                    <p class="medium blueDark mb15"><?php echo t('Activities');?></p>
                </div>
                <div class="cruiseLeft__checkbox">
                    <div class="checkbox">
                        <input id="ai_all" class="activities" type="checkbox" value="" checked>
                        <label for="ai_all" class="text13 blueDark"><?php echo t('All');?></label>
                    </div>
                    <?php if(count($activities) > 0):?>
                        <?php $ai = 0;foreach ($activities as $ob):

                            ?>
                            <div class="checkbox">
                                <input id="ai_<?php echo $ai?>" class="activities" type="checkbox" value="<?php echo trim(strtolower(convert_vn2latin(t($ob))));?>">
                                <label for="ai_<?php echo $ai?>" class="text13 blueDark"><?php echo t($ob)?></label>
                            </div>
                        <?php $ai++; endforeach;?>
                    <?php endif;?>

                </div>
            </div>

            <div class="cruiseResult___cont">
                <div class="cruiseLeft__title">
                    <p class="medium blueDark mb15"><?php echo t('Itinerary');?></p>
                </div>
                <div class="cruiseLeft__checkbox">
                    <div class="checkbox">
                        <input id="pp11_all" type="radio" name="filter_Itinerary" checked="checked" value="">
                        <label for="pp11_all" class="text13 blueDark"><?php echo t('All');?></label>
                    </div>
                    <div class="checkbox">
                        <input id="pp11" type="radio" name="filter_Itinerary" value="<?php echo ($lang == 'vi')?'vinhhalong':'halongbay'?>">
                        <label for="pp11" class="text13 blueDark"><?php echo t('Halong Bay');?></label>
                    </div>

                    <div class="checkbox">
                        <input id="pp14" type="radio" name="filter_Itinerary" value="<?php echo ($lang == 'vi')?'vinhlanha':'lanhabay'?>">
                        <label for="pp14" class="text13 blueDark"><?php echo t('Lan Ha Bay');?></label>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="cruiseResult__right col-9">
        <div class="cruiseResult__body">
            <div class="cruiseResult__header">
                <div class="cruiseRight__cont">
                    <p class="blueDark"><?php echo t('Recommended');?></p>
                    <p class="blueDark45"><?php echo t('Top offers');?></p>
                </div>
                <div class="cruiseRight__cont">
                    <p class="blueDark"><?php echo t('Lowest');?></p>
                    <p class="blueDark45"><span id="min_all"></span></p>
                </div>
                <div class="cruiseRight__cont">
                    <p class="blueDark"><?php echo t('Highest');?></p>
                    <p class="blueDark45"><span id="max_all"></span></p>
                </div>
            </div>
            <div class="cruiseResult__group showDesktop">
                <?php if(count($data) > 0):?>
                    <?php $ii = 0; foreach ($data as $ob):

                        $num_day = substr($ob['type_itinerary'],0,1);
                        $num_day = filter_var($num_day,FILTER_SANITIZE_NUMBER_INT) - 1;
                        if($num_day < 0) {
                            $num_day = 1;
                        }
                        $price = $price_max_fix;// $ob['min_price'] * $num_day ;
                        //echo $price;


                 //   print_r($ob);die;

                        $idx = rand(0,2);
                        $p = $percents[$idx];
                        $percent = $percents[$idx];

                        //$con_lai = $price;
                        //$chua_giam_gia = $tien_giam + $con_lai;


                        $itinerary_text = str_replace(' ','',strtolower($ob['itinerary_text']));
                        $itinerary_text = convert_vn2latin($itinerary_text);
                        $itinerary_text = trim($itinerary_text);
                        $is_show = false;
                        if($ob['type_itinerary'] == $duration) {
                            $is_show = true;
                        }
                        $discount_for_cruise = null;
                        $discount_per_adult = $discount_value_default;
                        $discount_html = '';
                        $discount_nid = null;//print_r($discount);
                        $doi_tuong_giam_total = 0;

                        $discount_value = '';
                        $discount_body = '';
                        for($d = 0; $d < count($discount); $d++) {
                          //  print_r($discount[$d]);
                            if( (in_array($ob['cruise_nid'],$discount[$d]['cruise'])) || count($discount[$d]['cruise']) == 0 ) {
                                //truong hop uu dai cho tau
                                if( (in_array($ob['type_itinerary'],$discount[$d]['hanh_trinh']) ) || count($discount[$d]['hanh_trinh']) == 0 && $discount[$d]['don_vi'] != 'percent' && $discount[$d]['doi_tuong_giam_adult'] == 1) {

                                    if($discount[$d]['so_tien_giam'] > $discount_per_adult ) {
                                        $discount_per_adult = $discount[$d]['so_tien_giam'];

                                    }




                                    $discount_html .= '<div class="discount-item" style="margin-bottom: 10px;padding-bottom:10px;border-bottom: 1px dashed #ccc">'.$discount[$d]['body'].'</div>';
                                }

                                if($discount[$d]['don_vi'] == 'percent') {
                                    $discount_value = $discount[$d]['so_tien_giam'].'%';
                                } else {
                                    $discount_value = show_price($discount[$d]['so_tien_giam']);

                                }
                                $discount_nid = $discount[$d]['nid'];
                                $discount_body = $discount[$d]['body'];
                            }
                           // $discount_nid = $discount[$d]['nid'];

                        }

                        $da_giam_gia = 0;
                      //  print_r($list_room);

                       // echo  $discount_nid.'xxxxxxxxxx';
                        $others_price = array();
                        $other_price_da_giam_gia = array();
                        $is_price_ok = false;
                        if(count($ob['others_price']) > 0) {
                            if($is_show == true) {
                                foreach ($ob['others_price'] as $key_room => $price_room) {
                                    if(in_array($key_room,$list_room)) {
                                        if(count($price_room) > 0) {
                                            for($p = 0; $p < count($price_room); $p++) {
                                                $op = $price_room[$p]['price'] * $num_day;//print_r($price_room);
                                                $op_other = ($price_room[$p]['price'] - $discount_per_adult) * $num_day ;
                                                if($lang == 'vi') {
                                                    $op = round($op/1000)*1000;
                                                    $op_other = round($op_other/1000)*1000;
                                                }
                                                array_push($others_price,$op);
                                                array_push($other_price_da_giam_gia,$op_other);
                                                if($price > $op) {
                                                    $price = $op;
                                                    $ob['min_price'] = $op;
                                                    $is_price_ok = true;
                                                }
                                            }
                                        }


                                    }
                                }
                            }


                        }
                        if($is_price_ok) {
                            $is_show = true;
                        } else {
                            $is_show = false;
                        }
                        //var_dump($is_price_ok);

                        if($discount_per_adult > 0) {
                            $da_giam_gia = ($ob['min_price'] - $discount_per_adult) * $num_day ;
                        }

                        ?>
                        <?php if($is_show):

                        if($price < $min_all) {
                            $min_all = $price;
                        }
                        if($price > $max_all) {
                            $max_all = $price;
                        }
                        ?>
                            <div min_price="<?php echo $ob['min_price']?>" other_price_da_giam_gia="<?php echo json_encode($other_price_da_giam_gia)?>" others_price="<?php echo json_encode($others_price)?>" cruise_id="<?php echo $ob['cruise_nid']?>" type_itinerary="<?php echo $ob['type_itinerary']?>" class="cruiseResult__table__row" nid="<?php echo $ob['nid']?>" itinerary="<?php echo $itinerary_text ?>" price="<?php echo $price?>" star="<?php echo $ob['star']?>" point="<?php echo isset($ob['point'])?$ob['point']:''?>" >
                                <div class="cruiseResult__table__left">
                                    <div class="cruiseResult__table__cell deals__img">
                                        <img src="<?php echo isset($ob['cruise_img'][0])?$ob['cruise_img'][0]:''?>"  />

                                        <?php if($discount_value != ''):?>
                                            <p>-<?php echo $discount_value?></p>
                                        <?php endif;?>

                                    </div>
                                    <div class="cruiseResult__table__cell">
                                        <ul class="ulGroup__text">
                                            <?php if($ii < 5):?>
                                                <li>
                                                    <p class="tableTop__booked text12 blueP400 medium top-book-all-cruise"><?php echo t('Top booked');?></p>
                                                </li>
                                            <?php endif;?>

                                            <li>
                                                <a href="<?php echo base_path().drupal_get_path_alias('cruise/'.$ob['cruise_nid'].'/'.$ob['nid'])?>?t=<?php echo $tran?>"  >
                                                    <span class="text20 blueDark medium"><?php echo $ob['cruise_name'] .' - '.$ob['title']?></span>
                                                    <?php if($discount_body != ''):?>
                                                        <div class="discount_body">
                                                            <div class="discount_text">
                                                                <?php echo strip_tags($discount_body);?>
                                                            </div>
                                                        </div>
                                                    <?php endif;?>
                                                </a>



                                                <p class="tableIcon__star">
                                                    <?php if(isset($ob['star'])):
                                                        echo html_star($ob['star']);
                                                        ?>

                                                    <?php endif;?>
                                                </p>
                                            </li>
                                            <li>
                                                <p class="offers__address blueDark45 text12"><svg xmlns="http://www.w3.org/2000/svg" width="10" height="14" viewBox="0 0 10 14" fill="none">
                                                        <path d="M4.99967 0.333374C2.41967 0.333374 0.333008 2.42004 0.333008 5.00004C0.333008 8.50004 4.99967 13.6667 4.99967 13.6667C4.99967 13.6667 9.66634 8.50004 9.66634 5.00004C9.66634 2.42004 7.57967 0.333374 4.99967 0.333374ZM4.99967 6.66671C4.07967 6.66671 3.33301 5.92004 3.33301 5.00004C3.33301 4.08004 4.07967 3.33337 4.99967 3.33337C5.91967 3.33337 6.66634 4.08004 6.66634 5.00004C6.66634 5.92004 5.91967 6.66671 4.99967 6.66671Z" fill="#5562DA"></path>
                                                    </svg><?php echo $ob['itinerary_text']?></p>
                                            </li>
                                            <li>
                                                <button type="button" data-toggle="modal" data-target="#popup_itinerary" class="viewMore text-left viewFull blue1"><span><?php echo t('View full itinerary');?></span></button>
                                                <div class="full_itinerary d-none">
                                                    <?php if(count($ob['itinerary']) > 0):?>
                                                        <?php for ($it = 0; $it < count($ob['itinerary']); $it++):

                                                            $content = trim($ob['itinerary'][$it]['value']);
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
                                                                    <p class="medium text16 blueDark"><?php echo t('Day')?> <?php echo ($it + 1).$title?></p>
                                                                </div>
                                                                <div class="cruiseItinerary__trip">
                                                                    <div class="tripContent" style="display: block">
                                                                        <?php echo $content?>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                        <?php endfor;?>
                                                    <?php endif;?>
                                                    <?php //print_r($ob['itinerary']);?>
                                                </div>
    <!--                                            <a class="blue1 viewFull">--><?php //echo t('View full itinerary');?><!--</a>-->
                                            </li>


                                            <?php $list_item = ''; if(isset($ob['field_thing_to_do_relax']) && count($ob['field_thing_to_do_relax']) > 0):?>
                                                <?php $a = 0; for($i = 0; $i < count($ob['field_thing_to_do_relax']); $i++):
                                                    $tid = $ob['field_thing_to_do_relax'][$i]['tid'];
                                                    $item = isset($list_amenities[$tid])?$list_amenities[$tid]:'';//echo $item;
                                                    $list_item .= trim(strtolower(convert_vn2latin($item))).',';
                                                    ?>
                                                    <?php if($item != '' && in_array($item,$activities) && $a < 3):?>
                                                    <li>
                                                        <p class="blueDark"><svg xmlns="http://www.w3.org/2000/svg" width="12" height="9" viewBox="0 0 12 9" fill="none">
                                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M11.8047 0.528636C12.0651 0.788986 12.0651 1.2111 11.8047 1.47145L4.4714 8.80478C4.21106 9.06513 3.78894 9.06513 3.5286 8.80478L0.195262 5.47145C-0.0650874 5.2111 -0.0650874 4.78899 0.195262 4.52864C0.455612 4.26829 0.877722 4.26829 1.13807 4.52864L4 7.39057L10.8619 0.528636C11.1223 0.268287 11.5444 0.268287 11.8047 0.528636Z" fill="#5C6AA1"></path>
                                                            </svg><?php echo $item?></p>
                                                    </li>
                                                    <?php $a++;endif;?>
                                                <?php endfor;?>
                                            <?php endif;?>


                                        </ul>
                                    </div>
                                    <input type="hidden" value="<?php echo $list_item?>" class="relax" />
                                </div>
                                <div class="cruiseResult__table__right">
                                    <div class="table__right__top">
                                        <p class="blueDark45"><?php echo isset($ob['review'])?$ob['review']:''?> <?php echo t('reviews');?></p>
                                        <p class="medium colorWhite"><?php echo isset($ob['point'])?$ob['point']:''?></p>
                                    </div>
                                    <div class="table__right__down" $price="<?php echo $price?>">
                                        <?php if($da_giam_gia > 0):?>
                                        <p class="blueDark medium price_not_dicount gia_goc"><?php echo show_price($price,0,true) ;?></p>
                                            <div class="small"><a target="_blank" href="<?php echo  base_path().'Hot-deals'?>" ><?php echo t('View more');?></a></div>
                                        <p class="green400 text24 medium gia_uu_dai"><?php echo show_price($da_giam_gia,0,true) ?>
                                        <?php else:?>
                                            <div class="price_all_cruise">
                                                <p class="blueDark45 text14 medium mr5"><?php echo $text_from_money?></p>
                                                <p class="green400 text24 medium gia_goc"><?php echo show_price($price,0,true) ;?></p>
                                            </div>
                                        <?php endif;?>
                                        <p class="blueDark medium">
                                            <?php echo t('Per pax');?>
                                        </p>
                                        <a href="<?php echo base_path().drupal_get_path_alias('cruise/'.$ob['cruise_nid'].'/'.$ob['nid'])?>?t=<?php echo $tran?>&did=<?php echo $discount_nid?>"  name="home_search" class="btn btn-orange w120"><?php echo t('View More');?></a>
                                    </div>
                                </div>

                            </div>
                        <?php if($discount_html !=''):?>
                        <div id="popup_discount_<?php echo $ob['nid']?>" class="popup_discount modal fade">
                            <div class="modal-dialog" style="max-width: 500px;">
                                <div class="modal-content">
                                    <div class="modal-body" style="padding: 50px">
                                        <button type="button" data-dismiss="modal" class="close">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="svg1point5">
                                                <path d="M14.3001 12.1788C14.2768 12.1556 14.2584 12.128 14.2458 12.0976C14.2332 12.0672 14.2267 12.0347 14.2267 12.0018C14.2267 11.9689 14.2332 11.9364 14.2458 11.906C14.2584 11.8756 14.2768 11.848 14.3001 11.8248L23.5631 2.5628C23.8444 2.28114 24.0022 1.89928 24.002 1.50124C24.0017 1.10319 23.8433 0.721561 23.5616 0.440299C23.28 0.159037 22.8981 0.00118392 22.5001 0.00146522C22.102 0.00174652 21.7204 0.160139 21.4391 0.441799L12.1771 9.6998C12.1539 9.72308 12.1263 9.74155 12.0959 9.75416C12.0656 9.76676 12.033 9.77325 12.0001 9.77325C11.9672 9.77325 11.9347 9.76676 11.9043 9.75416C11.8739 9.74155 11.8463 9.72308 11.8231 9.6998L2.56113 0.441799C2.42186 0.302467 2.25651 0.191929 2.07453 0.116498C1.89254 0.0410666 1.69748 0.00221873 1.50048 0.0021723C1.10262 0.00207854 0.721022 0.160037 0.439627 0.441299C0.158232 0.722561 9.38099e-05 1.10409 4.17235e-08 1.50195C-9.37265e-05 1.8998 0.157865 2.2814 0.439127 2.5628L9.70013 11.8248C9.72341 11.848 9.74188 11.8756 9.75448 11.906C9.76709 11.9364 9.77357 11.9689 9.77357 12.0018C9.77357 12.0347 9.76709 12.0672 9.75448 12.0976C9.74188 12.128 9.72341 12.1556 9.70013 12.1788L0.439127 21.4418C0.29986 21.5811 0.189401 21.7465 0.114055 21.9286C0.0387096 22.1106 -4.63876e-05 22.3057 4.17235e-08 22.5027C9.38099e-05 22.9005 0.158232 23.282 0.439627 23.5633C0.57896 23.7026 0.744358 23.813 0.92638 23.8884C1.1084 23.9637 1.30348 24.0025 1.50048 24.0024C1.89834 24.0023 2.27987 23.8442 2.56113 23.5628L11.8231 14.2998C11.8463 14.2765 11.8739 14.258 11.9043 14.2454C11.9347 14.2328 11.9672 14.2264 12.0001 14.2264C12.033 14.2264 12.0656 14.2328 12.0959 14.2454C12.1263 14.258 12.1539 14.2765 12.1771 14.2998L21.4391 23.5628C21.7204 23.8442 22.1019 24.0023 22.4998 24.0024C22.8976 24.0025 23.2792 23.8446 23.5606 23.5633C23.842 23.282 24.0002 22.9005 24.0003 22.5027C24.0003 22.1048 23.8424 21.7232 23.5611 21.4418L14.3001 12.1788Z" fill="black" fill-opacity="0.25"></path>
                                            </svg>
                                        </button>
                                        <h2><?php echo t('Discount');?></h2>
                                        <div class="flTable__detail" style="margin-top: 10px">
                                            <?php echo $discount_html;?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endif;?>
                        <?php $ii++;  endif;?>
                       <?php endforeach;?>
                <?php endif;?>
                <input type="hidden" name="min" value="<?php echo show_price($min_all)?>">
                <input type="hidden" name="max" value="<?php echo show_price($max_all)?>">

            </div>

            <div class="cruiseResult__group showMobile">
                <?php if(count($data) > 0):?>
                    <?php $ii = 0; foreach ($data as $ob):
                        $num_day = substr($ob['type_itinerary'],0,1);
                        $num_day = filter_var($num_day,FILTER_SANITIZE_NUMBER_INT) - 1;
                        if($num_day < 0) {
                            $num_day = 1;
                        }
                        $price = $ob['min_price'] * $num_day ;
                        if($price < $min_all) {
                            $min_all = $price;
                        }
                        if($price > $max_all) {
                            $max_all = $price;
                        }

                        $idx = rand(0,2);
                        $p = $percents[$idx];
                        $percent = $percents[$idx];

                        //$con_lai = $price;
                        //$chua_giam_gia = $tien_giam + $con_lai;


                        $itinerary_text = str_replace(' ','',strtolower($ob['itinerary_text']));
                        $itinerary_text = convert_vn2latin($itinerary_text);
                        // chuyển sang in thường

                        $itinerary_text = trim($itinerary_text);
                        $is_show = false;
                        if($ob['type_itinerary'] == $duration) {
                            $is_show = true;
                        }

                        $discount_for_cruise = null;
                        $discount_per_adult = $discount_value_default;
                        $discount_html = '';
                        for($d = 0; $d < count($discount); $d++) {
                            if( (in_array($ob['cruise_nid'],$discount[$d]['cruise'])) || count($discount[$d]['cruise']) == 0) {
                                //truong hop uu dai cho tau
                                if( (in_array($ob['type_itinerary'],$discount[$d]['hanh_trinh']) ) || count($discount[$d]['hanh_trinh']) == 0 ) {

                                    if($discount[$d]['so_tien_giam'] > $discount_per_adult ) {
                                        $discount_per_adult = $discount[$d]['so_tien_giam'];

                                    }
                                    $discount_html .= '<div class="discount-item" style="margin-bottom: 10px;padding-bottom:10px;border-bottom: 1px dashed #ccc">'.$discount[$d]['body'].'</div>';
                                }
                            }

                        }

                        $da_giam_gia = 0;
                        if($discount_per_adult > 0) {
                            $da_giam_gia = ($ob['min_price'] - $discount_per_adult) * $num_day ;
                        }



                        ?>
                        <?php if($is_show):?>
                        <div min_price="<?php echo $ob['min_price']?>" class="cruiseResult__table__row" nid="<?php echo $ob['nid']?>" cruise_id="<?php echo $ob['cruise_nid']?>" itinerary="<?php echo $itinerary_text ?>" price="<?php echo $price?>" star="<?php echo $ob['star']?>" point="<?php echo isset($ob['point'])?$ob['point']:''?>" >
                            <div class="cruiseResult__table__left">
                                <div class="cruiseResult__table__cell">
                                    <img src="<?php echo isset($ob['cruise_img'][0])?$ob['cruise_img'][0]:''?>" />
                                </div>
                                <div class="cruiseResult__table__cell">
                                    <ul class="ulGroup__text">
                                        <?php if($ii < 5):?>
                                        <li>
                                            <p class="tableTop__booked text12 blueP400 medium"><?php echo t('Top booked');?></p>
                                        </li>
                                        <?php endif;?>
                                        <li>
                                            <a href="<?php echo base_path().drupal_get_path_alias('cruise/'.$ob['cruise_nid'].'/'.$ob['nid'])?>?t=<?php echo $tran?>"  >
                                            <span class="text20 blueDark medium"><?php echo $ob['cruise_name'] .' - '.$ob['title']?></span>
                                            </a>
                                            <p class="tableIcon__star">
                                                <?php if(isset($ob['star'])):
                                                    echo html_star($ob['star']);
                                                    ?>

                                                <?php endif;?>
                                            </p>
                                        </li>
                                        <li>
                                            <div class="table__right__top">
                                                <p class="blueDark45"><?php echo isset($ob['review'])?$ob['review']:''?> <?php echo t('reviews');?></p>
                                                <p class="medium colorWhite"><?php echo isset($ob['point'])?$ob['point']:''?></p>
                                            </div>
                                        </li>
                                        <li>
                                            <p class="offers__address blueDark45 text12"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 10 14" fill="none">
                                                    <path d="M4.99967 0.333374C2.41967 0.333374 0.333008 2.42004 0.333008 5.00004C0.333008 8.50004 4.99967 13.6667 4.99967 13.6667C4.99967 13.6667 9.66634 8.50004 9.66634 5.00004C9.66634 2.42004 7.57967 0.333374 4.99967 0.333374ZM4.99967 6.66671C4.07967 6.66671 3.33301 5.92004 3.33301 5.00004C3.33301 4.08004 4.07967 3.33337 4.99967 3.33337C5.91967 3.33337 6.66634 4.08004 6.66634 5.00004C6.66634 5.92004 5.91967 6.66671 4.99967 6.66671Z" fill="#5562DA"></path>
                                                </svg><?php echo $ob['itinerary_text']?></p>
                                        </li>

                                        <li>
                                            <div class="table__right__down">
                                                <?php if($da_giam_gia > 0):?>
                                                    <p class="blueDark medium gia_goc price_not_dicount"><?php echo show_price($price,0,true);?></p>
                                                    <div class="small"><a target="_blank" href="<?php echo  base_path().'Hot-deals'?>" ><?php echo t('View more');?></a></div>
                                                    <p class="green400 gia_uu_dai text24 medium"><?php echo show_price($da_giam_gia,0,true)?></p>
                                                <?php else:?>
                                                    <div class="price_all_cruise">
                                                        <p class="blueDark45 text14 medium mr5"><?php echo $text_from_money?></p>
                                                        <p class="green400 text24 medium gia_goc"><?php echo show_price($price,0,true);?></p>
                                                    </div>
                                                <?php endif;?>
                                            </div>
                                        </li>
                                        <li><p class="blueDark medium"><?php echo t('Per pax');?></p></li>
                                        <a href="<?php echo base_path().drupal_get_path_alias('cruise/'.$ob['cruise_nid'].'/'.$ob['nid'])?>?t=<?php echo $tran?>&did=<?php echo $discount_nid?>"  name="home_search" class="btn btn-orange w120"><?php echo t('View More');?></a>
                                    </ul>
                                </div>
                            </div>

                            <?php if($discount_html !=''):?>
                                <div id="popup_discount_mobi_<?php echo $ob['nid']?>" class="popup_discount modal fade">
                                    <div class="modal-dialog" >
                                        <div class="modal-content">
                                            <div class="modal-body" style="padding: 50px">
                                                <button type="button" data-dismiss="modal" class="close">
                                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="svg1point5">
                                                        <path d="M14.3001 12.1788C14.2768 12.1556 14.2584 12.128 14.2458 12.0976C14.2332 12.0672 14.2267 12.0347 14.2267 12.0018C14.2267 11.9689 14.2332 11.9364 14.2458 11.906C14.2584 11.8756 14.2768 11.848 14.3001 11.8248L23.5631 2.5628C23.8444 2.28114 24.0022 1.89928 24.002 1.50124C24.0017 1.10319 23.8433 0.721561 23.5616 0.440299C23.28 0.159037 22.8981 0.00118392 22.5001 0.00146522C22.102 0.00174652 21.7204 0.160139 21.4391 0.441799L12.1771 9.6998C12.1539 9.72308 12.1263 9.74155 12.0959 9.75416C12.0656 9.76676 12.033 9.77325 12.0001 9.77325C11.9672 9.77325 11.9347 9.76676 11.9043 9.75416C11.8739 9.74155 11.8463 9.72308 11.8231 9.6998L2.56113 0.441799C2.42186 0.302467 2.25651 0.191929 2.07453 0.116498C1.89254 0.0410666 1.69748 0.00221873 1.50048 0.0021723C1.10262 0.00207854 0.721022 0.160037 0.439627 0.441299C0.158232 0.722561 9.38099e-05 1.10409 4.17235e-08 1.50195C-9.37265e-05 1.8998 0.157865 2.2814 0.439127 2.5628L9.70013 11.8248C9.72341 11.848 9.74188 11.8756 9.75448 11.906C9.76709 11.9364 9.77357 11.9689 9.77357 12.0018C9.77357 12.0347 9.76709 12.0672 9.75448 12.0976C9.74188 12.128 9.72341 12.1556 9.70013 12.1788L0.439127 21.4418C0.29986 21.5811 0.189401 21.7465 0.114055 21.9286C0.0387096 22.1106 -4.63876e-05 22.3057 4.17235e-08 22.5027C9.38099e-05 22.9005 0.158232 23.282 0.439627 23.5633C0.57896 23.7026 0.744358 23.813 0.92638 23.8884C1.1084 23.9637 1.30348 24.0025 1.50048 24.0024C1.89834 24.0023 2.27987 23.8442 2.56113 23.5628L11.8231 14.2998C11.8463 14.2765 11.8739 14.258 11.9043 14.2454C11.9347 14.2328 11.9672 14.2264 12.0001 14.2264C12.033 14.2264 12.0656 14.2328 12.0959 14.2454C12.1263 14.258 12.1539 14.2765 12.1771 14.2998L21.4391 23.5628C21.7204 23.8442 22.1019 24.0023 22.4998 24.0024C22.8976 24.0025 23.2792 23.8446 23.5606 23.5633C23.842 23.282 24.0002 22.9005 24.0003 22.5027C24.0003 22.1048 23.8424 21.7232 23.5611 21.4418L14.3001 12.1788Z" fill="black" fill-opacity="0.25"></path>
                                                    </svg>
                                                </button>
                                                <h2><?php echo t('Discount');?></h2>
                                                <div class="flTable__detail" style="margin-top: 10px">
                                                    <?php echo $discount_html;?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif;?>
                        </div>
                        <?php $ii++; endif;?>

                        <?php endforeach;?>
                <?php endif;?>
                <input type="hidden" name="min" value="<?php echo show_price($min_all)?>">
                <input type="hidden" name="max" value="<?php echo show_price($max_all)?>">

            </div>

        </div>
    </div>
</div>


<!--<div id="popup_itinerary" class="modal fade" role='dialog' data-backdrop="false">-->
<!--    <div class="modal-dialog">-->
<!--        <div class="modal-content">-->
<!--            <div class="modal-header">-->
<!--                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>-->
<!--                <h4 class="modal-title">Tutorialsplane Modal Demo</h4>-->
<!--            </div>-->
<!--            <div class="modal-body">-->
<!--                <p>Here the description starts here........</p>-->
<!---->
<!--            </div>-->
<!--            <div class="modal-footer">-->
<!--                <button type="button" data-backdrop="false" class="btn btn-default" data-dismiss="modal">Close</button>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->

<!--Modal start--->
<div id="popup_itinerary" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <button type="button" data-dismiss="modal" class="close">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="svg1point5">
                        <path d="M14.3001 12.1788C14.2768 12.1556 14.2584 12.128 14.2458 12.0976C14.2332 12.0672 14.2267 12.0347 14.2267 12.0018C14.2267 11.9689 14.2332 11.9364 14.2458 11.906C14.2584 11.8756 14.2768 11.848 14.3001 11.8248L23.5631 2.5628C23.8444 2.28114 24.0022 1.89928 24.002 1.50124C24.0017 1.10319 23.8433 0.721561 23.5616 0.440299C23.28 0.159037 22.8981 0.00118392 22.5001 0.00146522C22.102 0.00174652 21.7204 0.160139 21.4391 0.441799L12.1771 9.6998C12.1539 9.72308 12.1263 9.74155 12.0959 9.75416C12.0656 9.76676 12.033 9.77325 12.0001 9.77325C11.9672 9.77325 11.9347 9.76676 11.9043 9.75416C11.8739 9.74155 11.8463 9.72308 11.8231 9.6998L2.56113 0.441799C2.42186 0.302467 2.25651 0.191929 2.07453 0.116498C1.89254 0.0410666 1.69748 0.00221873 1.50048 0.0021723C1.10262 0.00207854 0.721022 0.160037 0.439627 0.441299C0.158232 0.722561 9.38099e-05 1.10409 4.17235e-08 1.50195C-9.37265e-05 1.8998 0.157865 2.2814 0.439127 2.5628L9.70013 11.8248C9.72341 11.848 9.74188 11.8756 9.75448 11.906C9.76709 11.9364 9.77357 11.9689 9.77357 12.0018C9.77357 12.0347 9.76709 12.0672 9.75448 12.0976C9.74188 12.128 9.72341 12.1556 9.70013 12.1788L0.439127 21.4418C0.29986 21.5811 0.189401 21.7465 0.114055 21.9286C0.0387096 22.1106 -4.63876e-05 22.3057 4.17235e-08 22.5027C9.38099e-05 22.9005 0.158232 23.282 0.439627 23.5633C0.57896 23.7026 0.744358 23.813 0.92638 23.8884C1.1084 23.9637 1.30348 24.0025 1.50048 24.0024C1.89834 24.0023 2.27987 23.8442 2.56113 23.5628L11.8231 14.2998C11.8463 14.2765 11.8739 14.258 11.9043 14.2454C11.9347 14.2328 11.9672 14.2264 12.0001 14.2264C12.033 14.2264 12.0656 14.2328 12.0959 14.2454C12.1263 14.258 12.1539 14.2765 12.1771 14.2998L21.4391 23.5628C21.7204 23.8442 22.1019 24.0023 22.4998 24.0024C22.8976 24.0025 23.2792 23.8446 23.5606 23.5633C23.842 23.282 24.0002 22.9005 24.0003 22.5027C24.0003 22.1048 23.8424 21.7232 23.5611 21.4418L14.3001 12.1788Z" fill="black" fill-opacity="0.25"></path>
                    </svg>
                </button>
                <h2><?php echo t('Itinerary');?></h2>
                <div class="flTable__detail">
                    <p>Here the description starts here........</p>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Modal end--->




<script>
    $('document').ready(function () {
        $('.clear_fitler').click(function () {
            reset_filter();
        });
        $('.editSearch__time button').click(function () {
            $(this).parents('.homeRight').find('.searchBox').addClass('open');
        });
        $('.cruiseResult__title button.onTab').click(function () {
            $(this).parents('.homeRight').find('.cruiseResult__left').removeClass('open');
        });
        $('.closeSearch__cruise').click(function () {
            $(this).parents('.searchBox').removeClass('open');
        });
        $('.editSearch__filter button').click(function () {
            $(this).parents('.homeRight').find('.cruiseResult__left').addClass('open');
        });
        $('#popup_itinerary').on('shown.bs.modal', function (e) {
            // do something...
            var content = $(e.relatedTarget).parents('.cruiseResult__table__row').find('div.full_itinerary').html();
            console.log(content);
            $('#popup_itinerary .flTable__detail').html(content);

        });
        $('.cruiseResult__left input').click(function() {
                console.log('abcd');
                if($(this).hasClass('activities') && $(this).attr('id') == 'ai_all') {
                    $('input.activities[id != ai_all]').prop('checked',false);
                }
            if($(this).hasClass('activities') && $(this).attr('id') != 'ai_all') {
                $('#ai_all').prop('checked',false);
            }
            filter_cruise();
        });
        $('.cruiseResult__left .cruiseLeft__star').click(function () {
            $('.cruiseResult__left .cruiseLeft__star').removeClass('active');
            $(this).addClass('active');
            filter_cruise();
        });

        var currency = "USD";
        if($('#lang').val() == 'vi') {
            currency = 'VND';
        }
        var min_max = get_max_price();
        if(currency == 'USD') {
            $('#min_all').text(currency + ' ' + min_max['min']);
            $('#max_all').text(currency + ' ' + min_max['max']);
        } else {

            $('#min_all').text(min_max['min'].toString().replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",") + ' ' + currency);
            $('#max_all').text(min_max['max'].toString().replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ",") + ' ' + currency);
        }






        function triggerModal(t){
            var id = $(t).parents('.cruiseResult__table__row').find('div.popup_discount').attr('id');
            console.log(id);
            $('#' + id).modal('toggle');
            console.log($(t));
            //const myModalEl = document.getElementById('exampleModal');
            // const modal = new mdb.Modal(myModalEl);
            // modal.toggle();
        }
    });

    function reset_filter  () {
        $('.cruiseResult__filter input[type=checkbox]').prop('checked',false);
        $('.cruiseResult__filter input[type=radio]').prop('checked',false);
        $('.cruiseLeft__star').removeClass('active');
    }

    function  filter_cruise() {
        console.log('fitler');
        var min = $('.cruiseResult__left input[name=price]:checked').parents('.checkbox').attr('min');
        var max = $('.cruiseResult__left input[name=price]:checked').parents('.checkbox').attr('max');

        var currency = "USD";
        if($('#lang').val() == 'vi') {
            currency = 'VND';
        }

        if(min == '' || min == undefined) {
            min = $('input[name=min]').val().replace(/[^0-9]/g,'');
            console.log(min);
        }
        if(max == '' || max == undefined ) {
            max = $('input[name=max]').val().replace(/[^0-9]/g,'');
        }
        min = parseFloat(min);
        max = parseFloat(max);



        var star = $('.cruiseResult__left .cruiseLeft__star.active').attr('star');

        var point = $('.cruiseResult__left input[name=fl]:checked').val();
        var filter_Itinerary = $('.cruiseResult__left input[name=filter_Itinerary]:checked').val();
        var activity = $('.activities:checked');
        var activity_arr = [];
        if(activity.length > 0) {
            for(var i = 0; i < activity.length; i++) {
                if( $(activity[i]).val().length > 2 && $(activity[i]).val() != '' && $(activity[i]).val() != undefined ) {
                    activity_arr[i] = $(activity[i]).val();
                }
            }
        }


        var parent_cls = '';
        if( screen.width >= 500 ) {
            parent_cls = '.showDesktop';
        } else {
            parent_cls = '.showMobile';
        }

        var cruiseResult__table__row = $(parent_cls + ' .cruiseResult__table__row');
        if(cruiseResult__table__row.length > 0) {
            for (var i = 0; i < cruiseResult__table__row.length; i++) {
                var price = $(cruiseResult__table__row[i]).attr('price');
                var cruise_id = $(cruiseResult__table__row[i]).attr('cruise_id');
                var others_price = $(cruiseResult__table__row[i]).attr('others_price');
                var other_price_da_giam_gia = $(cruiseResult__table__row[i]).attr('other_price_da_giam_gia');
                price = parseFloat(price);
                var my_star = $(cruiseResult__table__row[i]).attr('star');
                var my_point = $(cruiseResult__table__row[i]).attr('point');
                var my_activity_str = $(cruiseResult__table__row[i]).find('input.relax').val();
                var nid = $(cruiseResult__table__row[i]).attr('nid');
                //console.log(my_activity);
                var my_activity = [];
                if(my_activity_str != '' && my_activity_str != undefined) {
                    var temp = my_activity_str.split(',');
                    if(temp.length > 0) {
                        var aa = 0;
                        for(var a = 0; a < temp.length; a++) {
                            if(temp[a] != '') {
                                my_activity[aa] = temp[a].trim();
                                aa++;
                            }
                        }
                    }
                }


                var my_Itinerary = $(cruiseResult__table__row[i]).attr('itinerary');


                var is_show = true;
                if(price < min || price > max) {
                    is_show = false;
                }




                if(others_price != undefined && others_price != '') {
                    others_price = JSON.parse(others_price);
                    other_price_da_giam_gia = JSON.parse(other_price_da_giam_gia);
                    if(others_price.length > 0) {
                        others_price.sort();

                        for(var p = 0; p < others_price.length; p++) {
                            others_price[p] = others_price[p].toString().replace(/[^0-9]/g,'');
                            if(parseFloat(others_price[p]) >= min && parseFloat(others_price[p]) <= max) {
                                is_show = true;


                                $(parent_cls + ' .cruiseResult__table__row[cruise_id='+cruise_id+'] .gia_goc .price_value').text(others_price[p].toString().replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                                $(parent_cls + ' .cruiseResult__table__row[cruise_id='+cruise_id+'] .gia_uu_dai .price_value').text(other_price_da_giam_gia[p].toString().replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ","));
                               // $('.gia_goc .price_value').text(others_price[p]);
                               // $('.gia_uu_dai .price_value').text(other_price_da_giam_gia[p]);
                                break;
                            }

                        }
                    }
                }

                if(star != '' && star != undefined && star > 0) {
                    if(my_star != star) {
                        is_show = false;
                    }
                }
                //console.log('point:' + point);
                //console.log('my point:' + my_point);
                if(point != '' && point != undefined && point > 0) {
                    is_show = false;
                    if(parseFloat(my_point) >= parseFloat(point) ) {
                        is_show = true;
                    }
                }

                if(filter_Itinerary != '' && filter_Itinerary != undefined ) {
                    //console.log(filter_Itinerary);
                    //console.log(my_Itinerary);

                    if(filter_Itinerary.trim() != my_Itinerary.trim() ) {

                        is_show = false;
                        console.log('FAILED');
                    } else {
                        console.log('OK');
                    }

                    console.log(is_show);


                }
                console.log('show cruise id: ' + $(cruiseResult__table__row[i]).attr('cruise_id'));
                if(is_show) {
                    if(activity_arr.length > 0 ) {
                        for (var a = 0; a < activity_arr.length; a++) {
                            var activity_selected = activity_arr[a];
                            var idx = my_activity.indexOf(activity_selected);
                            console.log(activity_selected);
                            console.log(idx);

                            if(activity_selected != '' && my_activity.indexOf(activity_selected) > 0) {


                                is_show = true;
                                break;

                            } else {
                                console.log('hide cruise id: ' + $(cruiseResult__table__row[i]).attr('cruise_id'));
                                is_show = false;
                            }
                            console.log('#########################');
                        }
                    }
                }



                console.log(activity_arr);
                console.log(my_activity);

                console.log(is_show);
                console.log('-----------------------------------------');

                if(is_show ) {
                    $(cruiseResult__table__row[i]).removeClass('d-none');
                } else {
                    $(cruiseResult__table__row[i]).addClass('d-none');
                }


            }
        }


    }

    function filter_price(min,max) {

        var cruiseResult__table__row = $('.cruiseResult__table__row');
        if(cruiseResult__table__row.length > 0) {
            for(var i = 0; i < cruiseResult__table__row.length; i++) {
                if(min == '' && max == '') {
                    $(cruiseResult__table__row[i]).removeClass('d-none');
                } else {
                    if($(cruiseResult__table__row[i]).hasClass('d-none') == false) {
                        var price = $(cruiseResult__table__row[i]).attr('price');
                        if(max > 0) {
                            if(price >= min && price <= max) {
                                $(cruiseResult__table__row[i]).removeClass('d-none');
                            } else {
                                $(cruiseResult__table__row[i]).addClass('d-none');
                            }
                        } else {
                            console.log(price);
                            if(price > min ) {
                                $(cruiseResult__table__row[i]).removeClass('d-none');
                            } else {
                                $(cruiseResult__table__row[i]).addClass('d-none');
                            }
                        }

                    }
                }

            }
        }
    }

    function  get_max_price() {
        var cruiseResult__table__row = $('.cruiseResult__table__row');
        var max = 0;
        var min = 999999999999999999999999999999999999;
        for(var i = 0; i < cruiseResult__table__row.length; i++) {
            var temp = $(cruiseResult__table__row[i]).attr('others_price');
            if(temp && temp != '') {

                var temp2 = JSON.parse(temp);// temp.split(',');
                console.log(temp2);
                for(var j = 0; j < temp2.length; j++) {
                    if(temp2[j] != '') {
                        var p = parseFloat(temp2[j]);
                        if(p > max) {
                            max = p;
                        }
                        if(p < min) {
                            min = p;
                        }
                    }

                }
            }
        }
        console.log(min+ '--' + max);
        return {max:max,min:min};
    }


</script>