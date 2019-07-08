<?php
use app\components\Sidebar;
use yii\widgets\LinkPager;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
?>
<?php
$get = Yii::$app->request->get('tags');
?>
<!--main content start-->
<div class="main-content">
    <div class="container">

        <div class="search-container">
                <?php $form = ActiveForm::begin([
                    'action'  => ['site/tag'],
                    'method' => 'get',
                ]); ?>
                <?= Html::input('text', 'tags', $get, ['class' => 'form-control search-goodizer', 'autocomplete' => 'off']) ?>
                <?= Html::submitButton('Поиск', ['class' => 'btn btn-success']) ?>
                <?php ActiveForm::end(); ?>
        </div>
            <div class="row">
                <div class="col-md-8">
                    <?php if ($models) { ?>
                        <?php foreach ($models as $model) {?>
                            <article class="post post-list">
                                <div class="row">
                                    <?php if ($model['image']) { ?>
                                        <div class="col-sm-6">
                                            <div class="post-thumb">
                                                <?= Html::a(Html::img("/web/images/articles/{$model['image']}"), Url::to(['site/post', 'id' => $model['id']]), ['class' => 'pull-left'])?>
                                                <?= Html::a("<div class=\"text-uppercase text-center\">Прочитать</div>", Url::to(['site/post', 'id' => $model['id']]), ['class' => 'post-thumb-overlay text-center'])?>
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <?php if ($model['image']) { ?>
                                    <div class="col-sm-6">
                                        <?php } else { ?>
                                        <div class="col-sm-12" style="margin-left: 1em">
                                            <?php } ?>
                                            <div class="post-content">
                                                <header class="entry-header text-uppercase">
                                                    <h6>
                                                        <?= Html::a($model->category->title, Url::to(['site/category', 'id' => $model['category_id']]))?>
                                                    </h6>
                                                    <h1 class="entry-title">
                                                        <?= Html::a($model['title'], Url::to(['site/post', 'id' => $model['id']]))?>
                                                    </h1>
                                                </header>
                                                <div class="entry-content">
                                                    <p>
                                                        <?php
                                                        if (strlen($model['content']) <= 200) {
                                                            for ($i = 0; $i < strlen($model['content']); $i++) {
                                                                echo $model['content'][$i];
                                                            }
                                                        } else {
                                                            for ($i = 0; $i <= 200; $i++) {
                                                                echo $model['content'][$i];
                                                            } echo '...';
                                                        }?>
                                                    </p>
                                                </div>
                                                <div class="btn-continue-reading text-center text-uppercase">
                                                    <?= Html::a('Продолжение', Url::to(['site/post', 'id' => $model['id']]))?>
                                                </div>
                                                <div class="social-share">
                                                    <span class="social-share-title pull-left text-capitalize"><?= $model->user['name'] . ' ' . $model->date?></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            </article>
                        <?php }?>
                        <?php
                        echo LinkPager::widget([
                            'pagination' => $pages,
                        ]);
                        ?>

                    <?php } else echo "<b>По запросу \"{$get}\" ничего не найдено</b>" ?>
                </div>
                <?= Sidebar::widget()?>
            </div>
    </div>
</div>
<!-- end main content-->