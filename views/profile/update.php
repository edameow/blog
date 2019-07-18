<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = 'Редактирование профиля' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view']];
$this->params['breadcrumbs'][] = 'Update';

$flash = Yii::$app->session->getFlash('error-password');
?>
<div class="container">
    <div>
        <?= $flash?>
    </div>
        <h1 class="h1-to-h3"><?= Html::encode($this->title) ?></h1>
        <?= $this->render('_form', [
            'model' => $model,
            'model_value' => $model_value,
        ]) ?>
</div>