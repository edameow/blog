<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Категории';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="category-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

    <ul class="list-unstyled">
        <?php foreach ($category as $item) {?>
            <li class="admin-list">
                <ul class="list-unstyled">
                    <li><b>ID <?= $item->id?></b></li>
                    <li><?= $item->title?></li>
                </ul>
<!--                Html::a('Удалить', ['delete', 'id' => $item->id], ['class' => 'btn btn-danger'])-->
            </li>
        <?php }?>
    </ul>


</div>
