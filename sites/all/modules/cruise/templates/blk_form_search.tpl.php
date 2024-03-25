<?php
global $conf;
$max_room = 5;
$cruise_current = null;
$type_itinerary = null;
if(arg(0) == 'cruise' && arg(1) > 0 ) {
    $cruise_id_current_id = arg(1);
    $cruise = detail_cruise($cruise_id_current_id);
    $cruise_current = $cruise['info'];

    if(arg(2) > 0) {
        $itinerary_id = arg(2);

    } else {
        $itinerary_id = array_keys($cruise['itinerary'])[0];

    }

    if(isset($cruise['itinerary'][$itinerary_id])) {
        $itinerary_current = $cruise['itinerary'][$itinerary_id];//print_r($itinerary_current);die;
        $type_itinerary = $itinerary_current['field_type_itinerary']['und'][0]['value'];
    }


}


$frm_path = '';
if(arg(0) == 'cruise' && arg(1) > 0 && arg(2) > 0) {
    $frm_path = base_path().'cruise/'.arg(1).'/'.arg(2);
} else {
    $frm_path = base_path().'cruise/0';
}
$depart = '';
$search_param = array();
if(isset($_SESSION['search_param']) && isset($_REQUEST['t']) && $_REQUEST['t'] > 0) {
    var_dump($conf['CRUISE_DURATION'],$conf['CRUISE_DURATION'][$type_itinerary]);
    $tran = $_REQUEST['t'];
    $depart = $_SESSION['search_param'][$tran]['depart'];
    $search_param = $_SESSION['search_param'][$tran];
    $no_room = $search_param['no_room'];
    $adult = $search_param['adult'];
    $child = $search_param['child'];
    $infant = $search_param['infant'];
    $travel = 0;
    for ($i = 0; $i < $no_room; $i++) {
        $travel += $adult[$i] + $child[$i] + $infant[$i];
    }

}

?>

<form method="post" action="<?php echo $frm_path?>" id="frm-search-cruise">
    <div class="searchBox">
        <div class="searchBox__main">
            <div class="searchBox__select">
                <div class="searchBox__header showMobile">
                    <?php if(arg(0)  != ''):?>
                        <svg class="closeSearch__cruise" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none">
                            <path d="M13 1L1 13" stroke="#5C6AA1" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M1 1L13 13" stroke="#5C6AA1" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    <?php endif;?>
                    <p class="medium text28 blueDark"><?php echo t('Cruise with confidence');?></p>
                    <p class="blueDark"><?php echo t('Easily compare prices from multiple cruise line in Ha Long Bay with one click');?></p>
                </div>
                <div class="searchBox__header showDesktop">
                    <p class="medium text28 blueDark"><?php echo t('Cruise with confidence');?></p>
                    <p class="blueDark"><?php echo t('Easily compare prices from multiple cruise line in Ha Long Bay with one click');?></p>
                </div>
                <div class="searchBox__body">
                    <div class="searchBox__cont">
                        <div class="noMulti">
                            <div class="searchBox__form">
                                <div class="searchBox__from pd4 col4">
                                    <div class="searchBox__input">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="11" viewBox="0 0 24 11" fill="none">
                                            <path d="M1.22794 5H22.7711C22.9108 5 23.0386 5.08349 23.1021 5.21599C23.1656 5.34853 23.1537 5.50796 23.0713 5.62822L20.0998 9.97986C20.03 10.0823 19.9189 10.1429 19.8 10.1429C18.0231 10.1429 4.27739 10.1429 3.08252 10.1429C3.02641 10.1429 2.97182 10.129 2.92168 10.1025C1.10314 9.1357 0.856865 7.18256 0.856865 5.39883C0.856516 5.17918 1.02218 5 1.22794 5ZM18.3139 6.38462C18.3139 6.4938 18.3971 6.58244 18.4997 6.58244H18.8711C18.9736 6.58244 19.0568 6.49385 19.0568 6.38462V5.98904C19.0568 5.87986 18.9736 5.79122 18.8711 5.79122H18.4997C18.3972 5.79122 18.3139 5.87981 18.3139 5.98904V6.38462ZM16.8282 6.38462C16.8282 6.4938 16.9114 6.58244 17.0139 6.58244H17.3854C17.4879 6.58244 17.5711 6.49385 17.5711 6.38462V5.98904C17.5711 5.87986 17.4879 5.79122 17.3854 5.79122H17.0139C16.9114 5.79122 16.8282 5.87981 16.8282 5.98904V6.38462ZM15.3425 6.38462C15.3425 6.4938 15.4257 6.58244 15.5282 6.58244H15.8996C16.0021 6.58244 16.0854 6.49385 16.0854 6.38462V5.98904C16.0854 5.87986 16.0022 5.79122 15.8996 5.79122H15.5282C15.4257 5.79122 15.3425 5.87981 15.3425 5.98904V6.38462ZM13.8567 6.38462C13.8567 6.4938 13.9399 6.58244 14.0424 6.58244H14.4139C14.5164 6.58244 14.5996 6.49385 14.5996 6.38462V5.98904C14.5996 5.87986 14.5164 5.79122 14.4139 5.79122H14.0424C13.9399 5.79122 13.8567 5.87981 13.8567 5.98904V6.38462ZM12.371 6.38462C12.371 6.4938 12.4542 6.58244 12.5567 6.58244H12.9281C13.0306 6.58244 13.1139 6.49385 13.1139 6.38462V5.98904C13.1139 5.87986 13.0307 5.79122 12.9281 5.79122H12.5567C12.4542 5.79122 12.371 5.87981 12.371 5.98904V6.38462ZM10.8853 6.38462C10.8853 6.4938 10.9684 6.58244 11.071 6.58244H11.4424C11.5449 6.58244 11.6281 6.49385 11.6281 6.38462V5.98904C11.6281 5.87986 11.545 5.79122 11.4424 5.79122H11.071C10.9685 5.79122 10.8853 5.87981 10.8853 5.98904V6.38462ZM9.39949 6.38462C9.39949 6.4938 9.48267 6.58244 9.58522 6.58244H9.95664C10.0592 6.58244 10.1424 6.49385 10.1424 6.38462V5.98904C10.1424 5.87986 10.0592 5.79122 9.95664 5.79122H9.58522C9.48271 5.79122 9.39949 5.87981 9.39949 5.98904V6.38462ZM7.91376 6.38462C7.91376 6.4938 7.99695 6.58244 8.0995 6.58244H8.47092C8.57343 6.58244 8.65665 6.49385 8.65665 6.38462V5.98904C8.65665 5.87986 8.57347 5.79122 8.47092 5.79122H8.0995C7.99699 5.79122 7.91376 5.87981 7.91376 5.98904V6.38462ZM6.42804 6.38462C6.42804 6.4938 6.51122 6.58244 6.61377 6.58244H6.98519C7.0877 6.58244 7.17092 6.49385 7.17092 6.38462V5.98904C7.17092 5.87986 7.08774 5.79122 6.98519 5.79122H6.61377C6.51126 5.79122 6.42804 5.87981 6.42804 5.98904V6.38462ZM4.94227 6.38462C4.94227 6.4938 5.02545 6.58244 5.128 6.58244H5.49942C5.60193 6.58244 5.68516 6.49385 5.68516 6.38462V5.98904C5.68516 5.87986 5.60197 5.79122 5.49942 5.79122H5.128C5.0255 5.79122 4.94227 5.87981 4.94227 5.98904V6.38462ZM3.45655 6.38462C3.45655 6.4938 3.53973 6.58244 3.64228 6.58244H4.0137C4.11621 6.58244 4.19943 6.49385 4.19943 6.38462V5.98904C4.19943 5.87986 4.11625 5.79122 4.0137 5.79122H3.64228C3.53977 5.79122 3.45655 5.87981 3.45655 5.98904V6.38462Z" fill="#5C6AA1"/>
                                            <path d="M4.01455 2.1473L4.25783 1.52255C4.31315 1.37991 4.45061 1.28593 4.60365 1.28593H6.05669V0.357362C6.05669 0.254855 6.13987 0.171631 6.24242 0.171631H6.61384C6.71634 0.171631 6.79957 0.254812 6.79957 0.357362V1.28593H8.65675V0.357362C8.65675 0.254855 8.73994 0.171631 8.84249 0.171631H9.21391C9.31641 0.171631 9.39964 0.254812 9.39964 0.357362V1.28593H11.2568V0.357362C11.2568 0.254855 11.34 0.171631 11.4426 0.171631H11.814C11.9165 0.171631 11.9997 0.254812 11.9997 0.357362V1.28593H13.5404C13.6934 1.28593 13.8309 1.37991 13.8866 1.52255L14.1299 2.14695C14.177 2.26878 14.0872 2.40028 13.9567 2.40028H4.18766C4.0569 2.40028 3.96702 2.26878 4.01455 2.1473Z" fill="#5C6AA1"/>
                                            <path d="M2.43055 4.00966L2.65045 3.39009C2.70281 3.24187 2.84323 3.14307 3.00032 3.14307H17.4261C17.5833 3.14307 17.7236 3.24187 17.776 3.39009L17.9959 4.00926C18.039 4.13036 17.9494 4.25737 17.8213 4.25737H2.60548C2.47734 4.25741 2.38745 4.1304 2.43055 4.00966Z" fill="#5C6AA1"/>
                                        </svg>
                                        <input type="text" autocomplete="off" id="keyword" placeholder="<?php echo t('Cruise name');?>" value="<?php echo ($cruise_current)?$cruise_current['title']:''?>" class="form-control form-control-lg inputPlace">
                                        <div class="suggestion 111">
    <!--                                        <ul class="suggestion__list">-->
    <!--                                            <li>-->
    <!--                                                <button type="button">-->
    <!--                                                                <span class="cruise" cid="all" name="All Cruises"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="11" viewBox="0 0 24 11" fill="none"><path d="M1.22794 5H22.7711C22.9108 5 23.0386 5.08349 23.1021 5.21599C23.1656 5.34853 23.1537 5.50796 23.0713 5.62822L20.0998 9.97986C20.03 10.0823 19.9189 10.1429 19.8 10.1429C18.0231 10.1429 4.27739 10.1429 3.08252 10.1429C3.02641 10.1429 2.97182 10.129 2.92168 10.1025C1.10314 9.1357 0.856865 7.18256 0.856865 5.39883C0.856516 5.17918 1.02218 5 1.22794 5ZM18.3139 6.38462C18.3139 6.4938 18.3971 6.58244 18.4997 6.58244H18.8711C18.9736 6.58244 19.0568 6.49385 19.0568 6.38462V5.98904C19.0568 5.87986 18.9736 5.79122 18.8711 5.79122H18.4997C18.3972 5.79122 18.3139 5.87981 18.3139 5.98904V6.38462ZM16.8282 6.38462C16.8282 6.4938 16.9114 6.58244 17.0139 6.58244H17.3854C17.4879 6.58244 17.5711 6.49385 17.5711 6.38462V5.98904C17.5711 5.87986 17.4879 5.79122 17.3854 5.79122H17.0139C16.9114 5.79122 16.8282 5.87981 16.8282 5.98904V6.38462ZM15.3425 6.38462C15.3425 6.4938 15.4257 6.58244 15.5282 6.58244H15.8996C16.0021 6.58244 16.0854 6.49385 16.0854 6.38462V5.98904C16.0854 5.87986 16.0022 5.79122 15.8996 5.79122H15.5282C15.4257 5.79122 15.3425 5.87981 15.3425 5.98904V6.38462ZM13.8567 6.38462C13.8567 6.4938 13.9399 6.58244 14.0424 6.58244H14.4139C14.5164 6.58244 14.5996 6.49385 14.5996 6.38462V5.98904C14.5996 5.87986 14.5164 5.79122 14.4139 5.79122H14.0424C13.9399 5.79122 13.8567 5.87981 13.8567 5.98904V6.38462ZM12.371 6.38462C12.371 6.4938 12.4542 6.58244 12.5567 6.58244H12.9281C13.0306 6.58244 13.1139 6.49385 13.1139 6.38462V5.98904C13.1139 5.87986 13.0307 5.79122 12.9281 5.79122H12.5567C12.4542 5.79122 12.371 5.87981 12.371 5.98904V6.38462ZM10.8853 6.38462C10.8853 6.4938 10.9684 6.58244 11.071 6.58244H11.4424C11.5449 6.58244 11.6281 6.49385 11.6281 6.38462V5.98904C11.6281 5.87986 11.545 5.79122 11.4424 5.79122H11.071C10.9685 5.79122 10.8853 5.87981 10.8853 5.98904V6.38462ZM9.39949 6.38462C9.39949 6.4938 9.48267 6.58244 9.58522 6.58244H9.95664C10.0592 6.58244 10.1424 6.49385 10.1424 6.38462V5.98904C10.1424 5.87986 10.0592 5.79122 9.95664 5.79122H9.58522C9.48271 5.79122 9.39949 5.87981 9.39949 5.98904V6.38462ZM7.91376 6.38462C7.91376 6.4938 7.99695 6.58244 8.0995 6.58244H8.47092C8.57343 6.58244 8.65665 6.49385 8.65665 6.38462V5.98904C8.65665 5.87986 8.57347 5.79122 8.47092 5.79122H8.0995C7.99699 5.79122 7.91376 5.87981 7.91376 5.98904V6.38462ZM6.42804 6.38462C6.42804 6.4938 6.51122 6.58244 6.61377 6.58244H6.98519C7.0877 6.58244 7.17092 6.49385 7.17092 6.38462V5.98904C7.17092 5.87986 7.08774 5.79122 6.98519 5.79122H6.61377C6.51126 5.79122 6.42804 5.87981 6.42804 5.98904V6.38462ZM4.94227 6.38462C4.94227 6.4938 5.02545 6.58244 5.128 6.58244H5.49942C5.60193 6.58244 5.68516 6.49385 5.68516 6.38462V5.98904C5.68516 5.87986 5.60197 5.79122 5.49942 5.79122H5.128C5.0255 5.79122 4.94227 5.87981 4.94227 5.98904V6.38462ZM3.45655 6.38462C3.45655 6.4938 3.53973 6.58244 3.64228 6.58244H4.0137C4.11621 6.58244 4.19943 6.49385 4.19943 6.38462V5.98904C4.19943 5.87986 4.11625 5.79122 4.0137 5.79122H3.64228C3.53977 5.79122 3.45655 5.87981 3.45655 5.98904V6.38462Z" fill="#5C6AA1"></path><path d="M4.01455 2.1473L4.25783 1.52255C4.31315 1.37991 4.45061 1.28593 4.60365 1.28593H6.05669V0.357362C6.05669 0.254855 6.13987 0.171631 6.24242 0.171631H6.61384C6.71634 0.171631 6.79957 0.254812 6.79957 0.357362V1.28593H8.65675V0.357362C8.65675 0.254855 8.73994 0.171631 8.84249 0.171631H9.21391C9.31641 0.171631 9.39964 0.254812 9.39964 0.357362V1.28593H11.2568V0.357362C11.2568 0.254855 11.34 0.171631 11.4426 0.171631H11.814C11.9165 0.171631 11.9997 0.254812 11.9997 0.357362V1.28593H13.5404C13.6934 1.28593 13.8309 1.37991 13.8866 1.52255L14.1299 2.14695C14.177 2.26878 14.0872 2.40028 13.9567 2.40028H4.18766C4.0569 2.40028 3.96702 2.26878 4.01455 2.1473Z" fill="#5C6AA1"></path>-->
    <!--                                                                    <path d="M2.43055 4.00966L2.65045 3.39009C2.70281 3.24187 2.84323 3.14307 3.00032 3.14307H17.4261C17.5833 3.14307 17.7236 3.24187 17.776 3.39009L17.9959 4.00926C18.039 4.13036 17.9494 4.25737 17.8213 4.25737H2.60548C2.47734 4.25741 2.38745 4.1304 2.43055 4.00966Z" fill="#5C6AA1"></path>-->
    <!--                                                                    </svg>--><?php //echo t('All Cruises')?><!--</span>-->
    <!--                                                </button>-->
    <!--                                            </li>-->
    <!--                                        </ul>-->
                                            <?php $list_cruise = list_cruise(); ?>
                                            <?php if(count($list_cruise) > 0):?>
                                            <ul class="suggestion__list">
                                                <?php $i = 0;foreach ($list_cruise as $cruise)://print_r($cruise);die;?>
                                                    <?php if($i % 2 == 0):?>
                                                        <li><button type="button">
                                                    <?php endif;?>
                                                    <span class="cruise" field_full_day_cruise="<?php echo  isset($cruise['field_full_day_cruise']['und'][0]['value'])?$cruise['field_full_day_cruise']['und'][0]['value']:''?>" cid="<?php echo $cruise['nid']?>" name="<?php echo trim($cruise['title'])?>"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="11" viewBox="0 0 24 11" fill="none"><path d="M1.22794 5H22.7711C22.9108 5 23.0386 5.08349 23.1021 5.21599C23.1656 5.34853 23.1537 5.50796 23.0713 5.62822L20.0998 9.97986C20.03 10.0823 19.9189 10.1429 19.8 10.1429C18.0231 10.1429 4.27739 10.1429 3.08252 10.1429C3.02641 10.1429 2.97182 10.129 2.92168 10.1025C1.10314 9.1357 0.856865 7.18256 0.856865 5.39883C0.856516 5.17918 1.02218 5 1.22794 5ZM18.3139 6.38462C18.3139 6.4938 18.3971 6.58244 18.4997 6.58244H18.8711C18.9736 6.58244 19.0568 6.49385 19.0568 6.38462V5.98904C19.0568 5.87986 18.9736 5.79122 18.8711 5.79122H18.4997C18.3972 5.79122 18.3139 5.87981 18.3139 5.98904V6.38462ZM16.8282 6.38462C16.8282 6.4938 16.9114 6.58244 17.0139 6.58244H17.3854C17.4879 6.58244 17.5711 6.49385 17.5711 6.38462V5.98904C17.5711 5.87986 17.4879 5.79122 17.3854 5.79122H17.0139C16.9114 5.79122 16.8282 5.87981 16.8282 5.98904V6.38462ZM15.3425 6.38462C15.3425 6.4938 15.4257 6.58244 15.5282 6.58244H15.8996C16.0021 6.58244 16.0854 6.49385 16.0854 6.38462V5.98904C16.0854 5.87986 16.0022 5.79122 15.8996 5.79122H15.5282C15.4257 5.79122 15.3425 5.87981 15.3425 5.98904V6.38462ZM13.8567 6.38462C13.8567 6.4938 13.9399 6.58244 14.0424 6.58244H14.4139C14.5164 6.58244 14.5996 6.49385 14.5996 6.38462V5.98904C14.5996 5.87986 14.5164 5.79122 14.4139 5.79122H14.0424C13.9399 5.79122 13.8567 5.87981 13.8567 5.98904V6.38462ZM12.371 6.38462C12.371 6.4938 12.4542 6.58244 12.5567 6.58244H12.9281C13.0306 6.58244 13.1139 6.49385 13.1139 6.38462V5.98904C13.1139 5.87986 13.0307 5.79122 12.9281 5.79122H12.5567C12.4542 5.79122 12.371 5.87981 12.371 5.98904V6.38462ZM10.8853 6.38462C10.8853 6.4938 10.9684 6.58244 11.071 6.58244H11.4424C11.5449 6.58244 11.6281 6.49385 11.6281 6.38462V5.98904C11.6281 5.87986 11.545 5.79122 11.4424 5.79122H11.071C10.9685 5.79122 10.8853 5.87981 10.8853 5.98904V6.38462ZM9.39949 6.38462C9.39949 6.4938 9.48267 6.58244 9.58522 6.58244H9.95664C10.0592 6.58244 10.1424 6.49385 10.1424 6.38462V5.98904C10.1424 5.87986 10.0592 5.79122 9.95664 5.79122H9.58522C9.48271 5.79122 9.39949 5.87981 9.39949 5.98904V6.38462ZM7.91376 6.38462C7.91376 6.4938 7.99695 6.58244 8.0995 6.58244H8.47092C8.57343 6.58244 8.65665 6.49385 8.65665 6.38462V5.98904C8.65665 5.87986 8.57347 5.79122 8.47092 5.79122H8.0995C7.99699 5.79122 7.91376 5.87981 7.91376 5.98904V6.38462ZM6.42804 6.38462C6.42804 6.4938 6.51122 6.58244 6.61377 6.58244H6.98519C7.0877 6.58244 7.17092 6.49385 7.17092 6.38462V5.98904C7.17092 5.87986 7.08774 5.79122 6.98519 5.79122H6.61377C6.51126 5.79122 6.42804 5.87981 6.42804 5.98904V6.38462ZM4.94227 6.38462C4.94227 6.4938 5.02545 6.58244 5.128 6.58244H5.49942C5.60193 6.58244 5.68516 6.49385 5.68516 6.38462V5.98904C5.68516 5.87986 5.60197 5.79122 5.49942 5.79122H5.128C5.0255 5.79122 4.94227 5.87981 4.94227 5.98904V6.38462ZM3.45655 6.38462C3.45655 6.4938 3.53973 6.58244 3.64228 6.58244H4.0137C4.11621 6.58244 4.19943 6.49385 4.19943 6.38462V5.98904C4.19943 5.87986 4.11625 5.79122 4.0137 5.79122H3.64228C3.53977 5.79122 3.45655 5.87981 3.45655 5.98904V6.38462Z" fill="#5C6AA1"></path><path d="M4.01455 2.1473L4.25783 1.52255C4.31315 1.37991 4.45061 1.28593 4.60365 1.28593H6.05669V0.357362C6.05669 0.254855 6.13987 0.171631 6.24242 0.171631H6.61384C6.71634 0.171631 6.79957 0.254812 6.79957 0.357362V1.28593H8.65675V0.357362C8.65675 0.254855 8.73994 0.171631 8.84249 0.171631H9.21391C9.31641 0.171631 9.39964 0.254812 9.39964 0.357362V1.28593H11.2568V0.357362C11.2568 0.254855 11.34 0.171631 11.4426 0.171631H11.814C11.9165 0.171631 11.9997 0.254812 11.9997 0.357362V1.28593H13.5404C13.6934 1.28593 13.8309 1.37991 13.8866 1.52255L14.1299 2.14695C14.177 2.26878 14.0872 2.40028 13.9567 2.40028H4.18766C4.0569 2.40028 3.96702 2.26878 4.01455 2.1473Z" fill="#5C6AA1"></path>
                                                                        <path d="M2.43055 4.00966L2.65045 3.39009C2.70281 3.24187 2.84323 3.14307 3.00032 3.14307H17.4261C17.5833 3.14307 17.7236 3.24187 17.776 3.39009L17.9959 4.00926C18.039 4.13036 17.9494 4.25737 17.8213 4.25737H2.60548C2.47734 4.25741 2.38745 4.1304 2.43055 4.00966Z" fill="#5C6AA1"></path>
                                                                        </svg><?php echo $cruise['title']?></span>
                                                    <?php if($i % 2 != 0):?>
                                                        </button>
                                                        </li>
                                                     <?php endif;?>

                                                <?php $i++;endforeach;?>


                                            </ul>
                                            <?php endif;?>


                                        </div>
                                    </div>
                                </div>
                                <div class="searchBox__date pd4 col2">
                                    <div class="searchBox__input">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="21" height="22" viewBox="0 0 21 22" fill="none">
                                            <path d="M18.7103 0.411865H16.7477V2.52951C16.7477 2.95304 16.4206 3.23539 16.0935 3.23539C15.7664 3.23539 15.4393 2.95304 15.4393 2.52951V0.411865H4.97196V2.52951C4.97196 2.95304 4.64486 3.23539 4.31776 3.23539C3.99065 3.23539 3.66355 2.95304 3.66355 2.52951V0.411865H1.70093C0.719626 0.411865 0 1.32951 0 2.52951V5.07069H20.9346V2.52951C20.9346 1.32951 19.757 0.411865 18.7103 0.411865ZM0 6.55304V19.4707C0 20.7413 0.719626 21.5883 1.76636 21.5883H18.7757C19.8224 21.5883 21 20.6707 21 19.4707V6.55304H0ZM5.82243 18.4119H4.25234C3.99065 18.4119 3.72897 18.2001 3.72897 17.8472V16.0825C3.72897 15.8001 3.92523 15.5177 4.25234 15.5177H5.88785C6.14953 15.5177 6.41122 15.7295 6.41122 16.0825V17.8472C6.34579 18.2001 6.14953 18.4119 5.82243 18.4119ZM5.82243 12.0589H4.25234C3.99065 12.0589 3.72897 11.8472 3.72897 11.4942V9.72951C3.72897 9.44716 3.92523 9.16481 4.25234 9.16481H5.88785C6.14953 9.16481 6.41122 9.37657 6.41122 9.72951V11.4942C6.34579 11.8472 6.14953 12.0589 5.82243 12.0589ZM11.0561 18.4119H9.42056C9.15888 18.4119 8.8972 18.2001 8.8972 17.8472V16.0825C8.8972 15.8001 9.09346 15.5177 9.42056 15.5177H11.0561C11.3178 15.5177 11.5794 15.7295 11.5794 16.0825V17.8472C11.5794 18.2001 11.3832 18.4119 11.0561 18.4119ZM11.0561 12.0589H9.42056C9.15888 12.0589 8.8972 11.8472 8.8972 11.4942V9.72951C8.8972 9.44716 9.09346 9.16481 9.42056 9.16481H11.0561C11.3178 9.16481 11.5794 9.37657 11.5794 9.72951V11.4942C11.5794 11.8472 11.3832 12.0589 11.0561 12.0589ZM16.2897 18.4119H14.6542C14.3925 18.4119 14.1308 18.2001 14.1308 17.8472V16.0825C14.1308 15.8001 14.3271 15.5177 14.6542 15.5177H16.2897C16.5514 15.5177 16.8131 15.7295 16.8131 16.0825V17.8472C16.8131 18.2001 16.6168 18.4119 16.2897 18.4119ZM16.2897 12.0589H14.6542C14.3925 12.0589 14.1308 11.8472 14.1308 11.4942V9.72951C14.1308 9.44716 14.3271 9.16481 14.6542 9.16481H16.2897C16.5514 9.16481 16.8131 9.37657 16.8131 9.72951V11.4942C16.8131 11.8472 16.6168 12.0589 16.2897 12.0589Z" fill="#5C6AA1"></path>
                                        </svg>
                                        <div class="datepicker">
                                            <input type="text" placeholder="<?php echo t('Select Date...');?>" id="datepickerReturn" name="depart" class="check-out datepickerInput" value="<?php echo $depart?>" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="searchBox__code pd4 col2">
                                    <div class="searchBox__input duration_label">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22" fill="none">
                                            <path d="M11 0C8.82441 0 6.69767 0.645139 4.88873 1.85383C3.07979 3.06253 1.66989 4.78049 0.83733 6.79048C0.00476617 8.80047 -0.213071 11.0122 0.211367 13.146C0.635804 15.2798 1.68345 17.2398 3.22183 18.7782C4.76021 20.3166 6.72022 21.3642 8.85401 21.7886C10.9878 22.2131 13.1995 21.9952 15.2095 21.1627C17.2195 20.3301 18.9375 18.9202 20.1462 17.1113C21.3549 15.3023 22 13.1756 22 11C21.9966 8.08367 20.8365 5.28778 18.7744 3.22563C16.7122 1.16347 13.9163 0.00344047 11 0ZM14.707 14.707C14.5195 14.8945 14.2652 14.9998 14 14.9998C13.7348 14.9998 13.4805 14.8945 13.293 14.707L10.293 11.707C10.1055 11.5195 10.0001 11.2652 10 11V5C10 4.73478 10.1054 4.48043 10.2929 4.29289C10.4804 4.10536 10.7348 4 11 4C11.2652 4 11.5196 4.10536 11.7071 4.29289C11.8946 4.48043 12 4.73478 12 5V10.586L14.707 13.293C14.8945 13.4805 14.9998 13.7348 14.9998 14C14.9998 14.2652 14.8945 14.5195 14.707 14.707Z" fill="#5C6AA1"/>
                                        </svg>
                                        <p><svg xmlns="http://www.w3.org/2000/svg" width="10" height="8" viewBox="0 0 10 8" fill="none">
                                                <path d="M9.24559 0.405812C9.1762 0.282691 9.07533 0.180229 8.95331 0.108921C8.83128 0.0376131 8.6925 2.25533e-05 8.55117 0H0.796887C0.655634 6.85536e-05 0.516935 0.0376631 0.394983 0.108937C0.273031 0.18021 0.172203 0.282604 0.102818 0.405641C0.0334323 0.528677 -0.00201984 0.667939 8.88697e-05 0.809176C0.00219758 0.950413 0.0417915 1.08855 0.114819 1.20946L3.99196 7.61556C4.06298 7.73289 4.16307 7.82992 4.28255 7.89727C4.40204 7.96462 4.53687 8 4.67403 8C4.81118 8 4.94602 7.96462 5.0655 7.89727C5.18499 7.82992 5.28508 7.73289 5.3561 7.61556L9.23324 1.20946C9.30629 1.08861 9.34592 0.950513 9.34809 0.809309C9.35027 0.668106 9.31489 0.52886 9.24559 0.405812Z" fill="#415092"></path>
                                            </svg></p>
                                        <input readonly type="text" placeholder="<?php echo ($type_itinerary != '')?$conf['CRUISE_DURATION'][$type_itinerary]:t('Full day')?>" class="form-control form-control-lg inputPlace duration_label" />

                                        <div class="suggestion" id="duration">
                                            <?php foreach ($conf['CRUISE_DURATION'] as $key => $duration):?>
                                            <ul class="suggestion__list <?php echo $key?>" >
                                                <li><button type="button" key="<?php echo $key?>"><span><?php echo t($duration)?></span></button></li>
                                            </ul>
                                            <?php endforeach;?>

                                        </div>
                                    </div>
                                </div>
                                <div class="searchBox__code pd4 col4">
                                    <div class="searchBox__input searchBox_passenger">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="17" viewBox="0 0 12 12" fill="none">
                                            <path d="M3.33302 3.3335C3.33302 4.798 4.53552 6 5.99952 6C7.46452 6 8.66602 4.798 8.66602 3.3335C8.66602 1.868 7.46502 0.666504 5.99952 0.666504C4.53552 0.666504 3.33302 1.868 3.33302 3.3335ZM11.333 11.3335C11.333 9.3615 8.92902 7.3335 5.99952 7.3335C3.07102 7.3335 0.666016 9.3615 0.666016 11.3335V12H11.333V11.3335Z" fill="#5C6AA1"/>
                                        </svg>
                                        <p><svg xmlns="http://www.w3.org/2000/svg" width="10" height="8" viewBox="0 0 10 8" fill="none">
                                                <path d="M9.24559 0.405812C9.1762 0.282691 9.07533 0.180229 8.95331 0.108921C8.83128 0.0376131 8.6925 2.25533e-05 8.55117 0H0.796887C0.655634 6.85536e-05 0.516935 0.0376631 0.394983 0.108937C0.273031 0.18021 0.172203 0.282604 0.102818 0.405641C0.0334323 0.528677 -0.00201984 0.667939 8.88697e-05 0.809176C0.00219758 0.950413 0.0417915 1.08855 0.114819 1.20946L3.99196 7.61556C4.06298 7.73289 4.16307 7.82992 4.28255 7.89727C4.40204 7.96462 4.53687 8 4.67403 8C4.81118 8 4.94602 7.96462 5.0655 7.89727C5.18499 7.82992 5.28508 7.73289 5.3561 7.61556L9.23324 1.20946C9.30629 1.08861 9.34592 0.950513 9.34809 0.809309C9.35027 0.668106 9.31489 0.52886 9.24559 0.405812Z" fill="#415092"></path>
                                            </svg></p>
                                        <input type="text" readonly placeholder="
                                        <?php
                                            echo t('1 Room, 1 Traveller');
                                         ?>
                                        " class="form-control form-control-lg inputPlace searchBox_passenger" >
                                        <div class="suggestion roomSelect">
                                            <div class="roomSelect__close">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                                                    <path d="M17 1L1 17" stroke="#20265A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                    <path d="M1 1L17 17" stroke="#20265A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>
                                            </div>
                                            <div class="suggestion__top" id="no_room">
                                                <div class="select__box">
                                                    <label class="blueDark text16"><?php echo t('No. Rooms');?></label>
                                                    <select class="form-control" name="no_room" id="room_traveller">
                                                        <?php for($i = 1; $i <= $max_room; $i++):?>
                                                            <option value="<?php echo $i;?>"><?php echo $i;?></option>
                                                        <?php endfor;?>

                                                    </select>
                                                </div>
                                            </div>
                                            <div class="suggestion__bottom">
                                                <?php for($i = 1; $i <= $max_room; $i++):
                                                    $ii = $i - 1;
                                                    ?>
                                                    <div idx="<?php echo $i?>" id="room_<?php echo $i?>" class="roomBox__group d-none">
                                                        <p class="text16 medium blueP400 title_room"><?php echo t('Room');?> <?php echo $i;?></p>
                                                        <div class="select__box room_type ">
                                                            <label class="blueDark text16"><?php echo t('Type');?></label>
                                                            <select class="form-control room_type" name="room_type[<?php echo $ii?>]">
                                                                <option value="single"><?php echo t('Single');?></option>
                                                                <option value="double"><?php echo t('Double');?></option>
                                                                <option value="family"><?php echo t('Family ');?></option>
                                                            </select>
                                                        </div>
                                                        <div class="box__passenger">

                                                            <div class="select__box">
                                                                <label class="blueDark text16"><?php echo t('Adult (>10)');?> </label>
                                                                <select class="form-control adult" name="adult[<?php echo $ii?>]">

                                                                </select>
                                                            </div>
                                                            <div class="select__box">
                                                                <label class="blueDark text16"><?php echo t('Child (5-10)');?> </label>
                                                                <select class="form-control child" name="child[<?php echo $ii?>]">

                                                                </select>
                                                            </div>
                                                            <div class="select__box">
                                                                <label class="blueDark text16"><?php echo t('Infant (0-4)');?> </label>
                                                                <select class="form-control infant" name="infant[<?php echo $ii?>]">

                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php endfor;?>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="searchBox__btn pd4 w120">
                                    <a id="btn-search-cruise" class="btn btn-orange btn-lg w-100">
                                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" class="svg1">
                                            <path d="M19.4073 17.7527L14.9969 13.3422C16.0587 11.9286 16.6319 10.208 16.63 8.44C16.63 3.92406 12.9559 0.25 8.44 0.25C3.92406 0.25 0.25 3.92406 0.25 8.44C0.25 12.9559 3.92406 16.63 8.44 16.63C10.208 16.6319 11.9286 16.0587 13.3422 14.9969L17.7527 19.4073C17.9759 19.6069 18.2671 19.7135 18.5664 19.7051C18.8658 19.6967 19.1506 19.574 19.3623 19.3623C19.574 19.1506 19.6967 18.8658 19.7051 18.5664C19.7135 18.2671 19.6069 17.9759 19.4073 17.7527ZM2.59 8.44C2.59 7.28298 2.9331 6.15194 3.5759 5.18991C4.21871 4.22789 5.13235 3.47808 6.2013 3.03531C7.27025 2.59253 8.44649 2.47668 9.58128 2.70241C10.7161 2.92813 11.7584 3.48529 12.5766 4.30343C13.3947 5.12156 13.9519 6.16393 14.1776 7.29872C14.4033 8.43351 14.2875 9.60975 13.8447 10.6787C13.4019 11.7476 12.6521 12.6613 11.6901 13.3041C10.7281 13.9469 9.59702 14.29 8.44 14.29C6.88906 14.2881 5.40217 13.6712 4.30548 12.5745C3.2088 11.4778 2.59186 9.99095 2.59 8.44Z" fill="white"></path>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="msg d-none" id="msg"></div>
            </div>
        </div>
    </div>
    <input type="hidden" name="cruise" value="<?php echo ($cruise_current)?$cruise_current['nid']:''?>" />
    <input type="hidden" name="checkin" value="all" />
    <input type="hidden" name="duration" value="<?php echo ($type_itinerary != '')?$type_itinerary:'full_day'?>" />
    <input type="hidden" name="t" value="<?php echo time()?>" />
    <input type="hidden" name="arg2" value="<?php echo arg(2)?>" />
</form>

<input type="hidden" name="search_param" value='<?php echo (is_array($search_param) && count($search_param) > 0)?json_encode($search_param):''?>' />
<input type="hidden" name="data_cruise" value="">

<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/3.1.3/js/bootstrap-datetimepicker.min.js"></script>
<script>
    $(document).mouseup(function (e) {
        var suggestion = $('.suggestion');
        if (!suggestion.is(e.target) && suggestion.has(e.target).length === 0) {
            $('.suggestion').removeClass('open');
        }
        ;

    });

    $(document).ready(function () {
        var cruise_id = $('input[name=cruise]').val();
        if(cruise_id > 0) {
            var field_full_day_cruise =$('#frm-search-cruise span.cruise[cid='+cruise_id+']').attr('field_full_day_cruise');
            if(field_full_day_cruise == 'yes') {
                $('#duration .suggestion__list').addClass('d-none');
                $('#duration .suggestion__list.full_day').removeClass('d-none');
                var text_duration = $('#duration button[key=full_day] span').text();
                $('.duration_label').attr('placeholder',text_duration);
            } else {
                $('#duration .suggestion__list').removeClass('d-none');
                $('#duration .suggestion__list.full_day').addClass('d-none');
                $('input[name=duration]').val('2day1night');
                var text_duration = $('#duration button[key=2day1night] span').text();
                $('.duration_label').attr('placeholder',text_duration);
            }
            console.log(field_full_day_cruise);
        }
        //autocomplete
        reset_room();
        $('#keyword').keyup(function (){
            var keyword = $(this).val().toLowerCase();

            var cruise_name_html = $('.searchBox__from .suggestion__list span.cruise');
            $('.searchBox__from .suggestion__list button').removeClass('d-none');
            $('.searchBox__from .suggestion__list button span.cruise').addClass('d-none');
            $(cruise_name_html).each(function(i, value){
                var cruise_name = $(value).attr('name').toLowerCase();
                if(cruise_name.search(keyword) >= 0){
                    $(value).removeClass('d-none');
                }
            });
            var button_cruise = $('.searchBox__from .suggestion__list button');

            $(button_cruise).each(function(i, value){
                var check_button_cruise = false;
                $(value).find('span').each(function(j, value2){
                    if($(value2).hasClass('d-none') == false){
                        check_button_cruise = true;
                    }
                });
                if(!check_button_cruise){
                    $(value).addClass('d-none');
                }
            });
        });
        //close select room
        $('.roomSelect__close').click(function () {
            $(this).parent().removeClass('open');
        });



        $(".inputPlace").click(function () {
            $(this).next('.suggestion').addClass('open');
            //show hide type room
            var duration = $('#frm-search-cruise input[name=duration]').val();
            if(duration == 'full_day') {
                $('#no_room').addClass('d-none');
                $('.room_type').addClass('d-none');
                $('.title_room').addClass('d-none');
                $('.roomSelect').addClass('full_day');

            } else {
                $('#no_room').removeClass('d-none');
                $('.room_type').removeClass('d-none');
                $('.title_room').removeClass('d-none');
                $('.roomSelect').removeClass('full_day');

            }
            set_traveller_for_room('','');
        });


        $('#btn-search-cruise').click(function () {
           // return false;
            $('#msg').addClass('d-none');
            var cruise_id = $('input[name=cruise]').val();console.log(cruise_id);
            if(cruise_id == '') {
                $('#msg').text('Please select the cruise').removeClass('d-none');
                $('.searchBox #keyword').click();
                return false;
            }
            var depart = $('input[name=depart]').val();
            if(depart == '') {
                $('#msg').text('Please select the date').removeClass('d-none');
                $('#datepickerReturn').focus().click();
                return false;
            }
            var duration = $('input[name=duration]').val();
            if(duration == 'all_duration' || duration == '') {
                $('#msg').text('Please select the duration').removeClass('d-none');
                return false;
            }

            $('#frm-search-cruise').submit();
        });


        //click cruise
        $('.searchBox .cruise').click(function () {
            console.log('hello');
            var cruise_name = $(this).attr('name');
            var cid = $(this).attr('cid');

            var styleOpa = {
                'opacity': '.5',
                'pointer-events': 'none'
            };
            // if(cid == 'all'){
            //     $('.searchBox__form .searchBox__code.col4').css(styleOpa)
            // }

            $('#keyword').val(cruise_name);
            $('input[name=cruise]').val(cid);
            $('.searchBox .suggestion').removeClass('open');
            if($(this).attr('field_full_day_cruise') != '' && $(this).attr('field_full_day_cruise') != undefined && $(this).attr('field_full_day_cruise') == 'yes') {
                $('#duration .suggestion__list').addClass('d-none');
                $('#duration .suggestion__list.full_day').removeClass('d-none');
                var text_duration = $('#duration button[key=full_day] span').text();
                $('.duration_label').attr('placeholder',text_duration);
            } else {
                $('#duration .suggestion__list').removeClass('d-none');
                $('#duration .suggestion__list.full_day').addClass('d-none');
                $('input[name=duration]').val('2day1night');
                var text_duration = $('#duration button[key=2day1night] span').text();
                $('.duration_label').attr('placeholder',text_duration);
            }
            $('#msg').addClass('d-none');
            $('#datepickerReturn').focus().click();

        });

        $('#datepickerReturn').click(function () {
            var key = $(this).attr('key');
            var label = $(this).text();
            $('input[name=depart]').val(key);
            $('.searchBox__date').val(label);
            $('#msg').addClass('d-none');
            $(this).parents('.suggestion').removeClass('open');
        });

        $('#duration button').click(function () {
            var key = $(this).attr('key');
            var label = $(this).text();
            $('input[name=duration]').val(key);
            $('.duration_label').val(label);
            $(this).parents('.suggestion').removeClass('open');
            reset_room();

        });
       var room_traveller = $('.searchBox #room_traveller option:selected').val();
       var roomBox__group = $('.searchBox .suggestion__bottom .roomBox__group');
       if(roomBox__group.length > 0) {
           for(var i = 0; i < roomBox__group.length; i++) {
               var idx = $(roomBox__group[i]).attr('idx');
               if(parseInt(idx) <= parseInt(room_traveller)) {
                   $(roomBox__group[i]).removeClass('d-none');
               } else {
                   $(roomBox__group[i]).addClass('d-none');
               }
           }
       }

       $('#room_traveller').change(function () {
           var room_traveller = $('.searchBox #room_traveller option:selected').val();
           var roomBox__group = $('.searchBox .suggestion__bottom .roomBox__group');
           if(roomBox__group.length > 0) {
               for(var i = 0; i < roomBox__group.length; i++) {
                   var idx = $(roomBox__group[i]).attr('idx');
                   if(parseInt(idx) <= parseInt(room_traveller)) {
                       $(roomBox__group[i]).removeClass('d-none');
                   } else {
                       $(roomBox__group[i]).addClass('d-none');
                   }
               }
           }
       });

        $('.searchBox #room_traveller').change(function () {
            var room_traveller = $('.searchBox #room_traveller option:selected').val();
            var roomBox__group = $('.searchBox .suggestion__bottom .roomBox__group');
            if(roomBox__group.length > 0) {
                for(var i = 0; i < roomBox__group.length; i++) {
                    var idx = $(roomBox__group[i]).attr('idx');
                    if(parseInt(idx) <= parseInt(room_traveller)) {
                        $(roomBox__group[i]).removeClass('d-none');
                    }
                }
            }
            get_info();
        });
        set_traveller_for_room('','');
        $('select.room_type').change(function () {
            var id = $(this).parents('.roomBox__group').attr('id');
            set_traveller_for_room(id,$(this));
            get_info();
        });

        $('.roomBox__group select').change(function () {
            limit_traveller_for_room($(this));
            get_info();
        });

       function limit_traveller_for_room(t) {
           var adult = $(t).parents('.roomBox__group').find('select.adult option:selected').val();
           var child = $(t).parents('.roomBox__group').find('select.child option:selected').val();
           var infant =$(t).parents('.roomBox__group').find('select.infant option:selected').val();
           var room_type = $(t).parents('.roomBox__group').find('select.room_type option:selected').val();
           var duration = $('input[name=duration]').val();
           var total = parseInt(adult) + parseInt(child) + parseInt(infant);
           $(t).parents('.roomBox__group').find('select.child option').removeClass('d-none');
           console.log(total);
           if(room_type == 'double') {
               if(total > 4) {
                   $(t).find('option[value=0]').prop('selected',true);
               }
           } else if(room_type == 'family') {
               if(total > 6) {
                   $(t).find('option[value=0]').prop('selected',true);
               }
           } else if(duration == 'full_day') {
               var remain_child = 10 - adult + 1;
               for(var i = remain_child; i <= 10; i++) {
                   $(t).parents('.roomBox__group').find('select.child option[value='+i+']').addClass('d-none');
               }
               if( (parseInt(adult) + parseInt(child)) > 10) {
                   if($(t).hasClass('adult')) {
                       $(t).find('option[value=1]').prop('selected',true);
                   } else {
                       $(t).find('option[value=0]').prop('selected',true);
                   }

               }
           }

       }
       function  set_traveller_for_room(id,t) {

           if(id == '') {
               var roomBox__group = $('.searchBox .suggestion__bottom .roomBox__group');
           } else {
               var roomBox__group = $('#' + id);
           }
           var duration = $('input[name=duration]').val();
           if(roomBox__group.length > 0) {
               for(var i = 0; i < roomBox__group.length; i++) {
                  var room_type = $(roomBox__group[i]).find('select.room_type option:selected').val();
                   console.log('set travel for room' + room_type);
                  if(room_type == 'single') {

                      var option_adult = '<option value="1">1</option>';
                      var option_child = '<option value="0">0</option>';
                      var option_infant = '<option value="0">0</option><option value="1">1</option>';
                      if(duration == 'full_day') {
                          var option_adult = '';
                          var option_child = '';
                          var option_infant = '';
                          for(var j = 1; j <= 10; j++) {
                              var jj = j - 1;
                              option_adult += '<option value="'+ j +'">'+ j +'</option>';
                              option_child += '<option value="'+ jj +'">'+ jj +'</option>';
                              option_infant += '<option value="'+ jj +'">'+ jj +'</option>';
                          }
                      }

                      $(roomBox__group[i]).find('select.adult').html(option_adult);
                      $(roomBox__group[i]).find('select.child').html(option_child);
                      $(roomBox__group[i]).find('select.infant').html(option_infant);
                  } else if(room_type == 'double') {
                       var option_adult = '<option value="1">1</option><option value="2">2</option>';
                       $(roomBox__group[i]).find('select.adult').html(option_adult);
                       var option_child = '<option value="0">0</option><option value="1">1</option><option value="2">2</option>';
                       $(roomBox__group[i]).find('select.child').html(option_child);
                       var option_infant = '<option value="0">0</option><option value="1">1</option><option value="2">2</option>';
                       $(roomBox__group[i]).find('select.infant').html(option_infant);


                  }else if(room_type == 'family') {
                      var option_adult = '<option value="2">2</option><option value="3">3</option><option value="4">4</option>';
                      $(roomBox__group[i]).find('select.adult').html(option_adult);
                      var option_child = '<option value="0">0</option><option value="1">1</option><option value="2">2</option>';
                      $(roomBox__group[i]).find('select.child').html(option_child);
                      var option_infant = '<option value="0">0</option><option value="1">1</option><option value="2">2</option>';
                      $(roomBox__group[i]).find('select.infant').html(option_infant);
                  }
               }
           }


       }
       
       function get_info() {
           var num_room = $('select[name=no_room] option:selected').val();
           var passenger = 0;


           for(var r = 0; r < num_room; r++) {
               var r2 = r + 1;
               var adult = $('#room_' + r2 + ' select.adult');
               var child = $('#room_' + r2 + ' select.child');
               var infant = $('#room_' + r2 + ' select.infant');

               if(adult.length > 0) {
                   for(var i = 0; i < adult.length; i++) {
                       var a = $(adult[i]).find('option:selected').val();
                       passenger += parseInt(a);
                   }
               }
               if(child.length > 0) {
                   for(var i = 0; i < child.length; i++) {
                       var a = $(child[i]).find('option:selected').val();
                       passenger += parseInt(a);
                   }
               }
               if(infant.length > 0) {
                   for(var i = 0; i < infant.length; i++) {
                       var a = $(infant[i]).find('option:selected').val();
                       passenger += parseInt(a);
                   }
               }
           }

           console.log(passenger);
            var text = '';
           if(num_room > 1) {
               text += num_room + "<?php echo t(' Rooms, ')?>";
           } else {
               text +=  "<?php echo t('1 Room, ');?>";
           }
           if(passenger > 1) {
               text += passenger + "<?php echo t(' Travellers');?>";
           } else {
               text += passenger + "<?php echo t(' Traveller');?>";
           }
           $('.searchBox_passenger').attr('placeholder',text);
       }


       function reset_room() {
           console.log('reset search');
           $('#frm-search-cruise .roomBox__group').addClass('d-none');
           $('#frm-search-cruise  #room_1').removeClass('d-none');
           $('#frm-search-cruise select[name=no_room] option[value=1]').prop('selected',true);
           $('#frm-search-cruise select[name=room_type] option[value=single]').prop('selected',true);
           $('#frm-search-cruise select[name=room_type] option[value=single]').prop('selected',true);
           $('#frm-search-cruise select.adult option[value=1]').prop('selected',true);
           $('#frm-search-cruise select.child option[value=0]').prop('selected',true);
           $('#frm-search-cruise select.infant option[value=0]').prop('selected',true);
           var text =  "<?php echo t('1 Room, ');?>" + 1 + "<?php echo t(' Traveller');?>";
           $('.searchBox_passenger').attr('placeholder',text);
       }




    });
</script>
<?php

?>