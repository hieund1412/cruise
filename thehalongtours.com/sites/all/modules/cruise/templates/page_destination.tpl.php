<?php
$theme = '/sites/all/themes/newtheme/';
$lang = (isset($_SESSION['lang']) && $_SESSION['lang'] != '')?$_SESSION['lang']:'en';
if($lang == 'en') {
    $ha_long_bay_nid = 1390;
    $ha_lan_bay_nid = 1394;
    $tu_long_bay_nid = 1413;
    $Titov_Island_nid = 1434;
} else {
    $ha_long_bay_nid = 2892;
    $ha_lan_bay_nid = 3301;
    $tu_long_bay_nid = 2891;
    $Titov_Island_nid = 2883;

}

$ha_long = _get_node($ha_long_bay_nid);
$tu_long = _get_node($tu_long_bay_nid); //print_r($tu_long);die;
$ha_lan = _get_node($ha_lan_bay_nid); //print_r($tu_long);die;
$titov = _get_node($Titov_Island_nid); //print_r($tu_long);die;
?>

    <div style="background-image: url(<?php echo $theme?>images/destinations.jpg);" class="destination__banner">
        <div class="destination__cont container-auto">
            <p class="medium"><?php echo $ha_long['title']?></p>
            <?php echo isset($ha_long['summary'])?$ha_long['summary']:truncate_utf8($ha_long['body_value'],0,500);?>
            <a href="<?php echo base_path().drupal_get_path_alias('detail/'.$ha_long['nid'])?>" class="btn btn-outline-white btn-lg">
                <div class="flexIcon">
                    <span><?php echo t('View more');?></span>
                    <svg class="ml5" xmlns="http://www.w3.org/2000/svg" width="16" height="8" viewBox="0 0 16 8" fill="none">
                        <path d="M15.8047 3.52738L12.6193 0.342042C12.5261 0.248836 12.4073 0.185365 12.278 0.159653C12.1487 0.133941 12.0147 0.147143 11.8929 0.19759C11.7711 0.248036 11.667 0.333463 11.5937 0.44307C11.5205 0.552676 11.4814 0.681542 11.4813 0.813375V2.83204C11.4813 2.87624 11.4638 2.91864 11.4325 2.94989C11.4013 2.98115 11.3589 2.99871 11.3147 2.99871H1C0.734784 2.99871 0.48043 3.10407 0.292893 3.2916C0.105357 3.47914 0 3.73349 0 3.99871C0 4.26393 0.105357 4.51828 0.292893 4.70582C0.48043 4.89335 0.734784 4.99871 1 4.99871H11.3147C11.3589 4.99871 11.4013 5.01627 11.4325 5.04752C11.4638 5.07878 11.4813 5.12117 11.4813 5.16538V7.18404C11.4814 7.31588 11.5205 7.44474 11.5937 7.55435C11.667 7.66395 11.7711 7.74938 11.8929 7.79983C12.0147 7.85027 12.1487 7.86348 12.278 7.83776C12.4073 7.81205 12.5261 7.74858 12.6193 7.65538L15.8047 4.47004C15.9296 4.34502 15.9999 4.17549 15.9999 3.99871C15.9999 3.82193 15.9296 3.65239 15.8047 3.52738Z" fill="white"/>
                    </svg>
                </div>
            </a>
        </div>
    </div>

    <div style="background-image: url(<?php echo $theme?>images/destinations7.jpg);" class="destinations__item">
        <div class="container-auto">
            <div class="destinations__main">
                <div class="row">
                    <div class="col-6">
                        <div class="destinations__image">
                            <?php if(isset($tu_long['thumbnail'])):
                                $tu_long_img1 = $tu_long['thumbnail'];
                                if($tu_long['thumbnail2'] != '') {
                                    $tu_long_img2 = $tu_long['thumbnail2'];
                                } else {
                                    $tu_long_img2 = $tu_long['thumbnail'];
                                }
                                ?>
                            <div class="image__child image-50"><img src="<?php echo $tu_long_img1?>" /></div>
                            <div class="image__child image-50"><img src="<?php echo $tu_long_img2?>" /></div>
                            <?php endif;?>

                        </div>
                    </div>
                    <div class="col-6">
                        <p class="colorBluedark900 text28 medium"><?php echo $tu_long['title']?></p>
                        <p>
                            <?php $summary = (isset($tu_long['body']['und'][0]['summary']) && $tu_long['body']['und'][0]['summary'] !='')?$tu_long['body']['und'][0]['summary']: truncate_utf8($tu_long['body']['und'][0]['value'],500,true,'...');
                            echo strip_tags($summary);
                            ?>
                        </p>
                        <a href="<?php echo base_path().drupal_get_path_alias('detail/'.$tu_long['nid'])?>" target="_blank" class="btn btn-outline-orange btn-lg mt10">
                            <div class="flexIcon">
                                <p>View more</p>
                                <svg class="ml5" xmlns="http://www.w3.org/2000/svg" width="16" height="8" viewBox="0 0 16 8" fill="none">
                                    <path d="M15.8047 3.52731L12.6193 0.341981C12.5261 0.248775 12.4073 0.185304 12.278 0.159592C12.1487 0.13388 12.0147 0.147082 11.8929 0.197529C11.7711 0.247975 11.667 0.333402 11.5937 0.443009C11.5205 0.552615 11.4814 0.681481 11.4813 0.813314V2.83198C11.4813 2.87618 11.4638 2.91858 11.4325 2.94983C11.4013 2.98109 11.3589 2.99865 11.3147 2.99865H1C0.734784 2.99865 0.48043 3.104 0.292893 3.29154C0.105357 3.47908 0 3.73343 0 3.99865C0 4.26386 0.105357 4.51822 0.292893 4.70575C0.48043 4.89329 0.734784 4.99865 1 4.99865H11.3147C11.3589 4.99865 11.4013 5.01621 11.4325 5.04746C11.4638 5.07872 11.4813 5.12111 11.4813 5.16531V7.18398C11.4814 7.31581 11.5205 7.44468 11.5937 7.55429C11.667 7.66389 11.7711 7.74932 11.8929 7.79977C12.0147 7.85021 12.1487 7.86342 12.278 7.8377C12.4073 7.81199 12.5261 7.74852 12.6193 7.65531L15.8047 4.46998C15.9296 4.34496 15.9999 4.17542 15.9999 3.99865C15.9999 3.82187 15.9296 3.65233 15.8047 3.52731Z" fill="#FD6431"/>
                                </svg>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div  class="destinations__item">
        <div class="container-auto">
        <div class="destinations__main">
            <div class="row">
                <div class="col-6">
                    <p class="colorBluedark900 text28 medium"><?php echo $ha_lan['title']?></p>
                    <p>
                        <?php
                            $summary = (isset($ha_lan['body']['und'][0]['summary']) && $ha_lan['body']['und'][0]['summary'] !='')?$ha_lan['body']['und'][0]['summary']: truncate_utf8($ha_lan['body']['und'][0]['value'],500,true,'...');
                        echo strip_tags($summary);
                            ?>
                    </p>
                    <a href="<?php echo base_path().drupal_get_path_alias('detail/'.$ha_lan['nid'])?>" target="_blank" class="btn btn-outline-orange btn-lg mt10">
                        <div class="flexIcon">
                            <p>View more</p>
                            <svg class="ml5" xmlns="http://www.w3.org/2000/svg" width="16" height="8" viewBox="0 0 16 8" fill="none">
                                <path d="M15.8047 3.52731L12.6193 0.341981C12.5261 0.248775 12.4073 0.185304 12.278 0.159592C12.1487 0.13388 12.0147 0.147082 11.8929 0.197529C11.7711 0.247975 11.667 0.333402 11.5937 0.443009C11.5205 0.552615 11.4814 0.681481 11.4813 0.813314V2.83198C11.4813 2.87618 11.4638 2.91858 11.4325 2.94983C11.4013 2.98109 11.3589 2.99865 11.3147 2.99865H1C0.734784 2.99865 0.48043 3.104 0.292893 3.29154C0.105357 3.47908 0 3.73343 0 3.99865C0 4.26386 0.105357 4.51822 0.292893 4.70575C0.48043 4.89329 0.734784 4.99865 1 4.99865H11.3147C11.3589 4.99865 11.4013 5.01621 11.4325 5.04746C11.4638 5.07872 11.4813 5.12111 11.4813 5.16531V7.18398C11.4814 7.31581 11.5205 7.44468 11.5937 7.55429C11.667 7.66389 11.7711 7.74932 11.8929 7.79977C12.0147 7.85021 12.1487 7.86342 12.278 7.8377C12.4073 7.81199 12.5261 7.74852 12.6193 7.65531L15.8047 4.46998C15.9296 4.34496 15.9999 4.17542 15.9999 3.99865C15.9999 3.82187 15.9296 3.65233 15.8047 3.52731Z" fill="#FD6431"/>
                            </svg>
                        </div>
                    </a>
                </div>
                <div class="col-6">
                    <div class="destinations__image">
                        <?php if(isset($ha_lan['thumbnail'])):
                            $ha_lan_img1 = $ha_lan['thumbnail'];

                            ?>
                            <div class="image__child image-100">
                                <img src="<?php echo $tu_long_img1?>" />
                            </div>
                        <?php endif;?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <div  class="destinations__item" style="background-image: url(<?php echo $theme?>images/destinations8.jpg);">
    <div class="container-auto">
        <div class="destinations__main">
            <div class="row">
                <div class="col-6">
                    <div class="destinations__image">
                        <?php if(isset($titov['thumbnail'])):
                            $titov_img1 = $titov['thumbnail'];
                            if($titov['thumbnail2'] != '') {
                                $titov_img2 = $titov['thumbnail2'];
                            } else {
                                $titov_img2 = $titov['thumbnail'];
                            }
                            ?>
                        <div class="image__child image-50"><img src="<?php echo $titov_img1?>" /></div>
                        <div class="image__child image-50"><img src="<?php echo $titov_img2?>" /></div>
                        <?php endif;?>

                    </div>
                </div>
                <div class="col-6">
                    <p class="colorBluedark900 text28 medium"><?php echo $titov['title']?></p>
                    <p>
                        <?php $summary = (isset($tu_long['body']['und'][0]['summary']) && $titov['body']['und'][0]['summary'] !='')?$titov['body']['und'][0]['summary']: truncate_utf8($titov['body']['und'][0]['value'],500,true,'...');
                        echo strip_tags($summary);
                        ?>
                    </p>
                    <a href="<?php echo base_path().drupal_get_path_alias('detail/'.$titov['nid'])?>" target="_blank" class="btn btn-outline-orange btn-lg mt10">
                        <div class="flexIcon">
                            <p>View more</p>
                            <svg class="ml5" xmlns="http://www.w3.org/2000/svg" width="16" height="8" viewBox="0 0 16 8" fill="none">
                                <path d="M15.8047 3.52731L12.6193 0.341981C12.5261 0.248775 12.4073 0.185304 12.278 0.159592C12.1487 0.13388 12.0147 0.147082 11.8929 0.197529C11.7711 0.247975 11.667 0.333402 11.5937 0.443009C11.5205 0.552615 11.4814 0.681481 11.4813 0.813314V2.83198C11.4813 2.87618 11.4638 2.91858 11.4325 2.94983C11.4013 2.98109 11.3589 2.99865 11.3147 2.99865H1C0.734784 2.99865 0.48043 3.104 0.292893 3.29154C0.105357 3.47908 0 3.73343 0 3.99865C0 4.26386 0.105357 4.51822 0.292893 4.70575C0.48043 4.89329 0.734784 4.99865 1 4.99865H11.3147C11.3589 4.99865 11.4013 5.01621 11.4325 5.04746C11.4638 5.07872 11.4813 5.12111 11.4813 5.16531V7.18398C11.4814 7.31581 11.5205 7.44468 11.5937 7.55429C11.667 7.66389 11.7711 7.74932 11.8929 7.79977C12.0147 7.85021 12.1487 7.86342 12.278 7.8377C12.4073 7.81199 12.5261 7.74852 12.6193 7.65531L15.8047 4.46998C15.9296 4.34496 15.9999 4.17542 15.9999 3.99865C15.9999 3.82187 15.9296 3.65233 15.8047 3.52731Z" fill="#FD6431"/>
                            </svg>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

