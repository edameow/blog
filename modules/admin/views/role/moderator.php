<?php

use yii\helpers\Html;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Модераторы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">
    <h1><?= Html::encode($this->title) ?></h1>

        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>

        <ul class="list-unstyled">
            <?php foreach ($user as $item) {?>
                <?php Pjax::begin(['enablePushState' => false]);?>
                <li class="admin-list">
                    <ul class="list-unstyled">
                        <li><b>ID <?= $item->id?></b></li>
                        <li><?= $item->name?></li>
                    </ul>
                    <?= Html::a('Удалить', ['delete', 'id' => $item->id, 'role' => 'moderator'], ['class' => 'btn btn-danger'])?>
                </li>
                <?php Pjax::end();?>
            <?php }?>
        </ul>

</div>