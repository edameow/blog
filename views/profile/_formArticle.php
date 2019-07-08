<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use mihaildev\ckeditor\CKEditor;

/* @var $this yii\web\View */
/* @var $model app\models\Article */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="article-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($imageModel, 'image')->fileInput() ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'content')->widget(CKEditor::className(),[
        'editorOptions' => [
            'preset' => 'standard', //разработанны стандартные настройки basic, standard, full данную возможность не обязательно использовать
            'inline' => false, //по умолчанию false
        ],
    ]);?>

    <div class="form-group">
        <label class="control-label" for="article-category">Категория</label>
        <?= Html::dropDownList('category', $model->category->id, $categories, ['class' => 'form-control', 'id' => 'article-category']) ?>
    </div>

    <div class="form-group">
        <label class="control-label" for="article-tag">Теги</label>
        <?= Html::input('text', 'tags', $tags, ['class' => 'form-control', 'id' => 'article-tag']) ?>
    </div>

    <div class="profile-article-img">
        <img src="/images/articles/<?= $model->image?>" alt="">
    </div>

    <div class="form-group" style="margin-top: 1em">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
