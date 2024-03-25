<?php //print_r($data);
$sever = (($_SERVER['SERVER_PROTOCOL'] == 'HTTP/1.1')?'http://':'https://').$_SERVER['SERVER_NAME'];
$passenger = $data['passenger'];
$nb_type = $data['nb_type'];
$type = $data['type'];

?>
<?php for($i=1; $i<=$nb_type; $i++):
    if($data['passenger']['first_middle_name_'.$type.'_'.$i] != ''){
        $character = '/';
    }else{
        $character = '';
    }
    $full_name = $data['passenger']['title_'.$type.'_'.$i].'. '.$data['passenger']['last_name_'.$type.'_'.$i].$character.$data['passenger']['first_middle_name_'.$type.'_'.$i];
    $date_of_birth = $data['passenger']['day_'.$type.'_'.$i].'/'.$data['passenger']['month_'.$type.'_'.$i].'/'.$data['passenger']['year_'.$type.'_'.$i];
    $passport = $data['passenger']['passport_'.$type.'_'.$i];
    $nationality = $data['passenger']['nationality_'.$type.'_'.$i];
    $date_of_issued = $data['passenger']['date_issued_'.$type.'_'.$i];
    $date_of_expired = $data['passenger']['date_expired_'.$type.'_'.$i];
    $flyer =  $data['passenger']['flyer_'.$type.'_'.$i];
    $card = $data['passenger']['card_number_'.$type.'_'.$i];
    $frequent_flyer = $flyer.'/'.$card;
    ?>


    <tr>
        <td style="padding-top: 20px; vertical-align: middle;font-size: 14px;"><?php echo $full_name?></td>
        <td style="padding-top: 20px; vertical-align: middle;font-size: 14px;"><?php echo $date_of_birth?></td>
        <?php if($passport != ''):?>
            <td style="padding-top: 20px; vertical-align: middle;font-size: 14px;"><?php echo $passport;?></td>
        <?php endif;?>
        <?php if($card != ''): ?>
            <td style="padding-top: 20px; vertical-align: middle;font-size: 14px;"><?php echo $frequent_flyer?></td>
        <?php endif;?>
        <?php if($nationality != ''):?>
            <td style="padding-top: 20px; vertical-align: middle;font-size: 14px;"><?php echo get_name_nationality($nationality)?></td>
        <?php endif;?>
        <?php if($date_of_expired != '' && $date_of_issued != ''): ?>
            <td style="padding-top: 20px; vertical-align: middle;font-size: 14px;"><?php echo $date_of_issued?></td>
            <td style="padding-top: 20px; vertical-align: middle;font-size: 14px;"><?php echo $date_of_expired?></td>
        <?php endif;?>
    </tr>
<?php endfor;?>


<style>
    * {
        margin: 0;
        padding: 0;
    }

    table {
        border-collapse: collapse;
    }

    @media (max-width: 767px) {
        tr.tr-block {
            display: block;
        }

        td.td-block {
            display: block;
        }
    }
</style>