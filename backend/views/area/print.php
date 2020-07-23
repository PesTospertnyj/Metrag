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
        @page { size: landscape; }
    </style>
</head>
<body>
<table>
    <thead>
    <tr>
        <th>ID</th>
        <th>Тп</th>
        <th>Ран</th>
        <th>Улица</th>
        <th>Цн</th>
        <th>ЧУ</th>
        <th>Пл</th>
        <th>Газ</th>
        <th>Вод</th>
        <th>Кан</th>
        <th>ЦН</th>
        <th>Прим</th>
        <th>Конт</th>
        <th>Д/об</th>
        <th>Авт</th>
        <th>Дог</th>
        <th>Ф</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($models as $area) { ?>
        <tr>
            <td><?php echo str_pad($area['id'], 5, "0", STR_PAD_LEFT); ?></td>
            <td><?php echo mb_substr($area->getTypeObject()->name, 0, 2, 'UTF-8') ?></td>
            <td><?php echo mb_substr($area->getRegionKharkiv()->name, 0, 5, 'UTF-8') ?></td>
            <td><?php echo mb_substr($area->getStreet()->name, 0, 8, 'UTF-8') . " " . $area['number_building'] ?></td>
            <td><?php echo (ceil($area['price']) == $area['price']) ? number_format($area['price'], 0, '', '') : number_format($area['price'], 1, '.', '') ?></td>
            <td><?php echo mb_substr($area->getPartsite()->name, 0, 4, 'UTF-8') ?></td>
            <td><?php echo round($area['total_area']) ?></td>
            <td><?php echo mb_substr($area->getGas()->name, 0, 3, 'UTF-8') ?></td>
            <td><?php echo mb_substr($area->getWater()->name, 0, 3, 'UTF-8') ?></td>
            <td><?php echo mb_substr($area->getSewage()->name, 0, 3, 'UTF-8') ?></td>
            <td><?php echo mb_substr($area->getPurpose()->name, 0, 3, 'UTF-8') ?></td>
            <td><?php echo mb_substr($area['note'], 0, 9, 'UTF-8') ?></td>
            <td>
                <?php
                $phone = $area['phone'];
                echo mb_substr($phone, 0, 22, 'UTF-8');
                ?>
            </td>
            <td><?php if((int)$area['date_modified'] !== 0) { echo date('m.y', strtotime($area['date_modified'])); } else { echo "-"; } ?></td>
            <td><?php echo mb_substr($area->getAuthor()->username, 0, 4, 'UTF-8') ?></td>
            <td><?php echo mb_substr($area->getMediator()->name, 0, 4, 'UTF-8') ?></td>
            <td><?php if((bool) array_filter($area->getImages())){
                    echo '+';
                }else{
                    echo '-';
                } ?> </td>
        </tr>
    <?php } ?>
    </tbody>
</table>
<script>

    window.print();
</script>
</body>
</html>
