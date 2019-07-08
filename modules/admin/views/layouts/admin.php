<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\assets\PublicAsset;
use yii\helpers\Html;
use yii\helpers\Url;

PublicAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="container">
    <div class="menu-content">
        <div class="nav-head">
            <div class="nav text-uppercase">
                <a class="btn-style" href="<?= Url::home()?>">Главная</a>
            </div>
            <div class="i_con">
                <div class="nav text-uppercase">
                        <a class="btn-style" href="<?= Url::to(['/profile/view'], '')?>"><?= Yii::$app->user->identity->name ?></a>
                        <a class="btn-style">
                            <?= Html::beginForm(['/site/logout'], 'post')
                            . Html::submitButton(
                                'Выход',
                                ['class' => 'btn btn-link logout']
                            )
                            . Html::endForm(); ?>
                        </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="wrap">
    <div class="container">
        <ul class="list-unstyled">
            <li>
                Статьи
                <ul class="list-unstyled">
                    <li>
                        <?= Html::a('Предложенные статьи', Url::to(['article/index']))?>
                    </li>
                </ul>
            </li>
            <li>
                Категории
                <ul class="list-unstyled">
                    <li>
                        <?= Html::a('Редактирование категорий', Url::to(['category/index']))?>
                    </li>
                </ul>
            </li>
            <li>
                Теги
                <ul class="list-unstyled">
                    <li>
                        <?= Html::a('Редактирование тегов', Url::to(['tag/index']))?>
                    </li>
                </ul>
            </li>
            <li>
                Роли
                <ul class="list-unstyled">
                    <li>
                        <?= Html::a('Редактирование модераторов', Url::to(['role/moderator']))?>
                    </li>
                    <li>
                        <?= Html::a('Редактирование администраторов', Url::to(['role/admin']))?>
                    </li>
                    <li>
                        <?= Html::a('Редактирование контентмейкеров', Url::to(['role/contentmaker']))?>
                    </li>
                </ul>
            </li>
        </ul>
        <?= $content ?>
    </div>
</div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
