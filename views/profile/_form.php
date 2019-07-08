<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'value' => $model_value['name'], 'maxlength' => 32]) ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => true, 'value' => $model_value['email'], 'maxlength' => 255]) ?>

    <?= $form->field($model, 'description')->textarea(['maxlength' => true, 'value' => $model_value['description'], 'maxlength' => 255]) ?>

    <?= $form->field($model, 'password')->passwordInput(['value' => ''])->label('Введите пароль, чтобы сохранить изменения') ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
