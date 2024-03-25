<?php
$type = $data['type'];
$tran = $data['tran'];
$nationality = taxonomy_vocabulary_machine_name_load('nationality ')->vid;
$nationality = taxonomy_get_tree($nationality,0,1);
//adult
$search_param = isset($_SESSION['search_param'])?$_SESSION['search_param']:null;
$total = 0;

for($r = 0; $r < $search_param[$tran]['no_room']; $r++) {
    if($type == 'adult') {
        $total += $search_param[$tran]['adult'][$r];
    } else if($type == 'child') {
        $total += $search_param[$tran]['child'][$r];
    } else if($type == 'infant') {
        $total += $search_param[$tran]['infant'][$r];
    }
}

$min_year = date('Y') - 100;
$depart = $search_param[$tran]['depart'];
$temp_depart = explode('-',$depart);
$year_depart = $temp_depart[2];
if($type == 'adult') {
    $max_year = $year_depart - 11;
} else if($type == 'child') {
    $min_year = $year_depart - 10;
    $max_year = date('Y') - 5;
} else if($type == 'infant') {
    $min_year = date('Y') - 4;
    $max_year = date('Y');
}


for($a = 0; $a < $total; $a++):?>
    <div class="formBox <?php echo $type?>" type_pasenger="<?php echo $type?>">
        <div class="formBox__body">
            <div class="formBox__item">
                <div class="formBox__text">
                    <?php if($type == 'adult' && $a == 0):?>
                        <p class="text24 medium blueDark"><?php echo t('Guest Info');?></p>
                    <?php endif;?>
                    <p class="text20 medium blueDark mt15"><?php echo t(ucfirst($type))?> <?php echo ($a + 1);?></p>
                </div>
                <div class="formBox__row">
                    <div class="form-group w-50">
                        <label><?php echo t('Title ');?></label>
                        <select class="form-control" name="title[<?php echo $type?>][<?php echo $a?>]">
                            <?php if($type == 'adult'):?>
                                <option value="Mr"><?php echo t('Mr');?></option>
                                <option value="Ms"><?php echo t('Ms');?></option>
                                <option value="Mrs"><?php echo t('Mrs');?></option>
                            <?php else:?>
                                <option value="Mstr "><?php echo t('Mstr');?></option>
                                <option value="Miss"><?php echo t('Miss');?></option>
                            <?php endif;?>

                        </select>
                    </div>
                    <div class="form-group w-50">
                        <label class="labelStar"><?php echo t('Full name');?></label>
                        <input type="text" placeholder="<?php echo t('Full name');?>" name="fullname[<?php echo $type?>][<?php echo $a?>]" class="form-control required">
                    </div>
                </div>
                <div class="formBox__row">
                    <div class="formBox__date">
                        <label class="labelStar"><?php echo t('Date of Birth');?></label>
                        <div class="d-flex">
                            <div class="form-group">
                                <select class="form-control day required" name="day[<?php echo $type?>][<?php echo $a?>]">
                                    <option value=""><?php echo t('Day');?></option>
                                    <?php for($i1=0; $i1<31; $i1++):
                                        $day = $i1 + 1;
                                        $day = str_pad($day,2,'0',STR_PAD_LEFT);
                                        ?>
                                        <option value="<?php echo $day;?>"><?php echo $day; ?></option>
                                    <?php endfor;?>
                                </select>
                            </div>
                            <div class="form-group">
                                <select class="form-control month required" name="month[<?php echo $type?>][<?php echo $a?>]">
                                    <option value=""><?php echo t('Month');?></option>
                                    <?php for($i1=1; $i1<=12; $i1++):
                                        $month = $i1;
                                        $month = str_pad($month,2,'0',STR_PAD_LEFT);
                                        ?>
                                        <option value="<?php echo $month;?>"><?php echo $month; ?></option>
                                    <?php endfor;?>
                                </select>
                            </div>
                            <div class="form-group">
                                <select class="form-control year required" name="year[<?php echo $type?>][<?php echo $a?>]">
                                    <option value=""><?php echo t('Year');?></option>
                                    <?php for($i = $max_year; $i >= $min_year; $i--):?>
                                        <option value="<?php echo $i;?>"><?php echo $i; ?></option>
                                    <?php endfor;?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <p class="text16 medium blueDark mb15 mt15"><?php echo t('Passport detail');?></p>
                <div class="formBox__row mb0">
                    <div class="form-group w-50">
                        <label class="labelStar"><?php echo t('Passport Number');?></label>
                        <input type="text" name="passport[<?php echo $type?>][<?php echo $a?>]" placeholder="Passport Number" class="form-control required">
                    </div>
                    <div class="form-group w-50">
                        <label class="labelStar"><?php echo t('Nationality');?> </label>
                        <select class="form-control" name="nationality[<?php echo $type?>][<?php echo $a?>]">
                            <?php if(count($nationality) > 0):?>
                                <?php foreach ($nationality as $value):?>
                                    <option value="<?php echo $value->name?>"><?php echo $value->name?></option>
                                <?php endforeach;?>
                            <?php endif;?>
                        </select>
                    </div>
                    <div class="form-group w-50">
                        <label class="labelStar"><?php echo t('Date of Issued');?></label>
                        <input type="text" readonly placeholder="Date of Issued" name="date_issued[<?php echo $type?>][<?php echo $a?>]" class="form-control general_date required">
                    </div>
                    <div class="form-group w-50">
                        <label class="labelStar"><?php echo t('Date of Expired');?></label>
                        <input type="text" readonly placeholder="Date of Expired" name="date_expired[<?php echo $type?>][<?php echo $a?>]" class="form-control general_date required">
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endfor;?>





