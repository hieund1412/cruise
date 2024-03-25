<?php
$theme = '/sites/all/themes/newtheme/';
$hot_news = array_splice($data['hot_news'],1,5);
$special_offers = array_splice($data['special_offers'],0,count($data['special_offers']));
$travel_advisor = array_splice($data['travel_advisor'],0,count($data['travel_advisor']));
//print_r($hot_news);die;
?>

<div style="background-image: url(<?php echo $theme?>images/news1.jpg);" class="newBanner">
    <div class="newTitle container-auto">
        <p class="medium"><?php echo t('News');?></p>
    </div>
</div>
<div class="newFlex__group">
    <div class="container-auto">
        <div class="row">
            <div class="col-6">
                <a href="<?php echo base_path().drupal_get_path_alias('detail/'.$hot_news[0]['nid'])?>">
                    <div class="newFlex__card">
                        <img src="<?php echo isset($hot_news[0]['thumbnail'])?$hot_news[0]['thumbnail']:''?>" />
                        <div class="newFlex__cont">
                            <p class="text20 colorWhite medium"><?php echo $hot_news[0]['title']?></p>

                        </div>
                    </div>
                </a>
            </div>
            <div class="col-6">
                <div class="newFlex__main">
                    <?php for ($i = 1; $i < count($hot_news); $i++):?>
                        <div class="newFlex__col" nid="<?php echo $hot_news[$i]['nid']?>">
                            <a href="<?php echo base_path().drupal_get_path_alias('detail/'.$hot_news[$i]['nid'])?>">
                                <div class="newFlex__item">
                                    <img src="<?php echo isset($hot_news[$i]['thumbnail'])?$hot_news[$i]['thumbnail']:''?>" />
                                    <div class="newItem__cont">
                                        <p class="colorBluedark900 medium">
                                            <?php echo $hot_news[$i]['title']?>
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php endfor;?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="newPost__group">
    <div class="container-auto">
        <div class="title1"><span><?php echo t('Special offers');?></span></div>
        <div class="newPost__row showDesktop slick-slider">
            <?php for($i = 0; $i < count($special_offers); $i++):?>
            <div class="newPost__item"  nid="<?php echo $special_offers[$i]['nid']?>">
                <div class="newPost">
                    <a href="<?php echo base_path().drupal_get_path_alias('detail/'.$special_offers[$i]['nid'])?>">
                        <div class="newPost__img">
                            <img src="<?php echo isset($special_offers[$i]['thumbnail'])?$special_offers[$i]['thumbnail']:''?>" />
                        </div>
                        <div class="newPost__cont">
                            <p class="text14 colorBluedark900 medium">
                                <?php echo $special_offers[$i]['title']?>
                            </p>
                            <p class="colorBluedark900"><?php echo isset($special_offers[$i]['summary'])?$special_offers[$i]['summary']:truncate_utf8($special_offers[$i]['summary'],500,true)?></p>
                        </div>
                    </a>
                </div>
            </div>
            <?php endfor;?>
        </div>

        <div class="newPost__row_mobi showMobile slick-slider">
            <?php for($i = 0; $i < count($special_offers); $i++):?>
                <div class="newPost__item"  nid="<?php echo $special_offers[$i]['nid']?>">
                    <div class="newPost">
                        <a href="<?php echo base_path().drupal_get_path_alias('detail/'.$special_offers[$i]['nid'])?>">
                            <div class="newPost__img">
                                <img src="<?php echo isset($special_offers[$i]['thumbnail'])?$special_offers[$i]['thumbnail']:''?>" />
                            </div>
                            <div class="newPost__cont">
                                <p class="text14 colorBluedark900 medium">
                                    <?php echo $special_offers[$i]['title']?>
                                </p>
                                <p class="colorBluedark900"><?php echo isset($special_offers[$i]['summary'])?$special_offers[$i]['summary']:truncate_utf8($special_offers[$i]['summary'],500,true)?></p>
                            </div>
                        </a>
                    </div>
                </div>
            <?php endfor;?>
        </div>
    </div>
</div>
<div class="newPost__slide">
    <div class="container-auto">
        <div class="title1"><span><?php echo t('Travel advisor');?></span></div>
        <div class="postSlide__row showDesktop slick-slider">
            <?php for($i = 0; $i < count($travel_advisor); $i++):?>
                <div class="postSlide__item"  nid="<?php echo $travel_advisor[$i]['nid']?>">
                    <a href="<?php echo base_path().drupal_get_path_alias('detail/'.$travel_advisor[$i]['nid'])?>">
                        <div class="postSlide__img">
                            <img src="<?php echo isset($travel_advisor[$i]['thumbnail'])?$travel_advisor[$i]['thumbnail']:''?>" />
                        </div>
                        <div class="postSlide__cont">
                            <p class="text14 colorBluedark900 medium">
                                    <?php echo $travel_advisor[$i]['title']?>
                            </p>
                        </div>
                    </a>
                </div>
            <?php endfor;?>
        </div>
        <div class="postSlide__row_mobi showMobile slick-slider">
            <?php for($i = 0; $i < count($travel_advisor); $i++):?>
                <div class="postSlide__item">
                    <a href="<?php echo base_path().drupal_get_path_alias('detail/'.$travel_advisor[$i]['nid'])?>">
                        <div class="postSlide__img">
                            <img src="<?php echo isset($travel_advisor[$i]['thumbnail'])?$travel_advisor[$i]['thumbnail']:''?>" />
                        </div>
                        <div class="postSlide__cont">
                            <p class="text14 colorBluedark900 medium"> <?php echo $travel_advisor[$i]['title']?></p>
                        </div>
                    </a>
                </div>
            <?php endfor;?>
        </div>
    </div>
</div>
<script>
    // $(".newPost__row_mobi").slick({
    //     slidesToShow: 1,
    //     slidesToScroll: 1,
    //     //autoplay: true,
    //     speed: 800,
    //     autoplaySpeed: 5000,
    //     arrows: true,
    //     dots: true,
    //     appendArrows: '.appendArrows',
    //     responsive: [
    //         {
    //             breakpoint: 767,
    //             settings: {
    //                 arrows: false
    //             }
    //         }
    //     ]
    // });

    $(".postSlide__group_mobi").slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        //autoplay: true,
        speed: 800,
        autoplaySpeed: 5000,
        arrows: true,
        dots: true,
        appendArrows: '.appendArrows',
        responsive: [
            {
                breakpoint: 767,
                settings: {
                    arrows: false
                }
            }
        ]
    });


    function setBoundries(slick, state) {
        if (state === 'default') {
            slick.find('ul.slick-dots li').eq(4).addClass('n-small-1');
        }
    }
    var slickSlider = $('.slick-slider');
    var maxDots = 5;
    var transformXIntervalNext = -18;
    var transformXIntervalPrev = 18;

    slickSlider.on('init', function (event, slick) {
        $(this).find('ul.slick-dots').wrap("<div class='slick-dots-container'></div>");
        $(this).find('ul.slick-dots li').each(function (index) {
            $(this).addClass('dot-index-' + index);
        });
        $(this).find('ul.slick-dots').css('transform', 'translateX(0)');
        setBoundries($(this),'default');
    });

    var transformCount = 0;
    slickSlider.on('beforeChange', function (event, slick, currentSlide, nextSlide) {
        var totalCount = $(this).find('.slick-dots li').length;
        if (totalCount > maxDots) {
            if (nextSlide > currentSlide) {
                if ($(this).find('ul.slick-dots li.dot-index-' + nextSlide).hasClass('n-small-1')) {
                    if (!$(this).find('ul.slick-dots li:last-child').hasClass('n-small-1')) {
                        transformCount = transformCount + transformXIntervalNext;
                        $(this).find('ul.slick-dots li.dot-index-' + nextSlide).removeClass('n-small-1');
                        var nextSlidePlusOne = nextSlide + 1;
                        $(this).find('ul.slick-dots li.dot-index-' + nextSlidePlusOne).addClass('n-small-1');
                        $(this).find('ul.slick-dots').css('transform', 'translateX(' + transformCount + 'px)');
                        var pPointer = nextSlide - 3;
                        var pPointerMinusOne = pPointer - 1;
                        $(this).find('ul.slick-dots li').eq(pPointerMinusOne).removeClass('p-small-1');
                        $(this).find('ul.slick-dots li').eq(pPointer).addClass('p-small-1');
                    }
                }
            }
            else {
                if ($(this).find('ul.slick-dots li.dot-index-' + nextSlide).hasClass('p-small-1')) {
                    if (!$(this).find('ul.slick-dots li:first-child').hasClass('p-small-1')) {
                        transformCount = transformCount + transformXIntervalPrev;
                        $(this).find('ul.slick-dots li.dot-index-' + nextSlide).removeClass('p-small-1');
                        var nextSlidePlusOne = nextSlide - 1;
                        $(this).find('ul.slick-dots li.dot-index-' + nextSlidePlusOne).addClass('p-small-1');
                        $(this).find('ul.slick-dots').css('transform', 'translateX(' + transformCount + 'px)');
                        var nPointer = currentSlide + 3;
                        var nPointerMinusOne = nPointer - 1;
                        $(this).find('ul.slick-dots li').eq(nPointer).removeClass('n-small-1');
                        $(this).find('ul.slick-dots li').eq(nPointerMinusOne).addClass('n-small-1');
                    }
                }
            }
        }
    });
    $('.slick-slider').slick({
        slidesToShow: 4,
        slidesToScroll: 1,
        dots: true,
        arrows: true,
        focusOnSelect: false,
        infinite: true,
        responsive: [
            {
                breakpoint: 767,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                }
            }
        ]
    });
</script>
<style>
    .slick-dots-container {
        width: 5.5rem;
        overflow: hidden;
        display: block;
        padding: 0;
        margin: 0.625rem auto;
        height: 0.875rem;
        position: relative;
    }

    .slick-dots-container > ul {
        padding: 0;
        display: flex;
        transition: all 0.25s;
        position: relative;
        margin: 0;
        list-style: none;
        transform: translateX(0);
        align-items: center;
        bottom: unset;
        height: 100%;
    }

    .slick-dots-container > ul li.slick-active {
        transform: scale(1.3);
    }
    .slick-dots li button:before {
        display: none;
    }
</style>