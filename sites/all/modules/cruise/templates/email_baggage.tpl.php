<?php
$sever = (($_SERVER['SERVER_PROTOCOL'] == 'HTTP/1.1')?'http://':'https://').$_SERVER['SERVER_NAME'];
?>
<tr>
    <td colspan="6" style="padding-bottom: 10px; background-color: #fff;">
        <table style="width: 100%;">
            <thead>
            <tr>
                <th colspan="2"
                    style="background-color: rgba(0, 0, 0, 0.05); text-align: left; padding: 10px 15px;">
                    <p>
                        <img src="<?php echo $sever.base_path().'sites/all/themes/newtheme/' ?>images/mail/i-baggage.png" alt=""
                             style="width: 20px; vertical-align: middle;">
                        <span style="vertical-align: middle; padding-left: 5px; color:#F79320;">Baggage</span>
                    </p>
                </th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td style="padding: 15px;">
                    <p style="font-size: 16px; font-weight: 600;">Traveler 1 (Adult)</p>
                    <table style="width: 100%; margin-bottom: 15px;">
                        <tr style="border-bottom: 1px solid #eeee;">
                            <td style="text-align: left; vertical-align: top; padding: 15px 0;">
                                <strong>Hanoi (HAN) - Bangkok (BKK)</strong>
                            </td>
                            <td style="text-align: right; vertical-align: top; padding: 15px 0;">
                                <p style="font-weight: 600;">CARRY-ON BAGGAGE: INCLUDED</p>
                                <p>Carry10kg 22lbupto 45li 115lcm</p>
                                <p>
                                    <span style="vertical-align: middle;">CHECKED BAGGAGE:</span>
                                    <span style="vertical-align: middle; color: darkred; padding-left: 15px;">NOT INCLUDED</span>
                                </p>
                            </td>
                        </tr>
                        <tr style="border-bottom: 1px solid #eeee;">
                            <td style="text-align: left; vertical-align: top; padding: 15px 0;">
                                <strong>Hanoi (HAN) - Bangkok (BKK)</strong>
                            </td>
                            <td style="text-align: right; vertical-align: top; padding: 15px 0;">
                                <p style="font-weight: 600;">CARRY-ON BAGGAGE: INCLUDED</p>
                                <p>Carry10kg 22lbupto 45li 115lcm</p>
                                <p>
                                    <span style="vertical-align: middle;">CHECKED BAGGAGE:</span>
                                    <span style="vertical-align: middle; color: darkred; padding-left: 15px;">NOT INCLUDED</span>
                                </p>
                            </td>
                        </tr>
                    </table>
                    <p style="font-size: 12px; font-weight: 600;">Baggage allowance and charges are applied for the whole trip.</p>
                    <p style="font-size: 12px; color: rgba(0, 0, 0, 0.55);">Baggage allowance and fees are provided for information only.</p>
                    <p style="font-size: 12px; color: rgba(0, 0, 0, 0.55);">Additional allowance may apply depending on the traveler's individual passenger status (e.g. Saga Club membership)</p>
                </td>
            </tr>
            </tbody>
        </table>
    </td>
</tr>