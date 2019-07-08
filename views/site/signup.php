<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Регистрация';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="site-login">
    <div class="container">
        <h1><?= Html::encode($this->title) ?></h1>

        <p>Заполните все поля</p>

        <?php $form = ActiveForm::begin([
            'id' => 'login-form',
            'layout' => 'horizontal',
            'fieldConfig' => [
                'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
                'labelOptions' => ['class' => 'col-lg-1 control-label'],
            ],
        ]); ?>

        <?= $form->field($model, 'username')->textInput(['autofocus' => true, 'maxlength' => 32, 'placeholder' => 'До 32 символов'])?>

        <?= $form->field($model, 'email')->textInput(['placeholder' => 'example@example.example', 'maxlength' => 255])?>

        <?= $form->field($model, 'password')->passwordInput(['placeholder' => '*********', 'maxlength' => 60]) ?>

        <div class="form-group">
            <div class="col-lg-offset-1 col-lg-11">
                <?= Html::submitButton('Вход', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>

