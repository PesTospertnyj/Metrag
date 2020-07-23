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
        <th>Тип</th>
        <th>Ран</th>
        <th>Улица</th>
        <th>Цн</th>
        <th>Эт</th>
        <th>Пл</th>
        <th>Ст</th>
        <th>Ком</th>
        <th>ФС</th>
        <th>Прим</th>
        <th>Конт</th>
        <th>Д/об</th>
        <th>Авт</th>
        <th>Дог</th>
        <th>Ф</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($models as $commercial) { ?>
        <tr>
            <td><?php echo str_pad($commercial['id'], 5, "0", STR_PAD_LEFT); ?></td>
            <td><?php echo $commercial['count_room'] ?><?php echo mb_substr($commercial->getTypeObject()->name, 0, 2, 'UTF-8') ?></td>
            <td><?php echo mb_substr($commercial->getRegionKharkiv()->name, 0, 5, 'UTF-8') ?></td>
            <td><?php echo mb_substr($commercial->getStreet()->name, 0, 8, 'UTF-8') . " " . $commercial['number_office'] ?></td>
            <td><?php echo (ceil($commercial['price']) == $commercial['price']) ? number_format($commercial['price'], 0, '', '') : number_format($commercial['price'], 1, '.', '') ?></td>
            <td><?php echo $commercial['floor'] ?>/<?php echo $commercial['floor_all'] ?></td>
            <td><?php echo round($commercial['total_area']) ?>/<?php echo round($commercial['total_area_house']) ?></td>
            <td><?php echo mb_substr($commercial->getCondit()->name, 0, 3, 'UTF-8') ?></td>
            <td><?php echo mb_substr($commercial->getCommunication()->name, 0, 3, 'UTF-8') ?></td>
            <td><?php echo mb_substr($commercial->getOwnership()->name, 0, 3, 'UTF-8') ?></td>

            <td><?php echo mb_substr($commercial['note'], 0, 9, 'UTF-8') ?></td>
            <td>
                <?php
                $phone = $commercial['phone'];
                echo mb_substr($phone, 0, 22, 'UTF-8');
                ?>
            </td>
            <td><?php if((int)$commercial['date_modified'] !== 0) { echo date('m.y', strtotime($commercial['date_modified'])); } else { echo "-"; } ?></td>
            <td><?php echo mb_substr($commercial->getAuthor()->username, 0, 4, 'UTF-8') ?></td>
            <td><?php echo mb_substr($commercial->getMediator()->name, 0, 4, 'UTF-8') ?></td>
            <td><?php
                if((bool) array_filter($commercial->getImages())){
                    echo '+';
                }else{
                    echo '-';
                } ?></td>
        </tr>
    <?php } ?>
    </tbody>
</table>
<script>

    window.print();
</script>
</body>
</html>
