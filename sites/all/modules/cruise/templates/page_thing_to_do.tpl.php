<?php
$theme = '/sites/all/themes/newtheme/';


?>
<div style="background-image: url(<?php echo $theme?>images/things1.jpg);" class="thingTodo__banner">
    <div class="thingTodo__title container-auto">
        <p class="medium"><?php echo t('Thing to do');?></p>
    </div>
</div>

<?php if(count($data['list']) > 0):?>
    <?php $i = 0;foreach ($data['list'] as $ob):
        $html_left = '';
        $html_rightt = '';
        $summary = trim($ob['summary']);
        if($summary == '') {
            $summary = truncate_utf8($ob['body_value'],800);
        }
        $summary  = '<p>'.strip_tags($summary).'</p>';
        $view_more = '
        <a href="'.base_path().drupal_get_path_alias('detail/'.$ob['nid']).'" class="btn btn-outline-orange btn-lg mt10">
                                <div class="flexIcon">
                                    <p>'.t('View more').'</p>
                                    '.view_more_icon().'
                                </div>
                            </a>
        ';
        $cls_num_img = '';
        if($i % 2 == 0) {
            if(isset($ob['thumbnail']) && isset($ob['thumbnail2'])){
                $class_width = 'image-50';
            }else{
                $class_width = 'image-100';
            }
            $img1 = isset($ob['thumbnail'])?'<div class="image__child '.$class_width.'">'.'<img src="'.$ob['thumbnail'].'" />'.'</div>':'';
            $img2 = isset($ob['thumbnail2'])?'<div class="image__child '.$class_width.'">'.'<img src="'.$ob['thumbnail2'].'" />'.'</div>':'';
            $html_left = '<div class="destinations__image">'.$img1.$img2.'</div>';
            $html_right = '<p class="colorBluedark900 text28 medium node-title">'.$ob['title'].'</p>'.$summary.$view_more;
        } else {
            if(isset($ob['thumbnail']) && isset($ob['thumbnail2'])){
                $class_width = 'image-50';
            }else{
                $class_width = 'image-100';
            }
            $img1 = isset($ob['thumbnail'])?'<div class="image__child '.$class_width.'">'.'<img src="'.$ob['thumbnail'].'" />'.'</div>':'';
            $img2 = isset($ob['thumbnail2'])?'<div class="image__child '.$class_width.'">'.'<img src="'.$ob['thumbnail2'].'" />'.'</div>':'';
            $html_right = '<div class="destinations__image">'.$img1.$img2.'</div>';
            $html_left = '<p class="colorBluedark900 text28 medium node-title">'.$ob['title'].'</p>'.$summary.$view_more;
        }
        ?>
        <div style="background-image: url(<?php echo $theme?>images/destinations7.jpg);" class="destinations__item">
            <div class="container-auto">
                <div class="destinations__main">
                    <div class="row">
                        <div class="col-6">
                                <?php echo $html_left?>
                        </div>
                        <div class="col-6">
                            <?php echo $html_right;?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php $i++; endforeach;?>

<?php endif;?>