<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
/**
 *
 * Column    Type    Comment
 * id    int(11) Auto Increment
 * advert_id    int(11)
 * link    text
 * path    text
 * date    varchar(255)
 * type_object_id    int(11)
 * advert_from    varchar(255)
 * type    varchar(255)
 * type_flat    varchar(255)
 * count_room    int(11)
 * floor    int(11)
 * floor_all    int(11)
 * total_area    int(11)
 * floor_area    int(11)
 * kitchen_area    int(11)
 * price    varchar(255)
 * phone    text
 * status    text
 * note    text
 * kolfoto    int(11)
 * image    text
 * view    enum('neprov','no','yes','tel')
 */

?>

<div class="olx-table-result">

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,

        // table-striped использовать не нужно, он перекрывает цвет статуса
        'tableOptions' => [
            'class' => 'table table-bordered'
        ],

        'layout' => "{summary}\n{pager}\n{items}\n{pager}",

        'rowOptions' => function ($model) {
            // В зависимости от статуса изменяем его div
            return [
                'class' => 'status-' . $model->status
            ];
        },

        'columns' => [
            [
                'class' => 'yii\grid\ActionColumn',
                'visibleButtons' => ['view' => false,],
                'buttons' =>
                    [
                        'update' => function ($url, $model, $key) {
                           return '<a href="'.Url::base(true).'/apartment/add-from-parser?id='.$key.'" title="Добавить" class="btn btn-success" style="color: #000" aria-label="Добавить" data-pjax="0" ><span class="glyphicon glyphicon-pencil"></span></a>';
                    },
                    /*    'delete' => function ($url, $model, $key) {
                        return '<a href="'.Url::base(true).'/olxparser/parser/delete?id='.$key.'" title="Удалить" class="btn btn-danger" style="color: #000" aria-label="Удалить" data-pjax="0" data-confirm="Вы уверены, что хотите удалить этот элемент?" data-method="post"><span class="glyphicon glyphicon-trash"></span></a>';
                    },*/
                        'delete' => function ($url, $model, $key) {
                            $pattern = '/page=(\d*)/';
                            $url = Url::current();
                            if(preg_match($pattern, $url, $matches))
                            {
                                $page = $matches[1];
                            }
                            else
                            {
                                $page = '1';
                            }
                            return '<a href="'.Url::base(true).'/olxparser/parser/delete?id='.$key.'&page='.$page.'" title="Удалить" aria-label="Удалить" data-pjax="0" data-confirm="Вы уверены, что хотите удалить этот элемент?" data-method="post" class="btn btn-danger" style="color: #000" aria-label="Добавить" data-pjax="0" ><span class="glyphicon glyphicon-trash"></span></a>';

                        },
                        /*'view' => function ($url, $model, $key) {
                            return '';
                            },*/
                    ]
            ],
            'advert_id',
            [
                'label' => 'Ссылка',
                'format' => 'raw',
                'value' => function ($data) {
                    return $data->path;
                },
            ],
            'date',
            'advert_from',
            'type',
            'type_flat',
            'count_room',
            'floor',
            'floor_all',
            'total_area',
            'floor_area',
            'kitchen_area',
            'price',
            'phone',
            /*[
                'label' => 'Описание',
                'format' => 'raw',
                'value' => function ($data) {
                    return Html::tag('div', $data->note, ['class' => 'tooltipTd']);
                },
            ],*/
            'kolfoto',
            /*[
                'label' => 'Ссылки на фото',
                'format' => 'raw',
                'value' => function ($data) {
                    $images = unserialize($data->image);
                    if (count($images)) {

                        $links = [];
                        foreach ($images as $n => $link) {
                            // with number
                            //$links[] = Html::tag('a', ++$n, ['href' => $link, 'target' => '_blank']);

                            // without number
                            //$links[] = Html::tag('a', $link, ['href' => $link]);
                        }
                        $images_links = implode(' ', $links);

                        //return Html::tag('div', $images_links, ['class' => 'tooltipTd']);
                        return $images_links;
                    } else {
                        //return Html::tag('div', 'нет фото', ['class' => 'tooltipTd']);
                        return 'Нет фото';
                    }
                },
            ],*/
            [
                'label' => 'Статус',
                'format' => 'raw',
                'value' => function ($data) {
                    $data->status = (int)$data->status;

                    $status = [];
                    if ($data->status >= 2) {
                        $status[] = 'Совпал номер телефона';
                    }
                    if ($data->status >= 3) {
                        $status[] = 'Совпало количество комнат';
                    }
                    if ($data->status >= 4) {
                        $status[] = 'Совпала этажность дома';
                    }
                    if ($data->status >= 5) {
                        $status[] = 'Совпал этаж';
                    }

                    if (!empty($status)) {
                        $text = implode(', ', $status);

                        return Html::tag('div', $text, ['class' => 'tooltipTd']);
                    } else {
                        return '-';
                    }
                }
            ],
            [
                'label' => 'Похожие',
                'format' => 'raw',
                'value' => function ($data) {
                    if ($data->count_similar_advs) {
                        $text = "похожие ({$data->count_similar_advs} об.)";

                        return Html::tag('a', $text, [
                            'target' => '_blank',
                            'href' => Url::base(true).'/olxparser/compare/similar/?id=' . $data->id
                        ]);
                    } else {
                        return '-';
                    }
                }
            ]
        ],
    ]); ?>

</div>