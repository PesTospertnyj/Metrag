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
    <style type="text/css" media="print">
        /*@page { size: landscape; }*/
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
        <th>Ст</th>
        <th>М</th>
        <th>К</th>
        <th>В</th>
        <th>Г</th>
        <th>Прим</th>
        <th>Конт</th>
        <th>Д/об</th>
        <th>Дог</th>
        <th>Ф</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($models as $house) { ?>
        <tr>
            <td><?php echo str_pad($house['id'], 5, "0", STR_PAD_LEFT); ?></td>
            <td><?php echo $house['count_room'] ?><?php echo mb_substr($house->getTypeObject()->name, 0, 2, 'UTF-8') ?></td>
            <td><?php echo mb_substr($house->getRegionKharkiv()->name, 0, 5, 'UTF-8') ?></td>
            <td><?php echo$house->street . ", " . $house['number_building'] ?></td>
            <td><?php echo (ceil($house['price']) == $house['price']) ? number_format($house['price'], 0, '', '') : number_format($house['price'], 1, '.', '') ?></td>
            <td><?php echo $house['floor_all'] ?></td>
            <td><?php echo round($house['total_area_house']) ?>/<?php echo round($house['total_area']) ?></td>
            <td><?php echo mb_substr($house->getCondit()->name, 0, 3, 'UTF-8') ?></td>
            <td><?php echo mb_substr($house->getWallMaterial()->name, 0, 1, 'UTF-8') ?></td>
            <td><?php echo mb_substr($house->getSewage()->name, 0, 1, 'UTF-8') ?></td>
            <td><?php echo mb_substr($house->getWater()->name, 0, 1, 'UTF-8') ?></td>
            <td><?php echo mb_substr($house->getGas()->name, 0, 1, 'UTF-8') ?></td>
            <td><?php echo mb_substr($house['note'], 0, 9, 'UTF-8') ?></td>
            <td>
                <?php
                $phone = $house['phone'];
                echo mb_substr($phone, 0, 22, 'UTF-8');
                ?>
            </td>
            <td><?php if((int)$house['date_modified'] !== 0) { echo date('m.y', strtotime($house['date_modified'])); } else { echo "-"; } ?></td>
            <td><?php echo mb_substr($house->getMediator()->name, 0, 4, 'UTF-8') ?></td>
            <td><?php if((bool) array_filter($house->getImages())){
                    echo '+';
                }else{
                    echo '-';
                } ?> ?></td>
        </tr>
    <?php } ?>
    </tbody>
</table>
<script>

    window.print();
</script>
</body>
</html>
