<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Article */

$this->title = 'Создание статьи';
$this->params['breadcrumbs'][] = ['label' => 'Articles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">
        <h1 class="h1-to-h3"><?= Html::encode($this->title) ?></h1>
        <?= $this->render('_formCreate', [
            'model' => $model,
            'categories' => $categories,
            'imageModel' => $imageModel,
        ]) ?>
</div>
