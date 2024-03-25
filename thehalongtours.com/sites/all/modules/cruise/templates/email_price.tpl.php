<?php
//print_r($data);
$trans = $data['search_param']['trans'];
$full_code = $data['full_code'];
$total = $data['search_param']['adults'] * ($data['adult']['fare'] + $data['adult']['tax'] + $data['adult']['ticketing']);
$total_adult = $data['search_param']['adults'] * ($data['adult']['fare'] + $data['adult']['tax'] + $data['adult']['ticketing']);
$total_fare_adult = $data['search_param']['adults'] * $data['adult']['fare'];
$total_other = $data['search_param']['adults'] * ( $data['adult']['tax'] + $data['adult']['ticketing']);
$fare_adult = $data['adult']['fare'];
$total_tax = $data['adult']['tax'] * $data['search_param']['adults'];
$total_service_charge = $data['adult']['ticketing'] * $data['search_param']['adults'];
if($data['search_param']['children'] > 0) {
    $total += $data['search_param']['children'] * ($data['child']['fare'] + $data['child']['tax'] + $data['child']['ticketing']);
    $total_child = $data['search_param']['children'] * ($data['child']['fare'] + $data['child']['tax'] + $data['child']['ticketing']);
    $fare_child = $data['child']['fare'];
    $total_fare_child = $data['search_param']['children'] * $data['child']['fare'];
    $total_other += $data['search_param']['children'] * ($data['child']['tax'] + $data['child']['ticketing']);
    $total_tax = $total_tax + $data['child']['tax'] * $data['search_param']['children'] ;
    $total_service_charge += $data['child']['ticketing'] * $data['search_param']['children'];
}
if($data['search_param']['infants'] > 0) {
    $total += $data['search_param']['infants'] * ($data['infant']['fare'] + $data['infant']['tax'] + $data['infant']['ticketing']);
    $total_infant = $data['search_param']['infants'] * ($data['infant']['fare'] + $data['infant']['tax'] + $data['infant']['ticketing']);
    $total_fare_infant = $data['search_param']['infants'] * $data['infant']['fare'];
    $total_other += $data['search_param']['infants'] * ($data['infant']['tax'] + $data['infant']['ticketing']);
    $fare_infant = $data['infant']['fare'];
    $total_tax = $total_tax + $data['infant']['tax'] * $data['search_param']['infants'];
    $total_service_charge += $data['infant']['ticketing'] * $data['search_param']['infants'];
}

?>

<tbody>
<tr>
    <td style="padding-bottom: 10px">
        <p style="font-size: 14px;">Adult x <?php echo $data['search_param']['adults']?></p>
    </td>
    <td style="padding-bottom: 10px;">
        <p style="font-size: 14px;">USD <?php echo format_money($total_fare_adult)?></p>
    </td>
</tr>
<?php if($data['search_param']['children'] > 0):?>
    <tr>
        <td style="padding-bottom: 10px">
            <p style="font-size: 14px;">Child x <?php echo $data['search_param']['children']?></p>
        </td>
        <td style="padding-bottom: 10px;font">
            <p style="font-size: 14px;">USD <?php echo format_money($total_fare_child)?></p>
        </td>
    </tr>
<?php endif;?>
<?php if($data['search_param']['infants'] > 0):?>
    <tr>
        <td style="padding-bottom: 10px">
            <p style="font-size: 14px;">Infant x <?php echo $data['search_param']['infants']?></p>
        </td>
        <td style="padding-bottom: 10px;">
            <p style="font-size: 14px;">USD <?php echo format_money($total_fare_infant)?></p>
        </td>
    </tr>
<?php endif;?>
<tr>
    <td style="padding-bottom: 10px;">
        <p style="font-size: 14px;">Taxes & Fees</p>
    </td>
    <td style="padding-bottom: 10px;">
        <p style="font-size: 14px;">USD <?php echo format_money($total_tax)?></p>
    </td>
</tr>
<tr>
    <td style="padding-bottom: 10px;">
        <p style="font-size: 14px;">Service Charges</p>
    </td>
    <td style="padding-bottom: 10px;">
        <p style="font-size: 14px;">USD <?php echo format_money($total_service_charge)?></p>
    </td>
</tr>
<tr>
    <td style="padding-bottom: 10px;" width="30%">
        <p style="font-size: 14px;">Total</p>
    </td>
    <td style="padding-bottom: 10px;">
        <p style="font-size: 14px; font-weight: 600; color: #be1e2d;">USD <?php
            $_SESSION[$trans]['total_price'] = str_replace(',','',$_SESSION[$trans]['total_price']);
            echo format_money($_SESSION[$trans]['total_price']);?></p>
    </td>
</tr>
</tbody>