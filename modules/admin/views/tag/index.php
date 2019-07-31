<?php

use yii\helpers\Html;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TagSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Теги';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tag-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <ul class="list-unstyled">
        <?php foreach ($tag as $item) {?>
            <?php Pjax::begin(['enablePushState' => false]);?>
            <li class="admin-list">
                <ul class="list-unstyled">
                    <li><b>ID <?= $item->id?></b></li>
                    <li><?= $item->title?></li>
                </ul>
                <?= Html::a('Удалить', ['delete', 'id' => $item->id], ['class' => 'btn btn-danger'])?>
            </li>
            <?php Pjax::end()?>
        <?php }?>
    </ul>


</div>