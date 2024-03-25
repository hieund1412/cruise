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
<tr>
    <td style="border-bottom: 1px solid rgba(0, 0, 0, 0.15); padding: 10px; vertical-align: middle;">(<?php echo $data['area_code']?>) <?php echo $data['phone'] ?></td>
    <td style="border-bottom: 1px solid rgba(0, 0, 0, 0.15); padding: 10px; vertical-align: middle;"><?php echo $data['email']?></td>
</tr>