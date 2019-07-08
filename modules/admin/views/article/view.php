<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Article */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Articles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
    <div class="article-view">

        <h1><?= Html::encode($this->title) ?></h1>
        <h3><?= $model->category->title?></h3>

        <p>
            <?= Html::a('Опубликовать', ['publish', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a('Отклонить', ['reject', 'id' => $model->id], ['class' => 'btn btn-danger']) ?>
        </p>

        <div class="row">
            <div class="col-md-12">
                <?= Html::img("/web/images/articles/{$model['image']}", ['class' => 'offered-view'])?>
                <p>
                    <?= $model['content']?>
                </p>
                <?php foreach ($tags as $tag) { ?>
                    <span class="btn btn-primary"><?= $tag->tag->title?></span>
                <?php }?>
            </div>
        </div>
    </div>