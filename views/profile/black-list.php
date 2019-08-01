<?php
use yii\helpers\Html;
use yii\widgets\Pjax;

?>
<div class="container">
    <ul class="list-unstyled">
        <li><b>Теги</b></li>
        <ul class="list-unstyled">
            <?php foreach ($bl_tags as $bl_tag) {?>
                <?php Pjax::begin(['enablePushState' => false]);?>
                <li class="admin-list">
                    <span><?= $bl_tag->blackListTag->title ?></span>
                    <span><?= Html::a('Удалить', ['unban-tag', 'id' => $bl_tag->id], ['class' => 'btn btn-danger'])?></span>
                </li>
                <?php Pjax::end()?>
            <?php }?>
        </ul>
    </ul>
    <ul class="list-unstyled">
        <li><b>Пользователи</b></li>
        <ul class="list-unstyled">
            <?php foreach ($bl_users as $bl_user) {?>
                <?php Pjax::begin(['enablePushState' => false]);?>
                <li class="admin-list">
                    <span><?= $bl_user->blackListUser->name ?></span>
                    <span><?= Html::a('Удалить', ['unban-user', 'id' => $bl_user->id], ['class' => 'btn btn-danger'])?></span>
                </li>
                <?php Pjax::end()?>
            <?php }?>
        </ul>
    </ul>
</div>