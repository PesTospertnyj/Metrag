<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>


    <?php
    NavBar::begin([
        'brandLabel' => Yii::t('yii', 'Metrag'),
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            //'class' => 'navbar-inverse navbar-fixed-top',
            'class' => 'navbar-inverse',

        ],

    ]);

    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => Yii::t('yii', 'Login'), 'url' => ['/site/login']];
    } else {
        $menuItems = [
        //['label' => Yii::t('yii', 'Home'), 'url' => ['/site/index']],
        [
            'label' => Yii::t('yii', 'Rents'),
            'items' => [
                ['label' => Yii::t('yii', 'Search'), 'url' => ['/rent/search']],
                ['label' => Yii::t('yii', 'Add'), 'url' => ['/rent/create']],
                ['label' => Yii::t('yii', 'List'), 'url' => ['/rent']],
            ]
        ],
        [
            'label' => Yii::t('yii', 'Apartments'),
            'items' => [
                ['label' => Yii::t('yii', 'Search'), 'url' => ['/apartment/search']],
                ['label' => Yii::t('yii', 'Add'), 'url' => ['/apartment/create']],
                ['label' => Yii::t('yii', 'List'), 'url' => ['/apartment']],
            ]
        ],
        [
            'label' => Yii::t('yii', 'Buildings'),
            'items' => [
                ['label' => Yii::t('yii', 'Search'), 'url' => ['/building/search']],
                ['label' => Yii::t('yii', 'Add'), 'url' => ['/building/create']],
                ['label' => Yii::t('yii', 'List'), 'url' => ['/building']],
            ]
        ],
        [
            'label' => Yii::t('yii', 'Houses'),
            'items' => [
                ['label' => Yii::t('yii', 'Search'), 'url' => ['/house/search']],
                ['label' => Yii::t('yii', 'Add'), 'url' => ['/house/create']],
                ['label' => Yii::t('yii', 'List'), 'url' => ['/house']],
            ]
        ],
        [
            'label' => Yii::t('yii', 'Areas'),
            'items' => [
                ['label' => Yii::t('yii', 'Search'), 'url' => ['/area/search']],
                ['label' => Yii::t('yii', 'Add'), 'url' => ['/area/create']],
                ['label' => Yii::t('yii', 'List'), 'url' => ['/area']],
            ]
        ],
        [
            'label' => Yii::t('yii', 'Commercials'),
            'items' => [
                ['label' => Yii::t('yii', 'Search'), 'url' => ['/commercial/search']],
                ['label' => Yii::t('yii', 'Add'), 'url' => ['/commercial/create']],
                ['label' => Yii::t('yii', 'List'), 'url' => ['/commercial']],
            ]
        ],
        [
            'label' => Yii::t('yii', 'Administration'),
            'items' => [
                 ['label' => Yii::t('yii', 'Create user'), 'url' => ['/admin/user/create-user']],
                 '<li class="divider"></li>',
                 '<li class="dropdown-header">Options</li>',
                 ['label' => Yii::t('yii', 'Routes'), 'url' => ['/admin/route']],
                 ['label' => Yii::t('yii', 'Permissions'), 'url' => ['/admin/permission']],
                 ['label' => Yii::t('yii', 'Roles'), 'url' => ['/admin/role']],
                 '<li class="divider"></li>',
                 ['label' => Yii::t('yii', 'Users'), 'url' => ['/admin/user']],
        ],
        ],
        [
            'label' => Yii::t('yii', 'Edit'),
            'items' => [
                ['label' => Yii::t('yii', 'Агенты'), 'url' => ['/agents']],
                ['label' => Yii::t('yii', 'Condit'), 'url' => ['/condit']],
                ['label' => Yii::t('yii', 'Course'), 'url' => ['/course']],
                ['label' => Yii::t('yii', 'Comfort'), 'url' => ['/comfort']],
                ['label' => Yii::t('yii', 'Communication'), 'url' => ['/communication']],
                ['label' => Yii::t('yii', 'Developer'), 'url' => ['/developer']],
                ['label' => Yii::t('yii', 'Gas'), 'url' => ['/gas']],
                ['label' => Yii::t('yii', 'Layout'), 'url' => ['/layout']],
                ['label' => Yii::t('yii', 'Locality'), 'url' => ['/locality']],
                ['label' => Yii::t('yii', 'ЖК'), 'url' => ['/complex']],
                ['label' => Yii::t('yii', 'Mediator'), 'url' => ['/mediator']],
                ['label' => Yii::t('yii', 'Metro'), 'url' => ['/metro']],
                ['label' => Yii::t('yii', 'Ownership'), 'url' => ['/ownership']],
                ['label' => Yii::t('yii', 'Parthouse'), 'url' => ['/parthouse']],
                ['label' => Yii::t('yii', 'Partsite'), 'url' => ['/partsite']],
                ['label' => Yii::t('yii', 'Purpose'), 'url' => ['/purpose']],
                ['label' => Yii::t('yii', 'Region'), 'url' => ['/region']],
                ['label' => Yii::t('yii', 'Region Kharkiv'), 'url' => ['/region-kharkiv']],
                ['label' => Yii::t('yii', 'Region Kharkiv Admin'), 'url' => ['/region-kharkiv-admin']],
                ['label' => Yii::t('yii', 'Sewage'), 'url' => ['/sewage']],
                ['label' => Yii::t('yii', 'Source Info'), 'url' => ['/source-info']],
                ['label' => Yii::t('yii', 'Street'), 'url' => ['/street']],
                ['label' => Yii::t('yii', 'Type Object'), 'url' => ['/type-object']],
                ['label' => Yii::t('yii', 'Wall Material'), 'url' => ['/wall-material']],
                ['label' => Yii::t('yii', 'Water'), 'url' => ['/water']],
                ['label' => Yii::t('yii', 'Wc'), 'url' => ['/wc']],
                
            ]
        ],
        
        [
            'label' => Yii::t('yii', 'Parser'),
            'items' => [
                 ['label' => Yii::t('yii', 'OLX apartments'),
                     'url' => 'http://185.69.154.197',
                     'linkOptions' => ['target' => '_blank']
                 ],
                 ['label' => Yii::t('yii', 'Parser CD'), 'url' => ['/parsercd']],

            ],
        ],
        [
            'label' => Yii::t('yii', 'XML'),
            'items' => [
                 ['label' => Yii::t('yii', 'Create XML'), 'url' => ['/xml/create']],
                 //['label' => Yii::t('yii', 'XML list'), 'url' => ['/xml']],
                 
            ],
        ],
        [
            //'icon' => '<i class=\"fa fa-user-o\"></i>',
            'label' => '<i class="fa fa-user-o" style="color: #fff"></i>'.Yii::$app->user->identity->username,
            'items' => [

            ['label' => Yii::t('yii', 'Logout'), 'url' => ['/site/logout'],'class' => 'btn btn-link logout','linkOptions' => ['data-method' => 'post']],
            '<li class="divider"></li>',
            ['label' => Yii::t('yii', 'Change Password'), 'url' => ['/admin/user/change-password']],

            ],
        ],
        ];
        /*
        $menuItems[] = '<li>'
            . Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(
                \Yii::t('yii', 'Logout') .'(' . Yii::$app->user->identity->username . ')',
                ['class' => 'btn btn-link logout']
            )
            . Html::endForm()
            . '</li>';
      */

    }
    ?>

    <?php echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
        'encodeLabels' => false,
    ]);
    NavBar::end();
    ?>
<div class="wrap">
    <div class="container-fluid" >
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; <?= Yii::t('yii', 'Metrag')?> <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
