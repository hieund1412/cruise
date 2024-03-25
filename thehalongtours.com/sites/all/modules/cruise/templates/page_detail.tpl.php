<?php
$theme = '/sites/all/themes/newtheme/';
$media_server = 'https://flightlibrary.com/sites/default/files';
$bg = '';
$banner_title = '';
$term = isset($data['content']['field_category']['und'][0]['tid'])?$data['content']['field_category']['und'][0]['tid']:null;
if( $data['content']['type'] == 'destination') {
    $bg = $theme.'images/destinations.jpg';
    $banner_title = t('Destinations');
} else if( $data['content']['type'] == 'news') {
    $bg = $theme.'images/news1.jpg';
    $banner_title = t('News');
} else if($data['content']['type'] == 'page') {
    $bg = $theme.'images/contact-us.jpg';
} else if($data['content']['type'] == 'cruise_article' && $term == 8824) {
    $bg = $theme.'images/things1.jpg';
}
$body = $data['content']['body']['und'][0]['value'];
$body = str_replace('/sites/default/files',$media_server,$body);
$web_info = web_info();
$field_site_name = $web_info['field_site_name']['und'][0]['value'];
$site_email = $web_info['field_site_email']['und'][0]['value'];
$site_link = $web_info['field_site_link']['und'][0]['value'];
$site_link = '<a href="'.$site_link.'">'.$site_link.'</a>';
$body = str_replace('[SITE_NAME]',$field_site_name,$body);
$body = str_replace('[SITE_EMAIL]',$site_email,$body);
$body = str_replace('[SITE_LINK]',$site_link,$body);

//print_r($data);die;
?>

<div style="background-image: url(<?php echo $bg?>);" class="newBanner">
    <div class="newTitle container-auto">
        <p class="medium"><?php echo $banner_title?></p>
        <p class="colorWhite text24 <?php echo $banner_title ? '' : 'not_banner_title'?>"><?php echo  $data['content']['title']?></p>
    </div>
</div>
<div class="newFlex__group">
    <div class="container-auto">
        <div class="row node-detail">
            <?php echo  $body?>

        </div>
    </div>
</div>
