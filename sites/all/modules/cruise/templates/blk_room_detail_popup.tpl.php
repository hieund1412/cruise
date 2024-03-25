<?php


$cruise_img = $data['info']['cruise_image'];

?>
<div id="roomDetailPopup"  class="modal fade">
    <div class="modal-dialog" >
        <div class="modal-content" >
            <div class="modal-body">
                <button type="button" data-dismiss="modal" class="close">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="svg1point5">
                        <path d="M14.3001 12.1788C14.2768 12.1556 14.2584 12.128 14.2458 12.0976C14.2332 12.0672 14.2267 12.0347 14.2267 12.0018C14.2267 11.9689 14.2332 11.9364 14.2458 11.906C14.2584 11.8756 14.2768 11.848 14.3001 11.8248L23.5631 2.5628C23.8444 2.28114 24.0022 1.89928 24.002 1.50124C24.0017 1.10319 23.8433 0.721561 23.5616 0.440299C23.28 0.159037 22.8981 0.00118392 22.5001 0.00146522C22.102 0.00174652 21.7204 0.160139 21.4391 0.441799L12.1771 9.6998C12.1539 9.72308 12.1263 9.74155 12.0959 9.75416C12.0656 9.76676 12.033 9.77325 12.0001 9.77325C11.9672 9.77325 11.9347 9.76676 11.9043 9.75416C11.8739 9.74155 11.8463 9.72308 11.8231 9.6998L2.56113 0.441799C2.42186 0.302467 2.25651 0.191929 2.07453 0.116498C1.89254 0.0410666 1.69748 0.00221873 1.50048 0.0021723C1.10262 0.00207854 0.721022 0.160037 0.439627 0.441299C0.158232 0.722561 9.38099e-05 1.10409 4.17235e-08 1.50195C-9.37265e-05 1.8998 0.157865 2.2814 0.439127 2.5628L9.70013 11.8248C9.72341 11.848 9.74188 11.8756 9.75448 11.906C9.76709 11.9364 9.77357 11.9689 9.77357 12.0018C9.77357 12.0347 9.76709 12.0672 9.75448 12.0976C9.74188 12.128 9.72341 12.1556 9.70013 12.1788L0.439127 21.4418C0.29986 21.5811 0.189401 21.7465 0.114055 21.9286C0.0387096 22.1106 -4.63876e-05 22.3057 4.17235e-08 22.5027C9.38099e-05 22.9005 0.158232 23.282 0.439627 23.5633C0.57896 23.7026 0.744358 23.813 0.92638 23.8884C1.1084 23.9637 1.30348 24.0025 1.50048 24.0024C1.89834 24.0023 2.27987 23.8442 2.56113 23.5628L11.8231 14.2998C11.8463 14.2765 11.8739 14.258 11.9043 14.2454C11.9347 14.2328 11.9672 14.2264 12.0001 14.2264C12.033 14.2264 12.0656 14.2328 12.0959 14.2454C12.1263 14.258 12.1539 14.2765 12.1771 14.2998L21.4391 23.5628C21.7204 23.8442 22.1019 24.0023 22.4998 24.0024C22.8976 24.0025 23.2792 23.8446 23.5606 23.5633C23.842 23.282 24.0002 22.9005 24.0003 22.5027C24.0003 22.1048 23.8424 21.7232 23.5611 21.4418L14.3001 12.1788Z" fill="black" fill-opacity="1"></path>
                    </svg>
                </button>
                <div class="roomPopup__body">
                    <div class="roomPopup__top">
                        <div class="roomPopup__image">
                            <img src="<?php echo $img_first?>">
                        </div>

                        <div class="roomPopup__amenities">
                            <p class="text24 medium blueDark room_title"></p>
                            <div class="room_summary">summary</div>
                            <p class="text24 medium blueDark"><?php echo t('Most Popular Amenities');?></p>
                            <div class="amenities__item">
                                <ul>
                                    <li class="blueDark"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="13" viewBox="0 0 16 13" fill="none">
                                            <path d="M3.33301 6.36667C4.65072 5.26912 6.31141 4.66809 8.02634 4.66809C9.74127 4.66809 11.402 5.26912 12.7197 6.36667" stroke="#5C6AA1" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M0.946289 3.99998C2.89457 2.28263 5.40249 1.33508 7.99962 1.33508C10.5968 1.33508 13.1047 2.28263 15.053 3.99998" stroke="#5C6AA1" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M5.68652 8.74002C6.36332 8.25918 7.17297 8.00085 8.00319 8.00085C8.83341 8.00085 9.64306 8.25918 10.3199 8.74002" stroke="#5C6AA1" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M8 11.3334H8.00667" stroke="#5C6AA1" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg><?php echo t('Free wifi');?></li>

                                </ul>

                            </div>

                        </div>
                    </div>
                    <div class="roomPopup__bottom">
                        <div class="roomType__item">
                            <div class="roomType__item__cont">
                                <p class="text16 medium blueDark"><?php echo t('All');?> (<span id="total_img"></span>)</p>
                            </div>
                            <div class="roomType__item__cont">
                                <p class="text16 medium blueDark"><?php echo t('Rooms');?> (<span id="total_img_room"></span>)</p>
                            </div>
                            <div class="roomType__item__cont">
                                <p class="text16 medium blueDark"><?php echo t('Overview');?> (<span id="total_overview"><?php echo count($cruise_img);?></span>)</p>
                            </div>

                        </div>
                        <div class="roomType__image" style="cursor: pointer;">
                            <?php if(count($cruise_img)):?>
                                <?php for($i = 0; $i < count($cruise_img); $i++):
                                    $img = $cruise_img[$i];
                                    ?>
                                    <div class="roomType__item__img">
                                            <img src="<?php echo $img?>">
                                    </div>
                                <?php endfor;?>
                            <?php endif;?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>