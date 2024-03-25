<?php
$sever = (($_SERVER['SERVER_PROTOCOL'] == 'HTTP/1.1')?'http://':'https://').$_SERVER['SERVER_NAME'];
$flight = $data['flight'];
$baggage = $data['baggage'];
$flight = parseFlightbyJson($flight);
$check_transit = explode(' ',$flight['ANN_stop']);
if($check_transit[0] == '1'){
    $ann_stop = '1 stop';
    $color = '#E34A13';
}elseif ($check_transit[0] == '2'){
    $ann_stop = '2 stops';
    $color = '#E34A13';
}else{
    $ann_stop = 'Direct';
    $color = '#81BE33';

}

print_r($data);die;
?>

<tr>
    <td colspan="6" style="padding-bottom: 10px; border-bottom: 2px solid #e3e3e3;">
        <table style="width: 100%;">
            <thead></thead>
            <tbody>
            <tr>
                <td colspan="6" style="padding-top:15px;">
                    <p style="font-size: 16px;font-weight: 600;"><?php echo $data['type'];?></p>

                </td>
            </tr>
            <tr>
                <td colspan="6" style="padding-bottom: 20px;border-bottom: 1px dashed #e3e3e3;">
                    <table style="width: 100%;">
                        <thead>
                        <tr>
                            <td width="30%" style="padding: 10px 0; font-weight: 600; color: #a7a7a7;font-size: 14px;">Route</td>
                            <td width="20%" style="padding: 10px 0; font-weight: 600; color: #a7a7a7;font-size: 14px;">Time</td>
                            <td width="35%" style="padding: 10px 0; font-weight: 600; color: #a7a7a7;font-size: 14px;">Date</td>
                            <td style="padding: 10px 0; font-weight: 600; color: #a7a7a7;font-size: 14px;">Connection</td>
                        </tr>
                        </thead>

                        <tbody>
                        <tr>
                            <td style="font-size: 14px;"><?php echo $flight['ANN_fromCity'].' ('.$flight['ANN_from'].')';?> - <?php echo $flight['ANN_toCity'].' ('.$flight['ANN_to'].')';?></td>
                            <td style="font-size: 14px;"><?php echo $flight['ANN_timeOfDeparture'];?> - <?php echo $flight['ANN_timeOfArrival'];?></td>
                            <td style="font-size: 14px;"><?php echo $flight['ANN_departDate'];?> - <?php echo $flight['ANN_returnDate'];?></td>
                            <td style="font-size: 14px;"><?php echo $ann_stop?></td>

                        </tr>

                        </tbody>
                    </table>
                </td>
            </tr>
            <tr class="tr-block">
                <td colspan="6" style="padding-top: 20px;">
                    <table style="width: 100%;">
                        <tr>
                            <td width="30%" style="padding-bottom: 10px; color: #a7a7a7;">
                                <strong style="font-size: 14px;">Duration</strong>
                            </td>
                            <td style="padding-bottom: 10px;">
                                <p style="font-size: 14px;"><?php echo $flight['ANN_duration']; ?></p>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding-bottom: 10px; color: #a7a7a7;">
                                <strong style="font-size: 14px;">Flight Number</strong>
                            </td>
                            <td style="padding-bottom: 10px;">
                                <p style="font-size: 14px;"><?php echo implode(', ',$flight['ANN_flight_info_full']);?></p>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding-bottom: 10px; color: #a7a7a7;">
                                <strong style="font-size: 14px;">Aircraft</strong>
                            </td>
                            <td style="padding-bottom: 10px;">
                                <p style="font-size: 14px;"><?php echo implode(', ',$flight['ANN_equipmentType']);  ?></p>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding-bottom: 10px; color: #a7a7a7;">
                                <strong style="font-size: 14px;">Class</strong>
                            </td>
                            <td style="padding-bottom: 10px;">
                                <p style="font-size: 14px;"><?php
                                    $cls = $flight['ANN_cls'];
                                    $family = is_domestic($flight['ANN_from'],$flight['ANN_to'])?get_family_domestic():get_family_international();
                                    $cls_name = get_class_name_by_code($family,$cls);
                                    echo $cls_name;
                                    ?></p>
                            </td>
                        </tr>
                        <?php if($baggage != ''):?>
                            <tr>
                                <td style="padding-bottom: 10px; color: #a7a7a7;">
                                    <strong style="font-size: 14px;">Baggage Allowance</strong>
                                </td>
                                <td style="padding-bottom: 10px;">
                                    <p style="font-size: 14px;"><?php

                                        echo $baggage;
                                        ?></p>
                                </td>
                            </tr>
                        <?php endif;?>
                    </table>
                </td>
            </tr>
            </tbody>
        </table>
    </td>
</tr>