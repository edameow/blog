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
<nav class="navbar main-menu navbar-default">
    <div class="container">
        <div class="menu-content">
            <div class="nav-head">
                <div class="nav text-uppercase">
                    <a class="btn-style" href="<?= Url::home()?>">Главная</a>
                </div>
                <div class="i_con">
                    <div class="nav text-uppercase">
                        <?php if (Yii::$app->user->isGuest) {?>
                            <a class="btn-style" href="<?= Url::to(['site/login'])?>">Вход</a>
                            <a class="btn-style" href="<?= Url::to(['site/signup'])?>">Регистрация</a>
                        <?php } else { ?>

                            <a class="btn-style" href="<?= Url::to(['profile/view'], '')?>"><?= Yii::$app->user->identity->name ?></a>
                            <a class="btn-style">
                                <?= Html::beginForm(['/site/logout'], 'post')
                                . Html::submitButton(
                                    'Выход',
                                    ['class' => 'btn btn-link logout']
                                )
                                . Html::endForm(); ?>
                            </a>
                        <?php }?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>
<div class="container">
    <?php if (!Yii::$app->user->isGuest) {?>
    <ul class="profile-menu">
        <li>
            <a class="btn" href="<?= Url::to(['profile/update'])?>">Редактировать профиль</a>
        </li>
        <li>
            <a class="btn" href="<?= Url::to(['profile/set-image'])?>">Сменить аватарку</a>
        </li>
        <li>
            <a class="btn" href="<?= Url::to(['profile/black-list'])?>">Чёрный список</a>
        </li>
        <?php if (!Yii::$app->user->isGuest && Yii::$app->user->identity->contentmaker) { ?>
            <li>
                <a class="btn" href="<?= Url::to(['profile/create'])?>">Написать статью</a>
            </li>
            <li>
                <a class="btn" href="<?= Url::to(['profile/draft'])?>">Черновик</a>
            </li>
        <?php }?>
    </ul>
    <?php }?>
    <?= $content?>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
