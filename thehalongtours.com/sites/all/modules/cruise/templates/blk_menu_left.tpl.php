<?php
$theme = base_path(). 'sites/all/themes/newtheme/';
?>
<div class="homeLeft">
    <div class="homeLeft__main">
        <div class="homeLeft__option">
            <div class="homeLeft__tab">
                <div class="tabHeader">
                    <button class="homeLeft__button">
                        <span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="18" viewBox="0 0 24 18" fill="none">
                        <path d="M12 18H1.5C1.10218 18 0.720645 17.842 0.43934 17.5607C0.158036 17.2794 0 16.8978 0 16.5C0 16.1022 0.158036 15.7206 0.43934 15.4393C0.720645 15.158 1.10218 15 1.5 15H12C12.3978 15 12.7794 15.158 13.0607 15.4393C13.342 15.7206 13.5 16.1022 13.5 16.5C13.5 16.8978 13.342 17.2794 13.0607 17.5607C12.7794 17.842 12.3978 18 12 18Z" fill="#20265A"/>
                        <path d="M22.5 3H1.5C1.10218 3 0.720645 2.84196 0.43934 2.56066C0.158036 2.27936 0 1.89782 0 1.5C0 1.10218 0.158036 0.720644 0.43934 0.43934C0.720645 0.158035 1.10218 0 1.5 0H22.5C22.8978 0 23.2794 0.158035 23.5607 0.43934C23.842 0.720644 24 1.10218 24 1.5C24 1.89782 23.842 2.27936 23.5607 2.56066C23.2794 2.84196 22.8978 3 22.5 3V3Z" fill="#20265A"/>
                        <path d="M22.5 10.5H1.5C1.10218 10.5 0.720645 10.342 0.43934 10.0607C0.158036 9.77936 0 9.39782 0 9C0 8.60218 0.158036 8.22064 0.43934 7.93934C0.720645 7.65804 1.10218 7.5 1.5 7.5H22.5C22.8978 7.5 23.2794 7.65804 23.5607 7.93934C23.842 8.22064 24 8.60218 24 9C24 9.39782 23.842 9.77936 23.5607 10.0607C23.2794 10.342 22.8978 10.5 22.5 10.5V10.5Z" fill="#20265A"/>
                    </svg></span>
                    </button>
                    <p class="showMobile">
                        <a href="<?php echo base_path()?>">
                        <?php echo logo(210);?>
                        </a>
                    </p>
                </div>

            </div>
            <div class="homeLeft__group">
                <div class="homeLeft__icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="18" viewBox="0 0 25 18" fill="none">
                        <path d="M23.1663 8.62007L12.2498 1.90181L1.33329 8.62007C0.921161 8.87294 0.382161 8.74519 0.130161 8.33307C-0.123589 7.92182 0.005036 7.38282 0.417161 7.12994L11.7922 0.129938C12.073 -0.0433125 12.4283 -0.0433125 12.7092 0.129938L24.0842 7.12994C24.4963 7.38369 24.624 7.92182 24.3712 8.33307C24.1157 8.74694 23.5749 8.87207 23.1663 8.62007Z" fill="#5562DA"/>
                        <path d="M21 8.82747V17.4996H14.875V10.9371C14.875 10.6956 14.679 10.4996 14.4375 10.4996H10.0625C9.821 10.4996 9.625 10.6956 9.625 10.9371V17.4996H3.5V8.82747L12.25 3.4436L21 8.82747Z" fill="#5562DA"/>
                    </svg>
                    <p class="medium blueDark"><a href="<?php echo base_path()?>"><?php echo t('Home');?></a></p>
                </div>
                <div class="homeLeft__icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="15" viewBox="0 0 24 15" fill="none">
                        <path d="M23.3077 5.07689C23.6901 5.07689 24 4.7669 24 4.38459V0.692296C24 0.309937 23.69 0 23.3077 0H8.07694V3.46153C8.07694 3.84389 7.76695 4.15383 7.38464 4.15383C7.00233 4.15383 6.69234 3.84384 6.69234 3.46153V0H0.692344C0.309984 0 0 0.309937 0 0.692296V4.38459C0 4.76695 0.309984 5.07689 0.692297 5.07689C1.8375 5.07689 2.76923 6.00858 2.76923 7.15382C2.76923 8.29907 1.83755 9.23076 0.692297 9.23076C0.309984 9.23076 0 9.5407 0 9.92306V13.6154C0 13.9977 0.309984 14.3076 0.692297 14.3076H6.6923V10.8461C6.6923 10.4638 7.00228 10.1538 7.38459 10.1538C7.76691 10.1538 8.07689 10.4638 8.07689 10.8461V14.3076H23.3077C23.69 14.3076 24 13.9977 24 13.6154V9.92306C24 9.5407 23.69 9.23076 23.3077 9.23076C22.1625 9.23076 21.2307 8.29907 21.2307 7.15382C21.2307 6.00858 22.1625 5.07689 23.3077 5.07689ZM8.07694 8.07689C8.07694 8.45925 7.76695 8.76918 7.38464 8.76918C7.00233 8.76918 6.69234 8.4592 6.69234 8.07689V6.23072C6.69234 5.84836 7.00233 5.53842 7.38464 5.53842C7.76695 5.53842 8.07694 5.8484 8.07694 6.23072V8.07689Z" fill="#5C6AA1"/>
                    </svg>
                    <p class="medium blueDark"><a href="<?php echo base_path().drupal_get_path_alias('thing-to-do')?>"><?php  echo t('Things to do');?></a></p>
                </div>
                <div class="homeLeft__icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="24" viewBox="0 0 18 24" fill="none">
                        <path d="M8.99967 0.333252C4.48467 0.333252 0.833008 3.98492 0.833008 8.49992C0.833008 14.6249 8.99967 23.6666 8.99967 23.6666C8.99967 23.6666 17.1663 14.6249 17.1663 8.49992C17.1663 3.98492 13.5147 0.333252 8.99967 0.333252ZM8.99967 11.4166C7.38967 11.4166 6.08301 10.1099 6.08301 8.49992C6.08301 6.88992 7.38967 5.58325 8.99967 5.58325C10.6097 5.58325 11.9163 6.88992 11.9163 8.49992C11.9163 10.1099 10.6097 11.4166 8.99967 11.4166Z" fill="#5C6AA1"/>
                    </svg>
                    <p class="medium blueDark"><a href="<?php echo base_path().drupal_get_path_alias('destination')?>"><?php echo t('Destinations');?></a></p>
                </div>
                <div class="homeLeft__icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="19" viewBox="0 0 20 19" fill="none">
                        <path d="M19.4548 0H5.27172C4.97047 0 4.72615 0.241501 4.72615 0.53928V16.7157C4.72415 17.3008 4.52778 17.8693 4.16699 18.3333H17.2729C18.7785 18.3318 19.9987 17.1256 20.0003 15.6371V0.53928C20.0003 0.241501 19.756 0 19.4548 0V0ZM16.1817 14.0195H8.54474C8.24349 14.0195 7.99917 13.7782 7.99917 13.4804C7.99917 13.1826 8.24349 12.9411 8.54474 12.9411H16.1817C16.483 12.9411 16.7273 13.1826 16.7273 13.4804C16.7273 13.7782 16.483 14.0195 16.1817 14.0195ZM16.1817 10.7842H8.54474C8.24349 10.7842 7.99917 10.5429 7.99917 10.2451C7.99917 9.94735 8.24349 9.70585 8.54474 9.70585H16.1817C16.483 9.70585 16.7273 9.94735 16.7273 10.2451C16.7273 10.5429 16.483 10.7842 16.1817 10.7842ZM16.1817 7.54893H8.54474C8.24349 7.54893 7.99917 7.30762 7.99917 7.00984C7.99917 6.71207 8.24349 6.47056 8.54474 6.47056H16.1817C16.483 6.47056 16.7273 6.71207 16.7273 7.00984C16.7273 7.30762 16.483 7.54893 16.1817 7.54893ZM16.1817 4.31364H8.54474C8.24349 4.31364 7.99917 4.07234 7.99917 3.77456C7.99917 3.47678 8.24349 3.23528 8.54474 3.23528H16.1817C16.483 3.23528 16.7273 3.47678 16.7273 3.77456C16.7273 4.07234 16.483 4.31364 16.1817 4.31364Z" fill="#5C6AA1"/>
                        <path d="M2.77771 2.5H0.555623C0.24882 2.5 0 2.73619 0 3.02765V16.75C0 17.6244 0.746257 18.3333 1.66667 18.3333C2.58708 18.3333 3.33333 17.6244 3.33333 16.75V3.02765C3.33333 2.73619 3.08451 2.5 2.77771 2.5Z" fill="#5C6AA1"/>
                    </svg>
                    <p class="medium blueDark"><a href="<?php echo base_path().drupal_get_path_alias('news')?>"><?php echo t('News');?></a></p>
                </div>
                <div class="homeLeft__icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" viewBox="0 0 23 23" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M6.37169 11.5158H1.06796C0.479734 11.5158 0 11.0361 0 10.4478V1.06796C0 0.479733 0.479781 0 1.06796 0H16.1518C16.4657 0 16.7359 0.120339 16.9458 0.353757L18.5028 2.08466L14.1079 2.42886C13.5788 2.47028 13.1201 2.71927 12.7971 3.14029L6.37169 11.5158ZM3.78159 2.78443C3.23493 2.78443 2.79184 3.22752 2.79184 3.77418C2.79184 4.32085 3.23493 4.76394 3.78159 4.76394C4.32826 4.76394 4.77135 4.32085 4.77135 3.77418C4.77135 3.22752 4.32826 2.78443 3.78159 2.78443ZM7.21492 2.65549L3.04613 8.4582C2.92331 8.62889 2.96205 8.8668 3.13274 8.98967C3.30344 9.11249 3.54134 9.07375 3.66421 8.90311L7.833 3.1004C7.95583 2.92971 7.91708 2.69175 7.74639 2.56893C7.5757 2.44606 7.33774 2.4848 7.21492 2.65549ZM7.09396 6.75181C6.5473 6.75181 6.10421 7.1949 6.10421 7.74156C6.10421 8.28822 6.5473 8.73132 7.09396 8.73132C7.64062 8.73132 8.08372 8.28822 8.08372 7.74156C8.08376 7.19495 7.64062 6.75181 7.09396 6.75181Z" fill="#5C6AA1"/>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M22.5399 10.615C22.7309 10.366 22.7999 10.0783 22.7425 9.76971L21.8154 4.78362C21.6963 4.14376 21.4944 3.58744 20.978 3.19126C20.4616 2.79509 19.872 2.74406 19.2231 2.79489L14.1671 3.19088C13.8541 3.21539 13.5942 3.35651 13.4031 3.60555L4.22183 15.5733C3.86382 16.04 3.95239 16.7127 4.41909 17.0707L11.8613 22.7801C12.328 23.1381 13.0006 23.0495 13.3586 22.5828L22.5399 10.615ZM18.1023 5.30884C17.7685 5.74385 17.8507 6.36705 18.2857 6.70079C18.7207 7.03453 19.3439 6.95241 19.6776 6.51739C20.0114 6.08237 19.9293 5.45918 19.4942 5.12544C19.0592 4.7917 18.436 4.87382 18.1023 5.30884ZM18.5185 9.1575L17.5087 10.4743L14.5109 8.17524C14.3436 8.04745 14.1043 8.07951 13.9764 8.2469C13.8487 8.41425 13.8808 8.65354 14.0481 8.78138L17.3477 11.312C17.5151 11.4397 17.7544 11.4076 17.8822 11.2403L19.1246 9.62032C19.2524 9.45297 19.2204 9.21368 19.053 9.08584C18.8856 8.95805 18.6463 8.99015 18.5185 9.1575ZM15.5371 13.9288L14.9416 13.0697L15.7347 12.0357L16.7187 12.3881C16.9174 12.459 17.136 12.3554 17.2069 12.1567C17.2779 11.9579 17.1743 11.7394 16.9755 11.6685L12.8641 10.1964L12.8638 10.1973C12.7523 10.1577 12.624 10.1703 12.5192 10.2426C12.3461 10.3621 12.3026 10.5995 12.4222 10.7726L14.9101 14.3617C15.0296 14.5348 15.2669 14.5783 15.4401 14.4587C15.6132 14.3393 15.6567 14.1019 15.5371 13.9288ZM13.7265 11.3167L14.4855 12.4116L14.9808 11.7658L13.7265 11.3167ZM14.1857 14.807C14.3135 14.6396 14.5528 14.6075 14.7202 14.7353C14.8876 14.8631 14.9197 15.1024 14.7919 15.2698L13.5495 16.8897C13.4217 17.0571 13.1824 17.0892 13.015 16.9614L9.71536 14.4308C9.54801 14.303 9.51591 14.0638 9.6437 13.8964L10.8861 12.2764C11.0139 12.109 11.2532 12.0769 11.4206 12.2047C11.588 12.3325 11.6201 12.5718 11.4923 12.7392L10.4814 14.0573L11.5261 14.8585L12.1735 14.0143C12.3013 13.8469 12.5406 13.8148 12.708 13.9426C12.8753 14.0704 12.9074 14.3097 12.7796 14.4771L12.1312 15.3226L13.1759 16.1238L14.1857 14.807ZM7.57796 16.5899L8.1992 15.7799C8.43419 15.4735 8.77304 15.291 9.12967 15.244C9.48557 15.1971 9.8593 15.2851 10.1649 15.5194L11.8445 16.8076C12.1509 17.0426 12.3334 17.3815 12.3804 17.7381C12.4273 18.094 12.3393 18.4677 12.1049 18.7733L11.4837 19.5833C11.3559 19.7506 11.1166 19.7827 10.9492 19.6549L7.64962 17.1244C7.48222 16.9966 7.45017 16.7573 7.57796 16.5899ZM8.80529 16.2427C8.91192 16.1036 9.06594 16.0208 9.22817 15.9995C9.39103 15.978 9.56215 16.0183 9.70203 16.1256L11.3817 17.4138C11.5207 17.5204 11.6036 17.6744 11.6249 17.8366C11.6464 17.9995 11.6061 18.1706 11.4988 18.3105L11.1101 18.8173L8.41565 16.7508L8.80529 16.2427Z" fill="#5C6AA1"/>
                    </svg>
                    <p class="medium blueDark"><a href="<?php echo base_path().drupal_get_path_alias('deals')?>"><?php echo t('Hot deals');?></a></p>
                </div>
            </div>
            <div class="homeLeft__group">
                <div class="homeLeft__icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" viewBox="0 0 23 23" fill="none">
                        <path d="M23.0005 15.5238C23.0005 12.6537 21.354 10.0922 18.888 8.84619C18.8114 14.3493 14.3498 18.8109 8.84668 18.8875C10.0927 21.3535 12.6542 23 15.5243 23C16.87 23 18.1786 22.6416 19.3284 21.9607L22.9679 22.9674L21.9612 19.3279C22.6421 18.1781 23.0005 16.8695 23.0005 15.5238Z" fill="#5C6AA1"/>
                        <path d="M16.8077 8.40385C16.8077 3.76988 13.0378 0 8.40385 0C3.76988 0 0 3.76988 0 8.40385C0 9.91408 0.40199 11.3845 1.16534 12.6755L0.0308965 16.7766L4.13224 15.6424C5.42317 16.4057 6.89361 16.8077 8.40385 16.8077C13.0378 16.8077 16.8077 13.0378 16.8077 8.40385ZM7.11425 6.44796H5.82466C5.82466 5.02572 6.9816 3.86878 8.40385 3.86878C9.82609 3.86878 10.983 5.02572 10.983 6.44796C10.983 7.16983 10.6774 7.86366 10.1443 8.35129L9.04864 9.35408V10.3597H7.75905V8.78619L9.27365 7.39988C9.54433 7.1522 9.69344 6.81419 9.69344 6.44796C9.69344 5.73684 9.11497 5.15837 8.40385 5.15837C7.69272 5.15837 7.11425 5.73684 7.11425 6.44796ZM7.75905 11.6493H9.04864V12.9389H7.75905V11.6493Z" fill="#5C6AA1"/>
                    </svg>
                    <p class="medium blueDark"><a href="<?php echo base_path().drupal_get_path_alias('faq')?>"><?php echo t('FAQ');?></a></p>
                </div>
                <div class="homeLeft__icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="23" viewBox="0 0 25 23" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M14.875 21.2829C14.875 20.4727 14.1959 19.8159 13.3582 19.8159H11.5009C11.0987 19.8159 10.7129 19.9705 10.4284 20.2456C10.144 20.5207 9.98415 20.8939 9.98415 21.2829C9.98415 22.0932 10.6632 22.75 11.5009 22.75H13.3582C14.1959 22.75 14.875 22.0932 14.875 21.2829ZM3.5 17.5C3.75335 17.5187 4.05985 17.5295 4.36773 17.512C4.53175 18.3166 4.93923 19.0628 5.54746 19.6511C6.35493 20.4321 7.45007 20.8709 8.59198 20.8709H9.17072C9.1452 21.0059 9.13209 21.1438 9.13209 21.2829C9.13209 21.4236 9.1452 21.5614 9.17034 21.695H8.59198C7.22408 21.695 5.91219 21.1694 4.94496 20.2339C4.17332 19.4875 3.67141 18.529 3.5 17.5Z" fill="#5C6AA1"/>
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M2.7852 16.5388C2.10518 16.4251 1.47239 16.1047 0.978421 15.6151C0.351948 14.9942 0 14.152 0 13.2739V11.2563C0 10.3781 0.351948 9.536 0.978421 8.91509C1.60489 8.29418 2.45459 7.94531 3.34057 7.94531H3.56293C3.91837 3.49879 7.67195 0 12.25 0C16.8281 0 20.5816 3.49879 20.9371 7.94531H21.1594C22.0454 7.94531 22.8951 8.29418 23.5216 8.91509C24.1481 9.536 24.5 10.3781 24.5 11.2563V13.2739C24.5 14.152 24.1481 14.9942 23.5216 15.6151C22.8951 16.236 22.0454 16.5849 21.1594 16.5849H20.1736C19.7648 16.5849 19.4334 16.2563 19.4334 15.8512V8.63722C19.4334 4.70518 16.2173 1.51765 12.25 1.51765C8.28272 1.51765 5.06662 4.70518 5.06662 8.63722V15.8512C5.06662 16.1372 4.90139 16.3851 4.66031 16.5061C3.99671 16.7343 2.96756 16.5693 2.7852 16.5388Z" fill="#5C6AA1"/>
                    </svg>
                    <p class="medium blueDark">
                        <a href="<?php echo base_path().drupal_get_path_alias('contactus')?>"><?php echo t('Contact us');?></a>
                    </p>
                </div>
            </div>
        </div>


        <div class="homeLeft__language showMobile">
            <div class="header__lang">
                <div class="dropdown">
                    <p class="colorBluedark900 selectLang">&nbsp;</p>
                    <button type="button" data-toggle="dropdown" class="header__btn" aria-expanded="false">
                        <div class="langButton__title">
                            <?php if(isset($_SESSION['lang']) && $_SESSION['lang'] == 'en'):?>
                                <img src="<?php echo $theme?>images/lang-england.png" style="width: 40px;height: 30px" width="40px" height="30px">
                                <p class="text16 colorBluedark900 medium">English</p>
                            <?php elseif(isset($_SESSION['lang']) &&  $_SESSION['lang'] == 'vi'):?>
                                <img src="<?php echo $theme?>images/lang-vietnam.png"  width="40px" height="30px" style="width: 40px;height: 30px">
                                <p class="text16 colorBluedark900 medium">Vietnamese</p>
                            <?php endif;?>


                        </div>

                        <svg width="8" height="14" viewBox="0 0 8 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M0.292893 13.7071C-0.0976315 13.3166 -0.0976316 12.6834 0.292893 12.2929L5.58579 7L0.292892 1.70711C-0.0976326 1.31658 -0.0976326 0.683418 0.292892 0.292894C0.683416 -0.0976308 1.31658 -0.0976309 1.70711 0.292894L7.70711 6.29289C8.09763 6.68342 8.09763 7.31658 7.70711 7.70711L1.70711 13.7071C1.31658 14.0976 0.683417 14.0976 0.292893 13.7071Z" fill="#5C6AA1"/>
                        </svg>
                    </button>
                    <div class="dropdown-menu" style="">
                        <div class="listLang">
                            <a href="<?php echo base_path().drupal_get_path_alias('lang/en')?>" class="dropdown-item"><img src="<?php echo $theme?>images/lang-england.png"><span>English</span></a>
                            <a href="<?php echo base_path().drupal_get_path_alias('lang/vi')?>" class="dropdown-item"><img src="<?php echo $theme?>images/lang-vietnam.png"><span>Vietnamese</span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id='arcontactus'></div>

    <div style="font-size: 13px" class="blueDark copyright">

        Copyright © <?php echo date('Y');?>
    </div>
</div>