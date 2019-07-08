<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Контентмейкеры';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

    <ul class="list-unstyled">
        <?php foreach ($user as $item) {?>
            <li class="admin-list">
                <ul class="list-unstyled">
                    <li><b>ID <?= $item->id?></b></li>
                    <li><?= $item->name?></li>
                </ul>
                <?= Html::a('Удалить', ['delete', 'id' => $item->id, 'role' => 'contentmaker'], ['class' => 'btn btn-danger'])?>
            </li>
        <?php }?>
    </ul>

</div>
