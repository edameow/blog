<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Article */

$this->title = 'Редактирование статьи: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Articles', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="container">
    <div class="article-update">
        <h2><?= Html::encode($this->title) ?></h2>
        <h3><?= $model->category->title?></h3>
        <?= $this->render('_formArticle', [
            'model' => $model,
            'categories' => $categories,
            'tags' => $tags,
            'imageModel' => $imageModel,
        ]) ?>
    </div>
</div>