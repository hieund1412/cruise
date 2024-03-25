<?php
$theme = base_path().'sites/all/themes/newtheme/';
//var_dump($_SESSION['lang']);
$web_info = web_info_basic();
$admin_email = isset($web_info['field_manager_email']['und'][0]['value'])?$web_info['field_manager_email']['und'][0]['value']:'';

?>

<div class="logo flexIcon">
    <div class="showMobile">
        <div class="logo flexIcon">
            <svg class="showMobile mr15" xmlns="http://www.w3.org/2000/svg" width="24" height="18" viewBox="0 0 24 18" fill="none">
                <path d="M12 18H1.5C1.10218 18 0.720645 17.842 0.43934 17.5607C0.158036 17.2794 0 16.8978 0 16.5C0 16.1022 0.158036 15.7206 0.43934 15.4393C0.720645 15.158 1.10218 15 1.5 15H12C12.3978 15 12.7794 15.158 13.0607 15.4393C13.342 15.7206 13.5 16.1022 13.5 16.5C13.5 16.8978 13.342 17.2794 13.0607 17.5607C12.7794 17.842 12.3978 18 12 18Z" fill="#20265A"></path>
                <path d="M22.5 3H1.5C1.10218 3 0.720645 2.84196 0.43934 2.56066C0.158036 2.27936 0 1.89782 0 1.5C0 1.10218 0.158036 0.720644 0.43934 0.43934C0.720645 0.158035 1.10218 0 1.5 0H22.5C22.8978 0 23.2794 0.158035 23.5607 0.43934C23.842 0.720644 24 1.10218 24 1.5C24 1.89782 23.842 2.27936 23.5607 2.56066C23.2794 2.84196 22.8978 3 22.5 3V3Z" fill="#20265A"></path>
                <path d="M22.5 10.5H1.5C1.10218 10.5 0.720645 10.342 0.43934 10.0607C0.158036 9.77936 0 9.39782 0 9C0 8.60218 0.158036 8.22064 0.43934 7.93934C0.720645 7.65804 1.10218 7.5 1.5 7.5H22.5C22.8978 7.5 23.2794 7.65804 23.5607 7.93934C23.842 8.22064 24 8.60218 24 9C24 9.39782 23.842 9.77936 23.5607 10.0607C23.2794 10.342 22.8978 10.5 22.5 10.5V10.5Z" fill="#20265A"></path>
            </svg>
            <a href="<?php echo base_path()?>">
            <?php echo logo(210);?>
            </a>
        </div>

    </div>
    <div class="showDesktop">
        <a href="<?php echo base_path()?>">
            <?php echo logo(230);?>
        </a>
    </div>


</div>
<div class="headerReaction showMobile">



</div>
<div class="header__group showDesktop">
    <div class="header__sign hidden">
        <p class="medium blueDark"><?php echo t('Sign in');?></p>
    </div>
    <div class="header__lang">
        <div class="dropdown">
            <button type="button" data-toggle="dropdown" class="header__btn">


                    <?php if(isset($_SESSION['lang']) &&  $_SESSION['lang'] == 'en'):?>
                        <img src="<?php echo $theme?>images/lang-england.png" style="width: 30px;height: 20px">
                    <?php elseif(isset($_SESSION['lang']) &&  $_SESSION['lang'] == 'vi'):?>
                        <img src="<?php echo $theme?>images/lang-vietnam.png"  width="40px" height="30px" style="width: 40px;height: 30px">
                    <?php endif;?>

                <svg xmlns="http://www.w3.org/2000/svg" width="10" height="8" viewBox="0 0 10 8" fill="none">
                    <path d="M9.24559 0.405812C9.1762 0.282691 9.07533 0.180229 8.95331 0.108921C8.83128 0.0376131 8.6925 2.25533e-05 8.55117 0H0.796887C0.655634 6.85536e-05 0.516935 0.0376631 0.394983 0.108937C0.273031 0.18021 0.172203 0.282604 0.102818 0.405641C0.0334323 0.528677 -0.00201984 0.667939 8.88697e-05 0.809176C0.00219758 0.950413 0.0417915 1.08855 0.114819 1.20946L3.99196 7.61556C4.06298 7.73289 4.16307 7.82992 4.28255 7.89727C4.40204 7.96462 4.53687 8 4.67403 8C4.81118 8 4.94602 7.96462 5.0655 7.89727C5.18499 7.82992 5.28508 7.73289 5.3561 7.61556L9.23324 1.20946C9.30629 1.08861 9.34592 0.950513 9.34809 0.809309C9.35027 0.668106 9.31489 0.52886 9.24559 0.405812Z" fill="#415092"/>
                </svg>
            </button>
            <div class="dropdown-menu">
                <div class="listLang">
                    <a href="<?php echo base_path().drupal_get_path_alias('lang/en')?>" class="dropdown-item"><img src="<?php echo $theme?>images/lang-england.png"><span>English</span></a>
                    <a href="<?php echo base_path().drupal_get_path_alias('lang/vi')?>" class="dropdown-item"><img src="<?php echo $theme?>images/lang-vietnam.png"><span>Vietnamese</span></a>
                </div>
            </div>
        </div>
    </div>
</div>
<input type="hidden" id="admin_email" value="<?php echo $admin_email?>">

<script>

    $('.homeLeft__button').click(function () {
        if ($(window).width() > 767) {
            $(this).parents('.homeLeft').toggleClass('MvE2');
            if($('.homeLeft').hasClass('MvE2')){
                $('.homeRight').addClass('MvE1');
                $('.footer').addClass('MvE1');

            }else {
                $('.homeRight').removeClass('MvE1');
                $('.footer').removeClass('MvE1');
            }
        }else {
            $('.homeLeft').removeClass('open');


        }

    });
    $('.logo svg').click(function () {
        $(this).parents('section').find('.homeLeft').addClass('open');

    });


</script>

