<?php
use yii\helpers\Html;
use yii\helpers\Url;
use app\components\Sidebar;
use yii\widgets\ActiveForm;
use yii\widgets\LinkPager;
use yii\widgets\Pjax;

?>
<!--main content start-->
<div class="main-content">
    <div class="container">

        <div class="search-container">
                <?php $form = ActiveForm::begin([
                    'action'  => ['site/tag'],
                    'method' => 'get',
                ]); ?>
                <?= Html::input('text', 'tags', '', ['class' => 'form-control search-goodizer', 'autocomplete' => 'off']) ?>
                <?= Html::submitButton('Поиск', ['class' => 'btn btn-success']) ?>
                <?php ActiveForm::end(); ?>
        </div>

        <div class="row">
            <div class="col-md-8">
                <article class="post">
                    <div class="post-thumb">
                        <?= Html::img("/web/images/articles/{$model['image']}", ['class' => ''])?>
                    </div>
                    <div class="post-content">
                        <header class="entry-header text-center text-uppercase">
                            <h6>
                                <?= Html::a($model->category->title, Url::to(['site/category', 'id' => $model['category_id']]))?>
                            </h6>
                            <h1 class="entry-title">
                                <?= $model['title']?>
                            </h1>
                        </header>
                        <div class="entry-content">
                            <p>
                                <?= $model['content']?>
                            </p>
                        </div>
                        <div>
                            <?php foreach ($tags as $tag) { ?>
                                <?= Html::a($tag->tag->title, Url::to(['site/tag', 'tags' => $tag->tag->title]), ['class' => 'btn btn-default tag'])?>
                            <?php }?>
                        </div>
                        <div class="social-share">
							<span class="social-share-title pull-left text-capitalize">
                                <?= $model->user['name'] ?> <?= $model->date ?>
                            </span>
                        </div>
                    </div>
                </article>

                <!-- end bottom comment-->
                <?php if (!Yii::$app->user->isGuest) { ?>
                    <div class="leave-comment">
                        <?php $form = ActiveForm::begin([
                            'action'  => ['site/comment', 'id' => $model->id],
                            'options' => ['class' => 'form-horizontal contact-form comment-form', 'role' => 'form'],
                        ]) ?>
                        <div class="form-group">
                            <div class="col-md-12">
                                <?= $form->field($commentForm, 'comment')->textarea(['class' => 'form-control comment-text', 'placeholder' => 'Сообщение..'])?>
                            </div>
                        </div>
                        <?= Html::submitButton('Отправить', ['class' => 'btn send-btn send-comment'])?>
                        <?php ActiveForm::end() ?>
                    </div>
                <?php } else { ?>
                    <div class="leave-comment">
                        <p>Чтобы оставлять комментарии, надо авторизироваться.</p>
                    </div>
                <?php } ?>

                <?php Pjax::begin();?>
                <?php if (count($comments)) {?>
                    <div class="sort-btn">
                        <?php
                        echo LinkPager::widget([
                            'pagination' => $pages,
                        ]);

                        ?>
                        <?= Html::a('Сначала новые', ['post', 'id' => $model->id, 'sort' => 'new'], ['class' => 'btn btn-success sort-new']) ?>
                        <?= Html::a('Сначала старые', ['post', 'id' => $model->id, 'sort' => 'old'], ['class' => 'btn btn-success sort-old']) ?>
                    </div>
                    <div class="bottom-comment"><!--bottom comment-->
                        <h4><?= $countComments?> комментари<?= $commentTip?></h4>
                        <?php foreach ($comments as $comment) { ?>
                            <?php Pjax::begin(['enablePushState' => false]);?>
                            <div class="comment-img">
                                <?php  if ($model->user['image'] != null) {?>
                                    <img class="img-circle comment-avatar" src="/web/images/avatar/<?= $comment->user['image'] ?>" alt="">
                                <?php } else { ?>
                                    <img class="img-circle comment-avatar" src="/web/images/avatar/empty.png" alt="">
                                <?php }?>
                            </div>
                            <div class="comment-text">
                                <h5><?= $comment->user['name'] ?></h5>
                                <p class="comment-date">
                                    <?= $comment->date ?>
                                </p>
                                <p class="para">
                                    <?= $comment->text ?>
                                </p>
                            </div>
                            <?php if (!Yii::$app->user->isGuest) {
                                if (Yii::$app->user->identity->moderator) {?>
                                    <div class="delete-comment">
                                        <?= Html::a('Удалить комментарий', ['delete-comment', 'id' => $comment->id], ['class' => 'btn btn-primary']) ?>
                                    </div>
                                <?php }
                            } ?>
                            <?php Pjax::end()?>
                        <?php } ?>
                    </div>

                <?php }?>
                <?php Pjax::end()?>

            </div>
            <?= Sidebar::widget()?>
        </div>
    </div>
</div>
<!-- end main content-->