<?php
$models = $dataProvider->getModels();
?>
<html>
<head>
    <title>Print</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        td, th {
            border: 1px solid black;
            white-space: nowrap;
            overflow: hidden;
        }
    </style>
</head>
<body>
<table>
    <thead>
    <tr>
        <th>ID</th>
        <th>Тип</th>
        <th>Ран</th>
        <th>Улица</th>
        <th>Цн</th>
        <th>Эт</th>
        <th>Ст</th>
        <th>Ком</th>
        <th>Прим</th>
        <th>Конт</th>
        <th>Д/об</th>
        <th>Авт</th>
        <th>Л</th>
        <th>Т</th>
        <th>Х</th>
        <th>М</th>
        <th>К</th>
        <th>Г</th>
        <th>З</th>
        <th>С</th>
        <th>Ф</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($models as $rent) { ?>
        <tr>
            <td><?php echo str_pad($rent['id'], 5, "0", STR_PAD_LEFT); ?></td>
            <td><?php echo $rent['count_room'] ?>/<?php echo $rent['count_room_rent'] ?><?php echo mb_substr($rent->getTypeObject()->name, 0, 2, 'UTF-8') ?></td>
            <td><?php echo mb_substr($rent->getRegionKharkiv()->name, 0, 5, 'UTF-8') ?></td>
            <td><?php echo mb_substr($rent->getStreet()->name, 0, 8, 'UTF-8') . " " . $rent['number_building'] ?></td>
            <td><?php echo (ceil($rent['price']) == $rent['price']) ? number_format($rent['price'], 0, '', '') : number_format($rent['price'], 1, '.', '') ?></td>
            <td><?php echo $rent['floor'] ?>/<?php echo $rent['floor_all'] ?></td>
            <td><?php echo mb_substr($rent->getCondit()->name, 0, 3, 'UTF-8') ?></td>
            <td><?php echo mb_substr($rent->getComfort()->name, 0, 3, 'UTF-8') ?></td>
            <td><?php echo mb_substr($rent['note'], 0, 9, 'UTF-8') ?></td>
            <td>
                <?php
                $phone = $rent['phone'];
                echo mb_substr($phone, 0, 22, 'UTF-8');
                ?>
            </td>
            <td><?php if((int)$rent['date_modified'] !== 0) { echo date('m.y', strtotime($rent['date_modified'])); } else { echo "-"; } ?></td>
            <td><?php echo mb_substr($rent->getAuthor()->username, 0, 4, 'UTF-8') ?></td>
            <td><?php echo ($rent['phone_line'] ? "+" : "-") ?></td>
            <td><?php echo ($rent['tv'] ? "+" : "-") ?></td>
            <td><?php echo ($rent['refrigerator'] ? "+" : "-") ?></td>
            <td><?php echo ($rent['furniture'] ? "+" : "-") ?></td>
            <td><?php echo ($rent['conditioner'] ? "+" : "-") ?></td>
            <td><?php echo ($rent['garage'] ? "+" : "-") ?></td>
            <td><?php echo ($rent['entry'] ? "+" : "-") ?></td>
            <td><?php echo ($rent['washer'] ? "+" : "-") ?></td>
            <td><?php
                if((bool) array_filter($rent->getImages())){
                    echo '+';
                }else{
                    echo '-';
                } ?></td>
        </tr>
    <?php } ?>
    </tbody>
</table>
</body>
</html>