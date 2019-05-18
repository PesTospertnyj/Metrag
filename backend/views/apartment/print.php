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
            font-size: 16px;
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
    <?php foreach ($models as $apartment) { ?>
        <tr>
            <td><?php echo str_pad($apartment['id'], 5, "0", STR_PAD_LEFT); ?></td>
            <td><?php echo $apartment['count_room'] ?><?php echo mb_substr($apartment->getTypeObject()->name, 0, 2, 'UTF-8') ?></td>
            <td><?php echo mb_substr($apartment->getRegionKharkiv()->name, 0, 5, 'UTF-8') ?></td>
            <td><?php echo mb_substr($apartment->getStreet()->name, 0, 8, 'UTF-8') . " " . $apartment['number_building'] ?></td>
            <td><?php echo (ceil($apartment['price']) == $apartment['price']) ? number_format($apartment['price'], 0, '', '') : number_format($apartment['price'], 1, '.', '') ?></td>
            <td><?php echo $apartment['floor'] ?>/<?php echo $apartment['floor_all'] ?></td>
            <td><?php echo round($apartment['total_area']) ?>/<?php echo round($apartment['floor_area']) ?>/<?php echo round($apartment['kitchen_area']) ?></td>
            <td><?php echo $apartment['count_balcony'] ?>/<?php echo $apartment['count_balcony_glazed'] ?></td>
            <td><?php echo mb_substr($apartment->getCondit()->name, 0, 3, 'UTF-8') ?></td>
            <td><?php echo mb_substr($apartment->getLayout()->name, 0, 3, 'UTF-8') ?></td>
            <td><?php echo mb_substr($apartment->getWallMaterial()->name, 0, 1, 'UTF-8') ?></td>
            <td><?php echo mb_substr($apartment->getWc()->name, 0, 1, 'UTF-8') ?></td>
            <td><?php echo mb_substr($apartment['note'], 0, 9, 'UTF-8') ?></td>
            <td>
                <?php
                /*$rules = $engine->db->query("SELECT * FROM " . DB_PREF . "rules WHERE user_group='" . $_SESSION['access'] . "'");
                if ($rules->row['apartment_print']==="yes") $phone = explode(",", $apartment['phone']);
                else
                {
                    if ($apartment['author_name'])
                    {
                        $telauthor = $engine->db->query("SELECT * FROM " . DB_PREF . "users WHERE name='" . $apartment['author_name'] . "'");
                        $phone=explode(",", $telauthor->row['phone']);
                    }
                    else $phone=explode(",", "no telephone");
                }
                $phone =  $phone[0] . ((isset($phone[1])) ? ("," . $phone[1]) : "");
                */
                //$phone = explode(",", $apartment['phone']);
                //$phone =  $phone[0] . ((isset($phone[1])) ? ("," . $phone[1]) : "");
                $phone = $apartment['phone'];
                echo mb_substr($phone, 0, 22, 'UTF-8');
                ?>
            </td>
            <td><?php if((int)$apartment['date_modified'] !== 0) { echo date('m.y', strtotime($apartment['date_modified'])); } else { echo "-"; } ?></td>
            <td><?php echo mb_substr($apartment->getAuthor()->username, 0, 4, 'UTF-8') ?></td>
            <td><?php echo mb_substr($apartment->getMediator()->name, 0, 4, 'UTF-8') ?></td>
            <td><?php
                if((bool) array_filter($apartment->getImages())){
                    echo '+';
                }else{
                    echo '-';
                } ?>
            </td>
        </tr>
    <?php } ?>
    </tbody>
</table>
</body>
</html>
