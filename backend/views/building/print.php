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
        <th>Пл</th>
        <th>Бал</th>
        <th>Ст</th>
        <th>Пн</th>
        <th>М</th>
        <th>С</th>
        <th>Прим</th>
        <th>Конт</th>
        <th>Д/об</th>
        <th>Авт</th>
        <th>Дог</th>
        <th>Ф</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($models as $building) { ?>
        <tr>
            <td><?php echo str_pad($building['id'], 5, "0", STR_PAD_LEFT); ?></td>
            <td><?php echo $building['count_room'] ?><?php echo mb_substr($building->getTypeObject()->name, 0, 2, 'UTF-8') ?></td>
            <td><?php echo mb_substr($building->getRegion()->name, 0, 5, 'UTF-8') ?></td>
            <td><?php echo mb_substr($building->getStreet()->name, 0, 8, 'UTF-8') . " " . $building['number_building'] ?></td>
            <td><?php echo (ceil($building['price']) == $building['price']) ? number_format($building['price'], 0, '', '') : number_format($building['price'], 1, '.', '') ?></td>
            <td><?php echo $building['floor'] ?>/<?php echo $building['floor_all'] ?></td>
            <td><?php echo round($building['total_area']) ?>/<?php echo round($building['floor_area']) ?>/<?php echo round($building['kitchen_area']) ?></td>
            <td><?php echo $building['count_balcony'] ?>/<?php echo $building['count_balcony_glazed'] ?></td>
            <td><?php echo mb_substr($building->getCondit()->name, 0, 3, 'UTF-8') ?></td>
            <td><?php echo mb_substr($building->getLayout()->name, 0, 3, 'UTF-8') ?></td>
            <td><?php echo mb_substr($building->getWallMaterial()->name, 0, 1, 'UTF-8') ?></td>
            <td><?php echo mb_substr($building->getWc()->name, 0, 1, 'UTF-8') ?></td>
            <td><?php echo mb_substr($building['note'], 0, 9, 'UTF-8') ?></td>
            <td>
                <?php
                $phone = $building['phone'];
                echo mb_substr($phone, 0, 22, 'UTF-8');
                ?>
            </td>
            <td><?php if((int)$building['date_modified'] !== 0) { echo date('m.y', strtotime($building['date_modified'])); } else { echo "-"; } ?></td>
            <td><?php echo mb_substr($building->getAuthor()->username, 0, 4, 'UTF-8') ?></td>
            <td><?php echo mb_substr($building->getMediator()->name, 0, 4, 'UTF-8') ?></td>
            <td><?php
                if((bool) array_filter($building->getImages())){
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