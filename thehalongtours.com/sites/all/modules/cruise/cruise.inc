<?php
function web_info() {
    global $conf;
    $temp = explode('webcruise/',$conf['api_url']);
    $id = $temp[1];
    return _get_node($id);
}

function web_info_basic() {
    global $conf;
    $info = get_api_data($conf['api_url']);
    return $info;
}

function detail_cruise($id) {
    global $conf;
    $list_cruise_url = $conf['api_url'].'/cruise/'.$id;
    $cruises = get_api_data($list_cruise_url);
    return $cruises;
}

function area_code() {
    global $conf;
    $area_code_url = $conf['api_url'].'/area_code';
    $area_code = get_api_data($area_code_url);
    return $area_code;
}
function list_cruise() {
    global $conf;
    $list_cruise_url = $conf['api_url'].'/cruises';
    $cruises = get_api_data($list_cruise_url);
    return $cruises;
}
function list_cruise_by_ids() {
    $cruises = list_cruise();
    $data = array();
    if(count($cruises) > 0) {
        foreach ($cruises as $ob) {
            $nid = $ob['nid'];
            $data[$nid] = $ob;
        }
    }
    return $data;
}
function cruise_line() {
    global $conf;
    $list_cruise_url = $conf['api_url'].'/cruise-line';
    $cruises = get_api_data($list_cruise_url);
    return $cruises;
}
function special_packages() {
    global $conf;
    $list_cruise_url = $conf['api_url'].'/special-packages';
    $cruises = get_api_data($list_cruise_url);
    return $cruises;
}
function popular_destinations() {
    global $conf;
    $list_cruise_url = $conf['api_url'].'/destination';
    $cruises = get_api_data($list_cruise_url);
    return $cruises;
}

function thing_to_do() {
    global $conf;
    $list_cruise_url = $conf['api_url'].'/thing-to-do';
    $cruises = get_api_data($list_cruise_url);
    return $cruises;
}

function _news() {
    global $conf;
    $list_cruise_url = $conf['api_url'].'/news';
    $cruises = get_api_data($list_cruise_url);
    return $cruises;
}

function all_itinerary() {
    global $conf;
    $list_cruise_url = $conf['api_url'].'/all_itinerary';
    $cruises = get_api_data($list_cruise_url);
    return $cruises;
}


function hot_news() {
    global $conf;
    $list_cruise_url = $conf['api_url'].'/news/hot_new';
    $hot_news = get_api_data($list_cruise_url);
    return $hot_news;
}
function special_offers() {
    global $conf;
    $list_cruise_url = $conf['api_url'].'/news/special_offers';
    $special_offers = get_api_data($list_cruise_url);
    return $special_offers;
}

function travel_advisor() {
    global $conf;
    $list_cruise_url = $conf['api_url'].'/news/travel_advisor';
    $travel_advisor = get_api_data($list_cruise_url);
    return $travel_advisor;
}

function _deals() {
    global $conf;
    $list_cruise_url = $conf['api_url'].'/hot_deal';
    $cruises = get_api_data($list_cruise_url);
    return $cruises;
}

function _faq() {
    global $conf;
    $list_cruise_url = $conf['api_url'].'/faq';
    $cruises = get_api_data($list_cruise_url);
    return $cruises;
}

function review() {
    global $conf;
    $list_cruise_url = $conf['api_url'].'/review';
    $cruises = get_api_data($list_cruise_url);
    return $cruises;
}

function _page_review($full_code) {
    global $conf;
    $list_cruise_url = $conf['api_url'].'/page_review/'.$full_code;
    $data = get_api_data($list_cruise_url);
    return $data;
}

function _get_discount() {
    global $conf;
    $list_cruise_url = $conf['api_url'].'/discount';
    $discounts = get_api_data($list_cruise_url);//print_r($discounts);die;
    $data = array();
    $i = 0;//print_r($discounts);
    if($discounts && count($discounts) > 0) {
        foreach ($discounts as $ob) {

            //dieu kien duoc huong discount
            $field_from_date = isset($ob['field_from_date']['und'][0]['value'])?$ob['field_from_date']['und'][0]['value']:0;//ngay dat phong tu
            $field_to_date = isset($ob['field_to_date']['und'][0]['value'])?$ob['field_to_date']['und'][0]['value']:0;//ngay dat phong den
            $field_node_discount = isset($ob['field_node_discount']['und'])?$ob['field_node_discount']['und']:'ALL'; //cho tau nao
            $field_hanh_trinh = isset($ob['field_hanh_trinh']['und'])?$ob['field_hanh_trinh']['und']:'ALL';//cho hanh trinh nao
            $field_phong = isset($ob['field_phong']['und'][0]['value'])?$ob['field_phong']['und'][0]['value']:'ALL';//cho  phong nao

            $field_so_phong = isset($ob['field_so_phong']['und'][0]['value'])?$ob['field_so_phong']['und'][0]['value']:0; //so phong toi thieu

            $field_so_tien_toi_thieu = isset($ob['field_so_tien']['und'][0]['value'])?$ob['field_so_tien']['und'][0]['value']:0; //so tien tien toi thieu de duoc giam
            $field_don_vi_tien_toi_thieu = isset($ob['field_don_vi_tien_toi_thieu']['und'][0]['value'])?$ob['field_don_vi_tien_toi_thieu']['und'][0]['value']:0; //usd/vnd

            //thong tin giam
            $field_so_tien_giam = isset($ob['field_so_tien_giam']['und'][0]['value'])?$ob['field_so_tien_giam']['und'][0]['value']:0; //so tien giam
            $field_don_vi = isset($ob['field_don_vi']['und'][0]['value'])?$ob['field_don_vi']['und'][0]['value']:'';//don vi

            $field_doi_tuong_giam_adult = false;
            $field_doi_tuong_giam_child = false;
            $field_doi_tuong_giam_infant = false;
            $field_doi_tuong_giam_total = false;
            if(isset($ob['field_doi_tuong_giam']['und']) && count($ob['field_doi_tuong_giam']['und']) > 0) {
                for($i = 0; $i < count($ob['field_doi_tuong_giam']['und']); $i++) {
                    if($ob['field_doi_tuong_giam']['und'][$i]['value'] == 'adult') {
                        $field_doi_tuong_giam_adult = true;
                    } else if($ob['field_doi_tuong_giam']['und'][$i]['value'] == 'child') {
                        $field_doi_tuong_giam_child = true;
                    } else if($ob['field_doi_tuong_giam']['und'][$i]['value'] == 'infant') {
                        $field_doi_tuong_giam_infant = true;
                    } else if($ob['field_doi_tuong_giam']['und'][$i]['value'] == 'total') {
                        $field_doi_tuong_giam_total = true;
                    }
                }
            }

            $ngay_trong_tuan = array();
            if(isset($ob['field_week_day']['und']) && count($ob['field_week_day']['und']) > 0) {
                for($i = 0; $i < count($ob['field_week_day']['und']); $i++) {
                    array_push($ngay_trong_tuan,$ob['field_week_day']['und'][$i]['value']);
                }
            }
            $nguoilon_treem = isset($ob['field_adult_child']['und'][0]['value'])?$ob['field_adult_child']['und'][0]['value']:0;
            $nguoilon_embe = isset($ob['field_adult_infant']['und'][0]['value'])?$ob['field_adult_infant']['und'][0]['value']:0;
            $tongkhach = isset($ob['field_total_passenger']['und'][0]['value'])?$ob['field_total_passenger']['und'][0]['value']:0;

            if($field_from_date != '') {

                $field_from_date = DateTime::createFromFormat("d/m/Y H:i:s", $field_from_date.' 00:00:00');
                $field_from_date = $field_from_date->getTimestamp();

            }
            if($field_to_date != '') {
                $field_to_date = DateTime::createFromFormat("d/m/Y H:i:s", $field_to_date.' 23:59:59');
                $field_to_date = $field_to_date->getTimestamp();
            }
            $list_cruise = array();
            if($field_node_discount != 'ALL' && count($field_node_discount) > 0) {
                for($c = 0; $c < count($field_node_discount); $c++) {
                    $list_cruise[$c] = $field_node_discount[$c]['nid'];
                }
            }
            $list_hanhtrinh = array();
            if($field_hanh_trinh != 'ALL' && count($field_hanh_trinh) > 0) {
                for($h = 0; $h < count($field_hanh_trinh); $h++) {
                    $list_hanhtrinh[$h] =  $field_hanh_trinh[$h]['value'];
                }
            }

            $img_text = '/sites/default/files';
            $img_text2 = 'https://flightlibrary.com/sites/default/files';
            $body = str_replace($img_text,$img_text2,$ob['body']['und'][0]['value']);

            $data[] = array(
                'nid' => $ob['nid'],
                'title' => $ob['title'],
                'from_date' => $field_from_date,
                'to_date' => $field_to_date,
                'cruise' => $list_cruise,
                'hanh_trinh' => $list_hanhtrinh,
                'phong' => $field_phong,
                'so_phong' => $field_so_phong,
                'so_tien_toi_thieu' => $field_so_tien_toi_thieu,
                'don_vi_tien_toi_thieu' => $field_don_vi_tien_toi_thieu,
                'so_tien_giam' => $field_so_tien_giam,
                'don_vi' => $field_don_vi,
                'doi_tuong_giam_adult' => $field_doi_tuong_giam_adult,
                'doi_tuong_giam_child' => $field_doi_tuong_giam_child,
                'doi_tuong_giam_infant' => $field_doi_tuong_giam_infant,
                'doi_tuong_giam_total' => $field_doi_tuong_giam_total,
                'ngay_trong_tuan' => $ngay_trong_tuan,
                'nguoilon_treem' => $nguoilon_treem,
                'nguoilon_embe' => $nguoilon_embe,
                'tongkhach' => $tongkhach,
                'body' => $body,
                'image' => $ob['image']
            );
            $i++;



        }
    }

    return $data;
}


function _get_node($nid) {
    global $conf;
    $lang = isset($_SESSION['lang'])?$_SESSION['lang']:'en';
    $list_cruise_url = $conf['api_url'].'/node/'.$nid;
    $data = get_api_data($list_cruise_url);//print_r($data);die;

    $web_info = web_info_basic();
    $site_email = $web_info['field_site_email']['und'][0]['value'];
    $site_name = $web_info['field_site_name']['und'][0]['value'];
    $site_link = '<a href="'.$web_info['field_site_link']['und'][0]['value'].'">'.$web_info['field_site_link']['und'][0]['value'].'</a>';

    $body = isset($data['body']['und'][0]['value'])?$data['body']['und'][0]['value']:'';

    if($body != '') {
        $body = str_replace('[SITE_NAME]',$site_name,$body);
        $body = str_replace('[SITE_EMAIL]',$site_email,$body);
        $body = str_replace('[SITE_LINK]',$site_link,$body);

        $body = str_replace('[SITE_LINK]',$site_link,$body);
        if($nid == 3415) {
            $img_text = '/sites/default/files';
            $img_text2 = 'https://flightlibrary.com/sites/default/files';
            $body = str_replace($img_text,$img_text2,$body);
        } else if($data['type'] == 'discount') {
            $img_text = '/sites/default/files';
            $img_text2 = 'https://flightlibrary.com/sites/default/files';
            $body = str_replace($img_text,$img_text2,$body);
        }


        $data['body']['und'][0]['value'] = $body;
    }
    $c_key = '_get_node_'.$nid.'_'.$lang;
    $cached = cache_get($c_key, 'cache');
    if($cached && $conf['ev'] == 'production')  {
        $data_cache = $cached->data;
        return $data_cache;
    } else {

        cache_set($c_key, $data);
        return $data;
    }



}
function list_amenities() {
    global $conf;
    $lang = (isset($_SESSION['lang']) && $_SESSION['lang'] != '')?$_SESSION['lang']:'en';
    $c_key = 'list_amenities_'.$lang;
    $cached = cache_get($c_key, 'cache');
    if($cached && $conf['ev'] == 'production')  {
        $amenities = $cached->data;
    } else {
        $list_amenitie_url = $conf['api_url'].'/list_amenities';
        $amenities = get_api_data($list_amenitie_url);
        if(count($amenities) > 0) {
            $new_amenities = array();
            foreach ($amenities as $tid => $value) {
                $new_amenities[$tid] = t($value);
            }
            $amenities = $new_amenities;
        }
        cache_set($c_key, $amenities);
    }
    return $amenities;
}

function post_api_data($data,$api_url) {
    global $conf;
    $url = $conf['api_url'].'/'.$api_url;

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec($ch);
    return trim($result);

}

function get_api_data($url) {
    $header = array('Accept-Language: en');
    $lang = isset($_SESSION['lang'])?$_SESSION['lang']:'en';
    $url .= '?lang='.$lang;
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $header);
    $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    $data = curl_exec($curl);
    curl_close($curl);
    $data = json_decode($data,true);
    return $data;
}

function get_star_html($num) {
    $html = '
    <p class="tableIcon__star">';
    for($i = 1; $i <= $num; $i++) {
        $html .= '<svg xmlns="http://www.w3.org/2000/svg" width="12" height="11" viewBox="0 0 12 11" fill="none">
            <path d="M6 0L7.34708 4.1459H11.7063L8.17963 6.7082L9.52671 10.8541L6 8.2918L2.47329 10.8541L3.82037 6.7082L0.293661 4.1459H4.65292L6 0Z" fill="#FD6431"></path>
        </svg>';
    }


    $html .='</p>';
    return $html;
}