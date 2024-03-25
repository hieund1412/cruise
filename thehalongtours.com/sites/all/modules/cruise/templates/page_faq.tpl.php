<?php
$theme = '/sites/all/themes/newtheme/';


?>
<div style="background-image: url(<?php echo $theme?>images/faq.jpg);" class="yourCruise__banner">
    <div class="faqTitle container-auto">
        <p class="medium">FAQS</p>
    </div>
</div>
<div class="faq__body">
    <div class="container-auto">
        <div class="row">
            <div class="col-md-12">
                <?php if(count($data['faq']) > 0):?>
                    <?php foreach ($data['faq'] as $ob):?>
                        <div class="faq__item">
                            <div class="faq__title">
                                <div class="titleText"><span class="medium colorBluedark900 text16"><?php echo $ob['title']?></span></div>
                                <div class="titleIcon">
                                    <svg class="plusIcon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="12" cy="12" r="12" fill="#5C6AA1"/>
                                        <g clip-path="url(#clip0_1831_17085)">
                                            <path d="M17.25 11.25H12.75V6.75C12.75 6.3 12.45 6 12 6C11.55 6 11.25 6.3 11.25 6.75V11.25H6.75C6.3 11.25 6 11.55 6 12C6 12.45 6.3 12.75 6.75 12.75H11.25V17.25C11.25 17.7 11.55 18 12 18C12.45 18 12.75 17.7 12.75 17.25V12.75H17.25C17.7 12.75 18 12.45 18 12C18 11.55 17.7 11.25 17.25 11.25Z" fill="white"/>
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_1831_17085">
                                                <rect width="12" height="12" fill="white" transform="translate(6 6)"/>
                                            </clipPath>
                                        </defs>
                                    </svg>
                                    <svg class="minusIcon" style="display: none" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="12" cy="12" r="12" fill="#5C6AA1"/>
                                        <path d="M12.75 11.25H17.25C17.7 11.25 18 11.55 18 12C18 12.45 17.7 12.75 17.25 12.75H12.75H11.25H6.75C6.3 12.75 6 12.45 6 12C6 11.55 6.3 11.25 6.75 11.25H11.25H12.75Z" fill="white"/>
                                    </svg>

                                </div>
                            </div>
                            <div class="faq__cont" style="display: none;">
                                <p class="colorBluedark900 mt10">
                                    <?php echo replace_body($ob['body_value']);?>
                                </p>
                            </div>
                        </div>
                    <?php endforeach;?>
                <?php endif;?>
            </div>

        </div>
    </div>
</div>

<script>

    $('.faq__cont').slideUp();
    $('.faq__title').click(function () {
        $(this).next().slideToggle();
        $(this).find('.titleIcon').toggleClass('active')

    })

</script>