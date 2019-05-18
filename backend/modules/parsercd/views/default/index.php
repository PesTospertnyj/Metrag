<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use backend\models\RegionKharkiv;
use backend\models\Street;
use backend\models\Metro;

?>
<?php echo $this->render('_excel-input', ['model' => $model]); ?>

<div class="main-content" style="width: 100%;">

    <?php Pjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'rowOptions' => function ($model) {
            // В зависимости от статуса изменяем его div
            return [
                'class' => 'status-' . $model->status
            ];
        },
        'tableOptions' => [
            'class' => 'table-bordered',
            'style' => 'font-size: 13px;'
        ],
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],
            [
                'class' => 'yii\grid\ActionColumn',
                'visibleButtons' => ['view' => false,],
                'controller' => 'parsercd',
                'buttons' =>
                    [
                        'update' => function ($url, $model, $key) {
                            return '<a href="'.Url::base(true).'/apartment/add-from-parsercd?id='.$key.'" title="Добавить" class="btn btn-success" style="color: #000" aria-label="Добавить" data-pjax="0" ><span class="glyphicon glyphicon-pencil"></span></a>';
                        },
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
                            return '<a href="/admin/parsercd/parsercd/delete?id='.$key.'&page='.$page.'" title="Удалить" aria-label="Удалить" data-pjax="0" data-confirm="Вы уверены, что хотите удалить этот элемент?" data-method="post" class="btn btn-danger" style="color: #000" aria-label="Добавить" data-pjax="0" ><span class="glyphicon glyphicon-trash"></span></a>';

                        },

                    ],
            ],
            'id',
            /*
            [
                'format' => 'html',
                'attribute' => 'region_kharkiv_id',
                'value' =>  function ($dataProvider) {
                    $region = RegionKharkiv::findOne($dataProvider->region_kharkiv_id)->name;
                    $str = str_replace(' ', '<br>', $region);
                    return $str;
                },
                'contentOptions' => ['style' => 'max-width: 70px; overflow: hidden' ],
            ],
            [
                'format' => 'html',
                'attribute' => 'street_id',
                'value' =>  function ($dataProvider) {
                    $street = Street::findOne($dataProvider->street_id)->name;
                    $str = str_replace(' ', '<br>', $street);
                    return $str;
                },
                'contentOptions' => ['style' => 'max-width: 70px; overflow: hidden' ],
            ],
            [
                'format' => 'html',
                'attribute' => 'metro_id',
                'value' =>  function ($dataProvider) {
                    $metro = Metro::findOne($dataProvider->metro_id)->name;
                    $str = str_replace(' ', '<br>', $metro);
                    return $str;
                },
                'contentOptions' => ['style' => 'max-width: 70px; overflow: hidden' ],
            ],*/
            //'region_kharkiv_id',
            //'street_id',
            //'metro_id',
            //'link1:ntext',
            /*[
                'format' => 'html',
                'attribute' => 'link1',
                'value' =>  function ($dataProvider) {
                    $str = '';
                    if($dataProvider->link1 != ''){
                        $str = '<a href="'.$dataProvider->link1.'" target="_blank">'.Yii::t('app', 'Link').'</a>';
                    }
                    return $str;
                }
            ],
            [
                'format' => 'html',
                'attribute' => 'link2',
                'value' =>  function ($dataProvider) {
                    $str = '';
                    if($dataProvider->link2 != ''){
                        $str = '<a href="'.$dataProvider->link2.'" target="_blank">'.Yii::t('app', 'Link').'</a>';
                    }
                    return $str;
                }
            ],*/
            [
                'format' => 'raw',
                'attribute' => Yii::t('app', 'Link'),
                //'attribute' => 'Ссылка',
                'value' =>  function ($dataProvider) {
                    $str = '';
                    if($dataProvider->link1 != ''){
                        $str .= '<a href="'.$dataProvider->link1.'" target="_blank">'.$dataProvider->link1.'</a> <br>';
                    }
                    if($dataProvider->link2 != ''){
                        $str .= '<a href="'.$dataProvider->link2.'" target="_blank">'.$dataProvider->link2.'</a>';
                    }
                    return $str;
                },
                'contentOptions' => ['style' => 'max-width: 170px; overflow: hidden' ],
            ],
            //'link2:ntext',
            'date',
            // 'type_object_id',
            'count_room',
            [
                'attribute' => 'floor',
                'value' =>  function ($dataProvider) {
                    return $dataProvider->floor;
                },
                'contentOptions' => ['style' => 'max-width: 30px; overflow: hidden' ],
            ],
            [
                'format' => 'html',
                'attribute' => 'floor_all',
                'label' => 'Этаж-ть',
                'value' =>  function ($dataProvider) {
                    return $dataProvider->floor_all;
                },
                'contentOptions' => ['style' => 'max-width: 30px; overflow: hidden' ],
            ],
            [
                'attribute' => 'total_area',
                'label' => 'Общая пл',
                'value' =>  function ($dataProvider) {
                    return $dataProvider->total_area;
                },
                'contentOptions' => ['style' => 'max-width: 30px; overflow: hidden' ],
            ],
            [
                'attribute' => 'floor_area',
                'label' => 'Жилая пл',
                'value' =>  function ($dataProvider) {
                    return $dataProvider->floor_area;
                },
                'contentOptions' => ['style' => 'max-width: 30px; overflow: hidden' ],
            ],
            [
                'attribute' => 'kitchen_area',
                'label' => 'Кухни пл',
                'value' =>  function ($dataProvider) {
                    return $dataProvider->kitchen_area;
                },
                'contentOptions' => ['style' => 'max-width: 30px; overflow: hidden' ],
            ],
            'price',
            [
                'format' => 'html',
                'attribute' => 'phone',
                'value' =>  function ($dataProvider) {
                    $str = str_replace(',', '<br>', $dataProvider->phone);
                    return $str;
                }
            ],
            //'count_room',
            //'floor',
            //'floor_all',
            //'total_area',
            //'floor_area',
            // 'kitchen_area',

            // 'phone:ntext',
            // 'status:ntext',
            // 'note:ntext',
            // 'kolfoto',
            // 'image:ntext',
            // 'view',
            [
                'label' => 'Статус',
                'format' => 'raw',
                'value' => function ($data) {
                    $data->status = (int)$data->status;

                    $status = [];
                    if ($data->status >= 2) {
                        $status[] = 'Совпал номер телефона<br>';
                    }
                    if ($data->status >= 3) {
                        $status[] = 'Совпало количество комнат<br>';
                    }
                    if ($data->status >= 4) {
                        $status[] = 'Совпала этажность дома<br>';
                    }
                    if ($data->status >= 5) {
                        $status[] = 'Совпал этаж<br>';
                    }

                    if (!empty($status)) {
                        $text = implode('', $status);

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
                            'href' => Url::base(true).'/parsercd/compare/similar/?id=' . $data->id
                        ]);
                    } else {
                        return '-';
                    }
                }
            ]
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
